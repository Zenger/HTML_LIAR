<?php 
	require('liar.css.php');
	
	class HTMLiar
	{
		static $config;
		
		public static function run()
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
					$parse_state =  new HTMLie_CSS( $cssFile );
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
		}
	}
	
	HTMLiar::run();
?>