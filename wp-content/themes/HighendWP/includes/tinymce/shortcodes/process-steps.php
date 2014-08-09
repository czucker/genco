<script type="text/javascript">
var ProcessStepsDialog = {
	local_ed : 'ed',
	init : function(ed) {
		ProcessStepsDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		
		var animation = jQuery('#entrance-animation').val();
		var animation_delay = jQuery('#entrance-delay').val();
		var extra_class = jQuery('#extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
				// setup the output of our shortcode
		output += '[process_steps';
       

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

		output += '[process_step title="Title 1" icon="1"]This is the first step.[/process_step]<br/>';
		output += '[process_step title="Title 2" icon="hb-moon-heart"]Use any of our icons for these steps.[/process_step]<br/>';
		output += '[process_step title="Title 3" icon="hb-moon-star"]Enter between 3 and 5 steps.[/process_step]<br/>';
		output += '[process_step title="Title 4" icon="hb-moon-envelop"][/process_step]<br/>';

		output += '[/process_steps]'

		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(ProcessStepsDialog.init, ProcessStepsDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

        <div class="form-section clearfix">
            <label for="entrance-animation">Entrance Animation.<br/><small>Choose an entrance animation for this element.</small></label>
            <select name="entrance-animation" id="entrance-animation">
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
            <label for="entrance-delay">Entrance Delay.<br/><small>Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)</small></label>
            <input name="entrance-delay" id="entrance-delay" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="extra-class" id="extra-class" type="text" />
        </div>
         
    <a href="javascript:ProcessStepsDialog.insert(ProcessStepsDialog.local_ed)" id="insert" style="display: block;">Insert</a>
</form>