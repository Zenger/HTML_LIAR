<?php
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	
	
	define('WORD_LENGTH', 40); // set max characters in words (will be moved in config soon)
	
	define("FOLDER" , "ENCODED_HTML"); // Folder name
	
	
	define("UGLIFY_HTML" , true); // removes comments, new lines
			
	require('liar.css.php');
	require('liar.html.php');
	require('HTMLiar.parser.php');
	
	class HTMLiar
	{
		static $config;
		
		static $css_rules = array();
		
		public static function RunApplication()
		{
			self::$config = parse_ini_file('config.ini', true);
			if (!empty(self::$config))
			{
				self::initApp();
			}
		}
		
		
		public static function initApp()
		{
		
			// Create folder and make it writable
			if (!file_exists( FOLDER ))
			{
				if (!mkdir( FOLDER , '0777'))
				{
					die("Can't create folder for job. You can create folder at '".FOLDER."'. ");
				}
				@chmod(FOLDER , '0777'); //just for easyness
			}
			
			// Parse HTML Files Build Map of css classes and #ids
			foreach(self::$config['html']['html'] as $htmlFile)
			{
				try
				{
					HTMLie_HTML::Map($htmlFile);
				}
				catch (Exception $e)
				{
					echo $e->getMessage();
				}
			}
			
			/* Walks in dom, replaces css, id's, based on generated map */
			//HTMLie_HTML::ReplaceHTML();
			
			/* After the CSS Map is built, this parses all the HTML and JS and replaces the css classes with new ones, and minyfies */
			/*
			try
			{
				HTMLiarParser::RunParser();
				
			}
			catch(Exception $e)
			{
				echo "ERROR : " . $e->getMessage();
				
			}
			*/
		}
		
		
		/*
		  Generates a valid class name
		  @param $language You can send php, js, css. If css is used it will safely use the "-" symbol
		*/
		public function generateRandomName($language = "php")
		{
			$ln = array(
				'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z', // letters
				'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z', // letters caps
				'0','1','2','3','4','5','6','7','8','9', //numbers
				'_' , 
			);
			
			if ($language == "css") $ln[] = "-";
		
			
			// start with a letter 
			$name = $ln[mt_rand(0, 45)];
			//set word length
			$length = mt_rand(5 , WORD_LENGTH);
			
			$i = 0;
			
			
			while ($i < $length)
			{
				
				$name .= $ln[mt_rand(0,count($ln))];
				
				$i++;
			}
			
			return $name;
		}
		
		
	}
	
	HTMLiar::RunApplication();
?>