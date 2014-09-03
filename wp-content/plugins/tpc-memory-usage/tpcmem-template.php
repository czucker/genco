<?php
/**
 * TPC! Memory Usage Template API
 *
 * @package TPC_Memory_Usage
 * @subpackage Template
 */

if (!defined('ABSPATH'))
	die('-1');

/**
 * Display memory usage details inside HTML comment.
 *
 * @return void
 */
function tpcmem_display_comments() {
	global $tpcmem;
?>

<!--
TPC! Memory Usage (http://webjawns.com)
<?php echo 'Memory Usage: ' . esc_html(apply_filters('tpcmem_mb_suffix', $tpcmem->current())) . "\r"; ?>
<?php echo 'Memory Peak Usage: ' . esc_html(apply_filters('tpcmem_mb_suffix', $tpcmem->peak())) . "\r"; ?>
<?php echo 'WP Memory Limit: ' . esc_html(WP_MEMORY_LIMIT) . "\r"; ?>
<?php echo 'PHP Memory Limit: ' . esc_html($tpcmem->phpLimit()) . "\r"; ?>
<?php echo 'Checkpoints: ' . (int) $tpcmem->count() . "\r"; ?>
-->

<?php
}

/**
 * Display memory usage details within admin panel footer.
 *
 * @return string The HTML for the admin panel footer.
 */
function tpcmem_admin_footer($html) {
	global $tpcmem;

	if (get_option('tpc_memory_usage_admin_footer'))
		return $html . ' | Memory Usage: ' . apply_filters('tpcmem_mb_suffix', tpcmem_graph_peak_or_current()) . '/' . @ini_get('memory_limit');

	return $html;
}

function tpcmem_display_dashboard_widget() {
	global $tpcmem;

	add_action('admin_footer', 'tpcmem_dashboard_widget_js');

	// Get current/peak usage
	$current = $tpcmem->current();
	$peak = $tpcmem->peak();

	// Make percentages out of current/peak usage
	$currentPercentage = apply_filters('tpcmem_percent_of_limit', $current);
	$peakPercentage = apply_filters('tpcmem_percent_of_limit', $peak);

	switch (get_option('tpc_memory_usage_graph')) {
		case 'current':
			$gPercent = $currentPercentage;
			break;
		case 'peak':
			$gPercent = $peakPercentage;
			break;
		default:
			$gPercent = false;
			break;
	}

	if ($gPercent) {
		$gColor = '#1c6280';
		$gColor = $gPercent > 70 ? '#cccc00' : $gColor;
		$gColor = $gPercent > 90 ? '#cc0000' : $gColor;
	}
?>
<ul>
	<li>
		<strong><?php esc_html_e('Usage Sample'); ?></strong>:
		<span><?php echo esc_html( tpcmem_bytes_to_mb($current) . 'MB' ); ?></span>
		<span style='color: <?php echo $gColor; ?>;'>(<?php echo $currentPercentage; ?>%)</span>
	</li>
	<li>
		<strong><?php esc_html_e('Peak Usage'); ?></strong>:
		<span><?php echo esc_html( tpcmem_bytes_to_mb($peak) . 'MB' ); ?></span>
		<span style='color: <?php echo $gColor; ?>;'>(<?php echo $peakPercentage; ?>%)</span>
	</li>
	<?php if ( 'high' == get_option('tpc_memory_usage_log') && $highest_usage = get_option('tpc_memory_usage_log_highest') ): ?>
	<li>
		<strong><?php esc_html_e('All-Time'); ?></strong>:
		<span>
			<?php echo esc_html( tpcmem_bytes_to_mb($highest_usage['usage']) . 'MB on ' . date('n/j/y @ g:i a', $highest_usage['time']) ); ?>
			<?php echo isset($highest_usage['checkpoint_action']) && trim($highest_usage['checkpoint_action']) != '' ? "({$highest_usage['checkpoint_action']})" : ''; ?>
		</span>
	<?php endif; ?>

	<?php if (function_exists('sys_getloadavg')): ?>
	<li><strong><?php esc_html_e('Load Averages'); ?></strong>: <?php echo tpcmem_colorized_loadavg(); ?></li>
	<?php endif; ?>

	<li><strong><?php esc_html_e('WP Memory Limit'); ?></strong>: <span><?php echo esc_html(WP_MEMORY_LIMIT); ?></span></li>
	<li><strong><?php esc_html_e('PHP Memory Limit'); ?></strong>: <span><?php echo esc_html($tpcmem->phpLimit()); ?></span></li>
</ul>

<?php if ( false !== $gPercent ): ?>
<div class="progressbar">
    <div class="widget" id="tpcmem_pbar_wrap">
    <div class="widget" id="tpcmem_pbar" style="width: <?php echo $gPercent; ?>%; background: <?php echo $gColor; ?>;">
    <div id="tpcmem_pbar_percent"><?php echo $gPercent; ?>%</div>
    </div><!-- #tpcmem_pbar -->
    </div><!-- #tpcmem_pbar_wrap -->
</div><!-- #progressbar -->
<?php endif; ?>

<p style="font-size: 9px;">
	<a href="admin.php?page=tpc-memory-usage" title="System Overview">System Overview</a> |
	<span id="tpc_memory_usage_more_button"><a href="javascript:void(0)">More...</a></span>
	<span id="tpc_memory_usage_hide_button" class="hidden"><a href="javascript:void(0)">Hide...</a></span>
</p>

<div id="tpc_memory_usage_more" class="hidden">
<ul>
	<li><strong><?php esc_html_e('PHP Version'); ?></strong>: <span><?php echo esc_html(PHP_VERSION); ?></span></li>
	<li><strong><?php esc_html_e('Server Software'); ?></strong>: <span><?php echo esc_html($_SERVER['SERVER_SOFTWARE']); ?></span></li>
	<li><strong><?php esc_html_e('User Agent'); ?></strong>: <span><?php echo esc_html($_SERVER['HTTP_USER_AGENT']); ?></span></li>
</ul>
</div>
<?php
}

function tpcmem_dashboard_widget_js() {
	wp_print_scripts(array('tpcmem'));
}

/**
 * Retrieve paginator for given results.
 *
 * @param array $results Array to generate paginator for.
 * @param int $currentPage The current page of results.
 * @param int $itemsPerPage The number of items to show per page.
 * @return Zend_Paginator
 */
function tpcmem_initialize_paginator($results, $currentPage = 1, $itemsPerPage = 20) {
	if (!is_array($results))
		return false;

	/** Zend_Paginator */
	require_once 'Zend/Paginator.php';

	if (!$itemsPerPage)
		$itemsPerPage = 20;

	$paginator = Zend_Paginator::factory($results);
	$paginator->setCurrentPageNumber($currentPage);
	$paginator->setItemCountPerPage($itemsPerPage);
	$paginator->setPageRange(7);

	return $paginator;
}

function tpcmem_generate_paginator(Zend_Paginator $paginator) {
	$pc = $paginator->getPages(); ?>

<?php if ($pc->pageCount): ?>
<div class="tablenav">
<div class="tablenav-pages">

<span class="displaying-num">
	Displaying <?php echo (int) $pc->firstItemNumber; ?>&#8211;<?php echo (int) $pc->lastItemNumber; ?>
	of <?php echo (int) $pc->totalItemCount; ?>
</span>

<?php // First page link ?>
<?php if (isset($pc->first)): ?>
	<a class="prev page-numbers" href="<?php echo tpcmem_paginator_url($pc->first); ?>">&laquo;</a>
<?php endif; ?>

<?php // Numbered page links ?>
<?php foreach ($pc->pagesInRange as $page): ?>
	<?php if ($page != $pc->current): ?>
		<a class="page-numbers" href="<?php echo tpcmem_paginator_url($page); ?>"><?php echo $page; ?></a>
	<?php else: ?>
		<span class="page-numbers current"><?php echo $page; ?></span>
	<?php endif; ?>
<?php endforeach; ?>

<?php // Last page link ?>
<?php if (isset($pc->last)): ?>
	<a class="next page-numbers" href="<?php echo tpcmem_paginator_url($pc->last); ?>">&raquo;</a>
<?php endif; ?>

<?php // Previous page link ?>
<?php if (isset($pc->previous)): ?>
	<a class="prev page-numbers" href="<?php echo tpcmem_paginator_url($pc->previous); ?>"><?php esc_html_e('Previous'); ?></a>
<?php endif; ?>

<?php // Next page link ?>
<?php if (isset($pc->next)): ?>
	<a class="next page-numbers" href="<?php echo tpcmem_paginator_url($pc->next); ?>"><?php esc_html_e('Next'); ?></a>
<?php endif; ?>

</div>
</div>
<?php endif; ?>

<?php
}

function tpcmem_paginator_url($page = '') {
	$location = admin_url('admin.php');
	$location = add_query_arg('page', $_GET['page'], $location);
	$location = add_query_arg('p', (int) $page, $location);
	return $location;
}

function tpcmem_priority_text($priority) {
	switch ($priority) {
		case Tpcmem_Log::LOG_CRIT:
			$text = 'Critical';
			break;
		case Tpcmem_Log::LOG_INFO:
			$text = 'Normal';
			break;
	}

	return __($text);
}

function tpcmem_dropdown_items_per_page($selected = false) {
	foreach (array(10, 25, 50, 100, 200) as $numItems) {
		if ($selected == $numItems)
			$default = "<option value='{$numItems}' selected='selected'>{$numItems} per page</options>\r\n";
		else
			$options .= "<option value='{$numItems}'>{$numItems}</options>\r\n";
	}

	echo $default . $options;
}

function tpcmem_dropdown_checkpoint_actions($selected = false) {
	$d = $o = '';

	$actions = tpcmem_get_distinct_logged_checkpoints();
	if (!is_array($actions))
		return;

	foreach ($actions as $action) {
		$action = esc_attr($action);
		if ($selected === $action)
			$d = "<option value='{$action}' selected='selected'>{$action}</options>\r\n";
		else
			$o .= "<option value='{$action}'>{$action}</options>\r\n";
	}

	echo $d . $o;
}

/**
 * Display colorized load averages using sys_getloadavg().
 *
 * The sys_getloadavg() function only works on Linux systems.
 *
 * @return string|bool
 */
function tpcmem_colorized_loadavg() {
	if (!function_exists('sys_getloadavg'))
		return false;

	$avgs = sys_getloadavg();
	if (!is_array($avgs))
		return false;

	$colorized = '';
	foreach ($avgs as $avg) {
		if ($avg >= 2 && $avg < 3) {
			$class = 'tpcmemCpuMedium';
		} elseif ($avg >= 3) {
			$class = 'tpcmemCpuHigh';
		} else {
			$class = 'tpcmemCpuLow';
		}

		$colorized .= ' <span class="' . $class . '">' . $avg . '</span>';
	}

	return $colorized;
}