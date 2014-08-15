
	<div class="postbox box-slideslist">
		<h3>
			<span class='slideslist-title'>Slides List</span>
			<span id="saving_indicator" class='slideslist-loading'>Saving Order...</span>
		</h3>
		<div class="inside">
			<?php if(empty($arrSlides)):?>
			No Slides Found
			<?php endif?>
			
			
			<ul id="list_slides" class="list_slides ui-sortable">
			
				<?php foreach($arrSlides as $slide):
					
					$bgType = $slide->getParam("background_type","image");
					
					$order = $slide->getOrder();
					
					$urlImageForView = $slide->getUrlImageThumb();
					
					$slideTitle = $slide->getParam("title","Slide");
					$title = $slideTitle;
					
					$filename = $slide->getImageFilename();
					
					$imageAlt = stripslashes($slideTitle);
					if(empty($imageAlt))
						$imageAlt = "slide";
					
					if($bgType == "image" && !empty($filename))
						$title .= " ({$filename})";
					
					$slideid = $slide->getID();
					
					$urlEditSlide = self::getViewUrl(ShowBizAdmin::VIEW_SLIDE,"id=$slideid");
					$linkEdit = UniteFunctionsBiz::getHtmlLink($urlEditSlide, $title);
					
					$state = $slide->getParam("state","published");
					
				?>
					<li id="slidelist_item_<?php echo $slideid?>" class="ui-state-default">
					
						<span class="slide-col col-order">
							<span class="order-text"><?php echo $order?></span>
							<div class="state_loader" style="display:none;"></div>
							<?php if($state == "published"):?>
							<div class="icon_state state_published" data-slideid="<?php echo $slideid?>" title="Unpublish Slide"></div>
							<?php else:?>
							<div class="icon_state state_unpublished" data-slideid="<?php echo $slideid?>" title="Publish Slide"></div>
							<?php endif?>
							
						</span>
						
						<span class="slide-col col-name">
							<div class="slide-title-in-list"><?php echo $linkEdit?></div>

							<a class='button-primary revgreen' href='<?php echo $urlEditSlide?>' style="width:120px; "><i class="revicon-pencil-1"></i><?php _e("Edit Slide",SHOWBIZ_TEXTDOMAIN)?></a>
						</span>
						<span class="slide-col col-image">
							<?php if(!empty($urlImageForView)):?>
							
							<div id="slide_image_<?php echo $slideid?>" class="slide_image" title="Click to change the slide image." alt="<?php echo $imageAlt?>" style="background-image:url('<?php echo $urlImageForView?>')"></div>
							
							<?php else:?>
							
							<div id="slide_image_<?php echo $slideid?>" class="empty_slide_image" title="Click to set the slide image">
								No image, click to set.
							</div>
							
							<?php endif?>
						</span>
						
						<span class="slide-col col-operations">
	
							<a id="button_delete_slide_<?php echo $slideid?>" class='button-primary revred button_delete_slide ' style="width:120px; margin-top:8px !important" href='javascript:void(0)'><i class="revicon-trash"></i><?php _e("Delete",SHOWBIZ_TEXTDOMAIN)?></a>
							<span class="loader_round loader_delete" style="display:none;"><?php _e("Deleting Slide...",SHOWBIZ_TEXTDOMAIN)?></span>							

							<a id="button_duplicate_slide_<?php echo $slideid?>" class='button-primary revyellow button_duplicate_slide' href='javascript:void(0)' style="width:120px; " ><i class="revicon-picture"></i><?php _e("Duplicate",SHOWBIZ_TEXTDOMAIN)?></a>							
						</span>
						
						<span class="slide-col col-handle">
							<div class="col-handle-inside">
								<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
							</div>
						</span>	
						<div class="clear"></div>
					</li>
				<?php endforeach;?>
			</ul>
			
		</div>
	</div>