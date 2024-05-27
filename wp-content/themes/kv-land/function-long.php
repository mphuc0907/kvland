<?php
function getimage($id, $size = 'large', $true = '')
{

    if ($true == 'post') {
        if (get_the_post_thumbnail($id) != null) {
            return get_the_post_thumbnail_url($id, $size);
        }
    } else {
        $attachment_url = wp_get_attachment_image_url($id, $size);
        if ($attachment_url) {
            return $attachment_url;
        }
    }
    return get_field('image_no_image', 'option');

}

function register_ajaxurl()
{
    echo '<script type="text/javascript">
    var ajaxurl = "' . admin_url('admin-ajax.php') . '";
    var cms_adapter_ajax = function cms_adapter_ajax($param) {
        var beforeSend = $param.beforeSend || function() {};
        var complete = $param.complete || function() {}; //
            $.ajax({
                url: $param.url,
                type: $param.type,
                data: $param.data,
                beforeSend: beforeSend, 
                async: true,
                success: $param.callback,
                complete: complete 
             });
        };
  </script>';
}

add_action('wp_head', 'register_ajaxurl');

add_action('wp_ajax_sort_product', 'sort_product');
add_action('wp_ajax_nopriv_sort_product', 'sort_product');
function sort_product()
{
    session_start();
    global $wpdb;
    if (!empty($_POST['page_select'])) {
        $page_select = $_POST['page_select'];
    } else {
        $page_select = 1;
    }
//print_r($_POST);die();
    $args = array(
        'post_type' => 'project',
        'posts_per_page' => get_option('posts_per_page'),
        'paged' => $page_select,
        'tax_query' => array(
            'relation' => 'AND',
        ),
        'meta_query' => array(
            'relation' => 'AND',
        ),
        'orderby' => 'date', // Sắp xếp theo giá trị số của price_default
        'order' => 'desc', // Sắp xếp giảm dần (cao đến thấp)
    );

    if (!empty($_POST['type_project']) && $_POST['type_project'] != 0) {
        $search_type_project = sanitize_text_field($_POST['type_project']);
        $arr_meta_query = array(
            'taxonomy' => 'type_project',
            'field' => 'term_id',
            'terms' => $search_type_project
        );
        $args['tax_query'][] = $arr_meta_query;
    }
    if (!empty($_POST['keyword'])) {
        $search_type_project = sanitize_text_field($_POST['keyword']);
        $args['s'] = $search_type_project;
    }
    if (!empty($_POST['areas']) && $_POST['areas'] != 0) {
        $search_areas = sanitize_text_field($_POST['areas']);
        $arr_meta_query = array(
            'taxonomy' => 'areas',
            'field' => 'term_id',
            'terms' => $search_areas
        );
        $args['tax_query'][] = $arr_meta_query;
    }

    if (!empty($_POST['prices']) && $_POST['prices'] != 0) {
        $search_prices = sanitize_text_field($_POST['prices']);
        $arr_meta_query = array(
            'taxonomy' => 'prices',
            'field' => 'term_id',
            'terms' => $search_prices
        );
        $args['tax_query'][] = $arr_meta_query;
    }
    if (!empty($_POST['pro_stas']) && $_POST['pro_stas'] != 0) {
        $arr_meta_query = array(
            'taxonomy' => 'status_project',
            'field' => 'term_id',
            'terms' => sanitize_text_field($_POST['pro_stas']), // Đặt giá trị muốn so sánh
        );

        $args['tax_query'][] = $arr_meta_query;
    }

    if (!empty($_POST['company']) && $_POST['company'] !== 0) {

        $arr_meta_query = array(
            'key' => 'company',
            'value' => sanitize_text_field($_POST['company']), // Đặt giá trị muốn so sánh
            'compare' => '=',
            'type' => 'CHAR' // Kiểu dữ liệu của trường custom field
        );
        $args['meta_query'][] = $arr_meta_query;
    }

    $query_post = new WP_Query($args);
    $posst = $query_post->posts;


    if (!empty($posst)) {

        foreach ($posst as $key => $value) {
            $id_p = $value->ID;
            $cate = get_the_terms($id_p, 'status_project');
            $status_project = $cate[0]->name;
            $posst[$key]->img = getimage($id_p, 'large', 'post');
            $posst[$key]->url = get_permalink($id_p);
            $posst[$key]->status_project = $status_project;
            $posst[$key]->title = get_the_title($id_p);
            $posst[$key]->type_duan = get_the_terms($id_p, 'type_project')[0]->name;
            $posst[$key]->area = get_field('area', $id_p);
            $posst[$key]->address = get_field('address', $id_p);
            $posst[$key]->company = get_field('company', $id_p);
        }


        $max = $query_post->max_num_pages;
//        print_r($max);die();
        if ($max > 1) {
            $page = ' <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <li class="page-item number_page_prev" style="display: none" data-key="1">
                                            <a class="page-link" href="javascript:;" aria-label="Previous">
                                            <span aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16"
                                                     viewBox="0 0 17 16" fill="none">
                                                    <path d="M10.4995 13.781C10.3729 13.781 10.2462 13.7343 10.1462 13.6343L5.79953 9.28766C5.09286 8.58099 5.09286 7.42099 5.79953 6.71432L10.1462 2.36766C10.3395 2.17432 10.6595 2.17432 10.8529 2.36766C11.0462 2.56099 11.0462 2.88099 10.8529 3.07432L6.5062 7.42099C6.1862 7.74099 6.1862 8.26099 6.5062 8.58099L10.8529 12.9277C11.0462 13.121 11.0462 13.441 10.8529 13.6343C10.7529 13.7277 10.6262 13.781 10.4995 13.781Z"
                                                          fill="#292D32"/>
                                                </svg>
                                            </span>
                                            </a>
                                        </li>';
            $page .= ' <li class="page-item show_active number_page_1 active " data-key="1"><a
                                                    class="page-link" href="javascript:;">1</a></li>
                                        <li class="page-item near_1"><a href="javascript:;" class="page-link"><i
                                                        class="fas fa-ellipsis-h"></i></a></li>';
            for ($i = 2; $i <= $max; $i++):
                if ($max <= 6):
                    $page .= ' <li class="page-item show number_page number_page_' . $i . ' "
                        data-key="' . $i . '"><a
                                class="page-link" href="javascript:;">' . $i . '</a></li>';
                else:
                    if ($i < ($max)):
                        if ($i <= 3):
                            $page .= ' <li class="page-item show number_page  number_page_' . $i . ' "
                                data-key="' . $i . '"><a
                                        class="page-link" href="javascript:;">' . $i . '</a>
                            </li>';
                        else:
                            $page .= '<li class="page-item number_page  number_page_' . $i . ' "
                                data-key="' . $i . '"><a
                                        class="page-link" href="javascript:;">' . $i . '</a>
                           </li>';
                        endif;
                    endif;
                endif;
            endfor;
            if ($max > 6):
                $page .= ' <li class="page-item far_1"><a href="javascript:;" class="page-link"><i
                                                            class="fas fa-ellipsis-h"></i></a></li>


                                            <li class="page-item number_page show_active number_page_' . $max . ' "
                                                data-key="' . $max . '"><a class="page-link"
                                                                                                href="javascript:;">' . $max . '</a>
                                          </li>';
            endif;
            $page .= '<li class="page-item number_page_next" data-key="2">
                                            <a class="page-link" href="javascript:;" aria-label="Next">
                                            <span aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16"
                                                     viewBox="0 0 17 16" fill="none">
                                                    <path d="M6.43974 13.781C6.31307 13.781 6.18641 13.7343 6.08641 13.6343C5.89307 13.441 5.89307 13.121 6.08641 12.9277L10.4331 8.58099C10.7531 8.26099 10.7531 7.74099 10.4331 7.42099L6.08641 3.07432C5.89307 2.88099 5.89307 2.56099 6.08641 2.36766C6.27974 2.17432 6.59974 2.17432 6.79307 2.36766L11.1397 6.71432C11.4797 7.05432 11.6731 7.51432 11.6731 8.00099C11.6731 8.48766 11.4864 8.94766 11.1397 9.28766L6.79307 13.6343C6.69307 13.7277 6.56641 13.781 6.43974 13.781Z"
                                                          fill="#292D32"/>
                                                </svg>
                                            </span>
                                            </a>
                                        </li>

                                    </ul>
                                </nav>';
        } else {
            $page = '';
        }
        $rs['status'] = 0;
        $rs['data'] = $posst;
        $rs['page'] = $page;
    } else {
        $rs['status'] = 1;
        $rs['message'] = "Không có kết quả phù hợp";
        $rs['page'] = '';
    }
    returnajax($rs);
}

