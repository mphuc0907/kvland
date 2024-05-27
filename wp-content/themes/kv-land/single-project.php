<?php
session_start();
get_header(); ?>
    <!--noti-->
<?php
if (isset($_GET['message'])) {
    $message = sanitize_text_field($_GET['message']);
}
$sta = get_field('status_project');

?>
    <!--database-->
<?php
global $wpdb;
$sql = "SELECT * FROM $wpdb->prefix" . "review" . " WHERE status = 1 and id_post = " . get_the_ID().' order by id desc';
$results = $wpdb->get_results($sql);
if ($results) {
    foreach ($results as $result) {
        $id_post = $result->id_post;
        $reviewer_name = $result->reviewer_name;
        $note = $result->note;
        $status = $result->status;
        $date_time = $result->date_time;
    }
}

// trung bình đánh giá
$star_point_avg_1 = $wpdb->get_var("SELECT AVG(star_point) FROM $wpdb->prefix" . "review" . " WHERE  status = 1 and id_post = " . get_the_ID());
$star_point_avg = round($star_point_avg_1, 1);
// trung bình chất lượng
$star_quality_avg_1 = $wpdb->get_var("SELECT AVG(star_quality)  FROM $wpdb->prefix" . "review" . " WHERE  status = 1 and id_post = " . get_the_ID());
$star_quality_avg = round($star_quality_avg_1, 0);
$star_quality_percent = round($star_quality_avg_1, 1) * 20;
// trung bình tiện ích
$star_utilities_avg_1 = $wpdb->get_var("SELECT AVG(star_utilities) FROM $wpdb->prefix" . "review" . " WHERE  status = 1 and id_post = " . get_the_ID());
$star_utilities_avg = round($star_utilities_avg_1, 0);
$star_utilities_percent = round($star_utilities_avg_1, 1) * 20;
//trung bình địa điểm
$star_location_avg_1 = $wpdb->get_var("SELECT AVG(star_location) FROM $wpdb->prefix" . "review" . " WHERE  status = 1 and id_post = " . get_the_ID());
$star_location_avg = round($star_location_avg_1, 0);
$star_location_percent = round($star_location_avg_1, 1) * 20;
//trung bình giá cả
$star_price_avg_1 = $wpdb->get_var("SELECT AVG(star_price)  FROM $wpdb->prefix" . "review" . " WHERE  status = 1 and id_post = " . get_the_ID());
$star_price_avg = round($star_price_avg_1, 0);
$star_price_percent = round($star_price_avg_1, 1) * 20;
//trung bình giá trị
$star_value_avg_1 = $wpdb->get_var("SELECT AVG(star_value)  FROM $wpdb->prefix" . "review" . " WHERE  status = 1 and id_post = " . get_the_ID());
$star_value_avg = round($star_value_avg_1, 0);
$star_value_percent = round($star_value_avg_1, 1) * 20;
//trung bình giao thông
$star_traffic_avg_1 = $wpdb->get_var("SELECT AVG(star_traffic)  FROM $wpdb->prefix" . "review" . " WHERE  status = 1 and id_post = " . get_the_ID());
$star_traffic_avg = round($star_traffic_avg_1, 0);
$star_traffic_percent = round($star_traffic_avg_1, 1) * 20;

// get field
$status_project = get_field('status_project');
if ($status_project == 1) {
    $status_project = 'Sắp mở bán';
} else if ($status_project == 2) {
    $status_project = 'Đang mở bán';
} else {
    $status_project = 'Đã bàn giao';
}

$re_list_info = get_field('re_list_info');
$utilities = get_field('utilities');
$group_location_info = get_field('group_location_info');
$group_info = get_field('group_info');
$group_policy = get_field('group_policy');
$gallery_project = get_field('gallery_project');
$quymo = get_field('quymo');
$re_progress_project = get_field('re_progress_project');
$group_juridical = get_field('group_juridical');
$key_duan = tim_key_cuoi_cung_truoc_khi_khong_1($re_progress_project);
$arr_pre = array();
if (count($re_progress_project) <= 5) {
    $arr_pre = $re_progress_project;
} else {
    if ($key_duan < 2) {
        foreach ($re_progress_project as $k => $value) {
            if ($k < 5) {
                $arr_pre[] = $value;
            }
        }
    } elseif ($key_duan > (count($re_progress_project) - 2)) {
        foreach ($re_progress_project as $k => $value) {
            if ($k > (count($re_progress_project) - 5)) {
                $arr_pre[] = $value;
            }
        }
    } else {
        $arr_pre[] = $re_progress_project[$key_duan - 2];
        $arr_pre[] = $re_progress_project[$key_duan - 1];
        $arr_pre[] = $re_progress_project[$key_duan];
        $arr_pre[] = $re_progress_project[$key_duan + 1];
        $arr_pre[] = $re_progress_project[$key_duan + 2];
    }
}
?>

    <style>
        .review input[type="text"] {
            padding: 15px;
            font-size: 16px;
            color: #899197;
            font-family: var(--f-body);
        }

        main .section-dtda-8 .option-3 .content .col-right .rating-detail .list .child .right .item label i {
            color: #ccc;
        }

        main .section-dtda-8 .option-3 .content .col-right .rating .star .item label i {
            color: #899197;
        }

        main .section-dtda-8 .option-3 .content .col-right .rating .star .item.selected i {
            color: #FF912C;
        }

        main .section-dtda-8 .option-3 .content .col-right .rating-detail .list .child .right .item.hover i {
            color: #F7941D;
        }

        main .section-dtda-8 .option-3 .content .col-right .rating-detail .list .child .right .item.selected i {
            color: #FF912C;
        }

        main .section-dtda-8 .option-1 .content .col-right .bot .child .item .right i {
            color: #ccc;
        }

        main .section-dtda-8 .option-1 .content .col-right .bot .child .item .right i.active {
            color: #FF912C;
        }

        main .section-dtda-8 .option-3 .content .col-left .list .child .text .top .right .star i {
            color: #ccc;
        }

        main .section-dtda-8 .option-3 .content .col-left .list .child .text .top .right .star i.active {
            color: #FF912C;
        }

        .highcharts-title {
            display: none;
        }

        .highcharts-exporting-group {
            display: none;
        }

        .highcharts-legend-item {
            display: none;
        }

        .highcharts-credits {
            display: none;

        }
        .list_share {
            display: none; /* Ẩn ban đầu */
            overflow: hidden; /* Ẩn phần tử vượt ra ngoài */
            transition: height 0.3s ease; /* Hiệu ứng transition cho chiều cao */
            position: absolute;
        }

        .list_share.active {
            display: block; /* Hiển thị khi có class active */
        }
    </style>
    <section class="section-homepage-1 section-dtda-1">
        <div class="content">
            <div class="col-left">
                <div class="image">
                    <figure>
                        <img src="<?= getimage(get_post_thumbnail_id()) ?>" alt="">
                    </figure>
                </div>
            </div>
            <div class="col-right">
                <div class="breckcum">
                    <a href="<?= home_url() ?>">Trang chủ </a>
                    <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M9.88712 7.52679L7.06045 4.70013C6.99847 4.63764 6.92474 4.58805 6.8435 4.5542C6.76226 4.52036 6.67512 4.50293 6.58712 4.50293C6.49911 4.50293 6.41197 4.52036 6.33073 4.5542C6.24949 4.58805 6.17576 4.63764 6.11378 4.70013C5.98962 4.82504 5.91992 4.994 5.91992 5.17013C5.91992 5.34625 5.98962 5.51522 6.11378 5.64013L8.47378 8.00013L6.11378 10.3601C5.98962 10.485 5.91992 10.654 5.91992 10.8301C5.91992 11.0063 5.98962 11.1752 6.11378 11.3001C6.17608 11.3619 6.24995 11.4108 6.33118 11.444C6.4124 11.4772 6.49938 11.494 6.58712 11.4935C6.67485 11.494 6.76183 11.4772 6.84305 11.444C6.92428 11.4108 6.99816 11.3619 7.06045 11.3001L9.88712 8.47346C9.9496 8.41149 9.9992 8.33775 10.033 8.25651C10.0669 8.17527 10.0843 8.08814 10.0843 8.00013C10.0843 7.91212 10.0669 7.82498 10.033 7.74374C9.9992 7.6625 9.9496 7.58877 9.88712 7.52679Z"
                              fill="#41464B"/>
                    </svg>
                </span>
                    <a href="<?= home_url() . '/du-an' ?>">Dự án</a>
                    <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M9.88712 7.52679L7.06045 4.70013C6.99847 4.63764 6.92474 4.58805 6.8435 4.5542C6.76226 4.52036 6.67512 4.50293 6.58712 4.50293C6.49911 4.50293 6.41197 4.52036 6.33073 4.5542C6.24949 4.58805 6.17576 4.63764 6.11378 4.70013C5.98962 4.82504 5.91992 4.994 5.91992 5.17013C5.91992 5.34625 5.98962 5.51522 6.11378 5.64013L8.47378 8.00013L6.11378 10.3601C5.98962 10.485 5.91992 10.654 5.91992 10.8301C5.91992 11.0063 5.98962 11.1752 6.11378 11.3001C6.17608 11.3619 6.24995 11.4108 6.33118 11.444C6.4124 11.4772 6.49938 11.494 6.58712 11.4935C6.67485 11.494 6.76183 11.4772 6.84305 11.444C6.92428 11.4108 6.99816 11.3619 7.06045 11.3001L9.88712 8.47346C9.9496 8.41149 9.9992 8.33775 10.033 8.25651C10.0669 8.17527 10.0843 8.08814 10.0843 8.00013C10.0843 7.91212 10.0669 7.82498 10.033 7.74374C9.9992 7.6625 9.9496 7.58877 9.88712 7.52679Z"
                              fill="#41464B"/>
                    </svg>
                </span>
                    <span>
                    <?= get_the_title() ?>
                </span>
                </div>
                <div class="text">
                    <div class="info">
                        <div class="status">
                        <span>
                        <?= $status_project ?>
                        </span>
                        </div>
                        <div class="name">
                            <h3>Dự án <span><?= the_title(); ?></span></h3>
                        </div>
                        <div class="desc">
                            <p><strong>Vị trí:</strong> <span><?= get_field('address') ?></span></p>
                            <p><strong>Diện tích:</strong> <span><?= get_field('area') ?></span></p>
                            <p><strong>Chủ đầu tư:</strong> <span><?= get_field('company') ?></span></p>
                        </div>
                        <?php if (!empty($utilities)): ?>
                            <div class="utilities">
                                <h4>Tiện ích</h4>
                                <div class="list">
                                    <ul>
                                        <?php foreach ($utilities as $value): ?>
                                            <li>
                                                <figure>
                                                    <img src="<?= getimage($value['icon']) ?>" alt="">
                                                </figure>
                                                <?= $value['name'] ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($arr_pre)): ?>
                        <div class="progress-da">
                            <h4>Tiến độ dự án</h4>
                            <div class="list">
                                <ul>
                                    <?php

                                    foreach ($arr_pre as $key => $progress) :
                                        ?>
                                        <li <?= $progress['status'] == true ? 'class="active"' : '' ?>>
                                            <span><?= $progress['time'] ?></span>
                                            <p><?= $progress['title'] ?></p>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="price">
                        <?php if (!empty(get_field('price_project'))): ?>
                            <p>Giá chỉ từ <span><?= quy_doi_so(get_field('price_project')) ?>/m2</span></p>
                        <?php else: ?>
                            <p>Liên hệ thương lượng</p>
                        <?php endif; ?>
                    </div>
                    <div class="action">
                        <div class="left">
                            <a href="#" class="advise btn-tv">Tư vấn cho tôi</a>
                            <!--                            <a href="#" class="location">Vị trí</a>-->
