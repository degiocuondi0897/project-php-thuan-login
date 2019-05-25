<?php
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$num_per_page = 2;
$total_row = get_total_user();
//show_array($total_row);
$num_page = ceil($total_row / $num_per_page);
$start = ($page - 1) * $num_per_page;
//THanh phân trang
$base_url_pagging = "?mod=users&act=member";
$html_pagging = create_pagging($num_page, $base_url_pagging, $page);
$list_users = get_list_user($start, $num_per_page);
//show_array($list_users);
?>
<?php get_header(); ?>
    <div id="main-content-wp" class="member-page">
        <div class="wp-inner">
            <h3 class="title-page">Thông tin thành viên</h3>
            <div id="list-member">
                <table>
                    <thead>
                    <tr>
                        <td>STT</td>
                        <td>Họ và tên</td>
                        <td>Email</td>
                        <td>Trạng thái</td>
                        <td>Thao tác</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($list_users as $value) { ?>
                        <tr>
                            <td><?php echo $value['i'] ?></td>
                            <td><?php echo $value['userName'] ?></td>
                            <td><?php echo $value['emailUser'] ?></td>
                            <td><?php
                                if ($value['is_active'] == 1) {
                                    echo "đã kích hoạt";
                                } else {
                                    echo "chưa kích hoạt";
                                }
                                ?>
                            </td>
                            <td><a href="<?php echo $value['edit_user']?>" style="background: #b50000; margin-right: 10px; color: white; padding: 5px;">sửa</a>
                                <a href="<?php echo $value['delete_user']?>" style="background: #b50000; margin-right: 10px; color: white; padding: 5px;">xóa</a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?php echo $html_pagging; ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>