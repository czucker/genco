<script type="text/javascript">
var IBannerDialog = {
	local_ed : 'ed',
	init : function(ed) {
		IBannerDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var ib_image = jQuery('#ib-image').val();
		var text_color = jQuery('#color-style').val();
		var animation = jQuery('#map-entrance-animation').val();
		var animation_delay = jQuery('#map-entrance-delay').val();
		var extra_class = jQuery('#map-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[image_banner';

		if (ib_image != ''){
			output += ' url=\"'+ ib_image +'\"';
		}
		
		output += ' text_color="' + text_color + '"';

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

		if (mceSelected != ''){
			output += mceSelected;
		} else {
			output += 'Enter content here...';
		}

		output += '[/image_banner]';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(IBannerDialog.init, IBannerDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

		<div class="form-section clearfix">
            <label for="ib-image">Banner Image.<br/><small>Enter background image URL. Enter with full http:// prefix.</small></label>
            <textarea name="ib-image" id="ib-image" placeholder="Example: http://yourwebsite.com/images/banner-image.jpg"></textarea>
        </div>
		
		<div class="form-section clearfix">
            <label for="color-style">Text Color Style.<br/><small>Select a text color style for this element. Use light when your background is dark and opposite.</small></label>
            <select name="color-style" id="color-style">
                <option value="dark" selected>Dark Text</option>
                <option value="light">Light Text</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="map-entrance-animation">Entrance Animation.<br/><small>Choose an entrance animation for this element.</small></label>
            <select name="map-entrance-animation" id="map-entrance-animation">
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
            <label for="map-entrance-delay">Entrance Delay.<br/><small>Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)</small></label>
            <input name="map-entrance-delay" id="map-entrance-delay" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="map-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="map-extra-class" id="map-extra-class" type="text" />
        </div>
         
    <a href="javascript:IBannerDialog.insert(IBannerDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>