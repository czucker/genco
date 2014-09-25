<?php

/*
  Plugin Name: WP Visual Slide Box Builder
  Plugin URI: http://wpvisualslideboxbuilder.com
  Description: Fancy jQuery driven animations to display inside a box
  Author: Enmanuel Corvo
  Version: 1.2.7
  Author URI: http://wpvisualslideboxbuilder.com
 */


function ap_action_init()
{
    // Localization
    load_plugin_textdomain('wp-visual-slidebox-builder', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

// Add actions
add_action('init', 'ap_action_init');

function funbox_admin() {
    include('funbox_admin.php');
}

function funbox_admin_actions() {
    add_options_page("Virtual Slide Box Builder", "Virtual Slide Box Builder", 1, "Virtual_Slide_Box_Builder", "funbox_admin");
}

register_activation_hook(__FILE__, 'funbox_install');
add_action('admin_menu', 'funbox_admin_actions');
add_action('wp_enqueue_scripts', 'funbox_load');

add_action('admin_enqueue_scripts', 'fun_box_my_admin_scripts');

function fun_box_my_admin_scripts() {
    if (isset($_GET['page']) && $_GET['page'] == 'Virtual_Slide_Box_Builder') {
        wp_enqueue_media();
        funbox_admin_init();
    }
}

function funbox_load() {
    /* Register bootstrap and custom stylesheet and js for actual page */
    wp_register_style('bootstrap_funBox_style', plugins_url('bootstrap.min.css', __FILE__));
    wp_register_style('custom_funBox_style', plugins_url('custom-fun-box.css', __FILE__));
    wp_register_style('animated_css', plugins_url('animate-custom.css', __FILE__));
    wp_register_script('funbox_page_js', plugins_url('/js/fun_box.js', __FILE__), array('jquery'));
    wp_register_script('bootstrap_js', plugins_url('/js/bootstrap.min.js', __FILE__));

    wp_enqueue_style('bootstrap_funBox_style');
    wp_enqueue_style('custom_funBox_style');
    wp_enqueue_style('animated_css');
    wp_enqueue_script('funbox_page_js');
    wp_enqueue_script('bootstrap_js');
}

function funbox_admin_init() {
    /* Register bootstrap and custom stylesheet and js for admin view */
    wp_register_style('bootstrap_funBox_style', plugins_url('bootstrap.min.css', __FILE__));
    wp_register_style('custom_funBox_style', plugins_url('custom-fun-box.css', __FILE__));
    wp_register_style('animated_css', plugins_url('animate-custom.css', __FILE__));
    wp_register_script('funbox_admin_js', plugins_url('/js/fun_box_admin.js', __FILE__));
    wp_register_script('bootstrap_js', plugins_url('/js/bootstrap.min.js', __FILE__));

    wp_enqueue_style('bootstrap_funBox_style');
    wp_enqueue_style('custom_funBox_style');
    wp_enqueue_style('animated_css');
    wp_enqueue_script('funbox_admin_js');
    wp_enqueue_script('bootstrap_js');
}

function funbox_install() {
    global $wpdb;
    $table_name = $wpdb->prefix . "funbox";

    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                boxId VARCHAR(100),
                box_html TEXT,
                save_name VARCHAR(200),
                title VARCHAR(200),
                c_rc_1 VARCHAR(100),
                c_rc_2 VARCHAR(100),
                c_rc_3 VARCHAR(100),
                c_rc_4 VARCHAR(100),
                c_bg_c VARCHAR(100),
                c_bd_c VARCHAR(100),
                c_ft_c VARCHAR(100),
                c_brd VARCHAR(100),
                c_opc VARCHAR(100),
                c_wid VARCHAR(100),
                c_hei VARCHAR(100),
                c_txt VARCHAR(100),
                c_txt_l VARCHAR(100),
                c_txt_r VARCHAR(100),
                c_txt_t VARCHAR(100),
                c_txt_d VARCHAR(100),
                c_txt_fnt_sz VARCHAR(100),
                c_txt_spc VARCHAR(100),
                l_dv VARCHAR(100),
                l_rc_1 VARCHAR(100),
                l_rc_2 VARCHAR(100),
                l_rc_3 VARCHAR(100),
                l_rc_4 VARCHAR(100),
                l_bg_c VARCHAR(100),
                l_ft_c VARCHAR(100),
                l_tl_c VARCHAR(100),
                l_dv_c VARCHAR(100),
                l_entr VARCHAR(100),
                l_opc VARCHAR(100),
                l_titl VARCHAR(100),
                l_titl_u VARCHAR(100),
                l_titl_d VARCHAR(100),
                l_titl_l VARCHAR(100),
                l_titl_r VARCHAR(100),
                l_titl_fnt_sz VARCHAR(100),
                l_txt VARCHAR(100),
                l_txt_l VARCHAR(100),
                l_txt_r VARCHAR(100),
                l_txt_t VARCHAR(100),
                l_txt_d VARCHAR(100),
                l_txt_fnt_sz VARCHAR(100),
                l_txt_spc VARCHAR(100),
                l_titl_lnk VARCHAR(100),
                trans_1 VARCHAR(100),
                trans_2 VARCHAR(100),
                italics_1 VARCHAR(100),
                italics_2 VARCHAR(100),
                italics_3 VARCHAR(100),
                boald_1 VARCHAR(100),
                boald_2 VARCHAR(100),
                boald_3 VARCHAR(100),
                short_code VARCHAR(255),
                date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY id (id)
              );";
    }
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);
}

