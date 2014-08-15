<?php

	class ShowBizSettingsProduct extends UniteSettingsBizProductBiz{
		
		
		
		private static function getFirstCategory($cats){
						
			foreach($cats as $key=>$value){
				if(strpos($key,"option_disabled") === false)
					return($key);
			}
			return("");
		}		
		
		
		/**
		 * set category by post type, with specific name (can be regular or woocommerce)
		 */
		public static function setCategoryByPostTypes(UniteSettingsBiz $settings,$arrValues, $postTypesWithCats,$nameType,$nameCat,$defaultType){
			
			//update the categories list by the post types
			$postTypes = UniteFunctionsBiz::getVal($arrValues, $nameType ,$defaultType);
			if(strpos($postTypes, ",") !== false)
				$postTypes = explode(",",$postTypes);
			else
				$postTypes = array($postTypes);
			
			$arrCats = array();
			$globalCounter = 0;	
			
			$arrCats = array();
			$isFirst = true;
			
			foreach($postTypes as $postType){
				$cats = UniteFunctionsBiz::getVal($postTypesWithCats, $postType,array());
				if($isFirst == true){
					$firstValue = self::getFirstCategory($cats);
					$isFirst = false; 
				}
					
				$arrCats = array_merge($arrCats,$cats);
			}
			
			$settingCategory = $settings->getSettingByName($nameCat);
			$settingCategory["items"] = $arrCats;
			$settings->updateArrSettingByName($nameCat, $settingCategory);

			//update value to first category
			$value = $settings->getSettingValue($nameCat);
			if(empty($value)){
				
				$settings->updateSettingValue($nameCat, $firstValue);
			}
			
			return($settings);
		}
		
		
		/**
		 * 
		 * set custom values to settings
		 */
		public static function setSettingsCustomValues(UniteSettingsBiz $settings,$arrValues, $postTypesWithCats){
			
			$settings = self::setCategoryByPostTypes($settings, $arrValues, $postTypesWithCats, "post_types", "post_category","post");
			
			if(UniteFunctionsWooCommerceBiz::isWooCommerceExists())
				$settings = self::setCategoryByPostTypes($settings, $arrValues, $postTypesWithCats, "wc_post_types", "wc_post_category","product");
			
			return($settings);
		}
		

		/**
		 * 
		 * draw slider size
		 */
		protected function drawSliderSize($setting){
			
			$width = UniteFunctionsBiz::getVal($setting, "width");
			$height = UniteFunctionsBiz::getVal($setting, "height");
			
			?>
			
			<table>
				<tr>
					<td id="cellWidth">
						Slider Width:
					</td>
					<td id="cellWidthInput">
						<input id="width" name="width" type="text" class="textbox-small" value="<?php echo $width?>">
					</td>
					<td id="cellHeight">
						Slider Height: 
					</td>
					<td>
						<input id="height" name="height" type="text" class="textbox-small" value="<?php echo $height?>">
					</td>					
				
				</tr>
			</table>
			
			<?php 
		}
		
		
		
		/**
		 * 
		 * draw custom inputs for rev slider
		 * @param $setting
		 */
		protected function drawCustomInputs($setting){
			
			$customType = UniteFunctionsBiz::getVal($setting, "custom_type");
			switch($customType){
				case "slider_size":
					$this->drawSliderSize($setting);
				break;
				default:
					UniteFunctionsBiz::throwError("No handler function for type: $customType");
				break;
			}			
		}
		
	}

?>