<?php
/**
 * @package WordPress
 * @subpackage Highend
 */

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','hbthemes'); ?></p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
  <div class="comments-section aligncenter" id="comments">
    <h4 class="semi-bold"><?php comments_number(__('No Comments','hbthemes'), __('1 Comment', 'hbthemes'), __('% Comments', 'hbthemes') );?></h4>
    <h5 class="leave-your-reply"><?php _e('Leave your reply.', 'hbthemes'); ?></h5>
  </div>


	<ul class="comments-list">
		<?php wp_list_comments('type=comment&callback=hb_format_comment'); ?>
	</ul>

 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<!--<p class="nocomments">Comments are closed.</p>-->

	<?php endif; ?>

  

<?php endif; ?>

    <?php 

    $comments_pagination = paginate_comments_links( array(
        'prev_text' => '<i class="icon-angle-left"></i>', 
        'next_text' => '<i class="icon-angle-right"></i>',
        'echo' => false
    )); 

    if ( $comments_pagination ) {?>
      <div class="pagination">
        <?php echo $comments_pagination; ?>
      </div>
    <?php }
    ?>

<?php if ( comments_open() ) : 

$required_text = null;
$additional_text = hb_options('hb_comment_form_text');

if ( $additional_text != '' ){
  $additional_text = '<h5 class="aligncenter">' . $additional_text . '</h5>';
}

$args = array(
  'id_form'           => 'commentform',
  'id_submit'         => 'submit',
  'title_reply'       => __( 'Leave a Reply', 'hbthemes' ) . $additional_text,
  'title_reply_to'    => __( 'Leave a Reply to %s', 'hbthemes' ) . $additional_text,
  'cancel_reply_link' => __( 'Cancel Reply', 'hbthemes' ),
  'label_submit'      => __( 'Submit Comment', 'hbthemes' ),

  'comment_field' =>  '<p><textarea class="required requiredField" name="comment" id="comment" cols="55" rows="10" tabindex="67"></textarea></p>',

  'must_log_in' => '<p class="must-log-in">' .
    sprintf(
      __( 'You must be <a href="%s">logged in</a> to post a comment.', 'hbthemes' ),
      wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
    ) . '</p>',

  'logged_in_as' => '<p class="logged-in-as">' .
    sprintf(
    __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'hbthemes' ),
      admin_url( 'profile.php' ),
      $user_identity,
      wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
    ) . '</p>',

  'comment_notes_before' => '',

  'comment_notes_after' => '<div class="clearfix"></div>',

  'fields' => apply_filters( 'comment_form_default_fields', array(

    'author' =>
      '<div class="form-col"> 
          <input class="required requiredField" type="text" name="author" id="author" placeholder="' . __('Name (Required)' , 'hbthemes') . '" size="22" tabindex="64" value="' . esc_attr( $commenter['comment_author'] ) .'"/>
        </div>',

    'email' =>
      '<div class="form-col"> 
        <input class="required requiredField email" type="text" name="email" id="email" placeholder="' . __('Email (Required)' , 'hbthemes') . '" size="22" tabindex="65" value="' . esc_attr(  $commenter['comment_author_email'] ) . '"/>
      </div>',

    'url' =>
      '<div class="form-col clear-r-padding"> 
            <input type="text" name="url" id="url" placeholder="' . __('Website','hbthemes') . '" size="22" tabindex="66" value="' . esc_attr( $commenter['comment_author_url'] ) . '" />
          </div>'
    )
  ),
);

comment_form($args);


endif; // if you delete this the sky will fall on your head 

function hb_format_comment($comment, $args, $depth) {
  $isByAuthor = false;

    if($comment->comment_author_email == get_the_author_meta('email')) {
        $isByAuthor = true;
    }

    //$GLOBALS['comment'] = $comment; 
  ?>
  <li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
     
      <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
      
      
      <div class="comment-author vcard">

        <span class="rounded-element float-left">
          <?php echo get_avatar($comment,$size='76'); ?>
        </span>

        <cite class="fn"><?php comment_author_link(); ?></cite>

        <div class="reply">
          <?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment' , 'depth' => $depth, 'before' => '<span class="sep">&middot;</span> ' , 'max_depth' => $args['max_depth'])), get_comment_ID()) ?>
        </div>
        <br/>
        <?php if($isByAuthor) { ?><span class="author-tag"><?php _e('Author','hbthemes') ?></span><?php } ?>
      </div>

      <div class="comment-meta commentmetadata">
        <a href="<?php comment_link(); ?>">
          <time itemprop="commentTime" itemscope="itemscope" datetime="<?php comment_time('c'); ?>"><?php comment_date('F j, Y' , get_comment_ID()); _e(' at ', 'hbthemes' ); comment_time('g:i A'); ?></time>
        </a>
      </div>

      <div class="comment-inner">      
      <?php if ($comment->comment_approved == '0') : ?>
      <em class="moderation"><?php _e('Your comment is awaiting moderation.', 'hbthemes') ?></em>
      <br />
      <?php endif; ?>
  
      <?php comment_text(); ?>
        
    </div>  
    </div>    

<?php } ?>