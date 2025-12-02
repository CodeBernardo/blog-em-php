<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Minha Aplicação PHP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background: #f6f7fb; 
            margin: 0; 
            padding: 0;
        }
        header {
            background: #324f81;
            color: white;
            padding: 1.2rem;
            text-align: center;
        }
        main {
            max-width: 600px; 
            margin: 2rem auto; 
            background: white; 
            border-radius: 8px; 
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 2rem;
        }
        .php-output {
            padding: .8rem 1.2rem;
            margin-top: 1.2rem;
            background: #e7f0fa;
            border-left: 4px solid #324f81;
            font-family: 'Fira Mono', 'Courier', monospace;
        }
    </style>
</head>
<body>
    <header>
        <h1>Bem-vindo ao Projeto PHP</h1>
        <p>Arquivo de inicialização do sistema</p>
    </header>
    <main>
        <?php 
        include 'Learning/Basics.php';
        require 'system/config.php';
        ?>
        <h2>Concatenação de Strings em PHP</h2>
        <p>Exemplo usando a função <code>concatString</code>:</p>
        <div class="php-output">
        </div>
    </main>
</body>
</html>
