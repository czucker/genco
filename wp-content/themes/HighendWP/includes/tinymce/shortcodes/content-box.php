<script type="text/javascript">
var ContentBoxDialog = {
	local_ed : 'ed',
	init : function(ed) {
		ContentBoxDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var animation = jQuery('#box-entrance-animation').val();
		var animation_delay = jQuery('#box-entrance-delay').val();
		var box_type = jQuery('#box-type').val();
		var box_title = jQuery('#box-title').val();
		var box_icon = jQuery('#box-icon').val();
		var extra_class = jQuery('#box-extra-class').val();
		var bg_color = jQuery('#fw-bg-color').val();
		var text_color = jQuery('#fw-text-color').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[content_box';

		output += ' type=\"'+ box_type +'\"';

		if ( box_type == 'with-header' ){
			if (box_title != ''){
				output += ' title=\"'+ box_title +'\"';
			} else {
				output += ' title=\"Content Box Title\"';
			}

			if (box_icon != ''){
				output += ' icon=\"'+ box_icon +'\"';
			}
		}
		
		output += ' text_color=\"' + text_color + '\"';

		if ( bg_color != '' ){
			output += ' color=\"'+ bg_color +'\"';
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
		output += 'Enter your box content here...<br/>';
		output += '[/content_box]';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(ContentBoxDialog.init, ContentBoxDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

		<div class="form-section clearfix">
            <label for="box-type">Box Style.<br/><small>Choose your box style.</small></label>
            <select name="box-type" id="box-type">
            	<option value="with-header">With Header</option>
            	<option value="without-header">Without Header</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="box-title">Box Title.<br/><small>Enter box title here if you have selected "With Header". Example: My box title.</small></label>
            <input name="box-title" id="box-title" type="text" placeholder="Example: My box title" />
        </div>

        <div class="form-section clearfix">
            <label for="box-icon">Box Title Icon.<br/><small>Enter a name of icon you would like to use. Leave empty if you don't want an icon. You can find list of icons here: <a href="http://documentation.hb-themes.com/icons/" target="_blank">Icon List</a><br/>Example: hb-moon-apple-fruit</small></label>
            <input name="box-icon" id="box-icon" placeholder="Example: icon-heart" type="text" />
        </div>

        <div class="form-section clearfix">
            <label for="fw-bg-color">Box Background Color.<br/><small>Select a background color for this element.</small></label>
            <select name="fw-bg-color" id="fw-bg-color">
                <option value="default" selected>Default</option>
                <option value="color-alt-1">Color Alt 1</option>
                <option value="color-alt-2">Color Alt 2</option>
                <option value="color-alt-3">Color Alt 3</option>
                <option value="color-alt-4">Color Alt 4</option>
                <option value="color-alt-5">Color Alt 5</option>
                <option value="color-alt-6">Color Alt 6</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="fw-text-color">Content Color.<br/><small>Choose your text color style.</small></label>
            <select name="fw-text-color" id="fw-text-color">
                <option value="light">Light</option>
                <option value="dark" selected>Dark</option>
            </select>
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
         
    <a href="javascript:ContentBoxDialog.insert(ContentBoxDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>