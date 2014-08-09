<script type="text/javascript">
var ColumnsDialog = {
	local_ed : 'ed',
	init : function(ed) {
		ColumnsDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var layout = jQuery('#columns-type').val();
		var margin_top = jQuery('#columns-margin-top').val();
		var margin_bottom = jQuery('#columns-margin-bottom').val();
		var extra_class = jQuery('#columns-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[row';
		
		if (margin_top != '') {
			output += ' margin_top=\"'+margin_top+'px\"';
		}

		if (margin_bottom != '') {
			output += ' margin_bottom=\"'+margin_bottom+'px\"';
		}

		if (extra_class != '') {
			output += ' class=\"'+extra_class+'\"';
		}
		
		output += ']<br/>';

		if (layout == 'col-1'){
			output += '[column size="col-12"]Column content goes here.[/column]<br/>';
		}

		else if (layout == 'col-2-2'){
			output += '[column size="col-6"]Column content goes here.[/column]<br/>';
			output += '[column size="col-6"]Column content goes here.[/column]<br/>';
		}

		else if (layout == 'col-3-3-3'){
			output += '[column size="col-4"]Column content goes here.[/column]<br/>';
			output += '[column size="col-4"]Column content goes here.[/column]<br/>';
			output += '[column size="col-4"]Column content goes here.[/column]<br/>';
		}

		else if (layout == 'col-33-3'){
			output += '[column size="col-8"]Column content goes here.[/column]<br/>';
			output += '[column size="col-4"]Column content goes here.[/column]<br/>';
		} 

		else if (layout == 'col-4-4-4-4'){
			output += '[column size="col-3"]Column content goes here.[/column]<br/>';
			output += '[column size="col-3"]Column content goes here.[/column]<br/>';
			output += '[column size="col-3"]Column content goes here.[/column]<br/>';
			output += '[column size="col-3"]Column content goes here.[/column]<br/>';
		}

		else if (layout == 'col-2-4-4'){
			output += '[column size="col-6"]Column content goes here.[/column]<br/>';
			output += '[column size="col-3"]Column content goes here.[/column]<br/>';
			output += '[column size="col-3"]Column content goes here.[/column]<br/>';
		}

		else if (layout == 'col-444-4'){
			output += '[column size="col-9"]Column content goes here.[/column]<br/>';
			output += '[column size="col-3"]Column content goes here.[/column]<br/>';
		}

		else {
			output += '[column size="col-6"]Column content goes here.[/column]<br/>';
			output += '[column size="col-6"]Column content goes here.[/column]<br/>';
		}

		output += '[/row]<br/>';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(ColumnsDialog.init, ColumnsDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">
        <div class="form-section clearfix">
            <label for="columns-type">Column Layout.<br/><small>Each column layout represents one row. You can mix columns in the manually. But the sum must be equal to 1.</small></label>
            <select name="columns-type" id="columns-type" size="1">
                <option value="col-1" selected="selected">1/1</option>
                <option value="col-2-2">1/2 + 1/2</option>
                <option value="col-3-3-3">1/3 + 1/3 + 1/3</option>
                <option value="col-33-3">2/3 + 1/3</option>
                <option value="col-4-4-4-4">1/4 + 1/4 + 1/4 + 1/4</option>
                <option value="col-2-4-4">1/2 + 1/4 + 1/4</option>
                <option value="col-444-4">3/4 + 1/4</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="columns-margin-top">Margin Top.<br/><small>Enter top margin for this row in pixels. Leave empty for default value. No need to write px. Eg: -40</small></label>
            <input name="columns-margin-top" id="columns-margin-top" type="text" />
        </div>

        <div class="form-section clearfix">
            <label for="columns-margin-bottom">Margin Bottom.<br/><small>Enter bottom margin for this row in pixels. Leave empty for default value. No need to write px. Eg: 50</small></label>
            <input name="columns-margin-bottom" id="columns-margin-bottom" type="text" />
        </div>

        <div class="form-section clearfix">
            <label for="columns-extra-class">Extra Class.<br/><small>Enter additional CSS class for this row of columns. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="columns-extra-class" id="columns-extra-class" type="text" />
        </div>
         
    <a href="javascript:ColumnsDialog.insert(ColumnsDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>