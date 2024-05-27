<?php
/* Template Name: FAQ */

get_header();
$list = get_field('list');
?>
    <section class="section-faq-1">
        <div class="container">
            <div class="content">
                <div class="breadcrumb">
                    <div class="home">
                        <a href="<?= home_url() ?>">Trang chủ</a>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M9.88712 7.52679L7.06045 4.70013C6.99847 4.63764 6.92474 4.58805 6.8435 4.5542C6.76226 4.52036 6.67512 4.50293 6.58712 4.50293C6.49911 4.50293 6.41197 4.52036 6.33073 4.5542C6.24949 4.58805 6.17576 4.63764 6.11378 4.70013C5.98962 4.82504 5.91992 4.994 5.91992 5.17013C5.91992 5.34625 5.98962 5.51522 6.11378 5.64013L8.47378 8.00013L6.11378 10.3601C5.98962 10.485 5.91992 10.654 5.91992 10.8301C5.91992 11.0063 5.98962 11.1752 6.11378 11.3001C6.17608 11.3619 6.24995 11.4108 6.33118 11.444C6.4124 11.4772 6.49938 11.494 6.58712 11.4935C6.67485 11.494 6.76183 11.4772 6.84305 11.444C6.92428 11.4108 6.99816 11.3619 7.06045 11.3001L9.88712 8.47346C9.9496 8.41149 9.9992 8.33775 10.033 8.25651C10.0669 8.17527 10.0843 8.08814 10.0843 8.00013C10.0843 7.91212 10.0669 7.82498 10.033 7.74374C9.9992 7.6625 9.9496 7.58877 9.88712 7.52679Z" fill="#41464B"/>
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
    <section class="section-faq-2">
        <div class="container">
            <div class="content row">
                <div class="col-lg-6 col-left">
                    <ul class="item-faq">
                        <?php foreach ($list as $value): ?>
                        <li>
                            <div class="title-tab">
                                <p><?= $value['title'] ?></p>
                                <figure><span class="icon"></span></figure>
                            </div>
                            <div class="content-tab">
                                <?= $value['content'] ?>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-lg-6 col-right">
                    <div class="title">
                        <h2>Liên hệ với chúng tôi nếu bạn có thêm câu hỏi</h2>
                    </div>
                  <?= do_shortcode('[contact-form-7 id="49278" title="câu hỏi thường gặp"]') ?>
                </div>
            </div>
        </div>
    </section>
<?php
get_footer();?>

<script>
    $(document).ready(function() {
        (function($) {
            $('.item-faq .title-tab').click(function(j) {
                var dropDown = $(this).closest('li').find('.content-tab');

                // Toggle the 'show' class for the clicked title-tab
                $(this).toggleClass('show');

                // Toggle the visibility of the corresponding content-tab
                dropDown.stop(false, true).slideToggle();

                j.preventDefault();
            });
        })(jQuery);
    });
</script>