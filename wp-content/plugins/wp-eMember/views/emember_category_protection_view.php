<thead>
    <tr>
        <th scope="row" class="check-column">
            <input class="emember_select" type="checkbox">
            <input type="hidden" name="content_type" value="categories" />
        </th>
        <th scope="row">Name</th>
        <th scope="row">Description</th>
        <th scope="row">Posts</th>
    </tr>
</thead>
<tbody>
    <?php if (empty($filtered_categories)): ?>
        <tr><td colspan="4">No Category Found.</td></tr>
    <?php else: ?>
        <?php $c = 0;
        foreach ($filtered_categories as $category):
            ?>
            <tr <?php echo ($c % 2) ? 'class="alternate"' : ""; ?>>
                <th scope="row" class="check-column"><input class="emember_select" <?php echo $category['protected']; ?> type="checkbox" name="checked[<?php echo $category['ID']; ?>]"></th>
                <td><?php echo $category['name']; ?></td>
                <td><?php echo $category['description']; ?></td>
                <td>
                    <input type="hidden" name="item_id[]" value="<?php echo $category['ID']; ?>">
        <?php echo $category['count']; ?>
                </td>
            </tr>
            <?php $c++;
        endforeach;
        ?>
<?php endif; ?>
</tbody>
