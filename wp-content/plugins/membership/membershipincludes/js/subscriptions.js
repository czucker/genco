var m_levelcount = 1;

function m_colorsublevels() {

	var levels = jQuery('#membership-levels-holder').sortable("toArray");

	onserial = false;
	pre_period = '';
	pre_unit = '';
	pre_price = '';
	pre_mode = '';
	all_finite = false;
	finite_count = 0;
	missmatch = false;
	trialexceeded = false;
	
	if(levels.length > 1) {

		for(n=0; n < levels.length; n++) {
			mode = jQuery('#' + levels[n]).find('[name^="levelmode"]').val();			
			period = jQuery('#' + levels[n]).find('[name^="levelperiod"]').val();
			unit = jQuery('#' + levels[n]).find('[name^="levelperiodunit"]').val();
			price = jQuery('#' + levels[n]).find('[name^="levelprice"]').val();
			
			if ( mode == 'finite' ) {
				finite_count += 1;
				if ( ! onserial ) {
					if ( pre_period != period && pre_period != '') { missmatch = true; }
					if ( pre_unit != unit && pre_unit != '') { missmatch = true; }
					if ( pre_price != price && pre_price != '') { missmatch = true; }
				}
			}
			
			if(onserial == true) {
				// reset finite missmatch
				missmatch = false;
				
				jQuery('#' + levels[n]).addClass('afterserial');
				jQuery('#' + levels[n] + ' .warning-after-serial').show();
			} else {
				// Remove trialexceeded
				jQuery('#' + levels[n]).removeClass('trialexceeded')
				jQuery('#' + levels[n] + ' .warning-trial').hide();
									
				jQuery('#' + levels[n]).removeClass('afterserial');
				jQuery('#' + levels[n] + ' .warning-after-serial').hide();
			}

			if(mode == 'serial' || mode == 'indefinite') {
				onserial = true;				
				
				// Only 2 finite levels accepted before another level type
				if ( finite_count > 2 ) { 
					jQuery('#' + levels[n]).addClass('trialexceeded');
					jQuery('#' + levels[n] + ' .warning-trial').show();
				} else {
					jQuery('#' + levels[n]).removeClass('trialexceeded');
					jQuery('#' + levels[n] + ' .warning-trial').hide();
				}
			}
			
			// Clear finite checking on each field for now
			jQuery('#' + levels[n]).removeClass('finitedontmatch');
			jQuery('#' + levels[n] + ' .warning-finite-missmatch').hide();
			
			pre_mode = mode;
			pre_period = period;
			pre_unit = unit;
			pre_price = price;
			
			// 2CheckOut integration warning
			if ( finite_count > 0 && onserial ) {
				if ( jQuery('#membership-levels-holder').hasClass('twocheckout') ) {
					jQuery('#' + levels[n]).addClass('twocheckout-limit');
					jQuery('#' + levels[n] + ' .warning-twocheckout').show();
				} else {
					jQuery('#' + levels[n]).removeClass('twocheckout-limit');
					jQuery('#' + levels[n] + ' .warning-twocheckout').show();
				}
			}
			
		}
	}
	
	// If its all finite and there is a missmatch, then mark
	if ( missmatch ) {
		for(n=0; n < levels.length; n++) {
			jQuery('#' + levels[n]).addClass('finitedontmatch');
			jQuery('#' + levels[n] + ' .warning-finite-missmatch').show();			
		}		
	}
	
	

}

function m_removesublevel() {
	var level = jQuery(this).parents('li.sortable-levels').attr('id');

	jQuery(this).parents('li.sortable-levels').remove();


	jQuery('#level-order').val( jQuery('#level-order').val().replace(',' + level, ''));

	add_level_listeners();
	m_colorsublevels();

	return false;
}

function m_addnewsub() {
	window.location = "?page=membershipsubs&action=edit&sub_id=";

	return false;
}

function m_deactivatesub() {
	if(confirm(membership.deactivatesub)) {
		return true;
	} else {
		return false;
	}
}

function m_deletesub() {
	if(confirm(membership.deletesub)) {
		return true;
	} else {
		return false;
	}
}