add_action('wp_ajax_sort_file', 'sort_file');
add_action('wp_ajax_nopriv_sort_file', 'sort_file');
function sort_file()
{
    session_start();
    global $wpdb;
    if (!empty($_POST['page_select'])) {
        $page_select = $_POST['page_select'];
    } else {
        $page_select = 1;
    }

    $args = array(
        'post_type' => 'project',
        'posts_per_page' => get_option('posts_per_page'),
        'paged' => $page_select,
        'tax_query' => array(
            'relation' => 'AND',
        ),
        'meta_query' => array(
            'relation' => 'AND',
        ),
        'orderby' => 'date', // Sắp xếp theo giá trị số của price_default
        'order' => 'desc', // Sắp xếp giảm dần (cao đến thấp)
    );

    if (!empty($_POST['type_project']) && $_POST['type_project'] != 0) {
        $arr_dm = array(
            'taxonomy' => 'type_project',
            'field' => 'term_id',
            'terms' => sanitize_text_field($_POST['type_project'])
        );
        $args['tax_query'][] = $arr_dm;
    }
    if (!empty($_POST['type_project']) && $_POST['type_project'] != 0) {
        $search_type_project = sanitize_text_field($_POST['type_project']);
        $arr_meta_query = array(
            'taxonomy' => 'type_project',
            'field' => 'term_id',
            'terms' => $search_type_project
        );
        $args['tax_query'][] = $arr_meta_query;
    }
    if (!empty($_POST['keyword'])) {
        $search_type_project = sanitize_text_field($_POST['keyword']);
        $args['s'] = $search_type_project;
    }
    if (!empty($_POST['areas']) && $_POST['areas'] != 0) {
        $search_areas = sanitize_text_field($_POST['areas']);
        $arr_meta_query = array(
            'taxonomy' => 'areas',
            'field' => 'term_id',
            'terms' => $search_areas
        );
        $args['tax_query'][] = $arr_meta_query;
    }

    if (!empty($_POST['prices']) && $_POST['prices'] != 0) {
        $search_prices = sanitize_text_field($_POST['prices']);
        $arr_meta_query = array(
            'taxonomy' => 'prices',
            'field' => 'term_id',
            'terms' => $search_prices
        );
        $args['tax_query'][] = $arr_meta_query;
    }
    if (!empty($_POST['status_project']) && $_POST['status_project'] != 0) {
        $arr_meta_query = array(
            'key' => 'status_project',
            'value' => sanitize_text_field($_POST['status_project']), // Đặt giá trị muốn so sánh
            'compare' => '=',
            'type' => 'NUMERIC' // Kiểu dữ liệu của trường custom field
        );

        $args['meta_query'][] = $arr_meta_query;
    }
    if (!empty($_POST['company']) && $_POST['company'] != 0) {
        $arr_meta_query = array(
            'key' => 'company',
            'value' => sanitize_text_field($_POST['company']), // Đặt giá trị muốn so sánh
            'compare' => '=',
            'type' => 'CHAR' // Kiểu dữ liệu của trường custom field
        );
        $args['meta_query'][] = $arr_meta_query;
    }
    $query_post = new WP_Query($args);
    $posst = $query_post->posts;
    if (!empty($posst)) {
        foreach ($posst as $key => $value) {
            $id_p = $value->ID;

            $posst[$key]->img = getimage($id_p, 'large', 'post');
            $posst[$key]->url = get_permalink($id_p);
            $posst[$key]->pos = get_term($_POST['position']);
            $posst[$key]->title = get_the_title($id_p);
            $posst[$key]->date_s = get_the_date('d/m/Y', $id_p);
            $posst[$key]->file_pdf = get_field('file_pdf', $id_p);

        }
        $max = $query_post->max_num_pages;
        if ($max > 1) {
            $page = ' <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <li class="page-item number_page_prev" style="display: none" data-key="1">
                                            <a class="page-link" href="javascript:;" aria-label="Previous">
                                            <span aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16"
                                                     viewBox="0 0 17 16" fill="none">
                                                    <path d="M10.4995 13.781C10.3729 13.781 10.2462 13.7343 10.1462 13.6343L5.79953 9.28766C5.09286 8.58099 5.09286 7.42099 5.79953 6.71432L10.1462 2.36766C10.3395 2.17432 10.6595 2.17432 10.8529 2.36766C11.0462 2.56099 11.0462 2.88099 10.8529 3.07432L6.5062 7.42099C6.1862 7.74099 6.1862 8.26099 6.5062 8.58099L10.8529 12.9277C11.0462 13.121 11.0462 13.441 10.8529 13.6343C10.7529 13.7277 10.6262 13.781 10.4995 13.781Z"
                                                          fill="#292D32"/>
                                                </svg>
                                            </span>
                                            </a>
                                        </li>';
            $page .= ' <li class="page-item show_active number_page_1 active " data-key="1"><a
                                                    class="page-link" href="javascript:;">1</a></li>
                                        <li class="page-item near_1"><a href="javascript:;" class="page-link"><i
                                                        class="fas fa-ellipsis-h"></i></a></li>';
            for ($i = 2; $i <= $max; $i++):
                if ($max <= 6):
                    $page .= ' <li class="page-item show number_page_' . $i . ' "
                        data-key="' . $i . '"><a
                                class="page-link" href="javascript:;">' . $i . '</a></li>';
                else:
                    if ($i < ($max)):
                        if ($i <= 3):
                            $page .= ' <li class="page-item show  number_page_' . $i . ' "
                                data-key="' . $i . '"><a
                                        class="page-link" href="javascript:;">' . $i . '</a>
                            </li>';
                        else:
                            $page .= '<li class="page-item  number_page_' . $i . ' "
                                data-key="' . $i . '"><a
                                        class="page-link" href="javascript:;">' . $i . '</a>
                           </li>';
                        endif;
                    endif;
                endif;
            endfor;
            if ($max > 6):
                $page .= ' <li class="page-item far_1"><a href="javascript:;" class="page-link"><i
                                                            class="fas fa-ellipsis-h"></i></a></li>


                                            <li class="page-item number_page show_active number_page_' . $max . ' "
                                                data-key="' . $max . '"><a class="page-link"
                                                                                                href="javascript:;">' . $max . '</a>
                                          </li>';
            endif;
            $page .= '<li class="page-item number_page_next" data-key="2">
                                            <a class="page-link" href="javascript:;" aria-label="Next">
                                            <span aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16"
                                                     viewBox="0 0 17 16" fill="none">
                                                    <path d="M6.43974 13.781C6.31307 13.781 6.18641 13.7343 6.08641 13.6343C5.89307 13.441 5.89307 13.121 6.08641 12.9277L10.4331 8.58099C10.7531 8.26099 10.7531 7.74099 10.4331 7.42099L6.08641 3.07432C5.89307 2.88099 5.89307 2.56099 6.08641 2.36766C6.27974 2.17432 6.59974 2.17432 6.79307 2.36766L11.1397 6.71432C11.4797 7.05432 11.6731 7.51432 11.6731 8.00099C11.6731 8.48766 11.4864 8.94766 11.1397 9.28766L6.79307 13.6343C6.69307 13.7277 6.56641 13.781 6.43974 13.781Z"
                                                          fill="#292D32"/>
                                                </svg>
                                            </span>
                                            </a>
                                        </li>

                                    </ul>
                                </nav>';
        } else {
            $page = '';
        }
        $rs['status'] = 0;
        $rs['data'] = $posst;
        $rs['page'] = $page;
    } else {
        $rs['status'] = 1;
        $rs['message'] = "Không có kết quả phù hợp";
        $rs['page'] = '';
    }
    returnajax($rs);
}

