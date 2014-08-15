<?php

/**
 * 
 *
 * @version $Id$
 * @copyright 2003 
 **/
class rhlogin_admin_form_renderer {
	var $debug = false;
	var $cb_get_option;
	function rhlogin_admin_form_renderer($cb_get_option=false){
		$this->cb_get_option = $cb_get_option;
	}
	
	function get_option($name,$default='',$default_if_empty=true){
		if(is_callable($this->cb_get_option)){
			$str = call_user_func($this->cb_get_option,$name,$default,$default_if_empty);
			//----
			global $rhl_plugin;
			$upload_dir = wp_upload_dir();					
			$dcurl = $upload_dir['baseurl'].'/'.$rhl_plugin->resources_path.'/';
			$str = str_replace('{dcurl}',$dcurl,$str);			
			//----	
			return $str;
		}else if($default_if_empty){
			return $default;
		}	
		return '';
	}
	
	function render($option,$option_i=null,$options=null,$options_i=null){
		$method = 'render_'.$option->input_type;
		$method = method_exists($this,$method)?$method:'render_text';
		$this->$method($option, $option_i ,$options, $options_i );	
		//echo "<p><br /><pre>".print_r($option,true)."</pre></p>";
	}
	
	function render_grid_start($option,$option_i=null,$options=null,$options_i=null){
?>
<div class="row-fluid <?php $this->input_extra_class($option,$option_i,$options,$options_i)?>">
<?php
	}

	function render_toggle_button($option,$option_i=null,$options=null,$options_i=null){
		$name = property_exists($option,'name')?$option->name:$option->id;
?>
	<button id="<?php echo $option->id?>" type="button" data-toggle="button" class="btn input-field-input <?php $this->input_extra_class($option,$option_i,$options,$options_i)?>" <?php $this->input_extra_properties($option,$option_i,$options,$options_i)?> ><?php echo $option->label?></button>
<?php		
	}

	function render_font($option,$option_i=null,$options=null,$options_i=null){
		$name = property_exists($option,'name')?$option->name:$option->id;
		$unit = property_exists($option,'unit')?$option->unit:false;
?>
<div id="<?php echo $option->id?>-holder" class="input-field <?php $this->holder_extra_class($option) ?>">
	<span class="field-label label-for-<?php echo $option->input_type?> label-for-<?php echo $option->id?>"><?php echo $option->label?></span>
	<input id="<?php echo $option->id?>-style" type="hidden" class="input-field-input real-time default-value-from-css sup-input-font" data-selected-value="italic" data-css-property="font-style" data-css-selector="<?php echo @$option->selector?>" />
	<input id="<?php echo $option->id?>-weight" type="hidden" class="input-field-input real-time default-value-from-css sup-input-font" data-selected-value="bold" data-css-property="font-weight" data-css-selector="<?php echo @$option->selector?>" />
			
	<div class="<?php echo false!==$unit?'input-append':'';?>">
		<input id="<?php echo $option->id?>" type="text" name="<?php echo $name?>" value="" class="input-field-input <?php $this->input_extra_class($option,$option_i,$options,$options_i)?>" <?php $this->input_extra_properties($option,$option_i,$options,$options_i)?> />
		<?php if(false!==$unit): ?>
			<span class="add-on"><?php echo $option->unit?></span>
		<?php endif; ?>
		<button id="<?php echo $option->id?>-style-helper" data-input-parent="#<?php echo $option->id?>-style" type="button" class="btn sup-italic sup-input-font-helper" data-toggle="button"  >I</button>
		<button id="<?php echo $option->id?>-weight-helper" data-input-parent="#<?php echo $option->id?>-weight" type="button" class="btn sup-bold sup-input-font-helper" data-toggle="button"  >B</button>	
	</div>
</div>
<?php			
	}
	
	
	function render_grid_end($option,$option_i=null,$options=null,$options_i=null){
		echo "</div>";
	}
		
