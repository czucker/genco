<?php
/*
 * Plugin Name: GMap Widget
 * Plugin URI: http://www.hb-themes.com
 * Description: A widget that displays Google Map.
 * Version: 1.0
 * Author: HB-Themes
 * Author URI: http://www.hb-themes.com
 */

/*
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'hb_twitter_widgets' );

/*
 * Register widget.
 */
function hb_twitter_widgets() {
	register_widget( 'HB_Twitter_Widget' );
}

class hb_twitter_widget extends WP_Widget {

	function HB_Twitter_Widget() {
		$widget_ops = array( 'classname' => 'widget_twitter', 'description' => 'A widget that displays your latest tweets.' );
		$this->WP_Widget( 'twitter', '[HB-Themes] Twitter Feed', $widget_ops );

		/*if ( is_active_widget( false, false, $this->id_base ) ) {
			add_action( 'wp_print_scripts', array( &$this, 'add_tweet_script' ) );
		}*/

	}

	/*function add_tweet_script() {
		wp_enqueue_script( 'jquery-tweet' );
	}*/

	function widget( $args, $instance ) {
		extract( $args );
		$title = $instance['title'];
		$username = $instance['username'];
		$skin = $instance['skin'];
		$count = isset( $instance['count'] ) ? (int)$instance['count'] : 1;
		$consumer_key = hb_options('hb_twitter_consumer_key');
		$consumer_secret = hb_options('hb_twitter_consumer_secret');
		$access_token = hb_options('hb_twitter_access_token');
		$access_token_secret = hb_options('hb_twitter_access_token_secret');

		if ( $count < 1 || !$count ) {
			$count = 1;
		}
		if ( $count > 30 ) {
			$count = 30;
		}

if($consumer_key && $consumer_secret && $access_token && $access_token_secret) {
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;

		$transName = 'hbthemes_tweets_'.$args['widget_id'];
		$cacheTime = 10;
		delete_transient($transName);
		if(false === ($twitterData = get_transient($transName))) {
		     // require the twitter auth class
		     @require_once 'twitteroauth/twitteroauth.php';
		     $twitterConnection = new TwitterOAuth(
							$consumer_key,	// Consumer Key
							$consumer_secret,   	// Consumer secret
							$access_token,       // Access token
							$access_token_secret    	// Access token secret
							);
		    $twitterData = $twitterConnection->get(
							  'statuses/user_timeline',
							  array(
							    'screen_name'     => $username,
							    'count'           => $count,
							    'exclude_replies' => false
							  )
							);
		     if($twitterConnection->http_code != 200)
		     {
		          $twitterData = get_transient($transName);
		     }
		     set_transient($transName, $twitterData, 30 * $cacheTime);
		};
		$twitter = get_transient($transName);
		if($twitter && is_array($twitter)) {
		?>

					<div id="tweets_<?php echo $args['widget_id']; ?>">
						<ul class="hb-tweet-list <?php echo $skin; ?>">
							<?php foreach($twitter as $tweet): ?>
							<li>
								<span class="tweet-text">
								<?php
								$latestTweet = $tweet->text;
								$latestTweet = preg_replace('/http:\/\/([a-z0-9_\.\-\+\&\!\#\~\/\,]+)/i', '&nbsp;<a href="http://$1" target="_blank">http://$1</a>&nbsp;', $latestTweet);
								$latestTweet = preg_replace('/@([a-z0-9_]+)/i', '&nbsp;<a href="http://twitter.com/$1" target="_blank">@$1</a>&nbsp;', $latestTweet);
								echo $latestTweet;
								?>
								</span>
								<?php
								$twitterTime = strtotime($tweet->created_at);
								$timeAgo = hb_time_ago($twitterTime);
								?>
							</li>
							<span class="tweet-time"><a href="http://twitter.com/<?php echo $tweet->user->screen_name; ?>/statuses/<?php echo $tweet->id_str; ?>"><i class="hb-moon-twitter"></i><?php echo $timeAgo; ?></a></span>
							<?php endforeach; ?>
						</ul>
					</div>

					<p><?php _e('Follow ', 'hbthemes'); ?><a href="http://twitter.com/<?php echo $tweet->user->screen_name; ?>" target="_blank">@<?php echo $tweet->user->screen_name; ?></a></p>
		<?php 
		echo $after_widget;
	}} else {
		echo '<p>'. __('[Twitter Widget Error] You need to authenticate your Twitter App first. Go to Highend Options > Social Links. <a href="http://documentation.hb-themes.com/highend/#twitter">Read the documentation</a> to find out more.', 'hbthemes') .'</p>';
	}
			

	}
	

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['skin'] = $new_instance['skin'];
		$instance['count'] = (int) $new_instance['count'];

		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$username = isset( $instance['username'] ) ? esc_attr( $instance['username'] ) : '';
		$skin = isset( $instance['skin'] ) ? esc_attr( $instance['skin'] ) : 'light';
		$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 1;
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'username' ); ?>">Username:</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" type="text" value="<?php echo $username; ?>" /></p>
		<p>
			<label for="<?php echo $this->get_field_id( 'skin' ); ?>">Skin:</label>
			<select name="<?php echo $this->get_field_name( 'skin' ); ?>" id="<?php echo $this->get_field_id( 'skin' ); ?>" class="widefat">
				<option value="dark"<?php selected( $skin, 'dark');?>>Dark</option>
				<option value="light"<?php selected( $skin, 'light');?>>Light</option>
			</select>
		</p>
		<p><label for="<?php echo $this->get_field_id( 'count' ); ?>">Count</label>
		<input id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo $count; ?>" size="3" /></p>
		<small>You have to fill in your Twitter Info in Highend Options > Social Links > Twitter API Settings, in order to authenticate.</small>
<?php

	}
}
