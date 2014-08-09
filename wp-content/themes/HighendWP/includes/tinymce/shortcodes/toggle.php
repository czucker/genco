<script type="text/javascript">
var ToggleDialog = {
	local_ed : 'ed',
	init : function(ed) {
		ToggleDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var initial_index = jQuery('#initial-index').val();
		
		var animation = jQuery('#toggle-entrance-animation').val();
		var animation_delay = jQuery('#toggle-entrance-delay').val();
		var extra_class = jQuery('#toggle-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[toggle_group';

        if ( initial_index != '' ) {
            output += ' initial_index=\"' + initial_index + '\"';
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
        output += '[toggle_item icon="icon-heart" title="Toggle Title 1"]Enter your toggle content here...[/toggle_item]<br/>';
        output += '[toggle_item icon="hb-moon-brain" title="Toggle Title 2"]Copy these toggle_item elements to create as many of them as you need...[/toggle_item]<br/>';
        output += '[/toggle_group]';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(ToggleDialog.init, ToggleDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

        <div class="form-section clearfix">
            <label for="initial-index">Initial Index.<br/><small>Enter index of the toggle item which should be open initially. First element is number 0.</small></label>
            <input type="text" name="initial-index" id="initial-index" placeholder="Example: 0"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="toggle-entrance-animation">Entrance Animation.<br/><small>Choose an entrance animation for this element.</small></label>
            <select name="toggle-entrance-animation" id="toggle-entrance-animation">
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
            <label for="toggle-entrance-delay">Entrance Delay.<br/><small>Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)</small></label>
            <input name="toggle-entrance-delay" id="toggle-entrance-delay" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="toggle-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="toggle-extra-class" id="toggle-extra-class" type="text" />
        </div>
         
    <a href="javascript:ToggleDialog.insert(ToggleDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>