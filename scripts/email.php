<!DOCTYPE html>
<html>
<head>
<?php include('headLinks.php');?>
<script src="http://code.jquery.com/jquery-1.5.js"></script>
<script>
    function countChar(val) {
    var len = val.value.length;
    $('#charNum').text("Characters: "+ len);
    };
</script>

	<style>
	.form-control{
		color:blue;
	}
	.btn-danger a{
		color:#fff;
	}
  .table-striped>tbody>tr:nth-child(even)>td, 
	.table-striped>tbody>tr:nth-child(even)>th {
	   background-color: #c8f9d3;
	 }
   .badge{
     font-size: 15px;
     background-color: #CC0000;
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
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-bell-o"></i> <span>Notifications</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu active">
            <li class="treeview"><a href="#"><i class="fa fa-circle-o"></i>
            <span>SMS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu active">
            <li class="active"><a href="sms.php"><span class="glyphicon glyphicon-send"></span></i> Sent SMS</a></li>
            <li><a href="scheduledSMS.php"><span class="glyphicon glyphicon-list-alt"></span> Scheduled SMS</a></li>
          </ul>
         </li>
         <li class="treeview active"><a href="#"><i class="fa fa-circle-o"></i>
            <span>Email</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="email.php"><span class="glyphicon glyphicon-send"></span></i> Sent Emails</a></li>
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
        Emails
        <?php if($user['Role'] == 2 || $user['Role'] == 3 || $user['Role'] == 4){?>
        <button class="btn btn-success" style="font-size:12px;cursor:pointer" data-toggle="modal" data-target="#sendEmail">Send Email</button>
        <?php } ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Emails</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
			 <div class="col-md-12">
			<div class="box box-success">	
			<div class="box-body table-responsive">

      <form class="searchFilter" id="searchFilter" method="POST" action="email.php" >
  <div class="form-row ">
    <div class="col-md-2">
      <input type="text" class="form-control datepicker2" placeholder="Filter From" name="dateFrom" id="dateFrom" required autocomplete="off">
    </div>
    <div class="col-md-2">
      <input type="text" class="form-control datepicker2" placeholder="Filter To" name="dateTo" id="dateTo" required autocomplete="off">
    </div>

    <div class="col-md-2">
    <button class="btn btn-primary" type="submit">Search</button> <i title="Refresh Page" onClick="location.href='email.php'"  class="fa fa-refresh" style="margin-left:10px; color:green; font-weight:bold; cursor:pointer; font-size:16px"></i>
    </div>
  </div>
 <?php 
   if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
     echo "<p>Data filtered from { ".date_format(date_create($_POST['dateFrom']),"d-m-Y")." to ".date_format(date_create($_POST['dateTo']),"d-m-Y")." }</p>";
   }
 ?>
