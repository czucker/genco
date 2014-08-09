<script type="text/javascript">
var AlignCenterDialog = {
	local_ed : 'ed',
	init : function(ed) {
		AlignCenterDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var initial_index = jQuery('#initial-index').val();
		
		var animation = jQuery('#accordion-entrance-animation').val();
		var animation_delay = jQuery('#accordion-entrance-delay').val();
		var extra_class = jQuery('#accordion-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[align_center]Enter content to align center.[/align_center]';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(AlignCenterDialog.init, AlignCenterDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">
         
    <a href="javascript:AlignCenterDialog.insert(AlignCenterDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>