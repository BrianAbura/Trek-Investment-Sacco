<!DOCTYPE html>
<html>
<head>
<?php include('headLinks.php');?>
	<style>
   .text-muted{
     padding-bottom: 3px;
     color:royalblue;
   }
   .form-control{
		color:blue;
	}

	</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
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
            <li><a href="administrativeMembers.php"><i class="fa fa-circle-o"></i> Administrative Members</a></li>
          </ul>
        </li>

        <!--Investments-->	
        <li>
          <a href="investments.php">
            <i class="fa fa-money"></i>
            <span>Investments</span>
          </a>
        </li> 

        <!--Shares-->	
        	<li>
          <a href="welfare.php">
            <i class="fa fa-star"></i>
            <span>Welfare</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
        </li> <!-- //Shares-->	

        <!--Savings-->	
        <li>
          <a href="savings.php">
          <span class="glyphicon glyphicon-piggy-bank"></span>
            <span>Savings</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
        </li> <!-- //Savings-->	
        
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
            <li><a href="bankcharges.php"><i class="fa fa-circle-o"></i> Bank Charges</a></li>
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
          </ul>
        </li><!-- //Notifications-->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <?php 
	  $id = $_GET['investment_id'];
	  $investment = DB::queryFirstRow('SELECT * from investments where id=%s', $id);
	  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Investments
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Investments</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
		<div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <h4 class="text-center text-bold text-green text-uppercase" style="color:ds"><?php echo $investment['investment_name'];?></h4>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <div class="box box-primary" id="investmentDetails">
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-globe"></i> Investment Type</strong>
              <p class="text-muted">
              <?php echo $investment['investment_type'];?>
              </p>
            
              <strong><i class="fa fa-calendar"></i> Initiation Date</strong>
              <p class="text-muted">
              <?php echo date_format(date_create($investment['investment_date']), 'd-M-Y');?>
              </p>

              <strong><i class="fa fa-user"></i> Added By</strong>
              <p class="text-muted">
              <?php echo $investment['AddedBy'];?>
              </p>
              <br/>
              <strong><i class="fa fa-gear margin-r-5"></i>Investment Actions</strong>
                
              
              <p>
              <button class="btn bg-navy btn-sm" onclick="showEdit()"> <i class="fa fa-edit"></i> Edit</button>
              <button class="btn btn-danger btn-sm" onclick="Del_Investment('<?php echo $id?>');"><i class="fa fa-trash"></i> Delete</button>
              </p>
              <hr>

              <p class="text-center">
              <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#Add_invest_transactions"><i class="fa fa-plus"></i>  Add Transctions</button>
              </p>

              <hr>
            </div>
            <!-- /.box-body -->
          </div>


          <div class="box box-primary" id="investmentEdit">
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" class="form-content" method="POST" action="ManageInvestment.php" enctype="multipart/form-data">
              <input type="hidden" id="InvestAction" name="investment_action" value="Edit_Investment">
              <input type="hidden" id="investment_id" name="investment_id" value="<?php echo $id;?>">
                    <div class="box-body">
              <div class="row">

              <div class="form-group col-sm-12">
                <label for="SelectMem">Name of Investment</label>
                <input type="text" name="investment_name" id="investment_name" class="form-control" required value="<?php echo $investment['investment_name'];?>">
              </div>

              <div class="form-group col-sm-12">
              <label for="SelectMem">Type of Investment</label>
              <select class="form-control" name="investment_type" id="investment_type" required>
              <option value="<?php echo $investment['investment_type'];?>"><?php echo $investment['investment_type'];?></option>
              <option value="Annuities">Annuities</option>
              <option value="Bonds">Bonds</option>
              <option value="Certificates of Deposit">Certificates of Deposit</option>
              <option value="Commodities">Commodities</option>
              <option value="Collectables">Collectables</option>
              <option value="Cryptocurrencies">Cryptocurrencies</option>
              <option value="Exchange-Traded Funds">Exchange-Traded Funds</option>
              <option value="Fixed Income">Fixed Income</option>
              <option value="Government Bonds">Government Bonds</option>
              <option value="Hedge Funds">Hedge Funds</option>
              <option value="Insurance">Insurance</option>
              <option value="Mutual Funds">Mutual Funds</option>
              <option value="Peer-to-Peer Lending">Peer-to-Peer Lending</option>
              <option value="Real Estate">Real Estate</option>
              <option value="Savings Accounts">Savings Accounts</option>
              <option value="Stocks">Stocks</option>
              <option value="Other">Other</option>
              </select>
              </div>

              <div class="form-group col-sm-12">
                <label for="initiation_date">Initiation Date</label>
                <input type="text" class="form-control pull-right datepicker" name="investment_date" autocomplete="off" required value="<?php echo date_format(date_create($investment['investment_date']), 'm-d-Y');?>">
              </div>
              </div>
                    </div>
                      <!-- /.box-body -->
                      <div class="box-footer">
                        <button type="submit" class="btn bg-navy">Update</button>
                        <label class="btn btn-danger" onclick="showDetails()">Cancel</label>
                      </div>
                    </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->


    </div>
		<div class="col-md-9">
		 <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#All" data-toggle="tab"><strong>All</strong></a></li>
              <li><a href="#Deposits" data-toggle="tab"><strong>Deposits</strong></a></li>
              <li><a href="#Interests" data-toggle="tab"><strong>Interests Earned</strong></a></li>
              <li><a href="#Withdraws" data-toggle="tab"><strong>Withdraws</strong></a></li>
            </ul>
            <div class="tab-content">
            <!--Savings Tab-Pane -->
              <div class="tab-pane active" id="All">
              <div class="box-body table-responsive">
            	<table id="example1" class="table table-bordered small">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Amount</th>
                  <th>Transaction Action</th>
                  <th>Description</th>
                  <th>Transaction Date</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
				<?php 
        $transactions = DB::query('SELECT * from investment_transactions where investment_id=%s order by dateAdded desc', $id);
        $cnt = 1;
				foreach($transactions as $item){
          if($item['trans_action'] == 'Deposit'){
            $class = 'info';
          }
          elseif($item['trans_action'] == 'Interest'){
            $class = 'success';
          }
          else{
            $class = 'danger';
          }
				?>
				 <tr class="<?php echo $class; ?>" title="<?php echo "Added by: ".$item['AddedBy']." on ".date_format(date_create($saving['dateAdded']), 'd-m-Y'); ?>">
                  <td><?php echo $cnt;?></td>
                  <td><?php echo number_format($item['amount']);?></td>
                  <td><?php echo $item['trans_action'];?></td>
                  <td><?php echo $item['description'];?></td>  
                  <td><?php echo date_format(date_create($item['trans_date']), 'd-m-Y');?></td>
                  <td><i class="fa fa-times text-danger" style="cursor:pointer" onclick="Del_Investment_trans('<?php echo $item['id']?>');"></i></td>
                </tr>
        <?php 
        $cnt ++;
				}
				?>
				</tbody>
			</table>
          </div>
              </div>

              <!--Shares Tab-Pane -->
              <div class="tab-pane" id="Deposits">
              <div class="box-body table-responsive">
                <!-- /.box-header -->
			      <table id="example2" class="table small table-striped table-bordered">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Amount</th>
                  <th>Transaction Action</th>
                  <th>Description</th>
                  <th>Transaction Date</th>
                </tr>
                </thead>
                <tbody>
				<?php 
        $transactions = DB::query('SELECT * from investment_transactions where investment_id=%s and trans_action=%s order by dateAdded desc', $id, 'Deposit');
        $cnt = 1;
        $sumDeposits = 0;
				foreach($transactions as $item){
				?>
				 <tr class="info" title="<?php echo "Added by: ".$item['AddedBy']." on ".date_format(date_create($saving['dateAdded']), 'd-m-Y'); ?>">
                  <td><?php echo $cnt;?></td>
                  <td><?php echo number_format($item['amount']);?></td>
                  <td><?php echo $item['trans_action'];?></td>
                  <td><?php echo $item['description'];?></td>  
                  <td><?php echo date_format(date_create($item['trans_date']), 'd-m-Y');?></td>
                </tr>
        <?php 
        $cnt ++;
        $sumDeposits+=$item['amount'];
				}
				?>
				</tbody>
        <tfoot>
                <tr style="font-weight:bold; font-size:14px; background-color:#E3DAFF">
                    <td>
                    Total Deposits:</td>
                    <td>
                     <?php echo 'UGX '.number_format($sumDeposits);?>
                    </td>
                  </tr>
                </tfoot>
			</table>
          </div>
              </div>


              <!--Interests Earned-->
              <div class="tab-pane" id="Interests">
              <div class="box-body table-responsive">
               <!-- /.box-header -->
			      <table id="example3" class="table small table-bordered table-striped">
            <thead>
                <tr>
                  <th>#</th>
                  <th>Amount</th>
                  <th>Transaction Action</th>
                  <th>Description</th>
                  <th>Transaction Date</th>
                </tr>
                </thead>
                <tbody>
				<?php 
        $transactions = DB::query('SELECT * from investment_transactions where investment_id=%s and trans_action=%s order by dateAdded desc', $id, 'Interest');
        $cnt = 1;
        $sumInterests = 0;
				foreach($transactions as $item){
				?>
				 <tr class="success" title="<?php echo "Added by: ".$item['AddedBy']." on ".date_format(date_create($saving['dateAdded']), 'd-m-Y'); ?>">
                  <td><?php echo $cnt;?></td>
                  <td><?php echo number_format($item['amount']);?></td>
                  <td><?php echo $item['trans_action'];?></td>
                  <td><?php echo $item['description'];?></td>  
                  <td><?php echo date_format(date_create($item['trans_date']), 'd-m-Y');?></td>
                </tr>
        <?php 
        $cnt ++;
        $sumInterests+=$item['amount'];
				}
				?>
				</tbody>
        <tfoot>
                <tr style="font-weight:bold; font-size:14px; background-color:#E3DAFF">
                    <td>
                    Total Interests Earned:</td>
                    <td>
                     <?php echo 'UGX '.number_format($sumInterests);?>
                    </td>
                  </tr>
                </tfoot>
			</table>
          </div>
              </div>


              <!--Withdraws Earned Tab-Pane -->
               <div class="tab-pane" id="Withdraws">
              <div class="box-body table-responsive">
             	      <table id="example4" class="table small table-bordered table-striped">
                     <thead>
                <tr>
                  <th>#</th>
                  <th>Amount</th>
                  <th>Transaction Action</th>
                  <th>Description</th>
                  <th>Transaction Date</th>
                </tr>
                </thead>
                <tbody>
				<?php 
        $transactions = DB::query('SELECT * from investment_transactions where investment_id=%s and trans_action=%s order by dateAdded desc', $id, 'Withdraw');
        $cnt = 1;
        $sumWithdraw = 0;
				foreach($transactions as $item){
				?>
				 <tr class="danger" title="<?php echo "Added by: ".$item['AddedBy']." on ".date_format(date_create($saving['dateAdded']), 'd-m-Y'); ?>">
                  <td><?php echo $cnt;?></td>
                  <td><?php echo number_format($item['amount']);?></td>
                  <td><?php echo $item['trans_action'];?></td>
                  <td><?php echo $item['description'];?></td>  
                  <td><?php echo date_format(date_create($item['trans_date']), 'd-m-Y');?></td>
                </tr>
        <?php 
        $cnt ++;
        $sumWithdraw+=$item['amount'];
				}
				?>
				</tbody>
        <tfoot>
                <tr style="font-weight:bold; font-size:14px; background-color:#E3DAFF">
                    <td>
                    Total Withdraws:</td>
                    <td>
                     <?php echo 'UGX '.number_format($sumWithdraw);?>
                    </td>
                  </tr>
                </tfoot>
			</table>
          </div>
              </div>
              <!-- /.tab-pane LoanPayments-->
            </div>
            <!-- /.tab-content -->
          </div>
		</div>
      </div>
      <!-- /.row -->
      <!-- Main row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!-- Add-->
