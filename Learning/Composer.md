# Composer: Gerenciador de Dependências em PHP

O **Composer** é um gerenciador de dependências para projetos PHP. Ele permite declarar, instalar e atualizar facilmente as bibliotecas das quais o seu projeto depende, facilitando a organização e manutenção das dependências de terceiros.

---

## Principais vantagens do Composer

- Instala e atualiza automaticamente bibliotecas e frameworks necessários ao seu projeto
- Controla versões dos pacotes, evitando conflitos de dependências
- Utiliza o arquivo `composer.json` para gerenciar informações e dependências do projeto
- Permite o autoload automático de classes via PSR-4 ou outras especificações

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

### 4. Como usar o autoload no seu código

Antes de utilizar as classes do seu projeto, inclua a linha:
```php
require 'vendor/autoload.php';
```
Isso faz com que todas as classes cadastradas no autoload do Composer sejam carregadas automaticamente.

---

### 5. Instalação de dependências de terceiros

Para instalar algum pacote (por exemplo, `monolog/monolog`), use:
```bash
composer require monolog/monolog
```
O Composer irá adicionar o pacote ao `composer.json` e baixá-lo automaticamente na pasta `vendor/`.

---

### 6. Modo de desenvolvimento

Durante o desenvolvimento, execute o comando abaixo sempre que alterar o `composer.json` ou quiser atualizar dependências:

```bash
composer install    # instala as dependências
composer update     # atualiza as dependências existentes
```

---

### 7. Repositório de dependências

Os pacotes baixados pelo Composer ficam na pasta `vendor/`.  
**Não altere arquivos dessa pasta manualmente.**

---

## Resumo

O Composer organiza as bibliotecas utilizadas, carrega as classes automaticamente e facilita a manutenção do projeto PHP.
