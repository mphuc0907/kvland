<?php
/* Template Name: Giới thiệu */
get_header();
$mission = get_field('mission');
$loiich = get_field('loiich');
$tiendo = get_field('tiendo');
$cauhoi = get_field('cauhoi');
$info_contact = get_field('info_contact');
?>

<section class="section-about-1">
    <div class="content">
        <div class="col-left">
            <div class="image">
                <figure>
                    <img src="<?= getimage(get_the_ID(), 'large', 'post') ?>" alt="">
                </figure>
            </div>
        </div>
        <div class="col-right">
            <div class="text">
                <div class="breakcum">
                    <a href="<?= home_url() ?>">Trang chủ </a>
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M9.88663 7.52679L7.05996 4.70013C6.99799 4.63764 6.92425 4.58805 6.84301 4.5542C6.76177 4.52036 6.67464 4.50293 6.58663 4.50293C6.49862 4.50293 6.41148 4.52036 6.33024 4.5542C6.249 4.58805 6.17527 4.63764 6.1133 4.70013C5.98913 4.82504 5.91943 4.994 5.91943 5.17013C5.91943 5.34625 5.98913 5.51522 6.1133 5.64013L8.47329 8.00013L6.1133 10.3601C5.98913 10.485 5.91943 10.654 5.91943 10.8301C5.91943 11.0063 5.98913 11.1752 6.1133 11.3001C6.17559 11.3619 6.24947 11.4108 6.33069 11.444C6.41192 11.4772 6.49889 11.494 6.58663 11.4935C6.67437 11.494 6.76134 11.4772 6.84257 11.444C6.92379 11.4108 6.99767 11.3619 7.05996 11.3001L9.88663 8.47346C9.94911 8.41149 9.99871 8.33775 10.0326 8.25651C10.0664 8.17527 10.0838 8.08814 10.0838 8.00013C10.0838 7.91212 10.0664 7.82498 10.0326 7.74374C9.99871 7.6625 9.94911 7.58877 9.88663 7.52679Z"
                                  fill="#41464B"/>
                        </svg>
                    </span>
                    <span><?= get_the_title() ?></span>
                </div>
                <div class="title">
                    <h2><?= get_the_title() ?></h2>
                </div>
                <div class="desc">
                    <?php the_content() ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-about-2">
    <div class="content">
        <?php foreach ($mission as $value): ?>
            <div class="child">
                <div class="image">
                    <figure>
                        <img src="<?= getimage($value['background']) ?>" alt="">
                    </figure>
                </div>
                <div class="text">
                    <div class="icon">
                        <figure>
                            <img src="<?= getimage($value['icon']) ?>" style="width: 64px;height: 64px;" alt="">
                        </figure>
                    </div>
                    <div class="name">
                        <h4><?= $value['title'] ?></h4>
                    </div>
                    <div class="desc">
                        <?= apply_filters('the_content', $value['content']); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="section-about-3">
    <div class="container">
        <div class="title">
            <h2><?= $loiich['title'] ?></h2>
            <div class="desc">
                <?= apply_filters('the_content', $loiich['content']); ?>
            </div>
        </div>
        <div class="content row">
            <?php foreach ($loiich['list'] as $value): ?>
                <div class="col-xl-4">
                    <div class="child">
                        <div class="name">
                            <h4><?= $value['title'] ?></h4>
                        </div>
                        <div class="desc">
                            <?= apply_filters('the_content', $value['content']); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section-about-4">
    <div class="container">
        <div class="content row">
            <div class="col-xl-4">
                <div class="col-left">
                    <div class="title">
                        <h3><?= $tiendo['title'] ?></h3>
                    </div>
                    <div class="desc">
                        <?= apply_filters('the_content', $tiendo['content']) ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="col-right">
                    <div class="list row">
                        <?php foreach ($tiendo['list'] as $value): ?>
                            <div class="col-6">
                                <div class="child">
                                    <div class="image">
                                        <figure>
                                            <img src="<?= getimage($value['img']) ?>" alt="">
                                        </figure>
                                    </div>
                                    <div class="text">
                                        <span>01.</span>
                                        <div class="name">
                                            <a href="javascript:;"><?= $value['content'] ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-about-5" style="background: url('<?= getimage($cauhoi['background'],'full_size') ?> ') no-repeat">
    <div class="content">
        <div class="title">
            <h2><?= $cauhoi['title'] ?></h2>
            <div class="desc">
                <?= apply_filters('the_content', $cauhoi['content']) ?>
            </div>
        </div>
        <div class="slide-faq swiper">
            <div class="swiper-wrapper">
                <?php foreach ($cauhoi['list'] as $value): ?>
                    <div class="child swiper-slide">
                        <div class="name">
                            <a href="javascript:;"><?= $value['title'] ?></a>
                        </div>
                        <div class="desc">
                            <?= apply_filters('the_content', $value['content']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (count($cauhoi['list']) > 3): ?>
                <div class="slider-controls">
                    <div class="slider-pagination"></div>
                    <div class="slider-button-next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M8.91009 20.6695C8.72009 20.6695 8.53009 20.5995 8.38009 20.4495C8.09009 20.1595 8.09009 19.6795 8.38009 19.3895L14.9001 12.8695C15.3801 12.3895 15.3801 11.6095 14.9001 11.1295L8.3801 4.60953C8.0901 4.31953 8.0901 3.83953 8.3801 3.54953C8.6701 3.25953 9.1501 3.25953 9.4401 3.54953L15.9601 10.0695C16.4701 10.5795 16.7601 11.2695 16.7601 11.9995C16.7601 12.7295 16.4801 13.4195 15.9601 13.9295L9.44009 20.4495C9.29009 20.5895 9.10009 20.6695 8.91009 20.6695Z"
                                  fill="white"/>
                        </svg>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section-about-6">
    <div class="container">
        <div class="content row">
            <div class="col-xl-6">
                <div class="col-left">
                    <div class="title">
                        <h2>Liên hệ với chúng tôi nếu bạn có thêm câu hỏi</h2>
                    </div>
                    <?= do_shortcode('[contact-form-7 id="274" title="Form liên hệ"]') ?>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="col-right">
                    <div class="title">
                        <h2><?= $info_contact['title'] ?></h2>
                    </div>
                    <div class="method-contact">
                        <?php  foreach ($info_contact['info'] as $value):  ?>
                        <div class="child">
                            <figure>
                                <img src="<?= getimage($value['icon']) ?>" style="width: 20px;height: 20px;" alt="">
                            </figure>
                            <div class="text">
                                <span><?= $value['title'] ?></span>
                                <h4><?= $value['content'] ?></h4>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="map">
                        <figure>
                            <?= $info_contact['map_embed'] ?>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>

<script>
    var swiper = new Swiper('.slide-faq', {
        slidesPerView: "auto",
        spaceBetween: 20,
        grabCursor: true,
        speed: 500,
        loop: true,
        pagination: {
            el: '.slider-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.slider-button-next',
        },
    });
</script>