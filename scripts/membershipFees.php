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
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-money"></i> <span>Administrative Fees</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="fines.php"><i class="fa fa-circle-o"></i> Fines</a></li>
            <li><a href="expenses.php"><i class="fa fa-circle-o"></i> Expenses</a></li>
            <li class="active"><a href="membershipFees.php"><i class="fa fa-circle-o"></i> Membership Fees</a></li>
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
      Membership Fees/Subscription
       <?php if($user['Role'] == 2 || $user['Role'] == 3 || $user['Role'] == 4){?>
        <button class="btn btn-primary" style="font-size:12px;cursor:pointer" data-toggle="modal" data-target="#AddNewTransaction">Add Membership Fees <i class="fa fa-plus"></i></button>
        <?php }?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Administrative Fees</li>
        <li class="active">Membership Fees</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
			 <div class="col-md-12">
			<div class="box box-success">	
			<div class="box-body table-responsive">

      <form class="searchFilter" id="searchFilter" method="POST" action="membershipFees.php" >
  <div class="form-row ">
    <div class="col-md-2">
      <input type="text" class="form-control datepicker" placeholder="Filter From" name="dateFrom" id="dateFrom" required autocomplete="off">
    </div>
    <div class="col-md-2">
      <input type="text" class="form-control datepicker" placeholder="Filter To" name="dateTo" id="dateTo" required autocomplete="off">
    </div>

    <div class="col-md-2">
    <button class="btn btn-primary" type="submit">Search</button> <i title="Refresh Page" onClick="location.href='membershipFees.php'"  class="fa fa-refresh" style="margin-left:10px; color:green; font-weight:bold; cursor:pointer; font-size:16px"></i>
    </div>
  </div>
 <?php 
   if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
     echo "<p>Data filtered from { ".date_format(date_create($_POST['dateFrom']),"d-m-Y")." to ".date_format(date_create($_POST['dateTo']),"d-m-Y")." }</p>";
   }
 ?>
</form>
        

      <img class="borderDloadImg" src="../dist/img/excel_download.png" title="Export to Excel" onclick="ExportToExcel('example1', 'Membership Fees')"/> 
            <!-- /.box-header -->
			<table id="example1" class="table table-bordered table-striped">
      <thead>
                <tr>
                <th>#</th>
                <th>Membership No.</th>
                <th>Fullname</th>
                <th>Amount Paid</th>
                <th>Narration</th>
                <th>Payment Date</th>
                <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $cnt = 1;
                $sum = 0; 
                if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
                  $dateFrom = date_format(date_create($_POST['dateFrom']),"Y-m-d");
                  $dateTo = date_format(date_create($_POST['dateTo']),"Y-m-d");
                  $memFees = DB::query('SELECT * from membershipfees where DateAdded >=%s AND DateAdded <=%s order by DateAdded', $dateFrom, $dateTo);
                }
                else{
                  $memFees = DB::query('SELECT * from membershipfees order by DateAdded desc', 'Boat');
                }
                foreach($memFees as $memFee){
                  $member = DB::queryFirstRow('SELECT Fullname from members where MembershipNumber=%s and AccStatus=%s', $memFee['MembershipNumber'], 'Active');
                  if($member){
                ?>
                  <tr title="Added by: <?php echo $memFee['CreatedBy'];?>">
                  <td><?php echo $cnt;?></td>
                  <td><?php echo $memFee['MembershipNumber'];?></td>
                  <td><?php echo $member['Fullname'];?></td>
                  <td><?php echo number_format($memFee['Amount']);?></td> 
                  <td><?php echo $memFee['Narration'];?></td>         
                  <td><?php echo date_format(date_create($memFee['DateAdded']), 'd-m-Y');?></td>
                  <td>
                   <?php if($user['Role'] == 2 || $user['Role'] == 3 || $user['Role'] == 4){?>  
                  <button title="Edit Membership Fee" href="#editMemFees" data-id="<?php echo $memFee['Id']?>" data-toggle="modal" class="btn btn-primary btn-xs">EDIT</button>
                <?php }?>  
                </td>
                  </tr>
                <?php
                $cnt ++;
                $sum += $memFee['Amount'];
                   }
                }
                ?>
                </tbody>
                <tfoot>
              <tr style="font-weight:bold; font-size:14px; background-color:#DAE5FF">
              <td></td>
              <td></td>
              <td class="text-center">Total Membership Fee + Annual Subscription:</td>
              <td colspan="1"><?php echo number_format($sum);?></td>
              </tr>
          </tfoot>
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
<div class="modal fade" id="AddNewTransaction">
<div class="modal-dialog modal-lg" style="width:60%">
<div class="modal-content ">

