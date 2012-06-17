<?php
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	
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
			/* Parses all CSS files and builds a map of Linked CSS rules */
			foreach(self::$config['css']['css'] as $cssFile)
			{
				try
				{
					$parse_state =  HTMLie_CSS::Init( $cssFile );
					if (! $parse_state  )
					{
						throw new Exception('Couldn\'t parse ' . $cssFile);
					}
				}
				catch (Exception $e)
				{
					echo $e->getMessage();
				}
			}
			
			/* After the CSS Map is built, this parses all the HTML and JS and replaces the css classes with new ones, and minyfies */
			
			try
			{
				HTMLiarParser::RunParser();
				
			}
			catch(Exception $e)
			{
				echo "ERROR : " . $e->getMessage();
				
			}
		}
		
		
		
	}
	
	HTMLiar::RunApplication();
?>