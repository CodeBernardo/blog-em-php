<?php
require __DIR__ . '/vendor/autoload.php';

use system\Core\MarkdownReader;

$reader = new MarkdownReader();
$files = $reader->listFiles();

// Se um arquivo específico foi solicitado
$content = null;
$currentFile = null;

if (isset($_GET['file'])) {
    $currentFile = $_GET['file'];
    $content = $reader->getContent($currentFile);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Documentação PHP - Aprendizado</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f6f7fb;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width:1440px;
            margin: 0 auto;
            padding: 2rem;
        }

        header {
            background: #324f81;
            color: white;
            padding: 2rem;
            margin-bottom: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            box-sizing: border-box;
        }

        header h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            text-align: center;
            width: 100%;
        }
        header p {
            text-align: center;
            width: 100%;
        }

        .layout {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 2rem;
        }

        .sidebar {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            height: fit-content;
            position: sticky;
            top: 2rem;
        }

        .sidebar h2 {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            color: #324f81;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar li {
            margin-bottom: 0.5rem;
        }

        .sidebar a {
            display: block;
            padding: 0.75rem;
            color: #555;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .sidebar a:hover {
            background: #e7f0fa;
            color: #324f81;
        }

        .sidebar a.active {
            background: #324f81;
            color: white;
        }

        .content {
            background: white;
            padding: 2rem;
            max-width: 1200px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .content h1 {
            color: #324f81;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e7f0fa;
        }

        .content h2 {
            color: #324f81;
            margin-top: 2rem;
            margin-bottom: 1rem;
        }

        .content h3 {
            color: #555;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }

        .content code {
            background: #f4f4f4;
            padding: 0.2rem 0.4rem;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
        }

        .content pre {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 1rem;
            border-radius: 4px;
            overflow-x: auto;
            margin: 1rem 0;
            position: relative;
        }

        .content pre code {
            background: none;
            padding: 0;
            color: inherit;
            font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
            font-size: 0.9em;
            line-height: 1.5;
        }

        /* Estilos para Highlight.php (HLJS) */
        .content pre code.hljs {
            display: block;
            overflow-x: auto;
            padding: 0.5em;
        }

        /* Cores do tema GitHub Dark (compatível com Highlight.php) */
        .content .hljs {
            color: #e1e4e8;
            background: #24292e;
        }

        .content .hljs-comment,
        .content .hljs-quote {
            color: #6a737d;
            font-style: italic;
        }

        .content .hljs-keyword,
        .content .hljs-selector-tag,
        .content .hljs-type {
            color: #f97583;
        }

        .content .hljs-string,
        .content .hljs-literal {
            color: #9ecbff;
        }

        .content .hljs-number {
            color: #79b8ff;
        }

        .content .hljs-variable,
        .content .hljs-template-variable {
            color: #e1e4e8;
        }

        .content .hljs-function,
        .content .hljs-title {
            color: #b392f0;
        }

        .content .hljs-attr {
            color: #ffab70;
        }

        .content .hljs-tag {
            color: #85e89d;
        }

        .content .hljs-name {
            color: #79b8ff;
        }

        .content .hljs-built_in {
            color: #ffab70;
        }

        .content .hljs-class {
            color: #b392f0;
        }

        .content .hljs-operator {
            color: #f97583;
        }

        .content .hljs-punctuation {
            color: #e1e4e8;
        }

        .content .hljs-property {
            color: #79b8ff;
        }

        .content .hljs-attribute {
            color: #ffab70;
        }

        .content blockquote {
            border-left: 4px solid #324f81;
            padding-left: 1rem;
            margin: 1rem 0;
            color: #666;
            font-style: italic;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }

        .content table th,
        .content table td {
            padding: 0.75rem;
            border: 1px solid #ddd;
            text-align: left;
        }

        .content table th {
            background: #324f81;
            color: white;
        }

        .welcome {
            text-align: center;
            padding: 3rem 2rem;
        }

        .welcome h2 {
            color: #324f81;
            margin-bottom: 1rem;
        }

        .welcome p {
            color: #666;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
            }
            header {
                padding: 1.5rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📚 Documentação PHP</h1>
            <p>Conteúdo de aprendizado e referência</p>
        </header>

        <div class="layout">
            <aside class="sidebar">
                <h2>Conteúdo</h2>
                <ul>
                    <?php if (empty($files)): ?>
                        <li>Nenhum arquivo encontrado</li>
                    <?php else: ?>
                        <?php foreach ($files as $file): ?>
                            <li>
                                <a href="?file=<?= urlencode($file['name']) ?>" 
                                   class="<?= ($currentFile === $file['name']) ? 'active' : '' ?>">
                                    <?= htmlspecialchars($file['title']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </aside>

            <main class="content">
                <?php if ($content): ?>
                    <?= $content ?>
                <?php else: ?>
                    <div class="welcome">
                        <h2>Bem-vindo à Documentação!</h2>
                        <p>Selecione um tópico no menu lateral para começar.</p>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>
</body>
</html>
