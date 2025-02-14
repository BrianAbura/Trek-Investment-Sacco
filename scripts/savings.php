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
    <section class="content-header">
      <h1>
      Savings
      <?php if($user['Role'] == 2 || $user['Role'] == 3 || $user['Role'] == 4){?>
        <button class="btn btn-primary" style="font-size:12px;cursor:pointer" data-toggle="modal" data-target="#AddNewMember">Add New <i class="fa fa-plus"></i></button>
        <?php }?>
        <label class="label label-success" style="font-size:12px;cursor:pointer" data-toggle="modal" data-target="#viewOutstandingSavings">View Summary</label>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Savings</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
			 <div class="col-md-12">
			<div class="box box-primary">	
			<div class="box-body table-responsive">


      <form class="searchFilter" id="searchFilter" method="POST" action="savings.php" >
  <div class="form-row ">
    <div class="col-md-2">
      <input type="text" class="form-control datepicker" placeholder="Filter From" name="dateFrom" id="dateFrom" required autocomplete="off">
    </div>
    <div class="col-md-2">
      <input type="text" class="form-control datepicker" placeholder="Filter To" name="dateTo" id="dateTo" required autocomplete="off">
    </div>

    <div class="col-md-2">
    <button class="btn btn-primary" type="submit">Search</button> <i title="Refresh Page" onClick="location.href='savings.php'"  class="fa fa-refresh" style="margin-left:10px; color:green; font-weight:bold; cursor:pointer; font-size:16px"></i>
    </div>
  </div>
 <?php 
   if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
     echo "<p>Data filtered from { ".date_format(date_create($_POST['dateFrom']),"d-m-Y")." to ".date_format(date_create($_POST['dateTo']),"d-m-Y")." }</p>";
   }
 ?>
</form>
        

      <img class="borderDloadImg" src="../dist/img/excel_download.png" title="Export to Excel" onclick="ExportToExcel('exportTable', 'Members Savings')"/>
            <!-- /.box-header -->
			<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>#</th>
                <th>Membership No.</th>
                <th>Fullname</th>
                <th>Total Amount Saved</th>
                <th></th>
                </tr>
                </thead>
                <tbody>
			      	<?php 
                $allSavings = 0;
                $cnt = 1;
                $members = DB::query('SELECT * from members where AccStatus=%s order by Fullname', 'Active');
                foreach($members as $member){
                  $sum_savings = 0;

                  if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
                    $dateFrom = date_format(date_create($_POST['dateFrom']),"Y-m-d");
                    $dateTo = date_format(date_create($_POST['dateTo']),"Y-m-d");
                    $savings = DB::query('SELECT * from savings where MembershipNumber=%s AND SavingDate >=%s AND SavingDate <=%s ', $member['MembershipNumber'], $dateFrom, $dateTo);
                  }
                  else{
                    $savings = DB::query('SELECT * from savings where MembershipNumber=%s', $member['MembershipNumber']);
                  }
                  foreach($savings as $saving){
                      $sum_savings += $saving['Amount'];
                  }
                  if(!empty($savings)){
                    ?>
                    <tr class="tr_parent">
                        <td><?php echo $cnt;?></td>    
                        <td><?php echo $member['MembershipNumber'];?></td>
                        <td><?php echo $member['Fullname'];?></td>
                        <td><?php echo number_format($sum_savings);?></td>
                        <td><label title="View More Details" href="#viewDetails" data-id="<?php echo $member['MembershipNumber']?>" data-toggle="modal" class="label label-warning">View</label></td>
                    </tr>
                     <?php
                     $cnt++;
                       }
                    $allSavings += $sum_savings;
                      } 
                    ?>
				</tbody>
        <tfoot>
                    <tr style="font-weight:bold; font-size:14px; background-color:#D8FFE1">
                    <td colspan="2"></td>
                    <td class="text-center">Total Savings:</td>
                    <td colspan="2"><?php echo number_format($allSavings);?></td>
                    </tr>
                </tfoot>
			</table>

<!--Export Table Hidden-->
<table id="exportTable" class="table table-bordered hidden">
                <thead>
                <tr>
                <th>#</th>
                <th>Membership No.</th>
                <th>Fullname</th>
                <th>Amount</th>
                <th>Narration</th>
                <th>Saving Mode</th>
                <th>Savings Date</th>
                <th>Date Added</th>
                <th></th>
                </tr>
                </thead>
                <tbody>
                    
                <?php 
                $totalSavings = 0;
                $cnt = 1;
                    if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
                      $dateFrom = date_format(date_create($_POST['dateFrom']),"Y-m-d");
                      $dateTo = date_format(date_create($_POST['dateTo']),"Y-m-d");
                      $savings = DB::query('SELECT * from savings where SavingDate >=%s AND SavingDate <=%s order by MembershipNumber', $dateFrom, $dateTo);
                    }
                    else{
                      $savings = DB::query('SELECT * from savings order by MembershipNumber');
                    }
                    
                    foreach($savings as $saving){
                        $member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $saving['MembershipNumber']);
                ?>
                <tr class="tr_parent">
                    <td><?php echo $cnt;?></td>    
                    <td><?php echo $saving['MembershipNumber'];?></td>
                    <td><?php echo $member['Fullname'];?></td>
                    <td><?php echo number_format($saving['Amount']);?></td>
                    <td><?php echo $saving['Narration'];?></td>
                    <td><?php echo $saving['SavingMode'];?></td>
                    <td><?php echo date_format(date_create($saving['SavingDate']), 'd-m-Y');?></td>
                    <td><?php echo date_format(date_create($saving['DateCreated']), 'd-m-Y');?></td>
                </tr>
                 <?php
                 $cnt++;

                $totalSavings += $saving['Amount'];
                  } 
                ?>
                </tbody>
                <tfoot>
                    <tr style="font-weight:bold; font-size:14px; background-color:#D8FFE1">
                    <td></td>
                    <td></td>
                    <td class="text-center">Summary:</td>
                    <td><?php echo number_format($totalSavings);?></td>
                    </tr>
                </tfoot>
                </table>
                <!--Export Table Hidden-->

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
<div class="modal fade" id="AddNewMember">
<div class="modal-dialog modal-lg ">
<div class="modal-content ">

