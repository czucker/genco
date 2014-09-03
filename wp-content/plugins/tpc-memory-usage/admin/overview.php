<?php
/**
 * TPC! Memory Usage Overview
 * 
 * @package TPC_Memory_Usage
 */

if (!defined('ABSPATH'))
	die('-1');
?>

<div class="wrap">
<?php screen_icon('options-general'); ?>
<h2><?php echo esc_html('TPC! ' . $title); ?></h2>

<div id="tpcmem-overview-loading">
	<p><img src="<?php echo plugins_url('tpc-memory-usage/images/ajax-bar.gif'); ?>" /></p>
</div>

<?php
// Variable by reference for $_SERVER for simplification
$s = &$_SERVER;

// Complete security check
$security = tpcmem_check_security();

// Get MySQL variables and status
$mysql_status = tpcmem_get_mysql_status();
$mysql_vars = tpcmem_get_mysql_vars();
?>

<div id="tpcmem-overview-tabs" class="hidden">
	<ul>
		<li><a href="#tpcmem-server">Server</a></li>
		<li><a href="#tpcmem-php">PHP</a></li>
		<li><a href="#tpcmem-mysql">MySQL</a></li>
		<li><a href="#tpcmem-misc">WordPress</a></li>
		<li><a href="#tpcmem-security">Security</a></li>
	</ul>
	<div id="tpcmem-server">
		<table class="widefat fixed" cellspacing="0">
		<thead>
			<tr>
				<th scope="col" class="column-directive"><?php _e('Server Report'); ?></th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tfoot><tr><th colspan="2">&nbsp;</th></tr></tfoot>
		<tbody>
			<tr><th><?php esc_html_e('OS/Server:'); ?></th><td><?php echo esc_html(php_uname()); ?></td></tr>
			<?php if (function_exists('sys_getloadavg')): ?>
			<tr><th><?php esc_html_e('Load Averages:'); ?></th><td><?php echo tpcmem_colorized_loadavg(); ?></td></tr>
			<?php endif; ?>
			<tr><th><?php esc_html_e('Address:'); ?></th><td><?php echo esc_html($s['SERVER_ADDR']); ?></td></tr>
			<tr><th><?php esc_html_e('Name:'); ?></th><td><?php echo esc_html($s['SERVER_NAME']); ?></td></tr>
			<tr><th><?php esc_html_e('Software:'); ?></th><td><?php echo esc_html($s['SERVER_SOFTWARE']); ?></td></tr>
			<?php if (function_exists('apache_get_modules')): ?>
			<tr>
				<th><?php esc_html_e('Apache Modules:'); ?></th>
				<td>
					<span id="tpcmem-apache-loaded-modules-content" style="display: none;">
					<?php echo implode(', ', (array) apache_get_modules()); ?>
					</span><a href="javascript:void(0)" onclick="javascript:void(0)" id="tpcmem-apache-loaded-modules">View</a>
				</td>
			</tr>
			<?php endif; ?>
			<tr><th><?php esc_html_e('Protocol:'); ?></th><td><?php echo esc_html($s['SERVER_PROTOCOL']); ?></td></tr>
			<tr><th><?php esc_html_e('Document Root:'); ?></th><td><?php echo esc_html($s['DOCUMENT_ROOT']); ?></td></tr>
			<tr><th><?php esc_html_e('Client IP:'); ?></th><td><?php echo esc_html($s['REMOTE_ADDR']); ?></td></tr>
			<tr><th><?php esc_html_e('Client Hostname:'); ?></th><td><?php echo esc_html(gethostbyaddr($s['REMOTE_ADDR'])); ?></td></tr>
			<tr><th><?php esc_html_e('Client Port:'); ?></th><td><?php echo esc_html($s['REMOTE_PORT']); ?></td></tr>
			<tr><th><?php esc_html_e('Server Admin:'); ?></th><td><?php echo esc_html($s['SERVER_ADMIN']); ?></td></tr>
			<tr><th><?php esc_html_e('Server Port:'); ?></th><td><?php echo esc_html($s['SERVER_PORT']); ?></td></tr>
			<tr><th><?php esc_html_e('Server Signature:'); ?></th><td><?php echo trim($s['SERVER_SIGNATURE']) == '' ? 'OFF' : esc_html($s['SERVER_SIGNATURE']); ?></td></tr>
		</tbody>
		</table>
	</div>
	<div id="tpcmem-php">
		<table class="widefat fixed" cellspacing="0">
		<thead>
			<tr>
				<th scope="col" class="column-directive"><?php _e('PHP Report'); ?></th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tfoot><tr><th colspan="2">&nbsp;</th></tr></tfoot>
		<tbody>
			<tr>
				<th><?php esc_html_e('PHP Version:'); ?></th>
				<td><?php echo esc_html(PHP_VERSION); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('Zend Engine:'); ?></th>
				<td><?php echo esc_html(zend_version()); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('PHP Memory Limit:'); ?></th>
				<td><?php echo esc_html(get_cfg_var('memory_limit')); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('Memory Usage Sampling:'); ?></th>
				<td><?php echo esc_html(size_format(memory_get_usage(), 2)); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('Loaded Extensions:'); ?></th>
				<td>
					<span id="tpcmem-php-loaded-extensions-content" style="display: none;">
					<?php echo esc_html(implode(', ', get_loaded_extensions())); ?>
					</span><a href="javascript:void(0)" onclick="javascript:void(0)" id="tpcmem-php-loaded-extensions">View</a>
				</td>
			</tr>
			<tr>
				<th><?php esc_html_e('PHP Include Path:')?></th>
				<td><?php echo esc_html(get_include_path()); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('Maximum Upload:'); ?></th>
				<td><?php echo esc_html(ini_get('upload_max_filesize')); ?></td>
			</tr>
		</tbody>
		</table>
	</div>

	<div id="tpcmem-mysql">
		<table class="widefat fixed" cellspacing="0">
		<thead>
			<tr>
				<th scope="col" class="column-directive"><?php _e('MySQL Report'); ?></th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tfoot><tr><th colspan="2">&nbsp;</th></tr></tfoot>
		<tbody>
			<tr>
				<th><?php esc_html_e('Database:'); ?></th>
				<td><?php echo $mysql_vars['version_comment']; ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('Version:'); ?></th>
				<td><?php echo $mysql_vars['version']; ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('Uptime:'); ?></th>
				<td><?php echo tpcmem_get_mysql_uptime_string($mysql_status['Uptime']); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('Hostname:'); ?></th>
				<td><?php echo $mysql_vars['hostname']; ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('DATE Format:'); ?></th>
				<td><?php echo $mysql_vars['date_format']; ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('DATETIME Format:'); ?></th>
				<td><?php echo $mysql_vars['datetime_format']; ?></td>
			</tr>
		</tbody>
		</table>
	</div>
	<div id="tpcmem-misc">
		<table class="widefat fixed" cellspacing="0">
		<thead>
			<tr>
				<th scope="col" class="column-directive"><?php _e('WordPress Report'); ?></th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tfoot><tr><th colspan="2">&nbsp;</th></tr></tfoot>
		<tbody>
			<tr>
				<th><?php esc_html_e('WordPress Version:'); ?></th>
				<td><?php global $wp_version; echo $wp_version; ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('WordPress Memory Limit:'); ?></th>
				<td><?php echo esc_html(WP_MEMORY_LIMIT); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('WordPress DB Hostname:'); ?></th>
				<td><?php echo esc_html(DB_HOST); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('WordPress Database Name:'); ?></th>
				<td><?php echo esc_html(DB_NAME); ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('WordPress Language:'); ?></th>
				<td><?php echo defined('WPLANG') && WPLANG != '' ? WPLANG : 'English'; ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('Auto-Save Interval:'); ?></th>
				<td><?php echo (int) AUTOSAVE_INTERVAL . ' seconds'; ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('Query Logging:'); ?></th>
				<td><?php echo defined('SAVEQUERIES') && SAVEQUERIES ? 'Yes' : 'No'; ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('Debugging:'); ?></th>
				<td><?php echo defined('WP_DEBUG') && WP_DEBUG ? 'Yes' : 'No'; ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('Advanced Caching:'); ?></th>
				<td><?php echo defined('WP_CACHE') && WP_CACHE ? 'Yes' : 'No'; ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('External Object Cache:'); ?></th>
				<td><?php global $_wp_using_ext_object_cache; echo $_wp_using_ext_object_cache ? 'Yes' : 'No'; ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('Alternate Cron:'); ?></th>
				<td><?php echo defined('ALTERNATE_WP_CRON') && ALTERNATE_WP_CRON ? 'Yes' : 'No'; ?></td>
			</tr>
			<?php if (defined('TEMPLATEPATH')): ?>
			<tr>
				<th><?php esc_html_e('Template Path:'); ?></th>
				<td><?php echo TEMPLATEPATH; ?></td>
			</tr>
			<?php endif; ?>
			<?php if (defined('STYLESHEETPATH')): ?>
			<tr>
				<th><?php esc_html_e('Stylesheet Path:'); ?></th>
				<td><?php echo STYLESHEETPATH; ?></td>
			</tr>
			<?php endif; ?>
			<?php if (defined('EMPTY_TRASH_DAYS')): ?>
			<tr>
				<th><?php esc_html_e('Empty Trash Days:'); ?></th>
				<td><?php echo EMPTY_TRASH_DAYS; ?></td>
			</tr>
			<?php endif; ?>
			<tr>
				<th><?php esc_html_e('JavaScript Compression:'); ?></th>
				<td><?php echo defined('COMPRESS_SCRIPTS') && COMPRESS_SCRIPTS ? 'Yes' : 'No'; ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('CSS Compression:'); ?></th>
				<td><?php echo defined('COMPRESS_CSS') && COMPRESS_CSS ? 'Yes' : 'No'; ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('GZip Compression:'); ?></th>
				<td><?php echo defined('ENFORCE_GZIP') && ENFORCE_GZIP ? 'Yes' : 'No'; ?></td>
			</tr>
			<tr>
				<th><?php esc_html_e('JavaScript Concatenation:'); ?></th>
				<td><?php echo defined('CONCATENATE_SCRIPTS') && CONCATENATE_SCRIPTS ? 'Yes' : 'No'; ?></td>
			</tr>
		</tbody>
		</table>
	</div>
	<div id="tpcmem-security">
	<table class="widefat fixed" cellspacing="0">
	<thead>
		<tr>
			<th scope="col" class="column-directive">Security Check</th>
			<th>Recommendation</th>
		</tr>
	</thead>
	<tfoot><tr><th colspan="2">&nbsp;</th></tr></tfoot>
	<tbody>
		<tr>
			<th>allow_url_fopen</th>
			<td>
				<?php if ($security['allow_url_fopen']): ?>
				<div class="msgWarning">
				<p>The <strong>allow_url_fopen</strong> directive is set to ON.  It is recommended that you disable
				allow_url_fopen in the <em>php.ini</em> file for security reasons.  This allows PHP file functions, such as 
				<code>include</code>, <code>require</code>, and <code>file_get_contents()</code>, to retrieve data from remote 
				locations (Example: FTP, web site).  According to PHP Security Consortium, a large number of code injection 
				vulnerabilities are caused by the combination of enabling allow_url_fopen, and bad input filtering.</p>
				</div>
				<?php else: ?>
				<div class="msgSuccess">
				<p>The <strong>allow_url_fopen</strong> directive is set to OFF.  This disallows PHP file functions, such as 
				<code>include</code>, <code>require</code>, and <code>file_get_contents()</code>, from retrieving data from remote 
				locations (Example: FTP, web site).  According to PHP Security Consortium, a large number of code injection 
				vulnerabilities are caused by the combination of enabling allow_url_fopen, and bad input filtering.</p>
				</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>allow_url_include</th>
			<td>
				<?php if ($security['allow_url_include']): ?>
				<div class="msgError">
				<p>The <strong>allow_url_include</strong> directive is set to ON.  <code>allow_url_include</code> allows 
				remote file access via <code>include</code> and <code>require</code>.  We <em>strongly</em> recommend 
				disabling this functionality, as <code>include</code> and <code>require</code> are the most common attack 
				points for code injection attempts.</p>
				</div>
				<?php else: ?>
				<div class="msgSuccess">
				<p>The <strong>allow_url_include</strong> directive is set to OFF.  This disables remote file access 
				via <code>include</code> and <code>require</code>.  <code>include</code> and <code>require</code> are the 
				most common attack points for code injection attempts.</p>
				</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>display_errors</th>
			<td>
				<?php if ($security['display_errors'] == '1'): ?>
				<div class="msgError">
				<p>The <strong>display_errors</strong> setting in <em>php.ini</em> is set to ON.  This means that PHP errors, and 
				warnings are being displayed. Such warnings can cause sensitive information to be revealed to users (paths, database 
				queries, etc.).</p>
				</div>
				<?php else: ?>
				<div class="msgSuccess">
				<p>The <strong>display_errors</strong> setting in <em>php.ini</em> is set to OFF.  This is the proper setting for a 
				production environment.</p>
				</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>magic_quotes_gpc</th>
			<td>
				<?php if ($security['magic_quotes_gpc']): ?>
				<div class="msgWarning">
				<p><strong>Magic Quotes</strong> is set to ON. This feature has been depreciated as of PHP 5.3 and removed as of PHP 
				6.0. Relying on this feature is highly discouraged. It is preferred to code with magic quotes off and to instead 
				escape the data at runtime, as needed.</p>
				</div>
				<?php else: ?>
				<div class="msgSuccess">
				<p><strong>Magic Quotes</strong> is set to OFF. This is the proper setting for any environment.</p>
				</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>ModSecurity</th>
			<td>
				<?php if (!$security['mod_security']): ?>
				<div class="msgWarning">
				<p><strong>mod_security</strong> for Apache is not installed. ModSecurity can help protect your server against SQL 
				injections, XSS attacks, and a variety of other attacks. The Apache module is available for free at 
				<a href="http://www.modsecurity.org" title="ModSecurity">http://www.modsecurity.org</a>.</p>
				</div>
				<?php elseif ('N/A' === $security['mod_security']): ?>
				<div class="msgWarning">
				<p>Unable to determine if <strong>mod_security</strong> for Apache is installed. This can happen if a host uses 
				a different name for the Apache module, or if the <em>apache_get_modules()</em> function is not available in your 
				PHP installation. ModSecurity can help protect your server against SQL injections, XSS attacks, and a variety of 
				other attacks. The Apache module is available for free at 
				<a href="http://www.modsecurity.org" title="ModSecurity">http://www.modsecurity.org</a>.</p>
				</div>
				<?php else: ?>
				<div class="msgSuccess">
				<p><strong>mod_security</strong> for Apache is installed and actively protecting your web server.</p>
				</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>open_basedir</th>
			<td>
				<?php if (!$security['open_basedir']): ?>
				<div class="msgWarning">
				<p>The <strong>open_basedir</strong> directive is not set. <code>open_basedir</code>, set in <em>php.ini</em>, 
				limits the PHP process from accessing files outside of the specified directories.  It is strongly 
				suggested that you set <code>open_basedir</code> to your web site documents and shared libraries 
				<em>only</em>.</p>
				</div>
				<?php else: ?>
				<div class="msgSuccess">
				<p>The <strong>open_basedir</strong> directive is set to <code><?php echo @ini_get('open_basedir'); ?></code>. 
				<code>open_basedir</code>, set in <em>php.ini</em> limits the PHP process from accessing files outside of 
				the specified directories.</p>
				</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>register_globals</th>
			<td>
				<?php if ($security['register_globals']): ?>
				<div class="msgError">
				<p>The <strong>register_globals</strong> setting in <em>php.ini</em> is set to ON.  This feature has been depreciated 
				as of PHP 5.3 and removed as of PHP 6.0.  Relying on this feature is <em>highly</em> discouraged.</p>
				</div>
				<?php else: ?>
				<div class="msgSuccess">
				<p>The <strong>register_globals</strong> setting in <em>php.ini</em> is set to OFF.</p>
				</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>safe_mode</th>
			<td>
				<?php if ($security['safe_mode']): ?>
				<div class="msgWarning">
				<p>The <strong>safe_mode</strong> setting in <em>php.ini</em> is set to ON.  This feature is depreciated in PHP 5.3 
				and is removed in PHP 6.0.  Relying on this feature is architecturally incorrect, as this should not be solved at 
				the PHP level.</p>
				</div>
				<?php else: ?>
				<div class="msgSuccess">
				<p>The <strong>safe_mode</strong> setting in <em>php.ini</em> is set to OFF.  While relying on this feature is 
				architecturally incorrect because this should not be solved at the PHP level, many ISP's still use safe mode in 
				shared hosting situations due to limitations at the level the web server and OS.</p>
				</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>ServerSignature</th>
			<td>
				<?php if ($security['server_signature']): ?>
				<div class="msgWarning">
				<p>Apache's <strong>ServerSignature</strong> directive is set to ON. This means that your server software version, and 
				other important details are public, which can give hackers information necessary to exploit version and software-specific 
				vulnerabilities.</p>
				</div>
				<?php else: ?>
				<div class="msgSuccess">
				<p>Apache's <strong>ServerSignature</strong> directive is set to OFF. This prevents hackers from gaining information 
				that could help them exploit vulnerabilities based on your specific server software version.</p>
				</div>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>WP Unique Keys</th>
			<td>
				<?php if (tpcmem_check_unique_keys()): ?>
				<div class="msgSuccess">
				<p>The WordPress <strong>secret keys</strong> located in <em>wp-config.php</em> are defined.  These help add an extra 
				level of protection against hackers.  The secret keys can be changed at any time to invalidate all existing cookies, 
				which will also require users to login again.</p>
				</div>
				<?php else: ?>
				<div class="msgError">
				<p>Some of all of the WordPress <strong>secret keys</strong> located in <em>wp-config.php</em> are not defined.  WP's secret keys make your site harder to hack and access 
				by adding random elements to the password.  These keys don't have to be committed to memory, they just have to be long 
				and complicated.  The easiest way to obtain a set of secret keys is to use the 
				<a href="https://api.wordpress.org/secret-key/1.1/" title="WP Online Generator" rel="external">online generator</a>. 
				The secret keys can be changed at any time to invalidate all existing cookies, which will also require users to login again.</p>
				</div>
				<?php endif; ?>
			</td>		
		</tr>
	</tbody>
	</table>
	</div>
</div>

<p id="tpc-footer-text">Brought to you by Chris Strosser @ <a href="http://webjawns.com/">webjawns.com</a></p>
</div>