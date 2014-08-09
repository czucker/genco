<?php 
if ( function_exists('hb_pagination_ajax') ) return;
function hb_pagination_ajax($loopFile) { ?>
<a class="load-more-posts" href="#">
	<span class="load-more-text" data-more="<?php _e('Load More Posts', 'hbthemes'); ?>" data-less="<?php _e('No More Posts', 'hbthemes'); ?>"><?php _e('Load More Posts','hbthemes'); ?></span>
	<span class="hb-spin non-visible"><i class="hb-moon-spinner-5"></i></span>
</a>

<script type="text/javascript">  
	<?php $paged = (get_query_var('paged') ) ? get_query_var('paged') + 1 : 2; ?>
	var pagination_count = <?php echo $paged; ?>;
    jQuery(".load-more-posts").on('click', function(e){  
    	e.preventDefault();
    	if (!jQuery(this).hasClass('inactive')){
	    	jQuery(".load-more-posts > .load-more-text").hide(0);
	    	jQuery(".load-more-posts > .hb-spin").toggleClass('non-visible');
		    loadArticle(pagination_count);  
		    pagination_count++; 
		}
  	});  

	function loadArticle(pageNumber) {
		var $container = jQuery(".masonry-holder");
		var $col_count = "-1";

		if ( jQuery('.hb-blog-grid').length ) {
			$col_count = jQuery('#hb-blog-posts').attr("data-column-size");
			jQuery.ajax({  
			url: "<?php echo site_url(); ?>/wp-admin/admin-ajax.php",  
			type:'POST',  
			data: "action=infinite_scroll&page_no="+ pageNumber + "&loop_file=<?php echo $loopFile; ?>&col_count=" + $col_count ,   
			success: function(html){

				if (html){
					var $append_text_element = jQuery('.load-more-posts > .load-more-text');
					var $append_text = $append_text_element.attr('data-more');
					
					$append_text_element.html($append_text);

					jQuery(".load-more-posts > .load-more-text").show(0);
	    			jQuery(".load-more-posts > .hb-spin").addClass('non-visible');
					//jQuery("#hb-blog-posts").append(html);    // This will be the div where our content will be loaded
					var $to_insert = jQuery(html);
					$container.append( $to_insert ).isotope( 'appended', $to_insert );

					$container.imagesLoaded( function(){
						$container.isotope();
					});

					setTimeout(function() {
      					$container.isotope();
					}, 1500);

					setTimeout(function() {
      					$container.isotope();
					}, 3000);

					setTimeout(function() {
      					$container.isotope();
					}, 6000);

				} else {
					var $append_text_element = jQuery('.load-more-posts > .load-more-text');
					var $append_text = $append_text_element.attr('data-less');
					
					$append_text_element.html($append_text);
					$append_text_element.parent().addClass('inactive');

					jQuery(".load-more-posts > .load-more-text").show(0);
	    			jQuery(".load-more-posts > .hb-spin").addClass('non-visible');
				}

			}
		});
		}
		
		return false;
	}
</script>
<?php } ?>