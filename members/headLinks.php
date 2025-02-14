<?php 
  require_once('../defines/functions.php');
  require_once('../validate.php');
  require_once('functions.php');
  
  $user = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s',$_SESSION['MembershipNumber']);
  $src= "../dist/img/avatar.png";
  if(!empty($user['ProfilePicture'])){
    $src = $user['ProfilePicture'];
  }
  ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>TREK Investment Club</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
 
  <!-- magnific-popup -->
  <link rel="stylesheet" href="../bower_components/magnific-popup/magnific-popup.css" />
  
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- BootstrapFIleUpload -->
  <link rel="stylesheet" href="../bower_components/bootstrap-fileupload/bootstrap-fileupload.min.css" />
  <!-- Fav Icon -->
  <link rel="shortcut icon" type="image/png" href="../dist/img/fav.png"/>

	 <!--Alertfy -->
	<script type="text/javascript" src="../dist/js/alertify.min.js"></script>
	<link rel="stylesheet" type="text/css" media="all" href="../dist/css/alertify.min.css" />
	<link rel="stylesheet" type="text/css" media="all" href="../dist/css/themes/alertifyTheme.min.css" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
   <!-- In-Line Scripts-->
 <link rel="stylesheet" href="../dist/css/Styles-inline.css">

 <style>
  .progress-description a{
    color:aliceblue;
   }
   .dash-green{
     text-align: center;
     background-color:#179059;
   }
   .dash-blue{
     text-align: center;
     background-color:#186795;
   }
   .dash-yellow{
     text-align: center;
     background-color:#a46e19;
   }

   .dash-red{
     text-align: center;
     background-color:#af4639;
   }

   .dash-purple{
     text-align: center;
     background-color:#4d4a86;
   }
   .dash-grey{
     text-align: center;
     background-color:#aca9a9;
   }

   .info-box-number{
     font-size: 20px;
   }
   .info-box-text{
     text-transform: capitalize;
   }
   </style>