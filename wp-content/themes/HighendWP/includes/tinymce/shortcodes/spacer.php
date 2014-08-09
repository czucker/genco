<script type="text/javascript">
var SpacerDialog = {
	local_ed : 'ed',
	init : function(ed) {
		SpacerDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var height = jQuery('#spacer-height').val();
		var extra_class = jQuery('#spacer-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[spacer';

		if (height != ''){
			output += ' height=\"'+ height +'\"';
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
tinyMCEPopup.onInit.add(SpacerDialog.init, SpacerDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

        <div class="form-section clearfix">
            <label for="spacer-height">Spacer Height.<br/><small>Enter the height of this spacer in pixels. Do not write px. Leave empty for default value. Example: 40</small></label>
            <input type="text" name="spacer-height" id="spacer-height" placeholder="Example: 40"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="spacer-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="spacer-extra-class" id="spacer-extra-class" type="text" />
        </div>
         
    <a href="javascript:SpacerDialog.insert(SpacerDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>