	function render_text($option,$option_i=null,$options=null,$options_i=null){
		$name = property_exists($option,'name')?$option->name:$option->id;
		$unit = property_exists($option,'unit')?$option->unit:false;
?>
<div id="<?php echo $option->id?>-holder" class="input-field <?php $this->holder_extra_class($option) ?>">
	<span class="field-label label-for-<?php echo $option->input_type?> label-for-<?php echo $option->id?>"><?php echo $option->label?></span>
	<div class="<?php echo false!==$unit?'input-append':'';?>">
		<input id="<?php echo $option->id?>" type="text" name="<?php echo $name?>" value="" class="input-field-input <?php $this->input_extra_class($option,$option_i,$options,$options_i)?>" <?php $this->input_extra_properties($option,$option_i,$options,$options_i)?> />
		<?php if(false!==$unit): ?>
			<span class="add-on"><?php echo $option->unit?></span>
		<?php endif; ?>
	</div>
</div>
<?php		
	}
	
	function render_select($option,$option_i=null,$options=null,$options_i=null){
?>
<div id="<?php echo $option->id?>-holder" class="input-field <?php $this->holder_extra_class($option) ?>">
	<span class="field-label label-for-<?php echo $option->input_type?> label-for-<?php echo $option->id?>"><?php echo $option->label?></span>
	<select id="<?php echo $option->id?>" type="text" name="<?php echo $name?>" class="input-field-input <?php $this->input_extra_class($option,$option_i,$options,$options_i)?>" <?php $this->input_extra_properties($option,$option_i,$options,$options_i)?>>
	<?php foreach($option->options as $value => $label):?>
		<option value="<?php echo $value?>"><?php echo $label?></option>
	<?php endforeach; ?>
	</select>
</div>
<?php	
	}
	
	function render_background_position($option,$option_i=null,$options=null,$options_i=null){
?>
<div id="<?php echo $option->id?>-holder" class="input-field <?php $this->holder_extra_class($option) ?>">
	<span class="field-label label-for-<?php echo $option->input_type?> label-for-<?php echo $option->id?>"><?php echo $option->label?></span>
	<select id="<?php echo $option->id?>" type="text" name="<?php echo $name?>" class="input-field-input <?php $this->input_extra_class($option,$option_i,$options,$options_i)?>" <?php $this->input_extra_properties($option,$option_i,$options,$options_i)?>>
	<?php foreach($option->options as $value => $label):?>
		<option value="<?php echo $value?>"><?php echo $label?></option>
	<?php endforeach; ?>
	</select>
	<span>
		<label>X</label>
		<input id="<?php echo $option->id?>-x" name="<?php echo $option->id?>-x" type="text" class="bg-position" value="" />
		<label>Y</label>
		<input id="<?php echo $option->id?>-y" name="<?php echo $option->id?>-y" type="text" class="bg-position" value="" />
	</span>
</div>
<?php
	}
	
	function render_subtitle($option,$option_i=null,$options=null,$options_i=null){
?>
<div class="input-field <?php $this->holder_extra_class($option) ?>">
	<span class="field-label <?php $this->input_extra_class($option,$option_i,$options,$options_i)?>"><?php echo $option->label?></span>
</div>
<?php
	}
	
	function render_slider($option,$option_i=null,$options=null,$options_i=null){
		$name = property_exists($option,'name')?$option->name:$option->id;
?>
<div id="<?php echo $option->id?>-holder" class="input-field input-append pt-option-range <?php $this->holder_extra_class($option) ?>">
	<span class="field-label label-for-<?php echo $option->input_type?> label-for-<?php echo $option->id?>"><?php echo $option->label?></span>
	<input rel="test" id="<?php echo $option->id?>" type="range" min="<?php echo $option->min?>" max="<?php echo $option->max?>" step="<?php echo $option->step?>" name="<?php echo $name?>" value="<?php echo $option->default?$option->default:0;?>" class="input-field-input <?php $this->input_extra_class($option,$option_i,$options,$options_i)?>" <?php $this->input_extra_properties($option,$option_i,$options,$options_i)?> />
	<div class="rhl-clear"></div>
</div>
<?php		
	}
	
	function render_element_size($option,$option_i=null,$options=null,$options_i=null){
		$name = property_exists($option,'name')?$option->name:$option->id;
?>
<div id="<?php echo $option->id?>-holder" class="input-field input-append pt-option-range <?php $this->holder_extra_class($option) ?>">
	<span class="field-label label-for-<?php echo $option->input_type?> label-for-<?php echo $option->id?>"><?php echo $option->label?></span>
	<input rel="test" id="<?php echo $option->id?>" type="range" min="<?php echo $option->min?>" max="<?php echo $option->max?>" step="<?php echo $option->step?>" name="<?php echo $name?>" value="<?php echo $option->default?$option->default:0;?>" class="input-field-input <?php $this->input_extra_class($option,$option_i,$options,$options_i)?>" <?php $this->input_extra_properties($option,$option_i,$options,$options_i)?> />
	<div class="rhl-clear"></div>
</div>
<?php	
	}
	
