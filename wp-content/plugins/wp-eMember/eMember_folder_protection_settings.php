<?php

function eMember_folder_protection_settings_menu() {
    $message = "";
    $emember_config = Emember_Config::getInstance();

    if (isset($_GET['delete_record']) && isset($_GET['record_id'])) {//Need to delete a record
        $id = $_GET['record_id'];
        global $wpdb;
        $media_db_table_name = $wpdb->prefix . "emember_uploads";
        $guid = $wpdb->get_col("SELECT guid FROM $media_db_table_name WHERE id='$id'");

        if (isset($guid[0])) {
            $fileinfo = pathinfo($guid[0]);
            $filename = $fileinfo['basename'];
            $upload_dir = wp_upload_dir();
            $dir = $upload_dir['basedir'] . '/emember/downloads/';
            @unlink($dir . $filename);
            $updatedb = "DELETE FROM $media_db_table_name WHERE id='$id'";
            $results = $wpdb->query($updatedb);
            $message .= "Record successfully deleted!";
        }
    }
    if (isset($_POST['emem_add_manually_uploaded_file'])) {
        $upload_dir = wp_upload_dir();
        $filename = explode('.', $_POST['emember_manually_uploaded_filename']);
        $filename = $filename[0];
        $guid = $upload_dir['baseurl'] . '/emember/downloads/' . trim($_POST['emember_manually_uploaded_filename']);
        $date = trim($_POST['emember_manually_uploaded_date']);
        emember_add_uploaded_file_to_inventory($filename, $guid, $date);
        $message = "Saved Successfully.";
    }
    if (isset($_POST['emem_folder_protect'])) {
        $upload_dir = wp_upload_dir();

        $dir = $upload_dir['basedir'] . '/emember/downloads/';
        if (isset($_POST['emember_download_folder_protection'])) {
            $emember_config->setValue('emember_download_folder_protection', 1);
            $dir = $upload_dir['basedir'] . '/emember/downloads/';
            $htaccess = 'AuthUserFile ' . $dir . '.htpasswd' . "\n";
            $htaccess.= 'AuthName "eMember Protected Folder"' . "\n";
            $htaccess.= 'AuthType Basic' . "\n\n";
            $htaccess.= 'require valid-user' . "\n";
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            //Let's also create an empty index.html file in this folder
            $index_file = $dir . '/index.html';
            $handle = fopen($index_file, 'w');
            fclose($handle);

            $htpasswd = '';
            global $wpdb;
            $users = $wpdb->get_results('SELECT user_name, password FROM ' . $wpdb->prefix . 'wp_eMember_members_tbl');
            foreach ($users as $user) {
                if (!empty($user->user_name)) {//Do not add any entries where the username is empty
                    $htpasswd .= $user->user_name . ':' . $user->password . "\n";
                }
            }
            file_put_contents($dir . '.htaccess', $htaccess);
            file_put_contents($dir . '.htpasswd', $htpasswd);
            $message = "Download folder protection settings updated";
        } else {
            @unlink($dir . '.htaccess');
            @unlink($dir . '.htpasswd');
            $emember_config->setValue('emember_download_folder_protection', '');
            $message = "Download folder protection settings updated";
        }
        $emember_config->saveConfig();
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
        flush_rewrite_rules(true);
        echo '<script type="text/javascript">location.href="?page=eMember_admin_functions_menu&tab=2";</script>';
    }

    if (!empty($message)) {
        echo '<div id="message" class="updated fade"><p><strong>';
        echo $message;
        echo '</strong></p></div>';
    }
    ?>
    <div class="postbox">
        <h3><label for="title">Download Folder Protection</label></h3>
        <div class="inside">

            <div class="eMember_yellow_box">
                When this feature is enabled, any file you upload to the <code>"wp-content/uploads/emember/downloads"</code> folder will be protected. Only your members will be able to download any file(s) from that folder after providing their eMember username and password. You can upload your files to this folder using an FTP software or the media uploader below.
            </div>

            <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                <input type="checkbox" name="emember_download_folder_protection" id="emember_download_folder_protection"  <?php $protect_download = $emember_config->getValue('emember_download_folder_protection');
    echo ($protect_download) ? 'checked="checked"' : ''
    ?> value="1" />
                <i>Enable/Disable eMember Folder Protection</i>
                <input type="submit" name="emem_folder_protect" value="Update" class = "button-primary" />
            </form>

        </div></div>

    <div class="postbox">
        <h3><label for="title">eMember Media Uploader</label></h3>
        <div class="inside">
            <div id="emember-file-uploader">
                <noscript>
                <p>Please enable JavaScript to use file uploader.</p>
                <!-- or put a simple form for upload here -->
                </noscript>
            </div>
            <?php
            include_once('lib/class.emember.list_protected_media.php');
            //Create an instance of our list item class...
            $emember_list_table = new WP_eMember_List_Protected_Media();
            //Fetch, prepare, sort, and filter our data...

            $emember_list_table->prepare_items();
            //$form_post_url = $_REQUEST['page']."&tab=".$_REQUEST['tab'];//This can be handy if you need to post the form to a different post
            ?>
            <!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
            <form id="emember-protected-medias" method="POST">
                <!-- For plugins, we also need to ensure that the form posts back to our current page -->
                <input type="hidden" name="page" value="" />
                <!-- Now we can render the completed list table -->
    <?php $emember_list_table->display() ?>
            </form>
        </div></div>

    <div class="postbox">
        <h3><label for="title">Add Manually Uploaded File</label></h3>
        <div class="inside">

            <div class="eMember_yellow_box">
                If you manually uploaded a file to the protected folder using FTP, You Can add that file's information to eMember file inventory using this form after you have uploaded the file via FTP.
            </div>

            <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                <table>
                    <tr>
                        <td>File Name</td>
                        <td>
                            <input type="text" size="30" name="emember_manually_uploaded_filename" id="emember_manually_uploaded_filename"   value="" />
                            <i>Manually Uploaded File Name</i>
                        </td>
                    </tr>
                    <tr>
                        <td>Date</td>
                        <td><input type="date" name="emember_manually_uploaded_date" id="emember_manually_uploaded_date" value="">
                            <i> Upload Date </i></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="emem_add_manually_uploaded_file" value="Add" class = "button-primary" />
                        </td>
                    </tr>
                </table>
            </form>
        </div></div>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            var uploader = new qq.FileUploader({
                button_label: 'Upload a file',
                element: document.getElementById('emember-file-uploader'),
                action: '<?php echo admin_url("admin-ajax.php"); ?>',
                params: {'action': 'emember_file_upload'},
                onComplete: function(id, fileName, responseJSON) {
                    location.reload();
                }});
            $("#emember_manually_uploaded_date").dateinput({'format': 'yyyy-mm-dd', selectors: true, yearRange: [-100, 100]});
        });
    </script>
    <?php
}
?>
