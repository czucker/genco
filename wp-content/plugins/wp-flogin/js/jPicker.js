jQuery(document).ready(function () {
			jQuery('.Multiple').jPicker(
				{
					window: {
						position: {
							x: 'screenCenter',
							y: '100'
						}
					},
					images: {
						//clientPath: '<?php bloginfo('url');?>/wp-content/plugins/wp-flogin/images/'
						clientPath: '../wp-content/plugins/wp-flogin/images/'
					}
				},
				function(color,context){
					//update_color(this.id,color.val('all').hex);
					save();
				}
			);
		});