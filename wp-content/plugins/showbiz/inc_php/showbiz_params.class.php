<?php

	/**
	 * 
	 * get / update params in db
	 *
	 */

	class ShowBizParams extends UniteElementsBaseBiz{
		
		
		/**
		 * 
		 * update settign in db
		 */		
		public function updateFieldInDB($name,$value){
			
			$arrUpdate = array();
			$arrUpdate["general"] = "";
			$arrUpdate[$name] = $value;
			
			$arr = $this->db->fetch(GlobalsShowBiz::$table_settings);
			if(empty($arr)){	//insert to db
				$this->db->insert(GlobalsShowBiz::$table_settings,$arrUpdate);
			}else{	//update db
				$id = $arr[0]["id"];
				$this->db->update(GlobalsShowBiz::$table_settings,$arrUpdate,array("id"=>$id));
			}
		}
		
		/**
		 * 
		 * get field from db
		 */
		public function getFieldFromDB($name){
			
			$arr = $this->db->fetch(GlobalsShowBiz::$table_settings);
			
			//dmp("maxim");exit();
			
			if(empty($arr))
				return("");
				
			
			$arr = $arr[0];
			
			if(array_key_exists($name, $arr) == false && $name !== 'general')
				UniteFunctionsBiz::throwError("The settings db should cotnain field: $name");
			
			$value = @$arr[$name];
			return($value);
		}
		
		
	}

?>