	function render_color_or_something_else($option,$option_i=null,$options=null,$options_i=null){
		$other_options = $option->other_options && is_array($option->other_options)?$option->other_options:false;
		if(false===$other_options){
			return $this->render_colorpicker($option,$option_i,$options,$options_i);
		}
		$opacity = $option->opacity?true:false;
?>
<div id="<?php echo $option->id?>-holder" class="input-field input-field-color_or_something_else <?php $this->holder_extra_class($option) ?>">
	<span class="field-label label-for-<?php echo $option->input_type?> label-for-<?php echo $option->id?>"><?php echo $option->label?></span><br />
	<input id="<?php echo $option->id?>" value='' type="<?php echo $this->debug?'text':'hidden'?>" class="input-field-input color_or_something_else with-alternate-color-value <?php $this->input_extra_class($option,$option_i,$options,$options_i)?>" <?php $this->input_extra_properties($option,$option_i,$options,$options_i)?> />
	<select id="<?php echo $option->id?>-options" class="color-or-something-options alternate-color-values" data-target-selector="#<?php echo $option->id?>">
		<?php if($option->btn_clear):?>
		<option value="">&nbsp;</option>
		<?php endif; ?>
		<option value="color"><?php _e('Color','rhl')?></option>
		<?php foreach($option->other_options as $val => $label):?>
		<option value="<?php echo $val?>" class="alternate-color-value"><?php echo $label?></option>
		<?php endforeach; ?>
	</select>
	<div class='input-minicolors-hold'>
		<input id="<?php echo $option->id?>-color" data-target-selector="#<?php echo $option->id?>" value='' type="text" class="input-minicolors <?php echo $opacity?'with-opacity':'';?> colorpicker-preview-content colorpicker-input-field sub_color_or_something_else" />
	</div>
	<?php if(@$option->btn_clear):?>
	<div class="image-url-button-clear-cont">
		<input type="button" class="btn btn_clear_generic" data-clear-level='2' value="Clear" />
	</div>
	<?php endif; ?>
	<div class="rhl-clear"></div>
</div>
<?php		
	}
	
	function render_colorpicker($option,$option_i=null,$options=null,$options_i=null){
		$opacity = @$option->opacity?true:false;
?>
<div id="<?php echo $option->id?>-holder" class="input-field <?php $this->holder_extra_class($option) ?>">
	<span class="field-label label-for-<?php echo $option->input_type?> label-for-<?php echo $option->id?>"><?php echo $option->label?></span><br />
	<div class="colorpicker-input">
		<div class="colorpicker-preview">
			<input id="<?php echo $option->id?>" value='' type="text" class="input-minicolors <?php echo $opacity?'with-opacity':'';?> input-field-input colorpicker-preview-content colorpicker-input-field <?php $this->input_extra_class($option,$option_i,$options,$options_i)?>" <?php $this->input_extra_properties($option,$option_i,$options,$options_i)?> />
			<?php if($option->btn_clear):?>
			<input type="button" class="btn btn_clear_generic" value="Clear" />
			<?php endif; ?>
		</div>
		
	</div>
	
	<div class="rhl-clear"></div>
</div>
<?php	
	}

	function render_color_gradient($option,$option_i=null,$options=null,$options_i=null){
		$opacity = $option->opacity?true:false;
?>
<div id="<?php echo $option->id?>-holder" class="input-field <?php $this->holder_extra_class($option) ?>">
	<span class="field-label label-for-<?php echo $option->input_type?> label-for-<?php echo $option->id?>"><?php echo $option->label?></span><br />
	
	<div class="colorpicker-input">
		<div class="colorpicker-preview colorpicker_gradient">
			<input id="<?php echo $option->id?>" value='' type="<?php echo $this->debug?'text':'hidden'?>" class="input-field-input colorpicker_gradient <?php $this->input_extra_class($option,$option_i,$options,$options_i)?>" <?php $this->input_extra_properties($option,$option_i,$options,$options_i)?> />
			
			<input id="<?php echo $option->id?>-start" value='' type="text" class="input-minicolors <?php echo $opacity?'with-opacity':'';?> colorpicker-preview-content colorpicker-input-field sub_colorpicker_gradient" />
			
			<input id="<?php echo $option->id?>-end" value='' type="text" class="input-minicolors <?php echo $opacity?'with-opacity':'';?> colorpicker-preview-content colorpicker-input-field sub_colorpicker_gradient" />
			
			<?php if($option->btn_clear):?>
			<input type="button" class="btn btn_clear_gradient" value="Clear" />
			<?php endif; ?>
		</div>
		
	</div>
	<div class="rhl-clear"></div>
</div>
<?php	
	}

