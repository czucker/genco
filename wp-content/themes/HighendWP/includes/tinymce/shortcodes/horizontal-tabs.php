<script type="text/javascript">
var HorizontalTabsDialog = {
	local_ed : 'ed',
	init : function(ed) {
		HorizontalTabsDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var animation = jQuery('#horizontal-tabs-entrance-animation').val();
		var animation_delay = jQuery('#horizontal-tabs-entrance-delay').val();
		var extra_class = jQuery('#horizontal-tabs-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[horizontal_tabs';

        if (animation != "none") 
            output += ' animation="' + animation + '"';
        if ( animation_delay )
            output += ' animation_delay="' + animation_delay +'"';
        if ( extra_class ) 
            output += ' class="' + extra_class + '"';

        output += ']<br/>';
        output += '[tab title="Tab Title 1" icon="icon-heart"]Enter your tab content here...[/tab]<br/>';
        output += '[tab title="Tab Title 2" icon="hb-moon-brain"]Copy these tab elements to create as many of them as you need...[/tab]<br/>';
        output += '[tab title="Tab Title 3" icon="hb-moon-star"]Entery any other shortcode here...[/tab]<br/>';
        output += '[/horizontal_tabs]';
		
		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(HorizontalTabsDialog.init, HorizontalTabsDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

        <div class="form-section clearfix">
            <label for="horizontal-tabs-entrance-animation">Entrance Animation.<br/><small>Choose an entrance animation for this element.</small></label>
            <select name="horizontal-tabs-entrance-animation" id="horizontal-tabs-entrance-animation">
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
            <label for="horizontal-tabs-entrance-delay">Entrance Delay.<br/><small>Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)</small></label>
            <input name="horizontal-tabs-entrance-delay" id="horizontal-tabs-entrance-delay" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="horizontal-tabs-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="horizontal-tabs-extra-class" id="horizontal-tabs-extra-class" type="text" />
        </div>
         
    <a href="javascript:HorizontalTabsDialog.insert(HorizontalTabsDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>