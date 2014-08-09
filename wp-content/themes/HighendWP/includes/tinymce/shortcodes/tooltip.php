1<script type="text/javascript">
var TooltipDialog = {
	local_ed : 'ed',
	init : function(ed) {
		TooltipDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var tooltip_position = jQuery('#tooltip-position').val();
		var tooltip_text = jQuery('#tooltip-text').val();
		var extra_class = jQuery('#tooltip-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[tooltip';

		if (tooltip_text == ''){
			tooltip_text = "Enter your tooltip text here...";
		}

		output += ' position=\"'+tooltip_position+'\"';
		output += ' text=\"'+tooltip_text+'\"';

		if (extra_class != '') {
			output += ' class=\"'+extra_class+'\"';
		}
		
		output += ']';

		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		if (mceSelected == ''){
			output += 'Text goes here';
		} else {
			output += mceSelected;
		}

		output += '[/tooltip]';
		
		tinyMCEPopup.execCommand('mceReplaceContent', true, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(TooltipDialog.init, TooltipDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

		<div class="form-section clearfix">
            <label for="tooltip-position">Tooltip Position.<br/><small>Choose position for your tooltip.</small></label>
            <select name="tooltip-position" id="tooltip-position">
            	<option value="top">Top</option>
            	<option value="right">Right</option>
            	<option value="bottom">Bottom</option>
            	<option value="left">Left</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="tooltip-text">Tooltip Text.<br/><small>Enter a plain text which will be shown in the tooltip on hover.</small></label>
            <textarea name="tooltip-text" id="tooltip-text" type="text"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="tooltip-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="tooltip-extra-class" id="tooltip-extra-class" type="text" />
        </div>
         
    <a href="javascript:TooltipDialog.insert(TooltipDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>