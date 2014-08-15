
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
			
				<?php foreach($arrSlides as $index=>$slide):
					
					$bgType = $slide->getParam("background_type","image");
					
					if($sortBy == UniteFunctionsWPBiz::SORTBY_MENU_ORDER)
						$order = $slide->getOrder();
					else
						$order = $index + 1;
					
					$urlImageForView = $slide->getUrlImageThumb();					
						
					$slideTitle = $slide->getParam("title","Slide");
					$title = $slideTitle;
					$filename = $slide->getImageFilename();
					
					$imageAlt = stripslashes($slideTitle);
					if(empty($imageAlt))
						$imageAlt = "slide";
					
					if($bgType == "image" && !empty($filename))
						$title .= " ({$filename})";
					
					$postID = $slide->getID();
					
					$urlEditSlide = UniteFunctionsWPBiz::getUrlEditPost($postID);
					
					$linkEdit = UniteFunctionsBiz::getHtmlLink($urlEditSlide, $title,"","",true);
					
					$state = $slide->getParam("state","published");
					
				?>
					<li id="slidelist_item_<?php echo $postID?>" class="ui-state-default">
					
						<span class="slide-col col-order">
							<span class="order-text"><?php echo $order?></span>
							<div class="state_loader" style="display:none;"></div>
							<?php if($state == "published"):?>
							<div class="icon_state state_published" data-slideid="<?php echo $postID?>" title="Unpublish Slide"></div>
							<?php else:?>
							<div class="icon_state state_unpublished" data-slideid="<?php echo $postID?>" title="Publish Slide"></div>
							<?php endif?>
							
						</span>
						
						<span class="slide-col col-name">
							<div class="slide-title-in-list"><?php echo $linkEdit?></div>

							<a class='button-primary revgreen' href='<?php echo $urlEditSlide?>' style="width:120px; "><i class="revicon-pencil-1"></i><?php _e("Edit Post",SHOWBIZ_TEXTDOMAIN)?></a>
						</span>
						<span class="slide-col col-image">
							
							<?php if(!empty($urlImageForView)):?>
							<div id="slide_image_<?php echo $postID?>" class="slide_image" title="Click to change the slide image. Note: The post featured image will be changed." alt="<?php echo $imageAlt?>" style="background-image:url('<?php echo $urlImageForView?>')"></div>
							<?php else:?>
							no image 
							<?php endif?>
							
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