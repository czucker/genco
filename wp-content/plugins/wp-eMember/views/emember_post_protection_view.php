<thead>
    <tr>
        <th scope="row" class="check-column">
            <input class="emember_select" type="checkbox">
            <input type="hidden" name="content_type" value="posts" />
        </th>
        <th scope="row">Disable Bookmark</th>
        <th scope="row">Date</th>
        <th scope="row">Title</th>
        <th scope="row">Author</th>
        <th scope="row">Categories</th>
        <th scope="row">Status</th>
    </tr>
</thead>
<tbody>
    <?php if (empty($filtered_posts)): ?>
        <tr><td colspan="4">No Post Found.</td></tr>
    <?php else: ?>
        <?php $c = 0;
        foreach ($filtered_posts as $post):
            ?>
            <tr <?php echo ($c % 2) ? 'class="alternate"' : ""; ?>>
                <th scope="row" class="check-column"><input class="emember_select" <?php echo $post['protected']; ?> type="checkbox" name="checked[<?php echo $post['ID']; ?>]"></th>
                <th scope="row" class="check-column"><input class="emember_bookmark" <?php echo $post['bookmark']; ?> type="checkbox" name="bookmark[<?php echo $post['ID']; ?>]"></th>
                <td><?php echo $post['date']; ?></td>
                <td><a target="_blank" class="emember_post_preview" href="<?php echo get_permalink($post['ID']); //echo $post['ID'];   ?>"><?php echo $post['title']; ?></a></td>
                <td><?php echo $post['author']; ?></td>
                <td><?php echo $post['categories']; ?></td>
                <td>
                    <input type="hidden" name="item_id[]" value="<?php echo $post['ID']; ?>">
        <?php echo $post['status']; ?>
                </td>
            </tr>
            <?php $c++;
        endforeach;
        ?>
<?php endif; ?>
</tbody>
