<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/21/2023
 * Time: 2:52 PM
 */
global $wpdb;
$module_path = 'admin.php?page=reviews';
$page = 'reviews';
$my_str = "WHERE 1=1";
//if (isset($_POST['keyword'])) {
//    $keyword = $_POST['keyword'];
////    echo $keyword;die;
//    //
//    if ($keyword != '') {
//        $my_str .= ' AND ffc_posts.post_title like "%' . $keyword . '%" OR reviews.comment LIKE "%' . $keyword . '%"';
//
//    }
//}
//if (isset($_POST['status'])) {
//    $status = (int)$_POST['status'];
//    if ($status == 1 || $status == 0) {
//        $my_str .= ' AND reviews.status = ' . $status;
//    }
//}

/*Max Number of results to show*/
$max = 20;
/*Get the current page eg index.php?pg=4*/

if (isset($_GET['pg'])) {
    $p = (int)$_GET['pg'];
} else {
    $p = 1;
}
$limit = ($p - 1) * $max;
$prev = $p - 1;
$next = $p + 1;
$limits = (int)($p - 1) * $max;
// get comment with status = 1
$sqlReview = $wpdb->prepare("SELECT * from {$wpdb->prefix}review order by id desc ");
$result = $wpdb->get_results($sqlReview);

$getCommentTotal = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}review", OBJECT);
$totalres = count($getCommentTotal);
$totalposts = ceil($totalres / $max);
$lpm1 = $totalposts - 1;


?>
<style>
    .pagination {
        float: right;
    }

    .pagination a,
    .pagination span {http://kvland.wecan-group.info/
        display: inline-block;
        vertical-align: baseline;
        min-width: 30px;
        min-height: 30px;
        margin: 0;
        padding: 0 4px;
        font-size: 16px;
        line-height: 1.625;
        text-align: center;
    }

    .divgif {
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: 1100;
        display: none;
        background: #dedede;
        opacity: 0.5;
        top: 0;
        left: 0;
    }

    .iconloadgif {
        top: 0;
        right: 0;
        left: 0;
        bottom: 0;
        position: absolute;
        margin: auto;
        width: 150px;
        height: 150px;
    }
</style>
<div class="divgif">
    <img class="iconloadgif" src="https://i.gifer.com/ZKZg.gif " alt="">
