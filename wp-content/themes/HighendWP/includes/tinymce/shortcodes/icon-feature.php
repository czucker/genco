<script type="text/javascript">
var IconFeatureDialog = {
	local_ed : 'ed',
	init : function(ed) {
		IconBoxDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var icon = jQuery('#box-icon').val();
		var icon_position = jQuery('#box-icon-position').val();
		var align = jQuery('#box-icon-align').val();
		var title = jQuery('#box-title').val();
		var icon_link = jQuery('#icon-link').val();
		var animation = jQuery('#box-entrance-animation').val();
		var animation_delay = jQuery('#box-entrance-delay').val();
		var extra_class = jQuery('#box-extra-class').val();
		var image = jQuery('#box-image').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[icon_feature';
		
		if (icon != ''){
			output += ' icon=\"'+ icon +'\"';
		}
		
		if (icon_position != ''){
			output += ' icon_position=\"'+ icon_position +'\"';
		}

		if ( image != '' )
			output += ' image=\"' + image + '\"';
		
		if ( jQuery('#icon-border').is(':checked') ){
			output += ' border=\"yes\"';
		}
		
		if (title != ''){
			output += ' title=\"'+ title +'\"';
		}

		output += ' link=\"'+icon_link+'\"';

		if ( jQuery('#link-target').is(':checked') ){
			output += ' new_tab=\"yes\"';
		} else {
			output += ' new_tab=\"no\"';
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
		output += 'Enter your content here...<br/>';
		output += '[/icon_feature]';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(IconFeatureDialog.init, IconFeatureDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

		<div class="form-section clearfix">
            <label for="box-icon-position">Choose Icon Position.<br/><small>Choose an icon position for this icon feature.</small></label>
            <select name="box-icon-position" id="box-icon-position">
            	<option value="center" selected>Top Centered</option>
				<option value="left" selected>Left</option>
				<option value="right" selected>Right</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="box-icon">Icon or Character.<br/><small>Enter a name of icon you would like to use or enter just a single character. Leave empty to exclude. You can find list of icons here: <a href="http://documentation.hb-themes.com/icons/" target="_blank">Icon List</a><br/>Example: hb-moon-apple-fruit. Example for character: $</small></label>
            <input type="text" name="box-icon" id="box-icon" placeholder="Example: hb-moon-apple-fruit"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="box-image">Image URL or Media item ID.<br/><small>Enter a image URL which will be displayed in the icon feature place.</small></label>
            <input type="text" name="box-image" id="box-image" placeholder=""></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="icon-link">Link.<br/><small>Enter a link for this element. Leave empty if you do not want to use a link. Please use http:// prefix. Example: http://hb-themes.com</small></label>
            <input name="icon-link" id="icon-link" placeholder="Example: http://hb-themes.com" type="text" />
        </div>

        <div class="form-section clearfix">
            <label for="link-target"><small>Open link in new tab?</small></label>
            <input name="link-target" id="link-target" value="link-target" type="checkbox" />
        </div>
		
		<div class="form-section clearfix">
            <label for="icon-border"><small>Border around icon?</small></label>
            <input name="icon-border" id="icon-border" value="icon-border" type="checkbox" />
        </div>
		
		<div class="form-section clearfix">
            <label for="box-title">Title.<br/><small>Enter your icon box title. Leave empty to exclude. Example: My Feature</small></label>
            <input type="text" name="box-title" id="box-title" placeholder="Example: My Feauture"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="box-entrance-animation">Entrance Animation.<br/><small>Choose an entrance animation for this element.</small></label>
            <select name="box-entrance-animation" id="box-entrance-animation">
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
            <label for="box-entrance-delay">Entrance Delay.<br/><small>Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)</small></label>
            <input name="box-entrance-delay" id="box-entrance-delay" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="box-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="box-extra-class" id="box-extra-class" type="text" />
        </div>
         
    <a href="javascript:IconFeatureDialog.insert(IconFeatureDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>