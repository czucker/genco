<?
	class CNGann_ShortCodes  extends CNGann_Lib  {

		/* Splits */

		public function splits ($atts, $content){
			extract(shortcode_atts(array(
				'class' => ''
			),$atts,'splits'));
			return "<div class='splits {$class} '>".do_shortcode($content).do_shortcode('[clear]')."</div>";
		}

		public function one_half ($atts, $content){
			extract(shortcode_atts(array(
				'right' =>false,
				'left' => false
			),$atts,'one_half'));
			return "<div class='split half one ". ( $left ? "l" : "" ) ." ".($right ? "r" : "")." '>".do_shortcode(wpautop($content, true))."</div>";
		}

		public function one_third ($atts, $content){
			extract(shortcode_atts(array(
				'right' => false,
				'left' => false
			),$atts,'one_third'));
			return "<div class='split third one ". ( $left ? "l" : "" ) ." ".($right ? "r" : "")." '>".do_shortcode(wpautop($content, true))."</div>";
		}

		public function two_thirds ($atts, $content){
			extract(shortcode_atts(array(
				'right' =>false,
				'left' => false
			),$atts,'two_thirds'));
			return "<div class='split third two ". ( $left ? "l" : "" ) ." ".($right ? "r" : "")." '>".do_shortcode(wpautop($content, true))."</div>";
		}

		public function one_fourth ($atts, $content){
			extract(shortcode_atts(array(
				'right' =>false,
				'left' => false
			),$atts,'one_fourth'));
			return "<div class='split fourth one ". ( $left ? "l" : "" ) ." ".($right ? "r" : "")." '>".do_shortcode(wpautop($content, true))."</div>";
		}

		public function two_fourths ($atts, $content){
			extract(shortcode_atts(array(
				'right' =>false,
				'left' => false
			),$atts,'two_fourths'));
			return "<div class='split fourth two ". ( $left ? "l" : "" ) ." ".($right ? "r" : "")." '>".do_shortcode(wpautop($content, true))."</div>";
		}

		public function three_fourths ($atts, $content){
			extract(shortcode_atts(array(
				'right' =>false,
				'left' => false
			),$atts,'three_fourths'));
			return "<div class='split fourth three ". ( $left ? "l" : "" ) ." ".($right ? "r" : "")." '>".do_shortcode(wpautop($content, true))."</div>";
		}

		public function one_fifth ($atts, $content){
			extract(shortcode_atts(array(
				'right' =>false,
				'left' => false
			),$atts,'one_fifth'));
			return "<div class='split fifth one ". ( $left ? "l" : "" ) ." ".($right ? "r" : "")." '>".do_shortcode(wpautop($content, true))."</div>";
		}

		public function two_fifths ($atts, $content){
			extract(shortcode_atts(array(
				'right' =>false,
				'left' => false
			),$atts,'two_fifths'));
			return "<div class='split fifth two ". ( $left ? "l" : "" ) ." ".($right ? "r" : "")." '>".do_shortcode(wpautop($content, true))."</div>";
		}

		public function three_fifths ($atts, $content){
			extract(shortcode_atts(array(
				'right' =>false,
				'left' => false
			),$atts,'three_fifths'));
			return "<div class='split fifth three ". ( $left ? "l" : "" ) ." ".($right ? "r" : "")." '>".do_shortcode(wpautop($content, true))."</div>";
		}

		public function four_fifths ($atts, $content){
			extract(shortcode_atts(array(
				'right' =>false,
				'left' => false
			),$atts,'three_fifths'));
			return "<div class='split fifth four ". ( $left ? "l" : "" ) ." ".($right ? "r" : "")." '>".do_shortcode(wpautop($content, true))."</div>";
		}


		/* Clear */

		public function clear ($atts, $content){
			extract(shortcode_atts(array(
			),$atts,'clear'));
			return "<div style='clear:both;'></div>";
		}

		/* More */

		public function more ($atts, $content){
			extract(shortcode_atts(array(
				'title'=>"Learn More..."
			),$atts, 'more'));
			return "<div class='more'><a href='#'>{$title}</a><div style='display:none;' class='the_more'>".do_shortcode(wpautop($content, true))."</div></div>";
		}

		public function spoiler ($atts, $content){
			$atts = shortcode_atts(array(
				'title'=>"Spoilers..."
			),$atts, 'spoiler');
			return $this->more($atts,$content);
		}

		public function spoil ($atts, $content){
			$atts = shortcode_atts(array(
				'title'=>"Spoilers..."
			),$atts, 'spoil');
			return $this->spoiler($atts,$content);
		}

		/* Tabs */

		public function tabs ($atts, $content){
			extract(shortcode_atts(array(
				'class' => ''
			),$atts,'tabs'));
			return "<div class='tabs {$class} '>".do_shortcode($content)."</div>";
		}

		public function tab ($atts, $content){
			extract(shortcode_atts(array(
				'title'=>"",
				'ttl' => ""
			),$atts, 'tab'));
			return "<div class='tab' ttl='".($title != "" ? $title : ($ttl != "" ? $ttl : "New Tab"))."'>".do_shortcode(wpautop($content, true))."</div>";
		}

		/* Slider */

		public function slider ($atts, $content){
			extract(shortcode_atts(array(
				'first'=>false,
				"height" => "",
				"h"=>""
			),$atts, 'slider'));
			$h = $height ? $height : ($h ? $h : "");
			$h = $this->get_size($h);
			return "<div class='slider ".( $first != '' ? 'first' : '' )."' hh='".( $h ? $h : "" )."' >".do_shortcode($content)."</div>";
		}

		public function slide ($atts, $content){
			extract(shortcode_atts(array(
				'href'=>false,
				'id' => false,
				'link' => false,
				'slug' => false,
				'src' => false,
				'anchor' => false
			),$atts, 'slide'));
			$href = $this->get_url( $href ? $href : ($id ? $id : ($link ? $link : ($slug ? $slug : "#") ) ) );
			if($anchor) $anchor = "#".$anchor;
			$src = $this->get_image($src);
			return "<div class='slide' href='{$href}{$anchor}' src='{$src}'>".do_shortcode($content)."</div>";
		}

		/* Hover */

		public function hover ($atts, $content){
			extract(shortcode_atts(array(
				'class' => ''
			),$atts,'hover'));
			return "<div class='hover {$class} '>".do_shortcode(wpautop($content, true))."</div>";
		}

		public function on ($atts, $content){
			extract(shortcode_atts(array(
			),$atts,'on'));
			return "<div class='on'>".do_shortcode(wpautop($content, true))."</div>";
		}

		public function off ($atts, $content){
			extract(shortcode_atts(array(
			),$atts,'off'));
			return "<div class='off'>".do_shortcode(wpautop($content, true))."</div>";
		}

		/* Person */

		public function person ($atts, $content){
			extract(shortcode_atts(array(
				'src'=>  plugins_url('/images/def_person.png', ___FILE___),
				'name' => "",
				'jobtitle' => "",
				'email' => "",
				'phone' => ""
			),$atts, 'person'));
			$src = $this->get_image($src);
			return "
				<div class='person'>
					<img src='{$src}'>".
					( $name ? "<strong>{$name}</strong><br>" : "").
					( $jobtitle ? "<em>{$jobtitle}</em><br>" : "").
					( $email ? "<a href='mailto:{$email}'>Contact by Email</a><br>" : "").
					( $phone ? "<a href='tel:{$phone}'>{$phone}</a><br>" : "").
					"
				</div>
			";
		}

		/* Background */

		public function background ($atts, $content){
			extract(shortcode_atts(array(
				'src'=>"",
				'height' => "",
				'width' => "",
				'class' => "",
				'bgcolor' => "transparent",
				'color' => "inherit",
				'repeat' => "no-repeat",
				'position' => "top left",
				'padding' => "0px 0px 0px 0px"
			),$atts, 'background'));

			$src = $this->get_image($src);
			$height = $this->get_size($height);
			$width = $this->get_size($width);
			return "<div class='background {$class}' style=\" color: {$color}; background: {$bgcolor} " . ( $src ? "url('{$src}') {$repeat} {$position} " : "" ) . "; padding:{$padding}; min-height:{$height}; ".($width ? "width:{$width}; display: inline-block;" : "display: block;")."\" >".do_shortcode(wpautop($content, true))."</div>";
		}

		/* Flash Card */

		public function flashcard ($atts, $content){
			extract(shortcode_atts(array(
				'height' => '0',
				'width' => '0',
				'class' => ''
			), $atts, 'flashcard'));
			$height = $this->get_size($height);
			$width = $this->get_size($width);
			return "<div class='flashcard ".($this->is_ie() ? "IE":"")." ".$class."' style='".($height ? 'height:'.$height.';' : '')." ".($width ? 'width:'.$width.';' : '')."' ><div class='card'>".do_shortcode(wpautop($content, true))."</div></div>";
		}

		public function front ($atts, $content){
			extract(shortcode_atts(array(
				'click' => 'all'
			),$atts,'front'));
			return "<figure class='front' click='{$click}'>".do_shortcode(wpautop($content, true))."</figure>";
		}

		public function back ($atts, $content){
			extract(shortcode_atts(array(
				'click' => 'all'
			),$atts,'back'));
			return "<figure class='back' click='{$click}'>".do_shortcode(wpautop($content, true))."</figure>";
		}

		/* Link Map */

		public function linkmap ($atts, $content){
			extract(shortcode_atts(array(
				'height' => '',
				'width' => '',
				'class' => '',
				'src'	=> '',
				'hover_src' => '',
				'flashcard' => '',
				'bgcolor'   => 'transparent',
			), $atts, 'linkmap'));
			$height = $this->get_size($height);
			$width = $this->get_size($width);
			$flashcard = $flashcard != '';
			$src = $this->get_image($src);
			$hover_src = $this->get_image($hover_src);
			return "<link-map class='".$class."  ".($this->is_ie() ? "IE":"")." " . ($flashcard ? "fc' fc=\"{$flashcard}\"" : "'") . "  src='".$src."' style=\"height:{$height}; width:{$width}; background: {$bgcolor} url('{$src}') no-repeat top left; \" h='".$height."' w='".$width."' ".($hover_src ? " hoverSrc='{$hover_src}' " : '')." >".do_shortcode($content)."</link-map>";
		}

		public function maplink ($atts, $content){
			extract(shortcode_atts(array(
				'height' => '0',
				'width' => '0',
				'class' => '',
				'top' => '0',
				'left' => '0',
				'href'=>false,
				'id' => false,
				'link' => false,
				'slug' => false,
				'anchor' => false,
				'fc' => ''
			), $atts, 'map_link'));
			$href = $this->get_url( $href ? $href : ($id ? $id : ($link ? $link : ($slug ? $slug : "#") ) ) );
			if($anchor) $anchor = "#".$anchor;
			$height = $this->get_size($height);
			$width = $this->get_size($width);
			return "<map-link class='link {$class}' fc=\"{$fc}\" style=\"height:{$height}; width:{$width}; top: {$top}; left:{$left};\"  h='".$height."' w='".$width."' ltop='".$top."' lleft='".$left."' href=\"{$href}{$anchor}\">".do_shortcode(wpautop($content, true))."</map-link>";
		}

		public function link ($atts, $content){
			extract(shortcode_atts(array(
				'href'	=> false,
				'id' 	=> false,
				'link' 	=> false,
				'slug' 	=> false,
				'anchor' => false,
				'class'	=> ""
			),$atts, 'link'));
			if(!$content){
				if( is_numeric( $href ? $href : ($id ? $id : ($link ? $link : ($slug ? $slug : "#") ) ) ) ) $content ="[title id='".($href ? $href : ($id ? $id : ($link ? $link : ($slug ? $slug : "#") ) ))."']";
			}
			$href = $this->get_url( $href ? $href : ($id ? $id : ($link ? $link : ($slug ? $slug : "#") ) ) );
			if($anchor) $anchor = "#".$anchor;
			return "<a href='{$href}{$anchor}' class='{$class}'>".do_shortcode($content)."</a>";
		}

		public function title ($atts, $content){
			extract(shortcode_atts(array(
				'id'=>"",
				'slug'=>""
			),$atts, 'link'));
			if(!$id && $slug) $id = $wpdb->get_var("SELECT ID FROM {$wpdb->posts} WHERE post_name = '{$slug}'");
			if($id) $title = get_the_title($id);
			else $title = get_the_title();
			return $title;
		}

		public function button ($atts,$content){
			extract(shortcode_atts(array(
				'title' => 'Submit',
				'class' => ""
			),$atts, 'button'));
			return "<div class='button {$class}'>{$title}</div>";
		}

		public function buttons ($atts,$content){
			extract(shortcode_atts(array(
				'align' => "right"
			),$atts, 'buttons'));
			return "<div class='buttons' style='text-align:{$align}'>".do_shortcode($content)."</div>";
		}

		public function email_form ($atts, $content){
			extract(shortcode_atts(array(
				'height' => '620px',
				'width' => '100%',
				'title' => 'Get Connected',
				'above_form' => "Please enter your contact information and we will connect with you to answer any and all of your questions.",
				'email' => 'Email Address',
				'name' => 'First and Last Name',
				'company' => 'Company Name',
				'phone' => 'Phone Number',
				'content' => 'Comments',
				'get_emails' => 'Yes, I would like to receive the newsletters.',
				'button' => 'Get Connected',
				'type' => 'email',
				'error' => "There was an error connecting you.",
				'success' => "You are now connected."
			),$atts, 'email_form'));
			$height = $this->get_size($height);
			$width = $this->get_size($width);
			$form = "<div class='email_form' height='{$height}' width='{$width}' error=\"{$error}\" success=\"{$success}\">".
					"<h2>{$title}</h2>".
					"<p>{$above_form}</p>".
					"<input type='hidden' name='email_form' value='{$type}' />".
					"<input type='text' name='name' value='' placeholder='{$name}' />".
					"<input type='text' name='company' value='' placeholder='{$company}' />".
					"<input type='text' name='email' value='' placeholder='{$email}' />".
					"<input type='text' name='phone' value='' placeholder='{$phone}' />".
					"<textarea name='content' placeholder='{$content}'></textarea>".
					"<div class='checkboxarea'><input type='checkbox' name='get_emails' id='getEmails' value='y'><label for='getEmails'>{$get_emails}</label></div>".
					"[buttons align='right'][button title='{$button}' class='submit'][/buttons]".
				"</div>";
			return do_shortcode($form);
		}

		public function fake_footer($atts, $content){
			extract(shortcode_atts(array(
			),$atts, 'buttons'));
			return do_shortcode("<div class='fake_footer'>{$content}</div>");
		}

		public function anchor($atts, $content){
			extract(shortcode_atts(array(
				'name' => false
			),$atts, 'anchor'));
			if(!$name) return "";
			return "<a class='anchor' name='{$name}'></a>";
		}
	}