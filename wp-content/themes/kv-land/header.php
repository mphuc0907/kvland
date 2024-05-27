<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= getimage(get_field("fav_icon", "option")) ?>" type="image/x-icon"/>
    <?php wp_head() ?>

    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="author" content=""/>
    <meta property="og:title" content=""/>
    <meta property="og:description" content=""/>
    <meta property="og:url" content=""/>
    <link rel="shortcut icon" href="#" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css"
          href="<?= get_template_directory_uri() ?>/dist/lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="<?= get_template_directory_uri() ?>/dist/lib/fancybox/jquery.fancybox.min.css">
    <link rel="stylesheet" type="text/css"
          href="<?= get_template_directory_uri() ?>/dist/lib/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="<?= get_template_directory_uri() ?>/dist/lib/slick/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="<?= get_template_directory_uri() ?>/dist/lib/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="<?= get_template_directory_uri() ?>/dist/assets/scss/aos.css">
    <link rel="stylesheet" type="text/css" href="<?= get_template_directory_uri() ?>/dist/assets/scss/custom.css">
    <link rel="stylesheet" type="text/css" href="<?= get_template_directory_uri() ?>/dist/assets/select2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">

</head>
<body>
<?php
$elMenu = wp_get_nav_menu_items('Menu Header');
$menu1 = array();
$menu = array();
foreach ($elMenu as $value) {

    $menu1[] = (array)$value;
}
foreach ($menu1 as $element) {
    if (!array_search($element['ID'], array_column($menu1, 'menu_item_parent'))) {
        $element['dem'] = 0;
    } else {
        $element['dem'] = 1;
    }
    $menu[] = (array)$element;
}
$url_check = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$ke = strpos($url_check, 'page');
//print_r($ke);die();
if (!empty($ke)) {
    $url_check = substr($url_check, 0, $ke);
}
?>
<style>
    .highlight {
        border: 1px solid green!important; /* Thay đổi màu và độ dày border tùy ý */
    }
</style>
<header>
    <div class="header-wrapper">
        <div class="content">
            <div class="left">
                <div class="logo">
                    <a href="<?= home_url() ?>">
                        <figure>
                            <img src="<?= getimage(get_field('logo_header', 'option')) ?>" alt="">
                        </figure>
                    </a>
                </div>
            </div>
            <div class="right">
                <nav class="menu">
                    <ul>
                        <?php foreach ($menu as $value) :
                            if ($value['menu_item_parent'] == 0) :
                                ?>
                                <li class="sub-menu <?= ($value['url'] == $url_check) ? 'active' : '' ?>  <?= ($value['classes'][0] == $_SESSION['active'] && $_SESSION['active'] != '') ? 'active' : '' ?>">
                                    <a href="<?= $value['url'] ?>">
                                        <span><?= $value['title'] ?></span>
                                    </a>
                                    <?php if ($value['dem'] == 1) : ?>
                                        <div class="menudropdown">
                                            <ul>
                                                <?php foreach ($menu as $item): ?>
                                                    <?php if ($item['menu_item_parent'] == $value['ID']) : ?>
                                                        <li>
                                                            <a href="<?= $item['url'] ?>"><?= $item['title'] ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </li>
                            <?php endif;
                        endforeach;
                        ?>
                    </ul>
                    <div class="close-menu">
                        <i class="far fa-times"></i>
                    </div>
                </nav>
                <div class="action">
                    <div class="hotline">
                        <a href="tel:<?= get_field('hotline_header', 'option') ?>">
                            <figure>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <path d="M2.67568 5.3624C3.3018 4.69223 4.32778 3.66779 5.17214 2.83517C5.95381 2.06437 7.21006 2.07945 7.98062 2.86136L9.93802 4.84762C10.5184 5.43658 10.496 6.37193 9.96577 7.00642C8.35895 8.92912 8.65646 10.1294 11.2684 12.7413C13.8827 15.3556 15.0467 15.6152 16.9694 14.0004C17.6005 13.4704 18.5328 13.451 19.1198 14.0295L21.1387 16.0194C21.9211 16.7905 21.9356 18.0477 21.1639 18.8295C20.3331 19.6713 19.3114 20.6944 18.6389 21.3256C14.5753 25.1405 -1.12983 9.43566 2.67568 5.3624Z"
                                          stroke="white" stroke-width="2"/>
                                </svg>
                            </figure>
                            <?= get_field('hotline_header', 'option') ?>
                        </a>
                    </div>
                    <div class="search">
                        <div class="search-toggle">
                            <figure>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                                     fill="none">
                                    <path d="M8.58317 17.1253C3.87484 17.1253 0.0415039 13.292 0.0415039 8.58366C0.0415039 3.87532 3.87484 0.0419922 8.58317 0.0419922C13.2915 0.0419922 17.1248 3.87532 17.1248 8.58366C17.1248 13.292 13.2915 17.1253 8.58317 17.1253ZM8.58317 1.29199C4.55817 1.29199 1.2915 4.56699 1.2915 8.58366C1.2915 12.6003 4.55817 15.8753 8.58317 15.8753C12.6082 15.8753 15.8748 12.6003 15.8748 8.58366C15.8748 4.56699 12.6082 1.29199 8.58317 1.29199Z"
                                          fill="#292D32"/>
                                    <path d="M17.3332 17.9587C17.1748 17.9587 17.0165 17.9003 16.8915 17.7753L15.2248 16.1087C14.9832 15.867 14.9832 15.467 15.2248 15.2253C15.4665 14.9837 15.8665 14.9837 16.1082 15.2253L17.7748 16.892C18.0165 17.1337 18.0165 17.5337 17.7748 17.7753C17.6498 17.9003 17.4915 17.9587 17.3332 17.9587Z"
                                          fill="#292D32"/>
                                </svg>
                            </figure>
                            <div class="text">
                                <span>Tìm kiếm </span>
                                <p>bất động sản</p>
                            </div>
                        </div>
                        <div class="input-search">
                            <input type="text" placeholder="Search">
                        </div>
                    </div>
                </div>
            </div>
            <div class="menu-mobie">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </div>
</header>
<main>