
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
	    <li class="active">
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
          <!--Loan Requests-->	

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
        Loan Requests 
		<h6>
		<label>
		<i class="fa fa-square-o btn-info"></i>
		Pending Approval
		</label>
		<label>
		<i class="fa fa-square-o btn-warning"></i>
		Outstanding
		</label>
		<label>
		<i class="fa fa-square-o btn-danger"></i>
		Rejected
		</label>
		<label>
		<i class="fa fa-square-o btn-success"></i>
		Cleared
		</label>
		</h6>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">View Loan Requests</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
			 <div class="col-md-12">
			<div class="box box-success">	
			<div class="box-body table-responsive">

      <form class="searchFilter" id="searchFilter" method="POST" action="loanRequests.php" >
  <div class="form-row ">
    <div class="col-md-2">
      <input type="text" class="form-control datepicker2" placeholder="Filter From" name="dateFrom" id="dateFrom" required autocomplete="off">
    </div>
    <div class="col-md-2">
      <input type="text" class="form-control datepicker2" placeholder="Filter To" name="dateTo" id="dateTo" required autocomplete="off">
    </div>

    <div class="col-md-2">
    <button class="btn btn-primary" type="submit">Search</button> <i title="Refresh Page" onClick="location.href='loanRequests.php'"  class="fa fa-refresh" style="margin-left:10px; color:green; font-weight:bold; cursor:pointer; font-size:16px"></i>
    </div>
  </div>
 <?php 
   if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
     echo "<p>Data filtered from { ".date_format(date_create($_POST['dateFrom']),"d-m-Y")." to ".date_format(date_create($_POST['dateTo']),"d-m-Y")." }</p>";
   }
 ?>
