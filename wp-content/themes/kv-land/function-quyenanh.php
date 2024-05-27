<?php
function form_review()
{
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'form_review') {
        $id_post = sanitize_text_field($_POST['id_post']);
        $title_post = sanitize_text_field($_POST['title_post']);
        $link_post = sanitize_text_field($_POST['link_post']);
        $star_quality = sanitize_text_field($_POST['star_quality']);
        $star_utilities = sanitize_text_field($_POST['star_utilities']);
        $star_location = sanitize_text_field($_POST['star_location']);
        $star_price = sanitize_text_field($_POST['star_price']);
        $star_value = sanitize_text_field($_POST['star_value']);
        $star_traffic = sanitize_text_field($_POST['star_traffic']);
        $star_point = sanitize_text_field($_POST['star_point']);
        $reviewer_name = sanitize_text_field($_POST['reviewer_name']);
        $note = sanitize_textarea_field($_POST['note']);
        $status = 0;
        $date_time = date('Y-m-d H:i:s');
        $date_time_cv = strtotime($date_time);
        if (!empty($reviewer_name) && !empty($note) && !empty($star_point)) {
            global $wpdb;
            $data = array(
                'id_post' => $id_post,
                'title_post' => $title_post,
                'link_post' => $link_post,
                'star_quality' => $star_quality,
                'star_utilities' => $star_utilities,
                'star_location' => $star_location,
                'star_price' => $star_price,
                'star_value' => $star_value,
                'star_traffic' => $star_traffic,
                'star_point' => $star_point,
                'status' => $status,
                'reviewer_name' => $reviewer_name,
                'note' => $note,
                'date_time' => $date_time_cv,
            );

            $format = array(
                '%d',
                '%s',
                '%s',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%d',
                '%f',
                '%d',
                '%s',
                '%s',
                '%d',
            );
            $wpdb->insert('wp_review', $data, $format);
            $_SESSION['error_code'] = 1;
            $message = 'success';
            $_SESSION['message'] = 'Bạn đã đánh giá thành công';
        } else {
            $_SESSION['error_code'] = 2;
            $_SESSION['message'] = 'Bạn đã đánh giá thất bại, vui lòng kiểm tra lại thông tin';
            $message = 'error';
        }
        $redirect_url = wp_get_referer();
        wp_redirect($redirect_url);
        exit;
    }
}
add_action('admin_post_form_review', 'form_review');
add_action('admin_post_nopriv_form_review', 'form_review');
function commentDelete() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'commentDelete' && isset($_POST['id'])) {
        $id = sanitize_text_field($_POST['id']);
        global $wpdb;
        $wpdb->delete($wpdb->prefix . 'review', array('id' => $id));

        wp_die();
    } else {
        wp_send_json_error('Invalid AJAX request');
    }
}
add_action('wp_ajax_commentDelete', 'commentDelete');
add_action('wp_ajax_nopriv_commentDelete', 'commentDelete');



function changeStatus()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'changeStatus') {
        $id = sanitize_text_field($_POST['id']);
        $status = sanitize_text_field($_POST['status']);
        global $wpdb;
        $wpdb->update($wpdb->prefix . 'review', array('status' => $status), array('id' => $id));
        die();
    }
}
add_action('wp_ajax_changeStatus', 'changeStatus');
add_action('wp_ajax_nopriv_changeStatus', 'changeStatus');


function perform_search() {
    global $wpdb;

    if (isset($_POST['action']) && $_POST['action'] === 'perform_search') {
        $status = isset($_POST['status']) ? sanitize_text_field($_POST['status']) : 2;
        $keyword = isset($_POST['keyword']) ? sanitize_text_field($_POST['keyword']) : '';

        $table_name_review = $wpdb->prefix . 'review';
        $query = "SELECT * FROM $table_name_review WHERE $table_name_review.title_post LIKE %s";
        $params = array('%' . $wpdb->esc_like($keyword) . '%');

        if ($status != 2) {
            $query .= " AND status = %d";
            $params[] = $status;
        }

        $query = $wpdb->prepare($query, $params);

        $results = $wpdb->get_results($query);
        wp_send_json($results);
    }
}

add_action('wp_ajax_perform_search', 'perform_search');
add_action('wp_ajax_nopriv_perform_search', 'perform_search');