</div>
<div class="wrap">
    <h1 style="margin-bottom:15px;">
        Quản lý đánh giá của khách hàng
    </h1>

    <ul class="subsubsub">
        <li class="all"><a class="current" href="<?php echo $module_path; ?>">Tất cả <span
                        class="count">(<?php echo $totalres; ?>)</span></a></li>
    </ul>
    <form class="search-box flr"  id="search-form" method="POST" action="" style="float: right">
        Trạng thái:
        <select name="status" style="margin-bottom: 4px">
            <option value="2" <?php if (isset($status) && $status == 2) {
                echo 'selected';
            } ?>>Tất cả trạng thái
            </option>
            <option value="1" <?php if (isset($status) && $status == 1) {
                echo 'selected';
            } ?>>Đã duyệt
            </option>
            <option value="0" <?php if (isset($status) && $status == 0) {
                echo 'selected';
            } ?>>Chưa duyệt
            </option>
        </select>
        <input class="sear_2" value="<?php if (isset($keyword)) echo $keyword; ?>" type="text" name="keyword"
               placeholder="Từ khóa">

        <input type="submit" name="search" value="Lọc" class="button"/>
    </form>

    <div style="display: none" class="notice updated is-dismissible" id="message">
        <p class="notice-mess"></p>
    </div>

    <form class="" method="POST" action="<?php echo $module_path; ?>">
        <div class="tablenav top" style="display: none">
            <div class="alignleft actions bulkactions">
                <select id="bulk-action-selector-top" name="action">
                    <option value="-1">Tác vụ</option>
                    <option value="1">Xóa</option>
                </select>

                <input type="submit" value="Áp dụng" class="button action" id="doaction" name="doaction">
            </div>
        </div>

        <table class="wp-list-table widefat fixed striped posts">
            <thead>
            <tr class="headline">
                <th style="width:30px;text-align:center;">STT</th>
                <th>Người đánh giá</th>
                <th>Tên bài viết</th>
                <th>Điểm tổng</th>
                <th>Ghi chú</th>
                <th>Thời gian</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
            </thead>
            <tfoot>
            <tr class="headline">
                <th style="width:30px;text-align:center;">STT</th>
                <th>Người đánh giá</th>
                <th>Tên bài viết</th>
                <th>Điểm tổng</th>
                <th>Ghi chú</th>
                <th>Thời gian</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
            </tfoot>

            <?php
            $i = 0;
            foreach ($result as $key => $item) {
                ?>
                <tr id="table-list-<?= $key ?>">
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $item->reviewer_name; ?></td>
                    <td><a href="<?php echo get_permalink($item->id_post); ?>"
                           target="_blank"><?= get_the_title($item->id_post); ?></a></td>
                    <td><?= $item->star_point ?> </td>
                    <td><?php echo $item->note ?></td>
                    <td><?= date('d/m/y H:i', $item->date_time) ?> </td>
                    <td>
                        <select style="color: <?= $item->status == 1 ? 'green':'red' ?>" class="reviews-status" data-reviews-id="<?php echo $item->id; ?>">
                            <?php if ($item->status == 1): ?>
                                <option value="1" style="color: green" selected>Đã duyệt</option>
                                <option value="0" style="color: red">Chưa duyệt</option>
                            <?php else: ?>
                                <option value="0" style="color: red" selected>Chưa duyệt</option>
                                <option value="1" style="color: green">Đã duyệt</option>
                            <?php endif; ?>
                        </select>
                    </td>
                    <td><a style="cursor: pointer" class="reviews-delete" data-id="<?php echo $item->id; ?>">Xóa</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

    </form>

    <!--    <div class="pagination">-->
    <?php //echo paginate_admin($totalposts, $p, $lpm1, $prev, $next, $page); ?><!--</div>-->

</div>

<div class="box-alert"></div>
<script src="<?php echo plugin_dir_url(__DIR__) . '/assets/js/jquery.min.js'; ?>"></script>
<script>

    $(document).on('click', '.reviews-delete', function () {
        if (confirm('Bạn có chắc chắn muốn xóa bình luận này không?')) {
            let id = $(this).attr('data-id');
            console.log('Review ID:', id);
            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                cache: false,
                dataType: "text",
                data: {
                    id: id,
                    action: 'commentDelete',
                },
                beforeSend: function () {
                    $('.divgif').show();

                },
                success: function () {
                    $('.divgif').hide();
                    alert('Xóa thành công');
                    location.reload();
                }

            });
        }
    });
    $(document).on('change', '.reviews-status', function () {
        let status = $(this).val();
        let reviewId = $(this).attr('data-reviews-id');
        console.log(status);

        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            cache: false,
            dataType: "text",
            data: {
                id: reviewId,
                status: status,
                action: 'changeStatus',
            },
            beforeSend: function () {
                $('.divgif').show();
            },
            success: function () {
                $('.divgif').hide();
                alert('Cập nhật thành công')
                location.reload();
            }
        });
    });
    $('#search-form').on('submit', function (e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            dataType: 'json',
            data: formData + '&action=perform_search',
            beforeSend: function () {
                $('.divgif').show();
            },
            success: function (response) {
                $('.divgif').hide();
                updateTable(response);
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    function updateTable(response) {
        let html = '';

        if (response.length == 0) {
            html = '<tr><td colspan="8">Không có dữ liệu</td></tr>';
        } else {
            response.forEach(function (item, index) {
                var post_link = '<?= json_encode(get_permalink(' + item.id_post + ')) ?>';
                 var date = new Date(item.date_time * 1000);
                date = date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear() + ' ' + date.getHours() + ':' + date.getMinutes();
                html += '<tr id="table-list-' + index + '">';
                html += '<td>' + (index + 1) + '</td>';
                html += '<td>' + item.reviewer_name + '</td>';
                html += '<td><a href="' + item.link_post + '" target="_blank">' + item.title_post + '</a></td>';
                html += '<td>' + item.star_point + '</td>';
                html += '<td>' + item.note + '</td>';
                html += '<td>' + date + '</td>';
                html += '<td>';
                html += '<select class="reviews-status" data-reviews-id="' + item.id + '">';
                if (item.status == 1) {
                    html += '<option value="1" selected>Đã duyệt</option>';
                    html += '<option value="0">Chưa duyệt</option>';
                } else {
                    html += '<option value="0" selected>Chưa duyệt</option>';
                    html += '<option value="1">Đã duyệt</option>';
                }
                html += '</select>';
                html += '</td>';
                html += '<td><a style="cursor: pointer" class="reviews-delete" data-id="' + item.id + '">Xóa</a></td>';
            });
        }
        $('table tbody').html(html);

    }

</script>
