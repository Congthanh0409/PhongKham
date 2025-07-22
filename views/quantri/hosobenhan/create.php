<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-panel">
                <h4 class="mb"><i class="fa fa-angle-right"></i> Thêm Hồ Sơ Bệnh Án</h4>
                <form class="form-horizontal style-form" method="post" action="index.php?action=admin_hosobenhan_add">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Lịch hẹn đã xác nhận</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="appointment_id" id="appointment_id" required onchange="fillFromAppointment(this)">
                                <option value="">-- Chọn lịch hẹn --</option>
                                <?php foreach ($appointments as $appt): ?>
                                    <option 
                                        value="<?php echo $appt['appointment_id']; ?>"
                                        data-benhnhan-id="<?php echo $appt['benhnhan_id']; ?>"
                                        data-ngaykham="<?php echo $appt['appointment_date']; ?>">
                                        <?php echo htmlspecialchars($appt['name']) . " - " . date('d/m/Y', strtotime($appt['appointment_date'])); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <!-- Trường ẩn -->
                            <input type="hidden" name="benhnhan_id" id="benhnhan_id">
                            <input type="hidden" name="ngaykham" id="ngaykham">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Bác sĩ</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="bacsi" value="Bác Sĩ Trường" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Ghi chú</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="ghichu" id="ghichu" rows="3"></textarea>
                            <button type="button" class="btn btn-voice" onclick="startDictation()">
                                <i class="fa fa-microphone"></i> Ghi âm 
                            </button>
                            <div id="voiceStatus" class="voice-status"></div>
                            <input type="hidden" name="transcripts" id="transcripts" value="[]">
                            <div class="transcript-items"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Trạng thái</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="trangthai" required>
                                <option value="active">Đang điều trị</option>
                                <option value="completed">Hoàn thành</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Thêm hồ sơ
                            </button>
                            <a href="index.php?action=admin_hosobenhan_list" class="btn btn-default">
                                <i class="fa fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
    .btn-voice {
        background-color: #2196F3;
        color: white;
        border: none;
        margin-top: 10px;
    }
    .btn-voice:hover {
        background-color: #1976D2;
        color: white;
    }
    .btn-voice i {
        margin-right: 5px;
    }
    .voice-status {
        margin-top: 10px;
        font-style: italic;
        color: #666;
    }
    .recording {
        animation: pulse 1.5s infinite;
    }
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    .transcript-items {
        margin-top: 10px;
    }
    .transcript-item {
        margin-bottom: 10px;
        font-size: 0.9em;
        position: relative;
    }
    .transcript-item strong {
        color: #666;
        font-size: 0.8em;
    }
</style>

<script>
    // Initialize transcripts array
    let transcriptArray = [];

    // Speech recognition functionality
    function startDictation() {
        if (!('webkitSpeechRecognition' in window)) {
            alert("Trình duyệt không hỗ trợ Web Speech API. Vui lòng sử dụng Chrome!");
            return;
        }

        const recognition = new webkitSpeechRecognition();
        recognition.lang = "vi-VN";
        recognition.continuous = false;
        recognition.interimResults = false;

        const voiceStatus = document.getElementById("voiceStatus");
        const ghichuTextarea = document.getElementById("ghichu");
        const voiceButton = document.querySelector(".btn-voice");
        const transcriptList = document.querySelector(".transcript-items");

        recognition.onstart = () => {
            voiceStatus.innerText = "🎤 Đang nghe... Hãy nói ghi chú của bạn...";
            voiceButton.classList.add("recording");
        };

        recognition.onresult = function(event) {
            const transcript = event.results[0][0].transcript;
            
            // Add to textarea
            ghichuTextarea.value = ghichuTextarea.value 
                ? ghichuTextarea.value + "\n" + transcript 
                : transcript;
            
            // Add to transcripts array
            transcriptArray.push(transcript);
            document.getElementById("transcripts").value = JSON.stringify(transcriptArray);
            
            // Add to visual list
            const time = new Date().toLocaleTimeString();
            const transcriptItem = document.createElement("div");
            transcriptItem.className = "transcript-item alert alert-info alert-dismissible fade show";
            transcriptItem.innerHTML = `
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>${time}</strong><br>
                ${transcript}
            `;
            transcriptList.appendChild(transcriptItem);
            
            voiceStatus.innerText = "✅ Đã ghi nhận ghi chú";
        };

        recognition.onerror = function(event) {
            voiceStatus.innerText = "❌ Có lỗi xảy ra: " + event.error;
            voiceButton.classList.remove("recording");
        };

        recognition.onend = function() {
            voiceButton.classList.remove("recording");
            setTimeout(() => {
                voiceStatus.innerText = "";
            }, 3000);
        };

        recognition.start();
    }

    function fillFromAppointment(select) {
        const option = select.options[select.selectedIndex];
        document.getElementById('benhnhan_id').value = option.getAttribute('data-benhnhan-id');
        document.getElementById('ngaykham').value = option.getAttribute('data-ngaykham');
    }
</script> 