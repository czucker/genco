<script type="text/javascript">
var LaptopDialog = {
	local_ed : 'ed',
	init : function(ed) {
		LaptopDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var slideshow_speed = jQuery('#slider-time').val();
		var animation = jQuery('#video-entrance-animation').val();
		var animation_delay = jQuery('#video-entrance-delay').val();
		var extra_class = jQuery('#video-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[laptop_slider';

		if (slideshow_speed != ''){
			output += ' speed=\"'+ slideshow_speed +'\"';
		}

		if ( jQuery('#control-nav').is(':checked') ){
			output += ' bullets=\"yes\"';
		} else {
			output += ' bullets=\"no\"';
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

		
			output += '[slider_item img="http://placehold.it/866x541" title="Optional slider caption." rel="slider-100"]<br/>';
			output += '[slider_item img="http://placehold.it/866x541" rel="slider-100"]<br/>';
			output += '[slider_item img="http://placehold.it/866x541" title="Optional slider caption." rel="slider-100"]<br/>';
		output += '[/laptop_slider]';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(LaptopDialog.init, LaptopDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

		<div class="form-section clearfix">
            <label for="slider-time">Slideshow Speed.<br/><small>Speed in miliseconds before slides are changed. Do not enter ms, just a number. Example 4000 (4 seconds)</small></label>
            <input type="text" name="slider-time" id="slider-time" placeholder="Example: 4000"></input>
        </div>

        <div class="form-section clearfix">
            <label for="control-nav"><small>Show bullets?</small></label>
            <input name="control-nav" id="control-nav" value="control-nav" type="checkbox" checked/>
        </div>

        <div class="form-section clearfix">
            <label for="video-entrance-animation">Entrance Animation.<br/><small>Choose an entrance animation for this element.</small></label>
            <select name="video-entrance-animation" id="video-entrance-animation">
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
            <label for="video-entrance-delay">Entrance Delay.<br/><small>Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)</small></label>
            <input name="video-entrance-delay" id="video-entrance-delay" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="video-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="video-extra-class" id="video-extra-class" type="text" />
        </div>
         
    <a href="javascript:LaptopDialog.insert(LaptopDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>