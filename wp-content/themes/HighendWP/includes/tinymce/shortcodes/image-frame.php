<script type="text/javascript">
var IFrameDialog = {
	local_ed : 'ed',
	init : function(ed) {
		IFrameDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var if_image = jQuery('#if-image').val();
		var gallery_rel = jQuery('#rel-image').val();
		var border = jQuery('#image-border-style').val();
		var on_click_do = jQuery('#on-click-do').val();
		var link_href = jQuery('#link-href').val();
		var animation = jQuery('#map-entrance-animation').val();
		var animation_delay = jQuery('#map-entrance-delay').val();
		var extra_class = jQuery('#map-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[image_frame';

		if (if_image != ''){
			output += ' url=\"'+ if_image +'\"';
		}

		if (border != ''){
			output += ' border_style=\"'+ border +'\"';
		}

		output += ' action=\"'+ on_click_do +'\"';

		if (link_href != '' && on_click_do == 'open-url'){
			output += ' link=\"'+ link_href +'\"';
		}

		if (gallery_rel != ''){
			output += ' rel=\"'+ gallery_rel +'\"';
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
tinyMCEPopup.onInit.add(IFrameDialog.init, IFrameDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

		<div class="form-section clearfix">
            <label for="if-image">Image URL.<br/><small>Enter image URL. Enter with full http:// prefix.</small></label>
            <textarea name="if-image" id="if-image" placeholder="Example: http://yourwebsite.com/images/image.jpg"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="image-border-style">Image Border Style.<br/><small>Choose an image border style.</small></label>
            <select name="image-border-style" id="image-border-style">
            	<option value="circle-frame" selected>Circle Frame</option>
            	<option value="boxed-frame">Boxed Frame</option>
            	<option value="boxed-frame-hover">Boxed Frame with Hover</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="on-click-do">On Click Action.<br/><small>Choose what to do when clicked on image.</small></label>
            <select name="on-click-do" id="on-click-do">
            	<option value="none" selected>Nothing</option>
            	<option value="open-url">Open URL</option>
            	<option value="open-lightbox" selected>Open Lightbox</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="link-href">URL Link.<br/><small>Enter URL where it will lead when clicked on the image. On Click Action has to be "Open URL". You need to enter full website address with http:// prefix.</small></label>
            <input type="text" name="link-href" id="link-href" placeholder="Example: http://hb-themes.com"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="rel-image">Gallery REL attribute.<br/><small>If you want to open this image in lightbox gallery along with other images, then enter the same Gallery REL for all those images.</small></label>
            <input type="text" name="rel-image" id="rel-image" placeholder="Example: my-gallery"></textarea>
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
         
    <a href="javascript:IFrameDialog.insert(IFrameDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>