function returnajax($rs)
{
    echo json_encode($rs);
    die();
}

// Đăng ký endpoint trong REST API
function custom_acf_options_endpoint()
{

    register_rest_route('custom/v1', '/menu/', array(
        'methods' => 'GET',
        'callback' => 'custom_menu_endpoint',
        'args' => array(
            'menu_name' => array(
                'required' => true,
            ),
        ),
    ));
    register_rest_route('option_hex/v1', '/acf-options/', array(
        'methods' => 'GET',
        'callback' => 'get_acf_options_data',
    ));
}

add_action('rest_api_init', 'custom_acf_options_endpoint');

// Callback function để lấy dữ liệu từ option page
function get_acf_options_data()
{
    // Thực hiện các bước lấy dữ liệu từ option page ở đây
    // Ví dụ: $data = get_field('ten_truong_tuy_chon', 'option');
    $data['logo_header'] = get_field('logo_header', 'option');
    $data['favicon'] = get_field('favicon', 'option');
    $data['hotline_header'] = get_field('hotline_header', 'option');
    $data['contact_header'] = get_field('contact_header', 'option');
    $data['logo_footer'] = get_field('logo_footer', 'option');
    $data['network_social'] = get_field('network_social', 'option');
    $data['list_branch_footer'] = get_field('list_branch_footer', 'option');
    $data['copyright'] = get_field('copyright', 'option');
    $data['file_download'] = get_field('file_download', 'option');
    $data['image_no_image'] = get_field('image_no_image', 'option');
    $data['icon_menu'] = get_field('icon_menu', 'option');
    // Trả về dữ liệu dưới dạng JSON
    return rest_ensure_response($data);
}

