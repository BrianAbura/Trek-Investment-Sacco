<!DOCTYPE html>
<html>
<head>
<?php include('headLinks.php');?>
<style>
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
        Dashboard
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
       <!-- First Row-->
	  <div class="row">
    <div class="col-md-3 col-sm-3 col-xs-12" title="Members">
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Members</span>
              <span class="info-box-number"><?php echo sumMembers();?></span>
              <br/>
                  <span class="progress-description dash-green">
                  <a href="allMembers.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12" title="Total Members Savings">
          <div class="info-box bg-green">
            <span class="info-box-icon"> <span class="glyphicon glyphicon-piggy-bank"></span></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Members Savings</span>
              <span class="info-box-number"><?php echo 'UGX '.number_format(sumSavings());?></span>
              <br/>
                  <span class="progress-description dash-green">
                  <a href="savings.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12" title="Current Outstanding Savings">
          <div class="info-box bg-green">
            <span class="info-box-icon"><span class="glyphicon glyphicon-piggy-bank"></span></span>
            <div class="info-box-content">
              <span class="info-box-text">Current Outstanding Savings</span>
              <span class="info-box-number" <?php if(outstandingSavings() != 0) {echo 'style="color:orange"';}?>>
              <?php echo 'UGX '.number_format(outstandingSavings());?></span>
              <br/>
                  <span class="progress-description dash-green">
                  <a style="cursor:pointer" data-toggle="modal" data-target="#viewOutstandingSavings">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12" title="Membership Fee collected">
              <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Membership Fee collected</span>
                  <span class="info-box-number"><?php echo 'UGX '.number_format(sumMemFees()); ?></span>
                  <br/>
                      <span class="progress-description dash-green">
                      <a href="membershipFees.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                      </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
      </div>
        <!-- First Row-->
	  
       <!-- Second Row-->
	   <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12" title="Total Loans Disbursed">
              <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Loans Disbursed</span>
                  <span class="info-box-number"><?php  echo 'UGX '.number_format(totalLoans()); ?></span>
                  <br/>
                      <span class="progress-description dash-blue">
                      <a href="loanRequests.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                      </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12" title="Total Loans Paid">
              <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Loans Paid</span>
                  <span class="info-box-number"><?php echo 'UGX '.number_format(paidLoans()); ?></span>
                  <br/>
                      <span class="progress-description dash-blue">
                      <a href="loanPayments.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                      </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12" title="Current Outstanding Loans">
              <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" style="text-transform:capitalize">Current Outstanding Loans</span>
                  <span class="info-box-number" <?php if(outstandingLoans() != 0) {echo 'style="color:orange"';}?>>
                  <?php echo 'UGX '.number_format(outstandingLoans()); ?>
                </span>
                  <br/>
                      <span class="progress-description dash-blue">
                      <a href="loanRequests.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                      </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12" title="Interests Earned From Loans">
              <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" style="text-transform:capitalize">Interests Earned From Loans</span>
                  <span class="info-box-number"><?php echo 'UGX '.number_format(totalLoanInterests()); ?></span>
                  <br/>
                      <span class="progress-description dash-blue">
                      <a href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                      </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

      </div>
  <!-- End of Second Row End-->
         <!-- Third Row-->
         <div class="row">

         <div class="col-md-3 col-sm-3 col-xs-12" title="Total Welfare Contributions">
              <div class="info-box bg-purple">
                <span class="info-box-icon"><i class="fa fa-diamond"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" style="text-transform:capitalize">Total Welfare Contributions</span>
                  <span class="info-box-number"><?php echo 'UGX '.number_format(sumWelfare()); ?></span>
                  <br/>
                      <span class="progress-description dash-purple">
                      <a href="welfare.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                      </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12" title="Total Expenses">
              <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Expenses</span>
                  <span class="info-box-number"><?php echo 'UGX '.number_format(sumExpenses()); ?></span>
                  <br/>
                      <span class="progress-description dash-red">
                      <a href="expenses.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                      </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12" title="Fines">
              <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-credit-card-alt"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Fines</span>
                  <span class="info-box-number"><?php echo 'UGX '.number_format(sumFines());?></span>
                  <br/>
                      <span class="progress-description dash-green">
                      <a href="fines.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                      </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12" title="Cash at Bank">
              <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-bar-chart-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Investments</span>
                 <span class="info-box-number"><?php echo 'UGX '.number_format(invDeposits() + invInterests() - invWithdraws()); ?></span>
                  <br/>
                      <span class="progress-description dash-blue">
                      <a href="investments.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                      </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
      </div>
  <!-- Third Row End-->
  <div class="row">
  <div class="col-md-3 col-sm-3 col-xs-12" title="Cash at Bank">
              <div class="info-box bg-purple">
                <span class="info-box-icon"><i class="fa fa-bank"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Cash at Bank <i class="fa fa-star" style="color:gold" aria-hidden="true"></i></span>
                  <span class="info-box-number"><?php echo 'UGX '.number_format(sumCashbank());?></span>
                  <br/>
                      <span class="progress-description dash-purple">
                     
                      </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

