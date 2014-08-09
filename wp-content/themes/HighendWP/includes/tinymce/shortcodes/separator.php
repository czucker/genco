<script type="text/javascript">
var SeparatorDialog = {
	local_ed : 'ed',
	init : function(ed) {
		SeparatorDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var type = jQuery('#separator-type').val();
		var top = jQuery('#separator-top').val();
		var bottom = jQuery('#separator-bottom').val();
		var animation = jQuery('#separator-entrance-animation').val();
		var animation_delay = jQuery('#separator-entrance-delay').val();
		var extra_class = jQuery('#separator-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[separator';

		output += ' type=\"'+ type +'\"';

		if ( jQuery('#scissors-icon').is(':checked') ){
			output += ' scissors_icon=\"yes\"';
		}

		if ( jQuery('#gototop').is(':checked') ){
			output += ' go_to_top=\"yes\"';
		}

		if (top != ''){
			output += ' margin_top=\"'+ top +'\"';
		}

		if (bottom != ''){
			output += ' margin_bottom=\"'+ bottom +'\"';
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
tinyMCEPopup.onInit.add(SeparatorDialog.init, SeparatorDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

		<div class="form-section clearfix">
            <label for="separator-type">Separator Type.<br/><small>Choose your separator style. * Fullwidth Separator does not support all of the options and it has to be used in fullwidth layout.</small></label>
            <select name="separator-type" id="separator-type">
            	<option value="small-break">Small Break</option>
            	<option value="default" selected>Default</option>
            	<option value="default-double">Double Default</option>
            	<option value="dashed">Dashed</option>
            	<option value="dashed-double">Dashed Double</option>
            	<option value="small">Small</option>
            	<option value="hb-fw-separator">* Fullwidth</option>
            	<option value="hb-fw-dashed">* Fullwidth Dashed</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="scissors-icon"><small>Optional Scissors Icon?</small></label>
            <input name="scissors-icon" id="scissors-icon" value="scissors-icon" type="checkbox" />
        </div>

        <div class="form-section clearfix">
            <label for="gototop"><small>Go to top button?</small></label>
            <input name="gototop" id="gototop" value="gototop" type="checkbox" />
        </div>

        <div class="form-section clearfix">
            <label for="separator-top">Margin Top.<br/><small>Enter the top margin in pixels. Do not write px. Leave empty for default value. Example: 40</small></label>
            <input type="text" name="separator-top" id="separator-top" placeholder="Example: 40"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="separator-bottom">Margin Bottom.<br/><small>Enter the bottom margin in pixels. Do not write px. Leave empty for default value. Example: 40</small></label>
            <input type="text" name="separator-bottom" id="separator-bottom" placeholder="Example: 40"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="separator-entrance-animation">Entrance Animation.<br/><small>Choose an entrance animation for this element.</small></label>
            <select name="separator-entrance-animation" id="separator-entrance-animation">
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
            <label for="separator-entrance-delay">Entrance Delay.<br/><small>Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)</small></label>
            <input name="separator-entrance-delay" id="separator-entrance-delay" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="separator-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="separator-extra-class" id="separator-extra-class" type="text" />
        </div>
         
    <a href="javascript:SeparatorDialog.insert(SeparatorDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>