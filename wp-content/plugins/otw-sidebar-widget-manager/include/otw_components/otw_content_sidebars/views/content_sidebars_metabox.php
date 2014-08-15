<div id="<?php echo $this->meta_name ?>_container" class="otw_content_sidebars_container otw-cs-content">
	<input type="hidden" name="<?php echo $this->meta_name; ?>_noncename" value="<?php echo $meta_noncename ?>"/>
	<div>
		<?php echo OTW_Form::select( array( 'id' => 'otw_cs_use_configuration', 'label' => $this->get_label( 'Select default or custom settings' ), 'name' => 'otw_cs_use_configuration', 'value' => $default_values[ $item_type ]['configuration'], 'options' => $configuration_options, 'description' => $this->get_label( 'Default means that you want to apply the default settings for the OTW Content sidebars set in the left WP menu. Custom measns the settings will apply form what you set bellow.' ) ) ); ?>
	</div>
	<div class="otw_cs_delimiter"></div>
	<div id="otw_cs_sidebar_configiration" style="display: <?php echo  ( $default_values[ $item_type ]['configuration'] == 'custom' )?'block':'none' ?>;" >
		<div class="otw-cs-layout-selection">
			<div class="otw-form-control">
				<label for=""><?php echo $this->get_label('OTW Sidebars Configuration')?></label>
				<ul class="otw-cs-layout-type">
					<li><img src="<?php echo $this->component_url ?>img/layout-1c.png" alt="" id="<?php echo $item_type?>_1c" <?php echo ( $default_values[$item_type]['layout'] == '1c' )?'class="otw-selected"':''?>/></li>
					<li><img src="<?php echo $this->component_url ?>img/layout-2cl.png" alt="" id="<?php echo $item_type?>_2cl" <?php echo ( $default_values[$item_type]['layout'] == '2cl' )?'class="otw-selected"':''?>/></li>
					<li><img src="<?php echo $this->component_url ?>img/layout-2cr.png" alt="" id="<?php echo $item_type?>_2cr" <?php echo ( $default_values[$item_type]['layout'] == '2cr' )?'class="otw-selected"':''?>/></li>
					<li><img src="<?php echo $this->component_url ?>img/layout-3cl.png" alt="" id="<?php echo $item_type?>_3cl" <?php echo ( $default_values[$item_type]['layout'] == '3cl' )?'class="otw-selected"':''?>/></li>
					<li><img src="<?php echo $this->component_url ?>img/layout-3cm.png" alt="" id="<?php echo $item_type?>_3cm" <?php echo ( $default_values[$item_type]['layout'] == '3cm' )?'class="otw-selected"':''?>/></li>
					<li><img src="<?php echo $this->component_url ?>img/layout-3cr.png" alt="" id="<?php echo $item_type?>_3cr" <?php echo ( $default_values[$item_type]['layout'] == '3cr' )?'class="otw-selected"':''?>/></li>
				</ul>
				<input type="hidden" name="otw_cs_layout_<?php echo $item_type?>" id="otw_cs_layout_<?php echo $item_type?>" value="<?php echo $default_values[$item_type]['layout']?>" />
				<span class="otw-form-hint"><?php echo $this->get_label( 'Choose sidebar configuration.' )?></span>
			</div>
		</div>
		<div class="otw-cs-sidebars-selection">
			<div id="otw_cs_sidebar1_container_<?php echo $item_type ?>">
				<?php echo OTW_Form::select( array( 'id' => 'otw_cs_sidebar1_'.$item_type, 'label' => $this->get_label( 'OTW Primary Sidebar' ), 'name' => 'otw_cs_sidebar1_'.$item_type, 'value' => $default_values[ $item_type ]['sidebar1_id'], 'options' => $available_sidebars, 'description' => $this->get_label( 'Choose what sidebar should be displayed as OTW Primary sidebar.' ) ) ); ?>
			</div>
			<div id="otw_cs_sidebar2_container_<?php echo $item_type ?>">
				<?php echo OTW_Form::select( array( 'id' => 'otw_cs_sidebar2_'.$item_type, 'name' => 'otw_cs_sidebar2_'.$item_type, 'value' => $default_values[ $item_type ]['sidebar2_id'], 'options' => $available_sidebars, 'label' => $this->get_label( 'OTW Secondary Sidebar' ), 'description' => $this->get_label( 'OTW Secondary Sidebar' ) ) ); ?>
			</div>
		</div>
		<div class="otw-cs-sidebar-width-selection">
			<div id="otw_cs_sidebar-width1_container_<?php echo $item_type ?>">
				<?php echo OTW_Form::select( array( 'id' => 'otw_cs_sidebar1_size_'.$item_type, 'name' => 'otw_cs_sidebar1_size_'.$item_type, 'value' => $default_values[ $item_type ]['sidebar1_size'], 'options' => $available_sidebar_sizes,  'label' => $this->get_label( 'OTW Primary Sidebar Width' ), 'description' => $this->get_label( 'Choose the width for your Primary sidebar in columns. The whole content area including sidebars is 24 columns.' ) ) ); ?>
			</div>
			<div id="otw_cs_sidebar-width2_container_<?php echo $item_type ?>">
				<?php echo OTW_Form::select( array( 'id' => 'otw_cs_sidebar2_size_'.$item_type, 'name' => 'otw_cs_sidebar2_size_'.$item_type, 'value' => $default_values[ $item_type ]['sidebar2_size'], 'options' => $available_sidebar_sizes, 'label' => $this->get_label( 'OTW Secondary Sidebar Width' ), 'description' => $this->get_label( 'Choose the width for your Secondary sidebar in columns. The whole content area including sidebars is 24 columns.' ) ) ); ?>
			
			</div>
		</div>

	</div>
</div>