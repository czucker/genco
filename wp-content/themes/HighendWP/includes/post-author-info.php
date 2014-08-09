<?php
$author_id = get_query_var( 'author' );
if(empty($author_id)) $author_id = get_the_author_meta('ID');
$gravatar = get_avatar( get_the_author_meta('email', $author_id), '75' );
$description = get_the_author_meta('description', $author_id);
$name = get_the_author_meta('display_name', $author_id);
$posts_url = get_author_posts_url($author_id);
?>
<section class="author-box clearfix" itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person">
	<span class="author-meta blog-meta">
		<span class="rounded-element">
			<?php echo $gravatar; ?>
		</span>
	</span>

	<div class="author-description">
		<h3 class="semi-bold author-title"><?php _e('About ','hbthemes'); ?> <span class="author-box-name" itemprop="name"><?php echo $name; ?></span></h3>
		        		
		<div class="author_description_text" itemprop="description">

			<?php if ( $description ) { 
				echo '<p>' . $description . '</p>';
			} else { ?>
				<p><?php _e("This author hasn't written their bio yet.","hbthemes"); ?><br><span class="author-box-name" itemprop="name"><?php echo $name; ?></span><?php _e(' has contributed ', 'hbthemes' ); echo count_user_posts( $author_id);  _e(' entries to our website, so far.', 'hbthemes'); ?>
					<?php if( !is_archive() ) { ?>
					<a href="<?php echo $posts_url; ?>" class="simple-read-more"><?php _e('View entries by ' , 'hbthemes'); ?><span class="author-box-name" itemprop="name"><?php echo $name; ?>.</span></a>
					<?php } ?>
				</p>
			<?php } ?>

			<?php $user_soc = hb_get_user_socials ( $author_id ); ?>
			<ul class="social-icons dark clearfix">
				<?php foreach ( $user_soc as $soc => $soc_details ) { 
					if ( $soc_details['soc_link'] != '' ) { ?>
						<li class="<?php echo $soc; ?>"><a href="<?php echo $soc_details['soc_link']; ?>" class="<?php echo $soc; ?>" title="<?php echo $soc_details['soc_name']; ?>" target="_blank"><i class="hb-moon-<?php echo $soc; ?>"></i><i class="hb-moon-<?php echo $soc; ?>"></i></a></li>
					<?php }	
				} ?>
			</ul>

		</div>

	</div>
</section>
<?php if ( !is_archive() ) { ?>
<div class="hb-separator-extra"></div>
<?php } ?>