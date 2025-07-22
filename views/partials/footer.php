<?php
// This logic should be in a controller
require_once __DIR__ . '/../../config/dbconnect.php';

$db = new Database();
$conn = $db->getConnection();

$sql_contact = "SELECT id, facebook, zalo, tiktok, phone_number, company_email, company_address FROM social_media WHERE id = 1";
$result_contact = $conn->query($sql_contact);

if ($result_contact->num_rows > 0) {
    $social = $result_contact->fetch_assoc();
} else {
    $social = [
        'facebook' => '#',
        'tiktok' => '#',
        'zalo' => '#',
        'company_email' => 'info@taimuihong.com',
        'company_address' => '123 Đường ABC, TP Bắc Ninh',
        'phone_number' => '0123456789'
    ];
}
?>

<footer>
    <div class="container">
        <div class="row">
            
            <div class="col-12 col-md-4">
                <div class="footer-info">
                    <h4>Phòng Khám Đa Khoa Tai - Mũi - Họng</h4>
                    <p>Chúng tôi cung cấp dịch vụ uy tín và chất lượng.</p>
                    <div class="social-icons">
                        <a href="<?php echo $social['facebook']; ?>" class="social-icon facebook" target="_blank">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b9/2023_Facebook_icon.svg/667px-2023_Facebook_icon.svg.png" alt="Facebook" />
                        </a>
                        <a href="<?php echo $social['tiktok']; ?>" class="social-icon tiktok" target="_blank">
                            <img src="https://static.vecteezy.com/system/resources/previews/023/986/492/non_2x/tiktok-logo-tiktok-logo-transparent-tiktok-icon-transparent-free-free-png.png" alt="Tiktok" />
                        </a>
                        <a href="<?php echo $social['zalo']; ?>" class="social-icon zalo" target="_blank">
                            <img src="https://hidosport.vn/wp-content/uploads/2023/09/zalo-icon.png" alt="Zalo" />
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="footer-contact">
                    <h4>Thông Tin Liên Hệ</h4>
                    <p>Địa chỉ: <?php echo $social['company_address']; ?></p>
                    <p>Email: <?php echo $social['company_email']; ?></p>
                    <p>Điện thoại: <?php echo $social['phone_number']; ?></p>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="footer-hours">
                    <h4>Thời Gian Làm Việc</h4>
                    <p>Thứ 2 - Thứ 6: 8:00 AM - 6:00 PM</p>
                    <p>Thứ 7: 8:00 AM - 12:00 PM</p>
                    <p>Chủ Nhật: Đóng cửa</p>
                </div>
            </div>
        </div>
    </div>
</footer> 