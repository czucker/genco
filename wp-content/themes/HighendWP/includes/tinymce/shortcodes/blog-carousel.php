<script type="text/javascript">
var BlogCarouselDialog = {
	local_ed : 'ed',
	init : function(ed) {
		BlogCarouselDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var visible_items = jQuery('#visible-items').val();
		var total_items = jQuery('#total-items').val();
		var blog_category = jQuery('#blog-category').val();
		var excerpt_length = jQuery('#excerpt-length').val();
		var order_by = jQuery('#order-by').val();
		var order = jQuery('#order').val();
		var carousel_speed = jQuery('#carousel-speed').val();
		
		var animation = jQuery('#blog-carousel-entrance-animation').val();
		var animation_delay = jQuery('#blog-carousel-entrance-delay').val();
		var extra_class = jQuery('#blog-carousel-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
				// setup the output of our shortcode
		output += '[blog_carousel';
		output += ' visible_items=\"' + visible_items + '\"';

		if ( total_items != '' ){
			output += ' total_items=\"' + total_items + '\"';
		} else {
			output += ' total_items=\"-1\"';
		}

		if ( blog_category != '' ) {
			output += ' category=\"' + blog_category + '\"';
		}

		if ( excerpt_length != '' ) {
			output += ' excerpt_length=\"' + excerpt_length + '\"';
		}

		output += ' orderby=\"' + order_by + '\"';
		output += ' order=\"' + order + '\"';

		if ( carousel_speed != '' ) {
			output += ' carousel_speed=\"' + carousel_speed + '\"';
		}
		
		if ( jQuery('#auto-rotate').is(':checked') ){
			output += ' auto_rotate=\"yes\"';
		} 

		if ( jQuery('#read-more').is(':checked') ){
			output += ' read_more=\"yes\"';
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
tinyMCEPopup.onInit.add(BlogCarouselDialog.init, BlogCarouselDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

        <div class="form-section clearfix">
            <label for="visible-items">Visible Blog Posts.<br/><small>Choose how many posts are visible at once.</small></label>
            <select name="visible-items" id="visible-items">
            	<option value="1">1</option>
            	<option value="2">2</option>
            	<option value="3" selected>3</option>
            	<option value="4">4</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="total-items">Total Blog Posts.<br/><small>Choose how many posts to include in the carousel. To get all posts enter -1.</small></label>
            <input name="total-items" id="total-items" type="text" placeholder="Example: 10" />
        </div>

        <div class="form-section clearfix">
            <label for="blog-category">Blog Post Categories.<br/><small>Choose which post categories will be shown in the carousels. Enter category <strong>slugs</strong> and separate them with commas. Example: category-1, category-2</small></label>
            <input name="blog-category" id="blog-category" type="text" placeholder="Example: category-1, category-2" />
        </div>

        <div class="form-section clearfix">
            <label for="excerpt-length">Blog Post Excerpt Length.<br/><small>Specify how many words will be shown in the post excerpt. Leave empty for default value.</small></label>
            <input name="excerpt-length" id="excerpt-length" type="text" placeholder="Example: 20" />
        </div>

		<div class="form-section clearfix">
            <label for="read-more"><small>Display Read More Button?</small></label>
            <input name="read-more" id="read-more" value="read-more" type="checkbox" checked/>
        </div>

        <div class="form-section clearfix">
            <label for="order-by">Choose in which order to show blog posts.<br/><small>Select an order from the list of possible post orders.</small></label>
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
            <label for="carousel-speed">Carousel Speed.<br/><small>Specify the carousel speed in miliseconds, enter just a number. Example: 2000.</small></label>
            <input name="carousel-speed" id="carousel-speed" type="text" placeholder="Example: 2000" />
        </div>

		<div class="form-section clearfix">
            <label for="auto-rotate"><small>Auto Rotate?</small></label>
            <input name="auto-rotate" id="auto-rotate" value="auto-rotate" type="checkbox" checked/>
        </div>

        <div class="form-section clearfix">
            <label for="blog-carousel-entrance-animation">Entrance Animation.<br/><small>Choose an entrance animation for this element.</small></label>
            <select name="blog-carousel-entrance-animation" id="blog-carousel-entrance-animation">
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
            <label for="blog-carousel-entrance-delay">Entrance Delay.<br/><small>Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)</small></label>
            <input name="blog-carousel-entrance-delay" id="blog-carousel-entrance-delay" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="blog-carousel-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="blog-carousel-extra-class" id="blog-carousel-extra-class" type="text" />
        </div>
         
    <a href="javascript:BlogCarouselDialog.insert(BlogCarouselDialog.local_ed)" id="insert" style="display: block;">Insert</a>
</form>