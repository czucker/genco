<?php
/*
Plugin Name: Expand + Collapse Funk
Plugin URI: http://evan-herman.com
Description: Easily add expand/collapse functionality to any WordPress theme. Very easy to use interface for generating hidden content and links to reveal the content.
Version: 2.2
Author: Evan Herman
Author URI: http://www.Evan-Herman.com
License: GPL2
*/

  
function expand_collapse_functionality_everywhere() {
		// Expand Collapse Funk Functionality
		echo '<script>
			jQuery(document).ready(function() {
                                // expand-content-link renamed to expand-cnt-link for compatibility with twentyfourteen theme
				jQuery(".expand-content-link").removeClass("expand-content-link").addClass("expand-cnt-link");
				jQuery(".expand-cnt-link").click(function() {
					jQuery(this).toggleClass("ecf_closed").parent(".exp-col-content-holder").find(".hidden-content").first().stop().slideToggle("slow").css("display","block");
					return false;
				});	
				jQuery(".expand-cnt-link").toggleClass("ecf_closed").parent(".exp-col-content-holder").find(".hidden-content").css("display","none");
			
			//images with no float styles , get floated left
			if(typeof jQuery(".hidden-content > img").attr("float") === "undefined") {
				jQuery(".hidden-content > img:not([class])").addClass("alignleft");
			}
			
			/*
			jQuery(".hidden-content").each(function() {
				if (jQuery(this).find("img").length) {
					var hiddenContentpLength = jQuery(this).find(".hiddenContentp").text().length;
						if( hiddenContentpLength < 200 ) {
							jQuery(this).css("height","150px");
						}
				}
			});
			*/
			
			jQuery(".textwidget > .exp-col-content-holder > .hidden-content > img+p").attr("style","display:inherit !important;");
			
			});
				</script>';
		// Expand Collapse Funk Styles	
		echo '<style>
			.expand-cnt-link { font-weight:bold; display:block; margin-bottom:.5em; }
			.expand-cnt-link:before { font-family: "ecf-icons"; content: "\e601  ";  font-size:16px; }
			.hidden-content { display:block; vertical-align:top}
			.exp-col-content-holder { margin:15px 0px 15px 0 !important; }
			.exp-col-content-holder a { display:inline; }
			.exp-col-content-holder+p, .exp-col-content-holder img+p, .expand-cnt-link+p { display:none !important; }
			.ecf_closed:before { font-family: "ecf-icons"; content: "\e600  ";  font-size:16px; }
			.hiddenContentp { margin:0 !important; }
			.hiddenContentp+p { display:none;}
			.hidden-content img { width:20%; }
			.hidden-content img.alignright { margin-right:0 !important; margin-left:10px; margin-bottom:0px; }
			.hidden-content img.alignleft { margin-left:0 !important; margin-right:10px; margin-bottom:0px; }
			.hidden-content .videoWrapper+p { margin-bottom:0; }
			@font-face {
				font-family: "ecf-icons";
				src: url("fonts/ecf-icons.eot");
			}
			@font-face {
				font-family: "ecf-icons";
				src: url(data:application/x-font-ttf;charset=utf-8;base64,AAEAAAALAIAAAwAwT1MvMg6v8ysAAAC8AAAAYGNtYXDL8hqdAAABHAAAADxnYXNwAAAAEAAAAVgAAAAIZ2x5ZpFu6gUAAAFgAAABZGhlYWT+7sbiAAACxAAAADZoaGVhBigD3wAAAvwAAAAkaG10eAbbADMAAAMgAAAAEGxvY2EAvABeAAADMAAAAAptYXhwAAcAOAAAAzwAAAAgbmFtZUPPHeQAAANcAAABS3Bvc3QAAwAAAAAEqAAAACAAAwQAAZAABQAAApkCzAAAAI8CmQLMAAAB6wAzAQkAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABAACDmAQPA/8D/wAPAAEAAAAAAAAAAAAAAAAAAAAAgAAAAAAACAAAAAwAAABQAAwABAAAAFAAEACgAAAAGAAQAAQACACDmAf//AAAAIOYA////4RoCAAEAAAAAAAAAAQAB//8ADwABAAAAAAAAAAAAAgAANzkBAAAAAAIABwC+Ai8C+QAaADUAAAEUBwEGIyIvASY1ND8BJyY1ND8BNjMyFwEWFTMUBwEGIyIvASY1ND8BJyY1ND8BNjMyFwEWFQFUBv72BgcIBR0GBuHhBgYdBQgHBgEKBtsF/vUFCAcGHAYG4OAGBhwGBwgFAQsFAdsHBv72BgYdBQgHBuDhBgcIBR0GBv72BggHBv72BgYdBQgHBuDhBgcIBR0GBv72BggAAAIALAD1AmYDHQAaADUAAAEUBwEGIyInASY1ND8BNjMyHwE3NjMyHwEWFTUUBwEGIyInASY1ND8BNjMyHwE3NjMyHwEWFQJmBf71BQgHBv72BgYcBgcIBuDhBQgHBh0FBf71BQgHBv72BgYcBgcIBuDhBQgHBh0FAhIHBv72BgYBCgYHCAUdBgbh4QYGHQUI3AgF/vUFBQELBQgHBhwGBuDgBgYcBgcAAAEAAAABAADFBlcuXw889QALBAAAAAAAzrVBZAAAAADOtUFkAAAAAAJmAx0AAAAIAAIAAAAAAAAAAQAAA8D/wAAABAAAAAAaAmYAAQAAAAAAAAAAAAAAAAAAAAQAAAAAAgAAAAJJAAcCkgAsAAAAAAAKAF4AsgAAAAEAAAAEADYAAgAAAAAAAgAAAAAAAAAAAAAAAAAAAAAAAAAOAK4AAQAAAAAAAQASAAAAAQAAAAAAAgAOAFUAAQAAAAAAAwASACgAAQAAAAAABAASAGMAAQAAAAAABQAWABIAAQAAAAAABgAJADoAAQAAAAAACgAoAHUAAwABBAkAAQASAAAAAwABBAkAAgAOAFUAAwABBAkAAwASACgAAwABBAkABAASAGMAAwABBAkABQAWABIAAwABBAkABgASAEMAAwABBAkACgAoAHUAZQBjAGYALQBpAGMAbwBuAHMAVgBlAHIAcwBpAG8AbgAgADAALgAwAGUAYwBmAC0AaQBjAG8AbgBzZWNmLWljb25zAGUAYwBmAC0AaQBjAG8AbgBzAFIAZQBnAHUAbABhAHIAZQBjAGYALQBpAGMAbwBuAHMARwBlAG4AZQByAGEAdABlAGQAIABiAHkAIABJAGMAbwBNAG8AbwBuAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA) format("truetype"),
					 url(data:application/font-woff;charset=utf-8;base64,d09GRgABAAAAAAUUAAsAAAAABMgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABPUy8yAAABCAAAAGAAAABgDq/zK2NtYXAAAAFoAAAAPAAAADzL8hqdZ2FzcAAAAaQAAAAIAAAACAAAABBnbHlmAAABrAAAAWQAAAFkkW7qBWhlYWQAAAMQAAAANgAAADb+7sbiaGhlYQAAA0gAAAAkAAAAJAYoA99obXR4AAADbAAAABAAAAAQBtsAM2xvY2EAAAN8AAAACgAAAAoAvABebWF4cAAAA4gAAAAgAAAAIAAHADhuYW1lAAADqAAAAUsAAAFLQ88d5HBvc3QAAAT0AAAAIAAAACAAAwAAAAMEAAGQAAUAAAKZAswAAACPApkCzAAAAesAMwEJAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAQAAg5gEDwP/A/8ADwABAAAAAAAAAAAAAAAAAAAAAIAAAAAAAAgAAAAMAAAAUAAMAAQAAABQABAAoAAAABgAEAAEAAgAg5gH//wAAACDmAP///+EaAgABAAAAAAAAAAEAAf//AA8AAQAAAAAAAAAAAAIAADc5AQAAAAACAAcAvgIvAvkAGgA1AAABFAcBBiMiLwEmNTQ/AScmNTQ/ATYzMhcBFhUzFAcBBiMiLwEmNTQ/AScmNTQ/ATYzMhcBFhUBVAb+9gYHCAUdBgbh4QYGHQUIBwYBCgbbBf71BQgHBhwGBuDgBgYcBgcIBQELBQHbBwb+9gYGHQUIBwbg4QYHCAUdBgb+9gYIBwb+9gYGHQUIBwbg4QYHCAUdBgb+9gYIAAACACwA9QJmAx0AGgA1AAABFAcBBiMiJwEmNTQ/ATYzMh8BNzYzMh8BFhU1FAcBBiMiJwEmNTQ/ATYzMh8BNzYzMh8BFhUCZgX+9QUIBwb+9gYGHAYHCAbg4QUIBwYdBQX+9QUIBwb+9gYGHAYHCAbg4QUIBwYdBQISBwb+9gYGAQoGBwgFHQYG4eEGBh0FCNwIBf71BQUBCwUIBwYcBgbg4AYGHAYHAAABAAAAAQAAxQZXLl8PPPUACwQAAAAAAM61QWQAAAAAzrVBZAAAAAACZgMdAAAACAACAAAAAAAAAAEAAAPA/8AAAAQAAAAAGgJmAAEAAAAAAAAAAAAAAAAAAAAEAAAAAAIAAAACSQAHApIALAAAAAAACgBeALIAAAABAAAABAA2AAIAAAAAAAIAAAAAAAAAAAAAAAAAAAAAAAAADgCuAAEAAAAAAAEAEgAAAAEAAAAAAAIADgBVAAEAAAAAAAMAEgAoAAEAAAAAAAQAEgBjAAEAAAAAAAUAFgASAAEAAAAAAAYACQA6AAEAAAAAAAoAKAB1AAMAAQQJAAEAEgAAAAMAAQQJAAIADgBVAAMAAQQJAAMAEgAoAAMAAQQJAAQAEgBjAAMAAQQJAAUAFgASAAMAAQQJAAYAEgBDAAMAAQQJAAoAKAB1AGUAYwBmAC0AaQBjAG8AbgBzAFYAZQByAHMAaQBvAG4AIAAwAC4AMABlAGMAZgAtAGkAYwBvAG4Ac2VjZi1pY29ucwBlAGMAZgAtAGkAYwBvAG4AcwBSAGUAZwB1AGwAYQByAGUAYwBmAC0AaQBjAG8AbgBzAEcAZQBuAGUAcgBhAHQAZQBkACAAYgB5ACAASQBjAG8ATQBvAG8AbgAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA==) format("woff");
				font-weight: normal;
				font-style: normal;
			}

			[class^="ecf-icon-"], [class*=" ecf-icon-"] {
				font-family: "ecf-icons";
				speak: none;
				font-style: normal;
				font-weight: normal;
				font-variant: normal;
				text-transform: none;
				line-height: 1;

				/* Better Font Rendering =========== */
				-webkit-font-smoothing: antialiased;
				-moz-osx-font-smoothing: grayscale;
			}
			.videoWrapper {
				position: relative;
				padding-bottom: 56.25%; /* 16:9 */
				padding-top: 25px;
				height: 0;
			}
			.videoWrapper iframe {
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
			}
		</style>';		
}
add_action('wp_head','expand_collapse_functionality_everywhere');		

// Include Javascript to Create button and print necessary code into post editor
function expandCollapseFunk_button() {
    add_filter( "mce_external_plugins", "expandCollapseFunk_add_buttons" );
    add_filter( 'mce_buttons', 'expandCollapseFunk_register_buttons' );
}
add_action( 'init', 'expandCollapseFunk_button' );

function expandCollapseFunk_add_buttons( $plugin_array ) {
    $plugin_array['expandCollapseFunk'] = plugin_dir_url(__FILE__) . 'expand-collapse-funk.js';
    return $plugin_array;
}

function expandCollapseFunk_register_buttons( $buttons ) {
    array_push( $buttons, 'expandCollapseFunk' );
    return $buttons;
}

// Change Insert Into Post -> Use This Image
add_filter("esc_attr", "myfunction", 10, 2);
function myfunction($safe_text, $text) {
    return str_replace(__('Insert into Post'), __('Use this image'), $text);
}

?>
