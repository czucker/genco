<script type="text/javascript">
var OnePageSectionDialog = {
	local_ed : 'ed',
	init : function(ed) {
		OnePageSectionDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var id = jQuery('#onepage-id').val();
		var name = jQuery('#onepage-name').val();
		var content = jQuery('#onepage-content').val();
		var background_type = jQuery('#background-type').val();
		var text_color = jQuery('#text-color').val();
		var bg_color = jQuery('#bg-color').val();
		var image = jQuery('#image').val();
		var bg_video_mp4 = jQuery('#bg-video-mp4').val();
		var bg_video_ogv = jQuery('#bg-video-ogv').val();
		var poster = jQuery('#poster').val();
		var margin_top = jQuery('#margin-top').val();
		var margin_bottom = jQuery('#margin-bottom').val();
		var padding_top = jQuery('#padding-top').val();
		var padding_bottom = jQuery('#padding-bottom').val();
		var extra_class = jQuery('#extra-class').val();
		var border = jQuery('#border').is(':checked');
		var parallax = jQuery('#parallax').is(':checked');
		var scissors_icon = jQuery('#scissors_icon').is(':checked');
		var overlay = jQuery('#overlay').is(':checked');

		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[onepage_section';
		output += ' id=\"' + id + '\"';
		output += ' name=\"' + name + '\"';
		output += ' content=\"' + content + '\"';
		output += ' background_type=\"' + background_type + '\"';
		output += ' text_color=\"' + text_color + '\"';
		
		if ( bg_color != "" )
			output += ' bg_color=\"' + bg_color + '\"';
		
		if ( bg_video_mp4 != "" )
			output += ' bg_video_mp4=\"' + bg_video_mp4 + '\"';

		if ( bg_video_ogv != "" )
			output += ' bg_video_ogv=\"' + bg_video_ogv + '\"';
		
		if ( poster != "" )
			output += ' poster=\"' + poster + '\"';

		if ( parallax )
			output += ' parallax=\"yes\"';

		if ( border )
			output += ' border=\"yes\"';
		
		if ( scissors_icon )
			output += ' scissors_icon=\"yes\"';

		if ( overlay )
			output += ' overlay=\"yes\"';

		if ( image != "" )
			output += ' image=\"' + image + '\"';

		if ( margin_top != "" )
			output += ' margin_top=\"' + margin_top + '\"';

		if ( margin_bottom != "" )
			output += ' margin_bottom=\"' + margin_bottom + '\"';
		
		if ( padding_top != "" )
			output += ' padding_top=\"' + padding_top + '\"';
		
		if ( padding_bottom != "" )
			output += ' padding_bottom=\"' + padding_bottom + '\"';
		
		if ( extra_class != "" )
			output += ' extra_class=\"' + extra_class + '\"';
		

		output += ']';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(OnePageSectionDialog.init, OnePageSectionDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

		<div class="form-section clearfix">
            <label for="onepage-id">Unique Section ID.<br/><small>Enter a UNIQUE section id, without whitespaces. This is very important for One Page websites, as this will be used for a navigation. For example, if you have entered <strong>first-page</strong> in this field, in your menu, you would enter <strong>#first-page</strong> to link to this page.</small></label>
            <input type="text" name="onepage-id" id="onepage-id" placeholder="Example: first-page"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="onepage-name">Section Title.<br/><small>Enter title for this section. It will be used in left circle navigation on one page websites.</small></label>
            <input type="text" name="onepage-name" id="onepage-name" placeholder="Example: First Page"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="onepage-content">Content.<br/></label>
            <textarea name="onepage-content" id="onepage-content" placeholder="Example: Page Content"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="background-type">Background Type.<br/><small>Select a background type for this element.</small></label>
            <select name="background-type" id="background-type">
            	<option value="color" select>Background Color</option>
            	<option value="image">Background Image</option>
            	<option value="texture">Background Texture</option>
            	<option value="video">Background Video</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="border"><small>Enable Border?</small></label>
            <input name="border" id="border" value="border" type="checkbox" />
        </div>

		<div class="form-section clearfix">
            <label for="text-color">Text Color.<br/><small>Choose background color in hex format.</small></label>
            <select name="text-color" id="text-color">
            	<option value="dark" select>Dark</option>
            	<option value="light">Light</option>
            </select>
        </div>       

        <div class="form-section clearfix">
            <label for="bg-color">Background Color.<br/><small>Enter a focus color for this element in hex format. Example #ff6838</small></label>
            <input name="bg-color" id="bg-color" type="text" placeholder="Example: #ff6838" />
        </div>

        <div class="form-section clearfix">
            <label for="image">Background Image or Texture.<br/><small>URL to an image from media library that will be used as your background image or texture depending on value in Background Type.</small></label>
            <input type="text" name="image" id="image" placeholder=""></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="parallax"><small>Enable Parallax effect for image?</small></label>
            <input name="parallax" id="parallax" value="parallax" type="checkbox" />
        </div>

        <div class="form-section clearfix">
            <label for="scissors-icon"><small>Optional Scissors Icon?</small></label>
            <input name="scissors-icon" id="scissors-icon" value="scissors-icon" type="checkbox" />
        </div>

        <div class="form-section clearfix">
            <label for="bg-video-mp4">Background Video MP4.<br/><small>If you have chosen "Background Video" for the Background Type, enter link to your video in MP4 format here.</small></label>
            <input type="text" name="bg-video-mp4" id="bg-video-mp4" placeholder=""></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="bg-video-ogv">Background Video OGV.<br/><small>If you have chosen "Background Video" for the Background Type, enter link to your video in OGV format here.</small></label>
            <input type="text" name="bg-video-ogv" id="bg-video-ogv" placeholder=""></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="poster">Background Video Poster.<br/><small>Enter URL to an image that will be used as a placeholder until video is loaded (or cannot be loaded).</small></label>
            <input type="text" name="poster" id="poster" placeholder=""></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="overlay"><small>Video Texture Overlay?</small></label>
            <input name="overlay" id="overlay" value="overlay" type="checkbox" />
        </div>

        <div class="form-section clearfix">
            <label for="margin-top">Margin Top.<br/><small>Enter top margin for this section in pixels. Leave empty for default value. No need to write px. Eg: 40</small></label>
            <input type="text" name="margin-top" id="margin-top" placeholder="Example: 40"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="margin-bottom">Margin Bottom.<br/><small>Enter bottom margin for this section in pixels. Leave empty for default value. No need to write px. Eg: 40.</small></label>
            <input type="text" name="margin-bottom" id="margin-bottom" placeholder="Example: 40"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="padding-top">Padding Top.<br/><small>Enter top padding for this section in pixels. Leave empty for default value. No need to write px. Eg: 50</small></label>
            <input type="text" name="padding-top" id="padding-top" placeholder="Example: 50"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="padding-bottom">Padding Bottom.<br/><small>Enter bottom padding for this section in pixels. Leave empty for default value. No need to write px. Eg: 50</small></label>
            <input type="text" name="padding-bottom" id="padding-bottom" placeholder="Example: 50"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="extra-class" id="extra-class" type="text" />
        </div>
         
    <a href="javascript:OnePageSectionDialog.insert(OnePageSectionDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>