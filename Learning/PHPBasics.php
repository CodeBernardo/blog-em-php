<?php
declare(strict_types=1); // tipagem forte, Default(0) ✔️ (correta - obriga tipos estritos nos parâmetros de funções, disponível a partir do PHP 7.0)

use PSpell\Dictionary;

function concatString(string $param1, ?string $param2): string // sintaxe para funcoes ✔️ (correta - declara função tipada em PHP)
{
    // return $param1 . " " . $param2; // concatenançao de textos, o simbolo + so serve para numeros ✔️ (correta - o operador . concatena strings, + é só para números)

    /*
        $mensagem = $param1;
        $mensagem .= " ";
        $mensagem .= $param2;
        return $mensagem;
    */ // ✔️ (forma alternativa correta de concatenar strings usando .=)

    //Interpolacao ✔️ (correta - é possível fazer interpolação de variáveis dentro de aspas duplas)
    return "$param1 $param2";
    // return "{$param1} {$param2}"; // ✔️ (também correta, outra sintaxe de interpolação)

    // HEREDOC -> para textos grandes, templates HTML e emails ✔️ (correta - HEREDOC é útil para strings grandes, HTML, etc)
    // return <<<HTML
    // <p>$param1 $param2</p>
    // HTML;
}

//variaveis 
$variavel = "..."; // sintaxe para variaveis ✔️ (correta - declaração de variável em PHP)

// tipos de dados
$string = "";      // ✔️ string
$int = 1;          // ✔️ inteiro
$bool = true;      // ✔️ booleano
$float = 1.99;     // ✔️ ponto flutuante
$null = null;      // ✔️ null
var_dump($string); // para debug, printa o tipo e o valor da variavel ✔️ (correta - var_dump mostra tipo e valor)

//Contantes

// define() é uma função usada para criar constantes no PHP em tempo de execução.
// Sintaxe: define("NOME_DA_CONSTANTE", valor, bool $case_insensitive = false)
// Por padrão, as constantes definidas por define não são sensíveis a maiúsculas e minúsculas no PHP 7.3 ou inferior
// (mas a partir do PHP 7.4, o parâmetro $case_insensitive foi descontinuado e só é permitido criar constantes sensíveis a maiúsculas/minúsculas).

define("FOO", "bar"); // Define a constante FOO com valor "bar"
echo FOO;
$name = "exemplo";
define("EXAMPLE", $name); // constantes definidas por define só podem ser acessadas globalmente  

// const é outra forma de definir constantes no PHP, mas deve ser usada somente no escopo global ou dentro de classes.
// A principal diferença: const é avaliada em tempo de compilação. Além disso, só aceita valores escalares conhecidos em tempo de escrita do código.
const FOO2 = "Bar"; // Outra forma de criar uma constante (não pode ser usada dinamicamente)

// Resumindo:
// - define() pode ser usado em qualquer ponto do código (exceto fora do escopo em classes) e valores podem ser definidos dinamicamente.
// - const só pode ser usado no escopo de topo (global ou direto dentro de classes) e sempre requer um valor conhecido no momento da declaração.
// Ambos os métodos criam valores imutáveis que duram até o final da execução do script.

// Condicionais 
// Exemplo com if/elseif/else (controle de fluxo clássico)
function saudacao(int $time): string
{
    if ($time < 0 || $time > 23) {
        return "Formato de hora inválido";
    } elseif ($time >= 5 && $time <= 12) {
        return "Bom dia!";
    } elseif ($time > 12 && $time <= 19) {
        return "Boa Tarde!";
    } elseif (($time >= 0 && $time < 5) || ($time >= 20 && $time <= 23)) {
        return "Boa Noite!";
    }
    // Em caso de alguma falha lógica imprevista
    return "Formato de hora inválido";
}

