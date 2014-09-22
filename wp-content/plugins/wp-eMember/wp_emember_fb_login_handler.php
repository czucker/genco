<div id="fb-root"></div>
<script type="text/javascript">
    function login(response) {
        jQuery.get('<?php echo admin_url('admin-ajax.php'); ?>', {"action": "openid_login", "uid": response, 'type': 'facebook'},
        function(data) {
            if ((data.status == 1) || (data.status == 3))
                window.location.reload()
        },
                "json");
    }
    function logout() {
        jQuery.get('<?php echo admin_url('admin-ajax.php'); ?>', {"action": "openid_logout"},
        function(data) {
            if (data.status == 1)
                window.location.reload();
        },
                "json");
    }
    window.fbAsyncInit = function() {
        FB.init({appId: '<?php echo $emember_config->getValue('emember_fb_app_id'); ?>', status: true, cookie: true, xfbml: true});
        /* All the events registered */
        FB.Event.subscribe('auth.login', function(response) {
            // do something with response
            login(response.session.uid);
        });
        FB.Event.subscribe('auth.logout', function(response) {
            // do something with response
            logout();
        });

        FB.getLoginStatus(function(response) {
            if (response.session) {
                // logged in and connected user, someone you know
                //console.log('getStatus');
                login(response.session.uid);
            }
        });
    };
    (function() {
        var e = document.createElement('script');
        e.type = 'text/javascript';
        e.src = document.location.protocol +
                '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
    }());
</script>
<fb:login-button autologoutlink="true" perms="email,user_birthday,status_update,publish_stream"></fb:login-button>