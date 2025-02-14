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
            <li class="active"><a href="expenses.php"><i class="fa fa-circle-o"></i> Expenses</a></li>
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
      Expenses
      <?php if($user['Role'] == 2 || $user['Role'] == 3 || $user['Role'] == 4){?>
        <button class="btn btn-primary" style="font-size:12px;cursor:pointer" data-toggle="modal" data-target="#AddNewTransaction">Add New Expense <i class="fa fa-plus"></i></button>
     <?php }?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Administrative Fees</li>
        <li class="active">Expenses</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
			 <div class="col-md-12">
			<div class="box box-success">	
			<div class="box-body table-responsive">

      <form class="searchFilter" id="searchFilter" method="POST" action="expenses.php" >
  <div class="form-row ">
    <div class="col-md-2">
      <input type="text" class="form-control datepicker" placeholder="Filter From" name="dateFrom" id="dateFrom" required autocomplete="off">
    </div>
    <div class="col-md-2">
      <input type="text" class="form-control datepicker" placeholder="Filter To" name="dateTo" id="dateTo" required autocomplete="off">
    </div>

    <div class="col-md-2">
    <button class="btn btn-primary" type="submit">Search</button> <i title="Refresh Page" onClick="location.href='expenses.php'"  class="fa fa-refresh" style="margin-left:10px; color:green; font-weight:bold; cursor:pointer; font-size:16px"></i>
    </div>
  </div>
 <?php 
   if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
     echo "<p>Data filtered from { ".date_format(date_create($_POST['dateFrom']),"d-m-Y")." to ".date_format(date_create($_POST['dateTo']),"d-m-Y")." }</p>";
   }
 ?>
</form>
        

      <img class="borderDloadImg" src="../dist/img/excel_download.png" title="Export to Excel" onclick="ExportToExcel('example1', 'Expenses')"/> 
            <!-- /.box-header -->
			<table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>#</th>
                <th>Amount</th>
                <th>Narration</th>
                <th>Receipt</th>
                <th>Transaction Date</th>
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
                  $expenses = DB::query('SELECT * from expenses where TransactionDate >=%s AND TransactionDate <=%s order by DateAdded', $dateFrom, $dateTo);
                }
                else{
                  $expenses = DB::query('SELECT * from expenses order by TransactionDate desc', 'Boat');
                }
                foreach($expenses as $expense){
                ?>
                  <tr title="Added by: <?php echo $expense['AddedBy'];?>">
                  <td><?php echo $cnt;?></td>
                  <td><?php echo number_format($expense['Amount']);?></td>
                  <td><?php echo $expense['Narration'];?></td>
                  <td>
                  <?php 
                    if($expense['ReceiptImage'] != NULL){
                  ?>
                    <a href="#" class="pop">
                    <img class="img-responsive borderImg" src="<?php echo $expense['ReceiptImage'];?>" width="30" height="50">
										</a>
                  <?php 
                    }
                    else{
                  ?>  
                    <i class="fa fa-warning" style="color:orange" title="No Attachment"></i>
										</a>
                    <?php } ?>
                </td> 
                  
                  <td><?php echo date_format(date_create($expense['TransactionDate']), 'd-m-Y');?></td>
                  <td>
                  <?php if(($user['Role'] == 3 || $user['Role'] == 4) && $expense['AddedBy'] != "SYS_AUTO"){?>
                  <button title="Edit Expense" href="#editExpense" data-id="<?php echo $expense['Id']?>" data-toggle="modal" class="btn btn-primary btn-xs">EDIT</button>
                <?php }?>  
                </td>
                  </tr>
                <?php
                $cnt ++;
                $sum += $expense['Amount'];
                }
                ?>
                </tbody>
                <tfoot>
              <tr style="font-weight:bold; font-size:14px; background-color:#DAE5FF">
              <td class="text-center">Total Expenses:</td>
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
<div class="modal-dialog modal-lg">
<div class="modal-content ">

<div class="modal-header bg-green color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title">Add Expenses</h5>
      </div>
      <div class="modal-body">
      <form role="form" class="form-content" method="POST" action="ManageExpenses.php" enctype="multipart/form-data">
      <input type="hidden" value="ADD" name="expenseType">
            <div class="box-body">
			<div class="row">
                <div class="form-group col-sm-3">
                <label for="exampleInputEmail1">Amount</label>
                <input type="text" min="0" class="form-control CommaAmount" id="Amount" name="Amount" autocomplete="off" requred>
                </div>

                <div class="form-group col-sm-4">
                <label for="InputOccupation">Narration</label>
                <input type="text" class="form-control" id="Narration" name="Narration" requred>
                </div>

                <div class="form-group col-sm-3">
                <label for="datepicker">Transaction Date</label>
                <div class="input-group date">
                <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right datepicker" name="transaction_date" autocomplete="off" required>
                </div>
                </div>
			</div>
<br/>
      <div class="row">
      <div class="form-group">
                <label class="col-md-5 control-label">Receipt Photo</label>
                <div class="col-md-10">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="input-append">
                        <div class="uneditable-input">
                        <span class="fileupload-preview" style="font-size: 12px; color:blue"></span>
                        </div>
                        <span class="btn btn-default btn-file">
                        <span class="fileupload-exists">Change</span>
                        <span class="fileupload-new">Select file</span>
                        <input type="file" id="InputReceiptImg" name="ReceiptImage" onchange="ValidateSingleInput(this);" required/>
                        </span>
                        <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                        <p class="help-block">Accepted Formats: jpg, jpeg and png</p>
                    </div>
                    </div>
                </div>
                </div>
      </div>
            </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Add Expense</button>
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
<div class="modal fade" id="editExpense">
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
    $('#editExpense').on('show.bs.modal', function (e) {
        var expenseID = $(e.relatedTarget).data('id');
        $.ajax({
            type : 'post',
            url : 'Modal_expenses.php', //Here you will fetch records 
            data :  'expenseID='+ expenseID, //Pass $id
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
            }
        });
     });
});
</script>
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

  $(function() {
		$('.pop').on('click', function() {
			$('.imagepreview').attr('src', $(this).find('img').attr('src'));
			$('#imagemodal').modal('show');   
		});		
});
</script>
</body>
</html>
