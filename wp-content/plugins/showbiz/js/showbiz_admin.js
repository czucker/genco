var ShowBizAdmin = new function(){
	
		var t = this;
		var g_isSlidesFromPost = false;
		var g_codemirrorHtml = null;
		var g_codemirrorCss = null;
		var g_postTypesWithCats = null;
		
		
	//custom colors highlighting.
	CodeMirror.defineMode("customcolors", function(config, parserConfig) {
		  var mustacheOverlay = {
		    token: function(stream, state) {
		      var ch;
		      
		      if (stream.match("[")) {
		    	var word = "";
		        while ((ch = stream.next()) != null){
		          if (ch == "]"){
		        	  
		        	  var buttons = jQuery("#template_custom_options_wrapper a.button-option");
		        	  
		        	  for(var i=0,len=buttons.length;i<len;i++){
		        		  var placeholder = jQuery(buttons[i]).data("placeholder");
		        		  if(placeholder == word)
		        			  return("custom-button");		        		  
		        	  }
	        	 	  return "default-button";
		        	 
		        	 
		          }else
		        	  word += ch;
		        }
		      }
		      
		      while (stream.next() != null && !stream.match("[", false)) {}
		      	return null;
		    }
		  };
		  return CodeMirror.overlayMode(CodeMirror.getMode(config, parserConfig.backdrop || "text/html"), mustacheOverlay);
		});
		
	
		/**
		 * set code mirror editor for html
		 */
		t.setCodeMirrorEditor = function(type){
			
			if(type == "html"){
				
				g_codemirrorHtml = CodeMirror.fromTextArea(document.getElementById("textarea_content"), {
					mode: {name: "customcolors", alignCDATA: true},
			        lineNumbers: true				
				});
				
			}else{
				
				g_codemirrorCss = CodeMirror.fromTextArea(document.getElementById("textarea_css"), {
					mode: {name: "css"},
			        lineNumbers: true
				});
				
			}
		}
		
		/**
		 * init "templates view"
		 */
		this.initTemplatesView = function(templateType,templatePrefix){
			
			//create template
			jQuery("#button_create_template").click(function(){
				var data = {};
				data.type = templateType;
				data.prefix = templatePrefix;
				
				UniteAdminBiz.ajaxRequest("create_template",data,function(){
					location.reload();
				});
			});
			
			// delete template
			jQuery("#list_templates .button_delete_template").click(function(){
				if(confirm("Do you sure you want to delete this template?") == false)
					return(true);
				
				var data = {templateID:jQuery(this).data("id")};
				
				UniteAdminBiz.ajaxRequest("delete_template",data,function(){
					location.reload();
				});
				
			});

			// duplicate template
			jQuery("#list_templates .button_duplicate_template").click(function(){
				
				var data = {templateID:jQuery(this).data("id")};
				
				UniteAdminBiz.ajaxRequest("duplicate_template",data,function(){
					location.reload();
				});
				
			});

			//restore template
			jQuery("#list_templates .button_restore_template").click(function(){
				
				var templateID = jQuery(this).data("id");
				
				jQuery("#dialog_restore").dialog({
					modal:true,
					resizable:true,
					width:400,
					height:200,
					closeOnEscape:true,
					buttons:{
						"Close":function(){
							jQuery("#dialog_restore").dialog("close");
						},
						"Restore":function(){
							
							var data = {};
							data.templateID = templateID;
							data.original_name = jQuery("#original_template").val();
							
							UniteAdminBiz.ajaxRequest("restore_original_template",data,function(response){
								jQuery("#dialog_restore").dialog("close");
							});	
							
						}
					}
				
				}); //dialog restore				
				
				
			});
			
			// rename template
			jQuery("#list_templates .button_rename_template").click(function(){
				
				var title = jQuery(this).data("title");
				var templateID = jQuery(this).data("id")
				
				jQuery("#template_title").val(title).focus();
				
				jQuery("#dialog_rename").dialog({
					modal:true,
					resizable:true,
					width:400,
					height:200,
					closeOnEscape:true,
					buttons:{
						"Close":function(){
							jQuery("#dialog_rename").dialog("close");
						},
						"Update":function(){
							
							var data = {};
							data.templateID = templateID;
							data.title = jQuery("#template_title").val();
							
							UniteAdminBiz.ajaxRequest("update_template_title",data,function(response){
								jQuery("#dialog_rename").dialog("close");
								location.reload(true);
							});	
							
						}
					}
				
				}); //dialog open				
			}); //rename tempalte end
			
			
			// edit content
			jQuery("#list_templates .button_edit_content").click(function(){
				var templateID = jQuery(this).data("id")
				var templateTitle = jQuery(this).data("title")
				
				var data = {templateID:templateID};
				
				var objLoader = jQuery(this).siblings(".loader_edit_contents");
				objLoader.show();
				
				UniteAdminBiz.ajaxRequest("get_template_content",data,function(response){
					
					objLoader.hide();
										
					jQuery("#dialog_content").dialog({
						title:"Edit Template Html: " + templateTitle,
						modal:true,
						resizable:true,
						minWidth:960,
						minHeight:500,
						closeOnEscape:true,
						buttons:{
							"Close":function(){
								jQuery("#dialog_content").dialog("close");
							},
							"Update":function(){
								
								var data = {};
								data.templateID = templateID;
								
								if(g_codemirrorHtml != null)
									data.content = g_codemirrorHtml.getValue();
								else
									data.content = jQuery("#textarea_content").val();
								
								UniteAdminBiz.ajaxRequest("update_template_content",data,function(response){
									jQuery("#dialog_content").dialog("close");
								});								
							}								
						}
					
					}); //dialog open
					
					if(g_codemirrorHtml != null){
						g_codemirrorHtml.setValue(response.content);
					}
					else{
						jQuery("#textarea_content").val(response.content);
						setTimeout('ShowBizAdmin.setCodeMirrorEditor("html")',500);
					}
					
				});//ajax request - get content
								
			});//edit content click
			
			jQuery("#list_templates .button_edit_css").click(function(){
				var templateID = jQuery(this).data("id")
				var templateTitle = jQuery(this).data("title")

				var data = {templateID:templateID};
				
				var objLoader = jQuery(this).siblings(".loader_edit_css");
				objLoader.show();
				
				UniteAdminBiz.ajaxRequest("get_template_css",data,function(response){
					
					objLoader.hide();
					
					jQuery("#dialog_css").dialog({
						title:"Edit Template CSS: " + templateTitle,
						modal:true,
						resizable:true,
						minWidth:960,
						minHeight:700,
						closeOnEscape:true,
						buttons:{
							"Close":function(){
								jQuery("#dialog_css").dialog("close");
							},
							"Update":function(){
								
								var data = {};
								data.templateID = templateID;
								data.css = jQuery("#textarea_css").val();
								
								if(g_codemirrorCss != null)
									data.css = g_codemirrorCss.getValue();
								else
									data.css = jQuery("#textarea_css").val();
								
								UniteAdminBiz.ajaxRequest("update_template_css",data,function(response){
									jQuery("#dialog_css").dialog("close");
								});								
							}								
						}
					
					}); //dialog open
					
					if(g_codemirrorCss != null)
						g_codemirrorCss.setValue(response.css);
					else{
						jQuery("#textarea_css").val(response.css);
						setTimeout('ShowBizAdmin.setCodeMirrorEditor("css")',500);
					}
					
				});//ajax request - get content
				
			});
			
			//template html editor buttons - add placeholders
			jQuery("#template_buttons_html").delegate("a.button-option","click",function(){
					var text = jQuery(this).data("placeholder");
					if(text == "")
						return(true);
					
					text = "[" + text + "]";
					
					if(g_codemirrorHtml){
						g_codemirrorHtml.replaceSelection(text,"end");
						g_codemirrorHtml.focus();
					}
					else
						UniteAdminBiz.insertTextToTextarea("textarea_content",text);
			});
					
			
			//open dialog custom options
			jQuery("#button_edit_custom_options").click(function(){
				
				jQuery("#dialog_add_wildcard").dialog({
					modal:true,
					resizable:false,
					minWidth:700,
					minHeight:400,
					closeOnEscape:true,
					buttons:{
						"Close":function(){
							jQuery(this).dialog("close");
						}
					}
				});
				
			});
			
			//add custom option click.
			jQuery("#button_add_custom_option").click(function(){
				
				var data = {
					title: jQuery("#new_option_title").val(),
					name: jQuery("#new_option_name").val()
				};
				
				UniteAdminBiz.setErrorMessageID("custom_options_error_message");
				UniteAdminBiz.setAjaxLoaderID("loader_button_add");
				UniteAdminBiz.setAjaxHideButtonID("button_add_custom_option");
				UniteAdminBiz.ajaxRequest("add_wildcard" ,data,function(response){
					
					//clear fields:
					jQuery("#new_option_title").val("");					
					jQuery("#new_option_name").val("");					
					
					//add line:
					var html = '<li>';
					html += '<span class="option_name">'+ response.title + ' ('+response.name+')'+'</span>';
					html += '<span class="option_operations">';
					html += '	<a class="button-secondary button_remove_option" data-placeholder="'+response.placeholder+'" data-optionname="'+response.name+'">Remove</a>';
					html += '	<span class="loader_clean loader_remove_option float_left mleft_5 mtop_5" style="display:none;"></span>';
					html += '</span>';
					html += '<span class="clear_both"></span>';
					html += '</li>';
					
					jQuery("#list_custom_options").append(html);
					
					//add button to content dialog:
					htmlButton = '<a id="template_button_'+response.placeholder+'" class="button-secondary button-option button-custom" data-placeholder="'+response.placeholder+'" href="javascript:void(0)">'+response.title+'</a>';
					
					jQuery("#template_custom_options_wrapper").append(htmlButton);
					
				});
				
			});
			
			//delete custom option
			jQuery("#list_custom_options").delegate(".button_remove_option","click",function(){
				var objButton = jQuery(this);
				var optionName = objButton.data("optionname");
				var placeholder = objButton.data("placeholder");
				
				var data = {"name":optionName};
				var objLoader = objButton.siblings(".loader_remove_option");
				
				objLoader.show();
				objButton.hide();
				UniteAdminBiz.ajaxRequest("remove_wildcard" ,data,function(response){
					objButton.parents("li").remove();	
					//remove the template button
					jQuery("#template_button_"+placeholder).remove();
				});
				
			});
			
			
			//template css editor buttons - add placeholders
			jQuery("#template_buttons_css a").click(function(){
				var text = jQuery(this).data("placeholder");
				switch(text){
					case "itemid":
						var textToPut = "[" + text + "] ";
					break;
					default:
						var textToPut = "[" + text + "]";
					break;
				}
				
				if(g_codemirrorCss){
					g_codemirrorCss.replaceSelection(textToPut,"end");
					g_codemirrorCss.focus();
				}
				else
					UniteAdminBiz.insertTextToTextarea("textarea_css",textToPut);
				
			});
			
			//button classes tooltips:
			
			
			//template html editor "class" buttons
			jQuery("#template_classes a.button-class").click(function(){
				var objButton = jQuery(this);
				var textHtml =  objButton.data("html");
				
				if(g_codemirrorHtml){
					g_codemirrorHtml.replaceSelection(textHtml,"end");
					g_codemirrorHtml.focus();
				}
				else
					UniteAdminBiz.insertTextToTextarea("textarea_content",textHtml);
				
			}).tipsy({
				gravity:"s",
		        delayIn: 70
			});
			
			//preview template
			jQuery("#list_templates .button_preview_template").click(function(){
				
				var templateID = jQuery(this).data("id")
				var templateTitle = jQuery(this).data("title")
				
				openPreviewSliderDialog(templateID,"template");
				
			});	
		}
		
		
		/**
		 * init "slider" view functionality
		 */
		var initSaveSliderButton = function(ajaxAction){
		
			var refreshImages = "false";
			
			jQuery("#button_refresh_images").click(function(){
				refreshImages = "true";
				jQuery("#button_save_slider").click();
			});
			
			jQuery("#button_save_slider").click(function(){
					
					//collect data
					var data = {
							params: UniteSettingsBiz.getSettingsObject("form_slider_params"),
							main: UniteSettingsBiz.getSettingsObject("form_slider_main")
						};
					
					data['params']['refresh_images'] = refreshImages;
					
					//add slider id to the data
					if(ajaxAction == "update_slider"){
						data.sliderid = jQuery("#sliderid").val();
						
						//some ajax beautifyer
						UniteAdminBiz.setAjaxLoaderID("loader_update");
						UniteAdminBiz.setAjaxHideButtonID("button_save_slider");
						UniteAdminBiz.setSuccessMessageID("update_slider_success");
					}
					
					UniteAdminBiz.ajaxRequest(ajaxAction ,data);
			});		
		}

		
		/**
		 * update shortcode from alias value.
		 */
		var updateShortcode = function(){
			var alias = jQuery("#alias").val();			
			var shortcode = "[showbiz "+alias+"]";
			if(alias == "")
				shortcode = "-- wrong alias -- ";
			jQuery("#shortcode").val(shortcode);
		}
		
		/**
		 * 
		 * update category by post types
		 */
		var updateCatByPostTypes = function(typeSettingName,catSettingName){
			
			jQuery("#"+typeSettingName).change(function(){
				var arrTypes = jQuery(this).val();
				
				//replace the categories in multi select
				jQuery("#"+catSettingName).empty();
				jQuery(arrTypes).each(function(index,postType){
					var objCats = g_postTypesWithCats[postType];
					
					var flagFirst = true;
					for(catIndex in objCats){
						var catTitle = objCats[catIndex];
						//add option to cats select
						var opt = new Option(catTitle, catIndex);						
						
						if(catIndex.indexOf("option_disabled") == 0)
							jQuery(opt).prop("disabled","disabled");
						else{
							//select first option:
							if(flagFirst == true){
								jQuery(opt).prop("selected","selected");
								flagFirst = false;
							}
						}
						
						jQuery("#"+catSettingName).append(opt);
						
					}
					
				});					
			});
			
		}
		
		
		/**
		 * init common functionality of the slider view. 
		 */
		var initSliderViewCommon = function(){
			initShortcode();
			
			g_postTypesWithCats = jQuery.parseJSON(g_jsonTaxWithCats);
			updateCatByPostTypes("post_types","post_category");
			updateCatByPostTypes("wc_post_types","wc_post_category");
		}
		
		
		/**
		 * init "slider->add" view.
		 */
		this.initAddSliderView = function(){
			jQuery("#title").focus();
			initSaveSliderButton("create_slider");
			initSliderViewCommon();
		}
		
		
		/**
		 * init "slider->edit" view.
		 */		
		this.initEditSliderView = function(){
			
			initSliderViewCommon();
			
			initSaveSliderButton("update_slider");			
			
			//edit template button redirect
			jQuery("#button_edit_item_template").click(function(){
				var templateID = jQuery("#template_id").val();
				var url = g_viewTemplates + templateID;
				window.open(url, '_blank');				
				//window.location.href = url;
			});

			jQuery("#button_edit_item_template_nav").click(function(){
				var templateID = jQuery("#nav_template_id").val();
				var url = g_viewTemplatesNav + templateID;
				window.open(url, '_blank');
				//window.location.href = url;
			});
			
			
			
			//delete slider action
			jQuery("#button_delete_slider").click(function(){
				
				if(confirm("Do you really want to delete '"+jQuery("#title").val()+"' ?") == false)
					return(true);
				
				var data = {sliderid: jQuery("#sliderid").val()}
				
				UniteAdminBiz.ajaxRequest("delete_slider" ,data);
			});
			
			/*

			//api inputs functionality:
			jQuery("#api_wrapper .api-input, #api_area").click(function(){
				jQuery(this).select().focus();
			});
			
			//api button functions:
			jQuery("#link_show_api").click(function(){
				jQuery("#api_wrapper").show();
				jQuery("#link_show_api").addClass("button-selected");
				
				jQuery("#toolbox_wrapper").hide();
				jQuery("#link_show_toolbox").removeClass("button-selected");
			});
			
			jQuery("#link_show_toolbox").click(function(){
				jQuery("#toolbox_wrapper").show();
				jQuery("#link_show_toolbox").addClass("button-selected");
				
				jQuery("#api_wrapper").hide();
				jQuery("#link_show_api").removeClass("button-selected");
			});

			
			//export slider action
			jQuery("#button_export_slider").click(function(){
				var sliderID = jQuery("#sliderid").val()
				var urlAjaxExport = ajaxurl+"?action="+g_uniteDirPlagin+"_ajax_action&client_action=export_slider";
				urlAjaxExport += "&sliderid=" + sliderID;
				location.href = urlAjaxExport;
			});
			*/
			
			//preview slider actions
			jQuery("#button_preview_slider").click(function(){
				var sliderID = jQuery("#sliderid").val()
				openPreviewSliderDialog(sliderID);
			});
		}
		
		
		/**
		 * init shortcode functionality in the slider new and slider edit views.
		 */
		var initShortcode = function(){
			
			//select shortcode text when click on it.
			jQuery("#shortcode").focus(function(){				
				this.select();
			});
			jQuery("#shortcode").click(function(){				
				this.select();
			});
			
			//update shortcode
			jQuery("#alias").change(function(){
				updateShortcode();
			});

			jQuery("#alias").keyup(function(){
				updateShortcode();
			});
		}
		
		
		/**
		 * update slides order
		 */
		var updateSlidesOrder = function(sliderID){
			var arrSlideHtmlIDs = jQuery( "#list_slides" ).sortable("toArray");
			
			//get slide id's from html (li) id's
			var arrIDs = [];
			jQuery(arrSlideHtmlIDs).each(function(index,value){
				var slideID = value.replace("slidelist_item_","");
				arrIDs.push(slideID);
			});
			
			//save order
			var data = {arrIDs:arrIDs,sliderID:sliderID};
			
			jQuery("#saving_indicator").show();
			UniteAdminBiz.ajaxRequest("update_slides_order" ,data,function(){
				jQuery("#saving_indicator").hide();
			});
			
			
			jQuery("#select_sortby").val("menu_order");
				
		}
		
		
		/**
		 * init "sliders list" view 
		 */
		this.initSlidersListView = function(){
			
			jQuery(".button_delete_slider").click(function(){
				
				var sliderID = this.id.replace("button_delete_","");
				var sliderTitle = jQuery("#slider_title_"+sliderID).text(); 
				if(confirm("Do you really want to delete '"+sliderTitle+"' ?") == false)
					return(false);
				
				UniteAdminBiz.ajaxRequest("delete_slider" ,{sliderid:sliderID});
			});
			
			//duplicate slider action
			jQuery(".button_duplicate_slider").click(function(){
				var sliderID = this.id.replace("button_duplicate_","");
				UniteAdminBiz.ajaxRequest("duplicate_slider" ,{sliderid:sliderID});
			});
			
				//preview slider action
				jQuery(".button_slider_preview").click(function(){
					
					var sliderID = this.id.replace("button_preview_","");
					openPreviewSliderDialog(sliderID);
			});
			
		}

		
		/**
		 * open preview slider dialog
		 */
		var openPreviewSliderDialog = function(sliderID,type){
			
			if(type == undefined)
				type = "slider";
			
			var selectorItemID = (type == "template")?"#preview_templateid":"#preview_sliderid";
			
			jQuery("#dialog_preview_sliders").dialog({
				modal:true,
				resizable:false,
				minWidth:1100,
				minHeight:500,
				closeOnEscape:true,
				buttons:{
					"Close":function(){
						jQuery(this).dialog("close");
					}
				},
				open:function(event,ui){					
					var form1 = jQuery("#form_preview")[0];
					jQuery(selectorItemID).val(sliderID);
					form1.action = g_urlAjaxActions;
					form1.submit();
				},
				close:function(){
					var form1 = jQuery("#form_preview")[0];
					jQuery(selectorItemID).val("empty_output");
					form1.action = g_urlAjaxActions;
					form1.submit();
				}
			});
			
		}
		
		
		/**
		 * 
		 * init slides view posts related functions
		 */
		t.initSlidesListViewPosts = function(sliderID){
			
			g_isSlidesFromPost = true;
			
			initSlidesListView(sliderID);
			
			//init sortby
			jQuery("#select_sortby").change(function(){
				jQuery("#slides_top_loader").show();
				var data = {};
				data.sliderID = sliderID;
				data.sortby = jQuery(this).val();
				UniteAdminBiz.ajaxRequest("update_posts_sortby" ,data,function(){
					jQuery("#slides_top_loader").html("Updated, reloading page...");
					location.reload(true);
				});
			});
		}
		
		
		/**
		 * 
		 * init slides view posts related functions
		 */
		t.initSlidesListViewGallery = function(sliderID){
			g_isSlidesFromPost = false;
			
			initSlidesListView(sliderID);
		}
		
		
		/**
		 * init "slides list" view 
		 */
		var initSlidesListView = function(sliderID){
			
			//set the slides sortable, init save order
			jQuery("#list_slides").sortable({
					axis:"y",
					handle:'.col-handle',
					update:function(){updateSlidesOrder(sliderID)}
			});
			
			//new slide
			jQuery("#button_new_slide, #button_new_slide_top").click(function(){
				var data = {sliderid:sliderID};
				
				/*
				UniteAdminBiz.setAjaxHideButtonID("button_save_slide");
				*/
				if(this.id == "button_new_slide_top"){
					UniteAdminBiz.setAjaxLoaderID("loader_add_slide_top");				
					UniteAdminBiz.setSuccessMessageID("loader_add_slide_top_message");
				}else{
					UniteAdminBiz.setAjaxHideButtonID("button_new_slide");
					UniteAdminBiz.setAjaxLoaderID("loader_add_slide_bottom");				
					UniteAdminBiz.setSuccessMessageID("loader_add_slide_bottom_message");					
				}
				UniteAdminBiz.ajaxRequest("add_slide" ,data);
								
			});
			
			//duplicate slide
			jQuery(".button_duplicate_slide").click(function(){
				var slideID = this.id.replace("button_duplicate_slide_","");
				var data = {slideID:slideID,sliderID:sliderID};
				UniteAdminBiz.ajaxRequest("duplicate_slide" ,data);
			});
			
			// delete single slide
			jQuery(".button_delete_slide").click(function(){
				var slideID = this.id.replace("button_delete_slide_","");
				var data = {slideID:slideID,sliderID:sliderID};
				if(confirm("Delete this slide?") == false)
					return(false);
				UniteAdminBiz.ajaxRequest("delete_slide" ,data);
			});
			
			//activate tipsy:
			var imageClasses = ".col-image .slide_image,.col-image .empty_slide_image";
			
			jQuery(imageClasses).tipsy({
				gravity:"s",
		        delayIn: 70
			});
			
			//change image
			jQuery(imageClasses).click(function(){
				var slideID = this.id.replace("slide_image_","");
				UniteAdminBiz.openAddImageDialog("Select Slide Image",function(urlImage,imageID){					
					var data = {slider_id:sliderID,
								slide_id:slideID,
								url_image:urlImage,
								image_id:imageID};
					UniteAdminBiz.ajaxRequest("change_slide_image" ,data, function(){
						location.reload(true);
					});
				});
			});	
			
			//publish / unpublish item
			jQuery("#list_slides .icon_state").click(function(){
				var objIcon = jQuery(this);
				var objLoader = objIcon.siblings(".state_loader");
				var slideID = objIcon.data("slideid");
				var data = {slider_id:sliderID,slide_id:slideID};
				
				objIcon.hide();
				objLoader.show();
				UniteAdminBiz.ajaxRequest("toggle_slide_state" ,data,function(response){
					objIcon.show();
					objLoader.hide();
					var currentState = response.state;
					
					if(currentState == "published"){
						objIcon.removeClass("state_unpublished").addClass("state_published").prop("title","Unpublish Slide");
					}else{
						objIcon.removeClass("state_published").addClass("state_unpublished").prop("title","Publish Slide");
					}
							
				});
			});
			
			//preview slide from the slides list:
			jQuery("#list_slides .icon_slide_preview").click(function(){
				var slideID = jQuery(this).data("slideid");
				openPreviewSlideDialog(slideID,false);
			});
			
			
		}
		
		
		/**
		 * init "edit slide" view
		 */
		this.initEditSlideView = function(slideID){
			
			//save slide actions
			jQuery("#button_save_slide").click(function(){
				var params = UniteSettingsBiz.getSettingsObject("form_slide_params");
				var data = {
						slideid:slideID,
						params:params
					};	
				
				UniteAdminBiz.setAjaxHideButtonID("button_save_slide");
				UniteAdminBiz.setAjaxLoaderID("loader_update");
				UniteAdminBiz.setSuccessMessageID("update_slide_success");
				UniteAdminBiz.ajaxRequest("update_slide" ,data);
			});
			
			//change image actions
			jQuery("#button_change_image").click(function(){
				
				UniteAdminBiz.openAddImageDialog("Select Slide Image",function(urlImage){
						//set visual image 
						jQuery("#divLayers").css("background-image","url("+urlImage+")");
						
					}); //dialog
			});	//change image click.
			
			
			//preview slide actions - open preveiw dialog			
			jQuery("#button_preview_slide").click(function(){				
				openPreviewSlideDialog(slideID,true);
			});
			
		}//init slide view
		
		
		/**
		 * open preview slide dialog
		 */
		var openPreviewSlideDialog = function(slideID,useParams){

			if(useParams === undefined)
				useParams = true;
			
			var iframePreview = jQuery("#frame_preview");
			var previewWidth = iframePreview.width() + 10;
			var previewHeight = iframePreview.height() + 10;
			var iframe = jQuery("#frame_preview");
			
			jQuery("#dialog_preview").dialog({
					modal:true,
					resizable:false,
					minWidth:previewWidth,
					minHeight:previewHeight,
					closeOnEscape:true,
					buttons:{
						"Close":function(){
							jQuery(this).dialog("close");
						}
					},
					open:function(event,ui){
						var form1 = jQuery("#form_preview_slide")[0];
						
						var objData = {
								slideid:slideID,
							};
						
						if(useParams == true){
							objData.params = UniteSettingsBiz.getSettingsObject("form_slide_params"),
							objData.params.slide_bg_color = jQuery("#slide_bg_color").val();							
							objData.layers = UniteLayersBiz.getLayers()
						}
						
						var jsonData = JSON.stringify(objData);
						
						jQuery("#preview_slide_data").val(jsonData);
						form1.action = g_urlAjaxActions;
						form1.client_action = "preview_slide";
						form1.submit();
					},
					close:function(){	//distroy the loaded preview
						var form1 = jQuery("#form_preview_slide")[0];
						form1.action = g_urlAjaxActions;
						jQuery("#preview_slide_data").val("empty_output");
						form1.submit();
					}
			});
			
		}
		
}
