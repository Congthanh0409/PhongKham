<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<div class="container my-5">
    <!-- Form đặt lịch hẹn -->
    <div class="card mb-4">
        <div class="card-header">
            <h2>Đặt Lịch Hẹn</h2>
        </div>
        <div class="card-body">
            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <form action="index.php?action=datlichhen" method="POST">
                <div class="form-group mb-3">
                    <label>Họ tên:</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($patient['fullname']); ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label>Số điện thoại:</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($patient['phone']); ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label>Email:</label>
                    <input type="email" class="form-control" value="<?php echo htmlspecialchars($patient['email']); ?>" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="appointment_date">Ngày hẹn</label>
                    <input type="date" class="form-control" id="appointment_date" name="appointment_date" required>
                </div>
                <div class="form-group mb-3">
                    <label for="appointment_time">Giờ hẹn</label>
                    <input type="text" class="form-control" id="appointment_time" name="appointment_time" required>
                </div>
                <button type="submit" name="book" class="btn btn-primary">Đặt Lịch</button>
            </form>
        </div>
    </div>
    <!-- Danh sách lịch hẹn -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Danh Sách Lịch Hẹn</h3>
            <div class="d-flex align-items-center">
                <small class="text-muted me-2" id="lastUpdate">Tự động cập nhật mỗi 30s</small>
                <button type="button" class="btn btn-info btn-sm" onclick="checkAppointmentStatus()" title="Kiểm tra cập nhật trạng thái">
                    <i class="fa fa-refresh"></i> Cập nhật
                </button>
            </div>
        </div>
        <div class="card-body">
            <?php if (count($appointments) > 0): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Bệnh nhân</th>
                            <th>Số điện thoại</th>
                            <th>Ngày hẹn</th>
                            <th>Giờ hẹn</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $appointment): 
                            // Debug: Show raw time from database
                            echo "<!-- DEBUG: Raw appointment_time from DB: " . $appointment['appointment_time'] . " -->";
                            
                            // Parse time directly without timezone conversion
                            $raw_time = $appointment['appointment_time'];
                            $edit_time = $raw_time;
                            
                            // If the raw time is in HH:MM:SS format, extract just HH:MM
                            if (preg_match('/^(\d{1,2}):(\d{2})(:\d{2})?$/', $raw_time, $matches)) {
                                $hours = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
                                $minutes = $matches[2];
                                $edit_time = $hours . ':' . $minutes;
                                echo "<!-- DEBUG: Parsed time from regex: " . $edit_time . " -->";
                            }
                            
                            // For display, use the same parsed time
                            $display_time = $edit_time;
                            
                            // Debug: Show formatted time
                            echo "<!-- DEBUG: Final edit_time: " . $edit_time . " -->";
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($appointment['benhnhan_name']); ?></td>
                                <td><?php echo htmlspecialchars($appointment['phone']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($appointment['appointment_date'])); ?></td>
                                <td><?php echo $display_time; ?></td>
                                <td>
                                    <?php if ($appointment['confirmed'] == 1): ?>
                                        <span class="status-badge status-confirmed">Đã xác nhận</span>
                                    <?php else: ?>
                                        <span class="status-badge status-waiting">Chờ xác nhận</span>
                                        <button type="button" class="btn btn-warning btn-sm ms-2" 
                                                onclick="editAppointment(<?php echo $appointment['id']; ?>, '<?php echo $appointment['appointment_date']; ?>', '<?php echo $edit_time; ?>')">
                                            <i class="fa fa-edit"></i> Sửa
                                        </button>
                                        <a href="index.php?action=datlichhen&delete_id=<?php echo $appointment['id']; ?>" 
                                           class="btn btn-danger btn-sm ms-1" 
                                           onclick="return deleteAppointment(<?php echo $appointment['id']; ?>)"
                                           title="Hủy lịch hẹn">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($appointment['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-info">Chưa có lịch hẹn nào.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Edit Appointment Modal -->
<div class="modal fade" id="editAppointmentModal" tabindex="-1" aria-labelledby="editAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAppointmentModalLabel">Sửa Lịch Hẹn</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editAppointmentForm" action="index.php?action=datlichhen" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="edit_appointment" value="1">
                    <input type="hidden" id="edit_appointment_id" name="appointment_id">
                    
                    <div class="form-group mb-3">
                        <label for="edit_appointment_date">Ngày hẹn</label>
                        <input type="date" class="form-control" id="edit_appointment_date" name="appointment_date" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_appointment_time">Giờ hẹn</label>
                        <input type="text" class="form-control" id="edit_appointment_time" name="appointment_time" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.status-badge {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
}
.status-waiting {
    background-color: #ff9800;
    color: white;
}
.status-confirmed {
    background-color: #4caf50;
    color: white;
}

/* Loading state for delete button */
.btn-danger.loading {
    pointer-events: none;
    opacity: 0.7;
}

.btn-danger.loading i {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Smooth transitions for table rows */
.table tbody tr {
    transition: all 0.3s ease;
}

.table tbody tr.removing {
    opacity: 0;
    transform: translateX(-100%);
}
</style>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#appointment_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        position: "below"
    });

    // Initialize time picker for edit modal
    flatpickr("#edit_appointment_time", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        position: "below",
        minuteIncrement: 30,
        defaultHour: 8,
        defaultMinute: 0,
        allowInput: true,
        clickOpens: true
    });

    function editAppointment(appointmentId, appointmentDate, appointmentTime) {
        console.log('=== Edit Appointment Debug ===');
        console.log('Appointment ID:', appointmentId);
        console.log('Appointment Date:', appointmentDate);
        console.log('Time passed from PHP:', appointmentTime);
        console.log('Time type:', typeof appointmentTime);
        console.log('Time length:', appointmentTime.length);
        
        document.getElementById('edit_appointment_id').value = appointmentId;
        document.getElementById('edit_appointment_date').value = appointmentDate;
        
        // Set the time directly - PHP should have already formatted it correctly
        console.log('Setting time input value to:', appointmentTime);
        document.getElementById('edit_appointment_time').value = appointmentTime;
        
        // Force flatpickr to update its internal value
        var timeInput = document.getElementById('edit_appointment_time');
        if (timeInput._flatpickr) {
            timeInput._flatpickr.setDate(appointmentTime, false);
            console.log('Forced flatpickr to update with time:', appointmentTime);
        }
        
        // Set minimum date to today
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById("edit_appointment_date").setAttribute("min", today);
        
        // Show modal
        var modal = new bootstrap.Modal(document.getElementById('editAppointmentModal'));
        modal.show();
    }

    window.onload = function() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById("appointment_date").setAttribute("min", today);
    };

    document.querySelector('form').addEventListener('submit', function(event) {
        var appointmentDate = document.getElementById('appointment_date').value;
        var appointmentTime = document.getElementById('appointment_time').value;
        var appointmentDatetime = new Date(appointmentDate + 'T' + appointmentTime);
        var now = new Date();
        if (appointmentDatetime < now) {
            event.preventDefault();
            alert("Ngày và giờ hẹn không được nhỏ hơn thời gian hiện tại!");
        }
    });

    // Add validation for edit form
    document.getElementById('editAppointmentForm').addEventListener('submit', function(event) {
        var appointmentDate = document.getElementById('edit_appointment_date').value;
        var appointmentTime = document.getElementById('edit_appointment_time').value;
        var appointmentDatetime = new Date(appointmentDate + 'T' + appointmentTime);
        var now = new Date();
        if (appointmentDatetime < now) {
            event.preventDefault();
            alert("Ngày và giờ hẹn không được nhỏ hơn thời gian hiện tại!");
        }
    });

    // AJAX function to delete appointment
    function deleteAppointment(appointmentId) {
        if (confirm('Bạn có chắc chắn muốn hủy lịch hẹn này?')) {
            // Show loading state
            const deleteBtn = event.target.closest('a');
            const originalContent = deleteBtn.innerHTML;
            deleteBtn.innerHTML = '<i class="fa fa-spinner"></i>';
            deleteBtn.classList.add('loading');
            
            // Make AJAX request
            fetch('index.php?action=datlichhen&delete_id=' + appointmentId, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add removing animation
                    const row = deleteBtn.closest('tr');
                    if (row) {
                        row.classList.add('removing');
                        
                        // Remove row after animation
                        setTimeout(() => {
                            row.remove();
                            
                            // Check if table is empty
                            const tbody = row.parentNode;
                            if (tbody && tbody.children.length === 0) {
                                // Show "no appointments" message
                                const tableContainer = tbody.closest('.card-body');
                                tableContainer.innerHTML = '<div class="alert alert-info">Chưa có lịch hẹn nào.</div>';
                            }
                        }, 300);
                    }
                    
                    // Show success message
                    showMessage(data.message, 'success');
                } else {
                    // Show error message
                    showMessage(data.message, 'error');
                    
                    // Restore button
                    deleteBtn.innerHTML = originalContent;
                    deleteBtn.classList.remove('loading');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('Có lỗi xảy ra khi hủy lịch hẹn!', 'error');
                
                // Restore button
                deleteBtn.innerHTML = originalContent;
                deleteBtn.classList.remove('loading');
            });
        }
        return false; // Prevent default link behavior
    }

    // Function to show messages
    function showMessage(message, type) {
        // Remove existing messages
        const existingMessages = document.querySelectorAll('.alert');
        existingMessages.forEach(msg => msg.remove());
        
        // Create new message
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'}`;
        alertDiv.textContent = message;
        
        // Insert message at the top of the form
        const formCard = document.querySelector('.card-body');
        formCard.insertBefore(alertDiv, formCard.firstChild);
        
        // Auto remove message after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }

    // Function to refresh table content
    function refreshTable() {
        // Reload the page to get updated data
        location.reload();
    }

    // Auto refresh table after successful form submission
    document.querySelector('form[action*="datlichhen"]').addEventListener('submit', function(event) {
        // If this is a successful submission, refresh after a short delay
        setTimeout(() => {
            if (document.querySelector('.alert-success')) {
                refreshTable();
            }
        }, 2000);
    });

    // Handle edit form submission
    document.getElementById('editAppointmentForm').addEventListener('submit', function(event) {
        // Validation is already handled above
        // After successful submission, refresh the table
        setTimeout(() => {
            if (document.querySelector('.alert-success')) {
                refreshTable();
            }
        }, 2000);
    });

    // Auto-check appointment status every 30 seconds
    let statusCheckInterval;
    
    function startStatusCheck() {
        statusCheckInterval = setInterval(checkAppointmentStatus, 30000); // Check every 30 seconds
    }
    
    function stopStatusCheck() {
        if (statusCheckInterval) {
            clearInterval(statusCheckInterval);
        }
    }
    
    function checkAppointmentStatus() {
        // Update last update time
        const now = new Date();
        const timeString = now.toLocaleTimeString('vi-VN', {hour: '2-digit', minute: '2-digit'});
        document.getElementById('lastUpdate').textContent = `Cập nhật lúc: ${timeString}`;
        
        fetch('index.php?action=check_appointment_status', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateAppointmentTable(data.appointments);
            }
        })
        .catch(error => {
            console.error('Error checking appointment status:', error);
            document.getElementById('lastUpdate').textContent = 'Lỗi kết nối';
        });
    }
    
    function updateAppointmentTable(appointments) {
        const tbody = document.querySelector('.table tbody');
        if (!tbody) return;
        
        // Check if there are any status changes
        const currentRows = tbody.querySelectorAll('tr');
        let hasStatusChange = false;
        
        if (currentRows.length > 0 && currentRows.length === appointments.length) {
            currentRows.forEach((row, index) => {
                const appointment = appointments[index];
                const currentStatus = row.querySelector('.status-badge');
                const newStatus = appointment.confirmed == 1 ? 'Đã xác nhận' : 'Chờ xác nhận';
                
                if (currentStatus && currentStatus.textContent !== newStatus) {
                    hasStatusChange = true;
                }
            });
        }
        
        // Clear existing rows
        tbody.innerHTML = '';
        
        if (appointments.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center"><div class="alert alert-info">Chưa có lịch hẹn nào.</div></td></tr>';
            return;
        }
        
        appointments.forEach(appointment => {
            // Parse time for display
            let raw_time = appointment.appointment_time;
            let edit_time = raw_time;
            let display_time = edit_time;
            
            // Use JavaScript regex instead of PHP preg_match
            let timeMatch = raw_time.match(/^(\d{1,2}):(\d{2})(:\d{2})?$/);
            if (timeMatch) {
                let hours = String(timeMatch[1]).padStart(2, '0');
                let minutes = timeMatch[2];
                edit_time = hours + ':' + minutes;
                display_time = edit_time;
            }
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${escapeHtml(appointment.benhnhan_name)}</td>
                <td>${escapeHtml(appointment.phone)}</td>
                <td>${formatDate(appointment.appointment_date)}</td>
                <td>${display_time}</td>
                <td>
                    ${appointment.confirmed == 1 ? 
                        '<span class="status-badge status-confirmed">Đã xác nhận</span>' : 
                        `<span class="status-badge status-waiting">Chờ xác nhận</span>
                         <button type="button" class="btn btn-warning btn-sm ms-2" 
                                 onclick="editAppointment(${appointment.id}, '${appointment.appointment_date}', '${edit_time}')">
                             <i class="fa fa-edit"></i> Sửa
                         </button>
                         <a href="index.php?action=datlichhen&delete_id=${appointment.id}" 
                            class="btn btn-danger btn-sm ms-1" 
                            onclick="return deleteAppointment(${appointment.id})"
                            title="Hủy lịch hẹn">
                             <i class="fa fa-trash"></i>
                         </a>`
                    }
                </td>
                <td>${formatDateTime(appointment.created_at)}</td>
            `;
            tbody.appendChild(row);
        });
        
        // Show notification if status changed
        if (hasStatusChange) {
            showMessage('Trạng thái lịch hẹn đã được cập nhật!', 'success');
        }
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('vi-VN');
    }
    
    function formatDateTime(dateTimeString) {
        const date = new Date(dateTimeString);
        return date.toLocaleDateString('vi-VN') + ' ' + date.toLocaleTimeString('vi-VN', {hour: '2-digit', minute: '2-digit'});
    }
    
    // Start status checking when page loads
    document.addEventListener('DOMContentLoaded', function() {
        startStatusCheck();
        
        // Also check status when user becomes active (tab focus, mouse movement, etc.)
        let userActivityTimeout;
        function resetActivityTimeout() {
            clearTimeout(userActivityTimeout);
            userActivityTimeout = setTimeout(() => {
                checkAppointmentStatus();
            }, 5000); // Check after 5 seconds of inactivity
        }
        
        // Listen for user activity
        ['mousemove', 'keypress', 'click', 'scroll'].forEach(event => {
            document.addEventListener(event, resetActivityTimeout, true);
        });
        
        // Check status when tab becomes visible
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                checkAppointmentStatus();
            }
        });
    });
    
    // Stop checking when page is unloaded
    window.addEventListener('beforeunload', stopStatusCheck);
</script> 