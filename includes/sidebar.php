<?php
$currentPage = basename($_SERVER['PHP_SELF'] ?? '');
$menuItems = [
    ['label' => 'Dashboard', 'href' => 'dashboard.php', 'icon' => '⌂', 'pages' => ['dashboard.php']],
    ['label' => 'Summary Pencapaian', 'href' => 'summary.php', 'icon' => '▥', 'pages' => ['summary.php', 'summary_download.php', 'summary_dwonload.php']],
    ['label' => 'Library', 'href' => '#', 'icon' => '▤', 'pages' => []],
    ['label' => 'Mapping Corporate', 'href' => '#', 'icon' => '⚑', 'pages' => []],
    ['label' => 'Mapping', 'href' => 'index.php', 'icon' => '✣', 'pages' => ['index.php', 'proses.php', 'edit.php', 'hapus.php']],
    ['label' => 'Laporan', 'href' => 'summary.php', 'icon' => '▧', 'pages' => []],
    ['label' => 'Download Evidence', 'href' => '#', 'icon' => '☁', 'pages' => []],
    ['label' => 'Dashboard Lama', 'href' => 'index.php', 'icon' => '▣', 'pages' => []],
    ['label' => 'Initiative', 'href' => '#', 'icon' => '⚙', 'pages' => []],
    ['label' => 'Realisasi', 'href' => '#', 'icon' => '▦', 'pages' => []],
    ['label' => 'Waktu Pengisian', 'href' => '#', 'icon' => '◷', 'pages' => []],
    ['label' => 'Pedoman OMTI', 'href' => '#', 'icon' => '▧', 'pages' => []],
    ['label' => 'Konf. Perspective', 'href' => '#', 'icon' => '⚙', 'pages' => []],
];
?>
<aside class="sidebar">
    <div class="logo-area">
        <img src="assets/logo-peruri.png" alt="Logo PERURI" onerror="this.style.display='none'">
        <div class="logo-caption">CONTROLLER OMTI</div>
    </div>
    <nav class="menu" aria-label="Navigasi utama">
        <?php foreach ($menuItems as $item): ?>
            <?php $active = in_array($currentPage, $item['pages'], true); ?>
            <a href="<?= htmlspecialchars($item['href'], ENT_QUOTES, 'UTF-8') ?>"
               class="<?= $active ? 'active' : '' ?>"
               <?= $active ? 'aria-current="page"' : '' ?>>
                <span class="menu-icon" aria-hidden="true"><?= htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8') ?></span>
                <span class="menu-label"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></span>
            </a>
        <?php endforeach; ?>
    </nav>
</aside>
