<script type="text/javascript">
var ModalDialog = {
	local_ed : 'ed',
	init : function(ed) {
		ModalDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var title = jQuery('#window-title').val();
		var invoke = jQuery('#invoke-button').val();
		var extra_id = jQuery('#window-extra-id').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[modal_window';
		
		if (title != ''){
			output += ' title="' + title + '"';
		} else {
			output += ' title="Modal Window"';
		}

		if (invoke != ''){
			output += ' invoke_title="' + invoke + '"';
		} else {
			output += ' invoke_title="Show Modal Window"';
		}

		if (extra_id != ''){
			output += ' id="' + extra_id + '"';
		}
		
		output += ']<br/>';
		output += 'Enter the content for modal window here.<br/>';
		output += '[/modal_window]<br/>';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(ModalDialog.init, ModalDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

        <div class="form-section clearfix">
            <label for="window-title">Window Title.<br/><small>Enter a title for this modal window. Example: My Window Title</small></label>
            <input type="text" name="window-title" id="window-title" placeholder="Example: My Window Title"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="invoke-button">Invoke Button Title.<br/><small>Enter a title for the invoke button for this modal window. Example: Show Modal</small></label>
            <input type="text" name="invoke-button" id="invoke-button" placeholder="Example: Show Modal"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="window-extra-id">Optional Unique ID.<br/><small>Enter a UNIQUE id word, without spaces, that will be assigned to this modal window. You can use this id to invoke the window with javascript if you don't want to show the invoke button.</small></label>

            <input type="text" name="window-extra-id" id="window-extra-id" placeholder="Example: mymodalwindow"></textarea>
        </div>

        <div class="form-section clearfix">
            <small>Content between [modal_window] and [/modal_window] will be shown inside the modal window. You can use shortcodes inside also.</small></label>
        </div>
         
    <a href="javascript:ModalDialog.insert(ModalDialog.local_ed)" id="insert" style="display: block;">Insert</a>
</form>