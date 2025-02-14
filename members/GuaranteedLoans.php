<!DOCTYPE html>
<html>
<head>
<?php include('headLinks.php');
?>
<style>
	.table-striped>tbody>tr:nth-child(even)>td, 
	.table-striped>tbody>tr:nth-child(even)>th {
	   background-color: #c8f9d3;
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
		
		<li class="treeview active">
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
            <li class="active"><a href="GuaranteedLoans.php"><i class="fa fa-circle-o"></i> Guaranteed Loans</a></li>
          </ul>
        </li>
		
		<li>
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
       Guaranteed Loans
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Guarantee Requests</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
			 <div class="col-md-12">
			<div class="box box-success">	
			<div class="box-body table-responsive">
            <!-- /.box-header -->
			<table id="example1" class="table table-bordered small">
                <thead>
                <tr>
                  <th>Loan Requester</th>
                  <th>Loan Amount</th>
                  <th>Rate(%)</th>
                  <th>Interest</th>
                  <th>Guarantors Contribution *</th>
                  <th>Guarantors Action *</th>
                  <th>Comments</th>
                  <th>Loan Status</th>
                  <th>Date Requested</th>
                </tr>
                </thead>
                <tbody>
				<?php
        $sumGuaranteed = 0;
        $guarantRequests = DB::query('SELECT * from guarantors where MembershipNumber=%s AND NOT(Status=%s) order by Id desc', $_SESSION['MembershipNumber'], 'Pending');
				foreach($guarantRequests as $guarantRequest)
          {
            $loan = DB::queryFirstRow('SELECT * from loanrequests where LoanId=%s', $guarantRequest['LoanId']);
            $member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $loan['MembershipNumber']);
            if($loan['Status'] == "OUTSTANDING"){
              echo "<tr class='warning'>";
            }
            elseif($loan['Status'] == ("PENDING APPROVAL" || "APPROVED")){
              echo "<tr class='info'>";
            }
            elseif($loan['Status'] == "REJECTED"){
              echo "<tr class='danger'>";
            }
            else{
              echo "<tr class='success'>";
              }
      ?>   
                 <td><?php echo $member['Fullname'];?></td>
                  <td><?php echo number_format($loan['Principal']);?></td>
                  <td><?php echo $loan['Rate'];?></td>
                  <td><?php echo number_format($loan['Interest']);?></td>
                  <td style="color:blue"><?php echo number_format($guarantRequest['Amount']);?></td>
                  <td><?php echo $guarantRequest['Status'];?></td>
                  <td><?php echo $guarantRequest['Comments'];?></td>
                  <td><?php 
                      if($guarantRequest['Status'] != 'Declined'){
                        echo $guarantRequest['LoanStatus'];
                      }
                      else{
                        echo "N/A";
                      }
                 ?>
                  </td>
                  <td><?php echo date_format(date_create($loan['DateCreated']), 'd-M-Y');?></td>
              </tr>
				<?php 
         $sumGuaranteed +=$guarantRequest['Amount'];
				}
				?>
				</tbody>
        <tfoot>
                  <tr>
                    <td style="background:white"></td>
                    <td style="background:white"></td>
                    <td style="background:white"></td>
                    <td >
                    Total Guaranteed Loans:
                    </td>
                    <td>
                      <?php echo 'UGX '.number_format($sumGuaranteed);?>
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
    <!-- Modal for loan request summary-->
    <!-- Shows the summary of the loan in Detail-->
    <div class="modal fade" id="loanSummary">
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
<!-- End of Modal for loan request summary-->
<script>
    $(function () {
      $('#example1').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : false,
      'info'        : true,
      'autoWidth'   : true,
      'order'    : false
    })
  })
</script>
</body>
</html>