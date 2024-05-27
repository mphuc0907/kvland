<?php
get_header();
$highlight_pro = get_field('highlight_pro');

$args_ll = array(
    'post_type' => 'project',
    'posts_per_page' => get_option('posts_per_page'),
    'paged' => max(1, get_query_var('paged')),
    'tax_query' => array(
        'relation' => 'AND',
    ),
    'meta_query' => array(
        'relation' => 'AND',
    ),
    'orderby' => 'date', // hoặc thay đổi thành trường bạn muốn sắp xếp
    'order' => 'asc'
);

$args = array(
    'post_type' => 'project',
    'posts_per_page' => -1, // Hiển thị tất cả bài viết, không phân trang
    'tax_query' => array(
        'relation' => 'AND',
    ),
    'orderby' => 'date', // hoặc thay đổi thành trường bạn muốn sắp xếp
    'order' => 'asc'
);
if(!empty($_GET['status_project'])){
    $status_project = sanitize_text_field($_GET['status_project']);
    $arr_meta_query = array(
        'taxonomy' => 'status_project',
        'field' => 'term_id',
        'terms' => $status_project
    );
    $args['tax_query'][] = $arr_meta_query;
}
if(!empty($_GET['type_project'])){
    $search_type_project = sanitize_text_field($_GET['type_project']);
    $arr_meta_query = array(
        'taxonomy' => 'type_project',
        'field' => 'term_id',
        'terms' => $search_type_project
    );
    $args_ll['tax_query'][] = $arr_meta_query;
}
if(!empty($_GET['s'])){
    $search_type_project = sanitize_text_field($_GET['s']);
    $args_ll['s'] = $search_type_project;
}
if(!empty($_GET['areas'])){
    $search_areas = sanitize_text_field($_GET['areas']);
    $arr_meta_query = array(
        'taxonomy' => 'areas',
        'field' => 'term_id',
        'terms' => $search_areas
    );
    $args_ll['tax_query'][] = $arr_meta_query;
}

if(!empty($_GET['prices'])){
    $search_prices = sanitize_text_field($_GET['prices']);
    $arr_meta_query = array(
        'taxonomy' => 'prices',
        'field' => 'term_id',
        'terms' => $search_prices
    );
    $args_ll['tax_query'][] = $arr_meta_query;
}

if(!empty($_GET['status_project'])){
    $status_project = sanitize_text_field($_GET['status_project']);
    $arr_meta_query = array(
        'taxonomy' => 'status_project',
        'field' => 'term_id',
        'terms' => $status_project
    );
    $args_ll['tax_query'][] = $arr_meta_query;
}
if (!empty($_GET['company']) && $_GET['company'] !== 0) {
    $arr_meta_query = array(
        'key' => 'company',
        'value' => sanitize_text_field($_GET['company']), // Đặt giá trị muốn so sánh
        'compare' => '=',
        'type' => 'CHAR' // Kiểu dữ liệu của trường custom field
    );
    $args_ll['meta_query'][] = $arr_meta_query;
}
$post_all = new WP_Query($args_ll);
// Tạo một truy vấn WP_Query dựa trên các thông số tìm kiếm
$search_query = new WP_Query($args);

// Lấy số lượng bài viết từ truy vấn
$search_count = $search_query->found_posts;


$type_pro = get_terms(
    array(
        'taxonomy' => 'type_project',
        'hide_empty' => false,
    )
);
$areas = get_terms(
    array(
        'taxonomy' => 'areas',
        'hide_empty' => false,
    )
);
$prices = get_terms(
    array(
        'taxonomy' => 'prices',
        'hide_empty' => false,
    )
);
$status_project_2 = get_terms(
    array(
        'taxonomy' => 'status_project',
        'hide_empty' => false,
    )
);

$company = get_unique_custom_field_values();
?>
<style>
    .pagination .number_page.show {
        display: block;
    }

    .pagination .number_page.show_active {
        display: block !important;
    }

    .pagination .number_page {
        display: none;
    }

    .pagination .near_1 {
        display: none;
    }
</style>
<section class="section-banner-da">
    <div class="image">
        <figure>
            <img src="http://kvland.wecan-group.info/wp-content/uploads/2024/02/img-22.png" alt="">
        </figure>
    </div>
    <div class="content">
        <div class="breckcum">
            <a href="<?= home_url() ?>">Trang chủ </a>
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M9.88712 7.52679L7.06045 4.70013C6.99847 4.63764 6.92474 4.58805 6.8435 4.5542C6.76226 4.52036 6.67512 4.50293 6.58712 4.50293C6.49911 4.50293 6.41197 4.52036 6.33073 4.5542C6.24949 4.58805 6.17576 4.63764 6.11378 4.70013C5.98962 4.82504 5.91992 4.994 5.91992 5.17013C5.91992 5.34625 5.98962 5.51522 6.11378 5.64013L8.47378 8.00013L6.11378 10.3601C5.98962 10.485 5.91992 10.654 5.91992 10.8301C5.91992 11.0063 5.98962 11.1752 6.11378 11.3001C6.17608 11.3619 6.24995 11.4108 6.33118 11.444C6.4124 11.4772 6.49938 11.494 6.58712 11.4935C6.67485 11.494 6.76183 11.4772 6.84305 11.444C6.92428 11.4108 6.99816 11.3619 7.06045 11.3001L9.88712 8.47346C9.9496 8.41149 9.9992 8.33775 10.033 8.25651C10.0669 8.17527 10.0843 8.08814 10.0843 8.00013C10.0843 7.91212 10.0669 7.82498 10.033 7.74374C9.9992 7.6625 9.9496 7.58877 9.88712 7.52679Z"
                          fill="white"/>
                </svg>
            </span>
            <span>Kết quả dự án tìm kiếm: <?= $_GET['s'] ?></span>
        </div>
        <form action="">
            <input type="hidden" name="s" value="<?=$_GET['s'] ?>">
            <div class="child">
                <label for="">Loại dự án</label>
                <select name="type_project" id="type_project">
                    <option value="">Chọn loại dự án</option>
                    <?php foreach ($type_pro as $value):
                        ?>
                        <option value="<?= $value->term_id ?>" <?=  !empty($search_type_project) && $search_type_project == $value->term_id ? 'selected' :'' ?>><?= $value->name ?></option>
                    <?php
                    endforeach; ?>
                </select>
            </div>
            <div class="child">
                <label for="">Khu vực</label>
                <select name="areas" id="areas">
                    <option value="">Tỉnh/ Thành phố</option>
                    <?php foreach ($areas as $value):
                        ?>
                        <option value="<?= $value->term_id ?>" <?=  !empty($search_areas) && $search_areas == $value->term_id ? 'selected' :'' ?>><?= $value->name ?></option>
                    <?php
                    endforeach;
                    ?>
                </select>
            </div>
            <div class="child">
                <label for="">Mức giá</label>
                <select name="prices" id="prices">
                    <option value="">Chọn mức giá</option>
                    <?php foreach ($prices as $value):
                        ?>
                        <option value="<?= $value->term_id ?>"  <?=  !empty($search_prices) && $search_prices == $value->term_id ? 'selected' :'' ?>><?= $value->name ?></option>
                    <?php
                    endforeach;
                    ?>
                </select>
            </div>
            <div class="child">
                <label for="">Trạng thái</label>
                <select name="status_project" id="status_project">
                    <option value="">Chọn trạng thái</option>
                    <?php foreach ($status_project_2 as $key => $value):
                        ?>
                        <option value="<?= $value->term_id ?>" <?=  !empty(sanitize_text_field($_GET['status_project'])) && sanitize_text_field($_GET['status_project']) == $value->term_id ? 'selected' :'' ?> ><?= $value->name ?></option>

                    <?php
                    endforeach; ?>
                </select>
            </div>
            <div class="child">
                <label for="">Chủ đầu tư</label>
                <select name="company" id="company">
                    <option value="">Chọn chủ đầu tư</option>
                    <?php foreach ($company as $value):

                        ?>
                        <option value="<?= $value ?>" <?=  !empty(sanitize_text_field($_GET['company'])) && sanitize_text_field($_GET['company']) == $value ? 'selected' :'' ?>><?= $value ?></option>
                    <?php
                    endforeach; ?>
                </select>
            </div>
            <button>Tìm kiếm</button>
        </form>
    </div>