//GET ALL BOXES
add_action('wp_ajax_GET_SAVED_BOXES', 'get_all_funbox');
//GET SPECIFIC BOX
add_action('wp_ajax_GET_BOX', 'get_a_funbox');
//OVERWRITE SPECIFIC BOX
add_action('wp_ajax_OVERWRITE_BOX', 'overwrite_a_funbox');
//DELETE SPECIFIC BOX
add_action('wp_ajax_DELETE_BOX', 'delete_a_funbox');

function delete_a_funbox() {
    global $wpdb;
    $table_name = $wpdb->prefix . "funbox";
    $id = $_POST['id'];
    $wpdb->delete($table_name, array('id' => $id), array('%d'));
}

function overwrite_a_funbox() {
    global $wpdb;
    $table_name = $wpdb->prefix . "funbox";
    $name = $_POST['id'];
    $sql = "select * from " . $table_name . " where title=" . "'" . $name . "'";
    $results = $wpdb->get_row($sql);
    //exit(var_dump($_POST));
    $data = array(
        'boxid' => esc_html($_POST['data']['container']['save_name']),
        //box
        'c_rc_1' => esc_html($_POST['data']['container']['c_rc_1']),
        'c_rc_2' => esc_html($_POST['data']['container']['c_rc_2']),
        'c_rc_3' => esc_html($_POST['data']['container']['c_rc_3']),
        'c_rc_4' => esc_html($_POST['data']['container']['c_rc_4']),
        'c_bg_c' => esc_html($_POST['data']['container']['c_bg_c']),
        'c_bd_c' => esc_html($_POST['data']['container']['c_bd_c']),
        'c_ft_c' => esc_html($_POST['data']['container']['c_ft_c']),
        'c_brd' => esc_html($_POST['data']['container']['c_brd']),
        'c_opc' => esc_html($_POST['data']['container']['c_opc']),
        'c_wid' => esc_html($_POST['data']['container']['c_wid']),
        'c_hei' => esc_html($_POST['data']['container']['c_hei']),
        'c_txt' => esc_html($_POST['data']['container']['c_txt']),
        'c_txt_fnt_sz' => esc_html($_POST['data']['container']['c_txt_fnt_sz']),
        'c_txt_spc' => esc_html($_POST['data']['container']['c_txt_spc']),
        'save_name' => esc_html($_POST['data']['container']['save_name']),
        'box_html' => $_POST['data']['container']['html'],
        //lit
        'title' => esc_html($_POST['data']['container']['save_name']),
        'l_rc_1' => esc_html($_POST['data']['lit']['l_rc_1']),
        'l_rc_2' => esc_html($_POST['data']['lit']['l_rc_2']),
        'l_rc_3' => esc_html($_POST['data']['lit']['l_rc_3']),
        'l_rc_4' => esc_html($_POST['data']['lit']['l_rc_4']),
        'l_bg_c' => esc_html($_POST['data']['lit']['l_bg_c']),
        'l_ft_c' => esc_html($_POST['data']['lit']['l_ft_c']),
        'l_tl_c' => esc_html($_POST['data']['lit']['l_tl_c']),
        'l_dv_c' => esc_html($_POST['data']['lit']['l_dv_c']),
        'l_dv' => esc_html($_POST['data']['lit']['l_dv']),
        'l_entr' => esc_html($_POST['data']['lit']['l_entr']),
        'l_opc' => esc_html($_POST['data']['lit']['l_opc']),
        'l_titl' => esc_html($_POST['data']['lit']['l_titl']),
        //--
        'l_titl_fnt_sz' => esc_html($_POST['data']['lit']['l_titl_fnt_sz']),
        'l_txt' => esc_html($_POST['data']['lit']['l_txt']),
        'l_txt_fnt_sz' => esc_html($_POST['data']['lit']['l_txt_fnt_sz']),
        'l_txt_spc' => esc_html($_POST['data']['lit']['l_txt_spc']),
        'l_titl_lnk' => esc_html($_POST['data']['lit']['l_titl_lnk']),
        'trans_1' => esc_html($_POST['data']['lit']['trans_1']),
        'trans_2' => esc_html($_POST['data']['lit']['trans_2']),
        'italics_1' => esc_html($_POST['data']['lit']['italics_1']),
        'italics_2' => esc_html($_POST['data']['lit']['italics_2']),
        'italics_3' => esc_html($_POST['data']['lit']['italics_3']),
        'boald_1' => esc_html($_POST['data']['lit']['boald_1']),
        'boald_2' => esc_html($_POST['data']['lit']['boald_2']),
        'boald_3' => esc_html($_POST['data']['lit']['boald_3']),
        //-
        'short_code' => '[virtual_slide_box id="test"]'
    );
    $where = array('id' => $results->id);

    $wpdb->update($table_name, $data, $where);

    //exit(var_dump($wpdb->last_query));
    $json = json_encode(array(
        'Messege' => 'The item has been successfully saved, you can view it in your history.',
        'Type' => 'success',
        'Heading' => 'Sucessfully Saved',
    ));
    header('Content-type: application/json');
    echo $json;
    exit;
}

