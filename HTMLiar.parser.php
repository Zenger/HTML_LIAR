<?php
    class HTMLiarParser extends HTMLiar
    {
        
        
        public static function RunParser()
        {
           
            try
            {
                 /* Replace CSS classes */
                self::ReplaceCSS();
                
                /* Replace CSS classes in HTML Files */
                self::ReplaceHTML();
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
                die();
            }
            return true;
        }
        
        
        public static function ReplaceCSS()
        {
            $config = parent::$config;
            
            if (empty($config))
            {
                throw new Exception("Something is wrong, the config is empty!");
            }
            
            //assure files exists and are writable
            self::__exists_writable($config['css']['css']);
            
            $cssFiles = $config['css']['css'];
            
            foreach($cssFiles as $cssFile)
            {
                /* Grab content */
                $content = file_get_contents($cssFile);
                /* Remove Comments, new lines */
                $content = HTMLie_CSS::CleanCSS($content);
                /* Replace all classes with new ones */
                foreach(parent::$css_rules as $css => $replacement)
                {
                    $content = str_replace($css , $replacement, $content);
                }
                
                /* Write */
              /*
				$fh = fopen($cssFile, 'w');
                fwrite($fh, $content);
                fclose($fh); 
			   */
            }
            
        }
        
        
        public static function ReplaceHTML()
        {
            $config = parent::$config;
            
            if (empty($config))
            {
                throw new Exception("Something is wrong, the config is empty!");
            }
            
            //assure files exists and are writable
            self::__exists_writable($config['html']['html']);
            
            $htmlFiles = $config['html']['html'];
            
            foreach($htmlFiles as $htmlFile)
            {
                /* Grab content */
                $content = file_get_contents($htmlFile);
                /* Remove Comments, new lines 
                $content = HTMLie_HTML::CleanHTML($content); */
               
                /* Replace all classes with new ones */
                $content = HTMLie_HTML::ReplaceHTML($content);
                
                /* Write */
               // $fh = fopen($cssFile, 'w');
                //fwrite($fh, $content);
                //fclose($fh);
            }
        }
        
        /* This is a helper function , runs through the array of files, checks if exist and are writable and throws an error  */
        public static function __exists_writable(array $files)
        {
            foreach($files as $file)
            {
                
                if (!file_exists($file))
                {
                   
                    throw new Exception("File $file doesn't exist!");
                }
                
                if (!is_writeable($file))
                {
                    throw new Exception("File $file is not writable!");
                }
            }
        }
            
    }
?>