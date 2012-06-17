<?php

    require('libs/simple_html_dom/simple_html_dom.php');
    
    class HTMLie_HTML extends HTMLiar
    {
        /*$str = '<h1>T1</h1>Lorem ipsum.<h1>T2</h1>The quick red fox...<h1>T3</h1>... jumps over the lazy brown FROG';
            $DOM = new DOMDocument;
            $DOM->loadHTML($str);
        */
        
        public static function CleanHTML($content = null)
        {
                $replaces = array(
                        '/(?:\r\n|\n|\r)+/is', // replaces new lines
                        '/\/\*.+?\*\//is', // removes CSS comments
                        '/<!--(.*)-->/Uis' // Removes HTML comments
                );	
                
                
                foreach($replaces as $regex)
                {
                
                        $content = preg_replace( $regex, '', $content );
                }
                
                
                /* Remove tabs */
                $content = str_replace("\t",'', $content);
                
                return $content;
        }
        
        
        public static function ReplaceHTML($content)
        {
            $htmlDom = new simple_html_dom($content);
            
            $html = $htmlDom->getElementByTagName('html');
            
            $parse = self::Childrens($html);
        }
        
        public static function Childrens($html)
        {
            $children = $html->childNodes();
            
            if (!empty($children))
            {
                foreach($children as $i)
                {
                    
                }
            }
        }
    }
?>