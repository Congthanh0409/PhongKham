<ul class="sidebar-menu" id="nav-accordion">
    <p class="centered"><a href="index.php?action=admin_dashboard"><img src="quantri/assets/image/tải xuống.png" class="img-circle" width="60"></a></p>
    <h5 class="centered">
        <?php 
        $currentUser = SessionHelper::getCurrentUser();
        echo $currentUser ? $currentUser['username'] : 'Admin'; 
        ?>
    </h5>
    <li class="sub-menu">
        <a href="javascript:;">
            <i class="fa fa-desktop"></i>
            <span>Danh Mục</span>
        </a>
        <ul class="sub">
            <li><a href="index.php?action=admin_gioithieu_list">Giới Thiệu</a></li>
            <li><a href="index.php?action=admin_taimuihong_list">Tai-Mũi-Họng</a></li>
            <li><a href="index.php?action=admin_dichvu_list">Dịch Vụ</a></li>
            <li><a href="index.php?action=admin_tintuc_list">Tin Tức</a></li>
            <li><a href="index.php?action=admin_banner_list">Banner</a></li>
            <li><a href="index.php?action=admin_chungnhan_list">Chứng Nhận Quốc Gia</a></li>
            <li><a href="index.php?action=admin_datlichhen_list">Quản lý lịch hẹn</a></li>
            <li><a href="index.php?action=admin_datlichhen_statistics">Thống kê lịch hẹn</a></li>
            <li><a href="index.php?action=admin_hosobenhan_list">Hồ sơ bệnh án</a></li>
        </ul>
    </li>
    <li class="sub-menu">
        <a href="javascript:;">
            <i class="fa fa-tasks"></i>
            <span>Users</span>
        </a>
        <ul class="sub">
            <li><a href="index.php?action=admin_phanquyen_list">Xem Phân Quyền Người Dùng</a></li>
            <li><a href="index.php?action=admin_dieuchinhquyenhang_list">Điều chỉnh quyền hạng</a></li>
            <li><a href="index.php?action=admin_editpassword">Đổi mật khẩu</a></li>
        </ul>
    </li>
    <li class="sub-menu">
        <a href="javascript:;">
            <i class="fa fa-tasks"></i>
            <span>Cấu Hình Trang Web</span>
        </a>
        <ul class="sub">
            <li><a href="index.php?action=admin_socialmedia">Điều Chỉnh Mạng Xã Hội</a></li>
        </ul>
    </li>
</ul> 