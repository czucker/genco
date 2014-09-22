/**
 * Cookie plugin
 *
 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */

/**
 * Create a cookie with the given name and value and other optional parameters.
 *
 * @example $.cookie('the_cookie', 'the_value');
 * @desc Set the value of a cookie.
 * @example $.cookie('the_cookie', 'the_value', { expires: 7, path: '/', domain: 'jquery.com', secure: true });
 * @desc Create a cookie with all available options.
 * @example $.cookie('the_cookie', 'the_value');
 * @desc Create a session cookie.
 * @example $.cookie('the_cookie', null);
 * @desc Delete a cookie by passing null as value. Keep in mind that you have to use the same path and domain
 *       used when the cookie was set.
 *
 * @param String name The name of the cookie.
 * @param String value The value of the cookie.
 * @param Object options An object literal containing key/value pairs to provide optional cookie attributes.
 * @option Number|Date expires Either an integer specifying the expiration date from now on in days or a Date object.
 *                             If a negative value is specified (e.g. a date in the past), the cookie will be deleted.
 *                             If set to null or omitted, the cookie will be a session cookie and will not be retained
 *                             when the the browser exits.
 * @option String path The value of the path atribute of the cookie (default: path of page that created the cookie).
 * @option String domain The value of the domain attribute of the cookie (default: domain of page that created the cookie).
 * @option Boolean secure If true, the secure attribute of the cookie will be set and the cookie transmission will
 *                        require a secure protocol (like HTTPS).
 * @type undefined
 *
 * @name $.cookie
 * @cat Plugins/Cookie
 * @author Klaus Hartl/klaus.hartl@stilbuero.de
 */

/**
 * Get the value of a cookie with the given name.
 *
 * @example $.cookie('the_cookie');
 * @desc Get the value of a cookie.
 *
 * @param String name The name of the cookie.
 * @return The value of the cookie.
 * @type String
 *
 * @name $.cookie
 * @cat Plugins/Cookie
 * @author Klaus Hartl/klaus.hartl@stilbuero.de
 */
jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options = $.extend({}, options); // clone object since it's unexpected behavior if the expired property were changed
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // NOTE Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};

/**
 * This jQuery plugin displays pagination links inside the selected elements.
 *
 * @author Gabriel Birke (birke *at* d-scribe *dot* de)
 * @version 1.2
 * @param {int} maxentries Number of entries to paginate
 * @param {Object} opts Several options (see README for documentation)
 * @return {Object} jQuery Object
 */
