<?php
header( 'Content-type: text/css' );
include("../../../../../wp-load.php");
$fcl_options = get_option( 'fcl_custom_login_options' );
$options = array(
	'background'       => ( strlen( $fcl_options['colors']['background']) > 0 ) ? "#".$fcl_options['colors']['background'] : "transparent",
	'login_background' => ( strlen( $fcl_options['colors']['login_background']) > 0 ) ? "#".$fcl_options['colors']['login_background'] : "transparent",
	'label_font_color' => ( strlen( $fcl_options['colors']['label_font_color']) > 0 ) ? "#".$fcl_options['colors']['label_font_color'] : "#333",
	'link_font_color'  => ( strlen( $fcl_options['colors']['link_font_color']) > 0 ) ? "#".$fcl_options['colors']['link_font_color'] : "#333",
	'link_font_shadow_color'=> ( strlen( $fcl_options['colors']['link_font_shadow_color']) > 0 ) ? "#".$fcl_options['colors']['link_font_shadow_color'] : "#ccc",
	'logo'             => ( strlen( $fcl_options['images']['logo']) > 0 ) ? $fcl_options['images']['logo'] : "../../../../../wp-admin/images/logo-login.png",
	'hide_back_to_link'=> ( strlen( $fcl_options['style']['hide_back_to_link']) > 0 ) ? $fcl_options['style']['hide_back_to_link'] : "No",
	'hide_pwd_recovery'=> ( strlen( $fcl_options['style']['hide_pwd_recovery']) > 0 ) ? $fcl_options['style']['hide_pwd_recovery'] : "No",
	'disable'          => ( strlen( $fcl_options['style']['disable'] ) > 0 ) ? $fcl_options['style']['disable'] : "No",
	'login_type'       => ( strlen( $fcl_options['general']['login_type'] ) > 0 ) ? $fcl_options['general']['login_type'] : "new",
);
?>

<?php if ( "Yes" == $options['hide_back_to_link'] ): ?>
#backtoblog {
  display: none;
}
<?php endif; ?>

<?php if ( "Yes" == $options['hide_pwd_recovery'] ): ?>
#pwdrecovery {
  display: none;
}
<?php endif; ?>

<?php if ( "new" == $options['login_type'] ): //Start if it is the login form inside of the theme ?>
<?php /*
If you select to insert the login form into the activated theme, these styles below will be used.
If you use the default WordPress login page, the styles will be loaded from the 'wp-admin' folder and the styles below will not be used.
You may edit any of the values below as you see fit.
*/ ?>
#login form {
  margin-left: 8px;
  padding: 26px 24px 46px;
  font-weight: normal;
  -moz-border-radius: 3px;
  -khtml-border-radius: 3px;
  -webkit-border-radius: 3px;
  border-radius: 3px;
  background: #fff;
  border: 1px solid #e5e5e5;
  -moz-box-shadow: rgba(200, 200, 200, 0.7) 0 4px 10px -1px;
  -webkit-box-shadow: rgba(200, 200, 200, 0.7) 0 4px 10px -1px;
  -khtml-box-shadow: rgba(200, 200, 200, 0.7) 0 4px 10px -1px;
  box-shadow: rgba(200, 200, 200, 0.7) 0 4px 10px -1px;
}
#login form .forgetmenot {
  font-weight: normal;
  float: left;
  margin-bottom: 0;
}
.button-primary {
  font-family: sans-serif;
  padding: 3px 10px;
  border: none;
  font-size: 13px;
  border-width: 1px;
  border-style: solid;
  -moz-border-radius: 11px;
  -khtml-border-radius: 11px;
  -webkit-border-radius: 11px;
  border-radius: 11px;
  cursor: pointer;
  text-decoration: none;
  margin-top: -3px;
}
#login form p {
  margin-bottom: 0;
}
#login label {
  color: #777;
  font-size: 14px;
}
#login form .forgetmenot label {
  font-size: 12px;
  line-height: 19px;
}
#login form .wp_submit, .alignright {
  float: right;
}
/*#login form p {
  margin-bottom: 24px;
}*/
#login h1 a {
  background: url(../images/logo-login.png) no-repeat top center;
  width: 326px;
  height: 67px;
  text-indent: -9999px;
  overflow: hidden;
  padding-bottom: 15px;
  display: block;
}
/* set here position and size of Login form (see screenshot3) 
   margin: top right bottom left */
