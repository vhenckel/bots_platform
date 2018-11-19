<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Classe para manipulação dos atendentes dos bots
 *
 * @package Controller
 * @subpackage Manager
 * @access public
 **/
class Atendentes extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->menu = 'chatbot';
        $this->load->model('Chatbots_model', 'chatbots');
        $this->load->model('Atendentes_model', 'atendentes');
    }

    /**
     * Método para listagem dos atendentes do chat
     * @return void
     **/
    public function index($chatbotID = NULL, $atendenteID = NULL)
    {
        if (!$chatbotID) {
            redirect(base_url("manager/chatbots/"));
        }

        if ($atendenteID) {
            $data['atendenteEditar'] = $this->atendentes->get_by_id($atendenteID);
        }
        $this->submenu  = 'listar';
        $chatbot = $this->chatbots->get_by_id($chatbotID);
        $data['title']      = 'Listar Atendentes';
        $data['page']       = 'atendentes_listar';
        $data['chatbotID']  = $chatbotID;
        $data['hash']       = $chatbot->hash;
        $data['atendentes'] = $this->atendentes->get_by_field('chatbotID', $chatbotID);

        $this->render($data);
    }

    /**
     * Método para gravação de novos atendentes e edição de atendentes existentes
     *
     * @param  array $_POST = array com os dados do atendente
     * @return void
     **/
    public function gravar()
    {
        if ($_POST) {

            $attributes = [
                'nome'      => $this->input->post('nome'),
                'funcao'    => $this->input->post('funcao'),
                'chatbotID' => $this->input->post('chatbotID')
            ];

            $chatbotID   = $this->input->post('chatbotID');
            $atendenteID = $this->input->post('atendenteID');
            $hash        = $this->input->post('hash');

            if (isset($atendenteID)) {
                $update = $this->atendentes->update($atendenteID, $attributes);
                if ($update) {
                    $this->session->set_flashdata('success', 'Atendente editado com sucesso!');
                } else {
                    $this->session->set_flashdata('danger', "Atendente não pôde ser editado!");
                }
            } else {
                $atendenteID = $this->atendentes->insert($attributes);
                if ($atendenteID) {
                    $this->session->set_flashdata('success', 'Atendente criado com sucesso!');
                } else {
                    $this->session->set_flashdata('danger', 'Atendente não pôde ser criado!');
                }
            }

            if(isset($_FILES['avatar'])) {

                $this->load->library('upload');

                $path = "./assets/";

                if(!file_exists($path)):
                    mkdir($path, 0777);
                endif;

                $path = $path . 'chat-' . $hash . '/';

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

                if(isset($_FILES['avatar']['name']) && $_FILES['avatar']['name'] != '') {
                    // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
                    if ($_FILES['avatar']['error'] != 0) {
                       $data['erro'] = "Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['avatar']['error']];
                       $this->session->set_flashdata('danger', $data['erro']);
                    }
                    // Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
                    // Faz a verificação da extensão do arquivo
                    // $extensao = strtolower(end(explode('.', $_FILES['avatar']['name'])));
                    $extensao = explode('.', $_FILES['avatar']['name']);
                    $extensao = strtolower(end($extensao));

                    if (array_search($extensao, $_UP['extensoes']) === false) {
                      $messageSession = "Por favor, envie arquivos com as seguintes extensões: jpg, jpeg, png ou ico";
                      // exit;
                    }
                    // Faz a verificação do tamanho do arquivo
                    if ($_UP['tamanho'] < $_FILES['avatar']['size']) {
                      $messageSession = "O arquivo enviado é muito grande, envie arquivos de até 10Mb.";
                      exit;
                    }
                    // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta

                    // Mantém o nome original do arquivo
                    $nome_final = $_FILES['avatar']['name'];

                    // Depois verifica se é possível mover o arquivo para a pasta escolhida
                    if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $_UP['pasta'] . $nome_final)) {
                        $data['erro'] = 'Erro ao persistir na pasta';
                        $this->session->set_flashdata('danger', $data['erro']);
                    } else {
                        $persiste_imagem = $this->atendentes->update($atendenteID, ['avatar' => $nome_final]);
                        $this->session->set_flashdata('success', 'Avatar cadastrado com sucesso!');
                        $this->session->set_flashdata('danger', NULL);
                    }

                }
            }
            redirect(base_url("manager/atendentes/" . $chatbotID));
        }
    }

    /**
     * Método para exclusão de imagens do avatar do chat
     * @return void
     **/
    public function excluiravatar($atendenteID = NULL, $chatID = NULL)
    {
        $atendente = $this->atendentes->get_by_id($atendenteID);
        $chatbot   = $this->chatbots->get_by_id($chatID);

        if ($atendente) {
            $update  = $this->atendentes->update($atendente->atendenteID, ['avatar' => '']);
            if ($update) {
                $this->session->set_flashdata('success', 'Atendente editado com sucesso!');
                $path = "./assets/" . 'chat-' . $chatbot->hash . '/';
                @unlink($path . $atendente->avatar);
            } else {
                $this->session->set_flashdata('danger', "Atendente não pôde ser editado!");
            }
        }
        redirect(base_url("manager/atendentes/" . $chatID . '/' . $atendenteID));
    }

    /**
     * Método para exclusão do atendente do chat
     * @return void
     **/
    public function excluir($chatID = NULL, $atendenteID = NULL)
    {
        $atendente = $this->atendentes->get_by_id($atendenteID);
        $chatbot   = $this->chatbots->get_by_id($chatID);

        if ($atendente) {
            $delete  = $this->atendentes->delete($atendente->atendenteID);
            if ($delete) {
                $this->session->set_flashdata('success', 'Atendente deletado com sucesso!');
                $path = "./assets/" . 'chat-' . $chatbot->hash . '/';
                @unlink($path . $atendente->avatar);
            } else {
                $this->session->set_flashdata('danger', "Atendente não pôde ser deletado!");
            }
        }
        redirect(base_url("manager/atendentes/" . $chatID));
    }
}