<div class="col-md-3 col-sm-3 col-xs-12" title="Shared Interests">
     <div class="info-box bg-blue">
       <span class="info-box-icon"><i class="fa fa-money"></i></span>
       <div class="info-box-content">
         <span class="info-box-text" style="text-transform:capitalize">Shared Interests <i class="fa fa-star" style="color:gold" aria-hidden="true"></i></span>
         <span class="info-box-number">.</span>
         <br/>
             <span class="progress-description dash-blue">
             <a style="cursor:pointer" data-toggle="modal" data-target="#viewSharedInterest">View Details <i class="fa fa-arrow-circle-right"></i></a>
             </span>
       </div>
       <!-- /.info-box-content -->
     </div>
     <!-- /.info-box -->
   </div>
</div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!--/View the Shared Interest-->
  <div class="modal fade" id="viewSharedInterest">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header bg-blue">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h5 class="modal-title">Shared Interests per Individual</h5>
		  </div>
		
			<div class="modal-body">
				<table id="example4" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Member</th>
                  <th>Interest Earned</th>
                </tr>
                </thead>
                <tbody>
				<?php
				$cnt=1;
				$totalInterestEarned = 0;
				$members = DB::query('SELECT * from members where AccStatus=%s order by Id desc', 'Active');
				foreach($members as $member){
					$totalSavings = DB::queryFirstRow('SELECT sum(Amount)from savings where MembershipNumber=%s', $member['MembershipNumber']);
					$interestEarned = ($totalSavings['sum(Amount)'] * Interests())/sumSavings();
				?>
				 <tr>
                  <td><?php echo $cnt;?></td>
                  <td><?php echo $member['Fullname'];?></td>
                  <td><?php echo number_format($interestEarned);?></td>
                </tr>
				<?php 
				$cnt++;
				$totalInterestEarned = $totalInterestEarned + $interestEarned;
				}
				?>
				</tbody>
			</table>
			</div>
			<div class="modal-footer">
			<h4 class="pull-left">
			<b>Total: <?php echo 'UGX '.number_format($totalInterestEarned);?></b>
			</h4>
				<button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
</div>
<?php include('externalScripts.php');?>

<!--/View the Savings  Summary-->
<div class="modal fade" id="viewOutstandingSavings">
	  <div class="modal-dialog modal-lg" style="width:80%">
		<div class="modal-content">
		  <div class="modal-header bg-blue">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h5 class="modal-title">Current Outstanding Savings (<?php echo date("d-m-Y");?> )</h5>
		  </div>
		
			<div class="modal-body">
				<table id="example4" class="table table-bordered table-d">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Membership No.</th>
                  <th>Fullname</th>
                  <th>Date Joined</th>
                  <th>Expected Savings</th>
                  
                  <th>Current Savings</th>
                  <th>Outstanding Savings</th>
                </tr>
                </thead>
                <tbody>
				<?php
				$cnt=1;
        $sumExpected = 0;
        $sumCurrent = 0;
        $sumOutstanding = 0;
        $sumFines = 0;
				$members = DB::query('SELECT * from members where AccStatus=%s order by Fullname', 'Active');
				foreach($members as $member){
					$expectedSaving = ExpectedMemberSavings($member['MembershipNumber']);
          $currentSaving = MembersumSavings($member['MembershipNumber']);
          $outstandingSaving = $expectedSaving - $currentSaving;
          //$fines = 0.1 * $expectedSaving;
          if($outstandingSaving > 0){
				?>
				 <tr>
                  <td><?php echo $cnt;?></td>
                  <td><?php echo $member['MembershipNumber'];?></td>
                  <td><?php echo $member['Fullname'];?></td>
                  <td><?php echo date_format(date_create($member['Joining_date']), 'd-m-Y');?></td>
                  <td><?php echo number_format($expectedSaving);?></td>
                  
                  <td><?php echo number_format($currentSaving);?></td>
                  <td <?php if($outstandingSaving > 0){echo 'style="color:maroon"';}?>><?php echo number_format($outstandingSaving);?></td>
                </tr>
				<?php 
				$cnt++;
        $sumExpected += $expectedSaving;
        $sumCurrent += $currentSaving;
        $sumOutstanding += $outstandingSaving;
        //$sumFines += $fines;
				}}
				?>
				</tbody>
          <tfoot>
            <tr style="font-weight:bold; font-size:14px; background-color:#D8FFE1">
            <td></td>
            <td></td>
            <td>Summary: </td>
            <td></td>
            <td><?php echo number_format($sumExpected);?></td>
            
            <td><?php echo number_format($sumCurrent);?></td>
            <td><?php echo number_format($sumOutstanding);?></td>
            </tr>
          </tfoot>
         
			</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
</div>

<!-- Page script -->
<script>
 
    $(function () {
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
	 $('#example3').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
	$('#example4').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</script>
</body>
</html>