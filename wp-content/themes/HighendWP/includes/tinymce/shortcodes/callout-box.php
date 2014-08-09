<script type="text/javascript">
var CalloutDialog = {
	local_ed : 'ed',
	init : function(ed) {
		CalloutDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var callout_content = jQuery('textarea#callout-content').val();
		var animation = jQuery('#callout-entrance-animation').val();
		var animation_delay = jQuery('#callout-entrance-delay').val();
		var extra_class = jQuery('#callout-extra-class').val();

		var title = jQuery('#button-title').val();
		var link = jQuery('#button-link').val();
		var icon_name = jQuery('#icon-name').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[callout';

		if (title != ''){
			output += ' title=\"'+ title +'\"';
		}

		if (link != ''){
			output += ' link=\"'+ link +'\"';
		}

		if ( jQuery('#new_tab').is(':checked') ){
			output += ' new_tab=\"yes\"';
		}

		if ( icon_name != '' ){
			output += ' icon=\"'+icon_name+'\"';
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
		
		if ( callout_content != '' ) { output += callout_content; }
		else { output += 'Enter your callout content here.'; }

		output += '[/callout]';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(CalloutDialog.init, CalloutDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

        <div class="form-section clearfix">
            <label for="callout-content">Callout Content<br /><small>Enter your callout text here.</small></label>
            <textarea name="callout-content" value="" id="callout-content"></textarea>
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
            <label for="new_tab"><small>Open link in New Tab?</small></label>
            <input name="new_tab" id="new_tab" value="new_tab" type="checkbox" />
        </div>

        <div class="form-section clearfix">
            <label for="icon-name">Icon Name.<br/><small>Enter a name of icon you would like to use. Leave empty if you don't want an icon. You can find list of icons here: <a href="http://documentation.hb-themes.com/icons/" target="_blank">Icon List</a><br/>Example: hb-moon-apple-fruit</small></label>
            <input name="icon-name" id="icon-name" placeholder="Example: icon-heart" type="text" />
        </div>

        <div class="form-section clearfix">
            <label for="callout-entrance-animation">Entrance Animation.<br/><small>Choose an entrance animation for this element.</small></label>
            <select name="callout-entrance-animation" id="callout-entrance-animation">
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
            <label for="callout-entrance-delay">Entrance Delay.<br/><small>Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)</small></label>
            <input name="callout-entrance-delay" id="callout-entrance-delay" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="callout-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="callout-extra-class" id="callout-extra-class" type="text" />
        </div>
         
    <a href="javascript:CalloutDialog.insert(CalloutDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>