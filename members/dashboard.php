<!DOCTYPE html>
<html>
<head>
<?php include('headLinks.php');?>
<style>
.inner h3{
	font-size: 30px;
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
        <li class="active">
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
  <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
  
	<section class="content">
      <!-- Basic Information -->

       <!-- First Row General Information-->
	  <div class="row">
       <div class="col-md-4 col-sm-3 col-xs-12" title="Name and Membership Number">
          <div class="info-box bg-blue">
          <div class="small-box">
            <div class="inner">
			      <p>Name and Membership Number</p>
			        <h3 style="font-size:20px"><?php echo $user['Fullname']."<br/>".''.$_SESSION['MembershipNumber'];?></h3>
            </div>
          </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-4 col-sm-3 col-xs-12" title="Monthly Savings Premium">
          <div class="info-box bg-green">
            <span class="info-box-icon"> <span class="glyphicon glyphicon-piggy-bank"></span></span>
            <div class="info-box-content">
              <span class="info-box-text">Monthly Savings Premium</span>
              <span class="info-box-number"><?php echo 'UGX 200,000';?></span>
              <br/>
                  <span class="progress-description dash-green">
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-4 col-sm-3 col-xs-12" title="Total Loans Borrowed">
          <div class="info-box bg-yellow">
            <span class="info-box-icon"> <i class="fa fa-money"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Loans Borrowed</span>
              <span class="info-box-number"><?php echo 'UGX '.number_format(LoansRequests($_SESSION['MembershipNumber']));?></span>
              <br/>
                  <span class="progress-description dash-yellow">
                  <a href="viewLoanRequests.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
    </div>
      
        <!-- Row 2 Svings Details-->
      <div class="row">
      <div class="col-md-4 col-sm-3 col-xs-12" title="Total Welfare Contributions">
          <div class="info-box bg-blue">
            <span class="info-box-icon"> <i class="fa fa-diamond"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Welfare Contribution</span>
              <span class="info-box-number"><?php echo number_format(TotalWelfare($_SESSION['MembershipNumber']));?></span>
              <br/>
                  <span class="progress-description dash-blue">
                  <a href="viewWelfare.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>


        <div class="col-md-4 col-sm-3 col-xs-12" title="Total Savings to Date">
          <div class="info-box bg-green">
            <span class="info-box-icon"> <span class="glyphicon glyphicon-piggy-bank"></span></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Savings to Date</span>
              <span class="info-box-number"><?php echo 'UGX '.number_format(TotalSavings($_SESSION['MembershipNumber']));?></span>
              <br/>
                  <span class="progress-description dash-green">
                  <a href="viewSavings.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-4 col-sm-4 col-xs-12" title="Total Loans Paid">
          <div class="info-box bg-yellow">
            <span class="info-box-icon"> <i class="fa fa-money"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Loans Paid</span>
              <span class="info-box-number"><?php echo 'UGX '.number_format(LoanPayments($_SESSION['MembershipNumber']));?></span>
              <br/>
                  <span class="progress-description dash-yellow">
                  <a href="viewLoanPayments.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

    </div>

           <!-- Row 3 Loan Details-->
           <div class="row">
           <div class="col-md-4 col-sm-4 col-xs-12" title="Total Loans Guaranteed">
          <div class="info-box bg-blue">
            <span class="info-box-icon"> <i class="fa fa-money"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Loans Guaranteed</span>
              <span class="info-box-number"><?php echo 'UGX '.number_format(LoanGuaranteed($_SESSION['MembershipNumber']));?></span>
              <br/>
                  <span class="progress-description dash-blue">
                  <a href="GuaranteedLoans.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        
        <?php 
        $outStandingSaving = ExpectedMemberSavings($_SESSION['MembershipNumber']) - MembersumSavings($_SESSION['MembershipNumber']);
        if(MembersumSavings($_SESSION['MembershipNumber']) > ExpectedMemberSavings($_SESSION['MembershipNumber']) ){
          $val = 0;
        }
        elseif($outStandingSaving < 0){
          $val = "+".number_format(-$outStandingSaving);
        }
        else{
          $val = number_format($outStandingSaving);
        }
        ?>
        
        
        <div class="col-md-4 col-sm-3 col-xs-12" title="Current Outstanding Savings">
          <div class="info-box bg-green">
            <span class="info-box-icon"> <span class="glyphicon glyphicon-piggy-bank"></span></span>
            <div class="info-box-content">
              <span class="info-box-text">Current Outstanding Savings</span>
              <span class="info-box-number" <?php if($outStandingSaving !=0) {echo 'style="color:orange"';}?>
              ><?php echo 'UGX '.$val;?></span>
              <br/>
                  <span class="progress-description dash-green">
                  <a href="viewSavings.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        
        <div class="col-md-4 col-sm-3 col-xs-12" title="Current Outstanding Loan">
          <div class="info-box bg-yellow">
            <span class="info-box-icon"> <i class="fa fa-money"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Current Outstanding Loan Balance</span>
              <span class="info-box-number" 
              <?php if(MemOutstandingLoans($_SESSION['MembershipNumber']) !=0) {echo 'style="color:crimson"';}?>
              
              ><?php echo 'UGX '.number_format(MemOutstandingLoans($_SESSION['MembershipNumber']));?></span>
              <br/>
                  <span class="progress-description dash-yellow">
                  <a href="viewLoanRequests.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      </div>

      <!-- Row 3 Loan Details-->
      <div class="row">

        <div class="col-md-4 col-sm-4 col-xs-12" title="Total Loans Paid">
          <div class="info-box bg-red">
            <span class="info-box-icon"> <i class="fa fa-money"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Fines</span>
              <span class="info-box-number"><?php echo 'UGX '.number_format(TotalFines($_SESSION['MembershipNumber']));?></span>
              <br/>
                  <span class="progress-description dash-red">
                  <a style="cursor:pointer" data-toggle="modal" data-target="#viewFines">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
          
      </div>
		

	</section>
  </div>
  <!-- /.content-wrapper -->


  <div class="modal fade" id="viewFines">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header bg-blue">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h5 class="modal-title">Summary of Fines</h5>
		  </div>
		
			<div class="modal-body">
				<table id="example4" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Amount</th>
                  <th>Narration</th>
                  <th>Date</th>
                </tr>
                </thead>
                <tbody>
                <?php
                  $cnt=1;
                  $totalFines = 0;
                  $fines = DB::query('SELECT * from fines where MembershipNumber=%s order by Id desc', $_SESSION['MembershipNumber']);
                  foreach($fines as $fine){
                    $totalFines = $totalFines + $fine['Amount'];
                  ?>
                  <tr>
                            <td><?php echo $cnt;?></td>
                            <td><?php echo number_format($fine['Amount']);?></td>
                            <td><?php echo $fine['Narration'];?></td>
                            <td><?php echo date_format(date_create($fine['TransactionDate']), 'd-m-Y');?></td>
                          </tr>
                  <?php 
                  $cnt++;
                  //$totalFines ++;
                  }
                  ?>
               </tbody>
        </table>
			</div>
			<div class="modal-footer">
			<h4 class="pull-left">
			<b>Total: <?php echo 'UGX '.number_format($totalFines);?></b>
			</h4>
				<button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
</div>

<?php include('../scripts/externalScripts.php');?>
</body>
</html>