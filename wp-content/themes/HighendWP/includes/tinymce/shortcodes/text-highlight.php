<script type="text/javascript">
var HighlightDialog = {
	local_ed : 'ed',
	init : function(ed) {
		HighlightDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertHighlight(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		
		var highlight_style = jQuery('#highlight-style').val();
		var content = jQuery('textarea#highlight-content').val();
		var extra_class = jQuery('#highlight-extra-class').val();
		
				 
		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[highlight';
		
		if ( highlight_style != '' ){
			output += ' style=\"'+highlight_style+'\"';
		}

		if ( extra_class != '' ){
			output += ' class=\"'+extra_class+'\"';
		}

		output += ']';

		if ( content ) { output += content; }
		else if (mceSelected != '') { output += mceSelected; }
		else if (mceSelected == '') { output += 'Enter your highlighted text here'; }
		
		output += '[/highlight]';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(HighlightDialog.init, HighlightDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">
		
		<div class="form-section clearfix">
            <label for="highlight-style">Highlight Style.<br/><small>Select style for the highlighter.</small></label>
            <select name="highlight-style" id="highlight-style" size="1">
                <option value="default" selected="selected">Default</option>
                <option value="alt">Alternative (Yellow)</option>
            </select>
        </div>

		<div class="form-section clearfix">
            <label for="highlight-content">Highlight Content<br /><small>Leave blank to use selected text from the Content Editor.</small></label>
            <textarea name="highlight-content" id="highlight-content"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="highlight-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="highlight-extra-class" id="highlight-extra-class" type="text" />
        </div>
		
        
    <a href="javascript:HighlightDialog.insert(HighlightDialog.local_ed)" id="insert" style="display: block; line-height: 24px;">Insert</a>
    
</form>