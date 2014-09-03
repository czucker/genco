(function($) {
	$(document).ready(function() {
		$('#tpc_memory_usage_more_button a').click(function() {
			$('#tpc_memory_usage_more').slideDown('normal');
			$('#tpc_memory_usage_more_button').fadeOut('normal', function() {
				$('#tpc_memory_usage_hide_button').fadeIn();
			});
		});
	
		$('#tpc_memory_usage_hide_button a').click(function() {
			$('#tpc_memory_usage_more').slideUp('normal');
			$('#tpc_memory_usage_hide_button').fadeOut('normal', function() {
				$('#tpc_memory_usage_more_button').fadeIn();
			});
		});
		
		$('#tpcmemAddCheckpoint').click(function() {
			window.location.href = 'admin.php?page=tpcmem-checkpoint';
		});
		
		$('#tpcmemRefreshCheckpoints').click(function() {
			if (confirm('CAUTION! \n\r\n\rThis will erase ALL checkpoints, including those custom added, and repopulate the default checkpoints. \n\r\n\rAre you sure you want to continue?')) {
				window.location.href = 'admin.php?page=tpcmem-checkpoint-manager&action=refresh&_wpnonce=' + $('#refreshCheckpointsNonce').val();
			}
		});
	});
})(jQuery);