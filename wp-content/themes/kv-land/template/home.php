<?php
/* Template Name: Trang chủ */
get_header();

$banner = get_field('banner');
$kienthuc = get_field('kienthuc');
$pri_post = get_field('highlight_post');
$choose_project = get_field('choose_project');
$status_project = get_field('status_project', $pri_post->ID);
if ($status_project == 1) {
    $status_project = 'Sắp mở bán';
} else if ($status_project == 2) {
    $status_project = 'Đang mở bán';
} else {
    $status_project = 'Đã bàn giao';
}


$utilities = get_field('utilities', $pri_post->ID);
$re_progress_project = get_field('re_progress_project', $pri_post->ID);
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
$status_project = get_terms(
    array(
        'taxonomy' => 'status_project',
        'hide_empty' => false,
    )
);
$company = get_unique_custom_field_values();
?>
<!--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />-->
<style>
    .add_duan {
        display: none;
    }

    .add_duan.active {
        display: flex;
    }
</style>
<section class="section-banner-homepage">
    <div class="slide-image swiper">
        <div class="swiper-wrapper">
            <?php foreach ($banner as $value): ?>
                <div class="child swiper-slide">
                    <figure>
                        <img src="<?= getimage($value,'large') ?>" alt="">
                    </figure>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="slider-pagination"></div>
    </div>
    <div class="text">
        <div class="container">
            <form action="<?php echo home_url('/'); ?>">
                <div class="title">
                    <h3>Tìm kiếm <span>bất động sản</span> mong muốn</h3>
                    <div class="list">
                        <div class="child">
                            <input type="radio" id="status_bds0" value="" checked
                                   name="status_project">
                            <label for="status_bds0">Tất cả</label>
                        </div>
                        <?php foreach ($status_project as $key => $value):
                            ?>

                            <div class="child">
                                <input type="radio" id="status_bds<?= $value->term_id ?>" value="<?= $value->term_id ?>"
                                       name="status_project">
                                <label for="status_bds<?= $value->term_id ?>"><?= $value->name ?></label>
                            </div>
                        <?php
                        endforeach; ?>
                    </div>
                </div>

                <div class="child">
                    <div class="item">
                        <figure>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none">
                                <path d="M11 20.75C5.62 20.75 1.25 16.38 1.25 11C1.25 5.62 5.62 1.25 11 1.25C16.38 1.25 20.75 5.62 20.75 11C20.75 16.38 16.38 20.75 11 20.75ZM11 2.75C6.45 2.75 2.75 6.45 2.75 11C2.75 15.55 6.45 19.25 11 19.25C15.55 19.25 19.25 15.55 19.25 11C19.25 6.45 15.55 2.75 11 2.75Z"
                                      fill="#565E64"/>
                                <path d="M20.1601 22.79C20.0801 22.79 20.0001 22.78 19.9301 22.77C19.4601 22.71 18.6101 22.39 18.1301 20.96C17.8801 20.21 17.9701 19.46 18.3801 18.89C18.7901 18.32 19.4801 18 20.2701 18C21.2901 18 22.0901 18.39 22.4501 19.08C22.8101 19.77 22.7101 20.65 22.1401 21.5C21.4301 22.57 20.6601 22.79 20.1601 22.79ZM19.5601 20.49C19.7301 21.01 19.9701 21.27 20.1301 21.29C20.2901 21.31 20.5901 21.12 20.9001 20.67C21.1901 20.24 21.2101 19.93 21.1401 19.79C21.0701 19.65 20.7901 19.5 20.2701 19.5C19.9601 19.5 19.7301 19.6 19.6001 19.77C19.4801 19.94 19.4601 20.2 19.5601 20.49Z"
                                      fill="#565E64"/>
                            </svg>
                        </figure>
                        <input type="text" name="s" id="namess" placeholder="Tên dự án">
                    </div>
                    <div class="item price">
                        <select name="prices" id="prices">
                            <option value="">Chọn mức giá</option>
                            <?php foreach ($prices as $value):
                                ?>
                                <option value="<?= $value->term_id ?>"><?= $value->name ?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <div class="child">
                    <div class="item">
                        <select name="areas" id="areas">
                            <option value="">Chọn khu vực</option>
                            <?php foreach ($areas as $value):
                                ?>
                                <option value="<?= $value->term_id ?>"><?= $value->name ?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="item">
                        <select name="company" id="company">
                            <option value="">Chủ đầu tư</option>
                            <?php foreach ($company as $value):

                                ?>
                                <option value="<?= $value ?>"><?= $value ?></option>
                            <?php
                            endforeach; ?>
                        </select>
                    </div>
                    <div class="item">
                        <select name="type_project" id="type_project">
                            <option value="">Loại dự án</option>
                            <?php foreach ($type_pro as $value):
                                ?>
                                <option value="<?= $value->term_id ?>"><?= $value->name ?></option>
                            <?php
                            endforeach; ?>
                        </select>
                    </div>
                    <button>Tìm kiếm</button>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="section-homepage-1">
    <div class="content">
        <div class="col-left">
            <div class="image">
                <figure>
                    <img src="<?= getimage($pri_post->ID, 'large', 'post') ?>" alt="">
                </figure>
            </div>
        </div>
        <div class="col-right">
            <div class="text">
                <div class="info">
                    <div class="status">
                        <span><?= get_the_terms($pri_post->ID,'status_project')[0]->name ?></span>
                    </div>
                    <div class="name">
                        <h3>Dự án <span><?= get_the_title($pri_post->ID) ?></span></h3>
                    </div>
                    <div class="desc">
                        <p><strong>Vị trí:</strong> <span><?= get_field('address', $pri_post->ID) ?></span></p>
                        <?php if(!empty(get_field('area', $pri_post->ID))): ?>
                        <p><strong>Diện tích:</strong> <span><?= get_field('area', $pri_post->ID) ?></span></p>
                        <?php endif; ?>
                        <p><strong>Chủ đầu tư:</strong> <span><?= get_field('company', $pri_post->ID) ?></span></p>
                    </div>
                    <div class="utilities">
                        <h4>Tiện ích</h4>
                        <div class="list">
                            <ul>
                                <?php
                                if (!empty($utilities)):
                                    foreach ($utilities as $value): ?>
                                        <li>
                                            <figure>
                                                <img src="<?= getimage($value['icon']) ?>" alt="">
                                            </figure>
                                            <?= $value['name'] ?>
                                        </li>
                                    <?php endforeach;
                                endif;
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
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
                <div class="action">
                    <div class="left">
                        <a href="<?= get_permalink($pri_post->ID) ?>" class="advise">Tư vấn cho tôi</a>
                        <a href="<?= get_permalink($pri_post->ID) ?>#vitri" class="location">Vị trí</a>
                    </div>
                                            <div class="right">
                                                <a href="<?= get_permalink($pri_post->ID) ?>#review_scroll">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16" fill="none">
                                                        <path d="M2.69333 13.0137C2.28667 13.0137 1.90667 12.8737 1.63333 12.6137C1.28667 12.287 1.12 11.7937 1.18 11.2604L1.42667 9.10036C1.47333 8.69369 1.72 8.15369 2.00667 7.86036L7.48 2.06702C8.84667 0.620358 10.2733 0.580358 11.72 1.94703C13.1667 3.31369 13.2067 4.74036 11.84 6.18703L6.36667 11.9804C6.08667 12.2804 5.56667 12.5604 5.16 12.627L3.01333 12.9937C2.9 13.0004 2.8 13.0137 2.69333 13.0137ZM9.62 1.94036C9.10667 1.94036 8.66 2.26036 8.20667 2.74036L2.73333 8.54036C2.6 8.68036 2.44667 9.01369 2.42 9.20703L2.17333 11.367C2.14667 11.587 2.2 11.767 2.32 11.8804C2.44 11.9937 2.62 12.0337 2.84 12.0004L4.98667 11.6337C5.18 11.6004 5.5 11.427 5.63333 11.287L11.1067 5.49369C11.9333 4.61369 12.2333 3.80036 11.0267 2.66702C10.4933 2.15369 10.0333 1.94036 9.62 1.94036Z" fill="#1479DE"/>
                                                        <path d="M10.56 7.30036C10.5467 7.30036 10.5267 7.30036 10.5133 7.30036C8.43333 7.09369 6.76 5.51369 6.44 3.44703C6.4 3.17369 6.58667 2.92036 6.86 2.87369C7.13333 2.83369 7.38667 3.02036 7.43333 3.29369C7.68667 4.90703 8.99333 6.14703 10.62 6.30703C10.8933 6.33369 11.0933 6.58036 11.0667 6.85369C11.0333 7.10703 10.8133 7.30036 10.56 7.30036Z" fill="#1479DE"/>
                                                        <path d="M13 15.167H1C0.726667 15.167 0.5 14.9404 0.5 14.667C0.5 14.3937 0.726667 14.167 1 14.167H13C13.2733 14.167 13.5 14.3937 13.5 14.667C13.5 14.9404 13.2733 15.167 13 15.167Z" fill="#1479DE"/>
                                                    </svg>
                                                    Đánh giá dự án
                                                </a>
                                            </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-homepage-2">
    <div class="image-banner">
        <figure>
            <img src="<?= getimage(get_field('banner_list')) ?>" alt="">
        </figure>
    </div>
    <div class="text-banner">
        <div class="container">
            <div class="title">
                <div class="left">
                    <figure>
                        <svg xmlns="http://www.w3.org/2000/svg" width="42" height="29" viewBox="0 0 42 29" fill="none">
                            <path d="M0.576172 17.1793L12.3891 28.9962L41.1589 0H24.4325L12.3534 11.8487L0.576172 0.452817V17.1793Z"
                                  fill="white"/>
                        </svg>
                    </figure>
                    <h3>Dự án <span>đang mở bán</span></h3>
                </div>
                <div class="right">
                    <div class="list">
                        <!--                        <div class="child">-->
                        <!--                            <input type="radio" name="duan_home" value="2" data-val="Đang mở bán" id="da-1" checked>-->
                        <!--                            <label for="da-1">Đang mở bán</label>-->
                        <!--                        </div>-->
                        <!--                        <div class="child">-->
                        <!--                            <input type="radio" name="duan_home" id="da-2" value="3" data-val="Đã bàn giao">-->
                        <!--                            <label for="da-2">Đã bàn giao</label>-->
                        <!--                        </div>-->
                        <?php foreach ($choose_project as $key => $value):
                            $cat = get_term($value);
                            ?>
                            <div class="child">
                                <input type="radio" name="duan_home" value="<?= $value ?>" data-val="<?= $cat->name ?>"
                                       id="da-<?= $key ?>" <?= $key == 0 ? 'checked' : '' ?>>
                                <label for="da-<?= $key ?>"><?= $cat->name ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="<?= get_term_link(24) ?>" class="action right_ss">Xem tất cả dự án >></a>
                </div>
            </div>
            <?php
            foreach ($choose_project as $key => $value):
                $cat = get_term($value);
                $args_top_left = array(
                    'post_type' => 'project',
                    'posts_per_page' => 9,
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'status_project',
                            'field' => 'term_id',
                            'terms' => $value
                        )
                    ),
                );
                $query_status_1 = new WP_Query($args_top_left);
                ?>
                <div class="content row add_duan <?= $key == 0 ? 'dangmo active' : 'bangiao' ?> ">
                    <?php if ($query_status_1->have_posts()): ?>
                        <?php while ($query_status_1->have_posts()) :
                            $query_status_1->the_post();

                            ?>
                            <div class="col-xl-4">
                                <div class="child">
                                    <div class="top">
                                        <div class="image">
                                            <figure>
                                                <a href="<?= get_permalink() ?>">
                                                <img src="<?= getimage(get_the_ID(), 'large', 'post') ?>"
                                                     alt="">
                                                </a>
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
                                                    <?= $cat->name ?>
                                                </p>
                                                <p class="acreage">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                         viewBox="0 0 18 18" fill="none">
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
                                                <a href="<?= get_permalink() ?>"><?= get_the_title() ?></span></a>
                                            </div>
                                            <div class="desc">
                                                <p><strong>Vị trí:</strong>
                                                    <span><?= get_field('address') ?></span></p>
                                                <p><strong>Diện tích:</strong>
                                                    <span><?= get_field('area') ?></span></p>
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
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16" fill="none">
                                                    <path d="M2.69333 13.0137C2.28667 13.0137 1.90667 12.8737 1.63333 12.6137C1.28667 12.287 1.12 11.7937 1.18 11.2604L1.42667 9.10036C1.47333 8.69369 1.72 8.15369 2.00667 7.86036L7.48 2.06702C8.84667 0.620358 10.2733 0.580358 11.72 1.94703C13.1667 3.31369 13.2067 4.74036 11.84 6.18703L6.36667 11.9804C6.08667 12.2804 5.56667 12.5604 5.16 12.627L3.01333 12.9937C2.9 13.0004 2.8 13.0137 2.69333 13.0137ZM9.62 1.94036C9.10667 1.94036 8.66 2.26036 8.20667 2.74036L2.73333 8.54036C2.6 8.68036 2.44667 9.01369 2.42 9.20703L2.17333 11.367C2.14667 11.587 2.2 11.767 2.32 11.8804C2.44 11.9937 2.62 12.0337 2.84 12.0004L4.98667 11.6337C5.18 11.6004 5.5 11.427 5.63333 11.287L11.1067 5.49369C11.9333 4.61369 12.2333 3.80036 11.0267 2.66702C10.4933 2.15369 10.0333 1.94036 9.62 1.94036Z" fill="#1479DE"/>
                                                    <path d="M10.56 7.30036C10.5467 7.30036 10.5267 7.30036 10.5133 7.30036C8.43333 7.09369 6.76 5.51369 6.44 3.44703C6.4 3.17369 6.58667 2.92036 6.86 2.87369C7.13333 2.83369 7.38667 3.02036 7.43333 3.29369C7.68667 4.90703 8.99333 6.14703 10.62 6.30703C10.8933 6.33369 11.0933 6.58036 11.0667 6.85369C11.0333 7.10703 10.8133 7.30036 10.56 7.30036Z" fill="#1479DE"/>
                                                    <path d="M13 15.167H1C0.726667 15.167 0.5 14.9404 0.5 14.667C0.5 14.3937 0.726667 14.167 1 14.167H13C13.2733 14.167 13.5 14.3937 13.5 14.667C13.5 14.9404 13.2733 15.167 13 15.167Z" fill="#1479DE"/>
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
            <?php
            endforeach;
            ?>
        </div>
    </div>
