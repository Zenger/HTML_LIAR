<?php 

	define('MINIFY' , true);
	
	require('libs/css_parser/cssparser.php');
	
	class HTMLie_CSS
	{
	
		var $content = "";
		var $parseInstance;
		
		public function __construct($cssFile)
		{	
		
			if (!file_exists($cssFile)) 
			{
				throw new Exception('File not found : '. $cssFile);
				return false;
			}
			else
			{	
				$content = file_get_contents($cssFile);
				if (empty($content))
				{
					throw new Exception('Empty CSS file supplied : '.$cssFile);
					return;
				}
				else
				{
					$this->content = $content;
					
					$this->run(); // init logic
				}
			}
		}
		
		
		public function run()
		{
			$content = $this->content;
			
			$results = array();

			preg_match_all('/(.+?)\s?\{\s?(.+?)\s?\}/', $content, $matches);
			foreach($matches[0] AS $i=>$original)
				foreach(explode(';', $matches[2][$i]) AS $attr)
						if (strlen($attr) > 0) // for missing semicolon on last element, which is legal
						{
								list($name, $value) = explode(':', $attr);
								$results[$matches[1][$i]][trim($name)] = trim($value);
						}
			print_r( $results );

			
		}
		
		public function ReplaceCSSClass()
		{
			
		}
	}
?>