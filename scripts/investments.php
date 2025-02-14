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
<body class="hold-transition skin-blue sidebar-mini">
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
      <li><a href="administrativeMembers.php"><i class="fa fa-circle-o"></i> Administrative Members</a></li>
    </ul>
  </li>

  <!--Investments-->	
  <li class="active">
    <a href="investments.php">
    <i class="fa fa-money"></i>
      <span>Investments</span>
    </a>
  </li> <!-- //Shares-->	

  <!--Welcfare-->	
    <li>
    <a href="welfare.php">
      <i class="fa fa-star"></i>
      <span>Welfare</span>
      <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
    </a>
  </li> <!-- //Shares-->	

  <li class="treeview">
    <a href="#">
        <span class="glyphicon glyphicon-piggy-bank"></span>
        <span>Savings</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="active"><a href="savings.php"><i class="fa fa-circle-o"></i> Savings</a></li>
      <li><a href="fines.php"><i class="fa fa-circle-o"></i> Fines</a></li>
    </ul>
  </li> <!-- //Savings-->
  
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
      <li><a href="bankcharges.php"><i class="fa fa-circle-o"></i> Bank Charges</a></li>
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
Investments
<?php if($user['Role'] == 1 || $user['Role'] == 3 || $user['Role'] == 4){?>
  <button class="btn bg-purple" style="font-size:12px;cursor:pointer" data-toggle="modal" data-target="#AddNewInvestment">Add New <i class="fa fa-plus"></i></button>
  <?php }?>
</h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">Investments</li>
</ol>
</section>

<!-- Main content -->
<section class="content">
<div class="row">
  <div class="col-md-12">
<div class="box box-primary">	
<div class="box-body table-responsive">
      <!-- /.box-header -->
<table id="example2" class="table table-bordered table-striped">
          <thead>
          <tr>
          <th>#</th>
          <th>Investment Name</th>
          <th>Type</th>
          <th>Initiation Date</th>
          </tr>
          </thead>
          <tbody>
        <?php 
          $cnt = 1;
          $investments = DB::query('SELECT * from investments order by investment_name');
          foreach($investments as $item){
              ?>
              <tr class="tr_parent" title="Added by: <?php echo $item['AddedBy'];?>">
                  <td><?php echo $cnt;?></td>    
                  <td><a href="investment_details.php?investment_id=<?php echo $item['id'];?>" class="text-bold"><?php echo $item['investment_name'];?></a></td>
                  <td><?php echo $item['investment_type'];?></td>
                  <td><?php echo date_format(date_create($item['investment_date']), 'd-m-Y');?></td> 
              </tr>
                <?php
                $cnt++;
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
<div class="modal fade" id="AddNewInvestment">
<div class="modal-dialog modal-lg ">
<div class="modal-content ">

<div class="modal-header bg-purple color-palette">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span></button>
<h5 class="modal-title">Add New Investment</h5>
</div>
<div class="modal-body">
<form role="form" class="form-content" method="POST" action="ManageInvestment.php" enctype="multipart/form-data">
<input type="hidden" id="InvestAction" name="investment_action" value="Add_New_Investment">
      <div class="box-body">
<div class="row">

<div class="form-group col-sm-5">
  <label for="SelectMem">Name of Investment</label>
  <input type="text" name="investment_name" id="investment_name" class="form-control" required>
</div>

<div class="form-group col-sm-3">
<label for="SelectMem">Type of Investment</label>
<select class="form-control" name="investment_type" id="investment_type" required>
<option></option>
<option value="Annuities">Annuities</option>
<option value="Bonds">Bonds</option>
<option value="Certificates of Deposit">Certificates of Deposit</option>
<option value="Commodities">Commodities</option>
<option value="Collectables">Collectables</option>
<option value="Cryptocurrencies">Cryptocurrencies</option>
<option value="Exchange-Traded Funds">Exchange-Traded Funds</option>
<option value="Fixed Income">Fixed Income</option>
<option value="Government Bonds">Government Bonds</option>
<option value="Hedge Funds">Hedge Funds</option>
<option value="Insurance">Insurance</option>
<option value="Mutual Funds">Mutual Funds</option>
<option value="Peer-to-Peer Lending">Peer-to-Peer Lending</option>
<option value="Real Estate">Real Estate</option>
<option value="Savings Accounts">Savings Accounts</option>
<option value="Stocks">Stocks</option>
<option value="Other">Other</option>
</select>
</div>

<div class="form-group col-sm-3">
  <label for="initiation_date">Initiation Date</label>
  <input type="text" class="form-control pull-right datepicker" name="investment_date" autocomplete="off" required>
</div>
</div>
      </div>
      <br/>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-success">Add Investment</button>
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
//DataTables  
$(function () {
     //Date picker
$('.datepicker').datepicker({
autoclose: true,
todayHighlight: true,
})

$('#summaryTable').DataTable()
$('#example2').DataTable({
'paging'      : true,
'lengthChange': [true],
'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
'searching'   : true,
'ordering'    : true,
'info'        : true,
'autoWidth'   : false
})
})
</script>
</body>
</html>
