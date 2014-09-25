<?php
/*
Addon Name: PayPal Single Payments Gateway
Author: Incsub
Author URI: http://premium.wpmudev.org
Gateway ID: paypalsolo
*/

class paypalsolo extends Membership_Gateway {

	var $gateway = 'paypalsolo';
	var $title = 'PayPal Express - with Single Payments';
	var $issingle = true;

	public function __construct() {
		parent::__construct();

		add_action( 'M_gateways_settings_' . $this->gateway, array( &$this, 'mysettings' ) );

		// If I want to override the transactions output - then I can use this action
		//add_action('M_gateways_transactions_' . $this->gateway, array(&$this, 'mytransactions'));

		if ( $this->is_active() ) {
			// Subscription form gateway
			add_action( 'membership_purchase_button', array( &$this, 'display_subscribe_button' ), 1, 3 );

			// Payment return
			add_action( 'membership_handle_payment_return_' . $this->gateway, array( &$this, 'handle_paypal_return' ) );
			add_filter( 'membership_subscription_form_subscription_process', array( &$this, 'signup_free_subscription' ), 10, 2 );
		}
	}

	function mysettings() {

		global $M_options;

		?>
		<h3><?php _e('IPN Setup Instructions', 'membership'); ?></h3>
		<p><?php printf(__('In order for Membership to function correctlty you must setup an IPN listening URL with PayPal. Failure to do so will prevent your site from being notified when a member cancels their subscription.<br />Your IPN listening URL is: <strong>%s</strong><br /><a target="_blank" href="https://developer.paypal.com/docs/classic/ipn/integration-guide/IPNSetup/">Instructions &raquo;</a></p></p>', 'membership'), trailingslashit(home_url('paymentreturn/' . $this->gateway))); ?></p>
		<table class="form-table">
		<tbody>
		  <tr valign="top">
		  <th scope="row"><?php _e('PayPal Email', 'membership') ?></th>
		  <td><input type="text" name="paypal_email" value="<?php esc_attr_e(get_option( $this->gateway . "_paypal_email" )); ?>" />
		  <br />
		  </td>
		  </tr>
		  <tr valign="top">
		  <th scope="row"><?php _e('PayPal Site', 'membership') ?></th>
		  <td><select name="paypal_site">
		  <?php
		      $paypal_site = get_option( $this->gateway . "_paypal_site" );
		      $sel_locale = empty($paypal_site) ? 'US' : $paypal_site;
			$locales = array(
					'AX' => __('ÃLAND ISLANDS', 'membership'),
					'AL' => __('ALBANIA', 'membership'),
					'DZ' => __('ALGERIA', 'membership'),
					'AS' => __('AMERICAN SAMOA', 'membership'),
					'AD' => __('ANDORRA', 'membership'),
					'AI' => __('ANGUILLA', 'membership'),
					'AQ' => __('ANTARCTICA', 'membership'),
					'AG' => __('ANTIGUA AND BARBUDA', 'membership'),
					'AR' => __('ARGENTINA', 'membership'),
					'AM' => __('ARMENIA', 'membership'),
					'AW' => __('ARUBA', 'membership'),
					'AU' => __('AUSTRALIA', 'membership'),
					'AT' => __('AUSTRIA', 'membership'),
					'AZ' => __('AZERBAIJAN', 'membership'),
					'BS' => __('BAHAMAS', 'membership'),
					'BH' => __('BAHRAIN', 'membership'),
					'BD' => __('BANGLADESH', 'membership'),
					'BB' => __('BARBADOS', 'membership'),
					'BE' => __('BELGIUM', 'membership'),
					'BZ' => __('BELIZE', 'membership'),
					'BJ' => __('BENIN', 'membership'),
					'BM' => __('BERMUDA', 'membership'),
					'BT' => __('BHUTAN', 'membership'),
					'BA' => __('BOSNIA-HERZEGOVINA', 'membership'),
					'BW' => __('BOTSWANA', 'membership'),
					'BV' => __('BOUVET ISLAND', 'membership'),
					'BR' => __('BRAZIL', 'membership'),
					'IO' => __('BRITISH INDIAN OCEAN TERRITORY', 'membership'),
					'BN' => __('BRUNEI DARUSSALAM', 'membership'),
					'BG' => __('BULGARIA', 'membership'),
					'BF' => __('BURKINA FASO', 'membership'),
					'CA' => __('CANADA', 'membership'),
					'CV' => __('CAPE VERDE', 'membership'),
					'KY' => __('CAYMAN ISLANDS', 'membership'),
					'CF' => __('CENTRAL AFRICAN REPUBLIC', 'membership'),
					'CL' => __('CHILE', 'membership'),
					'CN' => __('CHINA', 'membership'),
					'CX' => __('CHRISTMAS ISLAND', 'membership'),
					'CC' => __('COCOS (KEELING) ISLANDS', 'membership'),
					'CO' => __('COLOMBIA', 'membership'),
					'CK' => __('COOK ISLANDS', 'membership'),
					'CR' => __('COSTA RICA', 'membership'),
					'CY' => __('CYPRUS', 'membership'),
					'CZ' => __('CZECH REPUBLIC', 'membership'),
					'DK' => __('DENMARK', 'membership'),
					'DJ' => __('DJIBOUTI', 'membership'),
					'DM' => __('DOMINICA', 'membership'),
					'DO' => __('DOMINICAN REPUBLIC', 'membership'),
					'EC' => __('ECUADOR', 'membership'),
					'EG' => __('EGYPT', 'membership'),
					'SV' => __('EL SALVADOR', 'membership'),
					'EE' => __('ESTONIA', 'membership'),
					'FK' => __('FALKLAND ISLANDS (MALVINAS)', 'membership'),
					'FO' => __('FAROE ISLANDS', 'membership'),
					'FJ' => __('FIJI', 'membership'),
					'FI' => __('FINLAND', 'membership'),
					'FR' => __('FRANCE', 'membership'),
					'GF' => __('FRENCH GUIANA', 'membership'),
					'PF' => __('FRENCH POLYNESIA', 'membership'),
					'TF' => __('FRENCH SOUTHERN TERRITORIES', 'membership'),
					'GA' => __('GABON', 'membership'),
					'GM' => __('GAMBIA', 'membership'),
					'GE' => __('GEORGIA', 'membership'),
					'DE' => __('GERMANY', 'membership'),
					'GH' => __('GHANA', 'membership'),
					'GI' => __('GIBRALTAR', 'membership'),
					'GR' => __('GREECE', 'membership'),
					'GL' => __('GREENLAND', 'membership'),
					'GD' => __('GRENADA', 'membership'),
					'GP' => __('GUADELOUPE', 'membership'),
					'GU' => __('GUAM', 'membership'),
					'GG' => __('GUERNSEY', 'membership'),
					'GY' => __('GUYANA', 'membership'),
					'HM' => __('HEARD ISLAND AND MCDONALD ISLANDS', 'membership'),
					'VA' => __('HOLY SEE (VATICAN CITY STATE)', 'membership'),
					'HN' => __('HONDURAS', 'membership'),
					'HK' => __('HONG KONG', 'membership'),
					'HU' => __('HUNGARY', 'membership'),
					'IS' => __('ICELAND', 'membership'),
					'IN' => __('INDIA', 'membership'),
					'ID' => __('INDONESIA', 'membership'),
					'IE' => __('IRELAND', 'membership'),
					'IM' => __('ISLE OF MAN', 'membership'),
					'IL' => __('ISRAEL', 'membership'),
					'IT' => __('ITALY', 'membership'),
					'JM' => __('JAMAICA', 'membership'),
					'JP' => __('JAPAN', 'membership'),
					'JE' => __('JERSEY', 'membership'),
					'JO' => __('JORDAN', 'membership'),
					'KZ' => __('KAZAKHSTAN', 'membership'),
					'KI' => __('KIRIBATI', 'membership'),
					'KR' => __('KOREA, REPUBLIC OF', 'membership'),
					'KW' => __('KUWAIT', 'membership'),
					'KG' => __('KYRGYZSTAN', 'membership'),
					'LV' => __('LATVIA', 'membership'),
					'LS' => __('LESOTHO', 'membership'),
					'LI' => __('LIECHTENSTEIN', 'membership'),
					'LT' => __('LITHUANIA', 'membership'),
					'LU' => __('LUXEMBOURG', 'membership'),
					'MO' => __('MACAO', 'membership'),
					'MK' => __('MACEDONIA', 'membership'),
					'MG' => __('MADAGASCAR', 'membership'),
					'MW' => __('MALAWI', 'membership'),
					'MY' => __('MALAYSIA', 'membership'),
					'MT' => __('MALTA', 'membership'),
					'MH' => __('MARSHALL ISLANDS', 'membership'),
					'MQ' => __('MARTINIQUE', 'membership'),
					'MR' => __('MAURITANIA', 'membership'),
					'MU' => __('MAURITIUS', 'membership'),
					'YT' => __('MAYOTTE', 'membership'),
					'MX' => __('MEXICO', 'membership'),
					'FM' => __('MICRONESIA, FEDERATED STATES OF', 'membership'),
					'MD' => __('MOLDOVA, REPUBLIC OF', 'membership'),
					'MC' => __('MONACO', 'membership'),
					'MN' => __('MONGOLIA', 'membership'),
					'ME' => __('MONTENEGRO', 'membership'),
					'MS' => __('MONTSERRAT', 'membership'),
					'MA' => __('MOROCCO', 'membership'),
					'MZ' => __('MOZAMBIQUE', 'membership'),
					'NA' => __('NAMIBIA', 'membership'),
					'NR' => __('NAURU', 'membership'),
					'NP' => __('NEPAL', 'membership'),
					'NL' => __('NETHERLANDS', 'membership'),
					'AN' => __('NETHERLANDS ANTILLES', 'membership'),
					'NC' => __('NEW CALEDONIA', 'membership'),
					'NZ' => __('NEW ZEALAND', 'membership'),
					'NI' => __('NICARAGUA', 'membership'),
					'NE' => __('NIGER', 'membership'),
					'NU' => __('NIUE', 'membership'),
					'NF' => __('NORFOLK ISLAND', 'membership'),
					'MP' => __('NORTHERN MARIANA ISLANDS', 'membership'),
					'NO' => __('NORWAY', 'membership'),
					'OM' => __('OMAN', 'membership'),
					'PW' => __('PALAU', 'membership'),
					'PS' => __('PALESTINE', 'membership'),
					'PA' => __('PANAMA', 'membership'),
					'PY' => __('PARAGUAY', 'membership'),
					'PE' => __('PERU', 'membership'),
					'PH' => __('PHILIPPINES', 'membership'),
					'PN' => __('PITCAIRN', 'membership'),
					'PL' => __('POLAND', 'membership'),
					'PT' => __('PORTUGAL', 'membership'),
					'PR' => __('PUERTO RICO', 'membership'),
					'QA' => __('QATAR', 'membership'),
					'RE' => __('REUNION', 'membership'),
					'RO' => __('ROMANIA', 'membership'),
					'RU' => __('RUSSIAN FEDERATION', 'membership'),
					'RW' => __('RWANDA', 'membership'),
					'SH' => __('SAINT HELENA', 'membership'),
					'KN' => __('SAINT KITTS AND NEVIS', 'membership'),
					'LC' => __('SAINT LUCIA', 'membership'),
					'PM' => __('SAINT PIERRE AND MIQUELON', 'membership'),
					'VC' => __('SAINT VINCENT AND THE GRENADINES', 'membership'),
					'WS' => __('SAMOA', 'membership'),
					'SM' => __('SAN MARINO', 'membership'),
					'ST' => __('SAO TOME AND PRINCIPE', 'membership'),
					'SA' => __('SAUDI ARABIA', 'membership'),
					'SN' => __('SENEGAL', 'membership'),
					'RS' => __('SERBIA', 'membership'),
					'SC' => __('SEYCHELLES', 'membership'),
					'SG' => __('SINGAPORE', 'membership'),
					'SK' => __('SLOVAKIA', 'membership'),
					'SI' => __('SLOVENIA', 'membership'),
					'SB' => __('SOLOMON ISLANDS', 'membership'),
					'ZA' => __('SOUTH AFRICA', 'membership'),
					'GS' => __('SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'membership'),
					'ES' => __('SPAIN', 'membership'),
					'SR' => __('SURINAME', 'membership'),
					'SJ' => __('SVALBARD AND JAN MAYEN', 'membership'),
					'SZ' => __('SWAZILAND', 'membership'),
					'SE' => __('SWEDEN', 'membership'),
					'CH' => __('SWITZERLAND', 'membership'),
					'TW' => __('TAIWAN, PROVINCE OF CHINA', 'membership'),
					'TZ' => __('TANZANIA, UNITED REPUBLIC OF', 'membership'),
					'TH' => __('THAILAND', 'membership'),
					'TL' => __('TIMOR-LESTE', 'membership'),
					'TG' => __('TOGO', 'membership'),
					'TK' => __('TOKELAU', 'membership'),
					'TO' => __('TONGA', 'membership'),
					'TT' => __('TRINIDAD AND TOBAGO', 'membership'),
					'TN' => __('TUNISIA', 'membership'),
					'TR' => __('TURKEY', 'membership'),
					'TM' => __('TURKMENISTAN', 'membership'),
					'TC' => __('TURKS AND CAICOS ISLANDS', 'membership'),
					'TV' => __('TUVALU', 'membership'),
					'UG' => __('UGANDA', 'membership'),
					'UA' => __('UKRAINE', 'membership'),
					'AE' => __('UNITED ARAB EMIRATES', 'membership'),
					'GB' => __('UNITED KINGDOM', 'membership'),
					'US' => __('UNITED STATES', 'membership'),
					'UM' => __('UNITED STATES MINOR OUTLYING ISLANDS', 'membership'),
					'UY' => __('URUGUAY', 'membership'),
					'UZ' => __('UZBEKISTAN', 'membership'),
					'VU' => __('VANUATU', 'membership'),
					'VE' => __('VENEZUELA', 'membership'),
					'VN' => __('VIET NAM', 'membership'),
					'VG' => __('VIRGIN ISLANDS, BRITISH', 'membership'),
					'VI' => __('VIRGIN ISLANDS, U.S.', 'membership'),
					'WF' => __('WALLIS AND FUTUNA', 'membership'),
					'EH' => __('WESTERN SAHARA', 'membership'),
					'ZM' => __('ZAMBIA', 'membership')
			);

		      foreach ($locales as $key => $value) {
					echo '<option value="' . esc_attr($key) . '"';
		 			if($key == $sel_locale) echo 'selected="selected"';
		 			echo '>' . esc_html($value) . '</option>' . "\n";
		      }
		  ?>
		  </select>
		  <br />
		  <?php //_e('Format: 00.00 - Ex: 1.25', 'supporter') ?></td>
		  </tr>
		  <tr valign="top">
		  <th scope="row"><?php _e('Paypal Currency', 'membership') ?></th>
		  <td><?php
			if(empty($M_options['paymentcurrency'])) {
				$M_options['paymentcurrency'] = 'USD';
			}
			echo esc_html($M_options['paymentcurrency']); ?></td>
		  </tr>
		  <tr valign="top">
		  <th scope="row"><?php _e('PayPal Mode', 'membership') ?></th>
		  <td><select name="paypal_status">
		  <option value="live" <?php if (get_option( $this->gateway . "_paypal_status" ) == 'live') echo 'selected="selected"'; ?>><?php _e('Live Site', 'membership') ?></option>
		  <option value="test" <?php if (get_option( $this->gateway . "_paypal_status" ) == 'test') echo 'selected="selected"'; ?>><?php _e('Test Mode (Sandbox)', 'membership') ?></option>
		  </select>
		  <br />
		  </td>
		  </tr>
		  <tr valign="top">
		  <th scope="row"><?php _e('Subscription button', 'membership') ?></th>
		  <?php
		  	$button = get_option( $this->gateway . "_paypal_button", 'https://www.paypal.com/en_US/i/btn/btn_subscribe_LG.gif' );
		  ?>
		  <td><input type="text" name="paypal_button" value="<?php esc_attr_e($button); ?>" style='width: 40em;' />
		  <br />
		  </td>
		  </tr>
		  <tr valign="top">
		  <th scope="row"><?php _e('Renew button', 'membership') ?></th>
		  <?php
		  	$button = get_option( $this->gateway . "_paypal_renew_button", 'http://www.paypal.com/en_US/i/btn/x-click-but23.gif' );
		  ?>
		  <td><input type="text" name="_paypal_renew_button" value="<?php esc_attr_e($button); ?>" style='width: 40em;' />
		  <br />
		  </td>
		  </tr>
		  <tr valign="top">
		  <th scope="row"><?php _e('Upgrade button', 'membership') ?></th>
		  <?php
		  	$button = get_option( $this->gateway . "_paypal_upgrade_button", 'https://www.paypal.com/en_US/i/btn/btn_subscribe_LG.gif' );
		  ?>
		  <td><input type="text" name="_paypal_upgrade_button" value="<?php esc_attr_e($button); ?>" style='width: 40em;' />
		  <br />
		  </td>
		  </tr>
		  <tr valign="top">
		  <th scope="row"><?php _e('Cancel button', 'membership') ?></th>
		  <?php
		  	$button = get_option( $this->gateway . "_paypal_cancel_button", 'https://www.paypal.com/en_US/i/btn/btn_unsubscribe_LG.gif' );
		  ?>
		  <td><input type="text" name="_paypal_cancel_button" value="<?php esc_attr_e($button); ?>" style='width: 40em;' />
		  <br />
		  </td>
		  </tr>

		</tbody>
		</table>
		<?php
	}

	function build_custom( $user_id, $sub_id, $amount, $sublevel = 0, $fromsub = 0 ) {
		global $M_options;

		$custom = time() . ':' . $user_id . ':' . $sub_id . ':';
		$key = md5( 'MEMBERSHIP' . apply_filters( 'membership_amount_' . $M_options['paymentcurrency'], $amount ) );

		if ( $fromsub === false ) {
			$fromsub = filter_input( INPUT_GET, 'from_subscription', FILTER_VALIDATE_INT );
		}

		$custom .= $key;
		$custom .= ":" . $sublevel . ":" . $fromsub;

		return $custom;
	}

	function single_button($pricing, $subscription, $user_id, $sublevel = 0, $fromsub = 0) {

		global $M_options;

		if(empty($M_options['paymentcurrency'])) {
			$M_options['paymentcurrency'] = 'USD';
		}

		$form = '';

		if (get_option( $this->gateway . "_paypal_status" ) == 'live') {
			$form .= '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">';
		} else {
			$form .= '<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">';
		}
		$form .= '<input type="hidden" name="charset" value="utf-8">';
		$form .= '<input type="hidden" name="business" value="' . esc_attr(get_option( $this->gateway . "_paypal_email" )) . '">';
		$form .= '<input type="hidden" name="cmd" value="_xclick">';
		// our Incsub BN code
		$form .= '<input type="hidden" name="bn" value="incsub_SP">';
		$form .= '<input type="hidden" name="item_number" value="' . $subscription->sub_id() . '">';
		$form .= '<input type="hidden" name="item_name" value="' . $subscription->sub_name() . '">';
		$form .= '<input type="hidden" name="amount" value="' . apply_filters('membership_amount_' . $M_options['paymentcurrency'], number_format($pricing[$sublevel -1]['amount'], 2, '.' , '')) . '">';
		$form .= '<input type="hidden" name="currency_code" value="' . $M_options['paymentcurrency'] .'">';
		$form .= '<input type="hidden" name="return" value="' . apply_filters( 'membership_return_url_' . $this->gateway, M_get_returnurl_permalink()) . '">';
		$form .= '<input type="hidden" name="cancel_return" value="' . apply_filters( 'membership_cancel_url_' . $this->gateway, M_get_subscription_permalink()) . '">';
		$form .= '<input type="hidden" name="custom" value="' . $this->build_custom($user_id, $subscription->id, number_format($pricing[$sublevel -1]['amount'], 2, '.' , ''), $sublevel, $fromsub) .'">';
		$form .= '<input type="hidden" name="lc" value="' . esc_attr(get_option( $this->gateway . "_paypal_site" )) . '">';
		$form .= '<input type="hidden" name="notify_url" value="' . apply_filters( 'membership_notify_url_' . $this->gateway, home_url('paymentreturn/' . esc_attr($this->gateway))) . '">';
		$form .= '<input type="hidden" name="no_note" value="1" />';
		$form .= '<input type="hidden" name="no_shipping" value="1" />';

		if($sublevel == 1) {
			$button = get_option( $this->gateway . "_paypal_button", 'https://www.paypal.com/en_US/i/btn/btn_subscribe_LG.gif' );
		} else {
			$button = get_option( $this->gateway . "_paypal_button", 'http://www.paypal.com/en_US/i/btn/x-click-but23.gif' );
		}

		$form .= '<input type="image" name="submit" border="0" src="' . $button . '" alt="PayPal - The safer, easier way to pay online">';
		$form .= '<img alt="" border="0" width="1" height="1" src="https://www.paypal.com/en_US/i/scr/pixel.gif" >';
		$form .= '</form>';

		return $form;

	}

	function signup_free_subscription($content, $error) {

		if(!isset($_POST['action']) || $_POST['action'] != 'validatepage2') {
			return $content;
		}

		if(isset($_POST['custom'])) {
			list($timestamp, $user_id, $sub_id, $key) = explode(':', $_POST['custom']);
		}

		// create_subscription
		$member = Membership_Plugin::factory()->get_member($user_id);
		if($member) {
			$member->create_subscription($sub_id, $this->gateway);
		}

		do_action('membership_payment_subscr_signup', $user_id, $sub_id);

		$content .= '<div id="reg-form">'; // because we can't have an enclosing form for this part

		$content .= '<div class="formleft">';

		$message = get_option( $this->gateway . "_completed_message", $this->defaultmessage );
		$content .= stripslashes($message);

		$content .= '</div>';

		$content .= "</div>";

		$content = apply_filters('membership_subscriptionform_signedup', $content, $user_id, $sub_id);

		return $content;

	}

	function single_free_button($pricing, $subscription, $user_id, $sublevel = 0) {

		global $M_options;

		if(empty($M_options['paymentcurrency'])) {
			$M_options['paymentcurrency'] = 'USD';
		}

		$form = '';

		$form .= '<form action="' . M_get_returnurl_permalink() . '" method="post">';
		$form .= '<input type="hidden" name="custom" value="' . $this->build_custom($user_id, $subscription->id, '0', $sublevel) .'">';

		if($sublevel == 1) {
			$form .= '<input type="hidden" name="action" value="subscriptionsignup" />';
			$form .=  wp_nonce_field('free-sub_' . $subscription->sub_id(), "_wpnonce", true, false);
			$form .=  "<input type='hidden' name='gateway' value='" . $this->gateway . "' />";

			$button = get_option( $this->gateway . "_payment_button", '' );
			if( empty($button) ) {
				$form .= '<input type="submit" class="button ' . apply_filters('membership_subscription_button_color', '') . '" value="' . __('Sign Up','membership') . '" />';
			} else {
				$form .= '<input type="image" name="submit" border="0" src="' . $button . '" alt="PayPal - The safer, easier way to pay online">';
			}

		} else {
			$form .=  wp_nonce_field('renew-sub_' . $subscription->sub_id(), "_wpnonce", true, false);
			$form .=  "<input type='hidden' name='action' value='subscriptionsignup' />";
			$form .=  "<input type='hidden' name='gateway' value='" . $this->gateway . "' />";
			$form .=  "<input type='hidden' name='subscription' value='" . $subscription->sub_id() . "' />";
			$form .=  "<input type='hidden' name='user' value='" . $user_id . "' />";
			$form .=  "<input type='hidden' name='level' value='" . $sublevel . "' />";

			$button = get_option( $this->gateway . "_payment_button", '' );
			if( empty($button) ) {
				$form .= '<input type="submit" class="button ' . apply_filters('membership_subscription_button_color', '') . '" value="' . __('Sign Up','membership') . '" />';
			} else {
				$form .= '<input type="image" name="submit" border="0" src="' . $button . '" alt="PayPal - The safer, easier way to pay online">';
			}
		}

		$form .= '</form>';

		return $form;

	}

	function build_subscribe_button($subscription, $pricing, $user_id, $sublevel = 1, $fromsub = 0) {

		if(!empty($pricing)) {
			// check to make sure there is a price in the subscription
			// we don't want to display free ones for a payment system

			if( isset($pricing[$sublevel - 1]) ) {
				if( empty($pricing[$sublevel - 1]) || $pricing[$sublevel - 1]['amount'] == 0 ) {
					// It's a free level
					return $this->single_free_button($pricing, $subscription, $user_id, $sublevel);
				} else {
					// It's a paid level
					return $this->single_button($pricing, $subscription, $user_id, $sublevel, $fromsub);
				}
			}

		}

	}

	function display_upgrade_from_free_button($subscription, $pricing, $user_id, $fromsub_id = false) {
		if($pricing[0]['amount'] < 1) {
			// a free first level
			$this->display_upgrade_button($subscription, $pricing, $user_id, $fromsub_id);
		} else {
			echo $this->build_subscribe_button($subscription, $pricing, $user_id, $fromsub_id);
		}

	}

	function display_upgrade_button($subscription, $pricing, $user_id, $fromsub_id = false) {

		echo '<form class="upgradebutton" action="' . M_get_subscription_permalink() . '" method="post">';
		wp_nonce_field('upgrade-sub_' . $subscription->sub_id());
		echo "<input type='hidden' name='action' value='upgradesolo' />";
		echo "<input type='hidden' name='gateway' value='" . $this->gateway . "' />";
		echo "<input type='hidden' name='subscription' value='" . $subscription->sub_id() . "' />";
		echo "<input type='hidden' name='user' value='" . $user_id . "' />";
		echo "<input type='hidden' name='fromsub_id' value='" . $fromsub_id . "' />";
		echo "<input type='submit' name='submit' value=' " . __('Upgrade', 'membership') . " ' class='button button-primary " . esc_attr( apply_filters( 'membership_subscription_button_color', '' ) ) . "' />";
		echo "</form>";
	}

	function display_cancel_button($subscription, $pricing, $user_id) {

		echo '<form class="unsubbutton" action="' . M_get_subscription_permalink() . '" method="post">';
		wp_nonce_field('cancel-sub_' . $subscription->sub_id());
		echo "<input type='hidden' name='action' value='unsubscribe' />";
		echo "<input type='hidden' name='gateway' value='" . $this->gateway . "' />";
		echo "<input type='hidden' name='subscription' value='" . $subscription->sub_id() . "' />";
		echo "<input type='hidden' name='user' value='" . $user_id . "' />";
		echo "<input type='submit' name='submit' value=' " . __('Unsubscribe', 'membership') . " ' class='button button-primary " . esc_attr( apply_filters( 'membership_subscription_button_color', '' ) ) . "' />";
		echo "</form>";
	}

	function display_subscribe_button($subscription, $pricing, $user_id, $sublevel = 1) {
		echo $this->build_subscribe_button($subscription, $pricing, $user_id, $sublevel);
	}

	function update() {

		if(isset($_POST['paypal_email'])) {
			update_option( $this->gateway . "_paypal_email", $_POST[ 'paypal_email' ] );
			update_option( $this->gateway . "_paypal_site", $_POST[ 'paypal_site' ] );
			update_option( $this->gateway . "_currency", (isset($_POST[ 'currency' ])) ? $_POST[ 'currency' ] : '' );
			update_option( $this->gateway . "_paypal_status", $_POST[ 'paypal_status' ] );
			update_option( $this->gateway . "_paypal_button", $_POST[ 'paypal_button' ] );
			update_option( $this->gateway . "_paypal_upgrade_button", $_POST[ '_paypal_upgrade_button' ] );
			update_option( $this->gateway . "_paypal_cancel_button", $_POST[ '_paypal_cancel_button' ] );
			update_option( $this->gateway . "_paypal_renew_button", $_POST[ '_paypal_renew_button' ] );
			if ( isset( $_POST[ 'completed_message' ] ) ) {
				update_option( $this->gateway . "_completed_message", $_POST[ 'completed_message' ] );
			}
		}

		// default action is to return true
		return true;

	}

	// IPN stuff
	function handle_paypal_return() {
		// PayPal IPN handling code

		if ((isset($_POST['payment_status']) || isset($_POST['txn_type'])) && isset($_POST['custom'])) {

			if (get_option( $this->gateway . "_paypal_status" ) == 'live') {
				$domain = 'https://www.paypal.com';
			} else {
				$domain = 'https://www.sandbox.paypal.com';
			}

			membership_debug_log( __('Received PayPal IPN from - ' , 'membership') . $domain );

			//Paypal post authenticity verification
			$ipn_data = (array) stripslashes_deep( $_POST );
			$ipn_data['cmd'] = '_notify-validate';
			$response = wp_remote_post("$domain/cgi-bin/webscr", array(
					'timeout' => 60,
					'sslverify' => false,
					'httpversion' => '1.1',
					'body' => $ipn_data,
				) );

			if ( ! is_wp_error( $response ) && 200 == $response['response']['code'] && ! empty( $response['body'] ) && "VERIFIED" == $response['body'] ) {
				membership_debug_log( 'PayPal Transaction Verified' );
			} else {
				$error = 'Response Error: Unexpected transaction response';
				membership_debug_log( $error );
				membership_debug_log( $response );
				echo $error;
				exit;
			}

			// handle cases that the system must ignore
			//if ($_POST['payment_status'] == 'In-Progress' || $_POST['payment_status'] == 'Partially-Refunded') exit;
			$new_status = false;
			// process PayPal response
			$factory = Membership_Plugin::factory();
			switch ($_POST['payment_status']) {
				case 'Partially-Refunded':
					break;

				case 'In-Progress':
					break;

				case 'Completed':
				case 'Processed':
					// case: successful payment
					$amount = $_POST['mc_gross'];
					$currency = $_POST['mc_currency'];
					list($timestamp, $user_id, $sub_id, $key, $sublevel, $fromsub) = explode(':', $_POST['custom']);

					$newkey = md5('MEMBERSHIP' . $amount);
					if($key != $newkey) {
						$member = $factory->get_member($user_id);
						if($member) {
							if(defined('MEMBERSHIP_DEACTIVATE_USER_ON_CANCELATION') && MEMBERSHIP_DEACTIVATE_USER_ON_CANCELATION == true ) {
								$member->deactivate();
							}
						}
					} elseif ( !$this->_check_duplicate_transaction( $user_id, $sub_id, $timestamp, trim( $_POST['txn_id'] ) ) ) {
						$this->_record_transaction( $user_id, $sub_id, $amount, $currency, $timestamp, trim( $_POST['txn_id'] ), $_POST['payment_status'], '' );

						if ( $sublevel == '1' ) {
							// This is the first level of a subscription so we need to create one if it doesn't already exist
							$member = $factory->get_member( $user_id );
							if ( $member ) {
								$member->create_subscription( $sub_id, $this->gateway );
								do_action( 'membership_payment_subscr_signup', $user_id, $sub_id );
							}
						} else {
							$member = $factory->get_member( $user_id );
							if ( $member ) {
								// Mark the payment so that we can move through ok
								$member->record_active_payment( $sub_id, $sublevel, $timestamp );
							}
						}

						// remove any current subs for upgrades
						$sub_ids = $member->get_subscription_ids();
						foreach ( $sub_ids as $fromsub ) {
							if ( $sub_id == $fromsub ) {
								continue;
							}

							$member->drop_subscription($fromsub);
						}

						// Added for affiliate system link
						do_action( 'membership_payment_processed', $user_id, $sub_id, $amount, $currency, $_POST['txn_id'] );
					}

					membership_debug_log( __('Processed transaction received - ','membership') . print_r($_POST, true) );
					break;

				case 'Reversed':
					// case: charge back
					$note = __('Last transaction has been reversed. Reason: Payment has been reversed (charge back)', 'membership');
					$amount = $_POST['mc_gross'];
					$currency = $_POST['mc_currency'];
					list($timestamp, $user_id, $sub_id, $key, $sublevel) = explode(':', $_POST['custom']);

					$this->_record_transaction($user_id, $sub_id, $amount, $currency, $timestamp, $_POST['txn_id'], $_POST['payment_status'], $note);

					membership_debug_log( __('Reversed transaction received - ','membership') . print_r($_POST, true) );

					$member = $factory->get_member($user_id);
					if($member) {
						$member->expire_subscription($sub_id);
						if(defined('MEMBERSHIP_DEACTIVATE_USER_ON_CANCELATION') && MEMBERSHIP_DEACTIVATE_USER_ON_CANCELATION == true ) {
							$member->deactivate();
						}
					}

					do_action('membership_payment_reversed', $user_id, $sub_id, $amount, $currency, $_POST['txn_id']);
					break;

				case 'Refunded':
					// case: refund
					$note = __('Last transaction has been reversed. Reason: Payment has been refunded', 'membership');
					$amount = $_POST['mc_gross'];
					$currency = $_POST['mc_currency'];
					list($timestamp, $user_id, $sub_id, $key, $sublevel) = explode(':', $_POST['custom']);

					$this->_record_transaction($user_id, $sub_id, $amount, $currency, $timestamp, $_POST['txn_id'], $_POST['payment_status'], $note);

					membership_debug_log( __('Refunded transaction received - ','membership') . print_r($_POST, true) );

					$member = $factory->get_member($user_id);
					if($member) {
						$member->expire_subscription($sub_id);
					}

					do_action('membership_payment_refunded', $user_id, $sub_id, $amount, $currency, $_POST['txn_id']);
					break;

				case 'Denied':
					// case: denied
					$note = __('Last transaction has been reversed. Reason: Payment Denied', 'membership');
					$amount = $_POST['mc_gross'];
					$currency = $_POST['mc_currency'];
					list($timestamp, $user_id, $sub_id, $key, $sublevel) = explode(':', $_POST['custom']);

					$this->_record_transaction($user_id, $sub_id, $amount, $currency, $timestamp, $_POST['txn_id'], $_POST['payment_status'], $note);

					membership_debug_log( __('Denied transaction received - ','membership') . print_r($_POST, true) );

					$member = $factory->get_member($user_id);
					if($member) {
						$member->expire_subscription($sub_id);
						if(defined('MEMBERSHIP_DEACTIVATE_USER_ON_CANCELATION') && MEMBERSHIP_DEACTIVATE_USER_ON_CANCELATION == true ) {
							$member->deactivate();
						}
					}

					do_action('membership_payment_denied', $user_id, $sub_id, $amount, $currency, $_POST['txn_id']);
					break;

				case 'Pending':
					// case: payment is pending
						$pending_str = array(
							'address' => __('Customer did not include a confirmed shipping address', 'membership'),
							'authorization' => __('Funds not captured yet', 'membership'),
							'echeck' => __('eCheck that has not cleared yet', 'membership'),
							'intl' => __('Payment waiting for aproval by service provider', 'membership'),
							'multi-currency' => __('Payment waiting for service provider to handle multi-currency process', 'membership'),
							'unilateral' => __('Customer did not register or confirm his/her email yet', 'membership'),
							'upgrade' => __('Waiting for service provider to upgrade the PayPal account', 'membership'),
							'verify' => __('Waiting for service provider to verify his/her PayPal account', 'membership'),
							'*' => ''
							);
					$reason = @$_POST['pending_reason'];
					$note = 'Last transaction is pending. Reason: ' . (isset($pending_str[$reason]) ? $pending_str[$reason] : $pending_str['*']);
					$amount = $_POST['mc_gross'];
					$currency = $_POST['mc_currency'];
					list($timestamp, $user_id, $sub_id, $key, $sublevel) = explode(':', $_POST['custom']);

					$this->_record_transaction($user_id, $sub_id, $amount, $currency, $timestamp, $_POST['txn_id'], $_POST['payment_status'], $note);

					membership_debug_log( __('Pending transaction received - ','membership') . print_r($_POST, true) );

					do_action('membership_payment_pending', $user_id, $sub_id, $amount, $currency, $_POST['txn_id']);
					break;

				default:
					// case: various error cases
			}

			//check for subscription details
			switch ($_POST['txn_type']) {

				case 'new_case':
					// a dispute
					if($_POST['case_type'] == 'dispute') {
						list($timestamp, $user_id, $sub_id, $key, $sublevel) = explode(':', $_POST['custom']);
						// immediately suspend the account
						$member = $factory->get_member($user_id);
						if($member) {
							$member->deactivate();

							membership_debug_log( sprintf(__('Dispute for %d','membership'), $user_id ) );
						}
					}

					do_action('membership_payment_new_case', $user_id, $sub_id, $_POST['case_type']);
					break;
			}

		} else {
			// Did not find expected POST variables. Possible access attempt from a non PayPal site.
			header('Status: 404 Not Found');
			echo 'Error: Missing POST variables. Identification is not possible.';
			membership_debug_log( 'Error: Missing POST variables. Identification is not possible.' );
			exit;
		}
	}

}

Membership_Gateway::register_gateway( 'paypalsolo', 'paypalsolo' );