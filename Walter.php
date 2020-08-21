<?php

/**
 *_____________________________________*
 *|                                    |
 *| Walter PHP Template Engine.        |
 *| 2020 - Moisés Mariano Duarte Maia  |
 *| github.com/moisesduartem/walterphp |
 *|____________________________________|
 */

class Walter
{
    private string $path;
    private string $filePath;
    private string $htmlFile;

    public function __construct(string $path) {
        $this->path = $path;
    }
    /**
     * @param string $view
     * @param array $data
     * @return string $htmlFile
     */
    public function render(string $view, array $data = []): string
    {
        /* Seta diretório 'path/arquivo.php'. */
        $this->setFilePath($this->path . $view . '.php');
        /* Recebendo o conteúdo HTML do diretório como string. */
        $this->setHtmlFile(file_get_contents($this->filePath));
        /* Procura comandos no arquivo */
        $this->searchCommandsOnFile();
        /* Percorre o array de dados */
        $this->checkDataOnFile($data);
        /**
         * Exibe a saída em HTML da string contendo a página/view.
         */
        echo $this->getHtmlFile();
        return $this->getHtmlFile();
    }

    private function checkDataOnFile($data): void
    {
        foreach ($data as $key => $value):
            /* Expressão regular que busca '$nomeDaVariavelNoArray' */
            $dollarExp = '/\$' .$key .'/';
            /* Expressão regular que busca '{{ nomeDaVariavelNoArray }}' */
            $mustacheExp = '/\{\{.+' .$key .'.+\}\}/';
            /* Se for uma string */
            if (gettype($data[$key]) == 'string'):
                /* Se existir no arquivo substitui na variavel $htmlFile */ 
                if (preg_match($dollarExp, $this->getHtmlFile()))
                $this->replaceDataOnFile($dollarExp, $value, $this->getHtmlFile());
                if (preg_match($mustacheExp, $this->getHtmlFile()))
                $this->replaceDataOnFile($mustacheExp, $value, $this->getHtmlFile());
            endif;
        endforeach;
    }

    private function searchCommandsOnFile()
    {
        // $forExp = '/\[.+for.+]/';
        // $matches = [];
        // if (preg_match($forExp, $this->getHtmlFile())):
        //     preg_match_all($forExp, $this->getHtmlFile(), $matches);
        //     foreach ($matches as $key => $value):
        //         // $arr = [];
        //         // echo preg_match_all('', $matches[$key][0]);
        //     endforeach;
        // endif;

        // print_r($matches);
        // echo preg_replace($forExp, $value, $this->getHtmlFile);
        //     $this->replaceDataOnFile($dollarExp, $value, $this->getHtmlFile());
    }

    /**
     * @param string $expression RegEx
     * @param int|float|bool|string $value Valor da Substituição
     * @param string $file Arquivo HTML em string
     */
    private function replaceDataOnFile(string $expression, $value, string $file): bool
    {
        return $this->setHtmlFile(preg_replace($expression, $value, $file));            
    }

    /**____________________*
     *|                    |
     *| GETTERS & SETTERS  |
     *|____________________|
     */

    /**  
     * @param string $filePath
     * @return string $this->filePath
     */
    private function setFilePath(string $filePath): string
    {   
        $this->filePath = $filePath;
        return $this->filePath;
    }
    
    /**
     * @return string $this->filePath
     */
    private function getFilePath(): string
    {   
        return $this->filePath;
    }
    
    /**
     * @param string $htmlFile
     * @return string $this->htmlFile
     */
    private function setHtmlFile($htmlFile): string
    {
        $this->htmlFile = $htmlFile;
        return $this->htmlFile;
    }

    /**
     * @return string $this->htmlFile
     */
    private function getHtmlFile(): string
    {
        return $this->htmlFile;
    }
}