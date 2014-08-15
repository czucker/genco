<?php
 
class ShowBiz_Widget extends WP_Widget {
	
    public function __construct(){
    	
        // widget actual processes
     	$widget_ops = array('classname' => 'widget_showbiz', 'description' => __('Displays a showbiz slider on the page') );
        parent::__construct('showbiz-widget', __('ShowBiz'), $widget_ops);
    }
 
    /**
     * 
     * the form
     */
    public function form($instance) {
	
		$slider = new ShowBizSlider();
    	$arrSliders = $slider->getArrSlidersShort();
    	    	
		if(empty($arrSliders))
			echo __("No sliders found, Please create a slider");
		else{
			
			$field = "showbiz";
			$fieldPages = "showbiz_pages";
			$fieldCheck = "showbiz_homepage";
			$fieldTitle = "showbiz_title";
			
	    	$sliderID = UniteFunctionsBiz::getVal($instance, $field);
	    	$homepage = UniteFunctionsBiz::getVal($instance, $fieldCheck);
	    	$pagesValue = UniteFunctionsBiz::getVal($instance, $fieldPages);
	    	$title = UniteFunctionsBiz::getVal($instance, $fieldTitle);
	    	
			$fieldID = $this->get_field_id( $field );
			$fieldName = $this->get_field_name( $field );
			
			$select = UniteFunctionsBiz::getHTMLSelect($arrSliders,$sliderID,'name="'.$fieldName.'" id="'.$fieldID.'"',true);
			
			$fieldID_check = $this->get_field_id( $fieldCheck );
			$fieldName_check = $this->get_field_name( $fieldCheck );
			$checked = "";
			if($homepage == "on")
				$checked = "checked='checked'";

			$fieldPages_ID = $this->get_field_id( $fieldPages );
			$fieldPages_Name = $this->get_field_name( $fieldPages );
			
			$fieldTitle_ID = $this->get_field_id( $fieldTitle );
			$fieldTitle_Name = $this->get_field_name( $fieldTitle );
			
		?>
			<label for="<?php echo $fieldTitle_ID?>"><?php _e("Title",SHOWBIZ_TEXTDOMAIN)?>:</label>
			<input type="text" name="<?php echo $fieldTitle_Name?>" id="<?php echo $fieldTitle_ID?>" value="<?php echo $title?>" class="widefat">
			
			<br><br>
		
			<?php _e("Choose Slider",SHOWBIZ_TEXTDOMAIN)?>: <?php echo $select?>
			
			<div style="padding-top:10px;"></div>
						
			<label for="<?php echo $fieldID_check?>"><?php _e("Home Page Only",SHOWBIZ_TEXTDOMAIN)?>:</label>
			<input type="checkbox" name="<?php echo $fieldName_check?>" id="<?php echo $fieldID_check?>" <?php echo $checked?> >
			
			<br><br>
			
			<label for="<?php echo $fieldPages_ID?>"><?php _e("Pages: (example: 2,10)",SHOWBIZ_TEXTDOMAIN)?> </label>
			<input type="text" name="<?php echo $fieldPages_Name?>" id="<?php echo $fieldPages_ID?>" value="<?php echo $pagesValue?>">
			
			<div style="padding-top:10px;"></div>
		<?php
		}	//else
		 
    }
 
    /**
     * 
     * update
     */
    public function update($new_instance, $old_instance) {
    	
        return($new_instance);
    }

    
    /**
     * 
     * widget output
     */
    public function widget($args, $instance) {
    	
		$sliderID = UniteFunctionsBiz::getVal($instance, "showbiz");
		$title = UniteFunctionsBiz::getVal($instance, "showbiz_title");
		
		$homepageCheck = UniteFunctionsBiz::getVal($instance, "showbiz_homepage");
		$homepage = "";
		if($homepageCheck == "on")
			$homepage = "homepage";
		
		$pages = UniteFunctionsBiz::getVal($instance, "showbiz_pages");
		if(!empty($pages)){
			if(!empty($homepage))
				$homepage .= ",";
			$homepage .= $pages;
		}
				
		if(empty($sliderID))
			return(false);

		//widget output
		$beforeWidget = UniteFunctionsBiz::getVal($args, "before_widget");
		$afterWidget = UniteFunctionsBiz::getVal($args, "after_widget");
		$beforeTitle = UniteFunctionsBiz::getVal($args, "before_title");
		$afterTitle = UniteFunctionsBiz::getVal($args, "after_title");
		
		echo $beforeWidget;
		echo $beforeTitle.$title.$afterTitle;
		ShowBizOutput::putSlider($sliderID,$homepage,true);		
		echo $afterWidget;
    }
 
}


?>