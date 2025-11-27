<!-- Arquivo responsavel pela inicializaçao do sistema -->
<?php 
include 'Learning/PHPBasics.php'; // ✔️ Correto: insere o conteúdo de outro arquivo no arquivo atual, funciona para qualquer arquivo
require 'system/config.php'; // ✔️ Correto: semelhante ao include, porém obrigatório para o arquivo atual rodar, deve ser usado para importar arquivos necessários (ex: conexões de banco)
// o prefixo _once pode ser adicionado em ambos para que seja criada apenas uma instância da importação ✔️ (correto)

echo concatString("hello", "world");