</form>
        
      <img class="borderDloadImg" src="../dist/img/excel_download.png" title="Export to Excel" onclick="ExportToExcel('tabletoExport', 'Loan Requests')"/> 
            <!-- /.box-header -->			
            <table id="example1" class="table table-bordered">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Member</th>
                  <th>Type</th>
                  <th>Principal</th>
                  <th>Rate(%)</th>
                  <th>Interest</th>
                  <th>Total Amount</th>
                  <th>Balance Due</th>
                  <th title="Guarantors">GR</th>
                  <th>Status</th>
                  <th>Due Date</th>
                  <th>Action</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
				<?php
        $sum_principal = 0;
        $sum_interest = 0;
        $sum_balance = 0;
        if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
          $dateFrom = date_format(date_create($_POST['dateFrom']),"Y-m-d");
          $dateTo = date_format(date_create($_POST['dateTo']),"Y-m-d");
          $loans = DB::query('SELECT * from loanrequests where DateCreated >=%s AND DateCreated <=%s order by Id', $dateFrom, $dateTo);
        }
        else{
          $loans = DB::query('SELECT * from loanrequests order by Id desc');
        }

				foreach($loans as $loan){
          $member = DB::queryFirstRow('SELECT Fullname from members where AccStatus=%s AND MembershipNumber=%s', 'Active', $loan['MembershipNumber']);
          $approval = DB::queryFirstRow('SELECT * from loanapprovals where LoanId=%s order by Id desc', $loan['LoanId']);
          $approver_role = DB::queryFirstRow('SELECT Designation from roles where RoleId=%s', $approval['RoleId']);
          $apprMsg = $approval['Status'];
         
                if($loan['Status'] == "REJECTED"){ echo "<tr class='danger'>"; }
                elseif($loan['Status'] == "OUTSTANDING"){ echo "<tr class='warning'>"; }
                elseif($loan['Status'] == "PENDING APPROVAL" || $loan['Status'] == "APPROVED"){ echo "<tr class='info'>"; }
                else{ echo "<tr class='success'>";  }
          if($member){
				?>
                  <td><?php echo $loan['LoanId'];?></td>
                  <td><?php echo $member['Fullname'];?></td>
                  <td><?php echo $loan['LoanType'];?></td>
                  <td><?php echo number_format($loan['Principal']);?></td>
                  <td><?php echo $loan['Rate'];?></td>
                  <td><?php echo number_format($loan['Interest']);?></td>
                  <td><?php echo number_format($loan['TotalAmount']);?></td>
                  <td <?php if($loan['Balance'] != 0){echo 'style="color:crimson"';}?>><?php echo number_format($loan['Balance']);?></td>
                  <td>
                  <i style="cursor:pointer;color:teal;font-size:15px" title="Guarantors List" class="fa fa-user-circle" 
                      onclick="ViewGuarantors('<?php echo $loan['LoanId']?>',
                      '<?php
                          $cnt = 1;
                          $accepted_gurantors = 0;
                          $sum_guaranteed = 0;
                          $declined_gurantors = 0;
                          $guarantors = DB::query('SELECT * from guarantors where LoanId=%s', $loan['LoanId']);
                          $guarantor_count = DB::count();
                          foreach($guarantors as $guarantor){
                          $Guarantor_name = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s',$guarantor['MembershipNumber']);
                          echo $cnt.'. '.$Guarantor_name['Fullname'].' >>> |'. number_format($guarantor['Amount']).'| >>> |'.$guarantor['Status'].'| >> '.$guarantor['Comments'].'<br/>';
                          $cnt++;
                          $sum_guaranteed += $guarantor['Amount'];
                          if($guarantor['Status'] == 'Accepted'){
                          $accepted_gurantors++;
                          }
                          else if($guarantor['Status'] == 'Declined'){
                            $declined_gurantors++;
                          }

                        }
                        echo '<br/>';
                        echo 'Guarantors: <b>'.$guarantor_count.'</b> | <span>Amount Guaranteed:</span> <b>'.number_format($sum_guaranteed).'</b> | <span>Accepted:</span> <b>'.$accepted_gurantors.'</b> | Declined: <b>'.$declined_gurantors.'</b>';
                      ?>'
                      );">
                  </i>
				        </td>
                <td><?php echo $loan['Status'];
                  if($loan['Status']=="REJECTED"){
                  ?>
                    <i style="cursor:pointer;color:blue;font-size:15px" title="Reason for Rejection" class="fa fa-info-circle" onclick="ViewReason('<?php echo $loan['LoanId']?>','<?php echo $approval['Narration']?>');"></i>
                  <?php 
                    }
                  ?>
              </td>
              <td><?php echo date_format(date_create($loan['DueDate']), 'd-m-Y');?></td>

                <!--This part has to be handled based the role-->
                  <td title="<?php echo $apprMsg; ?>">
                      <?php 
                      //Chairperson or Treasurer
                      if(($approval['RoleId'] == $user['Role'])){
                        if(($loan['Status'] == "PENDING APPROVAL") && ($accepted_gurantors == $guarantor_count)){ #Accepted Guarantors
                        ?>
                          <label class="btn btn-success btn-xs" onclick="ApproveLoan('<?php echo $loan['LoanId']?>','APPROVED');">Approve</label>
                          <label class="btn btn-danger btn-xs" onclick="RejectLoan('<?php echo $loan['LoanId']?>','REJECTED');">Reject</label>
                        <?php 
                        }
                        else if(($loan['Status'] == "PENDING APPROVAL") && ($declined_gurantors > 0)){ #More Rejected Gurantors
                        ?>
                          <label class="btn btn-danger btn-xs" onclick="RejectLoan('<?php echo $loan['LoanId']?>','REJECTED');">Reject</label>
                        <?php }
                              ?>
                            <?php 
                      }
                      else{
                        echo "";
                      }  
                      ?>
               <!--//This part has to be handled based the role-->
                  </td>
            

              <td><a href="#loanSummary" class="label label-danger" data-id="<?php echo $loan['LoanId']?>" data-toggle="modal">View Summary</td>
          </tr>
				<?php
        if($loan['Status'] == "OUTSTANDING" || $loan['Status'] == "CLEARED"){
          $sum_principal += $loan['Principal'];
          $sum_interest += $loan['Interest'];
          $sum_balance += $loan['Balance'];
        }
        
      }

			  	}
				?>
			</tbody>
      <tfoot>
          <tr style="font-weight:bold; font-size:14px; background-color:#c0c0c0">

          <td colspan="3" class="text-center">Summary: <br><small>(Cleared + Outstanding)</small></td>
          <td colspan=""><?php echo number_format($sum_principal);?></td>
          <td colspan=""></td>
          <td colspan=""><?php echo number_format($sum_interest);?></td>
          <td colspan=""></td>
          <td colspan="2" <?php if($sum_balance != 0){echo 'style="color:#CC0000"';}?>><?php echo number_format($sum_balance);?></td>
          </tr>
      </tfoot>
			</table>


          <!--Table to Export-->
      <table id="tabletoExport" class="table table-bordered hidden">
                <thead>
                <tr>
                  <th>Loan ID</th>
                  <th>AccNum</th>
                  <th>Fullname</th>
                  <th>Loan Type</th>
                  <th>Principal</th>
                  <th>Rate(%)</th>
                  <th>Interest</th>
                  <th>Total Amount</th>
                  <th>Balance Due</th>
                  <th>Status</th>
                  <th>Due Date</th>
                  <th>Date Requested</th>
                </tr>
                </thead>
                <tbody>
				<?php
        $sum_principal = 0;
        $sum_interest = 0;
        $sum_balance = 0;


        if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
          $dateFrom = date_format(date_create($_POST['dateFrom']),"Y-m-d");
          $dateTo = date_format(date_create($_POST['dateTo']),"Y-m-d");
          $loans = DB::query('SELECT * from loanrequests where DateCreated >=%s AND DateCreated <=%s order by Id', $dateFrom, $dateTo);
        }
        else{
          $loans = DB::query('SELECT * from loanrequests order by Id desc');
        }

			
				foreach($loans as $loan){
          $member = DB::queryFirstRow('SELECT * from members where AccStatus=%s AND MembershipNumber=%s', 'Active', $loan['MembershipNumber']);
				?>
        <tr>
                  <td><?php echo $loan['LoanId'];?></td>
                  <td><?php echo $member['MembershipNumber'];?></td>
                  <td><?php echo $member['Fullname'];?></td>
                  <td><?php echo $loan['LoanType'];?></td>
                  <td><?php echo number_format($loan['Principal']);?></td>
                  <td><?php echo $loan['Rate'];?></td>
                  <td><?php echo number_format($loan['Interest']);?></td>
                  <td><?php echo number_format($loan['TotalAmount']);?></td>
                  <td <?php if($loan['Balance'] != 0){echo 'style="color:crimson"';}?>><?php echo number_format($loan['Balance']);?></td>
                <td><?php echo $loan['Status'];?></td>
              <td><?php echo date_format(date_create($loan['DueDate']), 'd-m-Y');?></td>
              <td><?php echo date_format(date_create($loan['DateCreated']), 'd-m-Y');?></td>
          </tr>
				<?php
        $sum_principal += $loan['Principal'];
        $sum_interest += $loan['Interest'];
        $sum_balance += $loan['Balance'];
			  	}
				?>
			</tbody>
      <tfoot>
          <tr style="font-weight:bold; font-size:14px; background-color:#c0c0c0">
         <td></td><td></td><td></td>
          <td class="text-center">Summary:</td>
          <td><?php echo number_format($sum_principal);?></td>
          <td></td>
          <td><?php echo number_format($sum_interest);?></td>
          <td></td>
          <td <?php if($sum_balance != 0){echo 'style="color:#CC0000"';}?>><?php echo number_format($sum_balance);?></td>
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

