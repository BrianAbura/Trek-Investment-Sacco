  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>TREK</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="../dist/img/fav.png" width="50" alt="TREK"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
		</a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <?php 
           if($user['Role'] == 4){ //Only Systems Admin
          ?>
        <li>
            <a href="sysAdmin.php">
              <span ><i class="fa fa-empire" aria-hidden="true"></i> Admin</span>
            </a>
          </li>
          <?php } ?>
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo $src;?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $user['Fullname'];?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo $src;?>" class="img-circle" alt="User Image">
                <p>
                  <?php echo $user['Fullname'].' - '.$role['Role'];?>
                  <small><?php echo date_format(date_create($user['LastLogin']), 'd/m/Y H:i');?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="sysMemberProfile.php" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="signout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>