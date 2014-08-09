<script type="text/javascript">
var NotifDialog = {
	local_ed : 'ed',
	init : function(ed) {
		NotifDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var style = jQuery('#notif-style').val();
		var content = jQuery('textarea#notif-content').val();
		var animation = jQuery('#list-entrance-animation').val();
		var animation_delay = jQuery('#list-entrance-delay').val();
		var list_type = jQuery('#list-type').val();
		var extra_class = jQuery('#list-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[info_message';

		output += ' style=\"'+ style +'\"';

		if (animation != 'none'){
			output += ' animation=\"'+ animation +'\"';
		}

		if (animation_delay != '' && animation != 'none'){
			output += ' animation_delay=\"'+ animation_delay +'\"';
		}

		if (extra_class != '') {
			output += ' class=\"'+extra_class+'\"';
		}
		
		output += ']';
		
		if ( content != '' ) { output += content; }
		else { output += 'Enter your message here.'; }

		output += '[/info_message]';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(NotifDialog.init, NotifDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

		<div class="form-section clearfix">
            <label for="notif-style">Message Style.<br/><small>Choose the style for this message.</small></label>
            <select name="notif-style" id="notif-style">
            	<option value="info" selected>Info</option>
            	<option value="warning">Warning</option>
            	<option value="error">Error</option>
            	<option value="success">Success</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="notif-content">Message Text<br /><small>Enter your message text here.</small></label>
            <textarea name="notif-content" value="" id="notif-content"></textarea>
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
         
    <a href="javascript:NotifDialog.insert(NotifDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>