<?php

App::uses('TwigView', 'TwigView.View');

class CompileTemplatesShell extends Shell {
    
    private $TwigView;
    
    public function __construct($stdout = null, $stderr = null, $stdin = null) {
        parent::__construct($stdout, $stderr, $stdin);
        
        $this->TwigView = new TwigView();
    }
    
    public function all() {
        $plugins = CakePlugin::loaded();
        foreach ($plugins as $plugin) {
            
            if (!is_dir(CakePlugin::path($plugin) . 'View' . DS)) {
                continue;
            }
            
            $iterator = new RegexIterator(new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator(
                    CakePlugin::path($plugin) . 'View' . DS,
                    FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::SKIP_DOTS
                ),
                RecursiveIteratorIterator::CHILD_FIRST,
                RecursiveIteratorIterator::CATCH_GET_CHILD
            ), '/.*?.tpl$/', RegexIterator::GET_MATCH);

            foreach ($iterator as $paths) {
                foreach ($paths as $path) {
                    $this->file($path);
                }
            }
            
        }
    }
    
    public function file($fileName) {
        try {
            $this->TwigView->Twig->loadTemplate($fileName); 
            $this->out('<success>' . $fileName . '</success>');
        } catch (Exception $e) {
            $this->out('<error>' . $fileName . '</error>');
            $this->out($e->getMessage());
        }
    }
    
    function getOptionParser() {
        $parser = parent::getOptionParser();
        $parser->addSubcommand('all', array(
            'short' => 'a',
            'help' => __('Searches and compiles all twig templates it finds to JS.')
        ))->description(__('Twig to JS compiler.'));
        return $parser;
    }
}