<?php

namespace system\Core;

use Parsedown;
use Highlight\Highlighter;

class MarkdownReader
{
    private Parsedown $parser;
    private Highlighter $highlighter;
    private string $learningPath;
    private bool $useSyntaxHighlighting;

    public function __construct(bool $useSyntaxHighlighting = true)
    {
        $this->parser = new Parsedown();
        $this->highlighter = new Highlighter();
        $this->learningPath = __DIR__ . '/../../Learning/';
        $this->useSyntaxHighlighting = $useSyntaxHighlighting;
    }

    /**
     * Lista todos os arquivos Markdown na pasta Learning
     * @return array Array com informações dos arquivos
     */
    public function listFiles(): array
    {
        $files = [];
        $path = $this->learningPath;

        if (!is_dir($path)) {
            return $files;
        }

        $items = scandir($path);
        
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $filePath = $path . $item;
            
            if (is_file($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'md') {
                $files[] = [
                    'name' => $item,
                    'title' => $this->getTitleFromFile($filePath),
                    'slug' => $this->createSlug($item),
                    'path' => $filePath
                ];
            }
        }

        return $files;
    }

    /**
     * Lê e converte um arquivo Markdown para HTML
     * @param string $filename Nome do arquivo (com ou sem .md)
     * @return string HTML renderizado
     */
    public function getContent(string $filename): string
    {
        // Garante que o arquivo tenha extensão .md
        if (!str_ends_with($filename, '.md')) {
            $filename .= '.md';
        }

        $filePath = $this->learningPath . $filename;

        if (!file_exists($filePath)) {
            return '<p>Arquivo não encontrado.</p>';
        }

        $markdown = file_get_contents($filePath);
        $html = $this->parser->text($markdown);
        
        // Aplica syntax highlighting nos blocos de código
        if ($this->useSyntaxHighlighting) {
            $html = $this->highlightCodeBlocks($html);
        }
        
        return $html;
    }

    /**
     * Aplica syntax highlighting nos blocos de código usando Highlight.php
     * @param string $html HTML gerado pelo Parsedown
     * @return string HTML com syntax highlighting aplicado
     */
    private function highlightCodeBlocks(string $html): string
    {
        // Encontra todos os blocos <pre><code>
        $pattern = '/<pre><code(?:\s+class="language-(\w+)")?>([\s\S]*?)<\/code><\/pre>/';
        
        return preg_replace_callback($pattern, function ($matches) {
            $language = $matches[1] ?? null;
            $code = html_entity_decode($matches[2], ENT_QUOTES, 'UTF-8');
            
            // Remove espaços em branco extras
            $code = trim($code);
            
            if (empty($code)) {
                return $matches[0];
            }
            
            try {
                // Tenta detectar a linguagem automaticamente se não especificada
                if (empty($language)) {
                    $language = 'auto';
                }
                
                // Mapeia alguns nomes comuns de linguagens
                $languageMap = [
                    'php' => 'php',
                    'javascript' => 'javascript',
                    'js' => 'javascript',
                    'json' => 'json',
                    'html' => 'xml',
                    'xml' => 'xml',
                    'css' => 'css',
                    'sql' => 'sql',
                    'bash' => 'bash',
                    'shell' => 'bash',
                    'python' => 'python',
                    'java' => 'java',
                    'c' => 'c',
                    'cpp' => 'cpp',
                    'csharp' => 'csharp',
                    'go' => 'go',
                    'rust' => 'rust',
                ];
                
                $highlightLanguage = $languageMap[strtolower($language)] ?? $language;
                
                if ($highlightLanguage === 'auto') {
                    $highlighted = $this->highlighter->highlightAuto($code);
                } else {
                    $highlighted = $this->highlighter->highlight($highlightLanguage, $code);
                }
                
                $highlightedCode = $highlighted->value;
                $detectedLanguage = $highlighted->language ?? $language;
                
                return sprintf(
                    '<pre><code class="hljs language-%s">%s</code></pre>',
                    htmlspecialchars($detectedLanguage),
                    $highlightedCode
                );
            } catch (\Exception $e) {
                // Se houver erro, retorna o código original
                return $matches[0];
            }
        }, $html);
    }

    /**
     * Obtém o título do arquivo (primeira linha com #)
     * @param string $filePath Caminho do arquivo
     * @return string Título do arquivo
     */
    private function getTitleFromFile(string $filePath): string
    {
        $content = file_get_contents($filePath);
        $lines = explode("\n", $content, 2);
        
        if (isset($lines[0]) && str_starts_with(trim($lines[0]), '#')) {
            return trim(str_replace('#', '', $lines[0]));
        }

        return pathinfo($filePath, PATHINFO_FILENAME);
    }

    /**
     * Cria um slug a partir do nome do arquivo
     * @param string $filename Nome do arquivo
     * @return string Slug
     */
    private function createSlug(string $filename): string
    {
        $name = pathinfo($filename, PATHINFO_FILENAME);
        $name = strtolower($name);
        $name = preg_replace('/[^a-z0-9]+/', '-', $name);
        return trim($name, '-');
    }
}