</section>
<section class="section-da-3 section-search">
    <div class="container">
        <div class="content row">
            <div class="col-xl-8">
                <div class="col-left">
                    <div class="title">
                        <div class="left">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="29" viewBox="0 0 41 29"
                                 fill="none">
                                <path d="M0 17.1832L11.813 29.0001L40.5828 0.00390625H23.8563L11.7772 11.8526L0 0.456724V17.1832Z"
                                      fill="#A11D25"/>
                            </svg>
                            <h2>Dự án bất động sản</h2>
                        </div>
                        <div class="right">
                            <div class="child">
                                <p>Tổng số dự án:</p>
                                <span class="count_number"> <?= $search_count ?> dự án</span>
                            </div>
                            <div class="child">
                                <p>Trạng thái:</p>
                                <select name="pro_stas" id="pro_stas">
                                    <option value="">Tất cả</option>
                                    <?php foreach ($status_project_2 as $key => $value):
                                        ?>
                                        <option value="<?= $value->term_id ?>" <?=  !empty(sanitize_text_field($_GET['status_project'])) && sanitize_text_field($_GET['status_project']) == $value->term_id ? 'selected' :'' ?> ><?= $value->name ?></option>

                                    <?php
                                    endforeach; ?>

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="list row lisst_post">
                        <?php if ($post_all->have_posts()): ?>
                            <?php while ($post_all->have_posts()) :
                                $post_all->the_post();
                                $status_project = get_field('status_project');
                                if ($status_project == 1) {
                                    $status_project = 'Sắp mở bán';
                                } else if ($status_project == 2) {
                                    $status_project = 'Đang mở bán';
                                } else {
                                    $status_project = 'Đã bàn giao';
                                }
                                ?>
                                <div class="col-md-6 col-12">
                                    <div class="child">
                                        <div class="top">
                                            <div class="image">
                                                <figure>
                                                    <img src="<?= getimage(get_the_ID(), 'large', 'post') ?>"
                                                         alt="">
                                                </figure>
                                                <div class="info">
                                                    <p class="status">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                             viewBox="0 0 18 18" fill="none">
                                                            <path d="M17.25 17.0625H0.75C0.4425 17.0625 0.1875 16.8075 0.1875 16.5C0.1875 16.1925 0.4425 15.9375 0.75 15.9375H17.25C17.5575 15.9375 17.8125 16.1925 17.8125 16.5C17.8125 16.8075 17.5575 17.0625 17.25 17.0625Z"
                                                                  fill="white"/>
                                                            <path d="M14.835 17.0696C14.5275 17.0696 14.2725 16.8146 14.2725 16.5071V13.1621C14.2725 12.8546 14.5275 12.5996 14.835 12.5996C15.1425 12.5996 15.3975 12.8546 15.3975 13.1621V16.5071C15.3975 16.8146 15.15 17.0696 14.835 17.0696Z"
                                                                  fill="white"/>
                                                            <path d="M14.8502 13.7251C13.6277 13.7251 12.6377 12.7351 12.6377 11.5126V9.81017C12.6377 8.58767 13.6277 7.59766 14.8502 7.59766C16.0727 7.59766 17.0627 8.58767 17.0627 9.81017V11.5126C17.0627 12.7351 16.0727 13.7251 14.8502 13.7251ZM14.8502 8.73016C14.2502 8.73016 13.7627 9.21767 13.7627 9.81767V11.5201C13.7627 12.1201 14.2502 12.6077 14.8502 12.6077C15.4502 12.6077 15.9377 12.1201 15.9377 11.5201V9.81767C15.9377 9.21767 15.4502 8.73016 14.8502 8.73016Z"
                                                                  fill="white"/>
                                                            <path d="M10.7249 17.0628C10.4174 17.0628 10.1624 16.8078 10.1624 16.5003V4.52283C10.1624 3.33033 9.65987 2.82031 8.48987 2.82031H3.81738C2.63988 2.82031 2.12988 3.33033 2.12988 4.52283V16.5003C2.12988 16.8078 1.87488 17.0628 1.56738 17.0628C1.25988 17.0628 1.00488 16.8078 1.00488 16.5003V4.52283C1.00488 2.70033 2.00238 1.69531 3.81738 1.69531H8.48987C10.2974 1.69531 11.2874 2.70033 11.2874 4.52283V16.5003C11.2874 16.8078 11.0324 17.0628 10.7249 17.0628Z"
                                                                  fill="white"/>
                                                            <path d="M8.06212 6.75H4.34961C4.04211 6.75 3.78711 6.495 3.78711 6.1875C3.78711 5.88 4.04211 5.625 4.34961 5.625H8.06212C8.36962 5.625 8.62462 5.88 8.62462 6.1875C8.62462 6.495 8.36962 6.75 8.06212 6.75Z"
                                                                  fill="white"/>
                                                            <path d="M8.06212 9.5625H4.34961C4.04211 9.5625 3.78711 9.3075 3.78711 9C3.78711 8.6925 4.04211 8.4375 4.34961 8.4375H8.06212C8.36962 8.4375 8.62462 8.6925 8.62462 9C8.62462 9.3075 8.36962 9.5625 8.06212 9.5625Z"
                                                                  fill="white"/>
                                                            <path d="M6.1875 17.0625C5.88 17.0625 5.625 16.8075 5.625 16.5V13.6875C5.625 13.38 5.88 13.125 6.1875 13.125C6.495 13.125 6.75 13.38 6.75 13.6875V16.5C6.75 16.8075 6.495 17.0625 6.1875 17.0625Z"
                                                                  fill="white"/>
                                                        </svg>
                                                        <?= $status_project ?>
                                                    </p>
