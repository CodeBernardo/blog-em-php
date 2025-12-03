# Blog PHP – Projeto de Estudo

Projeto em PHP desenvolvido para estudar conceitos fundamentais da linguagem, incluindo sintaxe, orientação a objetos, namespaces e uso do Composer.

## 📋 Sobre o Projeto

Este projeto serve como um ambiente de aprendizado e prática de PHP, contendo exemplos de código, documentação e uma estrutura básica de sistema. O projeto utiliza tipagem estrita, autoload PSR-4 via Composer e está organizado em módulos de aprendizado.

## 🚀 Pré-requisitos

- **PHP 8.0 ou superior** (o projeto utiliza tipagem estrita e recursos do PHP 8)
- **Composer** (para gerenciamento de dependências e autoload)
- **Servidor web local** configurado (ex.: XAMPP, Laragon) ou PHP embutido

## 📦 Instalação

1. Clone ou copie este diretório para o `htdocs` (ou pasta pública equivalente do seu servidor).

2. Instale as dependências do Composer:
```bash
composer install
```

3. Inicie o servidor:
   - **XAMPP**: Inicie o Apache através do painel de controle
   - **PHP embutido**: Execute `php -S localhost:8000` no diretório do projeto

4. Acesse `http://localhost/blog` no navegador.

## 📁 Estrutura do Projeto

```
blog/
├── index.php              # Ponto de entrada da aplicação
├── composer.json          # Configuração do Composer e autoload
├── README.md              # Este arquivo
│
├── Learning/              # Documentação e exemplos de aprendizado
│   ├── Basics.md         # Conceitos básicos de PHP (tipagem, funções, arrays, etc.)
│   ├── Classes.md        # Orientação a objetos e namespaces
│   └── Composer.md       # Documentação sobre o Composer
│
├── system/                # Sistema e configurações
│   ├── config.php        # Configurações da aplicação (timezone, URLs)
│   └── Core/             # Classes principais do sistema (PSR-4)
│
└── vendor/               # Dependências instaladas pelo Composer
    └── autoload.php      # Autoloader do Composer
```

## 🔧 Configuração

O arquivo `system/config.php` contém as configurações básicas:
- Timezone: `America/Sao_Paulo`
- URL de desenvolvimento: `http://localhost/blog`
- URL de produção: `https://Tech/blog`

## 📚 Documentação de Aprendizado

O projeto inclui documentação detalhada em Markdown na pasta `Learning/`:

- **Basics.md**: Cobre conceitos fundamentais como:
  - Tipagem estrita
  - Funções e concatenação de strings
  - Variáveis e tipos de dados
  - Constantes (`define`, `const`)
  - Estruturas condicionais e de repetição
  - Arrays e iterações
  - Filtros de validação
  - Geração de slugs

- **Classes.md**: Explica:
  - Namespaces em PHP
  - Orientação a objetos
  - Uso de classes e métodos

- **Composer.md**: Documentação sobre:
  - Gerenciamento de dependências
  - Autoload PSR-4
  - Comandos básicos do Composer

## 🛠️ Autoload PSR-4

O projeto está configurado com autoload PSR-4 no `composer.json`:
- Namespace `system\` mapeado para o diretório `system/`

Para usar classes do sistema:
```php
require 'vendor/autoload.php';

use system\Core\MinhaClasse;
```

## 👤 Autor

**Bernardo Stein**
- Email: stein.bernardo@proton.me

## 📝 Próximos Passos Sugeridos

- [ ] Implementar exemplos práticos de classes em `system/Core/`
- [ ] Adicionar testes com PHPUnit
- [ ] Criar sistema de rotas básico
- [ ] Implementar exemplos de banco de dados
- [ ] Adicionar mais documentação e exemplos práticos

## 📄 Licença

Este é um projeto de estudo e aprendizado. Sinta-se livre para adaptar e usar conforme necessário!

---

**Nota**: Este projeto está em constante evolução como ferramenta de aprendizado. Contribuições e sugestões são bem-vindas!
