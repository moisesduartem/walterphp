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
    private array $data;

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
        $this->setData($data);
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
        $cmdExp = '/{\%.+\%\}/';
        if ($cmdsFound = preg_match_all($cmdExp, $this->getHtmlFile()) > 0):
            $this->inheritanceFunc();
        endif;
    }
    /**
     * Verifica se existe a função de herança.
     * @return string $HTMLReposition
     */
    private function inheritanceFunc(): string
    {
        $HTMLReposition = '';

        $inhExp = '/{\%.+extends.+\%\}/';
        $extendsDeclaration = [];
        if ($haveExtends = preg_match($inhExp, $this->getHtmlFile(), $extendsDeclaration)):
            $extendsWithoutKeys = substr($extendsDeclaration[0], 2, strlen($extendsDeclaration[0]) - 4);
            $parentFileWithQM = trim(str_replace('extends', '', $extendsWithoutKeys));
            $parentFileName = substr($parentFileWithQM, 1, strlen($parentFileWithQM) -2);
            $childrenContent = str_replace($extendsDeclaration[0], '', $this->getHtmlFile());
            
            if (file_exists($this->path . $parentFileName)):
                $parentFileContent = file_get_contents($this->path . $parentFileName);
                $HTMLReposition = preg_replace('/{\%.+children.+\%\}/', $childrenContent, $parentFileContent);
                $this->setHtmlFile($HTMLReposition);
            endif;
        endif;

        return $HTMLReposition;
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
     * @param array $data
     * @return array $this->data
     */
    private function setData(array $data): array
    {   
        $this->data = $data;
        return $this->data;
    }
    
    /**
     * @return array $this->data
     */
    private function getData(): array
    {   
        return $this->data;
    }

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