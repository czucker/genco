<script type="text/javascript">
    jQuery(document).ready(function($) {
        var itms_per_pg = parseInt(<?php echo $items_per_page; ?>);
        var count = parseInt(<?php echo $count; ?>);
        var tab = '<?php echo $tab ?>';
        var level = '<?php echo $levelId ?>';
        $("#emember_Pagination").pagination(count, {
            callback: function(i, container) {
                $('#wpm_post_page_table').html('Loading...........');
                var maxIndex = Math.min((i + 1) * itms_per_pg, count);
                var params = {action: "item_list_ajax", tab: tab, level: level, start: i * itms_per_pg, limit: itms_per_pg};
                $.get(ajaxurl, params, function(data) {
                    console.log(data);
                    $('#wpm_post_page_table').html(data);
                    $('#wpm_post_page_table thead .emember_select').click(function() {
                        var checked = this.checked;
                        $('#wpm_post_page_table tbody .emember_select').each(function() {
                            this.checked = checked;
                        });
                    });
                });
            },
            num_edge_entries: 2,
            num_display_entries: 10,
            items_per_page: itms_per_pg
        });
    });
</script>