<div class="modal-header bg-green color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title">Add Membership Fees/Annual Subscription</h5>
      </div>
      <div class="modal-body">
      <form role="form" class="form-content" method="POST" action="ManageMemFees.php" enctype="multipart/form-data">
      <input type="hidden" value="ADD" name="memFeeType">
            <div class="box-body">
			<div class="row">

                <div class="form-group col-sm-3">
                <label for="SelectMem">Member</label>
                <select class="form-control" name="MembershipNumber" id="MembershipNumber" required>
                <option></option>
                <?php 
                $members = DB::query('SELECT * from members where AccStatus=%s order by Fullname', 'Active');
                foreach($members as $member){
                ?>
                <option value="<?php echo $member['MembershipNumber'];?>"><?php echo $member['Fullname'];?></option>
                <?php }?>
                </select>
                </div>

                <div class="form-group col-sm-3">
                <label for="SelectMem">Narration</label>
                <select class="form-control" name="Narration" id="Narration" required>
                <option></option>
                <option value="Membership Fees">Membership Fees</option>
                <option value="Annual">Annual Subscription</option>
                </select>
                </div>

                <div class="form-group col-sm-3" id="subscription_year_tab">
                <label for="datepicker">Subscription Year</label>
                <div class="input-group date">
                <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="subscription_year" name="subscription_year" autocomplete="off">
                </div>
                </div>

                <div class="form-group col-sm-3">
                <label for="exampleInputEmail1">Amount</label>
                <input type="text" min="0" class="form-control CommaAmount" id="Amount" name="Amount" autocomplete="off" requred>
                </div>
		  	</div>
<br/>
      <div class="row">
                <div class="form-group col-sm-3">
                <label for="datepicker">Payment Date</label>
                <div class="input-group date">
                <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right datepicker" name="transaction_date" autocomplete="off" required>
                </div>
                </div>
			</div>
            </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Add Transaction</button>
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

<!-- Edit Savings Modal-->
<div class="modal fade" id="editMemFees">
    <div class="modal-dialog modal-lg">
    <div class="modal-content ">

    <div class="fetched-data"></div> <!--Fetched Header and body-->
      
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <script>
$(document).ready(function(){
    $('#editMemFees').on('show.bs.modal', function (e) {
        var MemFeeID = $(e.relatedTarget).data('id');
        $.ajax({
            type : 'post',
            url : 'Modal_memFees.php', //Here you will fetch records 
            data :  'MemFeeID='+ MemFeeID, //Pass $id
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
            }
        });
     });
});
</script>

<script>
  $(function () {
    //Date picker
    $('.datepicker').datepicker({
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

    //NarrationYear
    $(function () {
    //Date picker
    $('#subscription_year').datepicker({
      autoclose: true,
	  minViewMode: 2,
	  format: "yyyy",
	  minDate: new Date(),
    })

  })
</script>
<script>
  var Narration = document.getElementById("Narration");
  var subscription_year_tab = document.getElementById("subscription_year_tab");

  subscription_year_tab.style.display = "none";

  Narration.onchange = function(){
  if(Narration.value == "Annual"){
    subscription_year_tab.style.display = "block";
  }
  else{
    subscription_year_tab.style.display = "none";
  }
}
</script>
</body>
</html>