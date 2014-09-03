/**
 * TPC! Memory Usage Overview
 * 
 * @package TPC_Memory_Usage
 * @subpackage Administration
 */
(function($) {
	$(document).ready(function() {
		$("#tpcmem-overview-tabs").tabs({
			fx: { opacity: 'toggle' }
		});

		$("#tpcmem-overview-loading").slideUp("slow");
		$("#tpcmem-overview-tabs").slideDown("slow");

		$("#tpcmem-php-loaded-extensions").click(function() {
			if ($(this).html() == 'Hide') {
				$('#tpcmem-php-loaded-extensions-content').fadeOut();
				$(this).html('Show');
			} else {
				$('#tpcmem-php-loaded-extensions-content').fadeIn();
				$(this).html('Hide');
			}
		});
		
		$("#tpcmem-apache-loaded-modules").click(function() {
			if ($(this).html() == 'Hide') {
				$('#tpcmem-apache-loaded-modules-content').fadeOut();
				$(this).html('Show');
			} else {
				$('#tpcmem-apache-loaded-modules-content').fadeIn();
				$(this).html('Hide');
			}
		});
	});
})(jQuery);