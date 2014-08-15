<?php




if (is_user_logged_in()):     
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
  
  endif;
  
header("Content-type: text/css");
if(isset($_GET['step_id'])) {
     
     //preview mode
                 $wpcss_current_settings_array=csshero_get_configuration_array($_GET['step_id']);
                        
                         
}
else
{    //standard mode
     $wpcss_current_settings_array=csshero_get_configuration_array();
}
 
// print_r($wpcss_current_settings_array);die;
 
//init refactoring array
$wpcss_CSS_generator_array=array();

     
if ($wpcss_current_settings_array) foreach ($wpcss_current_settings_array as $option_slug=>$new_css_row):
        //print_r($new_css_row);
        
       //if (!is_array($new_css_row)) continue; //skip meta tags like theme name and version - skippa i non array
         
        $this_selector=$new_css_row->property_target;  
      
        
        $wpcss_CSS_generator_array[$this_selector][]=$new_css_row;

endforeach;

 //print_r($wpcss_CSS_generator_array);

///NUOVO ARRAY DI REFACTORING

foreach($wpcss_CSS_generator_array as $this_selector=>$this_properties):
    
    echo $this_selector. " {";
        foreach ($this_properties as $this_selector_rows): //print_r($this_property_rule);
                         
                         if (isset($this_selector_rows->media_query) AND $this_selector_rows->media_query!="") continue;
                      //   if ($this_selector_rows->property_value=="") continue; //da riaggiungere e pure bene sistemando prima il reset prop
                         echo "\n       ".$this_selector_rows->property_name.": ".$this_selector_rows->property_value."; ";
                 
        
        endforeach;
    
    echo "\n    } \n\n";
endforeach;


//MEDIA QUERY

if ($wpcss_current_settings_array) foreach ($wpcss_current_settings_array as $option_slug=>$new_css_row):
    
        
           if (!isset( $new_css_row->media_query) OR $new_css_row->media_query=="") continue;
         //if ($this_selector_rows->property_value=="") continue; //da riaggiungere e pure bene
        $this_selector=$new_css_row->property_target;  
      
          echo "\n".$new_css_row->media_query." { " .$this_selector. " {   ".$new_css_row->property_name.": ".$new_css_row->property_value."; }  }  ";

endforeach;


?>