</section>

<section class="section-homepage-3">
    <div class="container">
        <div class="content row">
            <div class="col-xl-8">
                <div class="col-left">
                    <div class="title">
                        <div class="left">
                            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="29" viewBox="0 0 41 29"
                                 fill="none">
                                <path d="M0 17.1793L11.813 28.9962L40.5828 0H23.8563L11.7772 11.8487L0 0.452817V17.1793Z"
                                      fill="#A11D25"/>
                            </svg>
                            <h3>Dự án <span>sắp mở bán</span></h3>
                        </div>
                        <div class="right">
                            <a href="<?= get_term_link(25) ?>" class="action ">Xem tất cả dự án >></a>
                        </div>
                    </div>
                    <?php
                    $args_top_left = array(
                        'post_type' => 'project',
                        'posts_per_page' => 5,
                        'tax_query' => array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => 'status_project',
                                'field' => 'term_id',
                                'terms' => array(25)
                            )
                        ),
                    );
                    $query_status_1 = new WP_Query($args_top_left); ?>
                    <div class="list">
                        <?php if ($query_status_1->have_posts()): ?>
                            <?php while ($query_status_1->have_posts()) :
                                $query_status_1->the_post();

                                ?>
                                <div class="child">
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
                                            Sắp mở bán
                                            </p>
                                            <p class="acreage">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                     viewBox="0 0 18 18" fill="none">
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
                                            <a href="<?= get_permalink() ?>"><?= get_the_title() ?></span></a>
                                        </div>
                                        <div class="desc">
                                            <p><strong>Vị trí:</strong>
                                                <span><?= get_field('address') ?></span></p>
                                            <p><strong>Diện tích:</strong>
                                                <span><?= get_field('area') ?></span></p>
                                            <p><strong>Chủ đầu tư:</strong>
                                                <span><?= get_field('company') ?></span></p>
                                        </div>
                                        <div class="action">
                                            <div class="left">
                                                <a href="<?= get_permalink() ?>" class="advise">Đặt mua dự án</a>
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
                </div>
            </div>
            <div class="col-xl-4">
                <div class="col-right">
                    <div class="title">
                        <svg xmlns="http://www.w3.org/2000/svg" width="41" height="29" viewBox="0 0 41 29" fill="none">
                            <path d="M0 17.1793L11.813 28.9962L40.5828 0H23.8563L11.7772 11.8487L0 0.452817V17.1793Z"
                                  fill="#A11D25"/>
                        </svg>
                        <h3>Bảng giá <span>dự án</span></h3>
                    </div>
                    <div class="fillter">
                        <div class="item">
                            <select name="banggia_areas" id="banggia_areas">
                                <option value="">Chọn khu vực</option>
                                <?php foreach ($areas as $value):
                                    ?>
                                    <option value="<?= $value->term_id ?>"><?= $value->name ?></option>
                                <?php
                                endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <?php
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
                    $query_status_1 = new WP_Query($args_top_left); ?>
                    <table>
                        <thead>
                        <tr>
                            <th>Tên dự án</th>
                            <th>Triệu đồng</th>
                        </tr>
                        </thead>
                        <tbody class="body_duan">
                        <?php if ($query_status_1->have_posts()): ?>
                            <?php while ($query_status_1->have_posts()) :
                                $query_status_1->the_post(); ?>
                                <tr>
                                    <td><a href="<?= get_permalink() ?>"><?= get_the_title() ?></a></td>
                                    <td><a href="<?= get_permalink() ?>"><?= !empty(get_field('price_project')) ? money_check(get_field('price_project')) : 'Liên hệ' ?></a></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif;
                        wp_reset_postdata(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-homepage-4">
    <div class="content">
        <div class="col-left">
            <div class="image">
                <figure>
                    <img src="<?= getimage(get_field('img')) ?>" alt="">
                </figure>
            </div>
        </div>
        <div class="col-right">
            <div class="left">
                <div class="title">
                    <h3>Công cụ <span>ước tính khoản vay</span></h3>
                </div>
                <form action="">
                    <div class="child">
                        <div class="item">
                            <label>Giá trị nhà đất</label>
                            <div class="input">
                                <input type="text" id="giatri"  >
                                <span>Đ</span>
                            </div>
                        </div>
                    </div>
                    <div class="child">
                        <div class="item">
                            <label>Tỉ lệ vay</label>
                            <div class="input">
                                <input type="number" id="tilevay" value="0">
                                <span>%</span>
                            </div>
                        </div>
                        <div class="item">
                            <label>Số tiền vay</label>
                            <div class="input">
                                <input type="text" value="0" id="loanvay" readonly>
                                <span>Đ</span>
                            </div>
                        </div>
                    </div>
                    <div class="child">
                        <div class="item">
                            <label for="#">Thời hạn vay</label>
                            <div class="input">
                                <input type="number" id="year_pay" value="1">
                                <span>năm</span>
                            </div>
                        </div>
                    </div>
                    <div class="child">
                        <div class="item ">
                            <label for="#">Lãi xuất vay ngân hàng %/năm</label>
                            <div class="interest-rate">
                                <div class="input">
                                    <select name="lai_suat_vay" id="lai_suat_vay">
                                        <option value="">Tùy chọn</option>
                                        <?php
                                        $lai_suat_vay = get_field('lai_suat_vay', 'option');
                                        foreach ($lai_suat_vay as $value):
                                            ?>
                                            <option value="<?= $value['value'] ?>"><?= $value['name'] ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="input percent">
                                    <input type="text" id="input_lai_suat_vay" >
                                    <span>%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="child">
                        <div class="item">
                            <label for="">Loại hình</label>
                            <div class="input">
                                <select name="hinhthuc" id="hinhthuc">
                                    <option value="">Tùy chọn</option>
                                    <?php
                                    $hinhthuc = get_field('hinhthuc', 'option');
                                    foreach ($hinhthuc as $value):
                                        ?>
                                        <option value="<?= $value['key'] ?>"><?= $value['title'] ?></option>
                                    <?php
                                    endforeach;
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                <span class="note">
                    <figure>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M12 13C12.2652 13 12.5196 12.8946 12.7071 12.7071C12.8946 12.5196 13 12.2652 13 12L13 8C13 7.73478 12.8946 7.48043 12.7071 7.29289C12.5196 7.10536 12.2652 7 12 7C11.7348 7 11.4804 7.10536 11.2929 7.29289C11.1054 7.48043 11 7.73478 11 8L11 12C11 12.2652 11.1054 12.5196 11.2929 12.7071C11.4804 12.8946 11.7348 13 12 13ZM11.62 16.92C11.8635 17.02 12.1365 17.02 12.38 16.92C12.5027 16.8724 12.6149 16.801 12.71 16.71C12.7983 16.6128 12.8694 16.5012 12.92 16.38C12.976 16.2613 13.0034 16.1312 13 16C13.0008 15.8684 12.9755 15.7379 12.9258 15.6161C12.876 15.4943 12.8027 15.3834 12.71 15.29C12.6128 15.2017 12.5012 15.1306 12.38 15.08C12.2285 15.0178 12.064 14.9937 11.901 15.0099C11.7381 15.0261 11.5816 15.0821 11.4453 15.1729C11.309 15.2638 11.1971 15.3867 11.1195 15.5309C11.0418 15.6751 11.0008 15.8362 11 16C11.0037 16.2648 11.1073 16.5184 11.29 16.71C11.3851 16.801 11.4972 16.8724 11.62 16.92ZM12 22C13.9778 22 15.9112 21.4135 17.5557 20.3147C19.2002 19.2159 20.4819 17.6541 21.2388 15.8268C21.9957 13.9996 22.1937 11.9889 21.8078 10.0491C21.422 8.10929 20.4696 6.32746 19.0711 4.92893C17.6725 3.53041 15.8907 2.578 13.9509 2.19215C12.0111 1.80629 10.0004 2.00433 8.17316 2.7612C6.3459 3.51808 4.78411 4.79981 3.6853 6.4443C2.58649 8.08879 2 10.0222 2 12C2 13.3132 2.25865 14.6136 2.7612 15.8268C3.26375 17.0401 4.00034 18.1425 4.92893 19.0711C5.85751 19.9997 6.9599 20.7362 8.17316 21.2388C9.38642 21.7413 10.6868 22 12 22ZM12 4C13.5822 4 15.129 4.46919 16.4446 5.34824C17.7601 6.2273 18.7855 7.47672 19.391 8.93853C19.9965 10.4003 20.155 12.0089 19.8463 13.5607C19.5376 15.1126 18.7757 16.538 17.6568 17.6569C16.538 18.7757 15.1126 19.5376 13.5607 19.8463C12.0089 20.155 10.4003 19.9965 8.93853 19.391C7.47672 18.7855 6.22729 17.7602 5.34824 16.4446C4.46919 15.129 4 13.5823 4 12C4 9.87827 4.84285 7.84344 6.34314 6.34315C7.84343 4.84285 9.87826 4 12 4Z"
                                  fill="#FFBA34"/>
                        </svg>
                    </figure>
                    Kết quả ước tính này chỉ mang tính chất tham khảo
                </span>
            </div>
            <div class="right">
                <div class="title">
                    <span>Tổng số tiền bạn cần trả</span>
                    <h3 class="loan_text">0</h3>
                </div>
                <div class="chart">
                    <span class="vtc">0%</span>
                    <span class="gct">0%</span>
                    <span class="lct">0%</span>
                </div>
                <div class="note">
                    <div class="child">
                        <div class="text">
                            <figure>
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16"
                                     fill="none">
                                    <circle cx="7.10791" cy="8.00049" r="7.10791" fill="#BC202F"/>
                                </svg>
                            </figure>
                            Vốn tự có
                        </div>
                        <p class="number von"><span>0</span> Đ</p>
                    </div>
                    <div class="child">
                        <div class="text">
                            <figure>
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16"
                                     fill="none">
                                    <circle cx="7.10791" cy="8.00049" r="7.10791" fill="#FFBA34"/>
                                </svg>
                            </figure>
                            Gốc cần trả
                        </div>
                        <p class="number goc"><span>0</span> Đ</p>
                    </div>
                    <div class="child">
                        <div class="text">
                            <figure>
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16"
                                     fill="none">
                                    <circle cx="7.10791" cy="8.00049" r="7.10791" fill="#DD1F2C"/>
                                </svg>
                            </figure>
                            Lãi cần trả
                        </div>
                        <p class="number loan"><span>0</span> Đ</p>
                    </div>
                </div>
                <div class="pay">
                    <span>Thanh toán tháng đầu</span>
                    <h4 class="pmt">0 Đ</h4>
                </div>
                <a href="javascript:;" class="finance">
                    <figure>
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                            <path d="M12.5 8.75C12.4 8.75 12.31 8.73 12.21 8.69C11.93 8.58 11.75 8.3 11.75 8V2C11.75 1.59 12.09 1.25 12.5 1.25C12.91 1.25 13.25 1.59 13.25 2V6.19L13.97 5.47C14.26 5.18 14.74 5.18 15.03 5.47C15.32 5.76 15.32 6.24 15.03 6.53L13.03 8.53C12.89 8.67 12.69 8.75 12.5 8.75Z"
                                  fill="white"/>
                            <path d="M12.4999 8.75043C12.3099 8.75043 12.1199 8.68043 11.9699 8.53043L9.96994 6.53043C9.67994 6.24043 9.67994 5.76043 9.96994 5.47043C10.2599 5.18043 10.7399 5.18043 11.0299 5.47043L13.0299 7.47043C13.3199 7.76043 13.3199 8.24043 13.0299 8.53043C12.8799 8.68043 12.6899 8.75043 12.4999 8.75043Z"
                                  fill="white"/>
                            <path d="M16.5 22.75H8.5C2.75 22.75 2.75 19.7 2.75 17V16C2.75 13.77 2.75 11.25 7.5 11.25C8.69 11.25 9.13 11.54 9.75 12C9.78 12.03 9.82 12.05 9.85 12.09L10.87 13.17C11.73 14.08 13.29 14.08 14.15 13.17L15.17 12.09C15.2 12.06 15.23 12.03 15.27 12C15.89 11.53 16.33 11.25 17.52 11.25C22.27 11.25 22.27 13.77 22.27 16V17C22.25 20.82 20.32 22.75 16.5 22.75ZM7.5 12.75C4.25 12.75 4.25 13.77 4.25 16V17C4.25 19.74 4.25 21.25 8.5 21.25H16.5C19.48 21.25 20.75 19.98 20.75 17V16C20.75 13.77 20.75 12.75 17.5 12.75C16.78 12.75 16.63 12.84 16.2 13.16L15.23 14.19C14.51 14.95 13.54 15.37 12.5 15.37C11.46 15.37 10.49 14.95 9.77 14.19L8.8 13.16C8.37 12.84 8.22 12.75 7.5 12.75Z"
                                  fill="white"/>
                            <path d="M5.5 12.7505C5.09 12.7505 4.75 12.4104 4.75 12.0005V8.00045C4.75 6.06045 4.75 3.65045 8.43 3.30045C8.84 3.26045 9.21 3.56045 9.25 3.98045C9.29 4.39045 8.99 4.76045 8.57 4.80045C6.25 5.01045 6.25 5.95045 6.25 8.00045V12.0005C6.25 12.4104 5.91 12.7505 5.5 12.7505Z"
                                  fill="white"/>
                            <path d="M19.4999 12.7502C19.0899 12.7502 18.7499 12.4102 18.7499 12.0002V8.00022C18.7499 5.95022 18.7499 5.01022 16.4299 4.79022C16.0199 4.75022 15.7199 4.38022 15.7599 3.97022C15.7999 3.56022 16.1599 3.25022 16.5799 3.30022C20.2599 3.65022 20.2599 6.06022 20.2599 8.00022V12.0002C20.2499 12.4102 19.9099 12.7502 19.4999 12.7502Z"
                                  fill="white"/>
                        </svg>
                    </figure>
                    Chi tiết kế hoạch tài chính
                </a>
            </div>
        </div>
    </div>
</section>

<section class="section-homepage-5">
    <div class="container">
        <div class="title">
            <h3><?= $kienthuc['title'] ?></h3>
            <div class="desc">
                <?= apply_filters('the_content', $kienthuc['content']) ?>
            </div>
        </div>
        <div class="content row">
            <?php foreach ($kienthuc['list'] as $value): ?>
                <div class="col-xl-4">
                    <div class="child">
                        <div class="image">
                            <figure>
                                <a href="<?= get_permalink($value->ID) ?>"><img
                                            src="<?= getimage($value->ID, 'large', 'post') ?>" alt=""></a>
                            </figure>
                        </div>
                        <div class="text">
                            <div class="name">
                                <a href="<?= get_permalink($value->ID) ?>"><?= $value->post_title ?></a>
                            </div>
                            <div class="desc">
                                <p><?= wp_trim_words(apply_filters('the_content', $value->post_content), 20) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php
get_footer();
?>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        var typingTimer;
        var doneTypingInterval = 500; // Thời gian chờ sau khi ngừng gõ, tính bằng mili giây
        $('#da-0').on('click', function () {
            // Your event handling code here
            $('.add_duan').removeClass('active');
            $('.dangmo').addClass('active');

        });
        $('#da-1').on('click', function () {
            // Your event handling code here
            $('.add_duan').removeClass('active');
            $('.bangiao').addClass('active');

        });
        $(".finance").click(function () {
            $(".popup-tv-khoan-vay").fadeIn();
            $(".overlay").fadeIn();
        });
        $('#tilevay').on('input', function () {
            var tile = $(this).val();
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function () {

                var giatri = $('#giatri').val();
                giatri = parseInt(giatri.replace(/\./g,'')); // Loại bỏ dấu chấm
                var vay = parseInt(giatri) * parseInt(tile) / 100;
                vay = vay.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Định dạng giá trị vay thành chuỗi có dấu chấm
                $('#loanvay').val(vay);
                check_loan();
            }, doneTypingInterval);
        });
        $('#company').select2({
            theme: "classic"
        });
        $('#giatri').on('input', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function () {
                // Lấy giá trị từ #giatri và chuyển đổi sang dạng số
                var gia_tri_str = $('#giatri').val();
                var gia_tri = parseFloat(gia_tri_str.replace(/\./g, '')); // Loại bỏ dấu chấm và chuyển đổi thành số thập phân
                var tile = $('#tilevay').val();
                var vay = gia_tri * tile / 100;

                // Định dạng lại giá trị vay thành chuỗi có dấu phẩy
                var formatted_vay = vay.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                // Gán giá trị vay vào #loanvay
                $('#loanvay').val(formatted_vay);

                // Gọi hàm kiểm tra vay
                check_loan();
            }, doneTypingInterval);
        });
        $('#year_pay').on('input', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function () {
                check_loan()
            }, doneTypingInterval);
        });
        $('#lai_suat_vay').on('change', function () {
            var lai_suat_vay = $(this).val();
            if (lai_suat_vay !== undefined || lai_suat_vay !== 0) {
                $('#input_lai_suat_vay').val(lai_suat_vay);
            }
            check_loan();
        })
        $('#hinhthuc').on('change', function () {
            check_loan();
        })


        function check_loan() {
            var giatri = $('#giatri').val().replace(/\./g,'');
            var tilevay = $('#tilevay').val();
            var loanvay = $('#loanvay').val().replace(/\./g,'');
            var year_pay = $('#year_pay').val();
            var input_lai_suat_vay = $('#input_lai_suat_vay').val();
            var hinhthuc = $('#hinhthuc').val();
            // Khởi tạo biến cờ
            var allValuesExist = true;

// Kiểm tra giá trị của từng biến
            if (!giatri || giatri === "0" || giatri === "") {
                allValuesExist = false;
            }
            if (!tilevay || tilevay === "0" || tilevay === "") {
                allValuesExist = false;
            }
            if (!loanvay || loanvay === "0" || loanvay === "") {
                allValuesExist = false;
            }
            if (!year_pay || year_pay === "0" || year_pay === "") {
                allValuesExist = false;
            }
            if (!input_lai_suat_vay || input_lai_suat_vay === "0" || input_lai_suat_vay === "") {
                allValuesExist = false;
            }
            if (!hinhthuc || hinhthuc === "0" || hinhthuc === "") {
                allValuesExist = false;
            }
// Kiểm tra biến cờ
            if (allValuesExist) {
                var $data = {
                    'giatri': giatri,
                    'tilevay': tilevay,
                    'loanvay': loanvay,
                    'year_pay': year_pay,
                    'input_lai_suat_vay': input_lai_suat_vay,
                    'hinhthuc': hinhthuc,
                    'action': 'loan_check'
                };
                var $param = {
                    'type': 'POST',
                    'url': ajaxurl,
                    'beforeSend': function () {
                        $("#loader").show();

                    },
                    'complete': function () {
                        $("#loader").hide();
                    },
                    'data': $data,
                    'callback': function (data) {
                        $('.add_table').html('');
                        var res = JSON.parse(data);
                        var tabale = res.data.data;
                        var html_tabale = '<table>' +
                            '<thead>' +
                            '<th>Kỳ trả nợ</th>' +
                            '<th>Số tiền lãi và gốc phải trả hàng tháng</th>' +
                            '<th>Tiền lãi</th>' +
                            '<th>Tiền gốc</th>' +
                            '<th>Dư nợ hiện tại</th>' +
                            '</thead>' +
                            '<tbody>';
                        tabale.forEach(function (e) {
                            html_tabale += '<tr>' +
                                '<td>Tháng ' + e.ky + '</td>' +
                                '<td style="text-align: center">' + formatNumberWithCommas(e.pay) + '</td>' +
                                '<td style="text-align: center">' + formatNumberWithCommas(e.tienLai) + '</td>' +
                                '<td style="text-align: center">' + formatNumberWithCommas(e.tienGoc) + '</td>' +
                                '<td style="text-align: center">' + formatNumberWithCommas((e.conLai < 10) ? 0 : e.conLai) + '</td>' +
                                '</tr>';
                        })
                        html_tabale += '</tbody></table> ';
                        $('.add_table').html(html_tabale);
                        $('.loan_text').html(res.money_pay);
                        var lona_t = parseInt(res.goc_loan) + parseInt(res.von) + parseInt(res.loan);
                        var percen_lo = (parseInt(res.goc_loan) / parseInt(lona_t)) * 100;
                        var percen_von = (parseInt(res.von) / parseInt(lona_t)) * 100;
                        var percen_lai = (parseInt(res.loan) / parseInt(lona_t)) * 100;
                        $('.vtc').html(percen_von.toFixed(2) + '%').css({
                            "width": percen_von.toFixed(2) + '%'
                        });
                        $('.gct').html(percen_lo.toFixed(2) + '%').css({
                            "width": percen_lo.toFixed(2) + '%'
                        });
                        $('.lct').html(percen_lai.toFixed(2) + '%').css({
                            "width": percen_lai.toFixed(2) + '%'
                        });
                        $('.von').html('<span>' + formatNumberWithCommas(res.von) + '</span> Đ');
                        $('.goc').html('<span>' + formatNumberWithCommas(res.goc_loan) + '</span> Đ');
                        $('.loan').html('<span>' + formatNumberWithCommas(res.loan) + '</span> Đ');
                        $('.pmt').html(formatNumberWithCommas(res.pay_month) + ' Đ');
                    }
                };

                cms_adapter_ajax($param);
            }
        }

        $('#banggia_areas').on('change', function () {
            var areass = $(this).val();
            var $data = {
                'areass': areass,
                'action': 'banggia_check'
            };
            var $param = {
                'type': 'POST',
                'url': ajaxurl,
                'beforeSend': function () {
                    $("#loader").show();

                },
                'complete': function () {
                    $("#loader").hide();
                },
                'data': $data,
                'callback': function (data) {
                    var res = JSON.parse(data);
                    if (res.status == 0) {
                        $('.body_duan').html('');
                        var table = res.data;
                        console.log(table);
                        if (table.length == 0) {
                            var html = '<tr><td colspan="2">Không có kết quả trả về</td> </tr>';
                            $('.body_duan').html(html);
                        } else {
                            var html = '';
                            table.forEach(function (e) {
                                html += '<tr>\n' +
                                    '                                    <td><a href="'+ e.url +'">' + e.post_title + '</a></td>\n' +
                                    '                                    <td><a href="'+ e.url +'">' + e.price_gia + '</a></td>\n' +
                                    '                                </tr>';
                            })
                            $('.body_duan').html(html);
                        }

                    }
                }
            };

            cms_adapter_ajax($param);
        })
        $('input[name="duan_home"]').on('change', function () {
            var selectedValue = $('input[name="duan_home"]:checked').val();
            var $data = {
                'stautus': selectedValue,
                'action': 'duan_check'
            };
            var $param = {
                'type': 'POST',
                'url': ajaxurl,
                'beforeSend': function () {
                    $("#loader").show();

                },
                'complete': function () {
                    $("#loader").hide();
                },
                'data': $data,
                'callback': function (data) {
                    var res = JSON.parse(data);
                    if (res.status == 0) {
                        $('.body_duan').html('');
                        var table = res.data;
                        console.log(table);
                        if (table.length == 0) {
                            var html = '<tr><td colspan="2">Không có kết quả trả về</td> </tr>';
                            $('.body_duan').html(html);
                        } else {
                            var html = '';
                            table.forEach(function (e) {
                                html += '<tr>\n' +
                                    '                                    <td>' + e.post_title + '</td>\n' +
                                    '                                    <td>' + e.price_gia + '</td>\n' +
                                    '                                </tr>';
                            })
                            $('.body_duan').html(html);
                        }

                    }
                }
            };

            cms_adapter_ajax($param);
        })
    })

    function formatNumberWithCommas(number) {
        if (isNaN(number)) {
            return "Invalid input";
        }
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>
<script>
    var swiper = new Swiper('.slide-image', {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        grabCursor: true,
        speed: 500,
        pagination: {
            el: '.slider-pagination',
            clickable: true,
        },
    });
    $('#da-0').on('click',function () {
        var link = '<?= get_term_link(24) ?>';
        $('.right_ss').attr('href',link);
    })
    $('#da-1').on('click',function () {
        var link = '<?= get_term_link(26) ?>';
        $('.right_ss').attr('href',link);
    })
    $('input#giatri').keyup(function(event) {
        // skip for arrow keys
        if(event.which >= 37 && event.which <= 40) return;

        // format number
        $(this).val(function(index, value) {
            // Xóa các ký tự không phải số
            value = value.replace(/\D/g, "");

            // Định dạng số với dấu chấm phân cách hàng nghìn
            return value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });
    });

</script>