<!--                                                    <p class="acreage">-->
<!--                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"-->
<!--                                                             viewBox="0 0 18 18" fill="none">-->
<!--                                                            <path d="M11.25 17.0625H6.75C2.6775 17.0625 0.9375 15.3225 0.9375 11.25V6.75C0.9375 2.6775 2.6775 0.9375 6.75 0.9375H11.25C15.3225 0.9375 17.0625 2.6775 17.0625 6.75V11.25C17.0625 15.3225 15.3225 17.0625 11.25 17.0625ZM6.75 2.0625C3.2925 2.0625 2.0625 3.2925 2.0625 6.75V11.25C2.0625 14.7075 3.2925 15.9375 6.75 15.9375H11.25C14.7075 15.9375 15.9375 14.7075 15.9375 11.25V6.75C15.9375 3.2925 14.7075 2.0625 11.25 2.0625H6.75Z"-->
<!--                                                                  fill="white"/>-->
<!--                                                            <path d="M10.4626 17.0625C10.2076 17.0625 9.98254 16.89 9.91504 16.635L6.20257 1.63501C6.12757 1.33501 6.31506 1.02752 6.61506 0.952521C6.91506 0.877521 7.22254 1.05752 7.29754 1.36502L11.0101 16.365C11.0851 16.665 10.8976 16.9725 10.5976 17.0475C10.5526 17.055 10.5076 17.0625 10.4626 17.0625Z"-->
<!--                                                                  fill="white"/>-->
<!--                                                            <path d="M1.49989 11.8129C1.25239 11.8129 1.03491 11.6554 0.959911 11.4079C0.869911 11.1079 1.04237 10.8004 1.34237 10.7104L8.48989 8.62544C8.78989 8.53544 9.09739 8.70793 9.18739 9.00793C9.27739 9.30793 9.10488 9.61544 8.80488 9.70544L1.65741 11.7904C1.60491 11.8054 1.55239 11.8129 1.49989 11.8129Z"-->
<!--                                                                  fill="white"/>-->
<!--                                                        </svg>-->
<!--                                                        Diện tích: --><?//= get_field('area') ?>
<!--                                                    </p>-->
                                                </div>
                                            </div>
                                            <div class="text">
                                                <div class="category">
                                                    <span>Dự án</span>
                                                </div>
                                                <div class="name">
                                                    <a href="<?= get_permalink() ?>"><?= get_the_title() ?></span></a>
                                                </div>
                                                <div class="desc">
                                                    <p><strong>Vị trí:</strong>
                                                        <span><?= get_field('address') ?></span></p>
