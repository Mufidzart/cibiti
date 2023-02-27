<?php
$getstaf = mysqli_query($conn, "SELECT * FROM arf_staf WHERE nip='$session_id_staf'");
$datastaf = mysqli_fetch_assoc($getstaf);
?>
<!-- BEGIN LOGO -->
<div class="page-logo">
  <a href="../index.php">
    <!-- <img src="../assets/layouts/layout4/img/logo-light.png" alt="logo" class="logo-default" /> -->
    <h1 style="color: white;">LMS</h1>
  </a>
  <div class="menu-toggler sidebar-toggler">
    <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
  </div>
</div>
<!-- END LOGO -->
<!-- BEGIN RESPONSIVE MENU TOGGLER -->
<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
<!-- END RESPONSIVE MENU TOGGLER -->
<!-- BEGIN PAGE TOP -->
<div class="page-top">
  <!-- BEGIN TOP NAVIGATION MENU -->
  <div class="top-menu">
    <ul class="nav navbar-nav pull-right">
      <li class="separator hide"> </li>
      <!-- BEGIN USER LOGIN DROPDOWN -->
      <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
      <li class="dropdown dropdown-user dropdown-dark">
        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
          <span class="username username-hide-on-mobile"> <?= $datastaf['nama_lengkap'] ?> </span>
          <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
          <img alt="" class="img-circle bg-white" style="padding:2px;" src="assets/images/admin_avatar.png" /> </a>
        <ul class="dropdown-menu dropdown-menu-default">
          <li>
            <a href="../auth.php?action=logout">
              <i class="icon-key"></i> Log Out </a>
          </li>
        </ul>
      </li>
      <!-- END USER LOGIN DROPDOWN -->
      <!-- BEGIN QUICK SIDEBAR TOGGLER -->
      <!-- <li class="dropdown dropdown-extended quick-sidebar-toggler">
        <span class="sr-only">Toggle Quick Sidebar</span>
        <i class="icon-logout"></i>
      </li> -->
      <!-- END QUICK SIDEBAR TOGGLER -->
    </ul>
  </div>
  <!-- END TOP NAVIGATION MENU -->
</div>
<!-- END PAGE TOP -->