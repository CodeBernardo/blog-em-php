<?php

namespace Learning;
/**
 * Por que ao adicionar o namespace a classe InvalidArgumentException ficou com erro?
 *
 * Explicação:
 * 
 * Quando você declara um namespace como `namespace Learning;`, todas as classes que você referencia
 * sem um namespace explícito são consideradas como pertencentes ao namespace atual.
 * Portanto, ao fazer `throw new InvalidArgumentException(...)` dentro do namespace Learning,
 * o PHP procura por `Learning\InvalidArgumentException`, e não pela classe nativa global
 * `\InvalidArgumentException` (do PHP).
 *
 * Para corrigir, basta adicionar a barra invertida antes do nome da classe, 
 * indicando que você quer usar a classe do namespace global:
 *    throw new \InvalidArgumentException("mensagem");
 *
 * ======================== EXEMPLOS DE COMO USAR NAMESPACES EM PHP ==========================
 *
 * 1. Definindo um namespace para suas classes:
 * 
 *    namespace MeuProjeto\Model;
 *    class Usuario { ... }
 * 
 * 2. Usando uma classe de outro namespace:
 * 
 *    use MeuProjeto\Model\Usuario;
 *    $usuario = new Usuario();
 * 
 * 3. Usando classes do namespace global (do PHP), como exceções ou funções nativas:
 * 
 *    throw new \InvalidArgumentException("Mensagem de erro.");  // Note a barra invertida!
 * 
 * 4. Acessando uma classe de outro namespace sem o 'use':
 *    $usuario = new \MeuProjeto\Model\Usuario();
 *
 * 5. Possível estrutura de diretórios:
 *    /src/MeuProjeto/Model/Usuario.php  (arquivo contendo 'namespace MeuProjeto\Model;')
 *
 * ===========================================================================================
 */

class Person
{
    // Propriedades privadas (não podem ser acessadas diretamente fora da classe)
    public string $nome;
    private int $idade;

    // Construtor
    public function __construct(string $nome, int $idade)
    {
        $this->setNome($nome);
        $this->setIdade($idade);
    }

    // Getter para 'nome'
    public function getNome(): string
    {
        return $this->nome;
    }

    // Setter para 'nome'
    public function setNome(string $nome): void
    {
        // Exemplo de validação
        if (empty($nome)) {
            throw new \InvalidArgumentException("Nome não pode ser vazio.");
        }
        $this->nome = $nome;
    }

    // Getter para 'idade'
    public function getIdade(): int
    {
        return $this->idade;
    }

    // Setter para 'idade'
    public function setIdade(int $idade): void
    {
        if ($idade < 0) {
            throw new \InvalidArgumentException("Idade não pode ser negativa.");
        }
        $this->idade = $idade;
    }

    // Método de apresentação
    public function apresentar(): string
    {
        return "Olá, meu nome é {$this->getNome()} e tenho {$this->getIdade()} anos.";
    }
}

/*
 * Criando um objeto e utilizando getters e setters
 */
$pessoa = new Person("Lucas", 28);
echo $pessoa->apresentar(); // Olá, meu nome é Lucas e tenho 28 anos.

$pessoa->setNome("Maria");    // Modifica o nome usando o set
$pessoa->nome = "João"; // Modifica o nome usando a propriedade pública
$pessoa->setIdade(31);        // Modifica a a propriedade privada usando o set

echo $pessoa->getNome();      // João
echo $pessoa->nome;           // João
echo $pessoa->getIdade();     // 31

/*
 * Resumo:
 * - Métodos get/set permitem controlar acesso, leitura e alteração das propriedades.
 * - Segurança e validação são facilmente implementados nos setters.
 * - Bom para encapsulamento e manutenção do código.
 */

// Encadeamento de métodos
class Message
{
    public string $content;

    /**
     * Construtor da classe. É chamado automaticamente ao instanciar o objeto.
     * Pode ser utilizado para inicializar propriedades.
     */
    public function __construct(string $content = "") 
    {
        $this->content = $content;
    }

    /**
     * Método destrutor. É chamado automaticamente quando o objeto é destruído ou
     * o script termina. Ideal para liberar recursos ou executar limpeza.
     */
    public function __destruct()
    {
        // Exemplo: echo "Objeto Message destruído\n";
    }