	function render_textshadow($option,$option_i=null,$options=null,$options_i=null){
?>
<div id="<?php echo $option->id?>-holder" class="input-field <?php $this->holder_extra_class($option) ?>">
	<span class="field-label label-for-<?php echo $option->input_type?> label-for-<?php echo $option->id?>"><?php echo $option->label?></span><br />
	
	<div class="colorpicker-input">
		<div class="colorpicker-preview">
			<input id="<?php echo $option->id?>" value='' type="<?php echo $this->debug?'text':'hidden'?>" class="input-field-input colorpicker_textshadow <?php $this->input_extra_class($option,$option_i,$options,$options_i)?>" <?php $this->input_extra_properties($option,$option_i,$options,$options_i)?> />
			
			<input id="<?php echo $option->id?>-color" value='' type="text" class="input-minicolors colorpicker-preview-content colorpicker-input-field  text-shadow-field text-shadow-color"  />
			
			<?php if($option->btn_clear):?>
			<input type="button" class="btn btn_clear_text_shadow" value="Clear" />
			<?php endif; ?>
		</div>
		<div class="colorpicker-preview text-shadow-extra">
			<span class="bootstrap-tooltip" data-tooltip-position="fixed" rel="tooltip" title="<?php _e('Horizontal position of the text shadow','rhl') ?>"><?php _e('H:','rhl')?></span>
			<input id="<?php echo $option->id?>-h" class="input-text-shadow-extra text-shadow-field text-shadow-h" type="text" value="" />
			<span class="bootstrap-tooltip" rel="tooltip" title="<?php _e('Vertical position of the text shadow','rhl') ?>"><?php _e('V:','rhl')?></span>
			<input id="<?php echo $option->id?>-v" class="input-text-shadow-extra text-shadow-field text-shadow-v" type="text" value="" />			
			<span class="bootstrap-tooltip" rel="tooltip" title="<?php _e('Text Shadow Blur','rhl') ?>"><?php _e('Blur:','rhl')?></span>
			<input id="<?php echo $option->id?>-b" class="input-text-shadow-extra text-shadow-field text-shadow-b" type="text" value="" />
		</div>
	</div>
	
	<div class="rhl-clear"></div>
</div>
<?php	
	}
	
