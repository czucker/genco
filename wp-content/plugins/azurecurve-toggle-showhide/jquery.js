jQuery(document).ready(function(){
	jQuery(".azc_tsh_toggle_container").hide();
	jQuery(".azc_tsh_toggle").click(function() {
		jQuery(this).toggleClass("azc_tsh_toggle_active").next().slideToggle('fast');
		return false;
	});
});