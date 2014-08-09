<script type="text/javascript">
var DropcapDialog = {
	local_ed : 'ed',
	init : function(ed) {
		DropcapDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertDropcap(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		
		var dropcap_style = jQuery('#dropcap-style').val();
		var content = jQuery('textarea#dropcap-content').val();
		var extra_class = jQuery('#dropcap-extra-class').val();
		
				 
		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[dropcap';
		
		if ( dropcap_style != '' ){
			output += ' style=\"'+dropcap_style+'\"';
		}

		if ( extra_class != '' ){
			output += ' class=\"'+extra_class+'\"';
		}

		output += ']';

		if ( content ) { output += content; }
		else if (mceSelected != '') { output += mceSelected; }
		else output += 'A';
		
		output += '[/dropcap]';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(DropcapDialog.init, DropcapDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">
		
		<div class="form-section clearfix">
            <label for="dropcap-style">Dropcap Style.<br/><small>Select style for the dropcap.</small></label>
            <select name="dropcap-style" id="dropcap-style" size="1">
                <option value="default" selected="selected">Default</option>
                <option value="simple">Simple</option>
                <option value="fancy">Fancy</option>
                <option value="dark">Dark</option>
            </select>
        </div>

		<div class="form-section clearfix">
            <label for="dropcap-content">Dropcap Content<br /><small>Leave blank to use selected text from the Content Editor.</small></label>
            <textarea name="dropcap-content" value="" id="dropcap-content"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="dropcap-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="dropcap-extra-class" id="dropcap-extra-class" type="text" />
        </div>
		
        
    <a href="javascript:DropcapDialog.insert(DropcapDialog.local_ed)" id="insert" style="display: block; line-height: 24px;">Insert</a>
    
</form>