	function render_image_url($option,$option_i=null,$options=null,$options_i=null){
?>
<div id="<?php echo $option->id?>-holder" class="input-field rhl-image-uploader">
	<span class="field-label label-for-<?php echo $option->input_type?> label-for-<?php echo $option->id?>"><?php echo $option->label?></span><br />
	<input id="<?php echo $option->id?>" value='' type="<?php echo $this->debug?'text':'hidden'?>" class="input-field-input rhl_image_uploader <?php $this->input_extra_class($option,$option_i,$options,$options_i)?>" <?php $this->input_extra_properties($option,$option_i,$options,$options_i)?> />
	<div class="rhl-image-uploader-control">
		<div class="dropdown preview-thumbnail">
			<div class="dropdown-content">
				<img src="" style="display:none;">
				<div class="dropdown-status" style="display: block; ">No Image</div>
			</div>
			<div class="dropdown-arrow rhl-image-uploader-helper-trigger"></div>
		</div>
		<?php if($option->btn_clear):?>
		<div class="image-url-button-clear-cont">
			<input type="button" class="btn btn_clear_image_url" value="Clear" />
		</div>
		<?php endif; ?>  			
		<div class="rhl-clear"></div>
	</div>
		
	<div class="rhl-clear"></div>
	
   <div id="<?php echo $option->id?>-msg" class="rhl-image-upload-msg"></div>
   
	<div class="rhl-image-upoader-helper helper-closed">
		<ul class="nav nav-tabs">
			<li class="active"><a class="rhl-upload-new" href="#<?php echo $option->id?>-upload" data-toggle="tab"><?php _e('Upload new','rhl')?></a></li>
			<li class="rhl-uploaded-images-tab"><a href="#<?php echo $option->id?>-uploaded" data-toggle="tab"><?php _e('Uploaded','rhl')?></a></li>
		</ul>
		<div class="tab-content">
			<div id="<?php echo $option->id?>-upload" class="tab-pane active">

				<div id="<?php echo $option->id?>-upload-ui" class="hide-if-no-js">
					<div id="<?php echo $option->id?>-drag-drop-area" class="drag-drop-area">
				    	<div class="drag-drop-inside">
				     		<p class="drag-drop-info">
							<?php _e('Drop a file here or'); ?>&nbsp;
				     		<a id="<?php echo $option->id?>-browse-button" href="#" class="upload" style="position: relative; z-index: 0; ">select a file</a>
							</p>	
				   		</div>
					</div>
				</div>
			
			</div>		
			<div id="<?php echo $option->id?>-uploaded" class="tab-pane rhl-uploaded-images-tab-pane">
				UPLOADED
			</div>		
			<textarea id="<?php echo $option->id?>-upload-list" style="width:96%;<?php echo $this->debug?'':'display:none;'?>" rows='5' class="input-pop-option" name="<?php echo $option->id?>-upload-list"><?php echo $this->get_option($option->id.'-upload-list','',true);?></textarea>
		</div>
	</div>
</div>

<?php
	
		$plupload_init = array(
			'runtimes'            => 'html5,silverlight,flash,html4',
			'browse_button'       => $option->id.'-browse-button',
			'container'           => $option->id.'-upload-ui',
			'drop_element'        => $option->id.'-drag-drop-area',
			'file_data_name'      => 'rhl-async-upload',            
			'multiple_queues'     => true,
			'max_file_size'       => $this->wp_max_upload_size(),
			'url'                 => admin_url('admin-ajax.php'),
			'flash_swf_url'       => includes_url('js/plupload/plupload.flash.swf'),
			'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
			'filters'             => array(array('title' => __('Allowed Files','rhl'), 'extensions' => '*')),
			'multipart'           => true,
			'urlstream_upload'    => true,
			'multipart_params'    => array(
		    	'_ajax_nonce'	=> wp_create_nonce('rhl-upload'),
		    	'action'      	=> 'rhl_handle_upload',            // the ajax action name
				'id'			=> $option->id,
				'queue'			=> $option->queue?$option->queue:$option->id
		  	),
			'id'				=> $option->id,
			'queue'				=> $option->queue?$option->queue:$option->id
		);

?>
<script type="text/javascript">init_image_uploader(<?php echo json_encode($plupload_init); ?>);</script>
<?php		
		
	}
	
