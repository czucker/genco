/*
 *	jQuery dynamicField plugin
 *	Copyright 2009, Matt Quackenbush (http://www.quackfuzed.com/)
 *
 *	Find usage demos at http://www.quackfuzed.com/demos/jQuery/dynamicField/index.cfm)
 *
 *	Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 *	and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 *	Version: 1.0
 *	Date:	 8/13/2009
 */
;
(function($) {
    $.fn.dynamicField = function(options) {
        if ($(this).attr("id") == undefined) {
            alert("The dynamicField plugin could not be initialized.\n\nPlease check the selector.");
            return $;
        }

        var f = $(this);

        var settings = $.extend({
            maxFields: 5,
            removeImgSrc: "../images/cross.png",
            spacerImgSrc: "../images/spacer.gif",
            addTriggerClass: "add-field-trigger",
            removeImgClass: "remove-field-trigger",
            hideClass: "hide",
            cloneContainerId: f.attr("id").replace(/^(.+)([_-][0-9]+)$/, "$1"),
            rowContainerClass: f.attr("class"),
//			labelText: f.find("label")
//							.html(),
//			baseName: f.children("input")
//								.attr("id")
//								.replace(/^(.+[_-])([0-9]+)$/,"$1"),
            addContainerId: "add-" + f.find("input")
                    .attr("id")
                    .replace(/^(.+)([_-][0-9]+)$/, "$1")
                    .replace(/_/g, "-") + "-container"
        }, options);

        var getFields = function() {
            return $("div." + settings.rowContainerClass);
        };

        // handle hide/show, etc
        var addRemoveBtnCk = function() {
            var fields = getFields();
            var len = fields.length;

            fields.each(function(i, elem) {
                $(elem)
                        .children("img")
                        .attr({
                            "src": settings.removeImgSrc,
                            "class": settings.removeImgClass
                        });
            });

            if (len > (settings.maxFields - 1)) {
                $("div#" + settings.addContainerId).addClass(settings.hideClass);
            } else {
                $("div#" + settings.addContainerId).removeClass(settings.hideClass);
            }
        };

        // handle field removal
        $("img." + settings.removeImgClass).live("click", function() {
            // remove the selected row          
            var fields = getFields();
            if (fields.length == 1)
                $(this).parent("div." + settings.rowContainerClass).hide();
            else
                $(this).parent("div." + settings.rowContainerClass).remove();
            // rebrand the remaining fields sequentially
            fields.each(function(i, elem) {
                var pos = new Number(i);
                var d = $(elem)
                        .attr("id", settings.cloneContainerId + "-" + pos);
                ;
                update_tag_meta(d, pos);
            });

            addRemoveBtnCk();
        });
        var update_tag_meta = function(parent_elem, pos, clear_fields) {
            parent_elem.find("label")
                    .each(function() {
                        var base_name = $(this).attr("for")
                                .replace(/^(.+[_-])([0-9]+)$/, "$1");
                        $(this).attr("for", base_name + pos);
                    });
            parent_elem.find("input")
                    .each(function() {
                        if ($(this).attr('type').toLowerCase() == 'checkbox')
                            $(this).val(pos);
                        else if (clear_fields)
                            $(this).val("");
                        var base_name = $(this).attr('name').split('[')[0];
                        var base_id = $(this).attr("id")
                                .replace(/^(.+[_-])([0-9]+)$/, "$1");
                        $(this).attr({
                            "id": base_id + pos,
                            "name": base_name + '[' + pos + ']'
                        });
                    });
            parent_elem.find('textarea').each(function() {
                var base_name = $(this).attr('name').split('[')[0];
                var base_id = $(this).attr("id")
                        .replace(/^(.+[_-])([0-9]+)$/, "$1");
                $(this).attr({
                    "id": base_id + pos,
                    "name": base_name + '[' + pos + ']'
                });
                if (clear_fields)
                    $(this).html('');
            });
            parent_elem.find("select")
                    .each(function() {
                        var base_name = $(this).attr('name').split('[')[0];
                        var base_id = $(this).attr("id")
                                .replace(/^(.+[_-])([0-9]+)$/, "$1");
                        $(this).attr({
                            "id": base_id + pos,
                            'name': base_name + '[' + pos + ']'
                        });
                        if (clear_fields)
                            $(this).val("");
                    });

        };

        // handle field add
        $("div#" + settings.addContainerId + " span." + settings.addTriggerClass).click(function() {
            var len = (getFields().length - 1);
            var block = $("div#" + settings.cloneContainerId + "-" + len);
            if (block.length > 0) {
                if (block.css('display') == "none") {
                    block.show();
                    return;
                }
            }
            var pos = new Number(len + 1);
            var newDiv = f
                    .clone(true)
                    .attr("id", settings.cloneContainerId + "-" + pos)
                    .addClass(settings.rowContainerClass);

            update_tag_meta(newDiv, pos, true);
            newDiv.find("img")
                    .attr("src", settings.removeImgSrc);
//			if ( len > 0 ) {
            $("div#" + settings.cloneContainerId + "-" + len).after(newDiv);
//			} else {
//				$("div#" + settings.addContainerId).before(newDiv);
//			}

            addRemoveBtnCk();
        });
        addRemoveBtnCk();
    };
})(jQuery);