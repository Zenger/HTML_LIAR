<?php
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	
	define("HTMLiar_Version" , "0.2.4"); // Project Version
	
	define('WORD_LENGTH', 40); // set max characters in words (will be moved in config soon)
	
	define("HTMLiar_Write_Folder" , "ENCODED_HTML"); // Folder name
	
	define("UGLIFY_HTML" , true); // removes comments, new lines in HTML
	define("UGLIFY_CSS"  , true); // removes comments, new lines in CSS
	define("UGLIFY_JS"   , true); // soon
	
	define("HTMLiar_Location_NoFolder" , dirname(dirname(__FILE__)) .DIRECTORY_SEPARATOR );
	define("HTMLiar_Location" ,  HTMLiar_Location_NoFolder . basename(dirname(__FILE__) ) );
	
	
	define("__show_generator" , true);
	define("__generator_string", "Generated with HTMLiar ". HTMLiar_Version . ". Project at https://github.com/Zenger/HTML_LIAR");
	
	require('liar.css.php');
	require('liar.html.php');
	
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
		
		/* Helper function , checks if sring is empty or not and replaces with a default value */
		public static function df( $string , $default = "")
		{
			$string = trim($string);
			return (empty($string)) ? $default : $string;
		}
		
		
		public static function initApp()
		{
		
			// Create folder and make it writable
			if (!file_exists( HTMLiar_Write_Folder ))
			{
				if (!mkdir( HTMLiar_Write_Folder , '0777'))
				{
					die("Can't create folder for job. You can create folder at '".HTMLiar_Write_Folder."'. ");
				}
				@chmod(HTMLiar_Write_Folder , '0777'); //just for easyness
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
			
			
			// Now parse CSS and replace css and id with new Classes and Id's
			foreach(self::$config['css']['css'] as $cssFile)
			{
				try
				{
					HTMLie_CSS::Map($cssFile);
				}
				catch (Exception $e)
				{
					echo $e->getMessage();
				}
			}
		
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
		
		public static function Create_Dir( $file )
		{
			$realpath = realpath($file);
			$path = str_replace( array( HTMLiar_Location_NoFolder , basename($file)  ), '' , $realpath);
			$path = HTMLiar_Location . DIRECTORY_SEPARATOR . HTMLiar_Write_Folder. DIRECTORY_SEPARATOR .  $path;
			@mkdir( $path , 0777 , true );
		}	
		
		public static function File_Location( $fileLocation )
		{
			$path = HTMLiar_Location . DIRECTORY_SEPARATOR . FOLDER . DIRECTORY_SEPARATOR;
			if (!file_exists( $fileLocation) )
			{
				throw new Exception("File doesn't exist at " . $fileLocation . " . <br /> Check file paths in config");
				return false;
			}
			else
			{
				$writepath = HTMLiar_Location . DIRECTORY_SEPARATOR . HTMLiar_Write_Folder . DIRECTORY_SEPARATOR;
				$realpath =  str_replace(HTMLiar_Location_NoFolder , $writepath  , realpath( $fileLocation ) );
				
				return $realpath;
				
			}
		}
	}
	
	HTMLiar::RunApplication();
?>