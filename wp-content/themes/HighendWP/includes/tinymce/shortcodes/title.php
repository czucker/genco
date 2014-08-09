<script type="text/javascript">
var TitleDialog = {
	local_ed : 'ed',
	init : function(ed) {
		TitleDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var title_text = jQuery('#title-text').val();
		var title_type = jQuery('#title-type').val();
		var title_color = jQuery('#title-color').val();
		var animation = jQuery('#title-entrance-animation').val();
		var animation_delay = jQuery('#title-entrance-delay').val();
		var extra_class = jQuery('#title-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[title';

		output += ' type="' + title_type + '"';
		output += ' color="' + title_color + '"';

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

		if (title_text != ''){
			output += title_text;
		} else {
			output += 'Enter title content here';
		}

		output += '[/title]';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(TitleDialog.init, TitleDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

		<div class="form-section clearfix">
            <label for="title-text">Title Text.<br/><small>Enter the title text.</label>
            <textarea type="text" name="title-text" id="title-text" placeholder="Example: My Title"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="title-type">Title Type.<br/><small>Choose title type.</small></label>
            <select name="title-type" id="title-type">
            	<option value="extra-large" selected>Extra Large</option>
            	<option value="h1">H1</option>
            	<option value="h2">H2</option>
            	<option value="h3">H3</option>
            	<option value="h4">H4</option>
            	<option value="h5">H5</option>
            	<option value="h6">H6</option>

            	<option value="special-h3">Special H3</option>
            	<option value="special-h3-left">Special H3 Left</option>
            	<option value="special-h3-right">Special H3 Right</option>

            	<option value="special-h4">Special H4</option>
            	<option value="special-h4-left">Special H4 Left</option>
            	<option value="special-h4-right">Special H4 Right</option>

            	<option value="fancy-h1">Fancy H1</option>
            	<option value="fancy-h2">Fancy H2</option>
            	<option value="fancy-h3">Fancy H3</option>
            	<option value="fancy-h4">Fancy H4</option>
            	<option value="fancy-h5">Fancy H5</option>
            	<option value="fancy-h6">Fancy H6</option>

            	<option value="subtitle-h3">Subtitle H3</option>
            	<option value="subtitle-h6">Subtitle H6</option>

            </select>
        </div>

        <div class="form-section clearfix">
            <label for="title-color">Color.<br/><small>Enter a color for this element in hex format. Leave empty for default value.</small></label>
            <input name="title-color" id="title-color" type="text" placeholder="Example: #323436" />
        </div>

        <div class="form-section clearfix">
            <label for="title-entrance-animation">Entrance Animation.<br/><small>Choose an entrance animation for this element.</small></label>
            <select name="title-entrance-animation" id="title-entrance-animation">
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
            <label for="title-entrance-delay">Entrance Delay.<br/><small>Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)</small></label>
            <input name="title-entrance-delay" id="title-entrance-delay" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="title-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="title-extra-class" id="title-extra-class" type="text" />
        </div>
         
    <a href="javascript:TitleDialog.insert(TitleDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>