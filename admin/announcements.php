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
        } elseif (isset($_POST['delete_announcement'])) {
            $wpdb->delete($table_name, array('id' => intval($_POST['announcement_id'])));
        }
    }

    // Get all announcements
    $announcements = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");
    ?>
    <div class="wrap">
        <h1>Manage Announcements</h1>

        <!-- Add New Announcement Form -->
        <div class="card p-4 mb-4">
            <h2>Add New Announcement</h2>
            <form method="post" action="">
                <p>
                    <label for="title">Announcement Text:</label><br>
                    <input type="text" name="title" id="title" class="regular-text" required>
                </p>
                <p>
                    <label for="message">Detailed Message (optional):</label><br>
                    <textarea name="message" id="message" class="large-text" rows="3"></textarea>
                </p>
                <button type="submit" name="add_announcement" class="button button-primary">Add Announcement</button>
            </form>
        </div>

        <!-- List Existing Announcements -->
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
                    <td><?php echo esc_html($announcement->title); ?></td>
                    <td><?php echo date('Y-m-d H:i', strtotime($announcement->created_at)); ?></td>
                    <td><?php echo esc_html($announcement->status); ?></td>
                    <td>
                        <form method="post" action="" style="display:inline;">
                            <input type="hidden" name="announcement_id" value="<?php echo $announcement->id; ?>">
                            <button type="submit" name="delete_announcement" class="button button-link-delete" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}
