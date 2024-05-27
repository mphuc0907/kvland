<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package KV_Land
 */

get_header();
$args = array(
    'post_type' => 'post',
    'posts_per_page' => 3,
    'post__not_in' => array(get_the_ID()),
    'orderby' => 'date',
    'order' => 'desc'
);
$post_tt = new WP_Query($args);
$args = array(
    'post_type' => 'post',
    'posts_per_page' => 4,
    'orderby' => 'date',
    'order' => 'desc'
);
$post_new = new WP_Query($args);
$view = get_field('view');
$view = $view + 1;
update_field('view', $view, get_the_ID());
$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 4,
    'meta_key' => 'view', // Thay 'tên_custom_field' bằng tên thực của custom field bạn muốn sắp xếp
    'orderby' => 'meta_value_num', // Sử dụng 'meta_value_num' nếu custom field lưu giá trị là số, sử dụng 'meta_value' nếu là chuỗi
    'order' => 'DESC',
);
$hot_news = new WP_Query($args);
?>

    <section class="section-knowledgedetail-1">
        <div class="container p-10">
            <div class="breadcrumb">
                <span>
                    <a href="<?= home_url() ?>">Trang chủ</a>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M9.88712 7.52679L7.06045 4.70013C6.99847 4.63764 6.92474 4.58805 6.8435 4.5542C6.76226 4.52036 6.67512 4.50293 6.58712 4.50293C6.49911 4.50293 6.41197 4.52036 6.33073 4.5542C6.24949 4.58805 6.17576 4.63764 6.11378 4.70013C5.98962 4.82504 5.91992 4.994 5.91992 5.17013C5.91992 5.34625 5.98962 5.51522 6.11378 5.64013L8.47378 8.00013L6.11378 10.3601C5.98962 10.485 5.91992 10.654 5.91992 10.8301C5.91992 11.0063 5.98962 11.1752 6.11378 11.3001C6.17608 11.3619 6.24995 11.4108 6.33118 11.444C6.4124 11.4772 6.49938 11.494 6.58712 11.4935C6.67485 11.494 6.76183 11.4772 6.84305 11.444C6.92428 11.4108 6.99816 11.3619 7.06045 11.3001L9.88712 8.47346C9.9496 8.41149 9.9992 8.33775 10.033 8.25651C10.0669 8.17527 10.0843 8.08814 10.0843 8.00013C10.0843 7.91212 10.0669 7.82498 10.033 7.74374C9.9992 7.6625 9.9496 7.58877 9.88712 7.52679Z"
                              fill="#41464B"/>
                    </svg>
                    <a href="<?= get_permalink(get_page_by_path('kien-thuc')) ?>"><?= get_the_title(get_page_by_path('kien-thuc')) ?></a>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M9.88712 7.52679L7.06045 4.70013C6.99847 4.63764 6.92474 4.58805 6.8435 4.5542C6.76226 4.52036 6.67512 4.50293 6.58712 4.50293C6.49911 4.50293 6.41197 4.52036 6.33073 4.5542C6.24949 4.58805 6.17576 4.63764 6.11378 4.70013C5.98962 4.82504 5.91992 4.994 5.91992 5.17013C5.91992 5.34625 5.98962 5.51522 6.11378 5.64013L8.47378 8.00013L6.11378 10.3601C5.98962 10.485 5.91992 10.654 5.91992 10.8301C5.91992 11.0063 5.98962 11.1752 6.11378 11.3001C6.17608 11.3619 6.24995 11.4108 6.33118 11.444C6.4124 11.4772 6.49938 11.494 6.58712 11.4935C6.67485 11.494 6.76183 11.4772 6.84305 11.444C6.92428 11.4108 6.99816 11.3619 7.06045 11.3001L9.88712 8.47346C9.9496 8.41149 9.9992 8.33775 10.033 8.25651C10.0669 8.17527 10.0843 8.08814 10.0843 8.00013C10.0843 7.91212 10.0669 7.82498 10.033 7.74374C9.9992 7.6625 9.9496 7.58877 9.88712 7.52679Z"
                              fill="#41464B"/>
                    </svg>
                    <a href="javascript:;"><p><?= get_the_title() ?></p></a>
                </span>
            </div>
        </div>
    </section>
    <section class="section-knowledgedetail-2">
        <div class="container p-10">
            <div class="content">
                <div class="row row-0">
                    <div class="col-lg-8 p-10 col-left">
                        <div class="detail">
                            <?php if (getimage(get_the_ID(), 'large', 'post') != home_url().'/wp-content/uploads/2024/04/no-image.jpg'): ?>
                                <div class="thumbnail">
                                    <figure>
                                        <img src="<?= getimage(get_the_ID(), 'large', 'post') ?>" alt="images">
                                    </figure>
                                </div>
                            <?php endif; ?>
                            <div class="list-option">
                                <div class="time">
                                    <p><?= get_the_date('d/m/Y') ?></p>
                                    <!--                                    <span>-->
                                    <!--                                        <svg xmlns="http://www.w3.org/2000/svg" width="4" height="4" viewBox="0 0 4 4" fill="none">-->
                                    <!--                                            <circle cx="2" cy="2" r="2" fill="#899197"/>-->
                                    <!--                                        </svg>-->
                                    <!--                                    </span>-->

                                </div>
                                                                <div class="view">
                                                                    <span>
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                             viewBox="0 0 24 24" fill="none">
                                                                            <path d="M11.9999 16.3299C9.60992 16.3299 7.66992 14.3899 7.66992 11.9999C7.66992 9.60992 9.60992 7.66992 11.9999 7.66992C14.3899 7.66992 16.3299 9.60992 16.3299 11.9999C16.3299 14.3899 14.3899 16.3299 11.9999 16.3299ZM11.9999 9.16992C10.4399 9.16992 9.16992 10.4399 9.16992 11.9999C9.16992 13.5599 10.4399 14.8299 11.9999 14.8299C13.5599 14.8299 14.8299 13.5599 14.8299 11.9999C14.8299 10.4399 13.5599 9.16992 11.9999 9.16992Z"
                                                                                  fill="#A11D25"/>
                                                                            <path d="M12.0001 21.0205C8.24008 21.0205 4.69008 18.8205 2.25008 15.0005C1.19008 13.3505 1.19008 10.6605 2.25008 9.00047C4.70008 5.18047 8.25008 2.98047 12.0001 2.98047C15.7501 2.98047 19.3001 5.18047 21.7401 9.00047C22.8001 10.6505 22.8001 13.3405 21.7401 15.0005C19.3001 18.8205 15.7501 21.0205 12.0001 21.0205ZM12.0001 4.48047C8.77008 4.48047 5.68008 6.42047 3.52008 9.81047C2.77008 10.9805 2.77008 13.0205 3.52008 14.1905C5.68008 17.5805 8.77008 19.5205 12.0001 19.5205C15.2301 19.5205 18.3201 17.5805 20.4801 14.1905C21.2301 13.0205 21.2301 10.9805 20.4801 9.81047C18.3201 6.42047 15.2301 4.48047 12.0001 4.48047Z"
                                                                                  fill="#A11D25"/>
                                                                        </svg>
                                                                        <?= get_field('view') ?> lượt xem
                                                                    </span>