function saudacaoSwitch(int $time): string
{
    switch (true) {
        case ($time < 0 || $time > 23):
            return "Formato de hora inválido";
        case ($time >= 5 && $time <= 12):
            return "Bom dia!";
        case ($time > 12 && $time <= 19):
            return "Boa Tarde!";
        case (($time >= 0 && $time < 5) || ($time >= 20 && $time <= 23)):
            return "Boa Noite!";
        default:
            return "Formato de hora inválido";
    }
}

function saudacaoTernario(int $time): string // PHP 4+
{
    return ($time < 0 || $time > 23) ? "Formato de hora inválido" :
        (($time >= 5 && $time <= 12) ? "Bom dia!" :
            (($time > 12 && $time <= 19) ? "Boa Tarde!" :
                ((($time >= 0 && $time < 5) || ($time >= 20 && $time <= 23)) ? "Boa Noite!" : "Formato de hora inválido")));
}

function saudacaoMatch(int $time): string // PHP 8+
{
    return match (true) {
        $time < 0 || $time > 23 => "Formato de hora inválido",
        $time >= 5 && $time <= 12 => "Bom dia!",
        $time > 12 && $time <= 19 => "Boa Tarde!",
        ($time >= 0 && $time < 5) || ($time >= 20 && $time <= 23) => "Boa Noite!",
        default => "Formato de hora inválido",
    };
}

// Tabela de operadores lógicos em PHP:
// | Operador | Nome | Precedência | Uso               | Observação                                                                                   |
// |----------|------|-------------|-------------------|----------------------------------------------------------------------------------------------|
// | &&       | AND  | Alta        | Mais comum        | Usado em expressões lógicas, recomendado na maioria dos casos; avalia ambos os lados sempre. |
// | and      | AND  | Baixa       | Controle de fluxo | Cuidado: precedência baixa; útil em atribuições condicionais, pode causar confusão.          |
// | ||       | OR   | Alta        | Mais comum        | Usado para verificar se pelo menos uma condição é verdadeira; avalia ambos os lados.         |
// | or       | OR   | Baixa       | Controle de fluxo | Cuidado: precedência baixa; usado em comandos condicionais, pode gerar ambiguidades.         |
// | xor      | XOR  | Média       | Pouco usado       | “Ou exclusivo”; verdadeiro se apenas um dos lados for verdadeiro.                            |
// | !        | NOT  | Alta        | Negação           | Nega o valor de uma expressão (verdadeiro para falso e vice-versa).                          |
// 
// Atenção: Precedência define a ordem em que os operadores são avaliados em uma expressão com múltiplos operadores. 
// Por exemplo, operadores com precedência alta (como && ou ||) são avaliados antes dos operadores com precedência baixa (como and ou or).
// Isso pode alterar o resultado de uma expressão se não for respeitado – em situações ambíguas, use parênteses para garantir o comportamento esperado!

//FILTROS
// Filtros no PHP são usados principalmente para validar e/ou sanitizar variáveis, como entradas de formulários.
// A função filter_var() recebe um valor e um tipo de filtro, e retorna o valor filtrado ou false (em caso de falha).
// Exemplos comuns incluem validação de e-mails, URLs, inteiros, etc.

// A função filter_var é extremamente útil no PHP para validação e sanitização de dados vindos de fontes externas, como formulários ou requisições.
// Ela reduz riscos de falhas de segurança e de dados inválidos, pois permite aplicar filtros prontos ou personalizados de forma padronizada.
// O filter_var retorna o valor filtrado, ou false se a validação falhar (por exemplo, se o e-mail for inválido).

function validateEmail(string $email): bool
{
    // Aqui usamos filter_var com FILTER_VALIDATE_EMAIL para verificar se o e-mail está em um formato válido.
    // Isso previne que valores inapropriados sejam processados como e-mail.
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Outros exemplos práticos do uso de filter_var:

// Sanitizar uma string removendo tags perigosas (evita XSS e outros ataques):
// FILTER_SANITIZE_STRING está deprecated desde o PHP 8.1, então utilize strip_tags() + trim() para limpar a string:
$nomeLimpo = trim(strip_tags($nome));

// Validar inteiros dentro de um determinado intervalo:
$numero = filter_var($input, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 100]]);
// Só retorna o valor se estiver entre 1 e 100; caso contrário, retorna false.