<!--                                                    <p><strong>Diện tích:</strong>-->
<!--                                                        <span>--><?//= get_field('area') ?><!--</span></p>-->
                                                    <p><strong>Chủ đầu tư:</strong>
                                                        <span><?= get_field('company') ?></span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="action">
                                            <div class="left">
                                                <a href="<?= get_permalink() ?>" class="advise">Tư vấn cho tôi</a>
                                                <a href="<?= get_permalink() ?>#vitri" class="location">Vị trí</a>
                                            </div>
                                            <div class="right">
                                                <a href="<?= get_permalink() ?>#review_scroll">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"
                                                         viewBox="0 0 14 16" fill="none">
                                                        <path d="M2.69333 13.0137C2.28667 13.0137 1.90667 12.8737 1.63333 12.6137C1.28667 12.287 1.12 11.7937 1.18 11.2604L1.42667 9.10036C1.47333 8.69369 1.72 8.15369 2.00667 7.86036L7.48 2.06702C8.84667 0.620358 10.2733 0.580358 11.72 1.94703C13.1667 3.31369 13.2067 4.74036 11.84 6.18703L6.36667 11.9804C6.08667 12.2804 5.56667 12.5604 5.16 12.627L3.01333 12.9937C2.9 13.0004 2.8 13.0137 2.69333 13.0137ZM9.62 1.94036C9.10667 1.94036 8.66 2.26036 8.20667 2.74036L2.73333 8.54036C2.6 8.68036 2.44667 9.01369 2.42 9.20703L2.17333 11.367C2.14667 11.587 2.2 11.767 2.32 11.8804C2.44 11.9937 2.62 12.0337 2.84 12.0004L4.98667 11.6337C5.18 11.6004 5.5 11.427 5.63333 11.287L11.1067 5.49369C11.9333 4.61369 12.2333 3.80036 11.0267 2.66702C10.4933 2.15369 10.0333 1.94036 9.62 1.94036Z"
                                                              fill="#1479DE"/>
                                                        <path d="M10.56 7.30036C10.5467 7.30036 10.5267 7.30036 10.5133 7.30036C8.43333 7.09369 6.76 5.51369 6.44 3.44703C6.4 3.17369 6.58667 2.92036 6.86 2.87369C7.13333 2.83369 7.38667 3.02036 7.43333 3.29369C7.68667 4.90703 8.99333 6.14703 10.62 6.30703C10.8933 6.33369 11.0933 6.58036 11.0667 6.85369C11.0333 7.10703 10.8133 7.30036 10.56 7.30036Z"
                                                              fill="#1479DE"/>
                                                        <path d="M13 15.167H1C0.726667 15.167 0.5 14.9404 0.5 14.667C0.5 14.3937 0.726667 14.167 1 14.167H13C13.2733 14.167 13.5 14.3937 13.5 14.667C13.5 14.9404 13.2733 15.167 13 15.167Z"
                                                              fill="#1479DE"/>
                                                    </svg>
                                                    Đánh giá dự án
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <p>Không có kết quả phù hợp</p>
                        <?php endif;
                        wp_reset_postdata(); ?>
                    </div>
                    <div class="page_arr">
                        <?php if ($post_all->max_num_pages > 1): ?>

                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item number_page_prev" data-key="1">
                                        <a class="page-link" href="javascript:;" aria-label="Previous">
                                            <span aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16"
                                                     viewBox="0 0 17 16" fill="none">
                                                    <path d="M10.4995 13.781C10.3729 13.781 10.2462 13.7343 10.1462 13.6343L5.79953 9.28766C5.09286 8.58099 5.09286 7.42099 5.79953 6.71432L10.1462 2.36766C10.3395 2.17432 10.6595 2.17432 10.8529 2.36766C11.0462 2.56099 11.0462 2.88099 10.8529 3.07432L6.5062 7.42099C6.1862 7.74099 6.1862 8.26099 6.5062 8.58099L10.8529 12.9277C11.0462 13.121 11.0462 13.441 10.8529 13.6343C10.7529 13.7277 10.6262 13.781 10.4995 13.781Z"
                                                          fill="#292D32"/>
                                                </svg>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="page-item show_active number_page_1 active " data-key="1"><a
                                                class="page-link" href="javascript:;">1</a></li>
                                    <li class="page-item near_1"><a href="javascript:;" class="page-link"><i
                                                    class="fas fa-ellipsis-h"></i></a></li>
                                    <?php for ($i = 2; $i <= $post_all->max_num_pages; $i++): ?>
                                        <?php if ($post_all->max_num_pages <= 6): ?>
                                            <li class="page-item show number_page_<?= $i ?> "
                                                data-key="<?= $i ?>"><a
                                                        class="page-link" href="javascript:;"><?= $i ?></a></li>
                                        <?php else: ?>
                                            <?php if ($i < ($post_all->max_num_pages)): ?>
                                                <?php if ($i <= 3): ?>
                                                    <li class="page-item number_page show  number_page_<?= $i ?> "
                                                        data-key="<?= $i ?>"><a
                                                                class="page-link" href="javascript:;"><?= $i ?></a>
                                                    </li>
                                                <?php else: ?>
                                                    <li class="page-item number_page  number_page_<?= $i ?> "
                                                        data-key="<?= $i ?>"><a
                                                                class="page-link" href="javascript:;"><?= $i ?></a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                    <?php if ($post_all->max_num_pages > 6): ?>
                                        <li class="page-item far_1"><a href="javascript:;" class="page-link"><i
                                                        class="fas fa-ellipsis-h"></i></a></li>


                                        <li class="page-item number_page show_active number_page_<?= $post_all->max_num_pages ?> "
                                            data-key="<?= $post_all->max_num_pages ?>"><a class="page-link"
                                                                                          href="javascript:;"><?= $post_all->max_num_pages ?></a>
                                        </li>
                                    <?php endif; ?>
                                    <li class="page-item number_page_next" data-key="1">
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
                            </nav>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="col-right">
                    <div class="fillter">
                        <div class="child">
                            <div class="name">
                                <h4>Loại dự án</h4>
                            </div>
                            <div class="list">
                                <div class="item">
                                    <div class="left">
                                        <input type="radio" name="type_project" id="type_project" value="" <?= !empty($search_type_project) ? '' : 'checked'  ?>>
                                        <label for="type_project">
                                            Tất cả
                                        </label>
                                    </div>
                                    <span><?= $search_count ?></span>
                                </div>
                                <?php foreach ($type_pro as $key => $value):
                                    $args = array(
                                        'post_type'      => 'project', // Đổi thành loại bài viết của bạn
                                        'posts_per_page' => -1, // Hiển thị tất cả bài viết
                                        'tax_query'      => array(
                                            'relation' => 'AND',

                                            array(
                                                'taxonomy' => 'type_project',
                                                'field'    => 'term_id',
                                                'terms'    => $value->term_id,
                                            ),
                                        ),
                                    );
                                    if(!empty($_GET['status_project'])){
                                        $status_project = sanitize_text_field($_GET['status_project']);
                                        $arr_meta_query = array(
                                            'taxonomy' => 'status_project',
                                            'field' => 'term_id',
                                            'terms' => $status_project
                                        );
                                        $args['tax_query'][] = $arr_meta_query;
                                    }
                                    $query = new WP_Query($args);

                                    // Lấy số lượng bài viết cho địa điểm hiện tại
                                    $post_count = $query->found_posts
                                    ?>
                                    <div class="item">
                                        <div class="left">
                                            <input type="radio" value="<?= $value->term_id ?>"  <?= $search_type_project == $value->term_id ? 'checked' : '' ?>  name="type_project" id="type_project_<?= $value->term_id ?>">
                                            <label for="type_project_<?= $value->term_id ?>">
                                                <?= $value->name ?>
                                            </label>
                                        </div>
                                        <span><?= $post_count ?></span>
                                    </div>
                                    <?php
                                    wp_reset_postdata();
                                endforeach; ?>
                            </div>
                        </div>
                        <div class="child">
                            <div class="name">
                                <h4>Khu vực</h4>
                            </div>
                            <div class="list">
                                <div class="item">
                                    <div class="left">
                                        <input type="radio" name="areas" id="areas" value="" <?= !empty($search_areas) ? '' : 'checked'  ?>>
                                        <label for="areas">
                                            Tất cả
                                        </label>
                                    </div>
                                    <span><?= $search_count ?></span>
                                </div>
                                <?php foreach ($areas as $key => $value):
                                    $args = array(
                                        'post_type'      => 'project', // Đổi thành loại bài viết của bạn
                                        'posts_per_page' => -1, // Hiển thị tất cả bài viết
                                        'tax_query'      => array(
                                            'relation' => 'AND',
                                            array(
                                                'taxonomy' => 'areas',
                                                'field'    => 'term_id',
                                                'terms'    => $value->term_id,
                                            ),
                                        ),
                                    );
                                    if(!empty($_GET['status_project'])){
                                        $status_project = sanitize_text_field($_GET['status_project']);
                                        $arr_meta_query = array(
                                            'taxonomy' => 'status_project',
                                            'field' => 'term_id',
                                            'terms' => $status_project
                                        );
                                        $args['tax_query'][] = $arr_meta_query;
                                    }
                                    $query = new WP_Query($args);

                                    // Lấy số lượng bài viết cho địa điểm hiện tại
                                    $post_count = $query->found_posts
                                    ?>
                                    <div class="item">
                                        <div class="left">
                                            <input type="radio" value="<?= $value->term_id ?>"  <?= $search_areas == $value->term_id ? 'checked' : '' ?>  name="areas" id="areas_<?= $value->term_id ?>">
                                            <label for="areas_<?= $value->term_id ?>">
                                                <?= $value->name ?>
                                            </label>
                                        </div>
                                        <span><?= $post_count ?></span>
                                    </div>
                                    <?php
                                    wp_reset_postdata();
                                endforeach; ?>
                            </div>
                        </div>
                        <div class="child">
                            <div class="name">
                                <h4>Mức giá</h4>
                            </div>
                            <div class="list">
                                <div class="item">
                                    <div class="left">
                                        <input type="radio" name="prices" id="prices_0" value="" <?= !empty($search_prices) ? '' : 'checked'  ?>>
                                        <label for="prices">
                                            Tất cả
                                        </label>
                                    </div>
                                    <span><?= $search_count ?></span>
                                </div>
                                <?php
                                foreach ($prices as $key => $value):
                                    $args = array(
                                        'post_type'      => 'project', // Đổi thành loại bài viết của bạn
                                        'posts_per_page' => -1, // Hiển thị tất cả bài viết
                                        'tax_query'      => array(
                                            'relation' => 'AND',

                                            array(
                                                'taxonomy' => 'prices',
                                                'field'    => 'term_id',
                                                'terms'    => $value->term_id,
                                            ),
                                        ),
                                    );
                                    if(!empty($_GET['status_project'])){
                                        $status_project = sanitize_text_field($_GET['status_project']);
                                        $arr_meta_query = array(
                                            'taxonomy' => 'status_project',
                                            'field' => 'term_id',
                                            'terms' => $status_project
                                        );
                                        $args['tax_query'][] = $arr_meta_query;
                                    }
                                    $query = new WP_Query($args);

                                    // Lấy số lượng bài viết cho địa điểm hiện tại
                                    $post_count = $query->found_posts;
                                    ?>
                                    <div class="item">
                                        <div class="left">
                                            <input type="radio" value="<?= $value->term_id ?>"  <?= $search_prices == $value->term_id ? 'checked' : '' ?>  name="prices" id="prices_<?= $value->term_id ?>">
                                            <label for="prices_<?= $value->term_id ?>">
                                                <?= $value->name ?>
                                            </label>
                                        </div>
                                        <span><?= $post_count ?></span>
                                    </div>
                                    <?php
                                    wp_reset_postdata();
                                endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
