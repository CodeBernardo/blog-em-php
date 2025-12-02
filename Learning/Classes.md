# Namespaces em PHP

## Exemplos de como usar namespaces em PHP

1. **Definindo um namespace para suas classes:**
   ```php
   namespace MeuProjeto\Model;
   class Usuario { ... }
   ```

2. **Usando uma classe de outro namespace:**
   ```php
   use MeuProjeto\Model\Usuario;
   $usuario = new Usuario();
   ```

3. **Usando classes do namespace global (do PHP), como exceções ou funções nativas:**
   ```php
   throw new \InvalidArgumentException("Mensagem de erro."); // Note a barra invertida!
   ```

4. **Acessando uma classe de outro namespace sem o 'use':**
   ```php
   $usuario = new \MeuProjeto\Model\Usuario();
   ```

5. **Possível estrutura de diretórios:**
   ```
   /src/MeuProjeto/Model/Usuario.php  (arquivo contendo 'namespace MeuProjeto\Model;')
   ```

---

### Por que ao adicionar o namespace a classe InvalidArgumentException ficou com erro?

Quando você declara um namespace como `namespace Learning;`, todas as classes que você referencia sem um namespace explícito são consideradas como pertencentes ao namespace atual. Portanto, ao fazer:

```php
throw new InvalidArgumentException(...);
```
dentro do namespace `Learning`, o PHP procura por `Learning\InvalidArgumentException`, e não pela classe nativa global `\InvalidArgumentException` (do PHP).

**Como corrigir:**  
Adicione a barra invertida antes do nome da classe, indicando que deseja usar a classe do namespace global:
```php
throw new \InvalidArgumentException("mensagem");
```

---

# Exemplo de Classe com Encapsulamento

```php
class Person
{
    public string $nome;
    private int $idade;

    public function __construct(string $nome, int $idade)
    {
        $this->setNome($nome);
        $this->setIdade($idade);
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        if (empty($nome)) {
            throw new \InvalidArgumentException("Nome não pode ser vazio.");
        }
        $this->nome = $nome;
    }

    public function getIdade(): int
    {
        return $this->idade;
    }

    public function setIdade(int $idade): void
    {
        if ($idade < 0) {
            throw new \InvalidArgumentException("Idade não pode ser negativa.");
        }
        $this->idade = $idade;
    }

    public function apresentar(): string
    {
        return "Olá, meu nome é {$this->getNome()} e tenho {$this->getIdade()} anos.";
    }
}
```

## Criando um objeto e utilizando getters e setters

```php
$pessoa = new Person("Lucas", 28);
echo $pessoa->apresentar(); // Olá, meu nome é Lucas e tenho 28 anos.

$pessoa->setNome("Maria");    // Modifica o nome usando o set
$pessoa->nome = "João";      // Modifica o nome usando a propriedade pública
$pessoa->setIdade(31);       // Modifica a propriedade privada usando o set

echo $pessoa->getNome();      // João
echo $pessoa->nome;           // João
echo $pessoa->getIdade();     // 31
```

**Resumo:**
- Métodos get/set permitem controlar acesso, leitura e alteração das propriedades.
- Segurança e validação são facilmente implementados nos setters.
- Bom para encapsulamento e manutenção do código.

---

# Encadeamento de Métodos e Métodos Mágicos

```php
class Message
{
    public string $content;

    public function __construct(string $content = "") 
    {
        $this->content = $content;
    }

    public function __destruct()
    {
        // Exemplo: echo "Objeto Message destruído\n";
    }

    public function __toString()
    {
        return $this->render();
    }

    public function __get($name)
    {
        if ($name === 'summary') {
            return "Resumo: " . substr($this->content, 0, 10) . "...";
        }
        return null;
    }

    public function __set($name, $value)
    {
        if ($name === 'content') {
            $this->content = $this->filterContent($value);
        }
    }

    public function __isset($name)
    {
        return property_exists($this, $name) && isset($this->$name);
    }

    public function success(string $content): self {
        $this->content = $this->filterContent($content);
        return $this;
    }

    public function filterContent(string $content): string {
        return filter_var($content, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public function render(): string {
        return $this->content;
    }
}
```

### Métodos mágicos/superiores especiais comumente utilizados em PHP

- `__construct()` : chamado na criação de um objeto (construtor).
- `__destruct()` : chamado quando o objeto é destruído (destrutor).
- `__toString()` : chamado quando o objeto é tratado como string.
- `__get()` : acesso a propriedades inacessíveis/inexistentes.
- `__set()` : atribuição a propriedades inacessíveis/inexistentes.
- `__isset()` : verificação de existência de propriedade inacessível.

Eles tornam objetos mais flexíveis e permitem customizar o comportamento em várias situações.

---

## Exemplos de uso:

```php
$msg = new Message();
// Encadeamento
echo $msg->success("<h1> Mensagem de sucesso </h1>")->render(); // retorna a mensagem filtrada

// Outra possibilidade é chamar a classe sem instanciar em uma variável
echo (new Message())->success("Sucesso")->render();
```

---

# Métodos Estáticos em PHP

Métodos estáticos pertencem à classe, e não à instância do objeto.  
Você pode chamá-los sem criar (instanciar) um objeto da classe.

## Como declarar e chamar métodos estáticos

```php
class MinhaClasse {
    public static function digaOla() {
        return "Olá do método estático!";
    }
}

echo MinhaClasse::digaOla();
```

**Vantagens:**
- Útil para utilitários, helpers ou operações que não dependem de dados da instância.
- Não requerem `$this` — dentro do método estático, `$this` não está disponível.

---

## Exemplo prático - Calculadora

```php
class Calculadora {
    public static function somar($a, $b): mixed {
        return self::logOperacao('somar', $a, $b, $a + $b);
    }

    public static function multiplicar($a, $b): float|int {
        return self::logOperacao('multiplicar', $a, $b, $a * $b);
    }

    public static function logOperacao(string $operacao, $a, $b, $resultado): mixed {
        // Exemplo didático: normalmente poderíamos logar, mas aqui apenas retorna o resultado.
        return $resultado;
    }
}
```

### Chamando métodos estáticos sem precisar instanciar a classe:

```php
echo Calculadora::somar(10, 20);         // Saída: 30
echo "\n";
echo Calculadora::multiplicar(5, 7);     // Saída: 35
```

**Resumo:**
- Métodos estáticos são úteis para operações utilitárias.
- Não acessam `$this`.
- São chamados via `NomeDaClasse::nomeMetodo()`.
- Métodos estáticos podem chamar outros métodos estáticos usando `self::` ou `static::`.
