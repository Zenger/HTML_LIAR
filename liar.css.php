<?php 
class HTMLie_CSS extends HTMLiar
{

	public static function Map($cssFile)
	{
		/* Grab content */
		$cssContent = file_get_contents($cssFile);
		
		// ParseCSS
		
		$cssContent = self::ParseCSS ( $cssContent );
		
		/* Uglify */
		if (UGLIFY_CSS == true)
		{
		     $cssContent = self::Uglify_Css($cssContent);
		}
		
		if (__show_copyright)
		{
			$cssContent = "/* ".__generator_string." */" . PHP_EOL . $cssContent;
			$cssContent .= PHP_EOL ."/* ".__generator_string." */";
		}
		
		
		// Write location
		$writeLocation = HTMLiar::File_Location($cssFile);
		// Check if folder exists and will be writeable
		if (! file_exists( str_replace( basename($cssFile)  , '' , $writeLocation  ) ) )
		{
			HTMLiar::Create_Dir( $cssFile ); 
		}
		
		file_put_contents( HTMLiar::File_Location($cssFile) , $cssContent );
	    
	}
	
	public static function parseCSS( $content )
	{
		foreach(parent::$css_rules as $rule => $replace)
		{
			// yep :)
			$content = str_replace ( $rule , $replace , $content );
		}
		return $content;
	}
	
	public static function Uglify_Css($content)
	{
		
		$replaces = array(
			'/(?:\r\n|\n|\r)+/is', // replaces new lines
			'/\/\*.+?\*\//is', // removes comments
		);
		
		
		foreach($replaces as $regex)
		{
		
			$content = preg_replace( $regex, '', $content );
		}
		
		return $content;
	}
}
?>