<?php
$urlArray = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', $urlArray);
?>
<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
<div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
        <li class="nav-item start <?= (end($segments) == 'kelas.php' || end($segments) == 'detail_kelas.php') ? 'active open' : '' ?>">
            <a href="../index.php" class="nav-link nav-toggle">
                <i class="icon-home"></i>
                <span class="title">Dashboard</span>
                <span class="selected"></span>
            </a>
        </li>
        <!-- <li class="nav-item  <?= (end($segments) == 'media.php' || end($segments) == 'detail_media.php') ? 'active open' : '' ?>">
            <a href="media.php" class="nav-link">
                <i class="icon-puzzle"></i>
                <span class="title">Bank Media</span>
            </a>
        </li> -->
    </ul>
    <!-- END SIDEBAR MENU -->
</div>