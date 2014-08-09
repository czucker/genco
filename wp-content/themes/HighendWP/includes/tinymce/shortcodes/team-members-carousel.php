<script type="text/javascript">
var TeamCarouselDialog = {
	local_ed : 'ed',
	init : function(ed) {
		TeamCarouselDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
        var style = jQuery('#team-style').val();
		var visible_items = jQuery('#visible-items').val();
		var total_items = jQuery('#total-items').val();
		var team_category = jQuery('#team-category').val();
		var order_by = jQuery('#order-by').val();
		var order = jQuery('#order').val();
		var carousel_speed = jQuery('#carousel-speed').val();
        var excerpt_length = jQuery('#excerpt-length').val();
		var animation = jQuery('#team-carousel-entrance-animation').val();
		var animation_delay = jQuery('#team-carousel-entrance-delay').val();
		var extra_class = jQuery('#team-carousel-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
				// setup the output of our shortcode
		output += '[team_carousel';
		output += ' visible_items=\"' + visible_items + '\"';

		if ( total_items != '' ){
			output += ' total_items=\"' + total_items + '\"';
		} else {
			output += ' total_items=\"-1\"';
		}

		if ( team_category != '' ) {
			output += ' category=\"' + team_category + '\"';
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
tinyMCEPopup.onInit.add(TeamCarouselDialog.init, TeamCarouselDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

        <div class="form-section clearfix">
            <label for="team-style">Team Member Box Style.<br/></label>
            <select name="team-style" id="team-style">
                <option value="" selected>Normal</option>
                <option value="boxed">Boxed</option>
            </select>
        </div>


        <div class="form-section clearfix">
            <label for="visible-items">Visible Team Members.<br/><small>Choose how many members are visible at once.</small></label>
            <select name="visible-items" id="visible-items">
            	<option value="2">2</option>
            	<option value="3">3</option>
            	<option value="4" selected>4</option>
            	<option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="total-items">Total Team Members Posts.<br/><small>Choose how many posts to include in the carousel. To get all posts enter -1.</small></label>
            <input name="total-items" id="total-items" type="text" placeholder="Example: 10" />
        </div>

        <div class="form-section clearfix">
            <label for="team-category">Team Member Categories.<br/><small>Choose which team members categories will be shown in the carousels. Enter category <strong>slugs</strong> and separate them with commas. Example: category-1, category-2</small></label>
            <input name="team-category" id="team-category" type="text" placeholder="Example: category-1, category-2" />
        </div>

        <div class="form-section clearfix">
            <label for="excerpt-length">Excerpt Length.<br/><small>Specify how many words will show in the excerpt, enter just a number. Example: 15.</small></label>
            <input name="excerpt-length" id="excerpt-length" type="text" placeholder="Example: 15" />
        </div>

        <div class="form-section clearfix">
            <label for="order-by">Choose in which order to show members.<br/><small>Select an order from the list of possible post orders.</small></label>
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
            <label for="team-carousel-entrance-animation">Entrance Animation.<br/><small>Choose an entrance animation for this element.</small></label>
            <select name="team-carousel-entrance-animation" id="team-carousel-entrance-animation">
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
            <label for="team-carousel-entrance-delay">Entrance Delay.<br/><small>Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)</small></label>
            <input name="team-carousel-entrance-delay" id="team-carousel-entrance-delay" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="team-carousel-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="team-carousel-extra-class" id="team-carousel-extra-class" type="text" />
        </div>
         
    <a href="javascript:TeamCarouselDialog.insert(TeamCarouselDialog.local_ed)" id="insert" style="display: block;">Insert</a>
</form>