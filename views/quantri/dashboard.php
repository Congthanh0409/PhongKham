<section class="wrapper">
    <?php if (isset($_SESSION['editpw_success'])): ?>
        <div class="alert alert-success alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <?php echo $_SESSION['editpw_success']; ?>
        </div>
        <?php unset($_SESSION['editpw_success']); ?>
    <?php endif; ?>
    
    <div class="row">
        <!-- Dịch Vụ -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-primary text-center no-boder">
                <div class="panel-body">
                    <i class="fa fa-briefcase fa-5x"></i>
                    <h3><?php echo $total_services; ?></h3>
                </div>
                <div class="panel-footer">
                    <span class="panel-footer-text">Dịch Vụ</span>
                </div>
            </div>
        </div>
        <!-- Tai-Mũi-Họng -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-green text-center no-boder">
                <div class="panel-body">
                    <i class="fa fa-stethoscope fa-5x"></i>
                    <h3><?php echo $total_braces; ?></h3>
                </div>
                <div class="panel-footer">
                    <span class="panel-footer-text">Tai-Mũi-Họng</span>
                </div>
            </div>
        </div>
        <!-- Đặt Lịch Hẹn -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-yellow text-center no-boder">
                <div class="panel-body">
                    <i class="fa fa-calendar fa-5x"></i>
                    <h3><?php echo $total_appointments; ?></h3>
                </div>
                <div class="panel-footer">
                    <span class="panel-footer-text">Đặt Lịch Hẹn</span>
                </div>
            </div>
        </div>
        <!-- Người Dùng -->
        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="panel panel-red text-center no-boder">
                <div class="panel-body">
                    <i class="fa fa-users fa-5x"></i>
                    <h3><?php echo $total_users; ?></h3>
                </div>
                <div class="panel-footer">
                    <span class="panel-footer-text">Người Dùng</span>
                </div>
            </div>
        </div>
    </div>
</section> 