<?php
/** OTW Sidebar & Widget Manager Column Interface
  *
  */
?>
<div class="otw_sbm_column_dialog">
	<div class="otw_sbm_dialog_actions">
		<div class="alignleft">
			<input id="otw-sbm-pcm-btn-cancel" class="button" type="button" accesskey="C" value="<?php _e('Cancel', 'otw_sbm')?>" name="cancel">
		</div>
		<div class="alignright">
			<input id="otw-sbm-pcm-btn-insert" class="button-primary" type="button" accesskey="I" value="<?php _e('Insert', 'otw_sbm')?>" name="insert">
		</div>
	</div>
	<div class="otw_sbm_dialog_content">
		<div class="updated visupdated">
			<p>
				<?php _e( '1. Select the number of columns for that row from the dropdown.', 'otw_sbm' )?><br />
				<?php _e( '2. Then select the type of columns you want to have.', 'otw_sbm' )?><br />
				<?php _e( '3. Click "Insert" button', 'otw_sbm' )?>
			</p>
		</div>
		
		<div>
			<label for="otw_sbm_number_columns"><?php _e( 'Columns', 'otw_sbm' )?></label>
			<div class="otw_sbm_select_wrapper">
				<span><?php _e( 'Number of columns...', 'otw_sbm') ?></span>
				<select id="otw_sbm_number_columns">
					<option value="0"><?php _e( 'Number of columns...', 'otw_sbm') ?></option>
					<option value="1"><?php _e( '1 column', 'otw_sbm') ?></option>
					<option value="2"><?php _e( '2 columns', 'otw_sbm') ?></option>
					<option value="3"><?php _e( '3 columns', 'otw_sbm') ?></option>
					<option value="4"><?php _e( '4 columns', 'otw_sbm') ?></option>
					<option value="5"><?php _e( '5 columns', 'otw_sbm') ?></option>
					<option value="6"><?php _e( '6 columns', 'otw_sbm') ?></option>
				</select>
			</div>
		</div>
		<div id="otw_sbm_column_buttons">
			
		</div>
		<div id="otw_sbm_selected">
		</div>
		<div id="otw_sbm_pcm_insert_error" class="error viserror" style="display: none;">
			<?php _e( 'To be able to insert the row you need to have a full row of columns.', 'otw_sbm')?><br /><br />
			<?php _e( 'For example if you have selected 4 columns from the dropdown you need to select as many columns as needed to fill a FULL row.<br /><br />
				Those are correct:<br />
					&nbsp;&nbsp;&nbsp;&nbsp;4 columns = 1/4 + 1/4 + 1/4 + 1/4<br />
					&nbsp;&nbsp;&nbsp;&nbsp;4 columns = 1/4 + 1/4 + 2/4<br />
					&nbsp;&nbsp;&nbsp;&nbsp;4 columns = 2/4 + 2/4<br />
					&nbsp;&nbsp;&nbsp;&nbsp;4 columns = 1/4 + 3/4<br />
					&nbsp;&nbsp;&nbsp;&nbsp;4 columns = 4/4', 'otw_sbm')?><br /><br />
			<?php _e('Those are incorrect:<br />
					&nbsp;&nbsp;&nbsp;&nbsp;4 columns != 1/4 + 1/4 (!= means not equal)<br />
					&nbsp;&nbsp;&nbsp;&nbsp;4 columns != 3/4<br />
					&nbsp;&nbsp;&nbsp;&nbsp;4 columns != 1/4 + 1/2', 'otw_sbm')
			?>
		</div>

	</div>
	<script type="text/javascript">
		otw_sbm_init_column_dialog();
	</script>
</div>