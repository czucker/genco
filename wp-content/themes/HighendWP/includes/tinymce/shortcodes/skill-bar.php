<script type="text/javascript">
var SkillDialog = {
	local_ed : 'ed',
	init : function(ed) {
		SkillDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var color = jQuery('#skill-color').val();
		var to = jQuery('#skill-to').val();
		var character = jQuery('#skill-char').val();
		var subtitle = jQuery('#skill-subtitle').val();
		var extra_class = jQuery('#skill-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[skill';

		if (to != ''){
			output += ' number=\"'+ to +'\"';
		} else {
			output += ' number=\"50\"';
		}

		if (character != ''){
			output += ' char=\"'+ character +'\"';
		}

		if (subtitle != ''){
			output += ' caption=\"'+ subtitle +'\"';
		}

		if (color != ''){
			output += ' color=\"'+ color +'\"';
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
tinyMCEPopup.onInit.add(SkillDialog.init, SkillDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

        <div class="form-section clearfix">
            <label for="skill-to">End Number.<br/><small>Enter the number this skill is filled. Do not write % or any other character. Example: 80</small></label>
            <input type="text" name="skill-to" id="skill-to" placeholder="Example: 80"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="skill-to">Character.<br/><small>Enter a character which stands next to the number. Example: %</small></label>
            <input type="text" name="skill-char" id="skill-char" placeholder="Example: %"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="skill-subtitle">Skill Title.<br/><small>A word, or short text to display above the skill meter. Example: Photoshop</small></label>
            <input type="text" name="skill-subtitle" id="skill-subtitle" placeholder="Example: Photoshop"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="skill-color">Color.<br/><small>Enter a focus color for this element in hex format. Example #ff6838</small></label>
            <input name="skill-color" id="skill-color" type="text" placeholder="Example: #ff6838" />
        </div>

        <div class="form-section clearfix">
            <label for="skill-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="skill-extra-class" id="skill-extra-class" type="text" />
        </div>
         
    <a href="javascript:SkillDialog.insert(SkillDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>