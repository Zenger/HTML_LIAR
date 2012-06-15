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
		
			/**
				@TODO: Write logic -> Build mapped array of data
					[.link] => '.q_QWei12',
					[#facebook'] => '#hywyqq12'
			**/
			$content = $this->content;
			
			$safe_tags = array(
			
				'html',	'body', 'div', 'span', 'applet', 'object', 'iframe','h1', 'h2', 'h3', 
				'h4', 'h5', 'h6', 'p', 'blockquote', 'pre','a', 'abbr', 'acronym', 'address',
				'big', 'cite','code','del', 'dfn', 'em', 'img', 'ins', 'kbd', 'q', 's', 'samp',
				'small', 'strike', 'strong', 'sub', 'sup', 'tt', 'var','b', 'u', 'i', 'center',
				'dl', 'dt', 'dd', 'ol', 'ul', 'li','fieldset', 'form', 'label', 'legend','table', 
				'caption', 'tbody', 'tfoot', 'thead', 'tr', 'th', 'td','article', 'aside', 'canvas',
				'details', 'embed', 'figure', 'figcaption', 'footer', 'header', 'hgroup','menu',
				'nav', 'output', 'ruby', 'section', 'summary','time', 'mark', 'audio', 'video',
				'article', 'aside', 'details', 'figcaption', 'figure','footer', 'header', 'hgroup',
				'menu', 'nav', 'section', 'input', 'em' , 'pre' , // html usable tags
				
				'xml','script','link', 'style','title','meta', 'head', // non usable tags
				
				// Forgot 
				'applet', 'area', 'base','basefont','bdo', 'button', 'colgroup', 'dir', 'font',
				'frame', 'frameset', 'hr' , 'ins', 'isindex', 'map', 'noframes', 'noscript',
				'optgroup', 'option', 'param', 'select', 'textarea'
			);
			
			// $results = array();
			$replaces = array(
				'/(?:\r\n|\n|\r)+/is', // replaces new lines
				'/\/\*.+?\*\//is', // removes comments
			);
			
			
			foreach($replaces as $regex)
			{
			
				$content = preg_replace( $regex, '', $content );
			}
			
			//$content = preg_replace( '#\/\*.+\*\/#' , '' , $content);
			
			//$content  = preg_replace($replaces , '', $content);
			print_r($content);
			
			
			// if (preg_match_all( '/(\n|\r)/is' , $content , $matches ) )
			// {
				// print_r($matches);
			// }

			// preg_match_all('/(.+?)\s?\{\s?(.+?)\s?\}/', $content, $matches);
			// foreach($matches[0] AS $i=>$original)
				// foreach(explode(';', $matches[2][$i]) AS $attr)
						// if (strlen($attr) > 0) // for missing semicolon on last element, which is legal
						// {
								// list($name, $value) = explode(':', $attr);
								// $results[$matches[1][$i]][trim($name)] = trim($value);
						// }
			// print_r( $results );

			
		}
		
		public function ReplaceCSSClass()
		{
			
		}
	}
?>