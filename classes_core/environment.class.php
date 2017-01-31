<?php
	class Environment
	{
		protected static $_instance = null;
		
		protected $_options = array();
		
		protected $_sims = array();
		
		
		public static function instance( $options )
		{
			if( self::$_instance )
				return self::$_instance;
			
			self::$_instance = new Environment($options);
			
			return self::$_instance;
		}
		
		
		protected function __construct( $options = array() )
		{
			$this->_options = $options;
		}
		
		public function init()
		{
			$config_required = array(
				'iter',
				'sims',
			);
			
			foreach( $config_required as $key_required )
			{
				if(
					array_key_exists($key_required, $this->_options)
					&& $this->_options[$key_required]
				){
					continue;
				}
				
				throw new Exception('missing required configuration value "'.$key_required.'"');
			}
			
			for( $count_sims = 0; $count_sims < $this->_options['sims']; $count_sims++ )
			{
				$sim = new Simulant($this);
				
				while( $this->sim_exists($sim->name()) )
					$sim = new Simulant();
				
				$this->sim_add($sim, $sim->name());
			}
			
			for( $count_iter = 0; $count_iter < $this->_options['iter']; $count_iter++ )
			{
				foreach( $this->_sims as $sim )
				{
					$sim->iterate();
				}
			}
			
		}
		
		public function sim_add( Simulant $sim = null, $handle = null )
		{
			if( ! $sim )
				throw new Exception('null simulant not allowed');
			
			if( ! $handle )
				throw new Exception('null handle not allowed');
			
			if( $this->sim_exists($handle) )
				throw new Exception('duplicate handle "'.$handle.'" not allowed');
			
			$this->_sims[$handle] = $sim;
			
			return true;
		}
		
		public function sim_exists( $handle = null )
		{
			if( ! $handle )
				throw new Exception('must specify handle');
			
			return array_key_exists($handle, $this->_sims);
		}
		
		public function sim_neighbors( $handle = null )
		{
			$names = array_keys($this->_sims);
			
			$name_last = null;
			
			$neighbor_last = null;
			$neighbor_next = null;
			
			foreach( $names as $name )
			{
				if( $name == $handle )
				{
					$neighbor_last = $name_last;
				}
				
				if( $neighbor_last == $name_last )
				{
					$neighbor_next = $name;
				}
				
				$name_last = $name;
			}
			
			return array(
				$neighbor_last,
				$neighbor_next,
			);
		}
		
		public function sim_remove( $handle = null )
		{
			if( ! $this-sim_exists($handle) )
				throw new Exception('handle "'.$handle.'" not found');
			
			$this->_sims[$handle] = null;
		}
		
		public function sims_list()
		{
			return $this->_sims;
		}
		
	}
	
