<script type="text/javascript">
var VerticalTabsDialog = {
	local_ed : 'ed',
	init : function(ed) {
		VerticalTabsDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
        var position = jQuery('#vertical-tabs-style').val();
		// set up variables to contain our input values
		var animation = jQuery('#vertical-tabs-entrance-animation').val();
		var animation_delay = jQuery('#vertical-tabs-entrance-delay').val();
		var extra_class = jQuery('#vertical-tabs-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[vertical_tabs position=\"' + position + '\"]<br/>';
        output += '[tab icon="icon-heart" title="Tab Title 1"]Enter your tab content here...[/tab]<br/>';
        output += '[tab icon="hb-moon-brain" title="Tab Title 2"]Copy these tab elements to create as many of them as you need...[/tab]<br/>';
        output += '[tab icon="hb-moon-star" title="Tab Title 3"]Entery any other shortcode here...[/tab]<br/>';
        output += '[/vertical_tabs]';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(VerticalTabsDialog.init, VerticalTabsDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

        <div class="form-section clearfix">
            <label for="vertical-tabs-style">Tab Position.<br/><small>Choose between left or right position for the tabs.</small></label>
            <select name="vertical-tabs-style" id="vertical-tabs-style">
                <option value="left-tabs" selected>Left</option>
                <option value="right-tabs">Right</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="vertical-tabs-entrance-animation">Entrance Animation.<br/><small>Choose an entrance animation for this element.</small></label>
            <select name="vertical-tabs-entrance-animation" id="vertical-tabs-entrance-animation">
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
            <label for="vertical-tabs-entrance-delay">Entrance Delay.<br/><small>Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)</small></label>
            <input name="vertical-tabs-entrance-delay" id="vertical-tabs-entrance-delay" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="vertical-tabs-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="vertical-tabs-extra-class" id="vertical-tabs-extra-class" type="text" />
        </div>
         
    <a href="javascript:VerticalTabsDialog.insert(VerticalTabsDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>