function custom_menu_endpoint($data)
{
    $menu_name = $data['menu_name'];

    $menu_items = wp_get_nav_menu_items($menu_name);

    return $menu_items;
}

function money_check($srt)
{
    return number_format($srt, 0, '.', ',');
}

function quy_doi_so($so)
{
    if ($so >= 1000000000) {
        $value = round($so / 1000000000, 1);
        return $value == intval($value) ? intval($value) . ' tỷ' : "khoảng $value tỷ";
    } elseif ($so >= 1000000) {
        $value = round($so / 1000000, 1);
        return $value == intval($value) ? intval($value) . ' triệu' : "khoảng $value triệu";
    } elseif ($so >= 1000) {
        $value = round($so / 1000, 1);
        return $value == intval($value) ? intval($value) . 'K' : "khoảng $value K";
    } else {
        return $so;
    }
}

function tim_key_cuoi_cung_truoc_khi_khong_1($mang)
{
    $key_cuoi_cung = -1;
    foreach ($mang as $key => $phantu) {
        if ($phantu['status'] != 1) {
            break; // Thoát vòng lặp khi gặp phần tử có status khác 1
        }
        $key_cuoi_cung = $key; // Lưu lại key của phần tử có status = 1
    }
    return $key_cuoi_cung;
}

add_action('wp_ajax_loan_check', 'loan_check');
add_action('wp_ajax_nopriv_loan_check', 'loan_check');
function tinhKhoanVay($soTienVay, $laiSuatNam, $soThangVay)
{
    // Chuyển lãi suất từ năm sang tháng và tính số tiền lãi hàng tháng
    $laiSuatThang = $laiSuatNam / 12 / 100;

    // Số tiền gốc trả hàng tháng
    $soTienGocHangThang = round($soTienVay / $soThangVay);
    $bangTraGop = array();

    $duNo = $soTienVay;
    $tong_lai = 0;
    for ($ky = 1; $ky <= $soThangVay; $ky++) {
        // Số tiền lãi trả hàng tháng
        $soTienLaiHangThang = round($duNo * $laiSuatThang);
        $tong_lai += $soTienLaiHangThang;
        // Tổng tiền trả hàng tháng
        $tongTienTraHangThang = $soTienGocHangThang + $soTienLaiHangThang;
        // Dư nợ còn lại
        $duNo -= $soTienGocHangThang;

        // Tính toán cho hàng trong bảng
        $bangTraGop[] = array(
            'ky' => $ky,
            'pay' => $tongTienTraHangThang,
            'tienGoc' => $soTienGocHangThang,
            'tienLai' => $soTienLaiHangThang,
            'conLai' => $duNo
        );
    }
    $arr = array(
        'data' => $bangTraGop,
        'tong_lai' => $tong_lai,
        'tong' => $tong_lai + $soTienVay,
    );

    return $arr;
}