#login {
  width: 320px;
  margin: 7em auto;
}
#login_error, .message {
  margin: 0 0 16px 8px;
  border-width: 1px;
  border-style: solid;
  padding: 12px;
  -moz-border-radius: 3px;
  -khtml-border-radius: 3px;
  -webkit-border-radius: 3px;
  border-radius: 3px;
}
#wpnav, #backtoblog {
  text-shadow: rgba(255, 255, 255, 1) 0 1px 0;
  margin: 0 0 0 16px;
  padding: 16px 16px 0;
}
#backtoblog, #pwdrecovery {
  padding: 12px 16px 0;
}
body form .input {
  font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", sans-serif;
  font-weight: 200;
  font-size: 24px;
  width: 97%;
  padding: 3px;
  margin-top: 2px;
  margin-right: 6px;
  margin-bottom: 16px;
  border: 1px solid #e5e5e5;
  background: #fbfbfb;
  outline: none;
  -moz-box-shadow: inset 1px 1px 2px rgba(200, 200, 200, 0.2);
  -webkit-box-shadow: inset 1px 1px 2px rgba(200, 200, 200, 0.2);
  box-shadow: inset 1px 1px 2px rgba(200, 200, 200, 0.2);
}

.clear {
  clear: both;
}
#pass-strength-result {
  font-weight: bold;
  border-style: solid;
  border-width: 1px;
  margin: 12px 0 6px;
  padding: 6px 5px;
  text-align: center;
}

