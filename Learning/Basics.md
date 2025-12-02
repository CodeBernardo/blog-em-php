# 📘 Sumário das Lições de PHP

1. **Tipagem Estrita e Declarações Iniciais**
2. **Sintaxe para Funções e Concatenamento de Strings**
3. **Variáveis e Tipos de Dados Primitivos**
4. **Constantes (`define`, `const`) – Características e Diferenças**
5. **Estruturas Condicionais (`if`, `switch`, ternário, `match`)**
6. **Operadores Lógicos e Tabela de Precedência**
7. **Filtros de Validação e Sanitização (`filter_var`, callbacks)**
8. **Informações do Servidor e Navegação (URL base, rotas)**
9. **Arrays: Criação e Iteração (formas, `foreach`)**
10. **Slugs: Como gerar e para que servem em URLs**
11. **Estruturas de Repetição (`while`, `do...while`, `for`, `foreach`)**

_Cada tópico traz exemplos de código e explicações práticas!_

---

## 1. Tipagem Estrita

```php
declare(strict_types=1); // Tipagem forte, Default(0) ✔️ 
```

---

## 2. Funções e Concatenamento

```php
function concatString(string $param1, ?string $param2): string 
{
    // return $param1 . " " . $param2; // concatenanção de textos

    /*
        $mensagem = $param1;
        $mensagem .= " ";
        $mensagem .= $param2;
        return $mensagem;
    */ // alternativa com .=

    // Interpolação
    return "$param1 $param2";
    // return "{$param1} {$param2}"; // Outra forma de interpolação
    // HEREDOC pode ser usado para textos longos/templates HTML
    // return <<<HTML
    // <p>$param1 $param2</p>
    // HTML;
}
```

---

## 3. Variáveis e Tipos

```php
$variavel = "..."; // variável
$string = "";      // string
$int = 1;          // inteiro
$bool = true;      // booleano
$float = 1.99;     // ponto flutuante
$null = null;      // null
var_dump($string); // debug: tipo e valor
```

---

## 4. Constantes

```php
define("FOO", "bar"); // Constante runtime
echo FOO;
$nome = "exemplo";
define("EXAMPLE", $nome); // define é sempre global
const FOO2 = "Bar"; // Constante compilada
```

**Resumo:**
- `define()`: qualquer ponto do código, valor dinâmico, mas não em classes.
- `const`: topo do código/classe, valor constante no momento de declaração.

---

## 5. Estruturas Condicionais

### If-Else

```php
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
    return "Formato de hora inválido";
}
```

### Switch

```php
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
```

### Ternário

```php
function saudacaoTernario(int $time): string
{
    return ($time < 0 || $time > 23) ? "Formato de hora inválido" :
        (($time >= 5 && $time <= 12) ? "Bom dia!" :
            (($time > 12 && $time <= 19) ? "Boa Tarde!" :
                ((($time >= 0 && $time < 5) || ($time >= 20 && $time <= 23)) ? "Boa Noite!" : "Formato de hora inválido")));
}
```

### Match (PHP 8+)

```php
function saudacaoMatch(int $time): string
{
    return match (true) {
        $time < 0 || $time > 23 => "Formato de hora inválido",
        $time >= 5 && $time <= 12 => "Bom dia!",
        $time > 12 && $time <= 19 => "Boa Tarde!",
        ($time >= 0 && $time < 5) || ($time >= 20 && $time <= 23) => "Boa Noite!",
        default => "Formato de hora inválido",
    };
}
```

---

## 6. Operadores Lógicos (Tabela)

| Operador | Nome | Precedência | Uso               | Observação                                                  |
|----------|------|-------------|-------------------|-------------------------------------------------------------|
| `&&`     | AND  | Alta        | Mais comum        | Avalia ambos os lados sempre.                               |
| `and`    | AND  | Baixa       | Controle de fluxo | Precedência baixa; cuidado com atribuições condicionais.    |
| `||`     | OR   | Alta        | Mais comum        | Usa para testar pelo menos uma condição.                    |
| `or`     | OR   | Baixa       | Controle de fluxo | Cuidado em atribuições, preferência para && e \|\|.           |
| `xor`    | XOR  | Média       | Pouco usado       | Verdadeiro se apenas um lado for verdadeiro.                |
| `!`      | NOT  | Alta        | Negação           | Inverte o valor lógico da expressão.                        |