function tinhKhoanVay_cd($soTienVay, $laiSuatNam, $soThangVay)
{
    // Chuyển lãi suất từ năm sang tháng và tính số tiền lãi hàng tháng
    $laiSuatThang = $laiSuatNam / 1200;

    // Số tiền gốc trả hàng tháng
    $soTienGocHangThang = round($soTienVay / $soThangVay);
    $bangTraGop = array();

    $duNo = $soTienVay;
    $tong_lai = 0;
    for ($ky = 1; $ky <= $soThangVay; $ky++) {
        // Số tiền lãi trả hàng tháng
        $soTienLaiHangThang = round($soTienVay * $laiSuatThang);
        $tong_lai += $soTienLaiHangThang;
        // Tổng tiền trả hàng tháng
        $tongTienTraHangThang = $soTienGocHangThang + $soTienLaiHangThang;
        // Dư nợ còn lại
        $duNo -= $soTienGocHangThang;
        // Tính toán cho hàng trong bảng
        $bangTraGop[] = array(
            'ky' => $ky,
            'pay' => $tongTienTraHangThang,
            'tienGoc' => $soTienGocHangThang,
            'tienLai' => $soTienLaiHangThang,
            'conLai' => $duNo
        );
    }
    $arr = array(
        'data' => $bangTraGop,
        'tong_lai' => $tong_lai,
        'tong' => $tong_lai + $soTienVay,
    );

    return $arr;
}

