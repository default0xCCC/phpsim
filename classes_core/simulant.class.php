<?php
	class Simulant
	{
		protected $_name = null;
		
		protected $_world = null;
		
		
		public function __construct( $world = null )
		{
			$this->_world = $world;
		}
		
		
		public function name()
		{
			if( $this->_name )
				return $this->_name;
			
			$names = array(
				'Alpha',
				'Bravo',
				'Charlie',
				'Delta',
				'Echo',
				'Foxtrot',
				'Golf',
				'Hotel',
				'Indigo',
				'Juliet',
				'Kilo',
				'Lima',
				'Mike',
				'November',
				'Oscar',
				'Papa',
				'Quebec',
				'Romeo',
				'Sierra',
				'Tango',
				'Uniform',
				'Victor',
				'Yankee',
				'Zulu',
			);
			
			$this->_name = $names[rand(0, count($names)-1)].rand(1,1000);
			
			return $this->_name;
		}
		
		public function iterate()
		{
			var_dump($this->_world->sim_neighbors($this->_name));
			die();
			// TODO
		}
		
	}
	