> **Atenção à ordem de avaliação:**  
> Use parênteses para garantir o resultado esperado!

---

## 7. Filtros de Validação e Sanitização

### Validar e-mail

```php
function validateEmail(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
```

### Exemplo de sanitização

> **Obs:** `FILTER_SANITIZE_STRING` está depreciado.

```php
$nomeLimpo = trim(strip_tags($nome));
```

### Validar inteiro no intervalo

```php
$input = 34;
$numero = filter_var($input, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1, "max_range" => 100]]);
```

### Validar URL

```php
$site = 'http"//meusite.com';
$urlValida = filter_var($site, FILTER_VALIDATE_URL) !== false;
```

### Filtro personalizado

```php
function apenasLetrasEspacos($valor)
{
    return preg_match('/^[\p{L}\s]+$/u', $valor) ? $valor : false;
}

$nomeUsuario = "João da Silva";
$usuarioValido = filter_var(
    $nomeUsuario,
    FILTER_CALLBACK,
    ["options" => "apenasLetrasEspacos"]
);
```

---

## 8. Informações do Servidor e Navegação

```php
function getServerBaseUrl(): string
{
    $server = filter_input(INPUT_SERVER, "SERVER_NAME");
    $env = $server == "localhost" ? DEV_URL : PROD_URL;
    return $env;
}

function navigate(string $path): string
{
    $server = getServerBaseUrl();
    $sanitized_path = str_starts_with($path, "/") ? $path : "/$path";
    return $server . $sanitized_path;
}
```

---

## 9. Arrays

### Modo tradicional

```php
$months = array(
    "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
    "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
);
```

### Forma moderna (a partir do PHP 5.4)

```php
$weekDays = [
    1 => "Domingo",
    "Batatinha" => "Segunda",
    "Terça",
    "Quarta",
    "Quinta",
    "Sexta",
    "Sábado"
];

var_dump($weekDays['Batatinha']);
```

### Iterando arrays

```php
foreach ($weekDays as $key => $value) {
    echo $key . " - " . $value . "<br>";
}
```

---

## 10. Slug (URLs amigáveis)

```php
function slug($string) {
    $string = mb_strtolower($string, 'UTF-8');
    $string = preg_replace('/[áàãâä]/u', 'a', $string);
    $string = preg_replace('/[éèêë]/u', 'e', $string);
    $string = preg_replace('/[íìîï]/u', 'i', $string);
    $string = preg_replace('/[óòõôö]/u', 'o', $string);
    $string = preg_replace('/[úùûü]/u', 'u', $string);
    $string = preg_replace('/[ç]/u', 'c', $string);
    $string = preg_replace('/[^a-z0-9\s-]/', '', $string);
    $string = preg_replace('/[\s-]+/', '-', $string);
    $string = trim($string, '-');
    return strip_tags($string);
}

$titulo = "<p>Olá Mundo! PHP é ótimo</p>";
$slug = slug($titulo);
echo "Slug: {$slug} <br>";
```

---

## 11. Estruturas de Repetição

**Principais estruturas:**
1. `while`
2. `do...while`
3. `for`
4. `foreach`

```php
// 1) while
$contador = 0;
while ($contador < 3) {
    echo "While contador: $contador <br>";
    $contador++;
}

// 2) do...while
$contadorDo = 0;
do {
    echo "Do-While contador: $contadorDo <br>";
    $contadorDo++;
} while ($contadorDo < 3);

// 3) for
for ($i = 0; $i < 3; $i++) {
    echo "For contador: $i <br>";
}

// 4) foreach
$frutas = ['Maçã', 'Banana', 'Uva'];
foreach ($frutas as $indice => $fruta) {
    echo "Fruta [$indice]: $fruta <br>";
}
```

**Resumo das diferenças:**
- `while`: repete enquanto condição for true (condição antes do bloco).
- `do...while`: executa pelo menos uma vez (condição depois).
- `for`: ideal quando o número de repetições é conhecido.
- `foreach`: melhor para arrays/coleções.