function get_a_funbox() {
    global $wpdb;
    $table_name = $wpdb->prefix . "funbox";
    $id = $_POST['id'];
    $sql = 'select * from ' . $table_name . ' where id=' . $id . '';
    $results = $wpdb->get_results($sql);
    $json = json_encode($results);

    header('Content-type: application/json');
    echo $json;
    exit;
}

function get_all_funbox() {
    global $wpdb;
    $table_name = $wpdb->prefix . "funbox";
    $sql = "select * from " . $table_name;

    $results = $wpdb->get_results($sql);
    $json = json_encode($results);

    header('Content-type: application/json');
    echo $json;
    exit;
}

//SHARE
add_action('wp_ajax_SHARE_BOX', 'share_box');

function share_box() {
    global $wpdb;
    $table_name = $wpdb->prefix . "funbox";
    if (isset($_POST['save_name'])) {
        $name = $_POST['save_name'];
        $sql = "select * from " . $table_name . " where title=" . "'" . $name . "' LIMIT 1";
        $results = $wpdb->get_row($sql);
    }
    $output = str_replace("test", $results->id, $results->short_code);
    global $user_ID;
    $page['post_type'] = 'page';
    $page['post_content'] = $output;
    $page['post_parent'] = 0;
    $page['post_author'] = $user_ID;
    $page['post_status'] = 'publish';
    $page['post_title'] = 'New Slidebox -' . $results->title;
    $pageid = wp_insert_post($page);
    if ($pageid == 0) { /* Add Page Failed */
    }
    $page_url = get_permalink($pageid);
    $json = json_encode(Array('page_url' => $page_url));
    header('Content-type: application/json');
    echo $json;
    exit;
}

//SAVING
add_action('wp_ajax_SAVE', 'save_new_funbox');

