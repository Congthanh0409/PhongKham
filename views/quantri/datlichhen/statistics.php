<section class="wrapper">
    <h3><i class="fa fa-angle-right"></i> Thống kê lịch hẹn</h3>
    <div class="row mt">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-heading">
                    <h4><i class="fa fa-bar-chart"></i> Tổng quan lịch hẹn</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="stat-card">
                                <h3><i class="fa fa-calendar"></i> Tổng số lịch hẹn</h3>
                                <div class="number"><?php echo $total_appointments; ?></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card">
                                <h3><i class="fa fa-check-circle"></i> Đã xác nhận</h3>
                                <div class="number" style="color: #5cb85c;"><?php echo $confirmed_appointments; ?></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-card">
                                <h3><i class="fa fa-clock-o"></i> Chờ xác nhận</h3>
                                <div class="number" style="color: #f0ad4e;"><?php echo $pending_appointments; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt">
        <div class="col-md-6">
            <div class="content-panel">
                <div class="panel-heading">
                    <h4><i class="fa fa-line-chart"></i> Lịch hẹn theo tháng</h4>
                </div>
                <div class="panel-body">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="content-panel">
                <div class="panel-heading">
                    <h4><i class="fa fa-bar-chart"></i> Lịch hẹn theo ngày trong tuần</h4>
                </div>
                <div class="panel-body">
                    <canvas id="weekdayChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt">
        <div class="col-md-12">
            <div class="content-panel">
                <div class="panel-heading">
                    <h4><i class="fa fa-clock-o"></i> Lịch hẹn theo khung giờ</h4>
                </div>
                <div class="panel-body">
                    <canvas id="timeslotChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly chart
    const monthlyLabels = ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12"];
    const monthlyTotal = <?php echo json_encode(array_map(function($m){return $m['total'];}, $monthly_data)); ?>;
    const monthlyConfirmed = <?php echo json_encode(array_map(function($m){return $m['confirmed'];}, $monthly_data)); ?>;
    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [
                { label: 'Tổng', data: monthlyTotal, backgroundColor: '#007bff' },
                { label: 'Đã xác nhận', data: monthlyConfirmed, backgroundColor: '#28a745' }
            ]
        },
        options: { responsive: true, plugins: { legend: { position: 'top' } } }
    });
    // Weekday chart
    const weekdayLabels = ["CN", "T2", "T3", "T4", "T5", "T6", "T7"];
    const weekdayData = <?php echo json_encode(array_values($weekday_data)); ?>;
    new Chart(document.getElementById('weekdayChart'), {
        type: 'bar',
        data: {
            labels: weekdayLabels,
            datasets: [{ label: 'Lịch hẹn', data: weekdayData, backgroundColor: '#ffc107' }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });
    // Timeslot chart
    const timeslotLabels = Array.from({length: 24}, (_, i) => i + ':00');
    const timeslotData = <?php echo json_encode(array_values($timeslot_data)); ?>;
    new Chart(document.getElementById('timeslotChart'), {
        type: 'line',
        data: {
            labels: timeslotLabels,
            datasets: [{ label: 'Lịch hẹn', data: timeslotData, borderColor: '#17a2b8', backgroundColor: 'rgba(23,162,184,0.1)', fill: true }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });
</script> 