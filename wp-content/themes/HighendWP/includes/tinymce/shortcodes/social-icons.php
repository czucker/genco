<script type="text/javascript">
var SocialDialog = {
	local_ed : 'ed',
	init : function(ed) {
		SocialDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var style = jQuery('#socials-style').val();
		var size = jQuery('#socials-size').val();
		var animation = jQuery('#skill-entrance-animation').val();
		var animation_delay = jQuery('#skill-entrance-delay').val();
		var extra_class = jQuery('#skill-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[social_icons';

		output += ' style=\"'+ style +'\"';
		output += ' size=\"'+ size +'\"';

		if ( jQuery('#new-tab').is(':checked') ){
			output += ' target=\"_blank\"';
		}

		jQuery('#social-icons-wrap input[type=text]').each(function() {
			$that = jQuery(this);
			$link = "";
			$id = "";

			if ($that.val() != ''){
				$link = $that.val();
				$id = $that.attr('id');

				output += ' ' + $id + '="' + $link + '"';
			}
			
		});

		if (animation != 'none'){
			output += ' animation=\"'+ animation +'\"';
		}

		if (animation_delay != '' && animation != 'none'){
			output += ' animation_delay=\"'+ animation_delay +'\"';
		}

		if (extra_class != '') {
			output += ' class=\"'+extra_class+'\"';
		}
		
		output += ']';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(SocialDialog.init, SocialDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

		<div class="form-section clearfix">
            <label for="socials-style">Icon Style.<br/><small>Choose style for social icons.</small></label>
            <select name="socials-style" id="socials-style">
            	<option value="dark" selected>Dark</option>
            	<option value="light">Light</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="socials-size">Icon Size.<br/><small>Choose size for social icons.</small></label>
            <select name="socials-size" id="socials-size">
            	<option value="small" selected>Small</option>
            	<option value="large">Large</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="new-tab"><small>Open links in new tab?</small></label>
            <input name="new-tab" id="new-tab" value="new-tab" type="checkbox" />
        </div>

		<div id="social-icons-wrap">

	        <div class="form-section clearfix">
	            <label for="twitter">Twitter URL.<br/><small>Enter your Twitter URL with http:// prefix. Leave empty to ignore.</small></label>
	            <input type="text" name="twitter" id="twitter" placeholder="Example: http://twitter.com/hbthemes"></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="facebook">Facebook URL.<br/><small>Enter your facebook URL with http:// prefix. Leave empty to ignore.</small></label>
	            <input type="text" name="facebook" id="facebook" placeholder="Example: http://facebook.com/hbthemes"></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="skype">Skype URL.<br/><small>Enter your Skype URL. Leave empty to ignore.</small></label>
	            <input type="text" name="skype" id="skype" placeholder="Enter link here..."></textarea>
	        </div>

	         <div class="form-section clearfix">
	            <label for="instagram">Instagram URL.<br/><small>Enter your Instagram URL. Leave empty to ignore.</small></label>
	            <input type="text" name="instagram" id="instagram" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="pinterest">Pinterest URL.<br/><small>Enter your Pinterest URL. Leave empty to ignore.</small></label>
	            <input type="text" name="pinterest" id="pinterest" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="googleplus">Google Plus URL.<br/><small>Enter your Google Plus URL. Leave empty to ignore.</small></label>
	            <input type="text" name="googleplus" id="googleplus" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="dribbble">Dribbble URL.<br/><small>Enter your Dribbble URL. Leave empty to ignore.</small></label>
	            <input type="text" name="dribbble" id="dribbble" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="digg">Digg URL.<br/><small>Enter your Digg URL. Leave empty to ignore.</small></label>
	            <input type="text" name="digg" id="digg" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="myspace">MySpace URL.<br/><small>Enter your MySpace URL. Leave empty to ignore.</small></label>
	            <input type="text" name="myspace" id="myspace" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="soundcloud">SoundCloud URL.<br/><small>Enter your SoundCloud URL. Leave empty to ignore.</small></label>
	            <input type="text" name="soundcloud" id="soundcloud" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="youtube">Youtube URL.<br/><small>Enter your Youtube URL. Leave empty to ignore.</small></label>
	            <input type="text" name="youtube" id="youtube" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="vimeo">Vimeo URL.<br/><small>Enter your Vimeo URL. Leave empty to ignore.</small></label>
	            <input type="text" name="vimeo" id="vimeo" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="flickr">Flickr URL.<br/><small>Enter your Flickr URL. Leave empty to ignore.</small></label>
	            <input type="text" name="flickr" id="flickr" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="tumblr">Tumblr URL.<br/><small>Enter your Tumblr URL. Leave empty to ignore.</small></label>
	            <input type="text" name="tumblr" id="tumblr" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="yahoo">Yahoo URL.<br/><small>Enter your Yahoo URL. Leave empty to ignore.</small></label>
	            <input type="text" name="yahoo" id="yahoo" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="foursquare">Foursquare URL.<br/><small>Enter your Foursquare URL. Leave empty to ignore.</small></label>
	            <input type="text" name="foursquare" id="foursquare" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="blogger">Blogger URL.<br/><small>Enter your Blogger URL. Leave empty to ignore.</small></label>
	            <input type="text" name="blogger" id="blogger" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="wordpress">WordPress URL.<br/><small>Enter your WordPress URL. Leave empty to ignore.</small></label>
	            <input type="text" name="wordpress" id="wordpress" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="lastfm">LastFM URL.<br/><small>Enter your LastFM URL. Leave empty to ignore.</small></label>
	            <input type="text" name="lastfm" id="lastfm" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="github">GitHub URL.<br/><small>Enter your GitHub URL. Leave empty to ignore.</small></label>
	            <input type="text" name="github" id="github" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="linkedin">LinkedIn URL.<br/><small>Enter your Linkedin URL. Leave empty to ignore.</small></label>
	            <input type="text" name="linkedin" id="linkedin" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="vk">VKontakte URL.<br/><small>Enter your VKontakte URL. Leave empty to ignore.</small></label>
	            <input type="text" name="vk" id="vk" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="yelp">Yelp URL.<br/><small>Enter your Yelp URL. Leave empty to ignore.</small></label>
	            <input type="text" name="yelp" id="yelp" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="forrst">Forrst URL.<br/><small>Enter your Forrst URL. Leave empty to ignore.</small></label>
	            <input type="text" name="forrst" id="forrst" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="deviantart">DeviantArt URL.<br/><small>Enter your DeviantArt URL. Leave empty to ignore.</small></label>
	            <input type="text" name="deviantart" id="deviantart" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="stumbleupon">StumbleUpon URL.<br/><small>Enter your StumbleUpon URL. Leave empty to ignore.</small></label>
	            <input type="text" name="stumbleupon" id="stumbleupon" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="delicious">Delicious URL.<br/><small>Enter your Delicious URL. Leave empty to ignore.</small></label>
	            <input type="text" name="delicious" id="delicious" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="reddit">Reddit URL.<br/><small>Enter your Reddit URL. Leave empty to ignore.</small></label>
	            <input type="text" name="reddit" id="reddit" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="reddit">Xing URL.<br/><small>Enter your Xing URL. Leave empty to ignore.</small></label>
	            <input type="text" name="xing" id="xing" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="behance">Behance URL.<br/><small>Enter your Behance URL with http:// prefix. Leave empty to ignore.</small></label>
	            <input type="text" name="behance" id="behance" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="email">Email URL.<br/><small>Enter your Email URL. Leave empty to ignore.</small></label>
	            <input type="text" name="email" id="email" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="rss">RSS URL.<br/><small>Enter your RSS URL. Leave empty to ignore.</small></label>
	            <input type="text" name="rss" id="rss" placeholder="Enter link here..."></textarea>
	        </div>

	        <div class="form-section clearfix">
	            <label for="custom-url">Custom URL.<br/><small>Enter your Custom URL. Leave empty to ignore.</small></label>
	            <input type="text" name="custom-url" id="custom-url" placeholder="Enter link here..."></textarea>
	        </div>

    	</div>
    	<!-- END wrap -->

        <div class="form-section clearfix">
            <label for="skill-entrance-animation">Entrance Animation.<br/><small>Choose an entrance animation for this element.</small></label>
            <select name="skill-entrance-animation" id="skill-entrance-animation">
            	<option value="none" selected>None</option>
            	<option value="fade-in">Fade In</option>
            	<option value="scale-up">Scale Up</option>
            	<option value="right-to-left">Right to Left</option>
            	<option value="left-to-right">Left to Right</option>
            	<option value="top-to-bottom">Top to Bottom</option>
            	<option value="bottom-to-top">Bottom to Top</option>
            	<option value="helix">Helix</option>
            	<option value="flip-x">Flip X</option>
            	<option value="flip-y">Flip Y</option>
            	<option value="spin">Spin</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="skill-entrance-delay">Entrance Delay.<br/><small>Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)</small></label>
            <input name="skill-entrance-delay" id="skill-entrance-delay" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="skill-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="skill-extra-class" id="skill-extra-class" type="text" />
        </div>
         
    <a href="javascript:SocialDialog.insert(SocialDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>