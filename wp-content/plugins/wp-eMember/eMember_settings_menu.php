<?php
include_once('admin_includes.php');
include_once('eMember_email_settings_menu.php');
include_once('recaptcha_settings.php');
include_once('emember_pages_settings.php');
include_once('emember_general_settings.php');
include_once('eMember_auto_responder_settings.php');
include_once('eMember_custom_field_settings.php');
include_once('emember_gateway_settings.php');

function wp_eMember_settings() {
    echo '<div class="wrap"><h2>WP eMembers - Settings v' . WP_EMEMBER_VERSION . '</h2>';
    echo check_php_version();
    echo eMember_admin_submenu_css();
    $current = (isset($_GET['tab'])) ? $_GET['tab'] : 1;
    ?>
    <h3 class="nav-tab-wrapper">
        <a class="nav-tab <?php echo ($current == 1) ? 'nav-tab-active' : ''; ?>" href="admin.php?page=eMember_settings_menu">General Settings</a>
        <a class="nav-tab <?php echo ($current == 4) ? 'nav-tab-active' : ''; ?>" href="admin.php?page=eMember_settings_menu&tab=4">Pages/Forms Settings</a>
        <a class="nav-tab <?php echo ($current == 2) ? 'nav-tab-active' : ''; ?>" href="admin.php?page=eMember_settings_menu&tab=2">Email Settings</a>
        <a class="nav-tab <?php echo ($current == 7) ? 'nav-tab-active' : ''; ?>" href="admin.php?page=eMember_settings_menu&tab=7">Gateway Settings</a>
        <a class="nav-tab <?php echo ($current == 3) ? 'nav-tab-active' : ''; ?>" href="admin.php?page=eMember_settings_menu&tab=3">reCAPTCHA Settings</a>
        <a class="nav-tab <?php echo ($current == 5) ? 'nav-tab-active' : ''; ?>" href="admin.php?page=eMember_settings_menu&tab=5">Autoresponder Settings</a>
        <a class="nav-tab <?php echo ($current == 6) ? 'nav-tab-active' : ''; ?>" href="admin.php?page=eMember_settings_menu&tab=6">Custom Field Settings</a>
    </h3>
    <?php
    $_GET['tab'] = isset($_GET['tab']) ? $_GET['tab'] : "";
    switch ($current) {
        case '2':
            wp_eMember_email_settings();
            break;
        case '3':
            recaptcha_settings();
            break;
        case '4':
            emember_pages_settings();
            break;
        case '5':
            emember_auto_responder_settings();
            break;
        case '6':
            emember_custom_field_settings();
            break;
        case '7':
            emember_payment_gateway_settings_menu();
            break;
        default:
            wp_eMember_general_settings();
            break;
    }
    echo '</div>';
}
?>
