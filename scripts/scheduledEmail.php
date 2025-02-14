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
         <li class="treeview active"><a href="#"><i class="fa fa-circle-o"></i>
            <span>Email</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="email.php"><span class="glyphicon glyphicon-send"></span></i> Sent Emails</a></li>
            <li class="active"><a href="scheduledEmail.php"><span class="glyphicon glyphicon-list-alt"></span> Scheduled Emails</a></li>
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
        Scheduled Emails
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Scheduled Emails</li>
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
                  <th>#</th>
                  <th>Receiver Name</th>
                  <th>Receiver Email</th>
                  <th>Subject</th>
                  <th>Message</th>
                  <th>Attachments</th>
                  <th>Schedule Time</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $cnt = 1;
            	$emails = DB::query('SELECT * from scheduledemails order by Id desc');
			      	foreach($emails as $email){
				?>
				 <tr title="<?php echo "Added By: ".$email['CreatedBy']." on ".date_format(date_create($email['DateCreated']), 'd-m-Y H:i');?>">
                  <td><?php echo $cnt;?></td>
                  <td><?php echo $email['ReceiverName'];?></td>
                  <td><?php echo $email['ReceiverEmail'];?></td>
                  <td><?php echo $email['Subject'];?></td>
                  <td><?php echo $email['Message'];?></td>
                  <td><?php echo $email['Attachments'];?></td>
                  <td><?php echo date_format(date_create($email['Schedule']), 'd-m-Y H:i');?></td>
                  <td>
                  <?php if($user['Role'] == 2 || $user['Role'] == 3 || $user['Role'] == 4){?>
                  <label class="btn btn-primary btn-xs" href="#editScheduleEmail" data-id="<?php echo $email['Id']?>" data-toggle="modal">Edit</label>
                  <label class="btn btn-danger btn-xs" onclick="deleteContent('<?php echo $email['Id']?>','scheduledemails');">Delete</label>
                  <?php }?>
                </td>
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

<!-- Add New Admin MOdal-->
    <div class="modal fade" id="editScheduleEmail">
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
    $('#editScheduleEmail').on('show.bs.modal', function (e) {
        var scheduleEmailID = $(e.relatedTarget).data('id');
        $.ajax({
            type : 'post',
            url : 'Modal_scheduleEmails.php', //Here you will fetch records 
            data :  'scheduleEmailID='+ scheduleEmailID, //Pass $id
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
            }
        });
     });
});
</script>

<script> 
    $(function () {
    $('#example1').DataTable()
  })
</script>
</body>
</html>