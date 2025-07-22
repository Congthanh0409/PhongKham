<?php
// Banner Section
if (isset($bannerContent)) {
    echo $bannerContent;
}

// Gioi Thieu Section
require_once __DIR__ . '/../partials/gioithieu.php';

// Dich Vu Section
if (isset($dichVuContent)) {
    echo $dichVuContent;
}

// Chung Nhan Section
if (isset($chungNhanContent)) {
    echo $chungNhanContent;
}

// Tin Tuc Section
if (isset($tinTucContent)) {
    echo $tinTucContent;
} 