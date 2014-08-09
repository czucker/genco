<script type="text/javascript">
var ChartDialog = {
	local_ed : 'ed',
	init : function(ed) {
		ChartDialog.local_ed = ed;
		tinyMCEPopup.resizeToInnerSize();
	},
	insert : function insertButton(ed) {
	 
		// Try and remove existing style / blockquote
		tinyMCEPopup.execCommand('mceRemoveNode', false, null);
		 
		// set up variables to contain our input values
		
		var chart_color = jQuery('#chart-color').val();
		var chart_type = jQuery('#chart-type').val();
		var chart_icon = jQuery('#chart-icon').val();
		var chart_text = jQuery('#chart-text').val();
		var chart_percent = jQuery('#chart-percent').val();
        var chart_caption = jQuery('#chart-caption').val();
        var chart_weight = jQuery('#chart-weight').val();
        var chart_circle_color = jQuery('#chart-circle-color').val();
        var animation_speed = jQuery('#chart-animation-speed').val();
		var animation = jQuery('#chart-entrance-animation').val();
		var animation_delay = jQuery('#chart-entrance-delay').val();
		var extra_class = jQuery('#chart-extra-class').val();


		//set highlighted content variable
		var mceSelected = tinyMCE.activeEditor.selection.getContent();
		var output = '';
		
		// setup the output of our shortcode
		output += '[circle_chart';


		output += ' type="' + chart_type + '"';
		output += ' color="' + chart_color + '"';
        output += ' track_color="' + chart_circle_color + '"';
        output += ' weight="' + chart_weight + '"';

		if (chart_icon){
			output += ' icon="' + chart_icon + '"';
		}

		if (chart_text){
			output += ' text="' + chart_text + '"';
		}

		if (chart_percent){
			output += ' percent="' + chart_percent + '"';
		}

        if (chart_caption){
            output += ' caption="' + chart_caption + '"';
        }

        if ( animation_speed != "" ) {
            output += ' animation_speed=\"' + animation_speed + '\"';
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
tinyMCEPopup.onInit.add(ChartDialog.init, ChartDialog);
</script>
<form action="/" method="get" accept-charset="utf-8">

        <div class="form-section clearfix">
            <label for="chart-type">Chart Type.<br/><small>Select a type for this element.</small></label>
            <select name="chart-type" id="chart-type">
            	<option value="with-icon">Chart with Icon</option>
            	<option value="with-percent" selected>Chart with Percent</option>
            	<option value="with-text">Chart with Text</option>
            </select>
        </div>

        <div class="form-section clearfix">
            <label for="chart-icon">Chart Icon<br /><small>If you have selected "Chart with Icon" enter your icon name here. <a href="http://documentation.hb-themes.com/icons/" target="_blank">View list of icons.</a></small></label>
            <input type="text" name="chart-icon" id="chart-icon" placeholder="Example: icon-heart"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="chart-percent">Chart Percent<br /><small>Enter a percent number here. Do not enter % character, just number! Example: 60</small></label>
            <input type="text" name="chart-percent" id="chart-percent" value="60" placeholder="Example: 60"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="chart-text">Chart Text<br /><small>If you have selected "Chart with Text" enter your text here.</small></label>
            <input type="text" name="chart-text" id="chart-text" placeholder="Example: Photoshop"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="chart-text">Chart Caption<br /><small>Optional chart caption. Showed below the chart.</small></label>
            <input type="text" name="chart-caption" id="chart-caption" placeholder="Example: Working Hours"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="chart-color">Color.<br/><small>Enter color in hex format for this element.</small></label>
            <input type="text" name="chart-color" id="chart-color" value="#336699"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="chart-circle-color">Circle Color.<br/><small>Enter color in hex format for the circle bar.</small></label>
            <input type="text" name="chart-circle-color" id="chart-circle-color" value="#e1e1e1"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="chart-weight">Chart Weight.<br/><small>Enter chart weight value. Example: 4.</small></label>
            <input type="text" name="chart-weight" id="chart-weight" value="3"></textarea>
        </div>

        <div class="form-section clearfix">
            <label for="chart-animation-speed">Animation Speed.<br/><small>Enter chart animation speed. Useful for creating timed animations. No need to enter ms. Eg: 1000 (1000 stands for 1 second)</small></label>
            <input name="chart-animation-speed" id="chart-animation-speed" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="chart-entrance-animation">Entrance Animation.<br/><small>Choose an entrance animation for this element.</small></label>
            <select name="chart-entrance-animation" id="chart-entrance-animation">
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
            <label for="chart-entrance-delay">Entrance Delay.<br/><small>Enter delay in miliseconds before the animation starts. Useful for creating timed animations. No need to enter ms. Eg: 300 (300 stands for 0.3 seconds)</small></label>
            <input name="chart-entrance-delay" id="chart-entrance-delay" type="text" placeholder="Example: 300" />
        </div>

        <div class="form-section clearfix">
            <label for="chart-extra-class">Extra Class.<br/><small>Enter additional CSS class. Separate classes with space. Eg: my-class second-class</small></label>
            <input name="chart-extra-class" id="chart-extra-class" type="text" />
        </div>
         
    <a href="javascript:ChartDialog.insert(ChartDialog.local_ed)" id="insert" style="display: block;">Insert</a>
    
</form>