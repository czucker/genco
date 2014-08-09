<script type="text/javascript">
var ClearDialog = {
	local_ed : 'ed',
	init : function(ed) {
		ClearDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		
		var output = '';
		
		// setup the output of our shortcode
		output += '[clear]';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(ClearDialog.init, ClearDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

        <div class="form-section clearfix">
            <label>This element will clear floated divs. Insert it after two or more floated divs which are causing layout break.</label>
        </div>
         
    <a href="javascript:ClearDialog.insert(ClearDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>