    /**
     * Permite que o objeto seja convertido automaticamente para string (por exemplo, em um echo).
     * Utiliza o método render() para definir a representação textual.
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Permite acessar propriedades inacessíveis ou inexistentes do objeto.
     * Útil para implementações personalizadas de acesso.
     */
    public function __get($name)
    {
        // Exemplo didático: retorna informação customizada ou nula se não existir
        if ($name === 'summary') {
            return "Resumo: " . substr($this->content, 0, 10) . "...";
        }
        return null;
    }

    /**
     * Permite atualizar propriedades inacessíveis ou inexistentes do objeto.
     * Pode ser usado para validação customizada ao setar propriedades.
     */
    public function __set($name, $value)
    {
        // Exemplo de log ou atribuição customizada
        if ($name === 'content') {
            $this->content = $this->filterContent($value);
        }
    }

    /**
     * Permite verificar se uma propriedade inacessível ou inexistente está definida.
     */
    public function __isset($name)
    {
        return property_exists($this, $name) && isset($this->$name);
    }

    /**
     * Define o conteúdo da mensagem como sucesso, sanitizando a entrada.
     * Permite encadeamento de métodos ao retornar $this.
     */
    public function success(string $content): self {
        $this->content = $this->filterContent($content);
        return $this;
    }

    /**
     * Filtra o conteúdo para evitar caracteres especiais perigosos.
     */
    public function filterContent(string $content): string {
        return filter_var($content, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    /**
     * Retorna o conteúdo pronto para ser exibido.
     */
    public function render(): string {
        return $this->content;
    }
}

/*
 * Métodos mágicos/superiores especiais comumente utilizados em PHP:
 * - __construct(): chamado na criação de um objeto (construtor).
 * - __destruct(): chamado quando o objeto é destruído (destrutor).
 * - __toString(): chamado quando o objeto é tratado como string.
 * - __get(): acesso a propriedades inacessíveis/inexistentes.
 * - __set(): atribuição a propriedades inacessíveis/inexistentes.
 * - __isset(): verificação de existência de propriedade inacessível.
 *
 * Eles tornam objetos mais flexíveis e permitem customizar o comportamento em várias situações.
 */

$msg = new Message();
//encadeamento
echo $msg->success("<h1> Mensagem de sucesso </h1>")->render(); // retorna a mensagem de sucesso com o filtro de conteúdo

// Outra possibilidade é chamar a classe sem instanciar em uma variavel
echo new Message()->success("Sucesso")->render();

// metodos estaticos

/*
 * ============================= MÉTODOS ESTÁTICOS EM PHP =============================
 *
 * Métodos estáticos pertencem à classe, e não à instância do objeto.
 * Você pode chamá-los sem criar (instanciar) um objeto da classe.
 * Para declarar, use a palavra-chave 'static':
 * 
 *     class MinhaClasse {
 *         public static function digaOla() {
 *             return "Olá do método estático!";
 *         }
 *     }
 * 
 * Para chamar:
 *     echo MinhaClasse::digaOla();
 *
 * Vantagens:
 * - Útil para utilitários, helpers ou operações que não dependem de dados da instância.
 * - Não requerem $this — dentro do método estático, $this não está disponível.
 *
 * Exemplo prático:
 */
class Calculadora {
    public static function somar($a, $b): mixed {
        // Chamando um método estático de dentro da própria classe
        return self::logOperacao('somar', $a, $b, $a + $b);
    }

    public static function multiplicar($a, $b): float|int {
        // Chamando um método estático de dentro da própria classe
        return self::logOperacao('multiplicar', $a, $b, $a * $b);
    }

    // Novo método estático que pode ser chamado de outros métodos estáticos
    public static function logOperacao(string $operacao, $a, $b, $resultado): mixed {
        // Apenas como exemplo didático.
        // Normalmente poderíamos logar em arquivo, banco, etc., mas aqui apenas retorna o resultado.
        // echo "Operação \"$operacao\" com $a e $b. Resultado: $resultado\n";
        return $resultado;
    }
}

// Chamando métodos estáticos sem precisar instanciar a classe:
echo Calculadora::somar(10, 20);         // Saída: 30
echo "\n";
echo Calculadora::multiplicar(5, 7);     // Saída: 35

/*
 * Resumo:
 * - Métodos estáticos são úteis para operações utilitárias.
 * - Não acessam $this.
 * - São chamados via NomeDaClasse::nomeMetodo().
 * - Métodos estáticos podem chamar outros métodos estáticos usando self:: ou static::
 */

