<!DOCTYPE html>
<html>
<head>
<?php include('headLinks.php');?>
	<style>
	.table-striped>tbody>tr:nth-child(even)>td, 
	.table-striped>tbody>tr:nth-child(even)>th {
	   background-color: #c8f9d3;
	 }
   .borderImg{
    border: 1px solid navy;
    width:  25px;
    height: 20px;
    object-fit: cover
   }
   tfoot>tr {
  background: #E0E0E0;
  font-weight: bold;
  font-size: 13px;
  color:midnightblue;
  text-align: justify;
}
	</style>
</head>
<body class="hold-transition skin-green sidebar-mini">
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
		<li>
          <a href="memberProfile.php">
            <i class="fa fa-user"></i> <span>Profile</span>
          </a>
        </li>
        <!--Welfare-->
        <li>
          <a href="viewWelfare.php">
          <i class="fa fa-diamond"></i> <span>Welfare</span>
          </a>
        </li>
           <!--Savings-->
		    <li>
          <a href="viewSavings.php">
          <span class="glyphicon glyphicon-piggy-bank"></span> <span>Savings</span>
          </a>
        </li>
		
		<li class="treeview">
          <a href="#">
          <span class="glyphicon glyphicon-list-alt"></span>
            <span>Loan Requests</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
              <?php 
				if(GuaranteeRequests($_SESSION['MembershipNumber']) != 0)
				{
				?>
			  <small class="label pull-right bg-red">
				<?php 
				echo number_format(GuaranteeRequests($_SESSION['MembershipNumber']));
				?>
			  </small>
				<?php 
				}
				?>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="requestLoan.php"><i class="fa fa-circle-o"></i> Request for a Loan</a></li>
            <li><a href="viewLoanRequests.php"><i class="fa fa-circle-o"></i> View Loan Requests</a></li>
            <li><a href="GuaranteeRequests.php"><i class="fa fa-circle-o"></i> Guarantee Requests  
            <?php 
				if(GuaranteeRequests($_SESSION['MembershipNumber']) != 0)
				{
				?>
			  <small class="label pull-right bg-red">
				<?php 
				echo number_format(GuaranteeRequests($_SESSION['MembershipNumber']));
				?>
			  </small>
				<?php 
				}
				?>
          </a></li>
            <li><a href="GuaranteedLoans.php"><i class="fa fa-circle-o"></i> Guaranteed Loans</a></li>
          </ul>
        </li>
		
		<li class="active">
          <a href="viewLoanPayments.php">
          <span class="glyphicon glyphicon-list-alt"></span> <span>Loan Payments</span>
          </a>
        </li>
		<li>
          <a href="signout.php">
            <i class="fa fa-power-off"></i> <span>Sign out</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
     <section class="content-header">
      <h1>
		
        Loan Payments 
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">View Loan Payments</li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="row">
			 <div class="col-md-12">
			<div class="box box-success">	
			<div class="box-body table-responsive">
            <!-- /.box-header -->
			<table id="example1" class="table table-bordered table-striped small">
                <thead>
                <tr>
                  <th>Loan ID</th>
                  <th>Loan Type</th>
                  <th>Loan Amount</th>
                  <th>Installment Paid</th>
                  <th>Current Balance</th>
                  <th>Payment Mode</th>
                  <th>Payment Receipt</th>
                  <th>Payment Date</th>
                </tr>
                </thead>
                <tbody>
				<?php 
        $sumPayments = 0;
				$loans = DB::query('SELECT * from loanpayments where MembershipNumber=%s order by Id desc',$_SESSION['MembershipNumber']);
				foreach($loans as $loan){
				?>
				<tr>
                  <td><?php echo $loan['LoanId'];?></td>
                  <td><?php echo $loan['LoanType'];?></td>
                  <td><?php echo number_format($loan['TotalAmount']);?></td>
                  <td><?php echo number_format($loan['AmountPaid']);?></td>
                  <td><?php echo number_format($loan['Balance']);?></td>
                  <td><?php echo $loan['PaymentMode'];?></td>
                  <td>
                  <?php 
                    if($loan['PaymentReceipts'] != NULL){
                  ?>
                    <a class="image-popup-no-margins" href="<?php echo $loan['PaymentReceipts'];?>">
                    <img class="img-responsive borderImg" src="<?php echo $loan['PaymentReceipts'];?>" width="30">
										</a>
                  <?php 
                    }
                    else{
                  ?>  
                    <i class="fa fa-warning" style="color:orange" title="No Attachment"></i>
										</a>
                    <?php } ?>
                </td>
                  <td><?php echo date_format(date_create($loan['PaymentDate']), 'd-m-Y');?></td>
                </tr>
				<?php 
        $sumPayments+=$loan['AmountPaid'];
					}
				?>
				</tbody>
        <tfoot>
                  <tr>
                  <td style="background:white"></td>
                  <td style="background:white"></td>
                    <td>
                    Total Loan Payments: 
                    </td>
                    <td>
                     <?php echo 'UGX '.number_format($sumPayments);?>
                    </td>
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
  </div>
  <!-- /.content-wrapper -->
<?php include('../scripts/externalScripts.php');?>
<script>
    $(function () {
    $('#example1').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>