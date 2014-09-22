<?php

add_action('widgets_init', 'emember_load_widgets');

function emember_load_widgets() {
    register_widget('WP_eMember_Login_Widget'); //register emember login widget
    //Other widgets can go here
}

class WP_eMember_Login_Widget extends WP_Widget {

    function WP_eMember_Login_Widget() {
        $widget_options = array('classname' => 'wp_eMember_widget', 'description' => __("Display WP eMember Login."));
        parent::WP_Widget('wp_eMember_login_widget', 'WP eMember Login', $widget_options);
    }

    function form($instance) {
        // outputs the options form on admin
    }

    function update($new_instance, $old_instance) {
        // processes widget options to be saved
    }

    function widget($args, $instance) {
        // outputs the content of the widget
        extract($args);

        $emember_config = Emember_Config::getInstance();
        $widget_title = $emember_config->getValue('wp_eMember_widget_title');
        if (empty($widget_title)) {
            $widget_title = EMEMBER_MEMBER_LOGIN;
        }
        echo $before_widget;
        echo $before_title . $widget_title . $after_title;
        echo eMember_login_widget();
        echo $after_widget;
    }

}
