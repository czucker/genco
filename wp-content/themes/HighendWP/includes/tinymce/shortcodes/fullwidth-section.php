<script type="text/javascript">
var FWDialog = {
	local_ed : 'ed',
	init : function(ed) {
		FWDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var id = jQuery('#fw-unique-id').val();
        var bg_type = jQuery('#fw-bg-type').val();
        var bg_color = jQuery('#fw-bg-color').val();
        var bg_image = jQuery('#fw-bg-image').val();
		var text_color = jQuery('#color-style').val();
        var bg_video = jQuery('#fw-bg-video').val();
        var bg_video_ogv = jQuery('#fw-bg-video-ogv').val();
        var extra_class = jQuery('#fw-extra-class').val();
        var margin_top = jQuery('#fw-margin-top').val();
        var margin_bottom = jQuery('#fw-margin-bottom').val();
        var padding_top = jQuery('#fw-padding-top').val();
        var padding_bottom = jQuery('#fw-padding-bottom').val();

		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[fullwidth_section';

		output += ' text_color="' + text_color + '"';
		output += ' background_type="' + bg_type + '"';
		
        if (bg_type == 'color'){
            output += ' bg_color="' + bg_color + '"';
        }

        if ( jQuery('#fw-border').is(':checked') ){
            output += ' border=\"yes\"';
        }

        if (bg_type == 'image' || bg_type == 'texture'){
            output += ' image="' + bg_image + '"';
        }

        if ( bg_type == 'image' && jQuery('#fw-parallax').is(':checked') ){
            output += ' parallax=\"yes\"';
        }

        if (bg_type == 'video'){
            output += ' bg_video_mp4="' + bg_video + '"';
            output += ' bg_video_ogv="' + bg_video_ogv + '"';
            output += ' poster="' + fw-bg-video-poster + '"';

            if ( jQuery('#fw-bg-video-overlay').is(':checked') ){
                output += ' overlay="yes"';
            }
        }

        if ( jQuery('#scissors-icon').is(':checked') ){
            output += ' scissors_icon=\"yes\"';
        }

        if (margin_top != '') {
            output += ' margin_top=\"'+margin_top+'\"';
        }

        if (margin_bottom != '') {
            output += ' margin_bottom=\"'+margin_bottom+'\"';
        }

        if (padding_top != '') {
            output += ' padding_top=\"'+padding_top+'\"';
        }

        if (padding_bottom != '') {
            output += ' padding_bottom=\"'+padding_bottom+'\"';
        }

		if (extra_class != '') {
			output += ' class=\"'+extra_class+'\"';
		}

        if (id != '') {
            output += ' id=\"'+id+'\"';
        }
		
		output += ']';

		output += 'Enter fullwidth section content here. You can use shortcodes also.';

		output += '[/fullwidth_section]';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(FWDialog.init, FWDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

        <div class="form-section clearfix">
            <label for="fw-bg-type">Background Type.<br/><small>Select a background type for this element.</small></label>
            <select name="bg-type" id="fw-bg-type">
                <option value="color" selected>Background Color</option>
                <option value="image">Background Image</option>
                <option value="texture">Background Texture</option>
                <option value="video">Background Video</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="fw-border"><small>Enable Border?</small></label>
            <input name="fw-border" id="fw-border" value="fw-border" type="checkbox" />
        </div>

        <div class="form-section clearfix">
            <label for="color-style">Text Color.<br/><small>Select a text color style for this element. Use light when your background is dark and opposite.</small></label>
            <select name="color-style" id="color-style">
                <option value="dark" selected>Dark Text</option>
                <option value="light">Light Text</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="fw-bg-color">Background Color.<br/><small>Enter background color in hex format. Example: #336699</small></label>
            <input name="fw-bg-color" id="fw-bg-color" type="text" placeholder="#336699" />
        </div>

        <div class="form-section clearfix">
            <label for="fw-bg-image">Background Image or Texture.<br/><small>If you have chosen "Background Image" or "Background Texture" for the Background Type, then enter the URL of your image here. Enter the URL with http:// prefix.</small></label>
            <input name="fw-bg-image" id="fw-bg-image" type="text" />
        </div>

        <div class="form-section clearfix">
            <label for="fw-parallax"><small>Enable Parallax Effect for image?</small></label>
            <input name="fw-parallax" id="fw-parallax" value="fw-parallax" type="checkbox" />
        </div>

        <div class="form-section clearfix">
            <label for="scissors-icon"><small>Optional Scissors Icon?</small></label>
            <input name="scissors-icon" id="scissors-icon" value="scissors-icon" type="checkbox" />
        </div>

        <div class="form-section clearfix">
            <label for="fw-bg-video">Background Video MP4.<br/><small>If you have chosen "Background Video" for the Background Type, then enter the URL of your video in MP4 format here. Enter the URL with http:// prefix.</small></label>
            <input name="fw-bg-video" id="fw-bg-video" type="text" />
        </div>

        <div class="form-section clearfix">
            <label for="fw-bg-video-ogv">Background Video OGV.<br/><small>If you have chosen "Background Video" for the Background Type, then enter the URL of your video in OGV format here. Enter the URL with http:// prefix.</small></label>
            <input name="fw-bg-video-ogv" id="fw-bg-video-ogv" type="text" />
        </div>

        <div class="form-section clearfix">
            <label for="fw-bg-video-poster">Background Video Poster.<br/><small>An image that will be used as a placeholder until video is loaded (or cannot be loaded). Enter the URL with http:// prefix.</small></label>
            <input name="fw-bg-video-poster" id="fw-bg-video-poster" type="text" />
        </div>

        <div class="form-section clearfix">
            <label for="fw-bg-video-overlay"><small>Video Texture Overlay?</small></label>
            <input name="fw-bg-video-overlay" id="fw-bg-video-overlay" value="fw-bg-video-overlay" type="checkbox" />
        </div>

        <div class="form-section clearfix">
            <label for="fw-margin-top">Margin Top.<br/><small>Enter top margin for this section in pixels. Leave empty for default value. No need to write px. Eg: 40</small></label>
            <input name="fw-margin-top" id="fw-margin-top" type="text" />
        </div>

        <div class="form-section clearfix">
            <label for="fw-margin-bottom">Margin Bottom.<br/><small>Enter bottom margin for this row in pixels. Leave empty for default value. No need to write px. Eg: 50</small></label>
            <input name="fw-margin-bottom" id="fw-margin-bottom" type="text" />
        </div>

        <div class="form-section clearfix">
            <label for="fw-padding-top">Inside Padding Top.<br/><small>Enter top padding for this section in pixels. Leave empty for default value. No need to write px. Eg: 50</small></label>
            <input name="fw-padding-top" id="fw-padding-top" type="text" />
        </div>

        <div class="form-section clearfix">
            <label for="fw-padding-bottom">Inside Padding Bottom.<br/><small>Enter bottom padding for this row in pixels. Leave empty for default value. No need to write px. Eg: 50</small></label>
            <input name="fw-padding-bottom" id="fw-padding-bottom" type="text" />
        </div>

        <div class="form-section clearfix">
            <label for="fw-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="fw-extra-class" id="fw-extra-class" type="text" />
        </div>

        <div class="form-section clearfix">
            <label for="fw-unique-id">Unique Section ID.<br/><small>If needed, enter a UNIQUE section id, without whitespaces. This is very important for One Page websites, as this will be used for a navigation.</small></label>
            <input name="fw-unique-id" id="fw-unique-id" type="text" />
        </div>
         
    <a href="javascript:FWDialog.insert(FWDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>