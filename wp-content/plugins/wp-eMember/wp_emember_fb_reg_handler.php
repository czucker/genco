<?php

function add_fb_namespace($output) {
    $xml_namespaces = 'xmlns="http://www.w3.org/1999/xhtml" ' .
            'xmlns:x2="http://www.w3.org/2002/06/xhtml2" ' .
            'xmlns:fb="http://www.facebook.com/2008/fbml" ';

    return $output . ' ' . $xml_namespaces;
}

function wp_emember_fb_reg_handler() {
    global $wpdb;
    global $emember_config;
    $emember_config = Emember_Config::getInstance();
    $result = $wpdb->get_results('SELECT id,alias FROM ' . WP_EMEMBER_MEMBERSHIP_LEVEL_TABLE . ' WHERE id !=1', ARRAY_A);
    ob_start();
    ?>
    <div id="fb-root"></div>
    <script src="http://connect.facebook.net/en_US/all.js#appId=<?php echo $emember_config->getValue('emember_fb_app_id'); ?>&xfbml=1"></script>
    <fb:registration redirect-uri="<?php echo WP_EMEMBER_URL; ?>/api/fb-openid.php"
                     fields="[
                     {'name':'name'},
                     {'name':'title','description':'Title','type':'select',    'options':{'Mr':'Mr','Miss':'Miss', 'Ms':'Ms','Dr':'Dr'}},
                     {'name':'username', 'description':'Username', 'type':'text'},
                     {'name':'first_name'},
                     {'name':'last_name'},
                     {'name':'email'},
                     {'name':'membership','description':'Membership','type':'select',    'options':{<?php
                     foreach ($result as $row) {
                         echo '\'' . $row['id'] . '\':\'' . $row['alias'] . '\',';
                     }
                     ?>}},
                     {'name':'location'},
                     {'name':'gender'},
                     {'name':'password'},
                     {'name':'company',      'description':'Company',             'type':'text'},
                     {'name':'street',      'description':'Address Street',             'type':'text'},
                     {'name':'state',      'description':'Address State',             'type':'text'},
                     {'name':'zipcode',      'description':'Address Zipcode',             'type':'text'},
                     {'name':'phone',      'description':'Phone Number',             'type':'text'},
                     {'name':'captcha'},
                     ]"
                     onvalidate="validate_async"></fb:registration>


    <script>
        function validate_async(form, cb) {
            var params = {"action": "check_name",
                "event": "check_name",
                "fieldId": "wp_emember_user_name",
                "fieldValue": form.username};

            jQuery.getJSON('<?php echo admin_url("admin-ajax.php"); ?>', params,
                    function(response) {
                        console.log('ddddd');
                        if (response[1]) {
                            // Username isn't taken, let the form submit
                            return cb();
                        }
                        return cb({username: 'That username is taken'});
                    });
        }
    </script>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
