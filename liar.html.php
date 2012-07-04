<?php

    require('libs/simple_html_dom/simple_html_dom.php');
    
    class HTMLie_HTML extends HTMLiar
    {
       
        
        public static function Uglify_Html($content = null)
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
        
        
        public static function Map($htmlFile)
        {
            /* Grab content */
            $htmlContent = file_get_contents($htmlFile);
            /* Throw content to simple_html_dom */
            $htmlDom = new simple_html_dom($htmlContent);
            $html = $htmlDom->getElementByTagName('html');
            
            /* Walk the dom and map the data to a parent var */
            self::MapWalk($html);
            
            /* Save the new file */
            
           $content = $htmlDom->save();
           if (UGLIFY_HTML == true)
           {
                $content = self::Uglify_Html($content);
           }
	   
	   if (__show_generator)
	   {
		$content = "<!-- ".__generator_string." -->". PHP_EOL . $content;
		$content .= PHP_EOL . "<!-- ".__generator_string." -->";
	   }
	   
           file_put_contents( HTMLiar::File_Location( $htmlFile ) , $content );
	   
            
        }
        /* Walks the children recursively
          @param $html supplie the starting point (usually the <html> tag as index)
          @param $index the key index, required for recursive walk
        */
        public static function MapWalk($html , $index = null)
        {
            $children = $html->children();
            if (!empty($children))
            {
                foreach($children as $k => $i)
                {
                    
                    $class = (!empty($i->{'class'})) ? explode(" " , $i->{'class'} ) : false;
                    $id = (!empty($i->id)) ? $i->id : false;
                    
                    if ($class)
                    {
                         /* walk dom, find class or id, try to search it's value in array, if it doesn't exist in global array, append a new name,
                           and replace the class with new name */
                           
                        foreach($class as $single_class)
                        {
               
                            /* Give logical names to existing, and new class*/
                            $__new_class = "." . $single_class;
                            $__new_replace = "." . HTMLiar::generateRandomName("css");
                            
                            /* If class doesn't exist in parent array, insert it and giv it logical replacement */
                            
                            if (!in_array($__new_class , parent::$css_rules))
                            {
                                 /* Keep Classes for further files */
                                parent::$css_rules[$__new_class] = $__new_replace;
                                $set_of_classes .= str_replace(".", "", $__new_replace) . " ";
                            }
                            else
                            {
                                $set_of_classes .= str_replace(".", "", parent::$css_rules[$__new_class] ) . " ";
                            }
                        
                           
                        }
                        
                        
                        $i->{'class'} = trim($set_of_classes);
                    }

                    if ($id)
                    {
                            /* Give logical names to existing, and new class*/
                            $__new_id = "#" . $id;
                            $__new_replace = "#" . HTMLiar::generateRandomName("css");
                            
                            /* If class doesn't exist in parent array, insert it and giv it logical replacement */
                            
                            if (!in_array($__new_id , parent::$css_rules))
                            {
                                 /* Keep Classes for further files */
                                parent::$css_rules[$__new_id] = $__new_replace;
                                $set_of_id .= str_replace("#","", $__new_replace);
                            }
                            else
                            {
                                $set_of_id .= str_replace("#","", parent::$css_rules[$__new_id]);
                            }
                        $i->id = $set_of_id;
                    }
                    
                    
                    if ($i->children() <> 0) self::MapWalk($i , $k);
                }
            }
        }
        
        
      
    }
?>