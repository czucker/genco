<?php
return array(
	array(
	    'type'      => 'group',
	    'repeating' => true,
	    'name'      => 'hb_pricing_table_items',
	    'sortable' => true,
	    'title'     => __('Pricing Table Column', 'hbthemes'),
		'description' => __('Add as many pricing table columns as you want by clicking the Add More button.', 'hbthemes'),
	    'fields'    => array(
				array(
					'type' => 'color',
					'name' => 'hb_pricing_color',
					'label' => __('Color Accent', 'hbthemes'),	
					'description'=>__('Specify an accent color for this pricing table item.','hbthemes')
				),
				array(
					'type' => 'toggle',
					'name' => 'hb_pricing_featured',
					'label' => __('Featured', 'hbthemes'),
					'default' => false,
					'description' => __('Make this pricing item featured. It will be styled differently than regular ones. Use with Featured Ribbon for best "stand out" look.', 'hbthemes'),
				),
				array(
					'type' => 'select',
					'name' => 'hb_pricing_ribbon',
					'label' => __('Pricing Ribbon.','hbthemes'),
					'description' => __('Choose which ribbon will appear on this item.','hbthemes'),
					'items' => array(
						array(
							'value' => 'none',
							'label' => __('None', 'hbthemes'),
						),
						array(
							'value' => 'gold',
							'label' => __('Gold', 'hbthemes'),
						),
						array(
							'value' => 'blue',
							'label' => __('Blue', 'hbthemes'),
						),
					),
					'default' => 'none',
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_pricing_featured_ribbon',
					'label' => __('Ribbon', 'hbthemes'),
					'description' => __('Add a custom ribbon on your pricing plan. Leave empty to hide. Example: POPULAR','hbthemes'),
					'default' => '',
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_pricing_title',
					'label' => __('Title', 'hbthemes'),
					'description' => __('Specify your pricing plan title. Change the default value.','hbthemes'),
					'default' => 'Starter Package',
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_pricing_price',
					'label' => __('Price', 'hbthemes'),
					'description' => __('Specify your pricing plan price. Change the default value.','hbthemes'),
					'default' => '$49',
				),
				array(
					'type' => 'textbox',
					'name' => 'hb_pricing_period',
					'label' => __('Period', 'hbthemes'),
					'description' => __('Enter a period of time for this pricing item and the given price. Example: yearly, monthly, daily etc.','hbthemes'),
					'default' => 'monthly',
				),
				array(
					'type' => 'wpeditor',
					'name' => 'hb_pricing_feature_list',
					'label' => __('Feature List', 'hbthemes'),
					'description' => __("Specify a list of features for your pricing plan. You can use lists and shortcodes here. If you want to use different button that the one provided below, use button shortcode for that.",'hbthemes'),
					'default' => '<p>[list type="icon"]<br />[list_item icon="icon-ok" color="#ff6838"]List item content here[/list_item]<br />[list_item icon="icon-ok" color="#336699"]List item content here[/list_item]<br />[list_item icon="icon-ok" color="#1dc1df"]List item content here[/list_item]<br />[/list]</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse viverra mauris eget tortor imperdiet vehicula.</p>',
				),
	    ),
	),
);
?>