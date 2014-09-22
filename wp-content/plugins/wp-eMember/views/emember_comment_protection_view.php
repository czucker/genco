<thead>
    <tr>
        <th scope="row" class="check-column">
            <input class="emember_select" type="checkbox">
            <input type="hidden" name="content_type" value="comments" />
        </th>
        <th scope="row">Date</th>
        <th scope="row">Author</th>
        <th scope="row">Contents</th>
    </tr>
</thead>
<tbody>
    <?php if (empty($filtered_comments)): ?>
        <tr><td colspan="4">No Comment Found.</td></tr>
    <?php else: ?>
        <?php $c = 0;
        foreach ($filtered_comments as $comment):
            ?>
            <tr <?php echo ($c % 2) ? 'class="alternate"' : ""; ?>>
                <th scope="row" class="check-column"><input class="emember_select" <?php echo $comment['protected'] ?> type="checkbox" name="checked[<?php echo $comment['ID']; ?>]"></th>
                <td><?php echo $comment['date']; ?></td>
                <td><?php echo $comment['author']; ?></td>
                <td>
                    <input type="hidden" name="item_id[]" value="<?php echo $comment['ID']; ?>">
        <?php echo $comment['content']; ?>
                </td>
            </tr>
            <?php $c++;
        endforeach;
        ?>
<?php endif; ?>
</tbody>
