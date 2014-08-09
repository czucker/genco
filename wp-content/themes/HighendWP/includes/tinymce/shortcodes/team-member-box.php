<script type="text/javascript">
var TeamMemberBoxDialog = {
	local_ed : 'ed',
	init : function(ed) {
		TeamMemberBoxDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
        var style = jQuery('#team-style').val();
        var count = jQuery('#team-count').val();
        var columns = jQuery('#team-columns').val();
        var category = jQuery('#team-category').val();
        var order = jQuery('#order').val();
        var orderby = jQuery('#order-by').val();
        var excerpt_length = jQuery('#excerpt-length').val();
		var animation = jQuery('#entrance-animation').val();
		var animation_delay = jQuery('#entrance-delay').val();
		var extra_class = jQuery('#extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[team_member_box';
        if ( style != '' ) {
            output += ' style=\"' + style + '\"';
        }

        if ( count != '' )
            output += ' count=\"' + count + '\"';

        if ( columns != '' )
            output += ' columns=\"' + columns + '\"';

        if ( category != '' )
            output += ' category=\"' + category + '\"';

        output += ' orderby=\"' + orderby + '\"';
        output += ' order=\"' + order + '\"';

        if ( excerpt_length != '' ) {
            output += ' excerpt_length=\"' + excerpt_length + '\"';
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
tinyMCEPopup.onInit.add(TeamMemberBoxDialog.init, TeamMemberBoxDialog);
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
            <label for="team-count">Team Member count.<br/><small>Specify how many team members to show overall.</small></label>
            <textarea type="text" name="team-count" id="team-count" placeholder="Example: 6"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="team-columns">Team Member column count.<br/><small>Specify how many team members to per row.</small></label>
            <textarea type="text" name="team-columns" id="team-columns" placeholder="Example: 3"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="team-category">Team Member category.<br/><small>Specify which category will be displayed. Enter category slug.</small></label>
            <textarea type="text" name="team-category" id="team-category" placeholder="Example: my-team-category"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="excerpt-length">Excerpt Length.<br/><small>Specify how many words will show in the excerpt, enter just a number. Example: 15.</small></label>
            <input name="excerpt-length" id="excerpt-length" type="text" placeholder="Example: 15" />
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
         
    <a href="javascript:TeamMemberBoxDialog.insert(TeamMemberBoxDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>