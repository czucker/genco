<?php $memberlist->prepare_items(); ?>
<div class="wrap">
    <ul class="subsubsub">
        <li class="emember_all_members"><a href="?page=wp_eMember_manage" <?php echo ($memberlist->selected == 'all') ? 'class="current"' : "" ?>>
                All <span class="count">(<?php echo $memberlist->count['all']; ?>)</span></a> |</li>
        <li class="emember_active_members"><a href="?page=wp_eMember_manage&account_state=active" <?php echo ($memberlist->selected == 'active') ? 'class="current"' : "" ?>>
                Active <span class="count">(<?php echo $memberlist->count['active']; ?>)</span></a> |</li>
        <li class="emember_incomplete_members"><a href="?page=wp_eMember_manage&account_state=incomplete" <?php echo ($memberlist->selected == 'incomplete') ? 'class="current"' : "" ?>>
                Incomplete <span class="count">(<?php echo $memberlist->count['incomplete']; ?>)</span></a> |</li>
        <li class="emember_pending_members"><a href="?page=wp_eMember_manage&account_state=pending" <?php echo ($memberlist->selected == 'pending') ? 'class="current"' : "" ?>>
                Pending <span class="count">(<?php echo $memberlist->count['pending']; ?>)</span></a></li>
    </ul>
    <form method="get">
        <p class="search-box">
            <label class="screen-reader-text" for="search_id-search-input">
                search:</label>
            <?php $account_state = filter_input(INPUT_GET, 'account_state'); ?>
            <select name="account_state" id="emember-account-state">
                <option value="-1" selected="selected">Account State</option>
                <option <?php echo ($account_state == 'active') ? "selected='selected'" : ""; ?> value="active">Active</option>
                <option <?php echo ($account_state == 'inactive') ? "selected='selected'" : ""; ?> value="inactive">Inactive</option>
                <option <?php echo ($account_state == 'expired') ? "selected='selected'" : ""; ?> value="expired">Expired</option>
                <option <?php echo ($account_state == 'pending') ? "selected='selected'" : ""; ?> value="pending">Pending</option>
                <option <?php echo ($account_state == 'unsubscribed') ? "selected='selected'" : ""; ?> value="unsubscribed">Unsubscribed</option>
            </select>
            <label for="emember-membership-level" class="screen-reader-text">Search:</label>
            <?php $membership_level = filter_input(INPUT_GET, 'membership_level'); ?>
            <select name="membership_level" id="emember-membership-level">
                <option value="-1" selected="selected">Membership Level</option>
                <?php foreach ($all_levels as $level): ?>
                    <option <?php echo ($membership_level == $level->id) ? "selected='selected'" : ""; ?> value="<?php echo $level->id; ?>"><?php echo stripslashes($level->alias); ?></option>
                <?php endforeach; ?>
            </select>
            <input id="search_id-search-input" type="text" name="s" value="" />
            <input id="search-submit" class="button" type="submit" name="" value="search" />
            <input type="hidden" name="page" value="wp_eMember_manage" />
        </p>
        <?php $memberlist->display(); ?>
    </form>
</div>
