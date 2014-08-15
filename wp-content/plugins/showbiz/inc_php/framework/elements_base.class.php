<?php

	class UniteElementsBaseBiz{
		
		protected $db;
		
		public function __construct(){
			
			$this->db = new UniteDBBiz();
		}
		
	}

?>