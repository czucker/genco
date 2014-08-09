<script type="text/javascript">
var CounterDialog = {
	local_ed : 'ed',
	init : function(ed) {
		CounterDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var color = jQuery('#counter-color').val();
		var from = jQuery('#count-from').val();
		var to = jQuery('#count-to').val();
		var icon = jQuery('#count-icon').val();
		var subtitle = jQuery('#count-subtitle').val();
		var speed = jQuery('#count-speed').val();
		var animation = jQuery('#map-entrance-animation').val();
		var animation_delay = jQuery('#map-entrance-delay').val();
		var extra_class = jQuery('#map-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[counter';

		if (from != ''){
			output += ' from=\"'+ from +'\"';
		} else {
			output += ' from=\"0\"';
		}

		if (to != ''){
			output += ' to=\"'+ to +'\"';
		} else {
			output += ' to=\"1250\"';
		}

		if (color != ''){
			output += ' color=\"'+ color +'\"';
		}

		if (icon != ''){
			output += ' icon=\"'+ icon +'\"';
		}

		if (subtitle != ''){
			output += ' subtitle=\"'+ subtitle +'\"';
		}

		if (speed != ''){
			output += ' speed=\"'+ speed +'\"';
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
tinyMCEPopup.onInit.add(CounterDialog.init, CounterDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

		<div class="form-section clearfix">
            <label for="count-from">Counter Start Number.<br/><small>Enter a start number for the counter. Counting will begin from this number. This value has to be a numerical. Example: 0</small></label>
            <input type="text" name="count-from" id="count-from" placeholder="Example: 0"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="count-to">Counter End Number.<br/><small>Enter an end number for the counter. Counting will end on this number. This value has to be a numerical. Example: 1250</small></label>
            <input type="text" name="count-to" id="count-to" placeholder="Example: 1250"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="count-icon">Icon.<br/><small>Enter a name of icon you would like to use. You can find list of icons here: <a href="http://documentation.hb-themes.com/icons/" target="_blank">Icon List</a><br/>Example: hb-moon-apple-fruit</small></label>
            <input type="text" name="count-icon" id="count-icon" placeholder="Example: hb-moon-apple-fruit"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="count-subtitle">Subtitle.<br/><small>A word, or short text to display below the counter. Example: Apples Eaten</small></label>
            <input type="text" name="count-subtitle" id="count-subtitle" placeholder="Example: Apples Eaten"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="count-speed">Counter Speed.<br/><small>Enter counter speed value in miliseconds. Example: 700</small></label>
            <input type="text" name="count-speed" id="count-speed" placeholder="Example: 700"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="counter-color">Color.<br/><small>Enter a focus color for this element in hex format. Example: #ff6838</small></label>
            <input name="counter-color" id="counter-color" type="text" placeholder="Example: #ff6838" />
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
         
    <a href="javascript:CounterDialog.insert(CounterDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>