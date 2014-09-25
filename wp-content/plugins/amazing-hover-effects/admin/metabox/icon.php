<?php
 
function add_menu_icons_styles(){
?>
 
<style>
#adminmenu .menu-icon-hover-effect div.wp-menu-image:before {
content: '\f105';
}
</style>
 
<?php
}
add_action( 'admin_head', 'add_menu_icons_styles' );
?>