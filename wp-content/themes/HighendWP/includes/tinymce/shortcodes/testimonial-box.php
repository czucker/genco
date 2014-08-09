<script type="text/javascript">
var TestimonialBoxDialog = {
	local_ed : 'ed',
	init : function(ed) {
		TestimonialBoxDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
        var type = jQuery('#testimonial-type').val();
        var count = jQuery('#testimonial-count').val();
        var columns = jQuery('#testimonial-columns').val();
        var category = jQuery('#testimonial-category').val();
        var order = jQuery('#order').val();
        var orderby = jQuery('#order-by').val();

		var animation = jQuery('#entrance-animation').val();
		var animation_delay = jQuery('#entrance-delay').val();
		var extra_class = jQuery('#extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[testimonial_box';
        
        output += ' type=\"' + type + '\"';
        
        if ( count != '' )
            output += ' count=\"' + count + '\"';

        if ( category != '' )
            output += ' category=\"' + category + '\"';
    
        if ( columns != '' )
            output += ' columns=\"' + columns + '\"';
    
        output += ' orderby=\"' + orderby + '\"';
        output += ' order=\"' + order + '\"';

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
tinyMCEPopup.onInit.add(TestimonialBoxDialog.init, TestimonialBoxDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

        <div class="form-section clearfix">
            <label for="testimonial-type">Testimonial Box Style.<br/><small>Choose between a boxed or a large quote style.</small></label>
            <select name="testimonial-type" id="testimonial-type">
            	<option value="normal" selected>Boxed</option>
            	<option value="large">Quote</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="testimonial-count">Testimonials count.<br/><small>Specify how many testimonials to show overall.</small></label>
            <textarea type="text" name="testimonial-count" id="testimonial-count" placeholder="Example: 6"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="testimonial-columns">Testimonials column count.<br/><small>Specify how many testimonials to per row.</small></label>
            <textarea type="text" name="testimonial-columns" id="testimonial-columns" placeholder="Example: 3"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="testimonial-category">Testimonials category.<br/><small>Specify which category will be displayed. Enter category slug.</small></label>
            <textarea type="text" name="testimonial-category" id="testimonial-category" placeholder="Example: my-testimonial-category"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="order-by">Choose in which order to show posts.<br/><small>Select an order from the list of possible post orders.</small></label>
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
         
    <a href="javascript:TestimonialBoxDialog.insert(TestimonialBoxDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>