function caculator($hinhthuc = 1, $nam = 1, $loan = 0, $laisuat = 0)
{
    $laisuat_m = $laisuat / 1200; // Lãi suất hàng tháng
    $month = $nam * 12; // Số kỳ trả nợ

    switch ($hinhthuc):
        case 1:
            $arr = tinhKhoanVay($loan, $laisuat, $month);
            break;
        case 2:
            $arr = tinhKhoanVay_cd($loan, $laisuat, $month);
            break;
        case 3:
            $pmt = $loan * $laisuat_m;
            $tong = $pmt * $month;
            break;
    endswitch;

    return $arr;
}

function loan_check()
{
    $giatri = $_POST['giatri'];
    $tilevay = $_POST['tilevay'];
    $loanvay = $_POST['loanvay'];
    $year_pay = $_POST['year_pay'];
    $input_lai_suat_vay = $_POST['input_lai_suat_vay'];
    $hinhthuc = $_POST['hinhthuc'];
    $money = caculator($hinhthuc, $year_pay, $loanvay, $input_lai_suat_vay);
    $von = ($giatri * (1 - ($tilevay / 100)));

    $goc_loan = $giatri * $tilevay / 100;
    $lai = $money['tong'] - $goc_loan;
    $arr = array(
        'von' => round($von),
        'goc_loan' => $goc_loan,
        'loan' => $lai,
        'pay_month' => $money['data'][0]['pay'],
        'data' => $money,
        'money_pay' => quy_doi_so(($money['tong']))
    );
    returnajax($arr);
}

function get_unique_custom_field_values()
{
    // Mảng để lưu trữ các giá trị unique của custom_field
    $args = array(
        'post_type' => 'project',
        'posts_per_page' => -1, // Hiển thị tất cả bài viết, không phân trang
        'orderby' => 'date', // hoặc thay đổi thành trường bạn muốn sắp xếp
        'order' => 'asc'
    );
    $search_query = new WP_Query($args);
    $posts = $search_query->posts;
    $unique_values = array();

    // Duyệt qua danh sách bài viết
    foreach ($posts as $post) {
        // Lấy giá trị của trường tùy chỉnh từ bài viết
        $custom_field_value = get_post_meta($post->ID, 'company', true);
        if (!empty($custom_field_value)):
            // Kiểm tra xem giá trị đã tồn tại trong mảng chưa
            if (!in_array($custom_field_value, $unique_values)) {
                // Nếu chưa tồn tại, thêm vào mảng
                $unique_values[] = $custom_field_value;
            }
        endif;
    }

    // Trả về mảng chứa các giá trị unique của custom_field
    return $unique_values;
}

add_action('wp_ajax_banggia_check', 'banggia_check');
add_action('wp_ajax_nopriv_banggia_check', 'banggia_check');


function banggia_check()
{
    $areas = sanitize_text_field($_POST['areass']);

    if (!empty($areas)) {
        $args_top_left = array(
            'post_type' => 'project',
            'posts_per_page' => 20,
            'tax_query' => array(
                array(
                    'taxonomy' => 'areas',
                    'field' => 'term_id', // hoặc 'slug', hoặc 'name' tùy thuộc vào cách bạn lưu trữ
                    'terms' => $areas,
                ),
            ),
        );

    } else {
        $args_top_left = array(
            'post_type' => 'project',
            'posts_per_page' => 20,
//                        'meta_query' => array(
//                            array(
//                                'key' => 'status_project',
//                                'value' => 1,
//                                'compare' => '='
//                            )
//                        )
        );
    }
    $query_status_1 = new WP_Query($args_top_left);
    $postss = $query_status_1->posts;
    foreach ($postss as $key => $value) {
        $postss[$key]->price_gia = !empty(get_field('price_project', $value->ID)) ? money_check(get_field('price_project', $value->ID)) : 'Liên hệ';
        $postss[$key]->url = get_permalink($value->ID);
    }
    $rs['status'] = 0;
    $rs['data'] = $postss;
    returnajax($rs);
}