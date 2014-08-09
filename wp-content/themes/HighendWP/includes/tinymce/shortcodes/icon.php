<script type="text/javascript">
var IconDialog = {
	local_ed : 'ed',
	init : function(ed) {
		IconDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertIcon(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		
		var icon_name = jQuery('#icon-name').val();
		var icon_size = jQuery('#icon-size').val();
		var icon_color = jQuery('#icon-color').val();
		var icon_float = jQuery('#icon-float').val();
		var icon_link = jQuery('#icon-link').val();
		var animation = jQuery('#skill-entrance-animation').val();
		var animation_delay = jQuery('#skill-entrance-delay').val();
		var extra_class = jQuery('#icon-extra-class').val();
		
				 
		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[icon';

		if ( icon_name != '' ){
			output += ' name=\"'+icon_name+'\"';
		} else {
			output += ' name=\"hb-moon-brain\"';
		}
		
		output += ' size=\"'+icon_size+'\"';
		output += ' color=\"'+icon_color+'\"';
		output += ' float=\"'+icon_float+'\"';
		output += ' link=\"'+icon_link+'\"';

		if ( jQuery('#link-target').is(':checked') ){
			output += ' new_tab=\"yes\"';
		} else {
			output += ' new_tab=\"no\"';
		}

		if ( jQuery('#loop-animation').is(':checked') ){
			output += ' jump=\"yes\"';
		}

		if (animation != 'none'){
			output += ' animation=\"'+ animation +'\"';
		}

		if (animation_delay != '' && animation != 'none'){
			output += ' animation_delay=\"'+ animation_delay +'\"';
		}

		if ( extra_class != '' ){
			output += ' class=\"'+extra_class+'\"';
		}

		output += ']';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(IconDialog.init, IconDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

		<div class="form-section clearfix">
            <label for="icon-name">Icon Name.<br/><small>Enter a name of icon you would like to use. You can find list of icons here: <a href="http://documentation.hb-themes.com/icons/" target="_blank">Icon List</a><br/>Example: hb-moon-apple-fruit</small></label>
            <input name="icon-name" id="icon-name" placeholder="Example: icon-heart" type="text" />
        </div>

        <div class="form-section clearfix">
            <label for="icon-link">Link.<br/><small>Enter a link for this icon. Leave empty if you do not want to use a link. Please use http:// prefix. Example: http://hb-themes.com</small></label>
            <input name="icon-link" id="icon-link" placeholder="Example: http://hb-themes.com" type="text" />
        </div>

        <div class="form-section clearfix">
            <label for="link-target"><small>Open link in new tab?</small></label>
            <input name="link-target" id="link-target" value="link-target" type="checkbox" />
        </div>
		
		<div class="form-section clearfix">
            <label for="icon-size">Icon Size.<br/><small>Select size for the icon.</small></label>
            <select name="icon-size" id="icon-size" size="1">
                <option value="small" selected="selected">Small</option>
                <option value="medium">Medium</option>
                <option value="large">Large</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="icon-color">Color.<br/><small>Enter a color in hex format for the icon. Leave empty for default value. Example: #ff6838</small></label>
            <input name="icon-color" id="icon-color" placeholder="Example: #ff6838" type="text" />
        </div>

        <div class="form-section clearfix">
            <label for="icon-float">Icon Align.<br/><small>Select the float position for this icon.</small></label>
            <select name="icon-float" id="icon-float" size="1">
                <option value="left" selected="selected">Left</option>
                <option value="none">None (Center)</option>
                <option value="right">Right</option>
                <option value="inherit">Inherit</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="loop-animation"><small>Enable jumping loop animation?</small></label>
            <input name="loop-animation" id="loop-animation" value="loop-animation" type="checkbox" />
        </div>

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
            <label for="icon-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="icon-extra-class" id="icon-extra-class" type="text" />
        </div>
		
        
    <a href="javascript:IconDialog.insert(IconDialog.local_ed)" id="insert" style="display: block; line-height: 24px;">Insert</a>
    
</form>