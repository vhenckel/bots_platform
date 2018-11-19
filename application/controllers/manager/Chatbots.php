<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe para manipulação dos chatbots
 *
 * @package Controller
 * @subpackage Manager
 * @access public
 **/
class Chatbots extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->menu = 'chatbot';
        $this->load->model('Chatbots_model', 'chatbots');
        $this->load->model('Dialogo_model', 'dialogos');
        $this->load->model('Atendentes_model', 'atendentes');
    }

    /**
     * Método para listagem dos chatbots
     * @return void
     **/
    public function index()
    {
        $this->submenu  = 'listar';
        $data['dataTable'] = TRUE;
        $data['title']    = 'Listar Chatbots';
        $data['page']     = 'chatbot_listar';
        $clientes         = $this->getClients();
        $data['chatbots'] = $this->chatbots->buscar_todos();

        $contador = 0;
        foreach ($data['chatbots'] as $bot) {
            foreach ($clientes as $cliente) {
                if ($cliente['ID'] == $bot->clienteID) {
                    $data['chatbots'][$contador]->cliente = $cliente['NOME'];
                }
            }
            $cont_atendentes[$contador] = $this->atendentes->get_by_field('chatbotID', $bot->chatbotID);
            $data['chatbots'][$contador]->atendentes = ($cont_atendentes[$contador]) ? 1 : 0;
            $contador++;
        }
        $this->render($data);
    }

    /**
     * Método para adicionar um novo chatbot
     * @return void
     **/
    public function adicionar($chatbotID=NULL)
    {
        $this->submenu  = 'novo';

        $data['title']       = 'Novo Chatbot';
        $data['page']        = 'chatbot_novo';
        $data['clientes']    = $this->getClients();
        $data['marcas']      = $this->buscar_marcas();
        $data['dialogos']    = $this->dialogos->get_all();
        $data['colorpicker'] = true;

        if ($chatbotID) {
            $data['chatEditar'] = $this->chatbots->get_by_id($chatbotID);
            $data['unidades'] = json_decode(file_get_contents("http://chat.leadforce.com.br/ws/webservice/buscar_empresas/" . $data['chatEditar']->clienteID . "/TRUE"));
        }
        $this->render($data);
    }

    /**
     * Método para gravação de novos bots e edição de bots existentes
     *
     * @param  array $_POST = array com os dados do bot
     * @return void
     **/
    public function gravar()
    {
        if ($_POST) {

            $attributes = [
                'titulo'            => $this->input->post('titulo'),
                'clienteID'         => $this->input->post('clienteID'),
                'dialogoID'         => $this->input->post('dialogoID'),
                'bgPrincipal'       => $this->input->post('bgPrincipal'),
                'bgSecundario'      => $this->input->post('bgSecundario'),
                'bgSecundarioFonte' => $this->input->post('bgSecundarioFonte'),
                'bgCTA'             => $this->input->post('bgCTA'),
                'bgCTAFonte'        => $this->input->post('bgCTAFonte'),
                'bgIcones'          => $this->input->post('bgIcones'),
                'chamadaPrincipal'  => $this->input->post('chamadaPrincipal'),
                'posicao'           => $this->input->post('posicao'),
                'start'             => ($this->input->post('start') * 1000),
                'marcaVeiculos'     => $this->input->post('marcaVeiculos'),
                'formulario'        => $this->input->post('formulario'),
                'unidade'           => $this->input->post('unidade'),
                'token'             => $this->input->post('token'),
                'editado'           => date('Y-m-d H:i:s')
            ];

            $chatbotID = $this->input->post('chatbotID');
            if ($chatbotID == 1) {
                // dd($attributes);
            }
            if (isset($chatbotID)) {
                $update    = $this->chatbots->update($chatbotID, $attributes);
                $dadosChat = $this->chatbots->get_by_id($chatbotID);
                $chatHash  = $dadosChat->hash;
                if ($update) {
                    $this->session->set_flashdata('success', 'Chatbot editado com sucesso!');
                } else {
                    $this->session->set_flashdata('danger', "Chatbot não pôde ser editado!");
                }
            } else {
                $attributes['criado'] = date('Y-m-d H:i:s');
                $attributes['hash']   = md5(date('Y-m-d H:i:s'));
                $chatHash = $attributes['hash'];
                $chatbotID = $this->chatbots->insert($attributes);
                if ($chatbotID) {
                    $this->session->set_flashdata('success', 'Chatbot criado com sucesso!');
                } else {
                    $this->session->set_flashdata('danger', "Chatbot não pôde ser criado!");
                }
            }

            if(isset($_FILES)) {

                $this->load->library('upload');

                $path = "./assets/";

                if(!file_exists($path)):
                    mkdir($path, 0777);
                endif;

                $path = $path . 'chat-' . $chatHash . '/';

                if(!file_exists($path)):
                    mkdir($path, 0777);
                endif;

                $html = "<html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>";

                $arquivoIndex = $path . "index.html";

                if(!file_exists($arquivoIndex)):
                    file_put_contents($arquivoIndex, $html);
                endif;

                // Pasta onde o arquivo vai ser salvo
                $_UP['pasta'] = $path;
                // Tamanho máximo do arquivo (em Bytes)
                $_UP['tamanho'] = 1024 * 1024 * 10; // 10Mb
                // Array com as extensões permitidas
                $_UP['extensoes'] = array('jpg', 'jpeg', 'pgn', 'ico');
                // Array com os tipos de erros de upload do PHP
                $_UP['erros'][0] = 'Não houve erro';
                $_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
                $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especificado no HTML';
                $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
                $_UP['erros'][4] = 'Não foi feito o upload do arquivo';

                if(isset($_FILES['logoCliente']['name']) && $_FILES['logoCliente']['name'] != '') {
                    // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
                    if ($_FILES['logoCliente']['error'] != 0) {
                       $data['erro'] = "Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['logoCliente']['error']];
                       $this->session->set_flashdata('danger', $data['erro']);
                    }
                    // Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
                    // Faz a verificação da extensão do arquivo
                    // $extensao = strtolower(end(explode('.', $_FILES['logoCliente']['name'])));

                    $extensao = explode('.', $_FILES['logoCliente']['name']);
                    $extensao = strtolower(end($extensao));

                    if (array_search($extensao, $_UP['extensoes']) === false) {
                      $messageSession = "Por favor, envie arquivos com as seguintes extensões: jpg, jpeg, png ou ico";
                      // exit;
                    }
                    // Faz a verificação do tamanho do arquivo
                    if ($_UP['tamanho'] < $_FILES['logoCliente']['size']) {
                      $messageSession = "O arquivo enviado é muito grande, envie arquivos de até 10Mb.";
                      exit;
                    }
                    // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta

                    // Mantém o nome original do arquivo
                    $nome_final = $_FILES['logoCliente']['name'];

                    // Depois verifica se é possível mover o arquivo para a pasta escolhida
                    if (!move_uploaded_file($_FILES['logoCliente']['tmp_name'], $_UP['pasta'] . 'lf_chatbot_logo.png')) {
                        $data['erro'] = 'Erro ao persistir na pasta';
                        $this->session->set_flashdata('danger', $data['erro']);
                    } else {
                        $persiste_imagem = $this->chatbots->update($chatbotID, ['logoCliente' => 'lf_chatbot_logo.png']);
                    }

                }

                if(isset($_FILES['imgIniciar']['name']) && $_FILES['imgIniciar']['name'] != '') {
                    // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
                    if ($_FILES['imgIniciar']['error'] != 0) {
                       $data['erro'] = "Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['imgIniciar']['error']];
                       $this->session->set_flashdata('danger', $data['erro']);
                    }
                    // Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
                    // Faz a verificação da extensão do arquivo
                    // $extensao = strtolower(end(explode('.', $_FILES['imgIniciar']['name'])));

                    $extensao = explode('.', $_FILES['imgIniciar']['name']);
                    $extensao = strtolower(end($extensao));

                    if (array_search($extensao, $_UP['extensoes']) === false) {
                      $messageSession = "Por favor, envie arquivos com as seguintes extensões: jpg, jpeg, png ou ico";
                      // exit;
                    }
                    // Faz a verificação do tamanho do arquivo
                    if ($_UP['tamanho'] < $_FILES['imgIniciar']['size']) {
                      $messageSession = "O arquivo enviado é muito grande, envie arquivos de até 10Mb.";
                      exit;
                    }
                    // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta

                    // Mantém o nome original do arquivo
                    $nome_final = $_FILES['imgIniciar']['name'];

                    // Depois verifica se é possível mover o arquivo para a pasta escolhida
                    if (!move_uploaded_file($_FILES['imgIniciar']['tmp_name'], $_UP['pasta'] . 'lf_chatbot_btninicial.png')) {
                        $data['erro'] = 'Erro ao persistir na pasta';
                        $this->session->set_flashdata('danger', $data['erro']);
                    } else {
                        $persiste_imagem = $this->chatbots->update($chatbotID, ['imgIniciar' => 'lf_chatbot_btninicial.png']);
                    }

                }

                if(isset($_FILES['imgIniciarMobile']['name']) && $_FILES['imgIniciarMobile']['name'] != '') {
                    // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
                    if ($_FILES['imgIniciarMobile']['error'] != 0) {
                       $data['erro'] = "Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['imgIniciarMobile']['error']];
                       $this->session->set_flashdata('danger', $data['erro']);
                    }
                    // Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
                    // Faz a verificação da extensão do arquivo
                    // $extensao = strtolower(end(explode('.', $_FILES['imgIniciarMobile']['name'])));

                    $extensao = explode('.', $_FILES['imgIniciarMobile']['name']);
                    $extensao = strtolower(end($extensao));

                    if (array_search($extensao, $_UP['extensoes']) === false) {
                      $messageSession = "Por favor, envie arquivos com as seguintes extensões: jpg, jpeg, png ou ico";
                      // exit;
                    }
                    // Faz a verificação do tamanho do arquivo
                    if ($_UP['tamanho'] < $_FILES['imgIniciarMobile']['size']) {
                      $messageSession = "O arquivo enviado é muito grande, envie arquivos de até 10Mb.";
                      exit;
                    }
                    // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta

                    // Mantém o nome original do arquivo
                    $nome_final = $_FILES['imgIniciarMobile']['name'];

                    // Depois verifica se é possível mover o arquivo para a pasta escolhida
                    if (!move_uploaded_file($_FILES['imgIniciarMobile']['tmp_name'], $_UP['pasta'] . 'lf_chatbot_btninicial_mobile.png')) {
                        $data['erro'] = 'Erro ao persistir na pasta';
                        $this->session->set_flashdata('danger', $data['erro']);
                    } else {
                        $persiste_imagem = $this->chatbots->update($chatbotID, ['imgIniciarMobile' => 'lf_chatbot_btninicial_mobile.png']);
                        $this->session->set_flashdata('danger', NULL);
                        unset($_SESSION['danger']);
                        $this->session->set_flashdata('success', 'Chatbot editado com sucesso!');
                    }

                }

                $arquivo_custom_css = $path . "custom.css";

                $remover_css = unlink($arquivo_custom_css);
                $position = NULL;
                if ($attributes['posicao'] == 2) {
                    $position = '.lf_chatbot-main-box{margin-left:0;}.lf_chatbot-container{left:inherit;right:0;}';
                }
                $css_custom = '.lf_chatbot-header{background: ' . $this->input->post('bgPrincipal') . ';}.lf_chatbot-header button{color: ' . $this->input->post('bgIcones') . ';}.lf_chatbot-consultant-profile,.lf_chatbot-endscreen{background: ' . $this->input->post('bgSecundario') . ';color: ' . $this->input->post('bgSecundarioFonte') . ';}.lf_chatbot-login-submit,.lf_chatbot-canvas-form-option:hover,.lf_chatbot-btn,.lf_chatbot-client-row .lf_chatbot-balloon{color: ' . $this->input->post('bgCTAFonte') . ';background: ' . $this->input->post('bgCTA') . ';}.lf_chatbot-balloon-right-tip{border-left: solid 8px ' . $this->input->post('bgCTA') . ';}.lf_chatbot-canvas-form-input-wrapper.active label {color: ' . $this->input->post('bgCTA') . ';}' . $position;


                if(!file_exists($arquivo_custom_css)):
                    file_put_contents($arquivo_custom_css, $css_custom);
                endif;
            }
            redirect(base_url("manager/chatbots/"));
        }
    }

    /**
     * Método para exclusão de imagens do chat
     * @return void
     **/
    public function excluirImg($tipoImagem = NULL, $chatID = NULL)
    {
        switch ($tipoImagem) {
            case 1:
                $imagem = 'logoCliente';
                break;
            case 2:
                $imagem = 'imgIniciar';
                break;
            case 3:
                $imagem = 'imgIniciarMobile';
                break;
            default:
                $imagem = 'logoCliente';
                break;
        }
        $chatbot = $this->chatbots->get_by_id($chatID);
        if ($chatbot) {
            $update  = $this->chatbots->update($chatID, [$imagem => '']);
            if ($update) {
                $this->session->set_flashdata('success', 'Chatbot editado com sucesso!');
                $path = "./assets/" . 'chat-' . $chatbot->hash . '/';
                @unlink($path . $chatbot->{$imagem});
            } else {
                $this->session->set_flashdata('danger', "Chatbot não pôde ser editado!");
            }
            redirect(base_url("manager/chatbots/adicionar/" . $chatID));
        }
        redirect(base_url("manager/chatbots/"));

    }

    /**
     * Método para buscar todos os clientes do MKT da LeadForce
     * @return array
     * @access private
     **/
    private function getClients()
    {
        $rows = json_decode(file_get_contents('http://mkt.leadforce.com.br/ws/grupos_json'), 1);

        if(count($rows)){
            return $rows;
        }
        return array('0' => null);
    }

    /**
     * Método para buscar as empresas
     * @param array $grupoID
     * @return array
     **/
    protected function buscar_empresas($grupoID)
    {
       $r = json_decode(file_get_contents('http://rel.leadforce.com.br/ws/empresas_by_grupo_json/' . $grupoID), 1);

        if(count($r)){
            return $r;
        }
        return array('0' => null);
    }
}