function m_clickactiontoggle() {
	if(jQuery(this).parent().hasClass('open')) {
		jQuery(this).parent().removeClass('open').addClass('closed');
		jQuery(this).parents('.action').find('.action-body').removeClass('open').addClass('closed');
	} else {
		jQuery(this).parent().removeClass('closed').addClass('open');
		jQuery(this).parents('.action').find('.action-body').removeClass('closed').addClass('open');
	}
}

function m_addtosubscription() {

	moving = jQuery(this).parents('.level-draggable').attr('id');

	var movingtitle = jQuery('#' + moving + ' div.action-top').html();

	var cloned = jQuery('#template-holder').clone().html();

	// remove the action link
	movingtitle = movingtitle.replace('<a href="#available-actions" class="action-button hide-if-no-js"></a>', '');

	cloned = cloned.replace('%startingpoint%', movingtitle);
	cloned = cloned.replace('%templateid%', moving + '-' + m_levelcount);
	cloned = cloned.replace(/%level%/gi, moving + '-' + m_levelcount);

	jQuery(cloned).appendTo('#membership-levels-holder');

	jQuery('a.removelink').unbind('click').click(m_removesublevel);

	jQuery('#level-order').val( jQuery('#level-order').val() + ',' + moving + '-' + m_levelcount);

	m_levelcount++;

	add_level_listeners();
	m_colorsublevels();

	return false;

}

function m_subsReady() {


	jQuery('.level-draggable').draggable({
			opacity: 0.7,
			helper: 'clone',
			start: function(event, ui) {
					jQuery('input#beingdragged').val( jQuery(this).attr('id') );
				 },
			stop: function(event, ui) {
					jQuery('input#beingdragged').val( '' );
				}
				});


	jQuery('.droppable-levels').droppable({
			hoverClass: 'hoveringover',
			drop: function(event, ui) {
					var moving = jQuery('input#beingdragged').val();
					var movingtitle = jQuery('#' + moving + ' div.action-top').html();

					var cloned = jQuery('#template-holder').clone().html();

					// remove the action link
					movingtitle = movingtitle.replace('<a href="#available-actions" class="action-button hide-if-no-js"></a>', '');

					cloned = cloned.replace('%startingpoint%', movingtitle);
					cloned = cloned.replace('%templateid%', moving + '-' + m_levelcount);
					cloned = cloned.replace(/%level%/gi, moving + '-' + m_levelcount);

					jQuery(cloned).appendTo('#membership-levels-holder');

					jQuery('a.removelink').unbind('click').click(m_removesublevel);

					jQuery('#level-order').val( jQuery('#level-order').val() + ',' + moving + '-' + m_levelcount);

					m_levelcount++;

					m_colorsublevels();
				}
	});

	jQuery('#membership-levels-holder').sortable({
		opacity: 0.7,
		helper: 'clone',
		placeholder: 'placeholder-levels',
		update: function(event, ui) {
				jQuery('#level-order').val(',' + jQuery('#membership-levels-holder').sortable('toArray').join(','));

				m_colorsublevels();
			}
	});

	jQuery('.addnewsubbutton').click(m_addnewsub);

	jQuery('.deactivate a').click(m_deactivatesub);
	jQuery('.delete a').click(m_deletesub);

	jQuery('a.removelink').click(m_removesublevel);

	jQuery('.action .action-top .action-button').click(m_clickactiontoggle);

	jQuery('a.action-to-subscription').click(m_addtosubscription);

	add_level_listeners();

	m_levelcount = jQuery('li.sortable-levels').length + 1;

}

function add_level_listeners() {
	jQuery( 'body' ).off( 'change', '[name^="levelmode"]', m_colorsublevels );
	jQuery( 'body' ).on( 'change', '[name^="levelmode"]', m_colorsublevels );
	
	jQuery( 'body' ).off( 'change', '[name^="levelperiod"]', m_colorsublevels );
	jQuery( 'body' ).on( 'change', '[name^="levelperiod"]', m_colorsublevels );
	
	jQuery( 'body' ).off( 'change', '[name^="levelperiodunit"]', m_colorsublevels );
	jQuery( 'body' ).on( 'change', '[name^="levelperiodunit"]', m_colorsublevels );

	jQuery( 'body' ).off( 'keyup', '[name^="levelprice"]', m_colorsublevels );
	jQuery( 'body' ).on( 'keyup', '[name^="levelprice"]', m_colorsublevels );
}

jQuery(document).ready(m_subsReady);