<div class="modal-header bg-navy color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title">Add Members Savings</h5>
      </div>
      <div class="modal-body">
      <form role="form" class="form-content" method="POST" action="ManageSavings.php" enctype="multipart/form-data">
      <input type="hidden" id="SavingAction" name="SavingAction" value="Add_New_Savings">
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
                  <label for="InputAmount">Amount</label>
                  <input type="text" class="form-control CommaAmount" id="InputAmount" name="Amount" placeholder="Enter Amount" autocomplete="off" required>
                </div>
				
				
			    <div class="form-group col-sm-3">
                  <label for="SelectMod">Mode of Saving</label>
				  <select class="form-control" name="SavingMode" id="SelectMod">
				  <option value="Bank Deposit">Bank Deposit</option>
				  </select>
                </div>
				
				<div class="form-group col-sm-3">
                <label for="datepicker">Saving Narration</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="NarrationMonth" id="NarrationMonth" placeholder="Select Month" autocomplete="off" required>
                  <input type="text" class="form-control pull-right" name="NarrationYear" id="NarrationYear" placeholder="Select Year" autocomplete="off" required>
                </div>
              </div>
			</div>

            <div class="row">				
				<div class="form-group col-sm-3">
                <label for="datepicker">Saving Date</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right datepicker" name="SavingDate" autocomplete="off" required>
                </div>
              </div>

              <div class="form-group col-sm-3">
                <label for="InputReceipt">Receipt Number</label>
                <input type="text" class="form-control" id="InputReceipt" style="text-transform:uppercase" name="ReceiptNumber" autocomplete="off" />
              </div>

                <div class="form-group">
                <label class="col-md-4 control-label">Receipt Photo</label>
                <div class="col-md-6">
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
                <button type="submit" class="btn btn-success">Add Saving</button>
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
<!-- View More Details-->
<div class="modal fade" id="viewDetails">
    <div class="modal-dialog modal-lg" style="width: 80%">
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
    $('#viewDetails').on('show.bs.modal', function (e) {
        var MembershipNumber = $(e.relatedTarget).data('id');
        $.ajax({
            type : 'post',
            url : 'Modal_savings.php', //Here you will fetch records 
            data :  'MembershipNumber='+ MembershipNumber, //Pass $id
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
            }
        });
     });
});
</script>

<!-- Edit Savings Modal-->
<div class="modal fade" id="editSavings">
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
    $('#editSavings').on('show.bs.modal', function (e) {
      $('#viewDetails').modal('hide');
        var SavingsId = $(e.relatedTarget).data('id');
        $.ajax({
            type : 'post',
            url : 'Modal_savings.php', //Here you will fetch records 
            data :  'SavingsId='+ SavingsId, //Pass $id
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


<!--/View the Savings  Summary-->
<div class="modal fade" id="viewOutstandingSavings">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header bg-blue">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h5 class="modal-title">Summary of Members Savings</h5>
		  </div>
		
			<div class="modal-body">
				<table id="example4" class="table table-bordered">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Membership No.</th>
                  <th>Fullname</th>
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
				$members = DB::query('SELECT * from members where AccStatus=%s order by Fullname', 'Active');
				foreach($members as $member){
					$expectedSaving = ExpectedMemberSavings($member['MembershipNumber']);
          $currentSaving = MembersumSavings($member['MembershipNumber']);
          $outstandingSaving = $expectedSaving - $currentSaving;
          if($outstandingSaving < 0){
              
            $sumOutstanding -= $outstandingSaving;
            $val = "+".number_format(-$outstandingSaving);
          }
          else{
            $val = number_format($outstandingSaving);
          }
				?>
				 <tr>
                  <td><?php echo $cnt;?></td>
                  <td><?php echo $member['MembershipNumber'];?></td>
                  <td><?php echo $member['Fullname'];?></td>
                  <td><?php echo number_format($expectedSaving);?></td>
                  <td><?php echo number_format($currentSaving);?></td>
                  <td <?php if($outstandingSaving > 0){echo 'style="color:maroon"';} elseif($outstandingSaving < 0){echo 'style="color:green"';}?>><?php echo $val;?></td>
                </tr>
				<?php 
				$cnt++;
        $sumExpected += $expectedSaving;
        $sumCurrent += $currentSaving;
        $sumOutstanding += $outstandingSaving;
				}
				?>
				</tbody>
          <tfoot>
            <tr style="font-weight:bold; font-size:14px; background-color:#D8FFE1">
            <td></td>
            <td></td>
            <td>Summary: </td>
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



<script>
  $(function () {
    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      todayHighlight: true,
      endDate: "currentDate",
    })
  })

    //NarrationMonth
    $(function () {
    //Date picker
    $('#NarrationMonth').datepicker({
      autoclose: true,
	  minViewMode: 1,
	  format: "MM",
    })
  })
  //NarrationYear
   $(function () {
    //Date picker
    $('#NarrationYear').datepicker({
      autoclose: true,
	  minViewMode: 2,
	  format: "yyyy",
	  minDate: new Date(),
    })

  })

    //DataTables  
    $(function () {
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
