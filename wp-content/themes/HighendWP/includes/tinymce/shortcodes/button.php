<script type="text/javascript">
var ButtonDialog = {
	local_ed : 'ed',
	init : function(ed) {
		ButtonDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var icon_name = jQuery('#icon-name').val();
		var size = jQuery('#button-size').val();
		var color = jQuery('#button-color').val();
		var title = jQuery('#button-title').val();
		var link = jQuery('#button-link').val();

		var animation = jQuery('#button-entrance-animation').val();
		var animation_delay = jQuery('#button-entrance-delay').val();
		var extra_class = jQuery('#button-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[button';

		if (title != ''){
			output += ' title=\"'+ title +'\"';
		} else {
			output += ' title=\"Button Title\"';
		}

		if (link != ''){
			output += ' link=\"'+ link +'\"';
		} else {
			output += ' link=\"#\"';
		}

		if ( jQuery('#new_tab').is(':checked') ){
			output += ' new_tab=\"yes\"';
		} else
            output += ' new_tab=\"no\"'; 

		if ( icon_name != '' ){
			output += ' icon=\"'+icon_name+'\"';
		}

		if ( jQuery('#special-style').is(':checked') ){
			output += ' special_style=\"yes\"';
		}

		if ( jQuery('#three-d').is(':checked') ){
			output += ' three_d=\"yes\"';
		}

		if (size != 'default'){
			output += ' size=\"'+ size +'\"';
		}

		if (color != 'default'){
			output += ' color=\"'+ color +'\"';
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
		
		output += ']';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(ButtonDialog.init, ButtonDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

        <div class="form-section clearfix">
            <label for="button-title">Button Title.<br/><small>Enter the title/caption for this button.</small></label>
            <input type="text" name="button-title" id="button-title" placeholder="Example: Purchase Today"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="button-link">Button Link URL.<br/><small>Choose URL of the link for the button. Enter with http:// prefix. You can also enter section id with # prefix to scroll to the section within your page. Example #home</small></label>
            <input type="text" name="button-link" id="button-link" placeholder="Example: http://hb-themes.com"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="new_tab"><small>Open link in New Tab?</small></label>
            <input name="new_tab" id="new_tab" value="new_tab" type="checkbox" />
        </div>

        <div class="form-section clearfix">
            <label for="icon-name">Icon Name.<br/><small>Enter a name of icon you would like to use. Leave empty if you don't want an icon. You can find list of icons here: <a href="http://documentation.hb-themes.com/icons/" target="_blank">Icon List</a><br/>Example: hb-moon-apple-fruit</small></label>
            <input name="icon-name" id="icon-name" placeholder="Example: icon-heart" type="text" />
        </div>

        <div class="form-section clearfix">
            <label for="special-style"><small>Special Icon Style?</small></label>
            <input name="special-style" id="special-style" value="special-style" type="checkbox" />
        </div>

        <div class="form-section clearfix">
            <label for="three-d"><small>Enable 3D Button Effect?</small></label>
            <input name="three-d" id="three-d" value="three-d" type="checkbox" />
        </div>

        <div class="form-section clearfix">
            <label for="button-size">Button Size.<br/><small>Choose size for this button.</small></label>
            <select name="button-size" id="button-size">
            	<option value="default" selected>Default</option>
            	<option value="large">Large</option>
            	<option value="small">Small</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="button-color">Button Color.<br/><small>Choose a color for this button. You can see a preview of colors <a href="http://flatuicolors.com/" target="_blank">HERE</a></small></label>
            <select name="button-color" id="button-color">
            	<option value="default" selected>Default</option>
            	<option value="turqoise">Turqoise</option>
            	<option value="green-sea">Green Sea</option>
            	<option value="sunflower">Sunflower</option>
            	<option value="orange">Orange</option>
            	<option value="emerald">Emerald</option>
            	<option value="nephritis">Nephritis</option>
            	<option value="carrot">Carrot</option>
            	<option value="pumpkin">Pumpkin</option>
            	<option value="peter-river">Peter River</option>
            	<option value="belize">Belize</option>
            	<option value="alizarin">Alizarin</option>
            	<option value="pomegranate">Pomegranate</option>
            	<option value="amethyst">Amethyst</option>
            	<option value="wisteria">Wisteria</option>
            	<option value="wet-asphalt">Wet Asphalt</option>
            	<option value="midnight-blue">Midnight Blue</option>
            	<option value="concrete">Concrete</option>
            	<option value="asbestos">Asbestos</option>
            	<option value="darkly">Darkly</option>
            	<option value="second-light">Light</option>
                <option value="hb-third-light">Light III</option>
            	<option value="second-dark">Dark II</option>
            	<option value="third-dark">Dark III</option>
            	<option value="yellow">Yellow</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="button-entrance-animation">Entrance Animation.<br/><small>Choose an entrance animation for this element.</small></label>
            <select name="button-entrance-animation" id="button-entrance-animation">
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
            <label for="button-entrance-delay">Entrance Delay.<br/><small>Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)</small></label>
            <input name="button-entrance-delay" id="button-entrance-delay" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="button-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="button-extra-class" id="button-extra-class" type="text" />
        </div>
         
    <a href="javascript:ButtonDialog.insert(ButtonDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>