
	<table class='wp-list-table widefat fixed unite_table_items'>
		<thead>
			<tr>
				<th width='20px'>ID</th>
				<th width='25%'>Name</th>
				<th width='120px'>Shortcode</th>				
				<th width='67%'>Actions</th>				
					
			</tr>
		</thead>
		<tbody>
			<?php foreach($arrSliders as $slider):
								
				$id = $slider->getID();
				$showTitle = $slider->getShowTitle();
				$title = $slider->getTitle();
				
				$alias = $slider->getAlias();
				$shortCode = $slider->getShortcode();			
				
				$editLink = self::getViewUrl(ShowBizAdmin::VIEW_SLIDER,"id=$id");
				$editSlidesLink = self::getViewUrl(ShowBizAdmin::VIEW_SLIDES,"id=$id");
				
				$showTitle = UniteFunctionsBiz::getHtmlLink($editLink, $showTitle);
				
			?>
				<tr>
					<td><?php echo $id?><span id="slider_title_<?php echo $id?>" class="hidden"><?php echo $title?></span></td>								
					<td><?php echo $showTitle?></td>
					<td><?php echo $shortCode?></td>
					<td>
						<a class="button-primary revgreen" href='<?php echo $editLink?>'><i class="revicon-cog"></i>Slider Settings</a>
						<a class="button-primary revblue" href='<?php echo $editSlidesLink ?>'><i class="revicon-pencil-1"></i>Edit Slides</a>						
						<a class="button-primary revred button_delete_slider" id="button_delete_<?php echo $id?>" href='javascript:void(0)' ><i class="revicon-trash"></i>Delete</a>
						<a class="button-primary revyellow button_duplicate_slider" id="button_duplicate_<?php echo $id?>" href='javascript:void(0)' ><i class="revicon-picture"></i>Duplicate</a>
						<div id="button_preview_<?php echo $id?>" class="button_slider_preview button-primary revgray" title="Preview <?php echo $title?>"><i class="revicon-search-1"></i></div>
					</td>

				</tr>							
			<?php endforeach;?>
			
		</tbody>		 
	</table>

	<?php require self::getPathTemplate("dialog_preview_slider");?>

	<script type="text/javascript">
		jQuery(document).ready(function(){
			ShowBizAdmin.initSlidersListView();
		});
	</script>

	