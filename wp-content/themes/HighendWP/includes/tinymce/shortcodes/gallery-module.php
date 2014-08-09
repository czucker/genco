<script type="text/javascript">
var FWGalleryDialog = {
	local_ed : 'ed',
	init : function(ed) {
		FWGalleryDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		var columns = jQuery('#columns').val();
		var count = jQuery('#total-count').val();
		var portfolio_category = jQuery('#portfolio-category').val();
		var order_by = jQuery('#order-by').val();
		var order = jQuery('#order').val();
        var orientation = jQuery('#orientation').val();
        var ratio = jQuery('#ratio').val();
		var animation = jQuery('#portfolio-carousel-entrance-animation').val();
		var animation_delay = jQuery('#portfolio-carousel-entrance-delay').val();
		var extra_class = jQuery('#portfolio-carousel-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
				// setup the output of our shortcode
		output += '[gallery_fullwidth';
		output += ' columns=\"' + columns + '\"';

		if ( count != '' ){
			output += ' count=\"' + count + '\"';
		} else {
			output += ' count=\"-1\"';
		}

		if ( portfolio_category != '' ) {
			output += ' category=\"' + portfolio_category + '\"';
		}

		output += ' orderby=\"' + order_by + '\"';
		output += ' order=\"' + order + '\"';

        output += ' orientation=\"' + orientation + '\"';
        output += ' ratio=\"' + ratio + '\"';

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
tinyMCEPopup.onInit.add(FWGalleryDialog.init, FWGalleryDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

        <div class="form-section clearfix">
            <label for="columns">Columns.<br/><small>Choose how many in how many columns to show your gallery items.</small></label>
            <select name="columns" id="columns">
            	<option value="2">2</option>
            	<option value="3">3</option>
            	<option value="4" selected>4</option>
            	<option value="5">5</option>
                <option value="6">6</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="total-count">Total Items.<br/><small>Choose how many gallery items to show in the module. To get all items enter -1.</small></label>
            <input name="total-count" id="total-count" type="text" placeholder="Example: 10" />
        </div>

        <div class="form-section clearfix">
            <label for="portfolio-category">Gallery Categories.<br/><small>Choose which gallery categories will be shown in the carousels. Enter category <strong>slugs</strong> and separate them with commas. Example: category-1, category-2</small></label>
            <input name="portfolio-category" id="portfolio-category" type="text" placeholder="Example: category-1, category-2" />
        </div>

        <div class="form-section clearfix">
            <label for="orientation">Image Orientation.<br/><small>Choose orientation of the gallery thumbnails.</small></label>
            <select name="orientation" id="orientation">
                <option value="landscape" selected>Landscape</option>
                <option value="portrait">Portrait</option>
            </select>
        </div>


        <div class="form-section clearfix">
            <label for="ratio">Image Ratio.<br/><small>Choose ratio of the gallery thumbnails.</small></label>
            <select name="ratio" id="ratio">
                <option value="ratio1" selected>16:9</option>
                <option value="ratio2">4:3</option>
                <option value="ratio4">3:2</option>
                <option value="ratio5">3:1</option>
                <option value="ratio3">1:1</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="order-by">Choose in which order to show gallery items.<br/><small>Select an order from the list of possible orders.</small></label>
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
            <label for="portfolio-carousel-entrance-animation">Entrance Animation.<br/><small>Choose an entrance animation for this element.</small></label>
            <select name="portfolio-carousel-entrance-animation" id="portfolio-carousel-entrance-animation">
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
            <label for="portfolio-carousel-entrance-delay">Entrance Delay.<br/><small>Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)</small></label>
            <input name="portfolio-carousel-entrance-delay" id="portfolio-carousel-entrance-delay" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="portfolio-carousel-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="portfolio-carousel-extra-class" id="portfolio-carousel-extra-class" type="text" />
        </div>
         
    <a href="javascript:FWGalleryDialog.insert(FWGalleryDialog.local_ed)" id="insert" style="display: block;">Insert</a>
</form>