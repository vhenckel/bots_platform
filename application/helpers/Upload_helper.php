<?php
/**
 * Função para upload de imagens
 * @return boolean
 **/
function upload($files, $folder, $lpID=null)
{
    if (isset($files)){
        $CI =& get_instance();
        $CI->load->library('upload');

        $path = "./assets/imagens/";

        if (isset($lpID)) {
            $path = $path . 'lp-' . $lpID . '/';
            if(!file_exists($path)):
                mkdir($path, 0777);
            endif;
        }

        if (isset($folder)) {
            $path = $path . $folder . '/';
        }

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

        $contador = 0;

        if(isset($files['name']) && $files['name'] != '') {
            // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
            if ($files['error'] != 0) {
               $data['erro'] = "Não foi possível fazer o upload, erro:" . $_UP['erros'][$files['error']];
               $CI->session->set_flashdata('danger', $data['erro']);
            }
            // Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
            // Faz a verificação da extensão do arquivo
            // $extensao = strtolower(end(explode('.', $files['name'])));

            $extensao = explode('.', $files['name']);
            $extensao = strtolower(end($extensao));

            if (array_search($extensao, $_UP['extensoes']) === false) {
              $messageSession = "Por favor, envie arquivos com as seguintes extensões: jpg, jpeg, png ou ico";
              // exit;
            }
            // Faz a verificação do tamanho do arquivo
            if ($_UP['tamanho'] < $files['size']) {
              $messageSession = "O arquivo enviado é muito grande, envie arquivos de até 10Mb.";
              exit;
            }
            // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta

            // Mantém o nome original do arquivo
            $nome_final = $files['name'];

            // Depois verifica se é possível mover o arquivo para a pasta escolhida
            if (!move_uploaded_file($files['tmp_name'], $_UP['pasta'] . $nome_final)) {
                $data['erro'] = 'Erro ao persistir na pasta';
                $CI->session->set_flashdata('danger', $data['erro']);
                return false;
            }
            return true;
        }
    }
}