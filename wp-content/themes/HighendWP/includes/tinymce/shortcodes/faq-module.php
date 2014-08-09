<script type="text/javascript">
var FAQModuleDialog = {
	local_ed : 'ed',
	init : function(ed) {
		FAQModuleDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var category = jQuery('#faq-category').val();
		var order_by = jQuery('#order-by').val();
		var order = jQuery('#order').val();
		
		var animation = jQuery('#entrance-animation').val();
		var animation_delay = jQuery('#entrance-delay').val();
		var extra_class = jQuery('#extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[faq';

		if (category != ''){
			output += ' category=\"'+ category +'\"';
		}

		output += ' orderby=\"' + order_by + '\"';
		output += ' order=\"' + order + '\"';

		if ( jQuery('#faq-filter').is(':checked') ){
			output += ' filter=\"yes\"';
		} 

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
tinyMCEPopup.onInit.add(FAQModuleDialog.init, FAQModuleDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

        <div class="form-section clearfix">
            <label for="faq-filter"><small>Show FAQ Filter?</small></label>
            <input name="faq-filter" id="faq-filter" value="auto-rotate" type="checkbox" checked/>
        </div>

		<div class="form-section clearfix">
            <label for="faq-category">FAQ Categories.<br/><small>Choose which faq categories will be shown in the module. Enter category <strong>slugs</strong> and separate them with commas. Example: category-1, category-2</small></label>
            <input name="faq-category" id="faq-category" type="text" placeholder="Example: category-1, category-2" />
        </div>

        <div class="form-section clearfix">
            <label for="order-by">Choose in which order to show faq items.<br/><small>Select an order from the list of possible post orders.</small></label>
            <select name="order-by" id="order-by">
            	<option value="date" selected>Date</option>
            	<option value="title">Title</option>
            	<option value="rand">Random</option>
            	<option value="comment_count">Comment Count</option>
            	<option value="menu_order">Menu Order</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="order">Descending or Ascending order.</label>
            <select name="order" id="order">
            	<option value="DESC" selected>Descending</option>
            	<option value="ASC">Ascending</option>
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
         
    <a href="javascript:FAQModuleDialog.insert(FAQModuleDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>