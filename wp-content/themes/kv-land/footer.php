<div class="popup-tv p-tv">
    <div class="content">
        <div class="title">
            <h2>TƯ VẤN CHO TÔI</h2>
        </div>
        <?= do_shortcode('[contact-form-7 id="232" title="Form tư vấn"]') ?>
        <div class="close-popup">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                <path d="M14.9993 29.3337C7.09268 29.3337 0.666016 22.907 0.666016 15.0003C0.666016 7.09366 7.09268 0.666992 14.9993 0.666992C22.906 0.666992 29.3327 7.09366 29.3327 15.0003C29.3327 22.907 22.906 29.3337 14.9993 29.3337ZM14.9993 2.66699C8.19935 2.66699 2.66602 8.20033 2.66602 15.0003C2.66602 21.8003 8.19935 27.3337 14.9993 27.3337C21.7994 27.3337 27.3327 21.8003 27.3327 15.0003C27.3327 8.20033 21.7994 2.66699 14.9993 2.66699Z"
                      fill="white"/>
                <path d="M11.226 19.7737C10.9727 19.7737 10.7194 19.6803 10.5194 19.4803C10.1327 19.0937 10.1327 18.4537 10.5194 18.067L18.066 10.5203C18.4527 10.1337 19.0927 10.1337 19.4794 10.5203C19.866 10.907 19.866 11.547 19.4794 11.9337L11.9327 19.4803C11.746 19.6803 11.4793 19.7737 11.226 19.7737Z"
                      fill="white"/>
                <path d="M18.7727 19.7737C18.5193 19.7737 18.266 19.6803 18.066 19.4803L10.5194 11.9337C10.1327 11.547 10.1327 10.907 10.5194 10.5203C10.906 10.1337 11.546 10.1337 11.9327 10.5203L19.4794 18.067C19.866 18.4537 19.866 19.0937 19.4794 19.4803C19.2794 19.6803 19.026 19.7737 18.7727 19.7737Z"
                      fill="white"/>
            </svg>
        </div>
    </div>
</div>
<div class="popup-tv popup-tv-khoan-vay">
    <div class="content">
        <div class="title">
            <h2>Chi tiết kế hoạch tài chính</h2>
        </div>
        <div class="add_table ">

        </div>
        <div class="close-popup">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                <path d="M14.9993 29.3337C7.09268 29.3337 0.666016 22.907 0.666016 15.0003C0.666016 7.09366 7.09268 0.666992 14.9993 0.666992C22.906 0.666992 29.3327 7.09366 29.3327 15.0003C29.3327 22.907 22.906 29.3337 14.9993 29.3337ZM14.9993 2.66699C8.19935 2.66699 2.66602 8.20033 2.66602 15.0003C2.66602 21.8003 8.19935 27.3337 14.9993 27.3337C21.7994 27.3337 27.3327 21.8003 27.3327 15.0003C27.3327 8.20033 21.7994 2.66699 14.9993 2.66699Z"
                      fill="white"/>
                <path d="M11.226 19.7737C10.9727 19.7737 10.7194 19.6803 10.5194 19.4803C10.1327 19.0937 10.1327 18.4537 10.5194 18.067L18.066 10.5203C18.4527 10.1337 19.0927 10.1337 19.4794 10.5203C19.866 10.907 19.866 11.547 19.4794 11.9337L11.9327 19.4803C11.746 19.6803 11.4793 19.7737 11.226 19.7737Z"
                      fill="white"/>
                <path d="M18.7727 19.7737C18.5193 19.7737 18.266 19.6803 18.066 19.4803L10.5194 11.9337C10.1327 11.547 10.1327 10.907 10.5194 10.5203C10.906 10.1337 11.546 10.1337 11.9327 10.5203L19.4794 18.067C19.866 18.4537 19.866 19.0937 19.4794 19.4803C19.2794 19.6803 19.026 19.7737 18.7727 19.7737Z"
                      fill="white"/>
            </svg>
        </div>
    </div>
</div>
<div class="overlay"></div>
</main>
<footer>
    <div class="footer-wrapper">
        <div class="option-1">
            <div class="container">
                <div class="content row">
                    <div class="col-xl-7">
                        <div class="col-left">
                            <div class="logo">
                                <a href="<?= home_url() ?>">
                                    <figure>
                                        <img src="<?= getimage(get_field('logo_footer', 'option')) ?>" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="desc">
                                <?= get_field('mota_footer', 'option') ?>
                            </div>
                            <?php $info = get_field('info', 'option') ?>
                            <div class="method-contact">
                                <?php foreach ($info as $value): ?>
                                    <div class="child">
                                        <figure>
                                            <img src="<?= getimage($value['icon']) ?>" style="width: 20px;height: 20px;"
                                                 alt="">
                                        </figure>
                                        <div class="text">
                                            <span><?= $value['title'] ?></span>
                                            <h4><?= $value['content'] ?></h4>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="col-right">
                            <h4>Newsletter</h4>
                            <div class="desc">
                                <p>Trở thành người đầu tiên nhận được các thông tin mới và thông tin khuyến mại</p>
                            </div>
                            <?= do_shortcode('[contact-form-7 id="49291" title="Đăng ký"]') ?>
                            <?php $connect_net = get_field('connect_net', 'option') ?>
                            <div class="social">
                                <?php foreach ($connect_net as $value): ?>
                                    <a href="<?= $value['links'] ?>">
                                        <figure>
                                            <img src="<?= getimage($value['icon']) ?>" alt="">
                                        </figure>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="option-2">
            <div class="container">
                <div class="content">
                    <nav class="menu-f">
                        <ul>
                            <?php $elMenu = wp_get_nav_menu_items('Menu Footer');
                            foreach ($elMenu as $value):
                                ?>
                                <li><a href="<?= $value->url ?>"><?= $value->title ?></a></li>
                            <?php endforeach; ?>

                        </ul>
                    </nav>
                    <div class="copyright">
                        <span>© 2000-2023, All Rights Reserved</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script type="text/javascript" src="<?= get_template_directory_uri() ?>/dist/lib/jquery/jquery.min.js"></script>
<script type="text/javascript"
        src="<?= get_template_directory_uri() ?>/dist/lib/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript"
        src="<?= get_template_directory_uri() ?>/dist/lib/fancybox/jquery.fancybox.min.js"></script>
<script type="text/javascript" src="<?= get_template_directory_uri() ?>/dist/lib/beerslider/beerslider.js"></script>
<script type="text/javascript" src="<?= get_template_directory_uri() ?>/dist/lib/swiper/swiper-bundle.min.js"></script>
<script type="text/javascript" src="<?= get_template_directory_uri() ?>/dist/lib/slick/slick.min.js"></script>
<script type="text/javascript" src="<?= get_template_directory_uri() ?>/dist/js/aos.js"></script>
<script type="text/javascript" src="<?= get_template_directory_uri() ?>/dist/js/custom.js"></script>
</body>
</html>
<?php wp_footer(); ?>
<script>
    $('.search').on('click', function () {
        $('#namess').focus().addClass('highlight'); // Thêm class 'highlight' để thêm border
        setTimeout(function() {
            $('#namess').removeClass('highlight'); // Xóa class 'highlight' sau 1 giây
        }, 500); // 1000ms = 1 giây
    })
</script>