<div class="modal fade" id="Add_invest_transactions">
<div class="modal-dialog modal-lg ">
<div class="modal-content ">

<div class="modal-header bg-primary color-palette">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span></button>
<h5 class="modal-title">Investment Transaction: <b><?php echo $investment['investment_name'];?></b></h5>
</div>
<div class="modal-body">
<form role="form" class="form-content" method="POST" action="ManageInvestment_trans.php" enctype="multipart/form-data">
<input type="hidden" id="InvestAction" name="transaction_action" value="Add_New_Transction">
<input type="hidden" id="investment_id" name="investment_id" value="<?php echo $id; ?>">
      <div class="box-body">
<div class="row">

<div class="form-group col-sm-3">
<label for="SelectMem">Action</label>
<select class="form-control" name="trans_action" id="trans_action" required>
<option></option>
<option value="Deposit">Deposit</option>
<option value="Interest">Interest Earned</option>
<option value="Withdraw">Withdraw</option>
</select>
</div>

<div class="form-group col-sm-3">
<label for="SelectMem">Amount</label>
<input type="text" name="amount" id="amount" class="form-control CommaAmount" required>
</div>

<div class="form-group col-sm-3">
  <label for="initiation_date">Transaction Date</label>
  <input type="text" class="form-control pull-right datepicker" name="date" autocomplete="off" required>
