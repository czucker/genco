<?php
function snp_is_valid_email($email)
{
	if (preg_match('|^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$|i', $email)) 
		return true;
	else
		return false;
}
function snp_detect_mobile($useragent)
{
	if (preg_match('/android.+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|meego.+mobile|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4)))
	{
		return true;
	}
	else
	{
		return false;
	}
}
function snp_is_valid_date($date)
{
    if (date('Y-m-d', strtotime($date)) == $date)
    {
	return true;
    }
    else
    {
	return false;
    }
}
function snp_get_post_types()
{
    $return = array();
    $post_types_excluded = array('snp_popups', 'snp_ab', 'attachment', 'revision', 'nav_menu_item', 'mediapage');
    $post_types = get_post_types(array('public' => true));
    foreach ($post_types as $post_type)
    {
	if (!in_array($post_type, $post_types_excluded))
	{
	    $return[$post_type] = $post_type;
	}
    }
    return $return;
}
function snp_get_popups()
{
	$Return = array();
	$args = array(
		'numberposts' => 1000,
		'offset' => 0,
		'orderby' => 'title',
		'order' => 'ASC',
		'post_type' => 'snp_popups',
		'post_status' => 'publish',
		'suppress_filters' => true);
	$posts_array = get_posts($args);
	foreach ((array) $posts_array as $post)
	{
		$Return[$post->ID] = $post->post_title;
	}
	return $Return;
}
function snp_get_ab()
{
    $Return = array();
    $args = array(
	'numberposts'		 => 1000,
	'offset'		 => 0,
	'orderby'		 => 'title',
	'order'			 => 'ASC',
	'post_type'		 => 'snp_ab',
	'post_status'		 => 'publish',
	'suppress_filters'	 => true);
    $posts_array		 = get_posts($args);
    foreach ((array) $posts_array as $post)
    {
	$Return['ab_' . $post->ID] = 'A/B Testing: ' . $post->post_title;
    }
    return $Return;
}


function snp_get_current_url()
{
	$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
	if ($_SERVER["SERVER_PORT"] != "80")
	{
		$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
	}
	else
	{
		$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}
function snp_detect_names($name)
{
    $ar = array();
    $ret = list($fname, $lname) = preg_split('/ /', $name,2);
    $ar['first']=$ret[0];
    $ar['last']=$ret[1];
    return $ar;
}

function snp_custom_fields($cf, $atts)
{
    if (!is_array($cf))
    {
	echo 'Please update form settings!';
	return;
    }
    foreach ($cf as $k => $field)
    {
	if($k=='RAND')
	{
	   // continue;
	}
	if ($field['type'] == 'email')
	{
	    echo $atts['email_field'];
	}
	elseif ($field['type'] == 'name')
	{
	    if (!$atts['snp_name_disable'])
	    {
		echo $atts['name_field'];
	    }
	}
	else
	{
	    if ($field['type'] == 'Text')
	    {
		$FIELD_TPL = '<input type="text" name="%NAME%" value="" %REQUIRED% class="snp-field snp-field-%NAME% %CSSCLASS%" placeholder="%PLACEHOLDER%" id="snp-%NAME%" />';
	    }
	    if ($field['type'] == 'Textarea')
	    {
		$FIELD_TPL = '<textarea name="%NAME%" %REQUIRED% class="snp-field snp-field-%NAME% %CSSCLASS%" placeholder="%PLACEHOLDER%" id="snp-%NAME%"></textarea>';
	    }
	    if ($field['type'] == 'DropDown')
	    {
		$FIELD_TPL = '<select name="%NAME%" %REQUIRED% class="snp-field snp-field-%NAME% %CSSCLASS%" placeholder="%PLACEHOLDER%" id="snp-%NAME%" />';
		if ($field['placeholder'])
		{
		    $FIELD_TPL .= '<option value="" disabled selected>%PLACEHOLDER%</option>';
		}
		foreach ($field['options'] as $option)
		{
		    $FIELD_TPL .= '<option value="' . $option . '">' . $option . '</option>';
		}
		$FIELD_TPL .= '</select>';
	    }
	    if ($field['type'] == 'Hidden')
	    {
		$FIELD_TPL = '<input type="hidden" name="%NAME%" %REQUIRED% class="snp-field snp-field-%NAME% %CSSCLASS%" value="%PLACEHOLDER%" id="snp-%NAME%" />';
		$f='%FIELD%';
	    }
	    else
	    {
		$f	 = $atts['tpl_field'];
	    }
	    $f	 = str_replace('%FIELD%', $FIELD_TPL, $f);
	    $f	 = str_replace('%LABEL%', $field['label'], $f);
	    $f	 = str_replace('%PLACEHOLDER%', $field['placeholder'], $f);
	    if ($field['icon'])
	    {
		$field['cssclass']	 = trim($field['cssclass'] . ' ' . $field['icon']);
	    }
	    $f			 = str_replace('%CSSCLASS%', $field['cssclass'], $f);
	    $f			 = str_replace('%REQUIRED%', $field['required'] == 'Yes' ? 'required' : '', $f);
	    $f			 = str_replace('%NAME%', $field['name'], $f);
	    echo $f;
	}
    }
}

function snp_clone_form_link($actions, $post)
{
    // If the post_type is 'post', and the Quick Edit row action is set
    if (('snp_popups' == $post->post_type || 'snp_ab' == $post->post_type) && isset($actions['inline hide-if-no-js']))
    {
	unset($actions['inline hide-if-no-js']);
    }
    if ('snp_popups' == $post->post_type)
    {
	$snp_nonce		 = wp_create_nonce('snp_nonce');
	$actions['clone']	 = '<a href="' . admin_url("admin-ajax.php?action=snp_clone_form&nonce=" . $snp_nonce . "&post_id=" . $post->ID) . '" title="'
		. esc_attr(__("Clone this item", 'arscode'))
		. '">' . __('Clone', 'arscode') . '</a>';
    }
    return $actions;
}

add_filter('post_row_actions', 'snp_clone_form_link', 10, 2);
add_action('wp_ajax_snp_clone_form', 'snp_clone_form');

function snp_clone_form()
{
    if (isset($_GET['nonce']) && isset($_GET['post_id']))
    {
	$nonce	 = $_GET['nonce'];
	$post_id = $_GET['post_id'];
    }
    else
    {
	$nonce	 = $_POST['nonce'];
	$post_id = $_POST['post_id'];
    }
    if (!isset($nonce) || !wp_verify_nonce($nonce, 'snp_nonce'))
    {
	return;
    }
    if (!current_user_can('edit_post', $post_id) || !current_user_can('edit_page', $post_id))
    {
	return;
    }
    $old_post	 = get_post($post_id);
    $new_post	 = array(
	'post_status'	 => 'draft',
	'menu_order'	 => $old_post->menu_order,
	'post_type'	 => $old_post->post_type,
	'comment_status' => $old_post->comment_status,
	'ping_status'	 => $old_post->ping_status,
	'pinged'	 => $old_post->pinged,
	'post_author'	 => $old_post->post_author,
	'post_category'	 => $old_post->post_category,
	'post_content'	 => $old_post->post_content,
	'post_excerpt'	 => $old_post->post_excerpt,
	'post_name'	 => $old_post->post_name,
	'post_parent'	 => $old_post->post_parent,
	'post_password'	 => $old_post->post_password,
	'post_title'	 => $old_post->post_title . ' - ' . __('Copy', 'arscode') . '',
	'post_type'	 => $old_post->post_type,
	'tags_input'	 => $old_post->tags_input,
	'to_ping'	 => $old_post->to_ping,
	'tax_input'	 => $old_post->tax_input,
    );
    $new_post_id	 = wp_insert_post($new_post);
    $post_meta_keys	 = get_post_custom_keys($post_id);
    if (empty($post_meta_keys))
    {
	return;
    }

    foreach ($post_meta_keys as $meta_key)
    {
	$meta_values = get_post_custom_values($meta_key, $post_id);
	foreach ($meta_values as $meta_value)
	{
	    if (!in_array($meta_key, array('snp_views', 'snp_conversions')))
	    {
		$meta_value	 = maybe_unserialize($meta_value);
		add_post_meta($new_post_id, $meta_key, $meta_value);
	    }
	}
    }
    $redirect	 = add_query_arg(array('action' => 'edit', 'post'	 => $new_post_id, 'nonce'	 => null), 'post.php');
    wp_redirect($redirect);
    exit();
}

function snp_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   return implode(",", $rgb); // returns the rgb values separated by commas
   //return $rgb; // returns an array with the rgb values
}

$FB_Locales['en_GB'] = 'English (UK)';
$FB_Locales['af_ZA'] = 'Afrikaans';
$FB_Locales['ar_AR'] = 'Arabic';
$FB_Locales['az_AZ'] = 'Azeri';
$FB_Locales['be_BY'] = 'Belarusian';
$FB_Locales['bg_BG'] = 'Bulgarian';
$FB_Locales['bn_IN'] = 'Bengali';
$FB_Locales['bs_BA'] = 'Bosnian';
$FB_Locales['ca_ES'] = 'Catalan';
$FB_Locales['cs_CZ'] = 'Czech';
$FB_Locales['cy_GB'] = 'Welsh';
$FB_Locales['da_DK'] = 'Danish';
$FB_Locales['de_DE'] = 'German';
$FB_Locales['el_GR'] = 'Greek';
$FB_Locales['en_PI'] = 'English (Pirate)';
$FB_Locales['en_UD'] = 'English (Upside Down)';
$FB_Locales['en_US'] = 'English (US)';
$FB_Locales['eo_EO'] = 'Esperanto';
$FB_Locales['es_ES'] = 'Spanish (Spain)';
$FB_Locales['es_LA'] = 'Spanish';
$FB_Locales['et_EE'] = 'Estonian';
$FB_Locales['eu_ES'] = 'Basque';
$FB_Locales['fa_IR'] = 'Persian';
$FB_Locales['fb_LT'] = 'Leet Speak';
$FB_Locales['fi_FI'] = 'Finnish';
$FB_Locales['fo_FO'] = 'Faroese';
$FB_Locales['fr_CA'] = 'French (Canada)';
$FB_Locales['fr_FR'] = 'French (France)';
$FB_Locales['fy_NL'] = 'Frisian';
$FB_Locales['ga_IE'] = 'Irish';
$FB_Locales['gl_ES'] = 'Galician';
$FB_Locales['he_IL'] = 'Hebrew';
$FB_Locales['hi_IN'] = 'Hindi';
$FB_Locales['hr_HR'] = 'Croatian';
$FB_Locales['hu_HU'] = 'Hungarian';
$FB_Locales['hy_AM'] = 'Armenian';
$FB_Locales['id_ID'] = 'Indonesian';
$FB_Locales['is_IS'] = 'Icelandic';
$FB_Locales['it_IT'] = 'Italian';
$FB_Locales['ja_JP'] = 'Japanese';
$FB_Locales['ka_GE'] = 'Georgian';
$FB_Locales['ko_KR'] = 'Korean';
$FB_Locales['ku_TR'] = 'Kurdish';
$FB_Locales['la_VA'] = 'Latin';
$FB_Locales['lt_LT'] = 'Lithuanian';
$FB_Locales['lv_LV'] = 'Latvian';
$FB_Locales['mk_MK'] = 'Macedonian';
$FB_Locales['ml_IN'] = 'Malayalam';
$FB_Locales['ms_MY'] = 'Malay';
$FB_Locales['nb_NO'] = 'Norwegian (bokmal)';
$FB_Locales['ne_NP'] = 'Nepali';
$FB_Locales['nl_NL'] = 'Dutch';
$FB_Locales['nn_NO'] = 'Norwegian (nynorsk)';
$FB_Locales['pa_IN'] = 'Punjabi';
$FB_Locales['pl_PL'] = 'Polish';
$FB_Locales['ps_AF'] = 'Pashto';
$FB_Locales['pt_BR'] = 'Portuguese (Brazil)';
$FB_Locales['pt_PT'] = 'Portuguese (Portugal)';
$FB_Locales['ro_RO'] = 'Romanian';
$FB_Locales['ru_RU'] = 'Russian';
$FB_Locales['sk_SK'] = 'Slovak';
$FB_Locales['sl_SI'] = 'Slovenian';
$FB_Locales['sq_AL'] = 'Albanian';
$FB_Locales['sr_RS'] = 'Serbian';
$FB_Locales['sv_SE'] = 'Swedish';
$FB_Locales['sw_KE'] = 'Swahili';
$FB_Locales['ta_IN'] = 'Tamil';
$FB_Locales['te_IN'] = 'Telugu';
$FB_Locales['th_TH'] = 'Thai';
$FB_Locales['tl_PH'] = 'Filipino';
$FB_Locales['tr_TR'] = 'Turkish';
$FB_Locales['uk_UA'] = 'Ukrainian';
$FB_Locales['vi_VN'] = 'Vietnamese';
$FB_Locales['zh_CN'] = 'Simplified Chinese (China)';
$FB_Locales['zh_HK'] = 'Traditional Chinese (Hong Kong)';
$FB_Locales['zh_TW'] = 'Traditional Chinese (Taiwan)';