# 📚 Composer

O **Composer** é um gerenciador de dependências para projetos PHP. Ele permite declarar, instalar e atualizar facilmente as bibliotecas das quais o seu projeto depende, facilitando a organização e manutenção das dependências de terceiros.

---

## Principais vantagens do Composer

- Instala e atualiza automaticamente bibliotecas e frameworks necessários ao seu projeto
- Controla versões dos pacotes, evitando conflitos de dependências
- Utiliza o arquivo `composer.json` para gerenciar informações e dependências do projeto
- Permite o autoload automático de classes via PSR-4 ou outras especificações
- Permite o autoload automático de arquivos (constantes, funções globais, configurações) usando a opção `"files"`

---

## Exemplo de uso básico

**1. Para criar o arquivo de dependências:**
```bash
composer init
```

**2. Para instalar uma biblioteca:**
```bash
composer require nome/pacote
```

**3. Para carregar automaticamente as classes:**
```php
require 'vendor/autoload.php';
```

Mais informações: [https://getcomposer.org/](https://getcomposer.org/)

---

## Como configurar o Composer neste projeto

### 1. Instalação do Composer (globalmente)

Baixe o Composer em [getcomposer.org/download](https://getcomposer.org/download/) e siga as instruções para instalação no seu sistema operacional.  
Após instalar, use o comando `composer` no terminal.

---

### 2. Inicialização do projeto com Composer

No diretório raiz do projeto, execute:
```bash
composer init
```
Isso irá criar o arquivo `composer.json`, onde você define as dependências do seu projeto.

---

### 3. Autoload de classes (PSR-4)

No arquivo `composer.json`, observe a seção `"autoload"`:

```json
"autoload": {
    "psr-4": {
        "system\\": "system/"
    }
}
```

Esse mapeamento faz com que as classes dentro da pasta `system/` sejam carregadas automaticamente, usando o padrão de namespaces PSR-4.

Para gerar (ou atualizar) o autoload, execute no terminal:
```bash
composer dump-autoload
```

---

### 4. Autoload de arquivos (constantes e funções)

O autoload PSR-4 carrega apenas **classes** automaticamente. Para carregar arquivos que contêm **constantes**, **funções globais** ou **configurações**, você precisa usar a opção `"files"` no `composer.json`.

**Exemplo de configuração:**

```json
"autoload": {
    "psr-4": {
        "system\\": "system/"
    },
    "files": ["system/config.php"]
}
```

**Como funciona:**

1. Quando você inclui `vendor/autoload.php`, o Composer automaticamente carrega todos os arquivos listados em `"files"`.
2. Isso é útil para arquivos que definem constantes (usando `define()`) ou funções globais que precisam estar disponíveis em todo o projeto.
3. Após adicionar ou modificar a configuração `"files"`, sempre execute:
   ```bash
   composer dump-autoload
   ```

**Exemplo prático:**

Se você tem um arquivo `system/config.php` com constantes:
```php
<?php 
define("DEV_URL", "http://localhost/blog"); 
define("PROD_URL", "https://Tech/blog"); 
```

E o `composer.json` está configurado com `"files": ["system/config.php"]`, então ao incluir `vendor/autoload.php`, as constantes estarão automaticamente disponíveis:

```php
require 'vendor/autoload.php';
// Agora PROD_URL e DEV_URL estão disponíveis sem precisar de require manual
echo PROD_URL;
```

**Importante:** 
- O autoload PSR-4 **não carrega constantes**, apenas classes
- Use `"files"` para carregar arquivos que definem constantes, funções ou configurações
- Sempre execute `composer dump-autoload` após modificar a configuração de autoload

---

### 5. Como usar o autoload no seu código

Antes de utilizar as classes do seu projeto, inclua a linha:
```php
require 'vendor/autoload.php';
```
Isso faz com que todas as classes cadastradas no autoload do Composer sejam carregadas automaticamente.

---

### 6. Instalação de dependências de terceiros

Para instalar algum pacote (por exemplo, `monolog/monolog`), use:
```bash
composer require monolog/monolog
```
O Composer irá adicionar o pacote ao `composer.json` e baixá-lo automaticamente na pasta `vendor/`.

---

### 7. Instalação, remoção e uso de pacotes

O Composer facilita não só a instalação, mas também a remoção e o uso de pacotes em seu projeto.

#### Instalar um pacote

Para instalar um pacote, utilize o comando:

```bash
composer require nome/da-biblioteca
```

Exemplo:
```bash
composer require phpmailer/phpmailer
```

#### Remover um pacote

Para remover um pacote (por exemplo, `phpmailer/phpmailer`), execute:

```bash
composer remove phpmailer/phpmailer
```

Isso atualizará o arquivo `composer.json` e removerá a dependência automaticamente do projeto.

#### Usar um pacote no seu código

Depois de instalar, basta garantir a presença do autoload:

```php
require 'vendor/autoload.php';

// Agora você pode instanciar classes do pacote instalado:
$mail = new PHPMailer\PHPMailer\PHPMailer();
```

**Dica:** Consulte a documentação da biblioteca para exemplos de uso e namespaces específicos.

---

### 8. Modo de desenvolvimento

Durante o desenvolvimento, execute o comando abaixo sempre que alterar o `composer.json` ou quiser atualizar dependências:

```bash
composer install    # instala as dependências
composer update     # atualiza as dependências existentes
```

---

### 9. Repositório de dependências

Os pacotes baixados pelo Composer ficam na pasta `vendor/`.  
**Não altere arquivos dessa pasta manualmente.**

---

## Resumo

O Composer organiza as bibliotecas utilizadas, carrega as classes automaticamente e facilita a manutenção do projeto PHP.
