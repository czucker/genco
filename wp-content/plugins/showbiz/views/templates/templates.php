

	<div class='wrap'>
	
	<div class="title_line">
		<h2>
			<?php echo $titleText?>
		</h2>
		
		<?php if(!empty($filterID)): ?>
		<div class='filter_text'>			
			Filtered results. <a id="button_show_all" class="button-secondary mleft_10" href="<?php echo $linkShowAll?>">Show all</a>
		</div>
		<?php endif?>
		<?php BizOperations::putGlobalSettingsHelp(); ?>	
		<?php BizOperations::putLinkHelp($linkHelp) ?>
		
	</div>

	<br>
	<?php if(empty($arrTemplates)): ?>
		No Templates Found
		<br>
	<?php else:
		 require self::getPathTemplate("templates_list");	 		
	endif?>
	
	
	<br>
	<p>			
		<a id="button_create_template" class='button-primary revgreen' href='javascript:void(0)'>Create New Template</a>
	</p>
	 
	 <br>
	
	
	</div>
	
	
	<!-- custom options dialog  -->

	<?php if($showCustomOptions == true):?>
	
	<div id="dialog_add_wildcard" title="Edit Custom Options" style="display:none">
		<br>
		<b>Options List:</b>
		<br>
		<div class="list_custom_options_wrapper">
			<ul id="list_custom_options" class="list_custom_options">
				<?php foreach($arrCustomOptions as $arr):
					$name = $arr["name"];
					$showName = $arr["title"] . " ({$name})";
					$placeholder = ShowBizWildcards::PLACEHOLDER_PREFIX.$name;
				?>
				<li>
					<span class="option_name">
						<?php echo $showName?>						
					</span>
					<span class="option_operations">
						<a class="button-primary  button_remove_option" data-placeholder="<?php echo $placeholder?>" data-optionname="<?php echo $name?>">Remove</a>
						<span class="loader_clean loader_remove_option float_left mleft_5 mtop_5" style="display:none;"></span>
					</span>
					<span class="clear_both"></span>
				</li>
				<?php endforeach?>
			</ul>
		</div>
		
		 Option Title 
		<input type="text" id="new_option_title" value="">
		
		&nbsp;&nbsp;
		
		Option Name									
		<input type="text" id="new_option_name" value="">
		
		&nbsp;&nbsp;
		
		<input id="button_add_custom_option" type="button" class="button-primary" value="Add Option" >
		
		<span id="loader_button_add" class="loader_clean float_right mright_50" style="display:none;"></span>
		
		<div id="custom_options_error_message" style="display:none;" class="unite_error_message"></div>
		
	</div>
	
	<?php endif?>
	

	<script type="text/javascript">
		jQuery(document).ready(function(){
			ShowBizAdmin.initTemplatesView("<?php echo $templatesType?>","<?php echo $templatesPrefix?>");
		});
	</script>
	