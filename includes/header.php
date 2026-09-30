<?php
$headerName = $_SESSION['nama'] ?? 'Pengguna';
$headerInitial = function_exists('mb_substr') ? mb_strtoupper(mb_substr($headerName, 0, 1, 'UTF-8'), 'UTF-8') : strtoupper(substr($headerName, 0, 1));
?>
<header class="header">
    <div class="header-title">
        <span>OMTI</span>
        <span class="header-subtitle">(Objectives, Measurements, Targets, and Initiatives)</span>
    </div>
    <div class="user-area">
        <span class="user-avatar" aria-hidden="true"><?= htmlspecialchars($headerInitial, ENT_QUOTES, 'UTF-8') ?></span>
        <span><?= htmlspecialchars($headerName, ENT_QUOTES, 'UTF-8') ?></span>
        <span aria-hidden="true">⌄</span>
    </div>
</header>
