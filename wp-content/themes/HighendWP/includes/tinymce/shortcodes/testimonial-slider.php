<script type="text/javascript">
var TestimonialSliderDialog = {
	local_ed : 'ed',
	init : function(ed) {
		TestimonialSliderDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var slider_type = jQuery('#slider-type').val();
		var count = jQuery('#item-count').val();
        var animation_speed = jQuery('#animation-speed').val();
        var slideshow_speed = jQuery('#slideshow-speed').val();
        var orderby = jQuery('#order-by').val();
        var order = jQuery('#order').val();
        var category = jQuery('#testimonial-category').val();

		var animation = jQuery('#testimonial-slider-entrance-animation').val();
		var animation_delay = jQuery('#testimonial-slider-entrance-delay').val();
		var extra_class = jQuery('#testimonial-slider-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[testimonial_slider';
        output += ' type=\"' + slider_type + '\"';
        if ( count != '' ) {
            output += ' count=\"' + count + '\"';
        }

        if ( animation_speed != '' ) {
            output += ' animation_speed=\"' + animation_speed + '\"';
        }

        if ( slideshow_speed != '' ) {
            output += ' slideshow_speed=\"' + slideshow_speed + '\"';
        }

        if ( category != '' ) {
            output += ' category=\"' + category + '\"';
        }

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
tinyMCEPopup.onInit.add(TestimonialSliderDialog.init, TestimonialSliderDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

        <div class="form-section clearfix">
            <label for="slider-type">Slider Type.<br/><small>Choose between a Large or Normal Testimonial Slider.</small></label>
            <select name="slider-type" id="slider-type">
                <option value="normal" selected>Normal</option>
                <option value="large">Large</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="item-count">Testimonials number.<br/><small>Enter how many testimonials to show in the slider. Leave empty to display all testimonials. Example: 5</small></label>
            <textarea type="text" name="item-count" id="item-count" placeholder="Example: 5"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="testimonial-category">Testimonials category.<br/><small>Specify which category will be displayed. Enter category slug.</small></label>
            <textarea type="text" name="testimonial-category" id="testimonial-category" placeholder="Example: my-testimonial-category"></textarea>
        </div>


        <div class="form-section clearfix">
            <label for="slideshow-speed">Slideshow Speed.<br/><small>Enter time in ms. This is the time an item will be visible before switching to another testimonial. Example: 5000.</small></label>
            <textarea type="text" name="slideshow-speed" id="slideshow-speed" placeholder="Example: 5000"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="animation-speed">Animation Speed.<br/><small>Enter time in ms. This is the transition time between two testimonials. Example: 350.</small></label>
            <textarea type="text" name="animation-speed" id="animation-speed" placeholder="Example: 350"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="order-by">Choose in which order to show testimonials.<br/><small>Select an order from the list of possible post orders.</small></label>
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
            <label for="testimonial-slider-entrance-animation">Entrance Animation.<br/><small>Choose an entrance animation for this element.</small></label>
            <select name="testimonial-slider-entrance-animation" id="testimonial-slider-entrance-animation">
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
            <label for="testimonial-slider-entrance-delay">Entrance Delay.<br/><small>Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)</small></label>
            <input name="testimonial-slider-entrance-delay" id="testimonial-slider-entrance-delay" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="testimonial-slider-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="testimonial-slider-extra-class" id="testimonial-slider-extra-class" type="text" />
        </div>
         
    <a href="javascript:TestimonialSliderDialog.insert(TestimonialSliderDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>