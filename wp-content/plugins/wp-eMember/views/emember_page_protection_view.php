<thead>
    <tr>
        <th scope="row" class="check-column">
            <input class="emember_select" type="checkbox">
            <input type="hidden" name="content_type" value="pages" />
        </th>
        <th scope="row">Disable Bookmark</th>
        <th scope="row">Date</th>
        <th scope="row">Title</th>
        <th scope="row">Author</th>
        <th scope="row">Status</th>
    </tr>
</thead>
<tbody>
    <?php if (empty($filtered_pages)): ?>
        <tr><td colspan="4">No Page Found.</td></tr>
    <?php else: ?>
        <?php $c = 0;
        foreach ($filtered_pages as $page):
            ?>
            <tr <?php echo ($c % 2) ? 'class="alternate"' : ""; ?>>
                <th scope="row" class="check-column"><input class="emember_select" <?php echo $page['protected']; ?> type="checkbox" name="checked[<?php echo $page['ID']; ?>]"></th>
                <th scope="row" class="check-column"><input class="emember_bookmark" <?php echo $page['bookmark']; ?> type="checkbox" name="bookmark[<?php echo $page['ID']; ?>]"></th>
                <td><?php echo $page['date']; ?></td>
                <td><a target="_blank" class="emember_post_preview" href="<?php echo get_permalink($page['ID']); //echo $page['ID'];   ?>"><?php echo $page['title']; ?></a></td>
                <td><?php echo $page['author']; ?></td>
                <td>
                    <input type="hidden" name="item_id[]" value="<?php echo $page['ID']; ?>">
        <?php echo $page['status']; ?>
                </td>
            </tr>
            <?php $c++;
        endforeach;
        ?>
<?php endif; ?>
</tbody>
