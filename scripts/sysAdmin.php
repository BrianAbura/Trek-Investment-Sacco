<!DOCTYPE html>
<html>
<head>
<?php include('headLinks.php');?>
	<style>
	.form-control{
		color:blue;
	}
	.btn-danger a{
		color:#fff;
	}
  .table-striped>tbody>tr:nth-child(even)>td, 
	.table-striped>tbody>tr:nth-child(even)>th {
	   background-color: #c8f9d3;
	 }
	</style>

</head>
<body class="hold-transition skin-black sidebar-mini">
<div class="wrapper">

<?php include('header.php');?>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">NAVIGATION</li>
        <li class="active">
          <a href="dashboard.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Members</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="allMembers.php"><i class="fa fa-circle-o"></i> All Members</a></li>
			      <li><a href="inactiveMembers.php"><i class="fa fa-circle-o"></i> Inactive Members</a></li>
          </ul>
        </li>

        <!--Welfare-->	
        <li>
          <a href="welfare.php">
            <i class="fa fa-diamond"></i>
            <span>Welfare</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
        </li> <!-- //Welfare-->		

        <!--Savings-->	
        <li>
          <a href="savings.php">
          <span class="glyphicon glyphicon-piggy-bank"></span>
            <span>Savings</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
        </li> <!-- //Savings-->	
        
        <!--Investments-->	
        <li>
          <a href="investments.php">
            <i class="fa fa-dollar"></i>
            <span>Investments</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li><!-- //Investments-->	

        <!--Loan Requests-->	
	    	<!--Loan Requests-->	
        <li>
          <a href="loanRequests.php">
          <span class="glyphicon glyphicon-list-alt"></span>
            <span>Loan Requests</span>
            <?php 
            if(PendingApprovals($user['Role']) != 0)
            {
            ?>
            <small class="label pull-right bg-red">
            <?php 
            echo number_format(PendingApprovals($user['Role']));
            ?>
            </small>
            <?php 
            }
            ?>
          </a>
        </li>

        <!--Loan Payments-->	
		<li>
          <a href="loanPayments.php">
          <span class="glyphicon glyphicon-list-alt"></span>
            <span>Loan Payments</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-money"></i> <span>Administrative Fees</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="fines.php"><i class="fa fa-circle-o"></i> Fines</a></li>
            <li><a href="expenses.php"><i class="fa fa-circle-o"></i> Expenses</a></li>
            <li><a href="membershipFees.php"><i class="fa fa-circle-o"></i> Membership Fees</a></li>
          </ul>
        </li> <!-- //Admin Fees-->
          <!-- //Notifications-->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-bell-o"></i> <span>Notifications</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview"><a href="#"><i class="fa fa-circle-o"></i>
            <span>SMS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="sms.php"><span class="glyphicon glyphicon-send"></span></i> Sent SMS</a></li>
            <li><a href="scheduledSMS.php"><span class="glyphicon glyphicon-list-alt"></span> Scheduled SMS</a></li>
          </ul>
         </li>
         <li class="treeview"><a href="#"><i class="fa fa-circle-o"></i>
            <span>Email</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="email.php"><span class="glyphicon glyphicon-send"></span></i> Sent Emails</a></li>
            <li><a href="scheduledEmail.php"><span class="glyphicon glyphicon-list-alt"></span> Scheduled Emails</a></li>
          </ul>
         </li>
          </ul>
        </li><!-- //Notifications-->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Administrators
        <button class="btn btn-primary" style="font-size:12px;cursor:pointer" data-toggle="modal" data-target="#AddNewAdmin">Add New <i class="fa fa-plus"></i></button>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Administrators</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
			 <div class="col-md-12">
			<div class="box box-success">	
			<div class="box-body table-responsive">
            <!-- /.box-header -->
			<table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Fullname</th>
                  <th>Email Address</th>
                  <th>Role</th>
                  <th>Last Login</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
				<?php 
				$sysusers = DB::query('SELECT * from systemusers');
				foreach($sysusers as $sysuser){
          $role = DB::queryFirstRow('SELECT Designation as Role from roles where RoleId=%s', $sysuser['Role']);
				?>
				 <tr>
                  <td><?php echo $sysuser['AccId'];?></td>
                  <td><?php echo $sysuser['Fullname'];?></td>
                  <td><?php echo $sysuser['EmailAddress'];?></td>
                  <td><?php echo $role['Role'];?></td>
                  <td><?php echo date_format(date_create($sysuser['LastLogin']), 'd-M-Y H:i');?></td>
                  <td>
                  <?php if($user['Role'] == 4){?>
                  <span><a class="btn btn-xs btn-primary">Edit</a></span>
                  <span><a class="btn btn-xs btn-danger" onclick="delRecord(<?php echo $sysuser['Id']?>, 'systemusers', 'Administrator');" >Delete</a></span>
                  <?php } ?>
                  </td>
                 
                </tr>
				<?php 
				}
				?>
				</tbody>
			</table>
          </div>
          </div>
          <!-- /.box -->
			 </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include('externalScripts.php');?>

<!-- Add New Admin MOdal-->
<div class="modal fade" id="AddNewAdmin">
<div class="modal-dialog modal-lg">
<div class="modal-content ">

<div class="modal-header bg-blue color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title">Add New Administrator</h5>
      </div>
      <div class="modal-body">
      <form role="form" class="form-content" action="ManageSysAdmin.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" class="form-control" id="ActionType" name="ActionType" value="ADD">
      <div class="box-body">
			  <div class="row">
        <div class="form-group col-sm-4">
          <label for="InputName">Fullname</label>
          <select class="form-control" id="sysMember" name="sysMember" required>
            <option> </option>
            <?php 
            $members = DB::query('SELECT * from members where AccStatus=%s', "Active");
            foreach($members as $member){
            ?>
            <option value="<?php echo $member['MembershipNumber']?>"> <?php echo $member['Fullname']?></option>
            <?php } ?>
				  </select>
        </div>

        <div class="form-group col-sm-4">
          <label for="InputPosition">Role</label>
				  <select class="form-control" id="sysRole" name="sysRole" required>
            <option> </option>
            <?php 
            $sysRoles = DB::query('SELECT * from roles');
            foreach($sysRoles as $sysRole){
            ?>
            <option value="<?php echo $sysRole['RoleId']?>"> <?php echo $sysRole['Designation']?></option>
            <?php } ?>
				  </select>
         </div>
      </div>

				<!-- /.First Row -->
        </div>
        <!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-success">Add Member</button>
        <button type="reset" class="btn btn-default">Reset</button>
      </div>
    </form>  
      </div>
  
  <div class="modal-footer">
    <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
  </div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
    <!-- End of Modal for loan request summary-->



<script> 
    $(function () {
    $('#example1').DataTable()
  })
</script>
</body>
</html>