<?php include('externalScripts.php');?>




<script>
$(document).ready(function(){
    $('#loanSummary').on('show.bs.modal', function (e) {
        var LoanID = $(e.relatedTarget).data('id');
        $.ajax({
            type : 'post',
            url : 'LoanSummary.php', //Here you will fetch records 
            data :  'LoanID='+ LoanID, //Pass $id
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
            }
        });
     });
});
</script>
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

<div class="modal fade" id="imagemodal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">              
    <div class="modal-body">
      <button type="button" class="close" data-dismiss="modal"><span style="color:red" aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <img src="" class="imagepreview" style="width: 100%;">
    </div>
  </div>
</div>
</div>

<!-- Page script -->
<script>
	function ViewReason(LoanId,Reason){
		//Prompt user to confirm
		alertify.alert('#'+LoanId+' - Reason for Rejection.',Reason);	
		}
  
  function ViewGuarantors(LoanId,List){
  //Prompt user to confirm
  alertify.alert('Loan #'+LoanId+' - Guarantors',List);	
  }
</script>

<script>
  $(function () {
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
  })
  
    $(function () {
    $('#example2').DataTable({
      'order'    : [[ 9, "desc" ]]
    })
    $('#example1').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'order'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
<script>
//Approve Loan
	function ApproveLoan(LoanId,Status){
		//Prompt user to confirm
		alertify.prompt('Approve Loan','Please provide a comment','', function(evt, Promptreason){ 
		 var hr = new XMLHttpRequest();
	     var url = "LoanApprovals.php";
	//Post to file without refreshing page
    var vars = "LoanId="+LoanId+"&Status="+Status+"&Reason="+Promptreason;
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			alertify.alert('Response',return_data);
			function redirect(){window.location.reload();}
			setTimeout(redirect, 8000);
		}	}
    hr.send(vars);
		}, function(){  });		
		}
</script>
<script>
//Reject Loan
	function RejectLoan(LoanId,Status){
		//Prompt user to confirm
		alertify.prompt('Reject Loan','Please give a reason for rejecting this loan.','', function(evt, Promptreason){ 
		 var hr = new XMLHttpRequest();
	     var url = "LoanApprovals.php";
	//Post to file without refreshing page
    var vars = "LoanId="+LoanId+"&Status="+Status+"&Reason="+Promptreason;
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			alertify.alert('Response',return_data);
			function redirect(){window.location.reload();}
			setTimeout(redirect, 5000);
		}	}
    hr.send(vars);
		}, function(){  });	
		}
</script>
</body>
</html>