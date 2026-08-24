<?php
// CONFIGURAÇÃO DE SEGURANÇA (CRIPTOGRAFIA BIDIRECIONAL)
define('CHAVE_SECRETA', 'Sua_Ch@v3_Sup3r_S3gur4_Aqui_2026!');
define('IV_SECRETO', 'Seu_IV_S3cr3t0_Aqui!');
define('METODO_CRIPTOGRAFIA', 'AES-256-CBC');

function encriptarSenha($string) {
    $chave = hash('sha256', CHAVE_SECRETA);
    $iv = substr(hash('sha256', IV_SECRETO), 0, 16);
    return base64_encode(openssl_encrypt($string, METODO_CRIPTOGRAFIA, $chave, 0, $iv));
}

function desencriptarSenha($string) {
    $chave = hash('sha256', CHAVE_SECRETA);
    $iv = substr(hash('sha256', IV_SECRETO), 0, 16);
    return openssl_decrypt(base64_decode($string), METODO_CRIPTOGRAFIA, $chave, 0, $iv);
}
?>