<!--                            <div class="share_button">-->
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= get_permalink() ?>" class="share" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M16.5 2.25C14.7051 2.25 13.25 3.70507 13.25 5.5C13.25 5.69591 13.2673 5.88776 13.3006 6.07412L8.56991 9.38558C8.54587 9.4024 8.52312 9.42038 8.50168 9.43939C7.94993 9.00747 7.25503 8.75 6.5 8.75C4.70507 8.75 3.25 10.2051 3.25 12C3.25 13.7949 4.70507 15.25 6.5 15.25C7.25503 15.25 7.94993 14.9925 8.50168 14.5606C8.52312 14.5796 8.54587 14.5976 8.56991 14.6144L13.3006 17.9259C13.2673 18.1122 13.25 18.3041 13.25 18.5C13.25 20.2949 14.7051 21.75 16.5 21.75C18.2949 21.75 19.75 20.2949 19.75 18.5C19.75 16.7051 18.2949 15.25 16.5 15.25C15.4472 15.25 14.5113 15.7506 13.9174 16.5267L9.43806 13.3911C9.63809 12.9694 9.75 12.4978 9.75 12C9.75 11.5022 9.63809 11.0306 9.43806 10.6089L13.9174 7.4733C14.5113 8.24942 15.4472 8.75 16.5 8.75C18.2949 8.75 19.75 7.29493 19.75 5.5C19.75 3.70507 18.2949 2.25 16.5 2.25ZM14.75 5.5C14.75 4.5335 15.5335 3.75 16.5 3.75C17.4665 3.75 18.25 4.5335 18.25 5.5C18.25 6.4665 17.4665 7.25 16.5 7.25C15.5335 7.25 14.75 6.4665 14.75 5.5ZM6.5 10.25C5.5335 10.25 4.75 11.0335 4.75 12C4.75 12.9665 5.5335 13.75 6.5 13.75C7.4665 13.75 8.25 12.9665 8.25 12C8.25 11.0335 7.4665 10.25 6.5 10.25ZM16.5 16.75C15.5335 16.75 14.75 17.5335 14.75 18.5C14.75 19.4665 15.5335 20.25 16.5 20.25C17.4665 20.25 18.25 19.4665 18.25 18.5C18.25 17.5335 17.4665 16.75 16.5 16.75Z"
                                              fill="#1C274C"/>
                                    </svg>
                                </a>
<!--                                <div class="list_share">-->
<!--                                    --><?//= do_shortcode('[Sassy_Social_Share]') ?>
<!--                                </div>-->
<!--                            </div>-->
                        </div>
                        <div class="right">
                            <a href="#" id="review">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16"
                                     fill="none">
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
        </div>
    </section>
