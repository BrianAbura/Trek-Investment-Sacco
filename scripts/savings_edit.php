<!DOCTYPE html>
<html>
<head>
<?php include('headLinks.php');?>
	<style>
  .form-control{
		color:blue;
	}
   .borderImg{
    border: 1px solid navy;
    width:  25px;
    height: 20px;
    object-fit: cover
   }
   .tr_parent{
    background-color: #F5F5F5;
    cursor: pointer;
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
        <li class="active">
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
    <!-- Main content -->
    <section class="content">
      <div class="row">
			 <div class="col-md-12">
			<div class="box box-primary">	
<?php
 if(isset($_REQUEST['SavingsId'])) { //Incase Editing Savings
  $SavingsId = htmlspecialchars(( isset( $_REQUEST['SavingsId'] ) )?  $_REQUEST['SavingsId']: null);
  $Saving = DB::queryFirstRow('SELECT * from savings where SavingsId=%s', $SavingsId);
  $member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $Saving['MembershipNumber']);
  $narration = explode(" ",$Saving['Narration']);
  $NarMonth = $narration[2];
  $NarYear = $narration[3];
?>
<!--Edit Savings modal-->
<div class="modal-header bg-navy color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title">Edit Savings for <?php echo $member['Fullname']." - ".$member['MembershipNumber'];?></h5>
      </div>
      <div class="modal-body">
      <form role="form" class="form-content" method="POST" action="ManageSavings.php" enctype="multipart/form-data">
      <input type="hidden" id="SavingAction" name="SavingAction" value="Edit_Saving">
      <input type="hidden" id="EditSavingsId" name="EditSavingsId" value="<?php echo $SavingsId;?>">
            <div class="box-body">
			<div class="row">
                <div class="form-group col-sm-3">
                  <label for="InputAmount">Amount</label>
                  <input type="text" class="form-control CommaAmount" id="InputAmount" name="Amount" value="<?php echo number_format($Saving['Amount'])?>" autocomplete="off" required>
                </div>
				
				
			    <div class="form-group col-sm-3">
                  <label for="SelectMod">Mode of Saving</label>
				  <select class="form-control" name="SavingMode" id="SelectMod">
				  <option selected="selected" value="<?php echo $Saving['SavingMode']?>"><?php echo "{".$Saving['SavingMode']."}" ;?></option>
                  <option value="Bank Deposit">Bank Deposit</option>
				  </select>
                </div>
				
				<div class="form-group col-sm-3">
                <label for="datepicker">Saving Narration</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="NarrationMonth" id="NarrationMonth" value="<?php echo $NarMonth;?>" required>
                  <input type="text" class="form-control pull-right" name="NarrationYear" id="NarrationYear" value="<?php echo $NarYear;?>" required>
                </div>
              </div>

              <div class="form-group col-sm-3">
                <label for="datepicker">Saving Date</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="SavingDate" id="datepicker" value="<?php echo date_format(date_create($Saving['SavingDate']), 'd-m-Y');?>" required>
                </div>
              </div>
			</div>

            <div class="row">
              <div class="form-group col-sm-3">
                <label for="InputReceipt">Receipt Number</label>
                <input type="text" class="form-control" id="InputReceipt" style="text-transform:uppercase" name="ReceiptNumber" value="<?php echo $Saving['ReceiptNumber']?>" />
              </div>

                <div class="form-group">
                <label class="col-md-6 control-label">Receipt Photo</label>
                <div class="col-md-8">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="input-append">
                        <div class="uneditable-input">
                        <span class="fileupload-preview" style="font-size: 12px; color:blue"></span>
                        </div>
                        <span class="btn btn-default btn-file">
                        <span class="fileupload-exists">Change</span>
                        <span class="fileupload-new">Select file</span>
                        <input type="file" id="InputReceiptImg" name="ReceiptImage" onchange="ValidateSingleInput(this);"/>
                        </span>
                        <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                        <?php echo str_replace('../fileUploads/receipts', '', $Saving['ReceiptImage']);?>
                        <p class="help-block">Accepted Formats: jpg, jpeg and png</p>
                    </div>
                    </div>
                </div>
                </div>
			</div>

            </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-success">Update Saving Information</button>
                <a href="savings.php" type="cancel" class="btn btn-danger">Cancel</a>
              </div>
            </form> 
      </div>
<?php }
?>
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
<!-- View More Details-->

<script>
  //NarrationYear
   $(function () {
    //Date picker Year
    $('#NarrationYear').datepicker({
      autoclose: true,
	  minViewMode: 2,
	  format: "yyyy",
	  minDate: new Date(),
    })

        //Date picker Month
    $('#NarrationMonth').datepicker({
    autoclose: true,
	  minViewMode: 1,
	  format: "MM",
    })

     //Date picker Standard
    $('#datepicker').datepicker({
      autoclose: true,
      todayHighlight: true,
      endDate: "currentDate",
    })

  })
</script>
</body>
</html>