/*
colors-fresh.css original start
*/
div.error, .login #login_error {
  background-color: #ffebe8;
  border-color: #c00;
}
div.updated, .login .message {
  background-color: #ffffe0;
  border-color: #e6db55;
}
/*
colors-fresh.css original end
*/
<?php if ("Yes" != $options['disable']): ?>
.btn {
  cursor: pointer;
  display: inline-block;
  background-color: #e6e6e6;
  background-repeat: no-repeat;
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), color-stop(0.25, #ffffff), to(#e6e6e6));
  background-image: -webkit-linear-gradient(#ffffff, #ffffff 0.25, #e6e6e6);
  background-image: -moz-linear-gradient(#ffffff, #ffffff 0.25, #e6e6e6);
  background-image: -ms-linear-gradient(#ffffff, #ffffff 0.25, #e6e6e6);
  background-image: -o-linear-gradient(#ffffff, #ffffff 0.25, #e6e6e6);
  background-image: linear-gradient(#ffffff, #ffffff 0.25, #e6e6e6);
  padding: 4px 14px;
  text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
  color: #333;
  font-size: 13px;
  line-height: 18px;
  border: 1px solid #ccc;
  border-bottom-color: #bbb;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  -webkit-transition: 0.1s linear all;
  -moz-transition: 0.1s linear all;
  transition: 0.1s linear all;
}
.btn:hover {
  background-position: 0 -15px;
  color: #333;
  text-decoration: none;
}
.btn.primary, .btn.danger {
  color: #fff;
}
.btn.primary:hover, .btn.danger:hover {
  color: #fff;
}
.btn.primary {
  background-color: #0064cd;
  background-repeat: repeat-x;
  background-image: -khtml-gradient(linear, left top, left bottom, from(#049cdb), to(#0064cd));
  background-image: -moz-linear-gradient(#049cdb, #0064cd);
  background-image: -ms-linear-gradient(#049cdb, #0064cd);
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #049cdb), color-stop(100%, #0064cd));
  background-image: -webkit-linear-gradient(#049cdb, #0064cd);
  background-image: -o-linear-gradient(#049cdb, #0064cd);
  background-image: linear-gradient(#049cdb, #0064cd);
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  border-color: #0064cd #0064cd #003f81;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
}
.btn.danger {
  background-color: #9d261d;
  background-repeat: repeat-x;
  background-image: -khtml-gradient(linear, left top, left bottom, from(#d83a2e), to(#9d261d));
  background-image: -moz-linear-gradient(#d83a2e, #9d261d);
  background-image: -ms-linear-gradient(#d83a2e, #9d261d);
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #d83a2e), color-stop(100%, #9d261d));
  background-image: -webkit-linear-gradient(#d83a2e, #9d261d);
  background-image: -o-linear-gradient(#d83a2e, #9d261d);
  background-image: linear-gradient(#d83a2e, #9d261d);
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  border-color: #9d261d #9d261d #5c1611;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
}
.btn.large {
  font-size: 16px;
  line-height: 28px;
  -webkit-border-radius: 6px;
  -moz-border-radius: 6px;
  border-radius: 6px;
}
/* set here size and position of Login button (see screenshot3) - default full size centered: */
.btn.small {
  padding-right: 9px;
  padding-left: 9px;
  font-size: 11px;
}
/* .. and sample smaller right aligned:
.btn.small {
  float:right;
  max-width:70px;
  font-size: 11px;
}
*/
.btn.disabled {
  background-image: none;
  filter: alpha(opacity=65);
  -khtml-opacity: 0.65;
  -moz-opacity: 0.65;
  opacity: 0.65;
  cursor: default;
}
.btn:disabled {
  background-image: none;
  filter: alpha(opacity=65);
  -khtml-opacity: 0.65;
  -moz-opacity: 0.65;
  opacity: 0.65;
  cursor: default;
}
.btn:active {
  -webkit-box-shadow: inset 0 3px 7px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.05);
  -moz-box-shadow: inset 0 3px 7px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.05);
  box-shadow: inset 0 3px 7px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.05);
}
<?php endif; //Show the custom login buttons as long as it isn't disabled ?>

<?php endif; //End if it is the login form inside of the theme ?>

<?php if ("Yes" != $options['disable']): ?>

<?php /* PLEASE BE CAREFUL EDITING THE VALUES BELOW */ ?>

<?php if ("current" == $fcl_options['general']['login_type']): //Only show these options to default login page ?>
#login h1 a { 
  background: url('<?php echo $options['logo']; ?>') no-repeat top center;
  background-size: auto;
} 
html {
  background: <?php echo $options['background']; ?>!important;
}
<?php endif; ?>
#login form  {
  background: <?php echo $options['login_background']; ?>;
  border: 0px solid #2b2b2b;
}
input.button-primary, button.button-primary, a.button-primary {
  text-decoration: none;
  cursor: pointer;
  display: inline-block;
  background-color: #e6e6e6;
  background-repeat: no-repeat;
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), color-stop(0.25, #ffffff), to(#e6e6e6));
  background-image: -webkit-linear-gradient(#ffffff, #ffffff 0.25, #e6e6e6);
  background-image: -moz-linear-gradient(#ffffff, #ffffff 0.25, #e6e6e6);
  background-image: -ms-linear-gradient(#ffffff, #ffffff 0.25, #e6e6e6);
  background-image: -o-linear-gradient(#ffffff, #ffffff 0.25, #e6e6e6);
  background-image: linear-gradient(#ffffff, #ffffff 0.25, #e6e6e6);
  padding: 4px 14px;
  text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
  color: #fff;
  font-size: 13px;
  line-height: 18px;
  border: 1px solid #ccc;
  border-bottom-color: #bbb;
  -webkit-border-radius: 4px;
  -moz-border-radius: 4px;
  border-radius: 4px;
  -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
  -webkit-transition: 0.1s linear all;
  -moz-transition: 0.1s linear all;
  transition: 0.1s linear all;
  background-color: #0064cd;
  background-repeat: repeat-x;
  background-image: -khtml-gradient(linear, left top, left bottom, from(#049cdb), to(#0064cd));
  background-image: -moz-linear-gradient(#049cdb, #0064cd);
  background-image: -ms-linear-gradient(#049cdb, #0064cd);
  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #049cdb), color-stop(100%, #0064cd));
  background-image: -webkit-linear-gradient(#049cdb, #0064cd);
  background-image: -o-linear-gradient(#049cdb, #0064cd);
  background-image: linear-gradient(#049cdb, #0064cd);
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  border-color: #0064cd #0064cd #003f81;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
}

input.button-primary:hover, button.button-primary:hover, a.button-primary:hover, a.button-primary:focus, a.button-primary:active {
  border-color: #13455b;
  color: #333;
}

.login #wpnav a, .login #nav a, .login #backtoblog a {
  color: <?php echo $options['link_font_color']; ?>!important;
  text-shadow: <?php echo $options['link_font_shadow_color']; ?> 0 1px 0;
}

#login label{
  color:<?php echo $options['label_font_color']; ?>;
}

/* to resolve a conflict with Visual Form Builder */
input.small, select.small {
  width: 100%;
}

#loginform {
    width: auto;
}
#wp-submit:hover{background-color: #0064AE;}
<?php endif; ?>