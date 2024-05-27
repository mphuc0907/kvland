<?php
/* Template Name: Kiến thức */
get_header();

$args = array(
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => 4,
    'meta_key' => 'view', // Thay 'tên_custom_field' bằng tên thực của custom field bạn muốn sắp xếp
    'orderby' => 'meta_value_num', // Sử dụng 'meta_value_num' nếu custom field lưu giá trị là số, sử dụng 'meta_value' nếu là chuỗi
    'order' => 'DESC',
);
$hot_news = new WP_Query($args);
$args = array(
    'post_type' => 'tuyen_dung',
    'posts_per_page' => get_option('posts_per_page'),
    'paged' => max(1, get_query_var('paged')),
    'tax_query' => array(
        'relation' => 'AND',
    ),
    'orderby' => 'date', // hoặc thay đổi thành trường bạn muốn sắp xếp
    'order' => 'asc'
);
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_type' => 'post',
    'posts_per_page' => get_option('posts_per_page'),
    'paged' => $paged,
    'orderby' => 'date',
    'order' => 'desc'
);
$post_s = new WP_Query($args);
?>
    <section class="section-knowledge-1">
        <div class="container p-10">
            <div class="content">
                <div class="breadcrumb">
                    <div class="home">
                        <a href="<?= home_url() ?>">Trang chủ</a>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M9.88712 7.52679L7.06045 4.70013C6.99847 4.63764 6.92474 4.58805 6.8435 4.5542C6.76226 4.52036 6.67512 4.50293 6.58712 4.50293C6.49911 4.50293 6.41197 4.52036 6.33073 4.5542C6.24949 4.58805 6.17576 4.63764 6.11378 4.70013C5.98962 4.82504 5.91992 4.994 5.91992 5.17013C5.91992 5.34625 5.98962 5.51522 6.11378 5.64013L8.47378 8.00013L6.11378 10.3601C5.98962 10.485 5.91992 10.654 5.91992 10.8301C5.91992 11.0063 5.98962 11.1752 6.11378 11.3001C6.17608 11.3619 6.24995 11.4108 6.33118 11.444C6.4124 11.4772 6.49938 11.494 6.58712 11.4935C6.67485 11.494 6.76183 11.4772 6.84305 11.444C6.92428 11.4108 6.99816 11.3619 7.06045 11.3001L9.88712 8.47346C9.9496 8.41149 9.9992 8.33775 10.033 8.25651C10.0669 8.17527 10.0843 8.08814 10.0843 8.00013C10.0843 7.91212 10.0669 7.82498 10.033 7.74374C9.9992 7.6625 9.9496 7.58877 9.88712 7.52679Z"
                              fill="#41464B"/>
                    </svg>
                    <div class="page">
                        <a href="javascript:;"><?= get_the_title() ?></a>
                    </div>
                </div>
                <div class="title">
                    <h2><?= get_the_title() ?></h2>
                </div>
            </div>
        </div>
    </section>
    <section class="section-knowledge-2">
        <div class="container p-10">
            <div class="content">
                <div class="row row-0">
                    <?php if ($hot_news->have_posts()):
                        $hot_news->the_post();
                        ?>
                        <div class="col-lg-6 left">
                            <div class="main">
                                <div class="image">
                                    <figure>
                                        <a href="<?= get_permalink() ?>"> <img
                                                    src="<?= getimage(get_the_ID(), 'large', 'post') ?>"
                                                    alt=""></a>
                                    </figure>
                                </div>
                                <div class="text">
                                    <div class="title">
                                        <a href="<?= get_permalink() ?>"><?= get_the_title() ?></a>
                                    </div>
                                    <div class="desc">
                                        <p><?= wp_trim_words(apply_filters('the_content', get_the_content('', false, get_the_ID())), 20) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 right">
                            <div class="list">
                                <?php while ($hot_news->have_posts()) :
                                    $hot_news->the_post(); ?>
                                    <div class="item">
                                        <div class="image">
                                            <figure>
                                                <a href="<?= get_permalink() ?>"> <img
                                                            src="<?= getimage(get_the_ID(), 'large', 'post') ?>"
                                                            alt=""></a>
                                            </figure>
                                        </div>
                                        <div class="text">
                                            <div class="title">
                                                <a href="<?= get_permalink() ?>"><?= get_the_title() ?></a>
                                            </div>
                                            <div class="desc">
                                                <p><?= wp_trim_words(apply_filters('the_content', get_the_content('', false, get_the_ID())), 20) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    <?php endif;
                    wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </section>
    <section class="section-knowledge-3">
        <div class="container p-10">
            <div class="content">
                <?php if ($post_s->have_posts()): ?>

                    <div class="row row-0">
                        <?php while ($post_s->have_posts()) :
                            $post_s->the_post(); ?>
                            <div class="col-sm-6 col-lg-4 p-10 col-item">
                                <div class="child">
                                    <div class="image">
                                        <figure>
                                            <a href="<?= get_permalink() ?>"> <img
                                                        src="<?= getimage(get_the_ID(), 'large', 'post') ?>"
                                                        alt=""></a>
                                        </figure>
                                    </div>
                                    <div class="text">
                                        <div class="title">
                                            <a href="<?= get_permalink() ?>"><?= get_the_title() ?></a>
                                        </div>
                                        <div class="desc">
                                            <p><?= wp_trim_words(apply_filters('the_content', get_the_content('', false, get_the_ID())), 20) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif;
                wp_reset_postdata(); ?>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <?php echo paginate_links(array(
                            'base' => add_query_arg('paged', '%#%'),
                            'format' => '&paged=%#%',
                            'current' => $paged,
                            'total' => $post_s->max_num_pages,
                            'prev_text' => __('<i class="fa fa-chevron-left" aria-hidden="true"></i>'),
                            'next_text' => __('<i class="fa fa-chevron-right" aria-hidden="true"></i>'),
                        )); ?>
                        <?php wp_reset_query(); ?>
                    </ul>
                </nav>
            </div>
        </div>

    </section>

<?php
get_footer();