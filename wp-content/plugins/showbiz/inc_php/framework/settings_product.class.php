<?php


	class UniteSettingsBizProductBiz extends UniteSettingsOutputBiz{
		
		/**
		 * draw text as input
		 */
		protected function drawTextInput($setting) {
			$disabled = "";
			$style="";
			$readonly = "";
			
			if(isset($setting["style"])) 
				$style = "style='".$setting["style"]."'";
			if(isset($setting["disabled"])) 
				$disabled = 'disabled="disabled"';
				
			if(isset($setting["readonly"])){
				$readonly = "readonly='readonly'";
			}
			
			$class = "regular-text";
						
			if(isset($setting["class"]) && !empty($setting["class"])){
				$class = $setting["class"];
				
				//convert short classes:
				switch($class){
					case "small":
						$class = "small-text";
					break;
					case "code":
						$class = "regular-text code";
					break;
				}
			}
				
			if(!empty($class))
				$class = "class='$class'";
			
			?>
				<input type="text" <?php echo $class?> <?php echo $style?> <?php echo $disabled?><?php echo $readonly?> id="<?php echo $setting["id"]?>" name="<?php echo $setting["name"]?>" value="<?php echo $setting["value"]?>" />
			<?php
		}
		
		
		/**
		 * 
		 * draw imaeg input:
		 * @param $setting
		 */
		protected function drawImageInput($setting){
			
			$class = UniteFunctionsBiz::getVal($setting, "class");
			
			if(!empty($class))
				$class = "class='$class'";
			
			$settingsID = $setting["id"];
			
			$buttonID = $settingsID."_button";
			$buttonID_remove = $settingsID."_button_remove";
			
			$spanPreviewID = $buttonID."_preview";
			
			$width = UniteFunctionsBiz::getVal($setting, "width",100);
			$height = UniteFunctionsBiz::getVal($setting, "height",70);
			
			$img = "";
			$value = UniteFunctionsBiz::getVal($setting, "value");
			
			$urlImage = "";
			if(!empty($value)){
				
				if(is_numeric($value)){
					
					$arrImage = UniteFunctionsWPBiz::getAttachmentImage($value, UniteFunctionsWPBiz::THUMB_MEDIUM);
					if(!empty($arrImage)){
						$urlImage = $arrImage["url"];
						$width = $arrImage["width"];
						$height = $arrImage["height"];
					}
					
				}else{		//take by image url
					$urlImage = $value;
					$imagePath = UniteFunctionsWPBiz::getImageRealPathFromUrl($urlImage);
					/*if(file_exists($imagePath)){
						$filepath = UniteFunctionsWPBiz::getImagePathFromURL($urlImage);
						$urlImage = UniteBaseClassBiz::getImageUrl($filepath,$width,$height,true);
					}*/
				}
				
			}
			
			$style = "width:{$width}px;height:{$height}px;";
			if(!empty($urlImage))
				$style .= "background-image:url('$urlImage');";
			
			?>
				<span id='<?php echo $spanPreviewID?>' class='setting-image-preview' style="<?php echo $style?>"><?php echo $img?></span>
				
					<input type="hidden" id="<?php echo $setting["id"]?>" name="<?php echo $setting["name"]?>" data-width="<?php echo $width?>" data-height="<?php echo $height?>" value="<?php echo $setting["value"]?>" />
					
					<input type="button" style="width:auto !important" id="<?php echo $buttonID?>" class='button-image-select <?php echo $class?>' value="Choose Image"></input>
					<input type="button" style="width:auto !important" id="<?php echo $buttonID_remove?>" class='button-image-remove <?php echo $class?>' value="Remove Image"></input>
			<?php
		}
		
		
		/**
		 * 
		 * draw color picker input
		 */
		protected function drawColorPickerInput($setting){			
			$bgcolor = $setting["value"];
			$bgcolor = str_replace("0x","#",$bgcolor);			
			// set the forent color (by black and white value)
			$rgb = UniteFunctionsBiz::html2rgb($bgcolor);
			$bw = UniteFunctionsBiz::yiq($rgb[0],$rgb[1],$rgb[2]);
			$color = "#000000";
			if($bw<128) $color = "#ffffff";
			
			
			$disabled = "";
			if(isset($setting["disabled"])){
				$color = "";
				$disabled = 'disabled="disabled"';
			}
			
			$style="style='background-color:$bgcolor;color:$color'";
			
			?>
				<input type="text" class="inputColorPicker" id="<?php echo $setting["id"]?>" <?php echo $style?> name="<?php echo $setting["name"]?>" value="<?php echo $bgcolor?>" <?php echo $disabled?>></input>
			<?php
		}
		
		/**
		 * 
		 * draw inputs
		 * @throws Exception
		 */
		protected function drawInputs($setting){
			switch($setting["type"]){
				case UniteSettingsBiz::TYPE_TEXT:
					$this->drawTextInput($setting);
				break;
				case UniteSettingsBiz::TYPE_COLOR:
					$this->drawColorPickerInput($setting);
				break;
				case UniteSettingsBiz::TYPE_SELECT:
					$this->drawSelectInput($setting);
				break;
				case UniteSettingsBiz::TYPE_CHECKBOX:
					$this->drawCheckboxInput($setting);
				break;
				case UniteSettingsBiz::TYPE_RADIO:
					$this->drawRadioInput($setting);
				break;
				case UniteSettingsBiz::TYPE_TEXTAREA:
					$this->drawTextAreaInput($setting);
				break;
				case UniteSettingsBiz::TYPE_EDITOR:
					$this->drawEditorInput($setting);
				break;
				case UniteSettingsBiz::TYPE_ORDERBOX:
					$this->drawOrderbox($setting);
				break;
				case UniteSettingsBiz::TYPE_ORDERBOX_ADVANCED:
					$this->drawOrderbox_advanced($setting);
				break;
				case UniteSettingsBiz::TYPE_IMAGE:
					$this->drawImageInput($setting);
				break;
				case UniteSettingsBiz::TYPE_CUSTOM:
					if(method_exists($this,"drawCustomInputs") == false){
						UniteFunctionsBiz::throwError("Method don't exists: drawCustomInputs, please override the class");
					}
					$this->drawCustomInputs($setting);
				break;
				default:
					throw new Exception("wrong setting type - ".$setting["type"]);
				break;
			}			
		}		
		
		
		/**
		 * 
		 * draw text area input
		 */
		protected function drawTextAreaInput($setting){
			
			$disabled = "";
			if (isset($setting["disabled"])) $disabled = 'disabled="disabled"';
			
			$style = "";
			if(isset($setting["style"]))
				$style = "style='".$setting["style"]."'";

			$rows = UniteFunctionsBiz::getVal($setting, "rows");
			if(!empty($rows))
				$rows = "rows='$rows'";
				
			$cols = UniteFunctionsBiz::getVal($setting, "cols");
			if(!empty($cols))
				$cols = "cols='$cols'";
			
			?>
				<textarea id="<?php echo $setting["id"]?>" name="<?php echo $setting["name"]?>" <?php echo $style?> <?php echo $disabled?> <?php echo $rows?> <?php echo $cols?>  ><?php echo $setting["value"]?></textarea>
			<?php
			if(!empty($cols))
				echo "<br>";	//break line on big textareas.
		}	

		
		/**
		 * 
		 * draw the editor input
		 */
		protected function drawEditorInput($setting){
			
			$disabled = "";
			if (isset($setting["disabled"])) $disabled = 'disabled="disabled"';
			
			$style = "";
			if(isset($setting["style"]))
				$style = "style='".$setting["style"]."'";

			$rows = UniteFunctionsBiz::getVal($setting, "rows","7");
			if(!empty($rows))
				$rows = "rows='$rows'";
				
			$value = UniteFunctionsBiz::getVal($setting, "value");
			$id = UniteFunctionsBiz::getVal($setting, "id");
			
			$settings = array();
			$settings["media_buttons"] = false;
			$settings["textarea_rows"] = $rows;
			
			wp_editor($value, $id, $settings);
			
			if(!empty($cols))
				echo "<br>";	//break line on big textareas.
			
		}		
		
		
		
		//-----------------------------------------------------------------------------------------------
		// draw checkbox
		protected function drawCheckboxInput($setting){
			
			$value = UniteFunctionsBiz::getVal($setting, "value");
			
			$checked = "";
			if($value === true || $value == "true" || $value == "on")			
				 	$checked = 'checked="checked"';
			
			?>
				<input type="checkbox" id="<?php echo $setting["id"]?>" class="inputCheckbox" name="<?php echo $setting["name"]?>" <?php echo $checked?>/>
			<?php
		}		
		
		//-----------------------------------------------------------------------------------------------
		//draw select input
		protected function drawSelectInput($setting){
			
			$className = "";
			if(isset($this->arrControls[$setting["name"]])) 
				$className = "control";
				
			$class = "";
			if($className != "") $class = "class='".$className."'";
			
			$disabled = "";
			if(isset($setting["disabled"])) $disabled = 'disabled="disabled"';
			
			$args = UniteFunctionsBiz::getVal($setting, "args");
			
			$settingValue = $setting["value"];
			
			if(strpos($settingValue,",") !== false)
				$settingValue = explode(",", $settingValue);
				
			?>
			<select id="<?php echo $setting["id"]?>" name="<?php echo $setting["name"]?>" <?php echo $disabled?> <?php echo $class?> <?php echo $args?>>
			<?php
			foreach($setting["items"] as $value=>$text):
				//set selected
				$selected = "";
				$addition = "";
				if(strpos($value,"option_disabled") === 0){
					$addition = "disabled";					
				}else{
					if(is_array($settingValue)){
						if(array_search($value, $settingValue) !== false) 
							$selected = 'selected="selected"';
					}else{
						if($value == $settingValue) 
							$selected = 'selected="selected"';
					}
				}
									
				
				?>
					<option <?php echo $addition?> value="<?php echo $value?>" <?php echo $selected?>><?php echo $text?></option>
				<?php
			endforeach
			?>
			</select>
			<?php
		}
		
		
		//-----------------------------------------------------------------------------------------------
		//draw hr row
		protected function drawTextRow($setting){
			
			//set cell style
			$cellStyle = "";
			if(isset($setting["padding"])) 
				$cellStyle .= "padding-left:".$setting["padding"].";";
				
			if(!empty($cellStyle))
				$cellStyle="style='$cellStyle'";
				
			//set style
			$rowStyle = "";					
			if(isset($setting["hidden"])) 
				$rowStyle .= "display:none;";
				
			if(!empty($rowStyle))
				$rowStyle = "style='$rowStyle'";
			
			?>
				<tr id="<?php echo $setting["id_row"]?>" <?php echo $rowStyle ?> valign="top">
					<td colspan="2" <?php echo $cellStyle?>>
						<span class="settings_static_text"><?php echo $setting["text"]?></span>
					</td>
				</tr>
			<?php 
		}
		
		//-----------------------------------------------------------------------------------------------
		//draw hr row
		protected function drawHrRow($setting){
			//set hidden
			$rowStyle = "";
			if(isset($setting["hidden"])) $rowStyle = "style='display:none;'";
			
			$class = UniteFunctionsBiz::getVal($setting, "class");
			if(!empty($class))
				$class = "class='$class'";
			
			?>
			<tr id="<?php echo $setting["id_row"]?>" <?php echo $rowStyle ?>>
				<td colspan="4" align="left" style="text-align:left;">
					 <hr <?php echo $class; ?> /> 
				</td>
			</tr>
			<?php 
		}
		
		
		/**
		 * 
		 * draw settings row
		 */
		protected function drawSettingRow($setting,$drawRowMarkup = true){
		
			$name = $setting["name"];
			
			//set cellstyle:
			$cellStyle = "";
			if(isset($setting[UniteSettingsBiz::PARAM_CELLSTYLE])){
				$cellStyle .= $setting[UniteSettingsBiz::PARAM_CELLSTYLE];
			}
			
			//set text style:
			$textStyle = $cellStyle;
			if(isset($setting[UniteSettingsBiz::PARAM_TEXTSTYLE])){
				$textStyle .= $setting[UniteSettingsBiz::PARAM_TEXTSTYLE];
			}
			
			if($textStyle != "") $textStyle = "style='".$textStyle."'";
			if($cellStyle != "") $cellStyle = "style='".$cellStyle."'";
			
			//set hidden
			$rowStyle = "";
			if(isset($setting["hidden"])) $rowStyle = "display:none;";
			if(!empty($rowStyle)) $rowStyle = "style='$rowStyle'";
			
			//set text class:
			$class = "";
			if(isset($setting["disabled"])) $class = "class='disabled'";
			
			//modify text:
			$text = UniteFunctionsBiz::getVal($setting,"text","");				
			// prevent line break (convert spaces to nbsp)
			$text = str_replace(" ","&nbsp;",$text);
			switch($setting["type"]){					
				case UniteSettingsBiz::TYPE_CHECKBOX:
					$text = "<label for='".$setting["id"]."' style='cursor:pointer;'>$text</label>";
				break;
			}			
			
			$addHtml = UniteFunctionsBiz::getVal($setting, UniteSettingsBiz::PARAM_ADDTEXT);			
			$addHtmlBefore = UniteFunctionsBiz::getVal($setting, UniteSettingsBiz::PARAM_ADDTEXT_BEFORE_ELEMENT);
			
			//set settings text width:
			$textWidth = "";
			if(isset($setting["textWidth"])) $textWidth = 'width="'.$setting["textWidth"].'"';
			
			$description = UniteFunctionsBiz::getVal($setting, "description");
			$required = UniteFunctionsBiz::getVal($setting, "required");
			$unit = UniteFunctionsBiz::getVal($setting, "unit");
			
			?>
				<?php if($drawRowMarkup == true):?>
				<tr id="<?php echo $setting["id_row"]?>" <?php echo $rowStyle ?> <?php echo $class?> valign="top">
					<th <?php echo $textStyle?> scope="row" <?php echo $textWidth ?>>
						<?php echo $text?>:
					</th>
					<td <?php echo $cellStyle?>>
				<?php endif?>
				
						<?php if(!empty($addHtmlBefore)):?>
							<span class="settings_addhtmlbefore"><?php echo $addHtmlBefore?></span>
						<?php endif?>
					
						<?php 
							$this->drawInputs($setting);
						?>						
						<?php if(!empty($required)):?>
							<span class='setting_required'>*</span>
						<?php endif?>
						
						<?php if(!empty($addHtml)):?>
							<span class="settings_addhtml"><?php echo $addHtml?></span>
						<?php endif?>
																	
						<?php if(!empty($description)):?>
							<span class="description"><?php echo $description?></span>
						<?php endif?>	
						
						<?php if(!empty($unit)):?>
							<span class='setting_unit'><?php echo $unit?></span>
						<?php endif?>
						
						<?php
							//draw joined output
							if(isset($this->arrJoinOutput[$name])){
								$arrKeys = $this->arrJoinOutput[$name];
								foreach($arrKeys as $key){
									$joinedSetting = $this->arrSettings[$key];
									$this->drawSettingRow($joinedSetting,false);
								}
							}							
						?>
						
			<?php if($drawRowMarkup == true):?>						
					</td>
				</tr>
			<?php endif?>
			<?php 
		}
		
		//-----------------------------------------------------------------------------------------------
		//draw all settings
		public function drawSettings(){
			$this->drawHeaderIncludes();
			$this->prepareToDraw();
			
			//draw main div
			$lastSectionKey = -1;
			$visibleSectionKey = 0;
			$lastSapKey = -1;
			
			$arrSections = $this->settings->getArrSections();
			$arrSettings = $this->settings->getArrSettings();
			$this->arrSettings = $arrSettings;
			
			//draw settings - simple
			if(empty($arrSections)):
					?><table class='form-table'><?php
					foreach($arrSettings as $key=>$setting){
						
						//bypass joined output (when some setting is joined to another setting)
						if(array_key_exists(UniteSettingsBiz::PARAM_OUTPUTWITH, $setting))
							continue;
						
						switch($setting["type"]){
							case UniteSettingsBiz::TYPE_HR:
								$this->drawHrRow($setting);
							break;
							case UniteSettingsBiz::TYPE_STATIC_TEXT:
								$this->drawTextRow($setting);
							break;
							default:
								$this->drawSettingRow($setting);
							break;
						}
					}
					?></table><?php					
			else:
			
				//draw settings - advanced - with sections
				foreach($arrSettings as $key=>$setting):
								
					//operate sections:
					if(!empty($arrSections) && isset($setting["section"])){										
						$sectionKey = $setting["section"];
												
						if($sectionKey != $lastSectionKey):	//new section					
							$arrSaps = $arrSections[$sectionKey]["arrSaps"];
							
							if(!empty($arrSaps)){
								//close sap
								if($lastSapKey != -1):
								?>
									</table>
									</div>
								<?php						
								endif;							
								$lastSapKey = -1;
							}
							
					 		$style = ($visibleSectionKey == $sectionKey)?"":"style='display:none'";
					 		
					 		//close section
					 		if($sectionKey != 0):
					 			if(empty($arrSaps))
					 				echo "</table>";
					 			echo "</div>\n";	 
					 		endif;					 		
					 		
							//if no saps - add table
							if(empty($arrSaps)):
							?><table class="form-table"><?php
							endif;								
						endif;
						$lastSectionKey = $sectionKey;
					}//end section manage
					
					//operate saps
					if(!empty($arrSaps) && isset($setting["sap"])){				
						$sapKey = $setting["sap"];
						if($sapKey != $lastSapKey){
							$sap = $this->settings->getSap($sapKey,$sectionKey);
							
							//draw sap end					
							if($sapKey != 0): ?>
							</table>
							<?php endif;
							
							//set opened/closed states:
							//$style = "style='display:none;'";
							$style = "";
							
							$class = "divSapControl";
							
							if($sapKey == 0 || isset($sap["opened"]) && $sap["opened"] == true){
								$style = "";
								$class = "divSapControl opened";						
							}
							
							?>
								<div id="divSapControl_<?php echo $sectionKey."_".$sapKey?>" class="<?php echo $class?>">
									
									<h3><?php echo $sap["text"]?></h3>
								</div>
								<div id="divSap_<?php echo $sectionKey."_".$sapKey?>" class="divSap" <?php echo $style ?>>				
								<table class="form-table">
							<?php 
							$lastSapKey = $sapKey;
						}
					}//saps manage
					
					//draw row:
					switch($setting["type"]){
						case UniteSettingsBiz::TYPE_HR:
							$this->drawHrRow($setting);
						break;
						case UniteSettingsBiz::TYPE_STATIC_TEXT:
							$this->drawTextRow($setting);
						break;
						default:
							$this->drawSettingRow($setting);
						break;
					}					
				endforeach;
			endif;	
			 ?>
			</table>
			
			<?php
			if(!empty($arrSections)):
				if(empty($arrSaps))	 //close table settings if no saps 
					echo "</table>";
				echo "</div>\n";	 //close last section div
			endif;
			
		}
		
		
		//-----------------------------------------------------------------------------------------------
		// draw sections menu
		public function drawSections($activeSection=0){
			if(!empty($this->arrSections)):
				echo "<ul class='listSections' >";
				for($i=0;$i<count($this->arrSections);$i++):
					$class = "";
					if($activeSection == $i) $class="class='selected'";
					$text = $this->arrSections[$i]["text"];
					echo '<li '.$class.'><a onfocus="this.blur()" href="#'.($i+1).'"><div>'.$text.'</div></a></li>';
				endfor;
				echo "</ul>";
			endif;
				
			//call custom draw function:
			if($this->customFunction_afterSections) call_user_func($this->customFunction_afterSections);
		}
		
		/**
		 * 
		 * draw settings function
		 * @param $drawForm draw the form yes / no
		 */
		public function draw($formID=null,$drawForm = false){
			if(empty($formID))
				UniteFunctionsBiz::throwError("The form ID can't be empty. you must provide it");
				
				$this->formID = $formID;
				
			?>
				<div class="settings_wrapper unite_settings_wide">
			<?php
			
			if($drawForm == true){
				?>
				<form name="<?php echo $formID?>" id="<?php echo $formID?>">
					<?php $this->drawSettings() ?>
				</form>
				<?php 				
			}else
				$this->drawSettings();
			
			?>
			</div>
			<?php 
		}

		
	}
?>