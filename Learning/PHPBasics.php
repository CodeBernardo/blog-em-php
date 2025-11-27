<?php
declare(strict_types=1); // tipagem forte, Default(0) ✔️ (correta - obriga tipos estritos nos parâmetros de funções, disponível a partir do PHP 7.0)

function concatString(string $param1, string $param2): string // sintaxe para funcoes ✔️ (correta - declara função tipada em PHP)
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

$variavel = "..."; // sintaxe para variaveis ✔️ (correta - declaração de variável em PHP)

// tipos de dados
$string = "";      // ✔️ string
$int = 1;          // ✔️ inteiro
$bool = true;      // ✔️ booleano
$float = 1.99;     // ✔️ ponto flutuante
$null = null;      // ✔️ null
var_dump($string); // para debug, printa o tipo e o valor da variavel ✔️ (correta - var_dump mostra tipo e valor)

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
