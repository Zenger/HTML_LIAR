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
            
			self::Childrens($html);
        }
        
        public static function Childrens($html , $index = null)
        {
            $children = $html->children();
            
            if (!empty($children))
            {
                foreach($children as $k => $i)
                {
                    $class = (!empty($i->{'class'})) ? explode(" " , $i->{'class'} ) : false;
					$id = (!empty($i->id)) ? $i->id : false;
					print_r(parent::$css_rules);
					
					// /* @TODO:Work this path */
					// if ($class !== false) { 
					
						// echo "HAS CLASS : " . $i->{'class'} ;
						
						// $_i = 0;
					
						// while($_i < count($class))
						// {
							// $space = (count($class) > 1) ? " " : "";
							// $new_class .= str_replace('.' , '' , parent::$css_rules[".".$class[$_i]] ) . $space;
							// $_i++;
						// }
						
						// echo "  REPLACED WITH : ". $new_class . "<br />";
					
					// }
					
					
					
					
					if ($i->children() <> 0) self::Childrens($i , $k);
                }
            }
        }
    }
?>