jQuery.fn.pagination = function(maxentries, opts) {
    opts = jQuery.extend({
        items_per_page: 10,
        num_display_entries: 10,
        current_page: 0,
        num_edge_entries: 0,
        link_to: "#",
        prev_text: "Prev",
        next_text: "Next",
        ellipse_text: "...",
        prev_show_always: true,
        next_show_always: true,
        callback: function() {
            return false;
        }
    }, opts || {});

    return this.each(function() {
        /**
         * Calculate the maximum number of pages
         */
        function numPages() {
            return Math.ceil(maxentries / opts.items_per_page);
        }

        /**
         * Calculate start and end point of pagination links depending on
         * current_page and num_display_entries.
         * @return {Array}
         */
        function getInterval() {
            var ne_half = Math.ceil(opts.num_display_entries / 2);
            var np = numPages();
            var upper_limit = np - opts.num_display_entries;
            var start = current_page > ne_half ? Math.max(Math.min(current_page - ne_half, upper_limit), 0) : 0;
            var end = current_page > ne_half ? Math.min(current_page + ne_half, np) : Math.min(opts.num_display_entries, np);
            return [start, end];
        }

        /**
         * This is the event handling function for the pagination links.
         * @param {int} page_id The new page number
         */
        function pageSelected(page_id, evt) {
            current_page = page_id;
            drawLinks();
            var continuePropagation = opts.callback(page_id, panel);
            if (!continuePropagation) {
                if (evt.stopPropagation) {
                    evt.stopPropagation();
                }
                else {
                    evt.cancelBubble = true;
                }
            }
            return continuePropagation;
        }

        /**
         * This function inserts the pagination links into the container element
         */
        function drawLinks() {
            panel.empty();
            var interval = getInterval();
            var np = numPages();
            // This helper function returns a handler function that calls pageSelected with the right page_id
            var getClickHandler = function(page_id) {
                return function(evt) {
                    return pageSelected(page_id, evt);
                }
            }
            // Helper function for generating a single link (or a span tag if it's the current page)
            var appendItem = function(page_id, appendopts) {
                page_id = page_id < 0 ? 0 : (page_id < np ? page_id : np - 1); // Normalize page id to sane value
                appendopts = jQuery.extend({text: page_id + 1, classes: ""}, appendopts || {});
                if (page_id == current_page) {
                    var lnk = jQuery("<span class='current'>" + (appendopts.text) + "</span>");
                }
                else
                {
                    var lnk = jQuery("<a>" + (appendopts.text) + "</a>")
                            .bind("click", getClickHandler(page_id))
                            .attr('href', opts.link_to.replace(/__id__/, page_id));


                }
                if (appendopts.classes) {
                    lnk.addClass(appendopts.classes);
                }
                panel.append(lnk);
            }
            // Generate "Previous"-Link
            if (opts.prev_text && (current_page > 0 || opts.prev_show_always)) {
                appendItem(current_page - 1, {text: opts.prev_text, classes: "prev"});
            }
            // Generate starting points
            if (interval[0] > 0 && opts.num_edge_entries > 0)
            {
                var end = Math.min(opts.num_edge_entries, interval[0]);
                for (var i = 0; i < end; i++) {
                    appendItem(i);
                }
                if (opts.num_edge_entries < interval[0] && opts.ellipse_text)
                {
                    jQuery("<span>" + opts.ellipse_text + "</span>").appendTo(panel);
                }
            }
            // Generate interval links
            for (var i = interval[0]; i < interval[1]; i++) {
                appendItem(i);
            }
            // Generate ending points
            if (interval[1] < np && opts.num_edge_entries > 0)
            {
                if (np - opts.num_edge_entries > interval[1] && opts.ellipse_text)
                {
                    jQuery("<span>" + opts.ellipse_text + "</span>").appendTo(panel);
                }
                var begin = Math.max(np - opts.num_edge_entries, interval[1]);
                for (var i = begin; i < np; i++) {
                    appendItem(i);
                }

            }
            // Generate "Next"-Link
            if (opts.next_text && (current_page < np - 1 || opts.next_show_always)) {
                appendItem(current_page + 1, {text: opts.next_text, classes: "next"});
            }
        }

        // Extract current_page from options
        var current_page = opts.current_page;
        // Create a sane value for maxentries and items_per_page
        maxentries = (!maxentries || maxentries < 0) ? 1 : maxentries;
        opts.items_per_page = (!opts.items_per_page || opts.items_per_page < 0) ? 1 : opts.items_per_page;
        // Store DOM element for easy access from all inner functions
        var panel = jQuery(this);
        // Attach control functions to the DOM element
        this.selectPage = function(page_id) {
            pageSelected(page_id);
        }
        this.prevPage = function() {
            if (current_page > 0) {
                pageSelected(current_page - 1);
                return true;
            }
            else {
                return false;
            }
        }
        this.nextPage = function() {
            if (current_page < numPages() - 1) {
                pageSelected(current_page + 1);
                return true;
            }
            else {
                return false;
            }
        }
        // When all initialisation is done, draw the links
        drawLinks();
        // call callback function
        opts.callback(current_page, this);
    });
}
/**
 * Confirm plugin 1.2
 *
 * Copyright (c) 2007 Nadia Alramli (http://nadiana.com/)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 */

/**
 * For more docs and examples visit:
 * http://nadiana.com/jquery-confirm-plugin
 * For comments, suggestions or bug reporting,
 * email me at: http://nadiana.com/contact/
 */