// Verificar se a entrada é uma URL válida:
$urlValida = filter_var($site, FILTER_VALIDATE_URL) !== false;

// Exemplo de filtro personalizado:
// filter_var também aceita FILTER_CALLBACK para aplicar funções de validação próprias.

// Função para aceitar apenas strings com letras e espaços:
function apenasLetrasEspacos($valor)
{
    // Retorna o valor se contém só letras e espaços; false caso contrário.
    return preg_match('/^[\p{L}\s]+$/u', $valor) ? $valor : false;
}

// Usando FILTER_CALLBACK para rodar um filtro customizado:
$nomeUsuario = "João da Silva";

$usuarioValido = filter_var(
    $nomeUsuario,
    FILTER_CALLBACK,
    ["options" => "apenasLetrasEspacos"]
);
// $usuarioValido terá o valor válido ou false se não corresponder ao critério.


// Server info e navegaçao

// Esta função identifica, de acordo com o servidor em que o sistema está rodando,
// qual URL base utilizar — por exemplo, quando estamos desenvolvendo localmente ou
// quando o código está em produção online. Isso é útil para garantir que as rotas 
// funcionem corretamente em diferentes ambientes, sem codificar caminhos fixos.
function getServerBaseUrl(): string
{
    // Pega o nome do servidor onde o PHP está rodando, por exemplo: "localhost" ou "meusite.com"
    $server = filter_input(INPUT_SERVER, "SERVER_NAME");

    // Se estiver rodando localmente, usa a constante DEV_URL.
    // Caso contrário, utiliza a URL definida para produção (PROD_URL).
    $env = $server == "localhost" ? DEV_URL : PROD_URL;

    return $env;
}

// Função responsável por criar um endereço absoluto para navegação no site.
// Recebe um caminho (por ex: "/login" ou "dashboard"), adiciona a BASE_URL e garante que
// não haja erro de concatenação de barras.
function navigate(string $path): string
{
    $server = getServerBaseUrl();

    // Garante que o caminho sempre comece com "/", evitando erros de navegação.
    $sanitized_path = str_starts_with($path, "/") ? $path : "/$path";

    // Concatena BASE_URL com o caminho, formando a URL absoluta do recurso desejado
    return $server . $sanitized_path;
}

// Arrays
// Existem duas formas principais de criar arrays em PHP:

// 1) Utilizando a função array()
// Essa é a forma tradicional, compatível com todas as versões do PHP.
$months = array(
    "Janeiro",
    "Fevereiro",
    "Março",
    "Abril",
    "Maio",
    "Junho",
    "Julho",
    "Agosto",
    "Setembro",
    "Outubro",
    "Novembro",
    "Dezembro"
);

// 2) Usando a sintaxe de colchetes []
// Essa forma foi introduzida no PHP 5.4 e é mais curta e legível.
$weekDays = [
    1 => "Domingo", // chave => valor
    "Batatinha" => "Segunda",
    "Terça",
    "Quarta",
    "Quinta",
    "Sexta",
    "Sábado"
];

var_dump($weekDays['Batatinha']); // pega o valor do indice batatinha

/*
 Diferenças principais:
 - array() funciona em todas as versões do PHP.
 - [] é suportado apenas a partir do PHP 5.4, sendo mais moderno e usual atualmente.
 Ambas as formas criam arrays equivalentes, a escolha depende da versão do PHP e preferência pessoal.
*/

// iteracoes em arrays
foreach ($weekDays as $key => $value) {
    echo $key . " - " . $value . "<br>";
}