	function render_background_image($option,$option_i=null,$options=null,$options_i=null){
		$opacity = $option->opacity?true:false;
?>
<div id="<?php echo $option->id?>-holder" class="input-field rhl-image-uploader <?php $this->holder_extra_class($option) ?>">
	<span class="field-label label-for-<?php echo $option->input_type?> label-for-<?php echo $option->id?>"><?php echo $option->label?></span><br />
	<input id="<?php echo $option->id?>" value='' type="<?php echo $this->debug?'text':'hidden'?>" class="input-field-input rhl_image_uploader input-field-bakground_image <?php $this->input_extra_class($option,$option_i,$options,$options_i)?>" <?php $this->input_extra_properties($option,$option_i,$options,$options_i)?> />
	<div class="rhl-image-uploader-control">
		<div class="dropdown preview-thumbnail">
			<div class="dropdown-content">
				<img src="" style="display:none;" />
				<div style="display:block;" class="dropdown-status">No Image</div>
				<div style="display:none;" class="dropdown-gradient">&nbsp;</div>
			</div>
			<div class="dropdown-arrow rhl-image-uploader-helper-trigger"></div>
		</div>
		<?php if($option->btn_clear):?>
		<div class="image-url-button-clear-cont">
			<input type="button" class="btn btn_clear_image_url" value="Clear" />
		</div>
		<?php endif; ?>  			
		<div class="rhl-clear"></div>
	</div>
		
	<div class="rhl-clear"></div>
	
   <div id="<?php echo $option->id?>-msg" class="rhl-image-upload-msg"></div>
   
	<div class="rhl-image-upoader-helper helper-closed">
		<ul class="nav nav-tabs">
			<li class=""><a class="rhl-image-gradient" href="#<?php echo $option->id?>-gradient" data-toggle="tab"><?php _e('Gradient','rhl')?></a></li>
			<li class="active"><a class="rhl-upload-new" href="#<?php echo $option->id?>-upload" data-toggle="tab"><?php _e('Upload','rhl')?></a></li>
			<li class="rhl-uploaded-images-tab"><a href="#<?php echo $option->id?>-uploaded" data-toggle="tab"><?php _e('Uploaded','rhl')?></a></li>
		</ul>
		<div class="tab-content">
			<div id="<?php echo $option->id?>-gradient" class="tab-pane">
				
				<input id="<?php echo $option->id?>-start" value='' type="text" class="input-minicolors <?php echo $opacity?'with-opacity':'';?> colorpicker-preview-content colorpicker-input-field sub_colorpicker_gradient" />
			
				<input id="<?php echo $option->id?>-end" value='' type="text" class="input-minicolors <?php echo $opacity?'with-opacity':'';?> colorpicker-preview-content colorpicker-input-field sub_colorpicker_gradient" />
			
			</div>
			<div id="<?php echo $option->id?>-upload" class="tab-pane active">

				<div id="<?php echo $option->id?>-upload-ui" class="hide-if-no-js">
					<div id="<?php echo $option->id?>-drag-drop-area" class="drag-drop-area">
				    	<div class="drag-drop-inside">
				     		<p class="drag-drop-info">
							<?php _e('Drop a file here or'); ?>&nbsp;
				     		<a id="<?php echo $option->id?>-browse-button" href="#" class="upload" style="position: relative; z-index: 0; ">select a file</a>
							</p>	
				   		</div>
					</div>
				</div>
			
			</div>		
			<div id="<?php echo $option->id?>-uploaded" class="tab-pane rhl-uploaded-images-tab-pane">
				UPLOADED
			</div>		
			<textarea id="<?php echo $option->id?>-upload-list" style="width:96%;<?php echo $this->debug?'':'display:none;'?>" rows='5' class="input-pop-option" name="<?php echo $option->id?>-upload-list"><?php echo $this->get_option($option->id.'-upload-list','',true);?></textarea>
		</div>
	</div>
</div>

<?php
	
		$plupload_init = array(
			'runtimes'            => 'html5,silverlight,flash,html4',
			'browse_button'       => $option->id.'-browse-button',
			'container'           => $option->id.'-upload-ui',
			'drop_element'        => $option->id.'-drag-drop-area',
			'file_data_name'      => 'rhl-async-upload',            
			'multiple_queues'     => true,
			'max_file_size'       => $this->wp_max_upload_size(),
			'url'                 => admin_url('admin-ajax.php'),
			'flash_swf_url'       => includes_url('js/plupload/plupload.flash.swf'),
			'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
			'filters'             => array(array('title' => __('Allowed Files','rhl'), 'extensions' => '*')),
			'multipart'           => true,
			'urlstream_upload'    => true,
			'multipart_params'    => array(
		    	'_ajax_nonce'	=> wp_create_nonce('rhl-upload'),
		    	'action'      	=> 'rhl_handle_upload',            // the ajax action name
				'id'			=> $option->id,
				'queue'			=> @$option->queue?$option->queue:$option->id
		  	),
			'id'				=> $option->id,
			'queue'				=> @$option->queue?$option->queue:$option->id
		);

?>
<script type="text/javascript">init_image_uploader(<?php echo json_encode($plupload_init); ?>);</script>
<?php		
		
	}
	
	function wp_max_upload_size() {
		//from wp 3.5
		$u_bytes = $this->wp_convert_hr_to_bytes( ini_get( 'upload_max_filesize' ) );
		$p_bytes = $this->wp_convert_hr_to_bytes( ini_get( 'post_max_size' ) );
		$bytes = $u_bytes;
		
		if(is_multisite()){
			if( function_exists('upload_size_limit_filter') ){
				$bytes   = apply_filters( 'upload_size_limit', min( $u_bytes, $p_bytes ), $u_bytes, $p_bytes );
			}
		}else{
			$bytes   = apply_filters( 'upload_size_limit', min( $u_bytes, $p_bytes ), $u_bytes, $p_bytes );
		}
		
		if(trim($bytes)!=''){
			return $bytes.'b';
		}else{
			return '';
		}
	}
	
