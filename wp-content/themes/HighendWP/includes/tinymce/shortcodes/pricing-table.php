<script type="text/javascript">
var PricingTableDialog = {
	local_ed : 'ed',
	init : function(ed) {
		PricingTableDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var pricing_columns = jQuery('#pricing-columns').val();
		var pricing_style = jQuery('#pricing-style').val();
		var pricing_id = jQuery('#pricing-id').val();
		
		var animation = jQuery('#entrance-animation').val();
		var animation_delay = jQuery('#entrance-delay').val();
		var extra_class = jQuery('#extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
				// setup the output of our shortcode
		output += '[pricing_table';
        output += ' style=\"' + pricing_style + '\"';
		output += ' pricing_item=\"' + pricing_id + '\"';
		output += ' columns=\"' + pricing_columns + '\"';

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

		tinyMCEPopup.execCommand('mceReplaceContent', false, output);
		 
		// Return
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(PricingTableDialog.init, PricingTableDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

        <div class="form-section clearfix">
            <label for="pricing-id">Pricing Item ID.<br/><small>Enter the ID of the pricing table you want to display.</small></label>
            <input name="pricing-id" id="pricing-id" type="text" placeholder="Example: 10" />
        </div>

        <div class="form-section clearfix">
            <label for="pricing-style">Choose in which order to show pricing items.<br/><small>Select an order from the list of possible orders.</small></label>
            <select name="pricing-style" id="pricing-style">
            	<option value="standard" selected>Standard</option>
            	<option value="colored">Colored</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="pricing-columns">Pricing Column Count.</label>
            <select name="pricing-columns" id="pricing-columns">
            	<option value="1">1</option>
            	<option value="2">2</option>
            	<option value="3" selected>3</option>
            	<option value="4">4</option>
            	<option value="5">5</option>
            	<option value="6">6</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="entrance-animation">Entrance Animation.<br/><small>Choose an entrance animation for this element.</small></label>
            <select name="entrance-animation" id="entrance-animation">
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
            <label for="entrance-delay">Entrance Delay.<br/><small>Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)</small></label>
            <input name="entrance-delay" id="entrance-delay" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="extra-class" id="extra-class" type="text" />
        </div>
         
    <a href="javascript:PricingTableDialog.insert(PricingTableDialog.local_ed)" id="insert" style="display: block;">Insert</a>
</form>