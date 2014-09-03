<?php
if(!function_exists("get_all_modals")){
function enqueue_modal($id)
{
    if(!is_array($id))
        EModal_Modals::enqueue_modal($id);
    else
        foreach($id as $i)
            EModal_Modals::enqueue_modal($i);
}}

if(!function_exists("emodal_get_option")){
function emodal_get_option($key)
{
	global $blog_id;
	if(function_exists('is_multisite') && is_multisite() && $blog_id)
	{
		return get_blog_option($blog_id, $key);
	}
	else
	{
		return get_site_option($key);
	}
}}


if(!function_exists("emodal_update_option")){
function emodal_update_option($key, $value) {
	global $blog_id;
	if(function_exists('is_multisite') && is_multisite() && $blog_id)
	{
		return update_blog_option($blog_id, $key, $value);
	}
	else
	{
		return update_site_option($key, $value);
	}
}}

if(!function_exists("emodal_delete_option")){
function emodal_delete_option($key) {
	global $blog_id;
	if(function_exists('is_multisite') && is_multisite() && $blog_id)
	{
		return delete_blog_option($blog_id, $key);
	}
	else
	{
		return delete_site_option($key);
	}
}}

if(!function_exists("emodal_get_license")){
function emodal_get_license($key = NULL) {
	$license = emodal_get_option(EMCORE_SLUG.'-license');
	if(!$license)
	{
		$license = array(
			'valid' => false,
			'key' => '',
			'status' => array(
				'code' => NULL,
				'message' => NULL,
				'expires' => NULL,
				'domains' => NULL
			)
		);
		emodal_update_option(EMCORE_SLUG.'-license', $license);
	}
	return $license && $key ? emresolve($license, $key) : $license;
}}


if(!function_exists("emresolve")){
function emresolve(array $a, $path, $default = null){
    $current = $a;
    $p = strtok($path, '.');
    while ($p !== false) {
        if (!isset($current[$p])) {
            return $default;
        }
        $current = $current[$p];
        $p = strtok('.');
    }
  return $current;
}}

if (!function_exists('array_replace_recursive'))
{
	function array_replace_recursive($array, $array1)
	{
		// handle the arguments, merge one by one
		$args = func_get_args();
		$array = $args[0];
		if (!is_array($array))
		{
			return $array;
		}
		for ($i = 1; $i < count($args); $i++)
		{
			if (is_array($args[$i]))
			{
				$array = recurse($array, $args[$i]);
			}
		}
		return $array;
	}
}
if (!function_exists('recurse'))
{
	function recurse($array, $array1)
	{
		foreach ($array1 as $key => $value)
		{
			// create new key in $array, if it is empty or not an array
			if (!isset($array[$key]) || (isset($array[$key]) && !is_array($array[$key])))
			{
				$array[$key] = array();
			}

			// overwrite the value in the base array
			if (is_array($value))
			{
				$value = recurse($array[$key], $value);
			}
			$array[$key] = $value;
		}
		return $array;
	}
}

if(!function_exists("emodal_debug")){ 
function emodal_debug($var){
    echo '<pre>'; var_dump($var); echo '</pre>';
}}