/*jQuery.fn.confirm = function(options) {
 options = jQuery.extend({
 msg: 'Are you sure?',
 stopAfter: 'never',
 wrapper: '<span></span>',
 eventType: 'click',
 dialogShow: 'show',
 dialogSpeed: '',
 timeout: 0
 }, options);
 options.stopAfter = options.stopAfter.toLowerCase();
 if (!options.stopAfter in ['never', 'once', 'ok', 'cancel']) {
 options.stopAfter = 'never';
 }
 options.buttons = jQuery.extend({
 ok: 'Yes',
 cancel: 'No',
 wrapper:'<a href="#"></a>',
 separator: '/'
 }, options.buttons);
 
 // Shortcut to eventType.
 var type = options.eventType;
 
 return this.each(function() {
 var target = this;
 var $target = jQuery(target);
 var timer;
 var saveHandlers = function() {
 var events = jQuery.data(target, 'events');
 if (!events) {
 // There are no handlers to save.
 return;
 }
 target._handlers = new Array();
 for (var i in events[type]) {
 target._handlers.push(events[type][i]);
 }
 }
 
 // Create ok button, and bind in to a click handler.
 var $ok = jQuery(options.buttons.wrapper)
 .append(options.buttons.ok)
 .click(function() {
 // Check if timeout is set.
 if (options.timeout != 0) {
 clearTimeout(timer);
 }
 $target.unbind(type, handler);
 $target.show();
 $dialog.hide();
 // Rebind the saved handlers.
 if (target._handlers != undefined) {
 jQuery.each(target._handlers, function() {
 $target.click(this);
 });
 }
 // Trigger click event.
 $target.click();
 if (options.stopAfter != 'ok' && options.stopAfter != 'once') {
 $target.unbind(type);
 // Rebind the confirmation handler.
 $target.one(type, handler);
 }
 return false;
 })
 
 var $cancel = jQuery(options.buttons.wrapper).append(options.buttons.cancel).click(function() {
 // Check if timeout is set.
 if (options.timeout != 0) {
 clearTimeout(timer);
 }
 if (options.stopAfter != 'cancel' && options.stopAfter != 'once') {
 $target.one(type, handler);
 }
 $target.show();
 $dialog.hide();
 return false;
 });
 
 if (options.buttons.cls) {
 $ok.addClass(options.buttons.cls);
 $cancel.addClass(options.buttons.cls);
 }
 
 var $dialog = jQuery(options.wrapper)
 .append(options.msg)
 .append($ok)
 .append(options.buttons.separator)
 .append($cancel);
 
 var handler = function() {
 jQuery(this).hide();
 
 // Do this check because of a jQuery bug
 if (options.dialogShow != 'show') {
 $dialog.hide();
 }
 
 $dialog.insertBefore(this);
 // Display the dialog.
 $dialog[options.dialogShow](options.dialogSpeed);
 if (options.timeout != 0) {
 // Set timeout
 clearTimeout(timer);
 timer = setTimeout(function() {$cancel.click(); $target.one(type, handler);}, options.timeout);
 }
 return false;
 };
 
 saveHandlers();
 $target.unbind(type);
 target._confirm = handler
 target._confirmEvent = type;
 $target.one(type, handler);
 });
 }*/

/**
 * Confirm plugin 1.3
 *
 * Copyright (c) 2007 Nadia Alramli (http://nadiana.com/)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 */

/**
 * For more docs and examples visit:
 * http://nadiana.com/jquery-confirm-plugin
 * For comments, suggestions or bug reporting,
 * email me at: http://nadiana.com/contact/
 */