<?php if (!empty($group_location_info['embed_map'])): ?>
    <section class="section-dtda-2" id="vitri"
             style="background: url('<?= getimage($group_location_info['img'], 'full_size') ?>') no-repeat ">
        <div class="content">
            <div class="col-left">
                <div class="map">
                    <figure>
                        <?= $group_location_info['embed_map'] ?>
                    </figure>
                </div>
            </div>
            <div class="col-right">
                <div class="text">
                    <div class="title">
                        <h4><?= $group_location_info['title'] ?></h4>
                    </div>
                    <div class="desc">
                        <?= apply_filters('the_content', $group_location_info['desc']) ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
    <section class="section-dtda-3">
        <div class="container">
            <div class="content">
                <div class="col-left">
                    <div class="image">
                        <figure>
                            <img src="<?= getimage($quymo['img']) ?>" alt="">
                        </figure>
                    </div>
                </div>
                <div class="col-right">
                    <div class="text">
                        <div class="title">
                            <h3><?= $quymo['title'] ?></h3>
                        </div>
                        <div class="desc">
                            <?= apply_filters('the_content', $quymo['desc']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-dtda-4">
        <div class="container">
            <div class="content">
                <div class="col-left " style="max-width: 100%">
                    <div class="title">
                        <h3><?= $group_info['title'] ?></h3>
                    </div>
                    <div class="desc">
                        <?= apply_filters('the_content', $group_info['desc']) ?>
                    </div>
                    <a href="#" class="advise btn-tv action">Tư vấn cho tôi</a>
                </div>
                <?php if( 1 > 2): ?>
                <div class="col-right">
                    <div class="list">
                        <?php for ($i = 0; $i < count($group_info['re_info']); $i += 2):

                            ?>
                            <div class="child">
                                <div class="item">
                                    <?php if (!empty($group_info['re_info'][$i]['icon'])): ?>
                                        <figure>
                                            <img src="<?= getimage($group_info['re_info'][$i]['icon']) ?>"
                                                 style="width: 32px;height: 32px;" alt="">
                                        </figure>
                                    <?php endif; ?>
                                    <div class="text">
                                        <span><?= $group_info['re_info'][$i]['title'] ?></span>
                                        <p><?= (!empty($group_info['re_info'][$i]['desc']) || $group_info['re_info'][$i]['desc'] !== '-') ? $group_info['re_info'][$i]['desc'] : 'Đang cập nhật' ?></p>
                                    </div>
                                </div>
                                <?php if (!empty($group_info['re_info'][$i + 1])): ?>
                                    <div class="item">
                                        <?php if (!empty($group_info['re_info'][$i + 1]['icon'])): ?>
                                            <figure>
                                                <img src="<?= getimage($group_info['re_info'][$i + 1]['icon']) ?>"
                                                     style="width: 32px;height: 32px;" alt="">
                                            </figure>
                                        <?php endif; ?>
                                        <div class="text">
                                            <span><?= $group_info['re_info'][$i + 1]['title'] ?></span>
                                            <p><?= (!empty($group_info['re_info'][$i + 1]['desc']) || $group_info['re_info'][$i + 1]['desc'] !== '-') ? $group_info['re_info'][$i + 1]['desc'] : 'Đang cập nhật' ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php if (!empty($group_policy['title'])): ?>
    <section class="section-dtda-5">

        <div class="container">
            <div class="col-left">
                <div class="title">
                    <h3><?= $group_policy['title'] ?></h3>
                </div>
                <div class="desc">
                    <?= apply_filters('the_content', $group_policy['desc']) ?>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="col-right">
                <div class="image">
                    <figure>
                        <img src="<?= getimage($group_policy['img']) ?>" alt="">
                    </figure>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

    <section class="section-dtda-6">
        <div class="container">
            <div class="title">
                <h2><?= (!empty($re_progress_project)) ? 'Tiến độ dự án' : 'Thư viện hình ảnh' ?> </h2>
            </div>
            <?php if (!empty($re_progress_project)): ?>
                <div class="content">
                    <div class="timeline swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($re_progress_project as $k => $value): ?>
                                <div class="child swiper-slide <?= ($value['status'] == true && $key_duan >= $k) ? 'active' : '' ?>">
                                    <span><?= $value['time'] ?></span>
                                    <p><?= $value['title'] ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="slider-button-prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M15.0904 3.33047C15.2804 3.33047 15.4704 3.40047 15.6204 3.55047C15.9104 3.84047 15.9104 4.32047 15.6204 4.61047L9.10039 11.1305C8.62039 11.6105 8.62039 12.3905 9.10039 12.8705L15.6204 19.3905C15.9104 19.6805 15.9104 20.1605 15.6204 20.4505C15.3304 20.7405 14.8504 20.7405 14.5604 20.4505L8.04039 13.9305C7.53039 13.4205 7.24039 12.7305 7.24039 12.0005C7.24039 11.2705 7.52039 10.5805 8.04039 10.0705L14.5604 3.55047C14.7104 3.41047 14.9004 3.33047 15.0904 3.33047Z"
                                  fill="#41464B"/>
                        </svg>
                    </div>
                    <div class="slider-button-next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M8.90961 20.6695C8.71961 20.6695 8.52961 20.5995 8.37961 20.4495C8.08961 20.1595 8.08961 19.6795 8.37961 19.3895L14.8996 12.8695C15.3796 12.3895 15.3796 11.6095 14.8996 11.1295L8.37961 4.60953C8.08961 4.31953 8.08961 3.83953 8.37961 3.54953C8.66961 3.25953 9.14961 3.25953 9.43961 3.54953L15.9596 10.0695C16.4696 10.5795 16.7596 11.2695 16.7596 11.9995C16.7596 12.7295 16.4796 13.4195 15.9596 13.9295L9.43961 20.4495C9.28961 20.5895 9.09961 20.6695 8.90961 20.6695Z"
                                  fill="#41464B"/>
                        </svg>
                    </div>
                </div>
            <?php endif; ?>
            <div class="image">
                <div class="list row">
                    <?php if (!empty($gallery_project)): ?>
                        <?php foreach ($gallery_project as $key => $value):
                            if ($key > 2) break;
                            ?>
                            <div class="col-xl-4">
                                <div class="child">
                                    <figure>
                                        <img src="<?= getimage($value) ?>" alt="">
                                    </figure>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

<?php if (!empty($group_juridical['title'])): ?>
    <section class="section-dtda-7">
        <div class="content">
            <div class="col-left">
                <div class="image">
                    <figure>
                        <img src="<?= getimage($group_juridical['img']) ?>" alt="">
                    </figure>
                </div>
            </div>
            <div class="col-right">
                <div class="text">
                    <div class="title">
                        <h2>
                            <?= $group_juridical['title'] ?>
                        </h2>
                    </div>
                    <div class="desc">
                        <?= $group_juridical['desc'] ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
    <section class="section-dtda-8" id="review_scroll">
        <div class="container">
            <div class="option-1">
                <div class="title">
                    <h3>Đánh giá dự án</h3>
                </div>
                <div class="content row">
                    <div class="col-xl-5">
                        <div class="col-lef">
                            <div class="image">
                                <figure>
                                    <img src="<?= getimage(get_the_ID(), 'large', 'post') ?>"
                                         alt=""></figure>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7">
                        <div class="col-right">
                            <div class="top">
                                <div class="text">
                                    <div class="name">
                                        <h3>Dự án <span><?= get_the_title() ?></span></h3>
                                    </div>
                                    <div class="desc">
                                        <p><?= get_field('address') ?></p>
                                    </div>
                                </div>
                                <div class="rating">
                                    <figure>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                             viewBox="0 0 50 50"
                                             fill="none">
                                            <path d="M27.3223 7.87387L30.4282 14.0907C30.8537 14.944 31.976 15.7847 32.9217 15.9316L38.5478 16.8792C42.1504 17.478 42.9768 20.0871 40.3996 22.676L36.01 27.0607C35.2771 27.7956 34.8523 29.2384 35.0921 30.2509L36.3386 35.6814C37.3184 39.9688 35.0443 41.6337 31.2643 39.3898L25.9839 36.2547C25.0222 35.6817 23.4562 35.6937 22.5069 36.2521L17.225 39.3656C13.444 41.5909 11.167 39.9265 12.1553 35.6445L13.4183 30.2258C13.6541 29.2129 13.2507 27.7687 12.5158 27.0359L8.10631 22.6385C5.53373 20.0529 6.36388 17.4465 9.96115 16.8483L15.5779 15.9182C16.5261 15.7534 17.6511 14.9375 18.0701 14.0771L21.1882 7.85394C22.8904 4.50195 25.6458 4.50937 27.3223 7.87387Z"
                                                  fill="#FFBA34"/>
                                        </svg>
                                    </figure>
                                    <p><span><?= $star_point_avg ?></span>/5</p>
                                </div>
                            </div>
                            <div class="bot">
                                <div class="child">
                                    <div class="item">
                                        <div class="left">
                                            <figure>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path d="M11.7904 11.88C11.2504 11.88 10.7004 11.78 10.2704 11.59L4.37039 8.97C2.87039 8.3 2.65039 7.4 2.65039 6.91C2.65039 6.42 2.87039 5.52 4.37039 4.85L10.2704 2.23C11.1404 1.84 12.4504 1.84 13.3204 2.23L19.2304 4.85C20.7204 5.51 20.9504 6.42 20.9504 6.91C20.9504 7.4 20.7304 8.3 19.2304 8.97L13.3204 11.59C12.8804 11.79 12.3404 11.88 11.7904 11.88ZM11.7904 3.44C11.4504 3.44 11.1204 3.49 10.8804 3.6L4.98039 6.22C4.37039 6.5 4.15039 6.78 4.15039 6.91C4.15039 7.04 4.37039 7.33 4.97039 7.6L10.8704 10.22C11.3504 10.43 12.2204 10.43 12.7004 10.22L18.6104 7.6C19.2204 7.33 19.4404 7.04 19.4404 6.91C19.4404 6.78 19.2204 6.49 18.6104 6.22L12.7104 3.6C12.4704 3.5 12.1304 3.44 11.7904 3.44Z"
                                                          fill="#41464B"/>
                                                    <path d="M12 17.09C11.62 17.09 11.24 17.01 10.88 16.85L4.09 13.83C3.06 13.38 2.25 12.13 2.25 11C2.25 10.59 2.59 10.25 3 10.25C3.41 10.25 3.75 10.59 3.75 11C3.75 11.55 4.2 12.24 4.7 12.47L11.49 15.49C11.81 15.63 12.18 15.63 12.51 15.49L19.3 12.47C19.8 12.25 20.25 11.55 20.25 11C20.25 10.59 20.59 10.25 21 10.25C21.41 10.25 21.75 10.59 21.75 11C21.75 12.13 20.94 13.38 19.91 13.84L13.12 16.86C12.76 17.01 12.38 17.09 12 17.09Z"
                                                          fill="#41464B"/>
                                                    <path d="M12 22.0902C11.62 22.0902 11.24 22.0102 10.88 21.8502L4.09 18.8302C2.97 18.3302 2.25 17.2202 2.25 15.9902C2.25 15.5802 2.59 15.2402 3 15.2402C3.41 15.2402 3.75 15.5902 3.75 16.0002C3.75 16.6302 4.12 17.2102 4.7 17.4702L11.49 20.4902C11.81 20.6302 12.18 20.6302 12.51 20.4902L19.3 17.4702C19.88 17.2102 20.25 16.6402 20.25 16.0002C20.25 15.5902 20.59 15.2502 21 15.2502C21.41 15.2502 21.75 15.5902 21.75 16.0002C21.75 17.2302 21.03 18.3402 19.91 18.8402L13.12 21.8602C12.76 22.0102 12.38 22.0902 12 22.0902Z"
                                                          fill="#41464B"/>
                                                </svg>
                                            </figure>
                                            <span>Chất lượng</span>
                                        </div>
                                        <div class="right" id="star_quality_avg" data-value="<?= $star_quality_avg ?>">
                                            <i class="fas fa-star" data-value="1">

                                            </i>
                                            <i class="fas fa-star" data-value="2">

                                            </i>
                                            <i class="fas fa-star" data-value="3">

                                            </i>
                                            <i class="fas fa-star" data-value="4">

                                            </i>
                                            <i class="fas fa-star" data-value="5">

                                            </i>
                                        </div>
                                    </div>
                                </div>
                                <div class="child">
                                    <div class="item">
                                        <div class="left">
                                            <figure>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path d="M13.4002 17.4201H10.8902C9.25016 17.4201 7.92016 16.0401 7.92016 14.3401C7.92016 13.9301 8.26016 13.5901 8.67016 13.5901C9.08016 13.5901 9.42016 13.9301 9.42016 14.3401C9.42016 15.2101 10.0802 15.9201 10.8902 15.9201H13.4002C14.0502 15.9201 14.5902 15.3401 14.5902 14.6401C14.5902 13.7701 14.2802 13.6001 13.7702 13.4201L9.74016 12.0001C8.96016 11.7301 7.91016 11.1501 7.91016 9.36008C7.91016 7.82008 9.12016 6.58008 10.6002 6.58008H13.1102C14.7502 6.58008 16.0802 7.96008 16.0802 9.66008C16.0802 10.0701 15.7402 10.4101 15.3302 10.4101C14.9202 10.4101 14.5802 10.0701 14.5802 9.66008C14.5802 8.79008 13.9202 8.08008 13.1102 8.08008H10.6002C9.95016 8.08008 9.41016 8.66008 9.41016 9.36008C9.41016 10.2301 9.72016 10.4001 10.2302 10.5801L14.2602 12.0001C15.0402 12.2701 16.0902 12.8501 16.0902 14.6401C16.0802 16.1701 14.8802 17.4201 13.4002 17.4201Z"
                                                          fill="#41464B"/>
                                                    <path d="M12 18.75C11.59 18.75 11.25 18.41 11.25 18V6C11.25 5.59 11.59 5.25 12 5.25C12.41 5.25 12.75 5.59 12.75 6V18C12.75 18.41 12.41 18.75 12 18.75Z"
                                                          fill="#41464B"/>
                                                    <path d="M12 22.75C6.07 22.75 1.25 17.93 1.25 12C1.25 6.07 6.07 1.25 12 1.25C17.93 1.25 22.75 6.07 22.75 12C22.75 17.93 17.93 22.75 12 22.75ZM12 2.75C6.9 2.75 2.75 6.9 2.75 12C2.75 17.1 6.9 21.25 12 21.25C17.1 21.25 21.25 17.1 21.25 12C21.25 6.9 17.1 2.75 12 2.75Z"
                                                          fill="#41464B"/>
                                                </svg>
                                            </figure>
                                            <span>Mức giá</span>
                                        </div>
                                        <div class="right" id="star_price_avg" data-value="<?= $star_price_avg ?>">
                                            <i class="fas fa-star" data-value="1">

                                            </i>
                                            <i class="fas fa-star" data-value="2">

                                            </i>
                                            <i class="fas fa-star" data-value="3">

                                            </i>
                                            <i class="fas fa-star" data-value="4">

                                            </i>
                                            <i class="fas fa-star" data-value="5">

                                            </i>
                                        </div>
                                    </div>
                                </div>
                                <div class="child">
                                    <div class="item">
                                        <div class="left">
                                            <figure>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path d="M17.79 22.7402H6.21C3.47 22.7402 1.25 20.5102 1.25 17.7702V10.3602C1.25 9.00021 2.09 7.29021 3.17 6.45021L8.56 2.25021C10.18 0.990208 12.77 0.930208 14.45 2.11021L20.63 6.44021C21.82 7.27021 22.75 9.05021 22.75 10.5002V17.7802C22.75 20.5102 20.53 22.7402 17.79 22.7402ZM9.48 3.43021L4.09 7.63021C3.38 8.19021 2.75 9.46021 2.75 10.3602V17.7702C2.75 19.6802 4.3 21.2402 6.21 21.2402H17.79C19.7 21.2402 21.25 19.6902 21.25 17.7802V10.5002C21.25 9.54021 20.56 8.21021 19.77 7.67021L13.59 3.34021C12.45 2.54021 10.57 2.58021 9.48 3.43021Z"
                                                          fill="#41464B"/>
                                                    <path d="M13.5 18.75H10.5C8.43 18.75 6.75 17.07 6.75 15V12C6.75 9.93 8.43 8.25 10.5 8.25H13.5C15.57 8.25 17.25 9.93 17.25 12V15C17.25 17.07 15.57 18.75 13.5 18.75ZM10.5 9.75C9.26 9.75 8.25 10.76 8.25 12V15C8.25 16.24 9.26 17.25 10.5 17.25H13.5C14.74 17.25 15.75 16.24 15.75 15V12C15.75 10.76 14.74 9.75 13.5 9.75H10.5Z"
                                                          fill="#41464B"/>
                                                    <path d="M12 18.75C11.59 18.75 11.25 18.41 11.25 18V9C11.25 8.59 11.59 8.25 12 8.25C12.41 8.25 12.75 8.59 12.75 9V18C12.75 18.41 12.41 18.75 12 18.75Z"
                                                          fill="#41464B"/>
                                                    <path d="M16.5 14.25H7.5C7.09 14.25 6.75 13.91 6.75 13.5C6.75 13.09 7.09 12.75 7.5 12.75H16.5C16.91 12.75 17.25 13.09 17.25 13.5C17.25 13.91 16.91 14.25 16.5 14.25Z"
                                                          fill="#41464B"/>
                                                </svg>
                                            </figure>
                                            <span>Tiện ích</span>
                                        </div>
                                        <div class="right" id="star_utilities_avg"
                                             data-value="<?= $star_utilities_avg ?>">
                                            <i class="fas fa-star" data-value="1">

                                            </i>
                                            <i class="fas fa-star" data-value="2">

                                            </i>
                                            <i class="fas fa-star" data-value="3">

                                            </i>
                                            <i class="fas fa-star" data-value="4">

                                            </i>
                                            <i class="fas fa-star" data-value="5">

                                            </i>
                                        </div>
                                    </div>
                                </div>
                                <div class="child">
                                    <div class="item">
                                        <div class="left">
                                            <figure>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path d="M5.15039 22.75C4.74039 22.75 4.40039 22.41 4.40039 22V2C4.40039 1.59 4.74039 1.25 5.15039 1.25C5.56039 1.25 5.90039 1.59 5.90039 2V22C5.90039 22.41 5.56039 22.75 5.15039 22.75Z"
                                                          fill="#41464B"/>
                                                    <path d="M16.3504 16.75H5.15039C4.74039 16.75 4.40039 16.41 4.40039 16C4.40039 15.59 4.74039 15.25 5.15039 15.25H16.3504C17.4404 15.25 17.9504 14.96 18.0504 14.71C18.1504 14.46 18.0004 13.9 17.2204 13.13L16.0204 11.93C15.5304 11.5 15.2304 10.85 15.2004 10.13C15.1704 9.37 15.4704 8.62 16.0204 8.07L17.2204 6.87C17.9604 6.13 18.1904 5.53 18.0804 5.27C17.9704 5.01 17.4004 4.75 16.3504 4.75H5.15039C4.73039 4.75 4.40039 4.41 4.40039 4C4.40039 3.59 4.74039 3.25 5.15039 3.25H16.3504C18.5404 3.25 19.2404 4.16 19.4704 4.7C19.6904 5.24 19.8404 6.38 18.2804 7.94L17.0804 9.14C16.8304 9.39 16.6904 9.74 16.7004 10.09C16.7104 10.39 16.8304 10.66 17.0404 10.85L18.2804 12.08C19.8104 13.61 19.6604 14.75 19.4404 15.3C19.2104 15.83 18.5004 16.75 16.3504 16.75Z"
                                                          fill="#41464B"/>
                                                </svg>
                                            </figure>
                                            <span>Giá trị</span>
                                        </div>
                                        <div class="right" id="star_value_avg" data-value="<?= $star_value_avg ?>">
                                            <i class="fas fa-star" data-value="1">

                                            </i>
                                            <i class="fas fa-star" data-value="2">

                                            </i>
                                            <i class="fas fa-star" data-value="3">

                                            </i>
                                            <i class="fas fa-star" data-value="4">

                                            </i>
                                            <i class="fas fa-star" data-value="5">

                                            </i>
                                        </div>
                                    </div>
                                </div>
                                <div class="child">
                                    <div class="item">
                                        <div class="left">
                                            <figure>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path d="M11.9997 22.76C10.5197 22.76 9.02969 22.2 7.86969 21.09C4.91969 18.25 1.65969 13.72 2.88969 8.33C3.99969 3.44 8.26969 1.25 11.9997 1.25C11.9997 1.25 11.9997 1.25 12.0097 1.25C15.7397 1.25 20.0097 3.44 21.1197 8.34C22.3397 13.73 19.0797 18.25 16.1297 21.09C14.9697 22.2 13.4797 22.76 11.9997 22.76ZM11.9997 2.75C9.08969 2.75 5.34969 4.3 4.35969 8.66C3.27969 13.37 6.23969 17.43 8.91969 20C10.6497 21.67 13.3597 21.67 15.0897 20C17.7597 17.43 20.7197 13.37 19.6597 8.66C18.6597 4.3 14.9097 2.75 11.9997 2.75Z"
                                                          fill="#41464B"/>
                                                    <path d="M10.7504 13.7504C10.5604 13.7504 10.3704 13.6804 10.2204 13.5304L8.72043 12.0304C8.43043 11.7404 8.43043 11.2604 8.72043 10.9704C9.01043 10.6804 9.49043 10.6804 9.78043 10.9704L10.7504 11.9404L14.2204 8.47043C14.5104 8.18043 14.9904 8.18043 15.2804 8.47043C15.5704 8.76043 15.5704 9.24043 15.2804 9.53043L11.2804 13.5304C11.1304 13.6804 10.9404 13.7504 10.7504 13.7504Z"
                                                          fill="#41464B"/>
                                                </svg>
                                            </figure>
                                            <span>Vị trí</span>
                                        </div>
                                        <div class="right" id="star_location_avg"
                                             data-value="<?= $star_location_avg ?>">
                                            <i class="fas fa-star" data-value="1">

                                            </i>
                                            <i class="fas fa-star" data-value="2">

                                            </i>
                                            <i class="fas fa-star" data-value="3">

                                            </i>
                                            <i class="fas fa-star" data-value="4">

                                            </i>
                                            <i class="fas fa-star" data-value="5">

                                            </i>
                                        </div>
                                    </div>
                                </div>
                                <div class="child">
                                    <div class="item">
                                        <div class="left">
                                            <figure>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path d="M15.65 21.4102C15.22 21.4102 14.79 21.3202 14.44 21.1502L9.19004 18.5202C8.89004 18.3702 8.30004 18.3802 8.01004 18.5502L5.65004 19.9002C4.63004 20.4802 3.58004 20.5602 2.79004 20.0902C1.99004 19.6302 1.54004 18.6902 1.54004 17.5102V7.79016C1.54004 6.88016 2.14004 5.85016 2.93004 5.40016L7.26004 2.92016C7.99004 2.50016 9.10004 2.47016 9.85004 2.85016L15.1 5.48016C15.4 5.63016 15.98 5.61016 16.28 5.45016L18.63 4.11016C19.65 3.53016 20.7 3.45016 21.49 3.92016C22.29 4.38016 22.74 5.32016 22.74 6.50016V16.2302C22.74 17.1402 22.14 18.1702 21.35 18.6202L17.02 21.1002C16.64 21.3002 16.14 21.4102 15.65 21.4102ZM8.64004 16.9202C9.07004 16.9202 9.50004 17.0102 9.85004 17.1802L15.1 19.8102C15.4 19.9602 15.98 19.9402 16.28 19.7802L20.61 17.3002C20.93 17.1202 21.24 16.5802 21.24 16.2202V6.49016C21.24 5.86016 21.06 5.39016 20.73 5.21016C20.41 5.03016 19.91 5.10016 19.37 5.41016L17.02 6.75016C16.29 7.17016 15.18 7.20016 14.43 6.82016L9.18004 4.19016C8.88004 4.04016 8.30004 4.06016 8.00004 4.22016L3.67004 6.70016C3.35004 6.88016 3.04004 7.42016 3.04004 7.79016V17.5202C3.04004 18.1502 3.22004 18.6202 3.54004 18.8002C3.86004 18.9902 4.36004 18.9102 4.91004 18.6002L7.26004 17.2602C7.65004 17.0302 8.15004 16.9202 8.64004 16.9202Z"
                                                          fill="#41464B"/>
                                                    <path d="M8.55957 17.75C8.14957 17.75 7.80957 17.41 7.80957 17V4C7.80957 3.59 8.14957 3.25 8.55957 3.25C8.96957 3.25 9.30957 3.59 9.30957 4V17C9.30957 17.41 8.96957 17.75 8.55957 17.75Z"
                                                          fill="#41464B"/>
                                                    <path d="M15.7305 20.7501C15.3205 20.7501 14.9805 20.4101 14.9805 20.0001V6.62012C14.9805 6.21012 15.3205 5.87012 15.7305 5.87012C16.1405 5.87012 16.4805 6.21012 16.4805 6.62012V20.0001C16.4805 20.4101 16.1405 20.7501 15.7305 20.7501Z"
                                                          fill="#41464B"/>
                                                </svg>
                                            </figure>
                                            <span>Giao thông</span>
                                        </div>
                                        <div class="right" id="star_traffic_avg" data-value="<?= $star_traffic_avg ?>">
                                            <i class="fas fa-star" data-value="1">

                                            </i>
                                            <i class="fas fa-star" data-value="2">

                                            </i>
                                            <i class="fas fa-star" data-value="3">

                                            </i>
                                            <i class="fas fa-star" data-value="4">

                                            </i>
                                            <i class="fas fa-star" data-value="5">

                                            </i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="option-2">
                <div class="content">
                    <div class="col-xl-6">
                        <div class="col-left">
                            <div class="list">
                                <div class="child">
                                    <div class="top">
                                        <h4>Chất lượng</h4>
                                        <span><?= $star_quality_percent ?>%</span>
                                    </div>
                                    <div class="bot">
                                        <span></span>
                                        <span style="width: <?= $star_quality_percent ?>%"></span>
                                    </div>
                                </div>
                                <div class="child">
                                    <div class="top">
                                        <h4>Tiện ích</h4>
                                        <span><?= $star_utilities_percent ?>%</span>
                                    </div>
                                    <div class="bot">
                                        <span></span>
                                        <span style="width: <?= $star_utilities_percent ?>%"></span>
                                    </div>
                                </div>
                                <div class="child">
                                    <div class="top">
                                        <h4>Vị trí</h4>
                                        <span><?= $star_location_percent ?>%</span>
                                    </div>
                                    <div class="bot">
                                        <span></span>
                                        <span style="width: <?= $star_location_percent ?>%"></span>
                                    </div>
                                </div>
                                <div class="child">
                                    <div class="top">
                                        <h4>Mức giá</h4>
                                        <span><?= $star_price_percent ?>%</span>
                                    </div>
                                    <div class="bot">
                                        <span></span>
                                        <span style="width: <?= $star_price_percent ?>%"></span>
                                    </div>
                                </div>
                                <div class="child">
                                    <div class="top">
                                        <h4>Giá trị</h4>
                                        <span><?= $star_value_percent ?>%</span>
                                    </div>
                                    <div class="bot">
                                        <span></span>
                                        <span style="width: <?= $star_value_percent ?>%"></span>
                                    </div>
                                </div>
                                <div class="child">
                                    <div class="top">
                                        <h4>Giao thông</h4>
                                        <span><?= $star_traffic_percent ?>%</span>
                                    </div>
                                    <div class="bot">
                                        <span></span>
                                        <span style="width: <?= $star_traffic_percent ?>%"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="col-right">
                            <div class="image">
                                <figure class="highcharts-figure">
                                    <div id="container"></div>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="option-3">
                <div class="content row">
                    <div class="col-xl-7">
                        <div class="col-left">
                            <div class="title">
                                <h3>Tất cả đánh giá</h3>
                                <div class="action">
                                    <span>Sắp xếp theo:</span>
                                    <select name="" id="">
                                        <option value="">Mới nhất</option>
                                        <option value="">Cũ nhất</option>
                                    </select>
                                </div>
                            </div>
                            <div class="list">
                                <?php
                                if (!empty($results[0])):
                                    foreach ($results as $key => $result):
                                        if ($key > 4) {
                                            break;
                                        }
                                        ?>
                                        <div class="child">
                                            <!--                                <div class="avatar">-->
                                            <!--                                    <figure>-->
                                            <!--                                        <img src="./dist/images/img-33.png" alt="">-->
                                            <!--                                    </figure>-->
                                            <!--                                </div>-->
                                            <div class="text">
                                                <div class="top">
                                                    <h4><?= $result->reviewer_name; ?></h4>
                                                    <div class="right">
                                                        <div class="star" id="star_total_<?php echo $key; ?>"
                                                             data-value="<?= $result->star_point; ?>">
                                                            <i class="fas fa-star" data-value="1">

                                                            </i>
                                                            <i class="fas fa-star" data-value="2">

                                                            </i>
                                                            <i class="fas fa-star" data-value="3">

                                                            </i>
                                                            <i class="fas fa-star" data-value="4">

                                                            </i>
                                                            <i class="fas fa-star" data-value="5">

                                                            </i>
                                                        </div>
                                                        <script>
                                                            document.addEventListener("DOMContentLoaded", function () {
                                                                var starTotal = document.getElementById("star_total_<?php echo $key; ?>").getAttribute("data-value");
                                                                var stars = document.querySelectorAll("#star_total_<?php echo $key; ?> i");
                                                                stars.forEach(function (star) {
                                                                    if (star.getAttribute("data-value") <= starTotal) {
                                                                        star.classList.add("active");
                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                        <span>
                                                <?=
                                                date('d/m/y', $result->date_time)
                                                ?>
                                            </span>
                                                    </div>
                                                </div>
                                                <div class="bot">
                                                    <p>
                                                        <?= $result->note; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <? endforeach;
                                else:
                                    ?>
                                    <p>Hiện chưa có đánh giá</p>
                                <?php
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="col-right">
                            <div class="title">
                                <h4>Viết đánh giá</h4>
                            </div>
                            <div class="rating">
                                <span>Đánh giá bằng sao:</span>
                                <div class="star star-rating" id="star_total">
                                    <div class="item" data-value='1'>
                                        <label for="star-1"><i class="fas fa-star"></i></label>
                                    </div>
                                    <div class="item" data-value='2'>
                                        <label for="star-2"><i class="fas fa-star"></i></label>
                                    </div>
                                    <div class="item" data-value='3'>
                                        <label for="star-3"><i class="fas fa-star"></i></label>
                                    </div>
                                    <div class="item" data-value='4'>
                                        <label for="star-4"><i class="fas fa-star"></i></label>
                                    </div>
                                    <div class="item" data-value='5'>
                                        <label for="star-5"><i class="fas fa-star"></i></label>
                                    </div>
                                </div>
                            </div>
                            <div class="rating-detail">
                                <div class="name">
                                    <h4>Đánh giá các tiêu chí cụ thể</h4>
                                    <div class="desc">
                                        <p>(Tiêu chí cụ thể giúp đánh giá chính xác hơn)</p>
                                    </div>
                                </div>
                                <div class="list">
                                    <div class="child">
                                        <div class="left">
                                            <figure>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path d="M11.7904 11.88C11.2504 11.88 10.7004 11.78 10.2704 11.59L4.37039 8.97C2.87039 8.3 2.65039 7.4 2.65039 6.91C2.65039 6.42 2.87039 5.52 4.37039 4.85L10.2704 2.23C11.1404 1.84 12.4504 1.84 13.3204 2.23L19.2304 4.85C20.7204 5.51 20.9504 6.42 20.9504 6.91C20.9504 7.4 20.7304 8.3 19.2304 8.97L13.3204 11.59C12.8804 11.79 12.3404 11.88 11.7904 11.88ZM11.7904 3.44C11.4504 3.44 11.1204 3.49 10.8804 3.6L4.98039 6.22C4.37039 6.5 4.15039 6.78 4.15039 6.91C4.15039 7.04 4.37039 7.33 4.97039 7.6L10.8704 10.22C11.3504 10.43 12.2204 10.43 12.7004 10.22L18.6104 7.6C19.2204 7.33 19.4404 7.04 19.4404 6.91C19.4404 6.78 19.2204 6.49 18.6104 6.22L12.7104 3.6C12.4704 3.5 12.1304 3.44 11.7904 3.44Z"
                                                          fill="#41464B"/>
                                                    <path d="M12 17.09C11.62 17.09 11.24 17.01 10.88 16.85L4.09 13.83C3.06 13.38 2.25 12.13 2.25 11C2.25 10.59 2.59 10.25 3 10.25C3.41 10.25 3.75 10.59 3.75 11C3.75 11.55 4.2 12.24 4.7 12.47L11.49 15.49C11.81 15.63 12.18 15.63 12.51 15.49L19.3 12.47C19.8 12.25 20.25 11.55 20.25 11C20.25 10.59 20.59 10.25 21 10.25C21.41 10.25 21.75 10.59 21.75 11C21.75 12.13 20.94 13.38 19.91 13.84L13.12 16.86C12.76 17.01 12.38 17.09 12 17.09Z"
                                                          fill="#41464B"/>
                                                    <path d="M12 22.0902C11.62 22.0902 11.24 22.0102 10.88 21.8502L4.09 18.8302C2.97 18.3302 2.25 17.2202 2.25 15.9902C2.25 15.5802 2.59 15.2402 3 15.2402C3.41 15.2402 3.75 15.5902 3.75 16.0002C3.75 16.6302 4.12 17.2102 4.7 17.4702L11.49 20.4902C11.81 20.6302 12.18 20.6302 12.51 20.4902L19.3 17.4702C19.88 17.2102 20.25 16.6402 20.25 16.0002C20.25 15.5902 20.59 15.2502 21 15.2502C21.41 15.2502 21.75 15.5902 21.75 16.0002C21.75 17.2302 21.03 18.3402 19.91 18.8402L13.12 21.8602C12.76 22.0102 12.38 22.0902 12 22.0902Z"
                                                          fill="#41464B"/>
                                                </svg>
                                            </figure>
                                            <span>Chất lượng</span>
                                        </div>
                                        <div class="right star-rating" id="star_quality">
                                            <div class="item" data-value='1'>
                                                <label for="r1-1"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='2'>
                                                <label for="r1-2"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='3'>
                                                <label for="r1-3"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='4'>
                                                <label for="r1-4"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='5'>
                                                <label for="r1-5"><i class="fas fa-star"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="child">
                                        <div class="left">
                                            <figure>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path d="M17.79 22.7402H6.21C3.47 22.7402 1.25 20.5102 1.25 17.7702V10.3602C1.25 9.00021 2.09 7.29021 3.17 6.45021L8.56 2.25021C10.18 0.990208 12.77 0.930208 14.45 2.11021L20.63 6.44021C21.82 7.27021 22.75 9.05021 22.75 10.5002V17.7802C22.75 20.5102 20.53 22.7402 17.79 22.7402ZM9.48 3.43021L4.09 7.63021C3.38 8.19021 2.75 9.46021 2.75 10.3602V17.7702C2.75 19.6802 4.3 21.2402 6.21 21.2402H17.79C19.7 21.2402 21.25 19.6902 21.25 17.7802V10.5002C21.25 9.54021 20.56 8.21021 19.77 7.67021L13.59 3.34021C12.45 2.54021 10.57 2.58021 9.48 3.43021Z"
                                                          fill="#41464B"/>
                                                    <path d="M13.5 18.75H10.5C8.43 18.75 6.75 17.07 6.75 15V12C6.75 9.93 8.43 8.25 10.5 8.25H13.5C15.57 8.25 17.25 9.93 17.25 12V15C17.25 17.07 15.57 18.75 13.5 18.75ZM10.5 9.75C9.26 9.75 8.25 10.76 8.25 12V15C8.25 16.24 9.26 17.25 10.5 17.25H13.5C14.74 17.25 15.75 16.24 15.75 15V12C15.75 10.76 14.74 9.75 13.5 9.75H10.5Z"
                                                          fill="#41464B"/>
                                                    <path d="M12 18.75C11.59 18.75 11.25 18.41 11.25 18V9C11.25 8.59 11.59 8.25 12 8.25C12.41 8.25 12.75 8.59 12.75 9V18C12.75 18.41 12.41 18.75 12 18.75Z"
                                                          fill="#41464B"/>
                                                    <path d="M16.5 14.25H7.5C7.09 14.25 6.75 13.91 6.75 13.5C6.75 13.09 7.09 12.75 7.5 12.75H16.5C16.91 12.75 17.25 13.09 17.25 13.5C17.25 13.91 16.91 14.25 16.5 14.25Z"
                                                          fill="#41464B"/>
                                                </svg>
                                            </figure>
                                            <span>Tiện ích</span>
                                        </div>
                                        <div class="right star-rating" id="star_utilities">
                                            <div class="item" data-value='1'>
                                                <label for="r2-1"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='2'>
                                                <label for="r2-2"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='3'>
                                                <label for="r2-3"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='4'>
                                                <label for="r2-4"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='5'>
                                                <label for="r2-4"><i class="fas fa-star"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="child">
                                        <div class="left">
                                            <figure>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path d="M11.9997 22.76C10.5197 22.76 9.02969 22.2 7.86969 21.09C4.91969 18.25 1.65969 13.72 2.88969 8.33C3.99969 3.44 8.26969 1.25 11.9997 1.25C11.9997 1.25 11.9997 1.25 12.0097 1.25C15.7397 1.25 20.0097 3.44 21.1197 8.34C22.3397 13.73 19.0797 18.25 16.1297 21.09C14.9697 22.2 13.4797 22.76 11.9997 22.76ZM11.9997 2.75C9.08969 2.75 5.34969 4.3 4.35969 8.66C3.27969 13.37 6.23969 17.43 8.91969 20C10.6497 21.67 13.3597 21.67 15.0897 20C17.7597 17.43 20.7197 13.37 19.6597 8.66C18.6597 4.3 14.9097 2.75 11.9997 2.75Z"
                                                          fill="#41464B"/>
                                                    <path d="M10.7504 13.7504C10.5604 13.7504 10.3704 13.6804 10.2204 13.5304L8.72043 12.0304C8.43043 11.7404 8.43043 11.2604 8.72043 10.9704C9.01043 10.6804 9.49043 10.6804 9.78043 10.9704L10.7504 11.9404L14.2204 8.47043C14.5104 8.18043 14.9904 8.18043 15.2804 8.47043C15.5704 8.76043 15.5704 9.24043 15.2804 9.53043L11.2804 13.5304C11.1304 13.6804 10.9404 13.7504 10.7504 13.7504Z"
                                                          fill="#41464B"/>
                                                </svg>
                                            </figure>
                                            <span>Vị trí</span>
                                        </div>
                                        <div class="right star-rating" id="star_location">
                                            <div class="item" data-value='1'>
                                                <label for="r3-1"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='2'>
                                                <label for="r3-2"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='3'>
                                                <label for="r3-3"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='4'>
                                                <label for="r3-4"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='5'>
                                                <label for="r3-5"><i class="fas fa-star"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="child">
                                        <div class="left">
                                            <figure>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path d="M13.4002 17.4201H10.8902C9.25016 17.4201 7.92016 16.0401 7.92016 14.3401C7.92016 13.9301 8.26016 13.5901 8.67016 13.5901C9.08016 13.5901 9.42016 13.9301 9.42016 14.3401C9.42016 15.2101 10.0802 15.9201 10.8902 15.9201H13.4002C14.0502 15.9201 14.5902 15.3401 14.5902 14.6401C14.5902 13.7701 14.2802 13.6001 13.7702 13.4201L9.74016 12.0001C8.96016 11.7301 7.91016 11.1501 7.91016 9.36008C7.91016 7.82008 9.12016 6.58008 10.6002 6.58008H13.1102C14.7502 6.58008 16.0802 7.96008 16.0802 9.66008C16.0802 10.0701 15.7402 10.4101 15.3302 10.4101C14.9202 10.4101 14.5802 10.0701 14.5802 9.66008C14.5802 8.79008 13.9202 8.08008 13.1102 8.08008H10.6002C9.95016 8.08008 9.41016 8.66008 9.41016 9.36008C9.41016 10.2301 9.72016 10.4001 10.2302 10.5801L14.2602 12.0001C15.0402 12.2701 16.0902 12.8501 16.0902 14.6401C16.0802 16.1701 14.8802 17.4201 13.4002 17.4201Z"
                                                          fill="#41464B"/>
                                                    <path d="M12 18.75C11.59 18.75 11.25 18.41 11.25 18V6C11.25 5.59 11.59 5.25 12 5.25C12.41 5.25 12.75 5.59 12.75 6V18C12.75 18.41 12.41 18.75 12 18.75Z"
                                                          fill="#41464B"/>
                                                    <path d="M12 22.75C6.07 22.75 1.25 17.93 1.25 12C1.25 6.07 6.07 1.25 12 1.25C17.93 1.25 22.75 6.07 22.75 12C22.75 17.93 17.93 22.75 12 22.75ZM12 2.75C6.9 2.75 2.75 6.9 2.75 12C2.75 17.1 6.9 21.25 12 21.25C17.1 21.25 21.25 17.1 21.25 12C21.25 6.9 17.1 2.75 12 2.75Z"
                                                          fill="#41464B"/>
                                                </svg>
                                            </figure>
                                            <span>Mức giá</span>
                                        </div>
                                        <div class="right star-rating" id="star_price">
                                            <div class="item" data-value='1'>
                                                <label for="r4-1"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='2'>
                                                <label for="r4-2"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='3'>
                                                <label for="r4-3"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='4'>
                                                <label for="r4-4"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='5'>
                                                <label for="r4-5"><i class="fas fa-star"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="child">
                                        <div class="left">
                                            <figure>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path d="M5.15039 22.75C4.74039 22.75 4.40039 22.41 4.40039 22V2C4.40039 1.59 4.74039 1.25 5.15039 1.25C5.56039 1.25 5.90039 1.59 5.90039 2V22C5.90039 22.41 5.56039 22.75 5.15039 22.75Z"
                                                          fill="#41464B"/>
                                                    <path d="M16.3504 16.75H5.15039C4.74039 16.75 4.40039 16.41 4.40039 16C4.40039 15.59 4.74039 15.25 5.15039 15.25H16.3504C17.4404 15.25 17.9504 14.96 18.0504 14.71C18.1504 14.46 18.0004 13.9 17.2204 13.13L16.0204 11.93C15.5304 11.5 15.2304 10.85 15.2004 10.13C15.1704 9.37 15.4704 8.62 16.0204 8.07L17.2204 6.87C17.9604 6.13 18.1904 5.53 18.0804 5.27C17.9704 5.01 17.4004 4.75 16.3504 4.75H5.15039C4.73039 4.75 4.40039 4.41 4.40039 4C4.40039 3.59 4.74039 3.25 5.15039 3.25H16.3504C18.5404 3.25 19.2404 4.16 19.4704 4.7C19.6904 5.24 19.8404 6.38 18.2804 7.94L17.0804 9.14C16.8304 9.39 16.6904 9.74 16.7004 10.09C16.7104 10.39 16.8304 10.66 17.0404 10.85L18.2804 12.08C19.8104 13.61 19.6604 14.75 19.4404 15.3C19.2104 15.83 18.5004 16.75 16.3504 16.75Z"
                                                          fill="#41464B"/>
                                                </svg>
                                            </figure>
                                            <span>Giá trị</span>
                                        </div>
                                        <div class="right star-rating" id="star_value">
                                            <div class="item" data-value='1'>
                                                <label for="r5-1"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='2'>
                                                <label for="r5-2"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='3'>
                                                <label for="r5-3"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='4'>
                                                <label for="r5-4"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='5'>
                                                <label for="r5-5"><i class="fas fa-star"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="child">
                                        <div class="left">
                                            <figure>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path d="M15.65 21.4102C15.22 21.4102 14.79 21.3202 14.44 21.1502L9.19004 18.5202C8.89004 18.3702 8.30004 18.3802 8.01004 18.5502L5.65004 19.9002C4.63004 20.4802 3.58004 20.5602 2.79004 20.0902C1.99004 19.6302 1.54004 18.6902 1.54004 17.5102V7.79016C1.54004 6.88016 2.14004 5.85016 2.93004 5.40016L7.26004 2.92016C7.99004 2.50016 9.10004 2.47016 9.85004 2.85016L15.1 5.48016C15.4 5.63016 15.98 5.61016 16.28 5.45016L18.63 4.11016C19.65 3.53016 20.7 3.45016 21.49 3.92016C22.29 4.38016 22.74 5.32016 22.74 6.50016V16.2302C22.74 17.1402 22.14 18.1702 21.35 18.6202L17.02 21.1002C16.64 21.3002 16.14 21.4102 15.65 21.4102ZM8.64004 16.9202C9.07004 16.9202 9.50004 17.0102 9.85004 17.1802L15.1 19.8102C15.4 19.9602 15.98 19.9402 16.28 19.7802L20.61 17.3002C20.93 17.1202 21.24 16.5802 21.24 16.2202V6.49016C21.24 5.86016 21.06 5.39016 20.73 5.21016C20.41 5.03016 19.91 5.10016 19.37 5.41016L17.02 6.75016C16.29 7.17016 15.18 7.20016 14.43 6.82016L9.18004 4.19016C8.88004 4.04016 8.30004 4.06016 8.00004 4.22016L3.67004 6.70016C3.35004 6.88016 3.04004 7.42016 3.04004 7.79016V17.5202C3.04004 18.1502 3.22004 18.6202 3.54004 18.8002C3.86004 18.9902 4.36004 18.9102 4.91004 18.6002L7.26004 17.2602C7.65004 17.0302 8.15004 16.9202 8.64004 16.9202Z"
                                                          fill="#41464B"/>
                                                    <path d="M8.55957 17.75C8.14957 17.75 7.80957 17.41 7.80957 17V4C7.80957 3.59 8.14957 3.25 8.55957 3.25C8.96957 3.25 9.30957 3.59 9.30957 4V17C9.30957 17.41 8.96957 17.75 8.55957 17.75Z"
                                                          fill="#41464B"/>
                                                    <path d="M15.7305 20.7501C15.3205 20.7501 14.9805 20.4101 14.9805 20.0001V6.62012C14.9805 6.21012 15.3205 5.87012 15.7305 5.87012C16.1405 5.87012 16.4805 6.21012 16.4805 6.62012V20.0001C16.4805 20.4101 16.1405 20.7501 15.7305 20.7501Z"
                                                          fill="#41464B"/>
                                                </svg>
                                            </figure>
                                            <span>Giao thông</span>
                                        </div>
                                        <div class="right star-rating" id="stars_traffic">
                                            <div class="item" data-value='1'>
                                                <label for="r6-1">
                                                    <i class="fas fa-star fa-fw"></i>
                                                </label>
                                            </div>
                                            <div class="item" data-value='2'>
                                                <label for="r6-2"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='3'>
                                                <label for="r6-3"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='4'>
                                                <label for="r6-4"><i class="fas fa-star"></i></label>
                                            </div>
                                            <div class="item" data-value='5'>
                                                <label for="r6-5"><i class="fas fa-star"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="review">
                                <h4>Viết đánh giá</h4>
                                <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post"
                                      id="form_review">
                                    <input type="hidden" name="action" value="form_review">
                                    <input type="hidden" name="id_post" value="<?php echo get_the_ID(); ?>">
                                    <input type="hidden" name="title_post" value="<?php echo get_the_title(); ?>">
                                    <input type="hidden" name="link_post" value="<?php echo get_the_permalink(); ?>">
                                    <input type="hidden" name="star_quality" value="0" id="stars_quality_input">
                                    <input type="hidden" name="star_utilities" value="0" id="stars_utilities_input">
                                    <input type="hidden" name="star_location" value="0" id="stars_location_input">
                                    <input type="hidden" name="star_price" value="0" id="stars_price_input">
                                    <input type="hidden" name="star_value" value="0" id="stars_value_input">
                                    <input type="hidden" name="star_traffic" value="0" id="stars_traffic_input">
                                    <input type="hidden" name="star_point" value="0" id="stars_point_input">
                                    <input type="text" placeholder="Họ và tên" class="form-control name"
                                           name="reviewer_name" id="reviewer_name">
                                    <textarea name="note" id="content" cols="30" rows="10"
                                              placeholder="Nhập nội dung"></textarea>
                                    <button>Gửi đánh giá</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-dtda-9">
        <div class="container">
            <div class="title">
                <h3>Dự án liên quan</h3>
            </div>
            <div class="content row">
                <?php
                $taxonomies = get_object_taxonomies('project');
                $terms = get_the_terms(get_the_ID(), $taxonomies[0]);
                $args_project = array(
                    'post_type' => 'project',
                    'posts_per_page' => 3,
                    'post_status' => 'publish',
                    'post__not_in' => array(get_the_ID()),
                    'tax_query' => array(
                        array(
                            'taxonomy' => $taxonomies[0],
                            'field' => 'slug',
                            'terms' => $terms[0]->slug
                        )
                    )
                );
                $query_project = new WP_Query($args_project);
                ?>
                <?php if ($query_project->have_posts()) : ?>
                    <?php while ($query_project->have_posts()) : $query_project->the_post(); ?>
                        <div class="col-xl-4">
                            <div class="child">
                                <div class="image">
                                    <figure>
                                        <img src="<?= getimage(get_post_thumbnail_id()) ?>" alt="">
                                    </figure>
                                    <div class="info">
                                        <p class="status">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                 viewBox="0 0 18 18"
                                                 fill="none">
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
                                        <p class="acreage">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                 viewBox="0 0 18 18"
                                                 fill="none">
                                                <path d="M11.25 17.0625H6.75C2.6775 17.0625 0.9375 15.3225 0.9375 11.25V6.75C0.9375 2.6775 2.6775 0.9375 6.75 0.9375H11.25C15.3225 0.9375 17.0625 2.6775 17.0625 6.75V11.25C17.0625 15.3225 15.3225 17.0625 11.25 17.0625ZM6.75 2.0625C3.2925 2.0625 2.0625 3.2925 2.0625 6.75V11.25C2.0625 14.7075 3.2925 15.9375 6.75 15.9375H11.25C14.7075 15.9375 15.9375 14.7075 15.9375 11.25V6.75C15.9375 3.2925 14.7075 2.0625 11.25 2.0625H6.75Z"
                                                      fill="white"/>
                                                <path d="M10.4626 17.0625C10.2076 17.0625 9.98254 16.89 9.91504 16.635L6.20257 1.63501C6.12757 1.33501 6.31506 1.02752 6.61506 0.952521C6.91506 0.877521 7.22254 1.05752 7.29754 1.36502L11.0101 16.365C11.0851 16.665 10.8976 16.9725 10.5976 17.0475C10.5526 17.055 10.5076 17.0625 10.4626 17.0625Z"
                                                      fill="white"/>
                                                <path d="M1.49989 11.8129C1.25239 11.8129 1.03491 11.6554 0.959911 11.4079C0.869911 11.1079 1.04237 10.8004 1.34237 10.7104L8.48989 8.62544C8.78989 8.53544 9.09739 8.70793 9.18739 9.00793C9.27739 9.30793 9.10488 9.61544 8.80488 9.70544L1.65741 11.7904C1.60491 11.8054 1.55239 11.8129 1.49989 11.8129Z"
                                                      fill="white"/>
                                            </svg>
                                            Diện tích: <?= get_field('area') ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="text">
                                    <div class="category">
                                        <span>Biệt thự</span>
                                    </div>
                                    <div class="name">
                                        <a href="<?= the_permalink() ?>">
                                            <?= the_title() ?>
                                        </a>
                                    </div>
                                    <div class="desc">
                                        <p><strong>Địa chỉ:</strong><?= get_field('address') ?></p>
                                        <p><strong>Chủ đầu tư:</strong><?= get_field('company') ?></p>
                                        <!--                                <p><strong>Liên hệ:</strong><a href="#">098 545 8888</a></p>-->
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
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php get_footer(); ?>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        // get data từ data-value
        var star_quality_avg = $('#star_quality_avg').data('value');
        var star_utilities_avg = $('#star_utilities_avg').data('value');
        var star_location_avg = $('#star_location_avg').data('value');
        var star_price_avg = $('#star_price_avg').data('value');
        var star_value_avg = $('#star_value_avg').data('value');
        var star_traffic_avg = $('#star_traffic_avg').data('value');
        console.log(star_quality_avg);
        Highcharts.chart('container', {

            chart: {
                polar: true,
                type: 'line',
            },
            pane: {
                size: '90%'
            },
            xAxis: {
                categories: ['Chất lượng', 'Tiện ích', 'Vị trí', 'Mức giá',
                    'Giá trị', 'Giao thông'],
                tickmarkPlacement: 'off',
                lineWidth: 0,
                labels: {
                    style: {
                        fontSize: '13px'
                    }
                }
            },
            yAxis: {
                gridLineInterpolation: 'polygon',
                lineWidth: 0,
                min: 0
            },
            tooltip: {
                shared: true,
                pointFormat: '<span style="color:{series.color}">{series.name}: <b>${point.y:,.0f}</b><br/>'
            },
            legend: {
                align: 'right',
                verticalAlign: 'middle',
                layout: 'vertical'
            },
            plotOptions: {
                series: {
                    showInLegend: false,
                    enableMouseTracking: false,
                    //
                }
            },
            series: [{
                data: [star_quality_avg, star_utilities_avg, star_location_avg, star_price_avg, star_value_avg, star_traffic_avg],
                pointPlacement: 'on',
                color: 'red'
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            align: 'center',
                            verticalAlign: 'bottom',
                            layout: 'horizontal'
                        },
                        pane: {
                            size: '70%'
                        }
                    }
                }]
            }
        });

    </script>
    <script>
        var swiper = new Swiper('.timeline', {
            slidesPerView: 8,
            spaceBetween: 0,
            grabCursor: true,
            speed: 500,
            loop: false,
            navigation: {
                nextEl: '.slider-button-next',
                prevEl: '.slider-button-prev',
            },
        });
    </script>
    <script>
        $(document).ready(function () {
            function handleHoverAndClick(container) {
                $(container + ' .item').hover(function () {
                    var onStar = parseInt($(this).data('value'), 10);
                    for (i = 0; i < onStar; i++) {
                        $(this).parent().children('.item').eq(i).addClass('hover');
                    }
                }, function () {
                    var onStar = parseInt($(this).data('value'), 10);
                    for (i = 0; i < onStar; i++) {
                        $(this).parent().children('.item').eq(i).removeClass('hover');
                    }
                });

                $(container + ' .item').on('click', function () {
                    var stars = $(this).parent().children('.item');
                    var onStar = parseInt($(this).data('value'), 10);
                    for (i = 0; i < stars.length; i++) {
                        $(stars[i]).removeClass('selected');
                    }
                    for (i = 0; i < onStar; i++) {
                        $(stars[i]).addClass('selected');
                    }
                    stars.removeClass('selected').slice(0, onStar).addClass('selected');

                    var clickedValue = parseInt($(this).data('value'), 10);
                    if (container == '#star_quality') {
                        $('#stars_quality_input').val(clickedValue);
                    } else if (container == '#star_value') {
                        $('#stars_value_input').val(clickedValue);
                    } else if (container == '#star_location') {
                        $('#stars_location_input').val(clickedValue);
                    } else if (container == '#star_utilities') {
                        $('#stars_utilities_input').val(clickedValue);
                    } else if (container == '#stars_traffic') {
                        $('#stars_traffic_input').val(clickedValue);
                    } else if (container == '#star_price') {
                        $('#stars_price_input').val(clickedValue);
                    }
                    // tính điểm trung bình
                    if ($('#stars_quality_input').val() != 0 && $('#stars_value_input').val() != 0 && $('#stars_location_input').val() != 0 && $('#stars_utilities_input').val() != 0 && $('#stars_traffic_input').val() != 0 && $('#stars_price_input').val() != 0) {
                        var total = parseInt($('#stars_quality_input').val()) + parseInt($('#stars_value_input').val()) + parseInt($('#stars_location_input').val()) + parseInt($('#stars_utilities_input').val()) + parseInt($('#stars_traffic_input').val()) + parseInt($('#stars_price_input').val());
                        var average = total / 6;
                        average = Math.round(average * 10) / 10;
                        $stars_point_input = $('#stars_point_input');
                        $stars_point_input.val(average);

                        // tô màu sao điểm trung bình
                        var stars_point_total = parseInt($stars_point_input.val());
                        var stars_total = $('#star_total');
                        stars_total.find('.item').each(function (index) {
                            if (index < stars_point_total) {
                                $(this).addClass('selected');
                            } else {
                                $(this).removeClass('selected');
                            }
                        });

                    }
                });
            }

            handleHoverAndClick('#stars_traffic');
            handleHoverAndClick('#star_value');
            handleHoverAndClick('#star_quality');
            handleHoverAndClick('#star_utilities');
            handleHoverAndClick('#star_location');
            handleHoverAndClick('#star_price');
            //
            $('#form_review').submit(function () {
                if ($('#stars_point_input').val() == 0 || $.trim($('#reviewer_name').val()) == '' || $.trim($('#content').val()) == '') {
                    alert('Vui lòng đánh giá đầy đủ các tiêu chí');
                    return false;
                }
            });

        });

        // điểm trung bình các tiêu chí
        function addActiveClass(elementId) {
            let star_avg = document.getElementById(elementId).getAttribute('data-value');
            let star_avg_i = document.querySelectorAll(`#${elementId} i`);

            star_avg_i.forEach(item => {
                if (item.getAttribute('data-value') <= star_avg) {
                    item.classList.add('active');
                }
            });
        }

        addActiveClass('star_quality_avg');
        addActiveClass('star_price_avg');
        addActiveClass('star_utilities_avg');
        addActiveClass('star_value_avg');
        addActiveClass('star_location_avg');
        addActiveClass('star_traffic_avg');
        // tính số phần trăm của thanh tiến độ


        // scroll khi click đánh giá dự án
        document.getElementById('review').addEventListener('click', function () {
            document.getElementById('review_scroll').scrollIntoView({behavior: 'smooth'});
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.share').click(function() {
                var $listShare = $('.list_share');
                $listShare.toggleClass('active');
                if ($listShare.hasClass('active')) {
                    var height = $listShare[0].scrollHeight;
                    $listShare.css('height', height);
                } else {
                    $listShare.css('height', 0);
                }
            });
        });
    </script>
<?php
if ($_SESSION['error_code'] != 0) {
    if ($_SESSION['error_code'] == 1) {
        echo '<script>
    Swal.fire({
  title: "Thành công!",
  text: "' . $_SESSION['message'] . '",
  icon: "success"
});
 
</script>';
    } else {
        echo '<script>
Swal.fire({
  title: "Thất bại",
  text: "' . $_SESSION['message'] . '",
  icon: "warning"
});

</script>';
    }
}


$_SESSION['error_code'] = 0;
