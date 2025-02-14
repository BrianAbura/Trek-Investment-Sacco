<!DOCTYPE html>
<html>
<head>
<?php include('headLinks.php');?>
	<style>
  .form-control{
		color:blue;
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
        <li>
          <a href="dashboard.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Members</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="allMembers.php"><i class="fa fa-circle-o"></i> All Members</a></li>
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
        Members
        <?php if($user['Role'] == 4 || $user['Role'] == 1){?>
        <button class="btn btn-primary" style="font-size:12px;cursor:pointer" data-toggle="modal" data-target="#AddNewMember">Add New <i class="fa fa-plus"></i></button>
          <?php }?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Members</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
			 <div class="col-md-12">
			<div class="box box-success">	
			<div class="box-body table-responsive">
        
      <img class="borderDloadImg" src="../dist/img/excel_download.png" title="Export to Excel" onclick="ExportToExcel('example1', 'Members')"/> 	
            <!-- /.box-header -->
			<table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>Membership No.</th>
                <th>FullName</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Residence</th>
                <th>Date Joined</th>
                <th>Last Login</th>
                <th></th>
                </tr>
                </thead>
                <tbody>
				<?php 
        $members = DB::query('SELECT * from members where AccStatus=%s order by Id desc', 'Active');
				foreach($members as $member){
				?>
				 <tr title="Added by: <?php echo $member['CreatedBy'];?>">
          <td><?php echo $member['MembershipNumber'];?></td>
          <td><?php echo $member['Fullname'];?></td>
				  <td><?php echo $member['MSISDN'];?></td>
				  <td><?php echo $member['EmailAddress'];?></td>
          <td><?php echo $member['Residence'];?></td>               
				  <td><?php echo date_format(date_create($member['Joining_date']), 'd-m-Y');?></td>
          <td><?php echo date_format(date_create($member['LastLogin']), 'd-m-Y H:i');?></td>
				  <td><a href="memberProfile.php?MembershipNumber=<?php echo $member['MembershipNumber'];?>" class="label label-warning">VIEW</a></td>
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

  <!-- Add New Admin MOdal-->
<div class="modal fade" id="AddNewMember">
<div class="modal-dialog modal-lg ">
<div class="modal-content ">

<div class="modal-header bg-blue color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title">New Member <i class="fa fa-plus"></i></h5>
      </div>
      <div class="modal-body">
      <form role="form" class="form-content" method="POST" action="ManageMembers.php" enctype="multipart/form-data">
      <input type="hidden" id="MemAction" name="MemAction" value="Add_MEM">
              <div class="box-body">
			<div class="row">
				<div class="form-group col-sm-4">
          <label for="InputName">Fullname</label>
          <input type="text" class="form-control" id="InputName" name="Name" placeholder="Enter Fullname" autocomplete="off" required>
        </div>

        <div class="form-group col-sm-3">
          <label for="exampleInputEmail1">Email Address</label>
          <input type="email" class="form-control" id="exampleInputEmail1" name="EmailAddress" placeholder="Enter Email" required>
        </div>

        <div class="form-group col-sm-3">
          <label for="InputPhone">Phone Number</label>
          <input type="text" class="form-control" id="InputPhone" name="MSISDN" placeholder="Enter Phone Number" autocomplete="off" required>
        </div>
			</div>
      <br/>


      <div class="row">
        <div class="form-group col-sm-4">
          <label for="exampleInputEmail1">National ID / Passport No</label>
          <input type="text" class="form-control" id="exampleInputEmail1" style="text-transform:uppercase" name="IDNum" placeholder="NIN/Passport No." autocomplete="off" required>
        </div>

        <div class="form-group col-sm-4">
          <label for="InputOccupation">Workplace/Employer</label>
          <input type="text" class="form-control" id="InputOccupation" name="Workplace"  placeholder="Current Workplace">
        </div>

        <div class="form-group col-sm-4">
          <label for="InputPhone">Residence</label>
          <input type="text" class="form-control" id="InputPhone" name="Residence" placeholder="Current Residence" >
        </div>
			</div>
				</br>

      <div class="row">
        <div class="form-group col-sm-3">
          <label for="exampleInputEmail1">Postal Address</label>
          <textarea class="form-control" name="Postal_Address" id="Postal_Address" rows="3" cols="5"  ></textarea>
        </div>

        <div class="form-group col-sm-3">
        <label for="datepicker">Date of Joining</label>
        <div class="input-group date">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="text" class="form-control pull-right" name="joining_date" id="datepicker" autocomplete="off" required>
        </div>
        </div>

        <div class="form-group">
          <label class="col-md-4 control-label">Profile Photo</label>
          <div class="col-md-6">
            <div class="fileupload fileupload-new" data-provides="fileupload">
              <div class="input-append">
                <div class="uneditable-input">
                  <span class="fileupload-preview" style="font-size: 12px; color:blue"></span>
                </div>
                <span class="btn btn-default btn-file">
                  <span class="fileupload-exists">Change</span>
                  <span class="fileupload-new">Select file</span>
                  <input type="file" name="ProfilePicture" onchange="ValidateSingleInput(this);"/>
                </span>
                <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                <p class="help-block">Accepted Formats: jpg, jpeg and png</p>
              </div>
            </div>
          </div>
        </div>
			</div>
      <br/>
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
<?php include('externalScripts.php');?>


<script>
  $(function () {
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true,
      todayHighlight: true,
      endDate: "currentDate",
    })
  })
  
    $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