<!--                                                                    <span>-->
<!--                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"-->
<!--                                                                             viewBox="0 0 24 24" fill="none">-->
<!--                                                                            <path fill-rule="evenodd" clip-rule="evenodd"-->
<!--                                                                                  d="M16.5 2.25C14.7051 2.25 13.25 3.70507 13.25 5.5C13.25 5.69591 13.2673 5.88776 13.3006 6.07412L8.56991 9.38558C8.54587 9.4024 8.52312 9.42038 8.50168 9.43939C7.94993 9.00747 7.25503 8.75 6.5 8.75C4.70507 8.75 3.25 10.2051 3.25 12C3.25 13.7949 4.70507 15.25 6.5 15.25C7.25503 15.25 7.94993 14.9925 8.50168 14.5606C8.52312 14.5796 8.54587 14.5976 8.56991 14.6144L13.3006 17.9259C13.2673 18.1122 13.25 18.3041 13.25 18.5C13.25 20.2949 14.7051 21.75 16.5 21.75C18.2949 21.75 19.75 20.2949 19.75 18.5C19.75 16.7051 18.2949 15.25 16.5 15.25C15.4472 15.25 14.5113 15.7506 13.9174 16.5267L9.43806 13.3911C9.63809 12.9694 9.75 12.4978 9.75 12C9.75 11.5022 9.63809 11.0306 9.43806 10.6089L13.9174 7.4733C14.5113 8.24942 15.4472 8.75 16.5 8.75C18.2949 8.75 19.75 7.29493 19.75 5.5C19.75 3.70507 18.2949 2.25 16.5 2.25ZM14.75 5.5C14.75 4.5335 15.5335 3.75 16.5 3.75C17.4665 3.75 18.25 4.5335 18.25 5.5C18.25 6.4665 17.4665 7.25 16.5 7.25C15.5335 7.25 14.75 6.4665 14.75 5.5ZM6.5 10.25C5.5335 10.25 4.75 11.0335 4.75 12C4.75 12.9665 5.5335 13.75 6.5 13.75C7.4665 13.75 8.25 12.9665 8.25 12C8.25 11.0335 7.4665 10.25 6.5 10.25ZM16.5 16.75C15.5335 16.75 14.75 17.5335 14.75 18.5C14.75 19.4665 15.5335 20.25 16.5 20.25C17.4665 20.25 18.25 19.4665 18.25 18.5C18.25 17.5335 17.4665 16.75 16.5 16.75Z"-->
<!--                                                                                  fill="#A11D25"/>-->
<!--                                                                        </svg>-->
<!--                                                                        5 lượt chia sẻ-->
<!--                                                                    </span>-->
                                                                </div>
                            </div>
                            <div class="content-text">
                                <div class="title">
                                    <h2><?= get_the_title() ?></h2>
                                </div>
                                <?php the_content() ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 p-10 col-right">
                        <div class="option">
                            <h2>Chia sẻ bài viết</h2>
                            <div class="share">
                                <?= do_shortcode('[Sassy_Social_Share]') ?>
                            </div>
                        </div>
                        <div class="list-knowledge">
                            <div class="text">
                                <h2>Nổi bật</h2>
                            </div>
                            <div class="list">
                                <?php if ($hot_news->have_posts()): ?>
                                    <?php while ($hot_news->have_posts()): $hot_news->the_post();
                                        ?>
                                        <div class="child">
                                            <a href="<?= get_permalink(); ?>">
                                                <div class="title">
                                                    <h3><?= get_the_title() ?></h3>
                                                </div>
                                                <div class="time">
                                                    <p><?= get_the_date('d/m/Y'); ?></p>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                                <?php wp_reset_postdata(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-knowledgedetail-3">
        <div class="container p-10">
            <div class="content">
                <div class="list-knowledge">
                    <div class="title">
                        <h2>Bài viết liên quan</h2>
                    </div>
                    <?php if ($post_tt->have_posts()): ?>
                        <div class="row row-10">
                            <?php while ($post_tt->have_posts()) :
                                $post_tt->the_post();
                                ?>
                                <div class="col-sm-4 col-lg-4 col-item">
                                    <div class="image">
                                        <figure><img src="<?= getimage(get_the_ID(), 'large', 'post') ?>"
                                                     alt="images"></figure>
                                    </div>
                                    <div class="text">
                                        <div class="name">
                                            <a href="<?= get_permalink() ?>"><?= get_the_title() ?></a>
                                        </div>
                                        <div class="desc">
                                            <?php the_excerpt() ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif;
                    wp_reset_postdata(); ?>
                </div>
            </div>

        </div>
    </section>

<?php

get_footer();
