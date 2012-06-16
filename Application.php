<?php
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	
	require('liar.css.php');
	
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
			
			//print_r(self::$css_rules);
		}
	}
	
	HTMLiar::RunApplication();
?>