</div>

<div class="form-group col-sm-3">
<label for="SelectMem">Description</label>
<textarea name="description" id="description" class="form-control" ></textarea>
</div>
</div>
      </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-success">Add Transaction</button>
          <button type="reset" class="btn btn-default">Reset</button>
        </div>
      </form>
      <br>
      <p>
        <u><b>Note:</b></u>
        <ul>
          <li>Investment Deposits reduces/debits Cash at bank</li>
          <li>Investment Withdraws and Interests Earned increases/credits Cash at bank</li>
        </ul>

      </p>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

<?php include('externalScripts.php');?>
    

<script>
  var i_edit = document.getElementById("investmentEdit");
  var i_details = document.getElementById("investmentDetails");
  i_edit.style.display = "none";

  function showEdit() { 
    i_edit.style.display = "block";
    i_details.style.display = "none";
  }

  function showDetails() { 
    i_details.style.display = "block";
    i_edit.style.display = "none";
  }
</script>

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
    $('#example2').DataTable()
    $('#example3').DataTable()
    $('#example4').DataTable()
  })
</script>
<script>
    function Del_Investment(investment_id){
		//Prompt user to confirm
		alertify.confirm("Delete Investment","Are you sure you want to delete this investment?", function(){ 
		 var hr = new XMLHttpRequest();
	     var url = "ManageInvestment.php";
	//Post to file without refreshing page
  var vars = "investment_id="+investment_id+"&investment_action="+"Del_Investment";
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    // var return_data = hr.responseText;
        var jsonResponse = JSON.parse(hr.responseText);
        if(jsonResponse.Error){
          alertify.alert('Response',jsonResponse.Error);
          function redirect(){window.location.reload()}
			    setTimeout(redirect, 2000);
          
        }
        else{
          alertify.alert('Response',jsonResponse.Success);
          function redirect(){window.location.href = "investments.php"}
          setTimeout(redirect, 3000);
        }
        
			 
			//function redirect(){window.location.href = "investments.php"}
			//setTimeout(redirect, 3000);
		}	}
    hr.send(vars);
		}, function(){  });	
		}


    function Del_Investment_trans(transaction_id){
		//Prompt user to confirm
		alertify.confirm("Delete Transaction","Are you sure you want to delete this transaction?", function(){ 
		 var hr = new XMLHttpRequest();
	     var url = "ManageInvestment_trans.php";
	//Post to file without refreshing page
  var vars = "transaction_id="+transaction_id+"&transaction_action="+"Del_Transction";
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			alertify.alert('Response',return_data);
			function redirect(){window.location.reload()}
			setTimeout(redirect, 2000);
		}	}
    hr.send(vars);
		}, function(){  });	
		}
</script>
</body>
</html>
