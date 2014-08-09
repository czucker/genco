<script type="text/javascript">
var FWMapDialog = {
	local_ed : 'ed',
	init : function(ed) {
		FWMapDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var latitude = jQuery('#latitude').val();
		var longitude = jQuery('#longitude').val();
		var custom_pin = jQuery('#custom-pin').val();
		var zoom_level = jQuery('#zoom-level').val();
		var map_height = jQuery('#map-height').val();
		var animation = jQuery('#map-entrance-animation').val();
		var animation_delay = jQuery('#map-entrance-delay').val();
		var extra_class = jQuery('#map-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[map_embed';

		if (latitude != ''){
			output += ' latitude=\"'+ latitude +'\"';
		} else {
			output += ' latitude=\"48.856614\"';
		}

		if (longitude != ''){
			output += ' longitude=\"'+ longitude +'\"';
		} else {
			output += ' longitude=\"2.352222\"';
		}


		if ( jQuery('#map-border').is(':checked') ){
			output += ' border=\"yes\"';
		}

		if (zoom_level != ''){
			output += ' zoom=\"'+ zoom_level +'\"';
		} else {
			output += ' zoom=\"16\"';
		}

		if (map_height != ''){
			output += ' height=\"'+ map_height +'\"';
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

		if (custom_pin != '') {
			output += ' custom_pin=\"'+custom_pin+'\"';
		}

		
		output += ']';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(FWMapDialog.init, FWMapDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

		<div class="form-section clearfix">
            <label for="latitude">Center Latitude.<br/><small>Enter latitude coordinate where the map will be centered. You can use <a href="http://latlong.net" target="_blank">LatLong</a> to find out coordinates.</small></label>
            <input type="text" name="latitude" id="latitude" placeholder="Example: 48.856614"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="longitude">Center Longitude.<br/><small>Enter longitude coordinate where the map will be centered. You can use <a href="http://latlong.net" target="_blank">LatLong</a> to find out coordinates.</small></label>
            <input type="text" name="longitude" id="longitude" placeholder="Example: 2.352222"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="zoom-level">Map Zoom Level.<br/><small>Enter zoom level for the map. A numeric value from 1 to 18, where 1 is whole earth and 18 is street level zoom.</small></label>
            <input type="text" name="zoom-level" id="zoom-level" placeholder="Example: 16"/>
        </div>

        <div class="form-section clearfix">
            <label for="map-height">Map Height.<br/><small>Enter map height in pixels for the map. A numeric value - do not write px.</small></label>
            <input type="text" name="map-height" id="map-height" placeholder="Example: 380"/>
        </div>

        <div class="form-section clearfix">
            <label for="custom-pin">Custom Pin Image.<br/><small>Enter URL of the custom pin image for this map. Enter in full link with http:// prefix.</small></label>
            <textarea name="custom-pin" id="custom-pin" placeholder="Example: http://yourwebsite.com/images/custom-image.pin"></textarea>
        </div>

		<div class="form-section clearfix">
            <label for="map-border"><small>Border around map embed?</small></label>
            <input name="map-border" id="map-border" value="map-border" type="checkbox" />
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
         
    <a href="javascript:FWMapDialog.insert(FWMapDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>