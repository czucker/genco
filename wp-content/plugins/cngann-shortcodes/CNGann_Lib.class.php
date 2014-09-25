<?php
	class CNGann_Lib{
		public function get_methods(){
			$my_methods = get_class_methods($this);
			$lib_methods = get_class_methods('CNGann_Lib');
			$return = array();
			foreach($my_methods as $method){
				if(in_array($method, $lib_methods)) continue;
				if(str_replace('__','',$method) != $method) continue;
				$return[] = $method;
			}
			return $return;
		}
		public function get_image($i){
			$r = false;
			$tmp = wp_get_attachment_image_src($i,'full');
			if(is_numeric($i)) $r = $tmp[0]; // ID
			else if(str_replace('//','',$i) != $i) $r = $i; // is external link
			else if(file_exists( ___DIR___ . '/' . $i) ) $r = plugins_url($i,___FILE___);
			return $r;
		}
		public function get_url($i){
			global $wpdb;
			if($i === '#') return $i;
			if($i === '') return $i;
			if(is_numeric($i)) return get_permalink($i); // ID
			else if(str_replace('//','',$i) != $i) return $i; // is external link
			else if(file_exists( ___DIR___ . '/' . $i) ) return plugins_url($i,___FILE___);
			else if($wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name = '{$i}'")) return get_permalink($wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name = '{$i}'"));
			else return $i; // relative link
			return $i;
		}
		public function get_size($i){
			if($i != str_replace('px','',$i)) return $i;
			if($i != str_replace('%','',$i)) return $i;
			if($i != str_replace('em','',$i)) return $i;
			if($i != str_replace('pt','',$i)) return $i;
			if($i != str_replace('in','',$i)) return $i;
			if(is_numeric($i)) return $i . 'px';
			return false;
		}
		public function is_ie(){
			if (preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false)) return true;
			else return false;
		}
	}