jQuery.fn.confirm = function(options) {
    options = jQuery.extend({
        msg: 'Are you sure?',
        stopAfter: 'never',
        wrapper: '<span></span>',
        eventType: 'click',
        dialogShow: 'show',
        dialogSpeed: '',
        timeout: 0
    }, options);
    options.stopAfter = options.stopAfter.toLowerCase();
    if (!options.stopAfter in ['never', 'once', 'ok', 'cancel']) {
        options.stopAfter = 'never';
    }
    options.buttons = jQuery.extend({
        ok: 'Yes',
        cancel: 'No',
        wrapper: '<a href="#"></a>',
        separator: '/'
    }, options.buttons);

    // Shortcut to eventType.
    var type = options.eventType;

    return this.each(function() {
        var target = this;
        var $target = jQuery(target);
        var timer;
        var saveHandlers = function() {
            var events = jQuery.data(target, 'events');
            if (!events && target.href) {
                // No handlers but we have href
                $target.bind('click', function() {
                    document.location = target.href
                });
                events = jQuery.data(target, 'events');
            } else if (!events) {
                // There are no handlers to save.
                return;
            }
            target._handlers = new Array();
            for (var i in events[type]) {
                target._handlers.push(events[type][i]);
            }
        }

        // Create ok button, and bind in to a click handler.
        var $ok = jQuery(options.buttons.wrapper)
                .append(options.buttons.ok)
                .click(function() {
                    // Check if timeout is set.
                    if (options.timeout != 0) {
                        clearTimeout(timer);
                    }
                    $target.unbind(type, handler);
                    $target.show();
                    $dialog.hide();
                    // Rebind the saved handlers.
                    if (target._handlers != undefined) {
                        jQuery.each(target._handlers, function() {
                            $target.click(this.handler);
                        });
                    }
                    // Trigger click event.
                    $target.click();
                    if (options.stopAfter != 'ok' && options.stopAfter != 'once') {
                        $target.unbind(type);
                        // Rebind the confirmation handler.
                        $target.one(type, handler);
                    }
                    return false;
                })

        var $cancel = jQuery(options.buttons.wrapper).append(options.buttons.cancel).click(function() {
            // Check if timeout is set.
            if (options.timeout != 0) {
                clearTimeout(timer);
            }
            if (options.stopAfter != 'cancel' && options.stopAfter != 'once') {
                $target.one(type, handler);
            }
            $target.show();
            $dialog.hide();
            return false;
        });

        if (options.buttons.cls) {
            $ok.addClass(options.buttons.cls);
            $cancel.addClass(options.buttons.cls);
        }

        var $dialog = jQuery(options.wrapper)
                .append(options.msg)
                .append($ok)
                .append(options.buttons.separator)
                .append($cancel);

        var handler = function() {
            jQuery(this).hide();

            // Do this check because of a jQuery bug
            if (options.dialogShow != 'show') {
                $dialog.hide();
            }

            $dialog.insertBefore(this);
            // Display the dialog.
            $dialog[options.dialogShow](options.dialogSpeed);
            if (options.timeout != 0) {
                // Set timeout
                clearTimeout(timer);
                timer = setTimeout(function() {
                    $cancel.click();
                    $target.one(type, handler);
                }, options.timeout);
            }
            return false;
        };

        saveHandlers();
        $target.unbind(type);
        target._confirm = handler
        target._confirmEvent = type;
        $target.one(type, handler);
    });
}

/**
 * @author Remy Sharp
 * @url http://remysharp.com/2007/01/25/jquery-tutorial-text-box-hints/
 */

//(function ($) {
jQuery.fn.hint = function(blurClass) {
    if (!blurClass) {
        blurClass = 'blur';
    }

    return this.each(function() {
        // get jQuery version of 'this'
        var $input = jQuery(this),
                // capture the rest of the variable to allow for reuse
                title = $input.attr('title'),
                $form = jQuery(this.form),
                $win = jQuery(window);

        function remove() {
            if ($input.val() === title && $input.hasClass(blurClass)) {
                $input.val('').removeClass(blurClass);
            }
        }

        // only apply logic if the element has the attribute
        if (title) {
            // on blur, set value to title attr if text is blank
            $input.blur(function() {
                if (this.value === '') {
                    $input.val(title).addClass(blurClass);
                }
            }).focus(remove).blur(); // now change all inputs to title

            // clear the pre-defined text when form is submitted
            $form.submit(remove);
            $win.unload(remove); // handles Firefox's autocomplete
        }
    });
};

//})(jQuery);