?>
<script>
    $(document).ready(function () {
        $('.number_page_prev ').hide();
        var dem = 1;
        var pro_stas = $('#pro_stas').val();
        var type_project = $('input[name="type_project"]:checked').val();
        var areas = $('input[name="areas"]:checked').val();
        var prices = $('input[name="prices"]:checked').val();
        var company = '<?=  !empty(sanitize_text_field($_GET['company'])) ? sanitize_text_field($_GET['company']): '' ?>';
        var keyword = '<?=  !empty(sanitize_text_field($_GET['s'])) ? sanitize_text_field($_GET['s']): '' ?>';
        var count = parseInt(<?= $post_all->max_num_pages ?>);
        $('.construction_design').on('click', function () {
            construction_design = $(this).val();
            dem = 1;
            ajax_sort();
        });
        $('#pro_stas').on('change', function () {
            pro_stas = $(this).val();
            dem = 1;
            ajax_sort();
        });
        $('input[name="type_project"]').on('change', function(){
            type_project = $('input[name="type_project"]:checked').val();
            dem = 1;
            ajax_sort();
        });
        $('input[name="areas"]').on('change', function(){
            areas = $('input[name="areas"]:checked').val();
            dem = 1;
            ajax_sort();
        });
        $('input[name="prices"]').on('change', function(){
            prices = $('input[name="prices"]:checked').val();
            dem = 1;
            ajax_sort();
        });
        function ajax_sort() {
            var $data = {
                'page_select': dem,
                'pro_stas': pro_stas,
                'type_project': type_project,
                'areas': areas,
                'prices': prices,
                'company': company,
                'keyword': keyword,
                'action': 'sort_product'
            };
            var $param = {
                'type': 'POST',
                'url': ajaxurl,
                'beforeSend': function () {
                    $("#loader").show();

                },
                'complete': function () {
                    $("#loader").hide();
                    $(".tabs-content").show();
                },
                'data': $data,
                'callback': function (data) {
                    var res = JSON.parse(data);
                    if (res.status === 0) {
                        var content = res.data;
                        var html = '';
                        content.forEach(function (item, index) {
                            console.log(item);
                            html += '<div class="col-6">\n' +
                                '                                        <div class="child">\n' +
                                '                                            <div class="image">\n' +
                                '                                                <figure>\n' +
                                '                                                    <img src="'+ item.img +'" alt="">\n' +
                                '                                                </figure>\n' +
                                '                                                <div class="info">\n' +
                                '                                                    <p class="status">\n' +
                                '                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">\n' +
                                '                                                            <path d="M17.25 17.0625H0.75C0.4425 17.0625 0.1875 16.8075 0.1875 16.5C0.1875 16.1925 0.4425 15.9375 0.75 15.9375H17.25C17.5575 15.9375 17.8125 16.1925 17.8125 16.5C17.8125 16.8075 17.5575 17.0625 17.25 17.0625Z" fill="white"></path>\n' +
                                '                                                            <path d="M14.835 17.0696C14.5275 17.0696 14.2725 16.8146 14.2725 16.5071V13.1621C14.2725 12.8546 14.5275 12.5996 14.835 12.5996C15.1425 12.5996 15.3975 12.8546 15.3975 13.1621V16.5071C15.3975 16.8146 15.15 17.0696 14.835 17.0696Z" fill="white"></path>\n' +
                                '                                                            <path d="M14.8502 13.7251C13.6277 13.7251 12.6377 12.7351 12.6377 11.5126V9.81017C12.6377 8.58767 13.6277 7.59766 14.8502 7.59766C16.0727 7.59766 17.0627 8.58767 17.0627 9.81017V11.5126C17.0627 12.7351 16.0727 13.7251 14.8502 13.7251ZM14.8502 8.73016C14.2502 8.73016 13.7627 9.21767 13.7627 9.81767V11.5201C13.7627 12.1201 14.2502 12.6077 14.8502 12.6077C15.4502 12.6077 15.9377 12.1201 15.9377 11.5201V9.81767C15.9377 9.21767 15.4502 8.73016 14.8502 8.73016Z" fill="white"></path>\n' +
                                '                                                            <path d="M10.7249 17.0628C10.4174 17.0628 10.1624 16.8078 10.1624 16.5003V4.52283C10.1624 3.33033 9.65987 2.82031 8.48987 2.82031H3.81738C2.63988 2.82031 2.12988 3.33033 2.12988 4.52283V16.5003C2.12988 16.8078 1.87488 17.0628 1.56738 17.0628C1.25988 17.0628 1.00488 16.8078 1.00488 16.5003V4.52283C1.00488 2.70033 2.00238 1.69531 3.81738 1.69531H8.48987C10.2974 1.69531 11.2874 2.70033 11.2874 4.52283V16.5003C11.2874 16.8078 11.0324 17.0628 10.7249 17.0628Z" fill="white"></path>\n' +
                                '                                                            <path d="M8.06212 6.75H4.34961C4.04211 6.75 3.78711 6.495 3.78711 6.1875C3.78711 5.88 4.04211 5.625 4.34961 5.625H8.06212C8.36962 5.625 8.62462 5.88 8.62462 6.1875C8.62462 6.495 8.36962 6.75 8.06212 6.75Z" fill="white"></path>\n' +
                                '                                                            <path d="M8.06212 9.5625H4.34961C4.04211 9.5625 3.78711 9.3075 3.78711 9C3.78711 8.6925 4.04211 8.4375 4.34961 8.4375H8.06212C8.36962 8.4375 8.62462 8.6925 8.62462 9C8.62462 9.3075 8.36962 9.5625 8.06212 9.5625Z" fill="white"></path>\n' +
                                '                                                            <path d="M6.1875 17.0625C5.88 17.0625 5.625 16.8075 5.625 16.5V13.6875C5.625 13.38 5.88 13.125 6.1875 13.125C6.495 13.125 6.75 13.38 6.75 13.6875V16.5C6.75 16.8075 6.495 17.0625 6.1875 17.0625Z" fill="white"></path>\n' +
                                '                                                        </svg>\n' +
                                '                                                        '+ item.status_project +'                                                    </p>\n' +
                                // '                                                    <p class="acreage">\n' +
                                // '                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">\n' +
                                // '                                                            <path d="M11.25 17.0625H6.75C2.6775 17.0625 0.9375 15.3225 0.9375 11.25V6.75C0.9375 2.6775 2.6775 0.9375 6.75 0.9375H11.25C15.3225 0.9375 17.0625 2.6775 17.0625 6.75V11.25C17.0625 15.3225 15.3225 17.0625 11.25 17.0625ZM6.75 2.0625C3.2925 2.0625 2.0625 3.2925 2.0625 6.75V11.25C2.0625 14.7075 3.2925 15.9375 6.75 15.9375H11.25C14.7075 15.9375 15.9375 14.7075 15.9375 11.25V6.75C15.9375 3.2925 14.7075 2.0625 11.25 2.0625H6.75Z" fill="white"></path>\n' +
                                // '                                                            <path d="M10.4626 17.0625C10.2076 17.0625 9.98254 16.89 9.91504 16.635L6.20257 1.63501C6.12757 1.33501 6.31506 1.02752 6.61506 0.952521C6.91506 0.877521 7.22254 1.05752 7.29754 1.36502L11.0101 16.365C11.0851 16.665 10.8976 16.9725 10.5976 17.0475C10.5526 17.055 10.5076 17.0625 10.4626 17.0625Z" fill="white"></path>\n' +
                                // '                                                            <path d="M1.49989 11.8129C1.25239 11.8129 1.03491 11.6554 0.959911 11.4079C0.869911 11.1079 1.04237 10.8004 1.34237 10.7104L8.48989 8.62544C8.78989 8.53544 9.09739 8.70793 9.18739 9.00793C9.27739 9.30793 9.10488 9.61544 8.80488 9.70544L1.65741 11.7904C1.60491 11.8054 1.55239 11.8129 1.49989 11.8129Z" fill="white"></path>\n' +
                                // '                                                        </svg>\n' +
                                // '                                                        Diện tích:'+ item.area +'</p>\n' +
                                '                                                </div>\n' +
                                '                                            </div>\n' +
                                '                                            <div class="text">\n' +
                                '                                                <div class="category">\n' +
                                '                                                    <span>'+ item.type_duan +'</span>\n' +
                                '                                                </div>\n' +
                                '                                                <div class="name">\n' +
                                '                                                    <a href="'+ item.url +'">'+ item.title +'</a>\n' +
                                '                                                </div>\n' +
                                '                                                <div class="desc">\n' +
                                '                                                    <p><strong>Vị trí:</strong>\n' +
                                '                                                        <span>'+ item.address +'</span></p>\n' +
                                // '                                                    <p><strong>Diện tích:</strong>\n' +
                                // '                                                        <span>'+ item.area +'</span></p>\n' +
                                '                                                    <p><strong>Chủ đầu tư:</strong>\n' +
                                '                                                        <span>'+ item.company +'</span></p>\n' +
                                '                                                </div>\n' +
                                '                                                <div class="action">\n' +
                                '<div class="left"> ' +
                                '<a href="'+ item.url +'" class="advise">Tư vấn cho tôi</a>\n' +
                                '<a href="'+ item.url +'#vitri" class="location">Vị trí</a>' +
                                '                            </div>' +
                                '                            <div class="right">' +
                                '                                <a href="'+ item.url +'#review_scroll">' +
                                '   <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"\n' +
                                '                            viewBox="0 0 14 16" fill="none">\n' +
                                '                                <path d="M2.69333 13.0137C2.28667 13.0137 1.90667 12.8737 1.63333 12.6137C1.28667 12.287 1.12 11.7937 1.18 11.2604L1.42667 9.10036C1.47333 8.69369 1.72 8.15369 2.00667 7.86036L7.48 2.06702C8.84667 0.620358 10.2733 0.580358 11.72 1.94703C13.1667 3.31369 13.2067 4.74036 11.84 6.18703L6.36667 11.9804C6.08667 12.2804 5.56667 12.5604 5.16 12.627L3.01333 12.9937C2.9 13.0004 2.8 13.0137 2.69333 13.0137ZM9.62 1.94036C9.10667 1.94036 8.66 2.26036 8.20667 2.74036L2.73333 8.54036C2.6 8.68036 2.44667 9.01369 2.42 9.20703L2.17333 11.367C2.14667 11.587 2.2 11.767 2.32 11.8804C2.44 11.9937 2.62 12.0337 2.84 12.0004L4.98667 11.6337C5.18 11.6004 5.5 11.427 5.63333 11.287L11.1067 5.49369C11.9333 4.61369 12.2333 3.80036 11.0267 2.66702C10.4933 2.15369 10.0333 1.94036 9.62 1.94036Z"\n' +
                                '                            fill="#1479DE"/>\n' +
                                '                                <path d="M10.56 7.30036C10.5467 7.30036 10.5267 7.30036 10.5133 7.30036C8.43333 7.09369 6.76 5.51369 6.44 3.44703C6.4 3.17369 6.58667 2.92036 6.86 2.87369C7.13333 2.83369 7.38667 3.02036 7.43333 3.29369C7.68667 4.90703 8.99333 6.14703 10.62 6.30703C10.8933 6.33369 11.0933 6.58036 11.0667 6.85369C11.0333 7.10703 10.8133 7.30036 10.56 7.30036Z"\n' +
                                '                            fill="#1479DE"/>\n' +
                                '                                <path d="M13 15.167H1C0.726667 15.167 0.5 14.9404 0.5 14.667C0.5 14.3937 0.726667 14.167 1 14.167H13C13.2733 14.167 13.5 14.3937 13.5 14.667C13.5 14.9404 13.2733 15.167 13 15.167Z"\n' +
                                '                            fill="#1479DE"/>\n' +
                                '                                </svg>' +
                                'Đánh giá dự án </a> ' +
                                '</div>\n' +
                                '                                                </div>\n' +
                                '                                            </div>\n' +
                                '                                        </div>\n' +
                                '                                    </div>';
                        });
                        $('.lisst_post').html(html);
                    } else {
                        $('.lisst_post').html('<p>' + res.message + '</p>');
                    }
                    dem =1;
                    $('.page_arr').html(res.page);
                    $('.number_page_prev ').hide();


                }
            };

            cms_adapter_ajax($param);
        }

        function ajax_pag() {
            var $data = {
                'page_select': dem,
                'pro_stas': pro_stas,
                'type_project': type_project,
                'areas': areas,
                'prices': prices,
                'company': company,
                'keyword': keyword,
                'action': 'sort_product'
            };
            var $param = {
                'type': 'POST',
                'url': ajaxurl,
                'beforeSend': function () {
                    $("#loader").show();
                },
                'complete': function () {
                    $("#loader").hide();
                    $(".tabs-content").show();
                },
                'data': $data,
                'callback': function (data) {
                    var res = JSON.parse(data);
                    if (res.status === 0) {
                        var content = res.data;
                        var html = '';
                        content.forEach(function (item, index) {
                            console.log(item);
                            html += '<div class="col-6">\n' +
                                '                                        <div class="child">\n' +
                                '                                            <div class="image">\n' +
                                '                                                <figure>\n' +
                                '                                                    <img src="'+ item.img +'" alt="">\n' +
                                '                                                </figure>\n' +
                                '                                                <div class="info">\n' +
                                '                                                    <p class="status">\n' +
                                '                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">\n' +
                                '                                                            <path d="M17.25 17.0625H0.75C0.4425 17.0625 0.1875 16.8075 0.1875 16.5C0.1875 16.1925 0.4425 15.9375 0.75 15.9375H17.25C17.5575 15.9375 17.8125 16.1925 17.8125 16.5C17.8125 16.8075 17.5575 17.0625 17.25 17.0625Z" fill="white"></path>\n' +
                                '                                                            <path d="M14.835 17.0696C14.5275 17.0696 14.2725 16.8146 14.2725 16.5071V13.1621C14.2725 12.8546 14.5275 12.5996 14.835 12.5996C15.1425 12.5996 15.3975 12.8546 15.3975 13.1621V16.5071C15.3975 16.8146 15.15 17.0696 14.835 17.0696Z" fill="white"></path>\n' +
                                '                                                            <path d="M14.8502 13.7251C13.6277 13.7251 12.6377 12.7351 12.6377 11.5126V9.81017C12.6377 8.58767 13.6277 7.59766 14.8502 7.59766C16.0727 7.59766 17.0627 8.58767 17.0627 9.81017V11.5126C17.0627 12.7351 16.0727 13.7251 14.8502 13.7251ZM14.8502 8.73016C14.2502 8.73016 13.7627 9.21767 13.7627 9.81767V11.5201C13.7627 12.1201 14.2502 12.6077 14.8502 12.6077C15.4502 12.6077 15.9377 12.1201 15.9377 11.5201V9.81767C15.9377 9.21767 15.4502 8.73016 14.8502 8.73016Z" fill="white"></path>\n' +
                                '                                                            <path d="M10.7249 17.0628C10.4174 17.0628 10.1624 16.8078 10.1624 16.5003V4.52283C10.1624 3.33033 9.65987 2.82031 8.48987 2.82031H3.81738C2.63988 2.82031 2.12988 3.33033 2.12988 4.52283V16.5003C2.12988 16.8078 1.87488 17.0628 1.56738 17.0628C1.25988 17.0628 1.00488 16.8078 1.00488 16.5003V4.52283C1.00488 2.70033 2.00238 1.69531 3.81738 1.69531H8.48987C10.2974 1.69531 11.2874 2.70033 11.2874 4.52283V16.5003C11.2874 16.8078 11.0324 17.0628 10.7249 17.0628Z" fill="white"></path>\n' +
                                '                                                            <path d="M8.06212 6.75H4.34961C4.04211 6.75 3.78711 6.495 3.78711 6.1875C3.78711 5.88 4.04211 5.625 4.34961 5.625H8.06212C8.36962 5.625 8.62462 5.88 8.62462 6.1875C8.62462 6.495 8.36962 6.75 8.06212 6.75Z" fill="white"></path>\n' +
                                '                                                            <path d="M8.06212 9.5625H4.34961C4.04211 9.5625 3.78711 9.3075 3.78711 9C3.78711 8.6925 4.04211 8.4375 4.34961 8.4375H8.06212C8.36962 8.4375 8.62462 8.6925 8.62462 9C8.62462 9.3075 8.36962 9.5625 8.06212 9.5625Z" fill="white"></path>\n' +
                                '                                                            <path d="M6.1875 17.0625C5.88 17.0625 5.625 16.8075 5.625 16.5V13.6875C5.625 13.38 5.88 13.125 6.1875 13.125C6.495 13.125 6.75 13.38 6.75 13.6875V16.5C6.75 16.8075 6.495 17.0625 6.1875 17.0625Z" fill="white"></path>\n' +
                                '                                                        </svg>\n' +
                                '                                                        '+ item.status_project +'                                                    </p>\n' +
                                // '                                                    <p class="acreage">\n' +
                                // '                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">\n' +
                                // '                                                            <path d="M11.25 17.0625H6.75C2.6775 17.0625 0.9375 15.3225 0.9375 11.25V6.75C0.9375 2.6775 2.6775 0.9375 6.75 0.9375H11.25C15.3225 0.9375 17.0625 2.6775 17.0625 6.75V11.25C17.0625 15.3225 15.3225 17.0625 11.25 17.0625ZM6.75 2.0625C3.2925 2.0625 2.0625 3.2925 2.0625 6.75V11.25C2.0625 14.7075 3.2925 15.9375 6.75 15.9375H11.25C14.7075 15.9375 15.9375 14.7075 15.9375 11.25V6.75C15.9375 3.2925 14.7075 2.0625 11.25 2.0625H6.75Z" fill="white"></path>\n' +
                                // '                                                            <path d="M10.4626 17.0625C10.2076 17.0625 9.98254 16.89 9.91504 16.635L6.20257 1.63501C6.12757 1.33501 6.31506 1.02752 6.61506 0.952521C6.91506 0.877521 7.22254 1.05752 7.29754 1.36502L11.0101 16.365C11.0851 16.665 10.8976 16.9725 10.5976 17.0475C10.5526 17.055 10.5076 17.0625 10.4626 17.0625Z" fill="white"></path>\n' +
                                // '                                                            <path d="M1.49989 11.8129C1.25239 11.8129 1.03491 11.6554 0.959911 11.4079C0.869911 11.1079 1.04237 10.8004 1.34237 10.7104L8.48989 8.62544C8.78989 8.53544 9.09739 8.70793 9.18739 9.00793C9.27739 9.30793 9.10488 9.61544 8.80488 9.70544L1.65741 11.7904C1.60491 11.8054 1.55239 11.8129 1.49989 11.8129Z" fill="white"></path>\n' +
                                // '                                                        </svg>\n' +
                                // '                                                        Diện tích:'+ item.area +'</p>\n' +
                                '                                                </div>\n' +
                                '                                            </div>\n' +
                                '                                            <div class="text">\n' +
                                '                                                <div class="category">\n' +
                                '                                                    <span>'+ item.type_duan +'</span>\n' +
                                '                                                </div>\n' +
                                '                                                <div class="name">\n' +
                                '                                                    <a href="'+ item.url +'">'+ item.title +'</a>\n' +
                                '                                                </div>\n' +
                                '                                                <div class="desc">\n' +
                                '                                                    <p><strong>Vị trí:</strong>\n' +
                                '                                                        <span>'+ item.address +'</span></p>\n' +
                                // '                                                    <p><strong>Diện tích:</strong>\n' +
                                // '                                                        <span>'+ item.area +'</span></p>\n' +
                                '                                                    <p><strong>Chủ đầu tư:</strong>\n' +
                                '                                                        <span>'+ item.company +'</span></p>\n' +
                                '                                                </div>\n' +
                                '                                                <div class="action">\n' +
                                '                                                   <div class="left"> ' +
                                '<a href="'+ item.url +'" class="advise">Tư vấn cho tôi</a>\n' +
                                '<a href="'+ item.url +'#vitri" class="location">Vị trí</a>' +
                                '                            </div>' +
                                '                            <div class="right">' +
                                '                                <a href="'+ item.url +'#review_scroll">' +
                                '   <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16"\n' +
                                '                            viewBox="0 0 14 16" fill="none">\n' +
                                '                                <path d="M2.69333 13.0137C2.28667 13.0137 1.90667 12.8737 1.63333 12.6137C1.28667 12.287 1.12 11.7937 1.18 11.2604L1.42667 9.10036C1.47333 8.69369 1.72 8.15369 2.00667 7.86036L7.48 2.06702C8.84667 0.620358 10.2733 0.580358 11.72 1.94703C13.1667 3.31369 13.2067 4.74036 11.84 6.18703L6.36667 11.9804C6.08667 12.2804 5.56667 12.5604 5.16 12.627L3.01333 12.9937C2.9 13.0004 2.8 13.0137 2.69333 13.0137ZM9.62 1.94036C9.10667 1.94036 8.66 2.26036 8.20667 2.74036L2.73333 8.54036C2.6 8.68036 2.44667 9.01369 2.42 9.20703L2.17333 11.367C2.14667 11.587 2.2 11.767 2.32 11.8804C2.44 11.9937 2.62 12.0337 2.84 12.0004L4.98667 11.6337C5.18 11.6004 5.5 11.427 5.63333 11.287L11.1067 5.49369C11.9333 4.61369 12.2333 3.80036 11.0267 2.66702C10.4933 2.15369 10.0333 1.94036 9.62 1.94036Z"\n' +
                                '                            fill="#1479DE"/>\n' +
                                '                                <path d="M10.56 7.30036C10.5467 7.30036 10.5267 7.30036 10.5133 7.30036C8.43333 7.09369 6.76 5.51369 6.44 3.44703C6.4 3.17369 6.58667 2.92036 6.86 2.87369C7.13333 2.83369 7.38667 3.02036 7.43333 3.29369C7.68667 4.90703 8.99333 6.14703 10.62 6.30703C10.8933 6.33369 11.0933 6.58036 11.0667 6.85369C11.0333 7.10703 10.8133 7.30036 10.56 7.30036Z"\n' +
                                '                            fill="#1479DE"/>\n' +
                                '                                <path d="M13 15.167H1C0.726667 15.167 0.5 14.9404 0.5 14.667C0.5 14.3937 0.726667 14.167 1 14.167H13C13.2733 14.167 13.5 14.3937 13.5 14.667C13.5 14.9404 13.2733 15.167 13 15.167Z"\n' +
                                '                            fill="#1479DE"/>\n' +
                                '                                </svg>' +
                                'Đánh giá dự án </a> ' +
                                '</div>\n' +
                                '                                                </div>\n' +
                                '                                            </div>\n' +
                                '                                        </div>\n' +
                                '                                    </div>';
                        });
                        $('.lisst_post').html(html);
                    } else {
                        $('.lisst_post').html('<p>' + res.message + '</p>');
                    }

                }
            };

            cms_adapter_ajax($param);
        }

        $('body').on('click', '.page-item', function () {
            if (!$(this).hasClass('number_page_prev') || !$(this).hasClass('number_page_next')) {

                var key = $(this).data('key');
                dem = key;
                if (dem > 1) {
                    $('.number_page_prev').data('key', (parseInt(key) - 1));
                    $('.number_page_prev').show();

                } else {
                    $('.number_page_prev').data('key', 1);
                    $('.number_page_prev').hide();
                }

                if (parseInt(key) < parseInt(count)) {
                    $('.number_page_next').data('key', (parseInt(key) + 1));
                    $('.number_page_next').show();
                } else {
                    $('.number_page_next').data('key', count);
                    $('.number_page_next').hide();

                }
                if (key >= 4 && count > 6) {
                    $('.near_1').show();

                } else {
                    $('.near_1').hide();
                }
                if ((count - 2) <= key) {
                    $('.far_1').hide();
                } else {
                    $('.far_1').show();
                }
                var prev = parseInt(key) - 1;
                var next = parseInt(key) + 1;

                $('.page-item').removeClass('active').removeClass('show');
                $('.number_page_' + key).addClass('active').addClass('show');
                $('.number_page_' + prev).addClass('show');
                $('.number_page_' + next).addClass('show');
                if (key == 1) {
                    $('.number_page_3').addClass('show');
                }
                ajax_pag()
            }
        });
        $('body').on('click', '.number_page_prev', function () {
            var key = $(this).data('key');
            dem = dem -1;
            if (dem > 1) {
                $('.number_page_prev').data('key', (parseInt(key) - 1));
                $('.number_page_prev').show();

            } else {
                $('.number_page_prev').data('key', 1);
                $('.number_page_prev').hide();
            }
            $('.number_page_next').data('key', (parseInt(key) + 1));
            $('.number_page_next').show();
            if (dem >= 4) {
                $('.near_1').show();

            } else {
                $('.near_1').hide();
            }
            if ((count - 1) === key) {
                $('.far_1').hide();
            } else {
                $('.far_1').show();
            }
            var prev = parseInt(dem) - 1;
            var next = parseInt(dem) + 1;

            $('.page-item').removeClass('active').removeClass('show');
            $('.number_page_' + dem).addClass('active').addClass('show');
            $('.number_page_' + prev).addClass('show');
            $('.number_page_' + next).addClass('show');
            $('.contant_s').removeClass('active');
            $('.content_' + dem).addClass('active');
            ajax_pag()
        })
        $('body').on('click', '.number_page_next', function () {
            var key = $(this).data('key');
            dem = dem +1;
            console.log(dem);
            if (dem === count) {
                $('.number_page_next').data('key', count);
                $('.number_page_next').hide();
            } else {
                $('.number_page_next').data('key', dem);
                $('.number_page_next').show();
            }
            $('.number_page_prev').data('key', (parseInt(key) - 1));
            $('.number_page_prev').show();
            if (dem >= 4) {
                $('.near_1').show();

            } else {
                $('.near_1').hide();
            }

            if ((count - 2) <= dem) {
                $('.far_1').hide();
            } else {
                $('.far_1').show();
            }
            var prev = parseInt(dem) - 1;
            var next = parseInt(dem) + 1;

            $('.page-item').removeClass('active').removeClass('show');
            $('.number_page_' + dem).addClass('active').addClass('show');
            $('.number_page_' + prev).addClass('show');
            $('.number_page_' + next).addClass('show');
            $('.contant_s').removeClass('active');
            $('.content_' + dem).addClass('active');
            ajax_pag()
        })
    })

</script>
