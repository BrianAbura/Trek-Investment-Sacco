<?php
session_start();
require_once('cspheader.php');
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TREK Investment Club</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.css">
  <!-- Fav Icon -->
  <link rel="shortcut icon" type="image/png" href="dist/img/fav.png">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic" rel="stylesheet" type="text/css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="#"><strong>TREK INVESTMENT CLUB</strong></a>
  </div>
	
  <div class="register-box-body">
	<h3 class="login-box-msg">Welcome!</h3>
	<!--Alerts Starts -->
	<?php
	if(isset($_SESSION['Success'])){
	?>
	<div class="alert alert-success alert-dismissible small">
    <label class="close" data-dismiss="alert" aria-hidden="true">&times;</label>
    <i class="icon fa fa-check"></i>
    <?php echo $_SESSION['Success'];?>
    </div>
	<?php 
		unset($_SESSION['Success']);
		}else if(isset($_SESSION['Error'])){
	?>
	<div class="alert alert-danger alert-dismissible small">
    <label class="close" data-dismiss="alert" aria-hidden="true">&times;</label>
    <i class="icon fa fa-ban"></i>
    <?php echo $_SESSION['Error'];?>
    </div>
	<?php 
	unset($_SESSION['Error']);
		}
	?>
	<!--Alerts End -->
	<br/>
      <div class="row">
        <!-- /.col -->
       <div class="col-xs-6">
          <button type="submit" class="btn bg-olive btn-block btn-flat" data-toggle="modal" data-target="#modal-members"><i class="fa fa-users"></i> Members</button>
       </div>
	   <div class="col-xs-6">
          <button type="submit" class="btn bg-purple btn-block btn-flat" data-toggle="modal" data-target="#modal-admin"><i class="fa fa-user-secret"></i> Administrators</button>
       </div>
        <!-- /.col -->
      </div>
	  <hr/>
	  <br/>
  </div>
</div>

<!-- Member Login-->
<div class="modal fade" id="modal-members">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header bg-olive">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h5 class="modal-title">Members Login</h3>
		  </div>
		<form action="login.php" method="post" enctype="multipart/form-data">
			<div class="modal-body">
				<div class="form-group has-feedback">
				<input type="hidden" name="type" value="member">
				<input type="email" class="form-control" placeholder="Email Address" name="email" autocomplete="on" required>
				<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
				<input type="password" class="form-control" placeholder="Password" name="password" autocomplete="off" required>
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				<a href="" data-toggle="modal" data-dismiss="modal" data-target="#forgot-pass-member-modal">Forgot my password</a>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn bg-olive">Login</button>
			</div>
		</form>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
</div>
<!-- ../Member Login-->


<!-- Forgot Member Login-->
<div class="modal fade" id="forgot-pass-member-modal">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header bg-olive">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h5 class="modal-title">Member Forgot Password</h3>
		  </div>
		<form action="forgotPassword.php" method="post" enctype="multipart/form-data">
		<div class="modal-body">
			<span><a>Enter Email Address or Mobile Number to reset your password</a></span><br/>
				<div class="form-group has-feedback">
				<input type="hidden" name="type" value="Member">
				<input type="text" class="form-control" placeholder="johnsmith@gmail.com or 2567xxxxxxx" name="emailPhone" autocomplete="off" required>
				<span class="glyphicon glyphicon-refresh form-control-feedback"></span>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn bg-olive">Submit</button>
			</div>
		</form>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
</div>
<!-- ../Member Login-->


<!-- Admin Login-->
<div class="modal fade" id="modal-admin">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header bg-purple">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h5 class="modal-title">Administrators Login</h3>
		  </div>
		<form action="login.php" method="post" enctype="multipart/form-data">
			<div class="modal-body">
				<div class="form-group has-feedback">
				<input type="hidden" name="type" value="admin">
				<input type="email" class="form-control" placeholder="Email Address" name="email" autocomplete="on" required>
				<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
				<input type="password" class="form-control" placeholder="Password" name="password" autocomplete="off" required>
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				<a href="" data-toggle="modal" data-dismiss="modal" data-target="#forgot-pass-admin-modal">Forgot my password</a>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn bg-purple">Login</button>
			</div>
		</form>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
</div>
<!-- ../admin Login-->


<!-- Forgot Admin Pass_Login-->
<div class="modal fade" id="forgot-pass-admin-modal">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header bg-purple">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h5 class="modal-title">Administrator Forgot Password</h3>
		  </div>
		<form action="forgotPassword.php" method="post" enctype="multipart/form-data">
			<div class="modal-body">
			<span><a>Enter Email Address or Mobile Number to reset your password</a></span><br/>
				<div class="form-group has-feedback">
				<input type="hidden" name="type" value="Admin">
				<input type="text" class="form-control" placeholder="johnsmith@gmail.com or 2567xxxxxxx" name="emailPhone" autocomplete="off" required>
				<span class="glyphicon glyphicon-refresh form-control-feedback"></span>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn bg-purple">Submit</button>
			</div>
		</form>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
</div>
<!-- ../admin Login-->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