</form>
        

      <img class="borderDloadImg" src="../dist/img/excel_download.png" title="Export to Excel" onclick="ExportToExcel('example1', 'Emails')"/> 
            <!-- /.box-header -->
			<table id="example1" class="table table-bordered small">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Receiver</th>
                  <th>Email Address</th>
                  <th>Subject</th>
                  <th>Message</th>
                  <th>Attachments</th>
                  <th>Status</th>
                  <th>Date Sent</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $cnt = 1;
              if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
                $dateFrom = date_format(date_create($_POST['dateFrom']),"Y-m-d");
                $dateTo = date_format(date_create($_POST['dateTo']),"Y-m-d");
                $emails = DB::query('SELECT * from emails where DateCreated >=%s AND DateCreated <=%s order by DateCreated', $dateFrom, $dateTo);
              }
              else{
                $emails = DB::query('SELECT * from emails order by DateCreated desc', 'Boat');
              }
			      	foreach($emails as $email){
              $response = json_decode($email['Response']);
              if($response->Status == "ERROR"){
                echo '<tr class="danger">';
              }
              else{
                echo '<tr class="success">';
              }
			  	?>
                  <td><?php echo $cnt;?></td>
                  <td><?php echo $email['ReceiverName'];?></td>
                  <td><?php echo $email['ReceiverEmail'];?></td>
                  <td><?php echo $email['Subject'];?></td>
                  <td><?php echo trim($email['Message']);?></td>
                  <td><?php echo $email['Attachments'];?></td>
                  <td>
                      <?php 
                           $response = json_decode($email['Response']);
                           if($response->Status == "ERROR"){
                            echo $response->Status." : ".$response->Response;
                           }
                           else{
                            echo $response->Status;
                           }
                      ?>
                  </td>
                  <td><?php echo date_format(date_create($email['DateCreated']), 'd-m-Y');?></td>
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
<?php include('externalScripts.php');?>

<div class="modal fade" id="sendEmail">
<div class="modal-dialog modal-lg">
<div class="modal-content ">
<div class="modal-header bg-green color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title">Compose New Email</h5>
      </div>
      <div class="modal-body">
      <form class="form-content" method="POST" action="ManageEmails.php" enctype="multipart/form-data">
      <div class="box-body">
              <div class="form-group">
              <select class="form-control select2" name="SelectMemberNum[]" id="SelectMemberNum" multiple="multiple" placeholder="Select Members" style="width: 100%;">
              <option disabled="disabled">TO:</option>    
              <option value="ALL">All Members</option>
                  <?php 
                  $members = DB::query('SELECT * from members where AccStatus=%s order by Fullname', 'Active');
                  foreach($members as $member){
                  ?>
                  <option value="<?php echo $member['MembershipNumber'];?>"><?php echo $member['Fullname']." (".$member['EmailAddress'].")";?></option>
                  <?php }?>
                  </select>
              </div>
              <div class="form-group">
                  <input class="form-control" id="EmailSubject" name="EmailSubject" placeholder="Subject:" required>
              </div>
              <div class="form-group">
                    <textarea id="EmailBody" name="EmailBody" class="form-control" style="height: 100px" placeholder="Type your message here" required></textarea>
              </div>
              <div class="form-group">
                <div>
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="input-append">
                        <div class="uneditable-input">
                        <span class="fileupload-preview" style="font-size: 12px; color:blue"></span>
                        </div>
                        <span class="btn btn-default btn-file">
                        <span class="fileupload-exists">Change</span>
                        <span class="fileupload-new">Add Attachment</span>
                        <input type="file" id="EmailAttachment" name="EmailAttachment" onchange="ValidateSingleInput(this);"/>
                        </span>
                        <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                        <p class="help-block">Max 10MB || Accepted Formats: jpg, jpeg and png</p>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <input type="checkbox" id="scheduleChecker" name="scheduleChecker" value="SET"> <a style="cursor:pointer;">Set Schedule </a>
            <br/>
        
        <div class="row scheduledSMS">
        <br/>
		    <div class="form-group col-sm-4">
          <label>Scheduled Date:</label>
          <div class="input-group date">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" name="scheduleDate" id="datepicker" autocomplete="off" />
          </div>
          <!-- /.input group -->
        </div>
        <div class="form-group col-sm-4">
          <label>Scheduled Time:</label>
          <div class="input-group">
            <input type="text" class="form-control timepicker" name="scheduleTime" autocomplete="off" />
            <div class="input-group-addon">
              <i class="fa fa-clock-o"></i>
            </div>
          </div>
          <!-- /.input group -->
        </div>
				<!-- /.Second Row -->
        </div>

        <!-- /.box-body -->
      <div class="box-footer">
        <button type="submit" class="btn btn-success sendBtn">SEND</button>
        <button type="submit" class="btn btn-success scheduleBtn">Schedule SMS</button>
        &nbsp;
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
    <!-- bootstrap time picker -->


<script>
  var SelectMemberNum = document.getElementById("SelectMemberNum");
  SelectMemberNum.onchange = function(){
    if(SelectMemberNum.value == "ALL"){
      alertify.alert('Response','Email will be sent to all members if "ALL MEMBERS" option is selected.');
    }
  }
</script>

<script> 
    $(function () {
    $('#example1').DataTable()

     //Date picker
     $('#datepicker').datepicker({
      autoclose: true,
      todayHighlight: true,
      startDate: "currentDate",
    })

    $('.datepicker2').datepicker({
      autoclose: true,
      todayHighlight: true,
      endDate: "currentDate",
    })

     //Timepicker
     $('.timepicker').timepicker({
      showInputs: false,
      showMeridian: false,
      minuteStep: 10,
    })
  })
</script>
<script>
    $(document).ready(function(){
      $(".scheduledSMS").hide();
      $(".scheduleBtn").hide();
        $('#scheduleChecker').click(function(){
            if($(this).is(":checked")){
              $(".scheduledSMS").show();
              $(".scheduleBtn").show();
              $(".sendBtn").hide();
              $(".sendBtn").hide();
            }
            else if($(this).is(":not(:checked)")){
              $(".scheduledSMS").hide();
              $(".scheduleBtn").hide();
              $(".sendBtn").show();
            }
        });
    });
</script>


<script>
  $(function () {
    //Add text editor
    $("#EmailBody").wysihtml5({});
  });
</script>

</body>
</html>