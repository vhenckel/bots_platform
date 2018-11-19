<?php
/**
 * Função para depuração de dados
 * @return object
 **/
function dd($valor){
    echo "<pre>";
    print_r($valor);
    echo "</pre>";
    echo "<br />";
    echo "<pre>";
    var_dump($valor);
    echo "</pre>";
    die();
}

/**
 * Função para limpar string
 * @return String
 **/
function limpar($string) {
    $string = preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $string));
    $string = strtolower($string);
    $string = str_replace(' ', '-', $string);
    $string = str_replace('---', '-', $string);
    return $string;
}

/**
 * Função para limpar telefone
 * @return String
 **/
function limparTelefone($telefone) {
    $array1 = array("(", ")", "-", ".", " ");
    $array2 = array("", "", "", "", "");
    $retorno = str_replace( $array1, $array2, $telefone);
    return $retorno;
}

/**
 * Função para formatar telefone
 * @return String
 **/
function telefone($fone) {
    $pattern = '/(\d{2})(\d{5})(\d*)/';
    $telefoneN = preg_replace($pattern, '($1) $2-$3', $fone);
    return $telefoneN;
}

/**
 * Função para encriptação de dados
 * @return object
 **/
function crypto($pw) {
    return sha1('lead@' . $pw . '@force');
}