<script type="text/javascript">
var TeaserDialog = {
	local_ed : 'ed',
	init : function(ed) {
		TeaserDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var teaser_image = jQuery('#teaser-image').val();
		var teaser_alignment = jQuery('#teaser-alignment').val();
		var teaser_style = jQuery('#teaser-style').val();
		var button_title = jQuery('#button-title').val();
		var button_link = jQuery('#button-link').val();
		var teaser_title = jQuery('#teaser-title').val();
		var animation = jQuery('#teaser-entrance-animation').val();
		var animation_delay = jQuery('#teaser-entrance-delay').val();
		var extra_class = jQuery('#teaser-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[teaser';

		if (teaser_image != ''){
			output += ' image=\"'+ teaser_image +'\"';
		}

		output += ' align=\"'+ teaser_alignment +'\"';
		output += ' style=\"'+ teaser_style +'\"';
		
		if (teaser_title != ''){
			output += ' title=\"'+ teaser_title +'\"';
		}

		if ( button_title != '' ) {
			output += ' button_title=\"' + button_title + '\"';
		}

		if ( button_link != '' ) {
			output += ' button_link=\"' + button_link + '\"';
		}

		if ( jQuery('#new_tab').is(':checked') ){
			output += ' new_tab=\"yes\"';
		}

		if (animation != 'none'){
			output += ' animation=\"'+ animation +'\"';
		}

		if (animation_delay != '' && animation != 'none'){
			output += ' animation_delay=\"'+ animation_delay +'\"';
		}

		if (extra_class != '') {
			output += ' class=\"'+extra_class+'\"';
		}
		
		output += ']<br/>';
		output += 'Enter teaser content here.<br/>Use any shortcodes in the content<br/>';
		output += '[/teaser]';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(TeaserDialog.init, TeaserDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

		<div class="form-section clearfix">
            <label for="teaser-image">Teaser Image.<br/><small>Enter the link of the teaser image. The link can be obtained in the media library in the media item details. Leave empty to hide the image section of the teaser.</small></label>
            <input type="text" name="teaser-image" id="teaser-image" placeholder="Example: http://www.yourwebsite.com/wp-content/uploads/2014/2/image.jpg"></input>
        </div>

        <div class="form-section clearfix">
            <label for="teaser-alignment">Alignment.<br/><small>Choose teaser content alignment.</small></label>
            <select name="teaser-alignment" id="teaser-alignment">
            	<option value="alignleft" selected>Left</option>
            	<option value="aligncenter">Center</option>
            	<option value="alignright">Right</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="teaser-style">Style.<br/><small>Choose teaser style. Choose between a boxed or unboxed alternative.</small></label>
            <select name="teaser-alignstylement" id="teaser-style">
            	<option value="boxed" selected>Boxed</option>
            	<option value="alternative">Unboxed</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="teaser-title">Teaser Title.<br/><small>Enter the title/caption for this teaser box.</small></label>
            <input type="text" name="teaser-title" id="teaser-title" placeholder="Example: Spring Offer"></textarea>
        </div>

		<div class="form-section clearfix">
            <label for="button-title">Button Title.<br/><small>Enter the title/caption for this button.</small></label>
            <input type="text" name="button-title" id="button-title" placeholder="Example: Purchase Today"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="button-link">Button Link URL.<br/><small>Choose URL of the link for the button. Enter with http:// prefix. You can also enter section id with # prefix to scroll to the section within your page. Example #home</small></label>
            <input type="text" name="button-link" id="button-link" placeholder="Example: http://hb-themes.com"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="new_tab"><small>Open button link in New Tab?</small></label>
            <input name="new_tab" id="new_tab" value="new_tab" type="checkbox" />
        </div>

        <div class="form-section clearfix">
            <label for="teaser-entrance-animation">Entrance Animation.<br/><small>Choose an entrance animation for this element.</small></label>
            <select name="teaser-entrance-animation" id="teaser-entrance-animation">
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
            <label for="teaser-entrance-delay">Entrance Delay.<br/><small>Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)</small></label>
            <input name="teaser-entrance-delay" id="teaser-entrance-delay" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="teaser-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="teaser-extra-class" id="teaser-extra-class" type="text" />
        </div>
         
    <a href="javascript:TeaserDialog.insert(TeaserDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>