function save_new_funbox() {
    global $wpdb;
    $table_name = $wpdb->prefix . "funbox";
    $found = false;
    if (isset($_POST['data']['container']['save_name'])) {
        $name = $_POST['data']['container']['save_name'];
        $sql = "select * from " . $table_name . " where title=" . "'" . $name . "' LIMIT 1";
        $results = $wpdb->get_row($sql);
    }
    // $box = mysql_fetch_assoc($results);
    if (count($results) == 0) {
        $data = array(
            'boxid' => esc_html($_POST['data']['container']['save_name']),
            //box
            'c_rc_1' => esc_html($_POST['data']['container']['c_rc_1']),
            'c_rc_2' => esc_html($_POST['data']['container']['c_rc_2']),
            'c_rc_3' => esc_html($_POST['data']['container']['c_rc_3']),
            'c_rc_4' => esc_html($_POST['data']['container']['c_rc_4']),
            'c_bg_c' => esc_html($_POST['data']['container']['c_bg_c']),
            'c_bd_c' => esc_html($_POST['data']['container']['c_bd_c']),
            'c_ft_c' => esc_html($_POST['data']['container']['c_ft_c']),
            'c_brd' => esc_html($_POST['data']['container']['c_brd']),
            'c_opc' => esc_html($_POST['data']['container']['c_opc']),
            'c_wid' => esc_html($_POST['data']['container']['c_wid']),
            'c_hei' => esc_html($_POST['data']['container']['c_hei']),
            'c_txt' => esc_html($_POST['data']['container']['c_txt']),
            'c_txt_fnt_sz' => esc_html($_POST['data']['container']['c_txt_fnt_sz']),
            'c_txt_spc' => esc_html($_POST['data']['container']['c_txt_spc']),
            'save_name' => esc_html($_POST['data']['container']['save_name']),
            'box_html' => $_POST['data']['container']['html'],
            //lit
            'title' => esc_html($_POST['data']['container']['save_name']),
            'l_rc_1' => esc_html($_POST['data']['lit']['l_rc_1']),
            'l_rc_2' => esc_html($_POST['data']['lit']['l_rc_2']),
            'l_rc_3' => esc_html($_POST['data']['lit']['l_rc_3']),
            'l_rc_4' => esc_html($_POST['data']['lit']['l_rc_4']),
            'l_bg_c' => esc_html($_POST['data']['lit']['l_bg_c']),
            'l_ft_c' => esc_html($_POST['data']['lit']['l_ft_c']),
            'l_tl_c' => esc_html($_POST['data']['lit']['l_tl_c']),
            'l_dv_c' => esc_html($_POST['data']['lit']['l_dv_c']),
            'l_dv' => esc_html($_POST['data']['lit']['l_dv']),
            'l_entr' => esc_html($_POST['data']['lit']['l_entr']),
            'l_opc' => esc_html($_POST['data']['lit']['l_opc']),
            'l_titl' => esc_html($_POST['data']['lit']['l_titl']),
            //--
            'l_titl_fnt_sz' => esc_html($_POST['data']['lit']['l_titl_fnt_sz']),
            'l_txt' => esc_html($_POST['data']['lit']['l_txt']),
            'l_txt_fnt_sz' => esc_html($_POST['data']['lit']['l_txt_fnt_sz']),
            'l_txt_spc' => esc_html($_POST['data']['lit']['l_txt_spc']),
            'l_titl_lnk' => esc_html($_POST['data']['lit']['l_titl_lnk']),
            'trans_1' => esc_html($_POST['data']['lit']['trans_1']),
            'trans_2' => esc_html($_POST['data']['lit']['trans_2']),
            'italics_1' => esc_html($_POST['data']['lit']['italics_1']),
            'italics_2' => esc_html($_POST['data']['lit']['italics_2']),
            'italics_3' => esc_html($_POST['data']['lit']['italics_3']),
            'boald_1' => esc_html($_POST['data']['lit']['boald_1']),
            'boald_2' => esc_html($_POST['data']['lit']['boald_2']),
            'boald_3' => esc_html($_POST['data']['lit']['boald_3']),
            //-
            'short_code' => '[virtual_slide_box id="test"]'
        );
        $rows_affected = $wpdb->insert($table_name, $data);
        //exit(var_dump($wpdb->last_query));
        $json = json_encode(array(
            'Messege' => 'The item has been successfully saved, you can view it in your history.',
            'Type' => 'success',
            'Heading' => 'Sucessfully Saved',
        ));
        header('Content-type: application/json');
        echo $json;
        exit;
    } else {
        $json = json_encode(array(
            'Messege' => 'Do you want to overwrite the existing item?',
            'Type' => 'action',
            'Heading' => 'Overwrite Existing?',
            'Action' => array('pertinent' => 'Overwrite', 'def' => 'Cancel', 'call' => 'overwrite', 'pertinent_id' => $results->title),
        ));
        header('Content-type: application/json');
        echo $json;
        exit;
    }
}

//ajax
add_action('wp_ajax_SHORT_CODE_DISP', 'short_code_disp');

function short_code_disp() {
    $id = $_POST['id'];
    echo '[virtual_slide_box id=' . $id . ']';
}

add_shortcode('virtual_slide_box', 'box_shortcode');

function box_shortcode($atts) {
    extract(shortcode_atts(array(
        'id' => '',
        'mode' => 'bottom-up-full',
        'class' => '',
        'title' => '',
        'desc' => '',
        'alt' => ''
                    ), $atts));
    global $wpdb;
    $table_name = $wpdb->prefix . "funbox";
    $aBox = "13";
    $box = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id =%d", $id));
    //exit(var_dump($wpdb->last_query));
    $html_1 = str_replace('\\', '', $box->box_html);
    $html_2 = str_replace('squareDemo', 'squareDemo squareDemo_production', $html_1);
    $html = str_replace('square_preview', 'square_production_' . $box->boxId, $html_2);
    return $html;
}

?>