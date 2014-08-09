<script type="text/javascript">
var ListDialog = {
	local_ed : 'ed',
	init : function(ed) {
		ListDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var animation = jQuery('#list-entrance-animation').val();
		var animation_delay = jQuery('#list-entrance-delay').val();
		var list_type = jQuery('#list-type').val();
		var extra_class = jQuery('#list-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[list';

		if (list_type == 'ordered'){
			output += ' type=\"ordered\"';
		}

		else if (list_type == 'unordered'){
			output += ' type=\"unordered\"';
		}

		else if (list_type == 'icon'){
			output += ' type=\"icon\"';
		}

		if ( jQuery('#list-lined').is(':checked') ){
			output += ' lined=\"yes\"';
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

		if (list_type != 'icon'){
			output += '[list_item]List item content here[/list_item]<br/>';
			output += '[list_item]List item content here[/list_item]<br/>';
			output += '[list_item]List item content here[/list_item]<br/>';
			output += '[list_item]List item content here[/list_item]<br/>';
			output += '[list_item]List item content here[/list_item]<br/>';
		} else {
			output += '[list_item icon="icon-ok" color="#ff6838"]List item content here[/list_item]<br/>';
			output += '[list_item icon="icon-ok" color="#336699"]List item content here[/list_item]<br/>';
			output += '[list_item icon="icon-ok" color="#1dc1df"]List item content here[/list_item]<br/>';
			output += '[list_item icon="icon-minus" color="#E65598"]List item content here[/list_item]<br/>';
			output += '[list_item icon="icon-minus" color="#777777"]List item content here[/list_item]<br/>';
		}

		output += '[/list]<br/>';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(ListDialog.init, ListDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

		<div class="form-section clearfix">
            <label for="list-type">List Style.<br/><small>Choose your list style. If you choose icon type, then you need to enter icons manually for each list item. <a href="http://documentation.hb-themes.com/icons" target="_blank">View icon list.</a></small></label>
            <select name="list-type" id="list-type">
            	<option value="ordered">Ordered List</option>
            	<option value="unordered">Unordered List</option>
            	<option value="icon">Custom Icon List</option>
            </select>
        </div>

		<div class="form-section clearfix">
            <label for="list-lined"><small>Separate list items with line?</small></label>
            <input name="list-lined" id="list-lined" value="lined-list" type="checkbox" />
        </div>

        <div class="form-section clearfix">
            <label for="list-entrance-animation">Entrance Animation.<br/><small>Choose an entrance animation for this element.</small></label>
            <select name="list-entrance-animation" id="list-entrance-animation">
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
            <label for="list-entrance-delay">Entrance Delay.<br/><small>Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)</small></label>
            <input name="list-entrance-delay" id="list-entrance-delay" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="list-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="list-extra-class" id="list-extra-class" type="text" />
        </div>
         
    <a href="javascript:ListDialog.insert(ListDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>