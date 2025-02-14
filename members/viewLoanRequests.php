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
            <li class="active"><a href="viewLoanRequests.php"><i class="fa fa-circle-o"></i> View Loan Requests</a></li>
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
            <!-- /.box-header -->
			<table id="example1" class="table table-bordered small">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>LoanType</th>
                  <th>Principal</th>
                  <th>Rate(%)</th>
                  <th>Interest</th>
                  <th>Balance Due</th>
                  <th title="Guarantors">GR</th>
                  <th>Status</th>
                  <th>Date Requested</th>
                  <th>Due Date</th>
                  <th>Action</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
				<?php 
        $sumLoans = 0;
				$loans = DB::query('SELECT * from loanrequests where MembershipNumber=%s order by Id desc', $_SESSION['MembershipNumber']);
				foreach($loans as $loan){
          $loanBalance = $loan['Balance'];
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
                  <td><?php echo $loan['LoanId'];?></td>
                  <td><?php echo $loan['LoanType'];?></td>
                  <td><?php echo number_format($loan['Principal']);?></td>
                  <td><?php echo $loan['Rate'];?></td>
                  <td><?php echo number_format($loan['Interest']);?></td>
                  <td <?php if($loanBalance != 0){echo 'style="color:crimson"';}?>><?php echo number_format($loanBalance);?></td>
                  <td>
                  <i style="cursor:pointer;color:teal;font-size:15px" title="Guarantors List" class="fa fa-user-circle" 
                      onclick="ViewGuarantors('<?php echo $loan['LoanId']?>',
                      '<?php
                          $cnt = 1;
                          $guarantors = DB::query('SELECT * from guarantors where LoanId=%s',$loan['LoanId']);
                          foreach($guarantors as $guarantor){
                          $Guarantor_name = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s',$guarantor['MembershipNumber']);
                          echo $cnt.'. '.$Guarantor_name['Fullname'].' >>> |'. number_format($guarantor['Amount']).'| >>> |'.$guarantor['Status'].'| >> '.$guarantor['Comments'].'<br/>';
                          $cnt++; 
                        }
                      ?>'
                      );">
                  </i>
				        </td>
                  <td><?php echo $loan['Status'];
					  if($loan['Status']=="REJECTED"){
					  ?>
				  <i style="cursor:pointer;color:blue;font-size:15px" title="Reason for Rejection" class="fa fa-info-circle" onclick="ViewReason('<?php echo $loan['LoanId']?>','<?php echo $loan['ApprovalReason']?>');"></i>
					  <?php }?>
				  </td>
                  <td><?php echo date_format(date_create($loan['DateCreated']), 'd-M-Y');?></td>
                  <td><?php echo date_format(date_create($loan['DueDate']), 'd-M-Y');?></td>
                  <td><?php if($loan['Status'] == "PENDING APPROVAL"){
					  ?>
				  <label class="btn btn-danger btn-xs" onclick="delLoanRecord('<?php echo $loan['Id']?>', 'loanrequests', 'Loan Request');">Delete</label>
				      <?php }?>
				  </td>
          <td><a href="#loanSummary" class="label label-danger" data-id="<?php echo $loan['LoanId']?>" data-toggle="modal">View Summary</td>
                </tr>
				<?php 
            if($loan['Status'] == "OUTSTANDING" || $loan['Status'] == "CLEARED"){
              $sumLoans +=$loan['Principal'];
            }
				}
				?>
				</tbody>
        <tfoot>
                  <tr>
                  <td style="background:white"></td>
                    <td >
                    Total Loans Borrowed:
                    </td>
                    <td>
                      <?php echo 'UGX '.number_format($sumLoans);?>
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
$(document).ready(function(){
    $('#loanSummary').on('show.bs.modal', function (e) {
        var LoanID = $(e.relatedTarget).data('id');
        $.ajax({
            type : 'post',
            url : '../scripts/LoanSummary.php', //Here you will fetch records 
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
    $('#example1').DataTable({
      'order'    : [[ 8, "desc" ]]
    })
  })
</script>
<script>
	function delLoanRecord(id,table,ctype){
		//Prompt user to confirm
		alertify.confirm('Delete Record!', 'Are you sure you want to delete this '+ctype+' record?', function(){ 
      var hr = new XMLHttpRequest();
	     var url = "../scripts/deleteRecords.php";
	//Post to file without refreshing page
    var vars = "RowId="+id+"&Table="+table+"&Ctype="+ctype;
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			alertify.alert('Response',return_data);
			function redirect(){window.location.reload();}
			setTimeout(redirect, 3000);
		}	}
    hr.send(vars);
  }, 
  function(){ alertify.error('Action Cancelled')});
		}
</script>
</body>
</html>