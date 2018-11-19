<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe para manipulação do webservice
 *
 * @package Controller
 * @subpackage WS
 * @access public
 **/
class Webservice extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Atendentes_model', 'atendentes');
        $this->load->model('Blocos_model', 'blocos');
        $this->load->model('Chatbots_model', 'chatbots');
        $this->load->model('Leads_model', 'leads');
        $this->load->model('Respostas_model', 'respostas');
        $this->load->model('Conversas_model', 'conversas');
    }

    /**
     * Método para manipulação do diálogo entre o front e o back-end
     * @return void
     **/
    public function index($hash = NULL)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
        header('P3P: CP="CAO PSA OUR"'); // Makes IE to support cookies
        header("Content-Type: application/json; charset=utf-8");

        $request_body = file_get_contents('php://input');

        $this->logChat($request_body);

        $dados_request = json_decode($request_body);
        $chat = $this->chatbots->get_by_field('hash', $hash, 1);
        if (isset($dados_request->nome_atendente)) {
            $atendente = $this->atendentes->get_by_fields(['nome' => $dados_request->nome_atendente, 'chatbotID' => $chat->chatbotID], 1)[0];
        }
        if (isset($dados_request->leadID)) {
            $leadID = $dados_request->leadID;
            $conversa_aberta = $this->conversas->get_by_fields(['leadID' => $leadID, 'integrado' => 0]);
            if ($conversa_aberta) {
                $conversa = $conversa_aberta[0]->conversaID;
            } else {
                $conversa = $this->conversas->insert(['leadID' => $leadID, 'atendenteID' => $atendente->atendenteID, 'hashID' => $hash]);
            }
            if (!isset($atendente)) {
                $conversa_full = $this->conversas->get_by_id($conversa);
                $atendente = $this->atendentes->get_by_id($conversa_full->atendenteID);
            }
        }
        if (isset($dados_request->tipo_bloco)) {
            $tipo_bloco = (int) $dados_request->tipo_bloco;
        }
        if (isset($dados_request->proximo_bloco)) {
            $proximo_bloco = $dados_request->proximo_bloco;
        }
        if (isset($dados_request->dispositivo)) {
            $dispositivo = $dados_request->dispositivo;
        }
        if (isset($dados_request->dispositivo) && isset($leadID)) {
            $attributes['dispositivo'] = $dados_request->dispositivo;
            $update = $this->leads->update($leadID, $attributes);
        }


        if (isset($tipo_bloco)) {

            switch ($tipo_bloco) {
                case ($tipo_bloco === '0'):

                    $attributes['nome']  = $dados_request->nome;
                    $attributes['email'] = $dados_request->email;
                    $update = $this->leads->update($leadID, $attributes);
                    // Substituir variáveis no texto
                    $conteudo->texto = str_replace('{nome_atendente}', $atendente->nome, $conteudo->texto);

                    if ($update) {
                        $proxima = $this->blocos->buscar_inicial($hash);
                        $conteudo = json_decode($proxima->bloco_conteudo);

                        if ($proxima->tipoID == 1) {
                            $mensagem = [
                                "blocoID"       => (int) $proxima->blocoID,
                                "tipo_bloco"    => 1,
                                "texto"         => $conteudo->texto,
                                "proximo_bloco" => (int) $conteudo->proximo_bloco
                            ];
                        }
                        // echo 'Inicial' . PHP_EOL;
                        // echo json_encode($mensagem);
                    }
                    return FALSE;

                    break;
                case 1:
                case 2:
                case 3:
                    if (isset($dados_request->resposta)) {
                        $resposta = $dados_request->resposta;
                    } else {
                        $resposta = NULL;
                    }
                    if (isset($dados_request->blocoID)) {
                        $blocoID  = $dados_request->blocoID;
                        $enviada  = $this->blocos->get_by_id($blocoID);
                        $conteudo_enviado = json_decode($enviada->bloco_conteudo);
                        if (isset($conteudo_enviado->identificador) && $conteudo_enviado->identificador == 'nome') {
                            $attributes['nome']  = $dados_request->resposta;
                            $update = $this->leads->update($leadID, $attributes);
                        }
                        if (isset($conteudo_enviado->identificador) && $conteudo_enviado->identificador == 'email') {
                            $attributes['email'] = $dados_request->resposta;
                            $update = $this->leads->update($leadID, $attributes);
                        }
                        if (isset($conteudo_enviado->identificador) && $conteudo_enviado->identificador == 'telefone') {
                            $attributes['fone'] = $dados_request->resposta;
                            $update = $this->leads->update($leadID, $attributes);
                        }
                    }

                    $attributes = [
                        'texto'      => $resposta,
                        'leadID'     => $leadID,
                        'blocoID'    => $blocoID,
                        'hashID'     => $hash,
                        'date'       => date('Y-m-d H:i:s'),
                        'conversaID' => $conversa
                    ];

                    $resposta_salva = $this->respostas->insert($attributes);

                    $proxima = $this->blocos->get_by_id($proximo_bloco);
                    $conteudo = json_decode($proxima->bloco_conteudo);
                    // Substituir variáveis no texto
                    $conteudo->texto = str_replace('{nome_atendente}', $atendente->nome, $conteudo->texto);
                    if ($proxima->tipoID == 1 || $proxima->tipoID == 2) {
                        $mensagem = [
                            "blocoID"       => (int) $proxima->blocoID,
                            "tipo_bloco"    => (int) $proxima->tipoID,
                            "texto"         => $conteudo->texto,
                            "proximo_bloco" => (int) $conteudo->proximo_bloco
                        ];
                        // echo 'Tipo 1 ou 2' . PHP_EOL;
                        // echo json_encode($mensagem);
                    } else if ($proxima->tipoID == 3) {
                        $mensagem = [
                            "blocoID"       => (int) $proxima->blocoID,
                            "tipo_bloco"    => (int) $proxima->tipoID,
                            "texto"         => $conteudo->texto,
                            "respostas"     => $conteudo->respostas
                        ];
                        // echo 'Tipo 3' . PHP_EOL;
                        // echo json_encode($mensagem);
                    } else if ($proxima->tipoID == 5) {
                        $marcas[0] = new stdClass();
                        $marcas[0]->marcaID = $chat->marcaVeiculos;

                        $veiculos = $this->buscar_veiculos($marcas);

                        foreach ($veiculos as $veiculo) {
                            $respostas[] = [
                                'proximo_bloco' => (int) $conteudo->proximo_bloco,
                                'texto'         => $veiculo['MODELO']
                            ];
                        }
                        $mensagem = [
                            "blocoID"       => (int) $proxima->blocoID,
                            "tipo_bloco"    => (int) 3,
                            "texto"         => $conteudo->texto,
                            "respostas"     => $respostas
                        ];
                        // echo 'Tipo 5' . PHP_EOL;
                        // echo json_encode($mensagem);
                    } else if ($proxima->tipoID == 4) {


                        $empresas = $this->buscar_empresas($chat->clienteID);
                        foreach ($empresas as $empresa) {
                            $respostas[] = [
                                'proximo_bloco' => (int) $conteudo->proximo_bloco,
                                'texto'         => $empresa['NOME']
                            ];
                        }
                        $mensagem = [
                            "blocoID"       => (int) $proxima->blocoID,
                            "tipo_bloco"    => (int) 3,
                            "texto"         => $conteudo->texto,
                            "respostas"     => $respostas
                        ];
                        // echo 'Tipo 4' . PHP_EOL;
                        // echo json_encode($mensagem);
                    }
                    if (isset($conteudo->identificador)) {
                        $mensagem['identificador'] = $conteudo->identificador;
                    }
                    // echo json_encode($mensagem);
                    break;
                default:
                    echo "Erro...";
                    break;
            }
            echo json_encode($mensagem);
        } else {

            $proxima = $this->blocos->buscar_inicial($hash);
            $conteudo = json_decode($proxima->bloco_conteudo);
            if (isset($atendente)) {
                // Substituir variáveis no texto
                $conteudo->texto = str_replace('{nome_atendente}', $atendente->nome, $conteudo->texto);
            }
            if ($proxima->tipoID == 1) {
                $mensagem = [
                    "blocoID"       => (int) $proxima->blocoID,
                    "tipo_bloco"    => 1,
                    "texto"         => $conteudo->texto,
                    "proximo_bloco" => (int) $conteudo->proximo_bloco
                ];
            }
            // echo 'Inicial' . PHP_EOL;
            echo json_encode($mensagem);
            // dd($this->db->last_query());
        }
    }

    /**
     * Método para carregamento do script do chat
     * @return void
     **/
    public function load($hash = NULL)
    {
        $chatbot    = $this->chatbots->get_by_field('hash', $hash, 1);
        $atendentes = $this->atendentes->get_by_field('chatbotID', $chatbot->chatbotID);
        $lead       = $this->leads->insert(['clienteID' => $chatbot->clienteID, 'date' => date('Y-m-d H:i:s')]);
        shuffle($atendentes);
        $atendente  = $atendentes[0];

        echo "var lf_chatbot_token = '" . $chatbot->hash . "'" . PHP_EOL;
        echo "var lf_chatbot_leadID = '" . $lead . "'" . PHP_EOL;
        echo "var lf_formulario = '" . $chatbot->formulario . "'" . PHP_EOL;
        if ($chatbot->formulario == 1) {
            echo "var lf_chamada_form = '" . $chatbot->chamadaPrincipal . "'" . PHP_EOL;
        }
        echo "var lf_chatbot_atendente_avatar = '" . base_url() . 'assets/chat-' . $chatbot->hash . '/' . $atendente->avatar . "'" . PHP_EOL;
        echo "var lf_chatbot_atendente_nome = '" . $atendente->nome . "'" . PHP_EOL;
        echo "var lf_chatbot_atendente_cargo = '" . $atendente->funcao . "'" . PHP_EOL;

        echo "var lf_chatbot_start = " . (int) $chatbot->start . PHP_EOL;

        echo file_get_contents(base_url('assets/template/default.js?' . date('is')));
    }

    /**
     * Método para envio do Lead para o MKT
     *
     * @return void
     **/
    public function finaliza_chat($leadID = NULL) {
        $dados_do_lead = $this->leads->get_by_id($leadID);
        $conversa      = $this->conversas->get_by_fields(['leadID' => $leadID, 'integrado' => 0]);
        if ($conversa) {

            $respostas = $this->respostas->get_by_fields(['leadID' => $leadID, 'conversaID' => $conversa[0]->conversaID]);

            if ($respostas) {
                $chatbot = $this->chatbots->get_by_field('hash', $respostas[0]->hashID, 1);
                $blocos = $this->blocos->get_by_field('dialogoID', $chatbot->dialogoID);
                $contador_de_respostas = 0;
                foreach ($respostas as $resposta) {
                    if (isset($resposta->texto)) {
                        $resposta_cadastrada = $resposta->texto;
                    } else {
                        $resposta_cadastrada = '';
                    }

                    $resposta_cadastrada_data = $resposta->date;
                    $loja_setada = FALSE;
                    foreach ($blocos as $bloco) {

                        if ($bloco->blocoID == $resposta->blocoID) {
                            $conteudo = json_decode($bloco->bloco_conteudo);

                            $pergunta_cadastrada = $conteudo->texto;
                            if (isset($conteudo->identificador)) {
                                $identificador = $conteudo->identificador;
                                if ($conteudo->identificador == 'unidade') {
                                    $loja_setada = $resposta_cadastrada;
                                }
                                if ($conteudo->identificador == 'telefone') {
                                    $telefone_cadastrado = $resposta_cadastrada;
                                }
                            } else {
                                $identificador = '';
                            }

                            $respostas_para_envio[] = [
                                'pergunta'   => $pergunta_cadastrada,
                                'resposta'   => $resposta_cadastrada,
                                'date'       => $resposta_cadastrada_data,
                                'identifier' => $identificador
                            ];
                        }
                    $contador_de_respostas++;
                    }
                }
                if ($loja_setada == FALSE) {
                    $loja_setada = $chatbot->unidade;
                    $respostas_para_envio[$contador_de_respostas] = [
                                'pergunta'   => 'Loja:',
                                'resposta'   => $loja_setada,
                                'date'       => date('Y-m-d H:i:s'),
                                'identifier' => 'unidade'
                            ];
                }
                $data_string = [
                    "chat"        => json_encode($respostas_para_envio),
                    "email"       => (isset($dados_do_lead->email)) ? $dados_do_lead->email : '',
                    "name"        => (isset($dados_do_lead->nome)) ? $dados_do_lead->nome : '',
                    "dispositivo" => $dados_do_lead->dispositivo,
                    "token"       => $chatbot->token
                ];
                if (isset($telefone_cadastrado) || isset($dados_do_lead->email)) {
                    $url_api = 'http://rel.leadforce.com.br/ws/chat_robo';
                    $post = $data_string;
                    $ch = curl_init($url_api);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $retorno = json_decode($result);
                    if ($retorno->codigo == 0) {
                        $this->leads->update($leadID, ['integrado' => 1]);
                        $this->conversas->update($conversa[0]->conversaID, ['integrado' => 1]);
                    }
                    echo $result;
                } else {
                    echo 'Erro';
                }
            }
        }
    }

    /**
     * Método executado pela CRON para enviar leads não finalizados ao MKT
     * @return void
     **/
    public function finalizar_leads()
    {
        $leads_total = $this->leads->get_by_field('integrado', 0);
        if ($leads_total) {
            foreach ($leads_total as $lead) {
                $data_do_lead = explode(' ', $lead->date)[0];
                $historico = new DateTime();
                $historico->modify("-8 day");
                $data_historico = $historico->format('Y-m-d');
                $conversa = $this->conversas->get_by_fields(['leadID' => $lead->leadID, 'integrado' => 0])[0];
                if (($lead->email == '' && $lead->fone == '') || ($conversa->integrado == 1 && $data_do_lead <= $data_historico)) {
                    $deletar_lead[] = $this->leads->delete($lead->leadID);
                    if ($deletar_lead) {
                        $deletar_respostas = $this->respostas->delete_where('leadID', $lead->leadID);
                        $deletar_conversas = $this->conversas->delete_where('leadID', $lead->leadID);
                    }
                } else {
                    if ($lead->integrado == 0) {
                        $enviar_mkt[] = $this->finaliza_chat($lead->leadID);
                    }
                }
            }
        }
        if (isset($enviar_mkt)) {
            dd($enviar_mkt);
        }
        if (isset($deletar_lead)) {
            dd($deletar_lead);
        }
    }

    /**
     * Método para carregamento das fontes
     * @return void
     **/
    public function font($fonte,$formato){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/font-".$formato);
        echo @file_get_contents("https://chat.leadforce.com.br/assets/template/fonts/".$fonte."?".time());
    }

    /**
     * Método para persistência dos logs do chat
     * @return void
     **/
    private function logChat($request = NULL)
    {
        if (!$request) {
            return FALSE;
        }
        $path = 'application/logs/' . date('Y-m') . '/';
        if (!file_exists($path)) {
            mkdir($path, 0777);
        }
        write_file($path . date('d') . '-logs.txt', $request . "\n", 'a+');
    }

    /**
     * Método para buscar os veículos
     * @param array $marcas
     * @return array
     **/
    protected function buscar_veiculos($marcas)
    {
        $contador = 0;
        $qs = null;
        foreach ($marcas as $marca) {
            $qs .= 'mrc[' . $contador . ']=' . $marca->marcaID . '&';
            $contador++;
        }
        $r = json_decode(file_get_contents('http://mkt.leadforce.com.br/ws/modelos_json?' . $qs), 1);

        if(count($r)){
            return $r;
        }
        return array('0' => null);
    }

    /**
     * Método para buscar as empresas
     * @param array $grupoID
     * @return array
     **/
    public function buscar_empresas($grupoID, $json = FALSE)
    {
        if ($json) {
            $r = file_get_contents('http://rel.leadforce.com.br/ws/empresas_by_grupo_json/' . $grupoID);
            die($r);
        } else {
            $r = json_decode(file_get_contents('http://rel.leadforce.com.br/ws/empresas_by_grupo_json/' . $grupoID), 1);
        }


        if(count($r)){
            return $r;
        }
        return array('0' => null);
    }
}