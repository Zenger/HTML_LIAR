<?php 

	define('MINIFY' , true);
	

	
	class HTMLie_CSS extends HTMLiar
	{
	
		static $content = "";
		static $parseInstance;
		
		
		
		public function Init($cssFile)
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
					self::$content = $content;
					
					return self::RunParseCSS(); // init logic
				}
			}
		}
		
		
		
		public function RunParseCSS()
		{

			$content = self::$content;
			
			$css_rules = array();
			
			
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
				'menu', 'nav', 'section', 'input', 'em' , 'pre' , // html usable tags and HTML5 tags
				
				'xml','script','link', 'style','title','meta', 'head', // non usable tags
				
				// Updated HTML Tags (even deprecated)
				'applet', 'area', 'base','basefont','bdo', 'button', 'colgroup', 'dir', 'font',
				'frame', 'frameset', 'hr' , 'ins', 'isindex', 'map', 'noframes', 'noscript',
				'optgroup', 'option', 'param', 'select', 'textarea',
				
				// Unnecessary CSS rules
				'active','after','before','checked','disabled','empty','enabled','first-child','first-letter',
				'first-line','first-of-type','focus','hover','lang','last-child','last-of-type','link','not',
				'nth-child','nth-last-child','nth-last-of-type','nth-of-type','only-child','only-of-type','root',
				'target','visited'

			);
			
			$content = self::CleanCSS($content);
			 /* @TODO: Work this , must fix so it grabs \- */
			 preg_match_all('/((\w|\-)+)?(\s*>\s*)?(#(\w|\-)+)?\s*(\.(\w|\-)+)?\s*{/Uis', $content, $matches);
			 //preg_match_all('/((\w|\-)+)?((\s|\-)*>(\s|\-)*)?(#(\w|\-)+)?(\s|\-)*(\.(\w|\-)+)?(\s|\-)*{/is', $content, $matches);
			
			 foreach($matches[0] AS $i=>$original) {
				
				/* Replace the leading semicolon, and tabs in classnames */
				$css = str_replace(array("{" , "\t") , "", $original);
				
				echo $css . "<br />";
				
				if (!empty($css))
				{
					if (!in_array( $css ,parent::$css_rules ))
					{
						// UPDATE
						/* It happens there is a class a.padding and it's being captured, we'll make sure to grab .padding */
						$match = preg_match('/(\.|\#)\w*$/is' , $css , $matches);
						if (empty($matches[0])) continue;

						/* Send match to parent */	  /* is a class or id */       /* random name */
						parent::$css_rules[$matches[0]] = substr($matches[0] , 0, 1) .self::generateRandomName("css");
					}
				}
			 }
			
			
			
			// remove all the safe tags from the css rules
			
			foreach(parent::$css_rules as $i=>$css_item)
			{
				
				if (in_array($i, $safe_tags))
				{
					unset(parent::$css_rules[$i]);
					
				}
			}
			
			
			return true;	
		}		
		public function ReplaceCSSClass()
		{
					
			/**
				@TODO: Write logic -> Take mapped items and replace them in *.html , *.js, *.xml or whatever the user supplies
			**/
		}
		
		
		public function CleanCSS($content)
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