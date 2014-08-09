<script type="text/javascript">
var VideoDialog = {
	local_ed : 'ed',
	init : function(ed) {
		VideoDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var video_url = jQuery('#video-embed').val();
		var animation = jQuery('#video-entrance-animation').val();
		var animation_delay = jQuery('#video-entrance-delay').val();
		var video_width = jQuery('#video-width').val();
		var extra_class = jQuery('#video-extra-class').val();
		var embed_style = jQuery('#video-embed-style').val();

		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[video_embed';

		if (video_url != ''){
			output += ' url=\"'+ video_url +'\"';
		}

		if ( embed_style != '' )
			output += ' embed_style=\"' + embed_style + '\"';

		if (video_width != ''){
			output += ' width=\"'+ video_width +'\"';
		}

		if ( jQuery('#video-border').is(':checked') ){
			output += ' border=\"yes\"';
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
tinyMCEPopup.onInit.add(VideoDialog.init, VideoDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

		<div class="form-section clearfix">
            <label for="video-embed">Video URL.<br/><small>URL to the video which needs to be embedded.<br/><br/>Youtube example: http://www.youtube.com/watch?v=NxfK4LANqww</small></label>
            <textarea name="video-embed" id="video-embed" placeholder="Enter video url here..."></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="video-width">Video Width.<br/><small>Width of the Video in pixels. Height will be calculated automatically. Do not write px, just a number. Leave empty for fullwidth.<br/><br/>Example: 300</small></label>
            <textarea name="video-width" id="video-width" placeholder="300"></textarea>
        </div>

		<div class="form-section clearfix">
            <label for="video-border"><small>Border around video embed?</small></label>
            <input name="video-border" id="video-border" value="video-border" type="checkbox" />
        </div>

        <div class="form-section clearfix">
            <label for="video-embed-style">Embed Style.<br/><small>Choose between standard embed and embed in lightbox. Lightbox embed will generate a button invoker.</small></label>
            <select name="video-embed-style" id="video-embed-style">
            	<option value="default" selected>Default</option>
            	<option value="in_lightbox">In Lightbox</option>
            </select>
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
         
    <a href="javascript:VideoDialog.insert(VideoDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>