	function wp_convert_hr_to_bytes( $size ) {
		//from wp 3.5
		$size = strtolower($size);
		$bytes = (int) $size;
		if ( strpos($size, 'k') !== false )
			$bytes = intval($size) * 1024;
		elseif ( strpos($size, 'm') !== false )
			$bytes = intval($size) * 1024 * 1024;
		elseif ( strpos($size, 'g') !== false )
			$bytes = intval($size) * 1024 * 1024 * 1024;
		return $bytes;
	}
	
	function holder_extra_class($option,$option_i=null,$options=null,$options_i=null){
		if($option->holder_class){
			echo $option->holder_class." ";
		}	
	}
	
	function input_extra_class($option,$option_i=null,$options=null,$options_i=null){
		if($option->class){
			echo $option->class." ";
		}
		
		if($option->type=='css' && $option->selector){
			echo "default-value-from-css ";
			if($option->real_time){
				echo "real-time ";
			}
		}	
	}
	
	function input_extra_properties($option,$option_i=null,$options=null,$options_i=null){
		if($option->type=='css' && @$option->selector){
			echo "data-css-selector=\"".$option->selector."\" data-css-property=\"".$option->property."\" ";
		}	
		
		if(@$option->unit){
			echo "data-input-unit=\"".$option->unit."\" ";
		}
		
		if(@$option->blank_value){
			echo "data-blank-value=\"".$option->blank_value."\" ";
		}
		
		if(@$option->children){
			echo "data-children=\"".rawurlencode(json_encode($option->children))."\" ";
		}
		
		if(@$option->derived){
			echo "data-derived=\"".rawurlencode(json_encode($option->derived))."\" ";
		}
	}
	
	function render_background_size($option,$option_i=null,$options=null,$options_i=null){
?>
<div id="<?php echo $option->id?>-holder" class="input-field input-field-background_size <?php $this->holder_extra_class($option) ?>">
	<span class="field-label label-for-<?php echo $option->input_type?> label-for-<?php echo $option->id?>"><?php echo $option->label?></span><br />
	<input id="<?php echo $option->id?>" value='' type="<?php echo $this->debug?'text':'hidden'?>" class="input-field-input background_size <?php $this->input_extra_class($option,$option_i,$options,$options_i)?>" <?php $this->input_extra_properties($option,$option_i,$options,$options_i)?> />
	
	<div class="row-fluid">
		<div class="span8">
			<select id="<?php echo $option->id?>-options" class="input-wide bgsize_options alternate-bgsize-values" data-target-selector="#<?php echo $option->id?>">
				<option value="auto">auto</option>
				<?php foreach($option->other_options as $val => $label):?>
				<option value="<?php echo $val?>" class="alternate-bgsize-value"><?php echo $label?></option>
				<?php endforeach; ?>
			</select>
		</div>	
		<?php /*if($option->btn_clear):*/?>
		<div class="span4 bgsize_clear_btn">
			<input type="button" class="btn btn_clear_generic" data-clear-level='2' value="Clear" />
		</div>
		<?php /*endif;*/ ?>				
	</div>	
	<div class="row-fluid bgsize_value_holder">
		<div class="span6">
			<span class="field-label label-for-bgsize_percent_h"><?php _e('Height','rhl')?></span>
			<div class="input-append input-wide">
				<input id="<?php echo $option->id?>" type="text" name="bgsize_h" value="" class="bgsize_value bgsize_h" />
				<span class="add-on bgsize-unit">%</span>
			</div>
		</div>
		<div class="span6">
			<span class="field-label label-for-bgsize_percent_w"><?php _e('Width','rhl')?></span>
			<div class="input-append input-wide">
				<input id="<?php echo $option->id?>" type="text" name="bgsize_w" value="" class="bgsize_value bgsize_w" />
				<span class="add-on bgsize-unit">%</span>
			</div>
		</div>
	</div>
	
	<div class="rhl-clear"></div>	
</div>
<?php
	}
}

?>