<?php
add_action('emodal_admin_sidebar', 'emodal_admin_sidebar_share', 10);
function emodal_admin_sidebar_share()
{?>
	<h3 class="loveit-shareit" style="text-align:center">Love It? <span>Share It!</span></h3>
	<ul class="share-buttons">
		<li><div class="fb-like" data-href="http://easy-modal.com" data-width="100" data-layout="box_count" data-action="like" data-show-faces="false" data-send="true"></div></li>
		<li><a href="https://twitter.com/intent/tweet" class="twitter-share-button" data-count="vertical" data-url="http://easy-modal.com" data-via="wizard_is" data-related="wizard_is">Tweet</a></li>
		<li><div class="g-plusone" data-href="http://easy-modal.com" data-size="tall"></div></li>
	</ul>
	<br class="clear" />
	<br class="clear" />
	<div style="text-align:center">
		<a class="button rounded" href="http://wordpress.org/support/view/plugin-reviews/easy-modal#postform">Rate us on WordPress!</a>
	</div><?php
}

add_action('emodal_admin_sidebar', 'emodal_admin_sidebar_documentation', 20);
function emodal_admin_sidebar_documentation()
{?>
	<a href="http://easy-modal.com/documentation?utm_source=emcore&utm_medium=dashboard+link&utm_campaign=documentation" target="_blank">
		<img src="<?php echo EMCORE_URL;?>/assets/images/admin/sidebar-documentation.jpg" alt="Easy Modal Documentation" style="max-width:100%;" />
	</a><?php
}

add_action('emodal_admin_sidebar', 'emodal_admin_sidebar_support', 30);
function emodal_admin_sidebar_support()
{?>
	<hr/>
	<p class="emodal-feature-list" style="text-align:center">
		<a href="http://easy-modal.com/support/pricing?utm_source=emcore&utm_medium=dashboard+link&utm_campaign=get+support+now" target="_blank"><img src="<?php echo EMCORE_URL;?>/assets/images/admin/sidebar-priority-support.png" alt="Priority Support"/></a><br/>
		<a href="http://easy-modal.com/support?utm_source=emcore&utm_medium=dashboard+link&utm_campaign=visit+support" target="_blank">Visit the Support Page</a>
	</p><?php
}

//add_action('emodal_admin_sidebar', 'emodal_admin_sidebar_upgrade', 30);
function emodal_admin_sidebar_upgrade()
{?>
	<hr/>
	<p class="emodal-feature-list" style="text-align:center">
		More &amp; Extended Features<br/>
		Unlimited Themes <span>&middot;</span> Exclusive Add Ons<br/>
		Exclusive Themes <span>&middot;</span> Priority Support<br/>
		<img src="<?php echo EMCORE_URL;?>/assets/images/admin/sidebar-logo.png" alt="Easy Modal Pro" /><br/>
		<a href="https://easy-modal.com/pricing" class="btn" target="_blank">Upgrade</a><br/>
		<a href="http://easy-modal.com" target="_blank">See what you’re missing out on</a>
	</p><?php
}

add_action('emodal_admin_sidebar', 'emodal_admin_sidebar_follow', 50);
function emodal_admin_sidebar_follow()
{?>
	<div class="follow-box">
		<a href="https://twitter.com/EasyModal" class="twitter-follow-button" data-show-count="true" data-show-screen-name="true" data-size="medium" data-lang="en">Follow Us</a><br />
		<div class="fb-like" data-href="https://facebook.com/EasyModal" data-send="false" data-width="100px" data-show-faces="false"></div>
	</div><?php
}