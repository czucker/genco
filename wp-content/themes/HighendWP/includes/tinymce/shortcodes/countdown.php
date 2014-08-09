<script type="text/javascript">
var CountdownDialog = {
	local_ed : 'ed',
	init : function(ed) {
		CountdownDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var date = jQuery('#countdown-date').val();
		var animation = jQuery('#map-entrance-animation').val();
		var animation_delay = jQuery('#map-entrance-delay').val();
		var extra_class = jQuery('#map-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[countdown';

		if (date != ''){
			output += ' date=\"'+ date +'\"';
		} else {
			output += ' date=\"24 february 2018 12:00:00\"';
		}

		if ( jQuery('#aligncenter').is(':checked') ){
			output += ' aligncenter=\"yes\"';
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
tinyMCEPopup.onInit.add(CountdownDialog.init, CountdownDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

		<div class="form-section clearfix">
            <label for="ib-image">Countdown Date.<br/><small>Enter date and time for which countdown will count. Must enter in this format: <strong><br/>27 february 2014 12:00:00</strong></small></label>
            <input type="text" name="countdown-date" id="countdown-date" placeholder="Example: 27 february 2015 12:00:00"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="aligncenter"><small>Align center?</small></label>
            <input name="aligncenter" id="aligncenter" value="aligncenter" type="checkbox" />
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
         
    <a href="javascript:CountdownDialog.insert(CountdownDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>