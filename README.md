# Blog PHP – Conceitos Básicos

Pequeno projeto em PHP usado para estudar conceitos fundamentais da linguagem.
O arquivo `index.php` inicializa a aplicação, carrega as funções em
`Learning/PHPBasics.php` e a configuração em `system/config.php`.

## Pré-requisitos

- PHP 8.0 ou superior (o projeto utiliza tipagem estrita e `match`, recursos do PHP 8)
- Servidor web local configurado (ex.: XAMPP, Laragon ou PHP embutido)

## Executando localmente

1. Clone ou copie este diretório para o `htdocs` (ou pasta pública equivalente do seu servidor).
2. Inicie o servidor Apache do XAMPP (ou rode `php -S localhost:8000` no diretório do projeto).
3. Acesse `http://localhost/blog` no navegador.

## Estrutura

- `index.php`: ponto de entrada que faz o include dos demais arquivos.
- `Learning/PHPBasics.php`: funções utilitárias e exemplos de sintaxe/operadores.
- `system/config.php`: espaço reservado para configurações necessárias ao sistema.

## Próximos passos sugeridos

- Adicionar exemplos de arrays, laços e orientação a objetos.
- Criar testes simples demonstrando boas práticas com PHP Unit (`phpunit`).
- Complementar a documentação com prints/explicações das funções criadas.

Sinta-se livre para adaptar o projeto aos seus estudos!

