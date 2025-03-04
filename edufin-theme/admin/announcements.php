<?php
if (!defined('ABSPATH')) exit;

function edufin_announcements_menu() {
    add_menu_page(
        'Announcements', 
        'Announcements', 
        'manage_options',
        'edufin-announcements',
        'edufin_announcements_page',
        'dashicons-megaphone',
        30
    );
}
add_action('admin_menu', 'edufin_announcements_menu');

function edufin_announcements_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'announcements';

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['add_announcement'])) {
            $wpdb->insert($table_name, array(
                'title' => sanitize_text_field($_POST['title']),
                'message' => sanitize_textarea_field($_POST['message']),
                'status' => 'active'
            ));
            echo '<div class="notice notice-success"><p>Announcement added successfully!</p></div>';
        } elseif (isset($_POST['delete_announcement'])) {
            $wpdb->delete($table_name, array('id' => intval($_POST['announcement_id'])));
            echo '<div class="notice notice-success"><p>Announcement deleted successfully!</p></div>';
        } elseif (isset($_POST['toggle_status'])) {
            $announcement = $wpdb->get_row($wpdb->prepare("SELECT status FROM $table_name WHERE id = %d", $_POST['announcement_id']));
            $new_status = $announcement->status === 'active' ? 'inactive' : 'active';
            $wpdb->update(
                $table_name,
                array('status' => $new_status),
                array('id' => intval($_POST['announcement_id']))
            );
        }
    }

    // Get all announcements
    $announcements = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline">Manage Announcements</h1>
        <hr class="wp-header-end">

        <!-- Add New Announcement Form -->
        <div class="card p-4 mb-4">
            <h2>Add New Announcement</h2>
            <form method="post" action="">
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="title">Announcement Text</label></th>
                        <td>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   class="regular-text" 
                                   required 
                                   placeholder="Enter announcement text">
                            <p class="description">This text will be displayed in the announcement banner.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="message">Detailed Message</label></th>
                        <td>
                            <textarea name="message" 
                                      id="message" 
                                      class="large-text" 
                                      rows="3" 
                                      placeholder="Optional: Enter a more detailed message"></textarea>
                            <p class="description">Optional: Add more details about this announcement.</p>
                        </td>
                    </tr>
                </table>
                <p class="submit">
                    <button type="submit" 
                            name="add_announcement" 
                            class="button button-primary">
                        Add Announcement
                    </button>
                </p>
            </form>
        </div>

        <!-- List Existing Announcements -->
        <div class="card">
            <h2 class="title">Current Announcements</h2>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Announcement</th>
                        <th>Created</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($announcements as $announcement): ?>
                    <tr>
                        <td>
                            <strong><?php echo esc_html($announcement->title); ?></strong>
                            <?php if ($announcement->message): ?>
                                <br>
                                <span class="description"><?php echo esc_html($announcement->message); ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo date('Y-m-d H:i', strtotime($announcement->created_at)); ?></td>
                        <td>
                            <span class="status-<?php echo $announcement->status; ?>">
                                <?php echo ucfirst($announcement->status); ?>
                            </span>
                        </td>
                        <td>
                            <form method="post" action="" style="display:inline;">
                                <input type="hidden" name="announcement_id" value="<?php echo $announcement->id; ?>">
                                <button type="submit" 
                                        name="toggle_status" 
                                        class="button button-small">
                                    <?php echo $announcement->status === 'active' ? 'Deactivate' : 'Activate'; ?>
                                </button>
                                <button type="submit" 
                                        name="delete_announcement" 
                                        class="button button-small button-link-delete" 
                                        onclick="return confirm('Are you sure you want to delete this announcement?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($announcements)): ?>
                    <tr>
                        <td colspan="4">No announcements found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .status-active {
            color: #2ea;
            font-weight: 500;
        }
        .status-inactive {
            color: #999;
        }
    </style>
    <?php
}
