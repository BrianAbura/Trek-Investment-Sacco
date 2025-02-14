<!DOCTYPE html>
<html>
<head>
<?php include('headLinks.php');?>

<style>
/* The container */
.container {
  display: block;
  position: relative;
  padding-right: 120px;
  margin-bottom: 12px;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}


/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 10px;
  height: 20px;
  width: 20px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
tfoot{
  text-align: center;
  color: midnightblue;
  font-weight: bold;
}
.alertify-notifier .ajs-message.ajs-error{
    color: #fff;
    background: rgba(217, 92, 92, 0,95);
    text-shadow: -1px -1px 0 rgba(0, 0, 0, 0,5);
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
            <li class="active"><a href="requestLoan.php"><i class="fa fa-circle-o"></i> Request for a Loan</a></li>
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Loan Application
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Loan Application</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
			 <div class="col-md-12">
			<div class="box box-success">
            <!-- /.box-header -->

            <!-- form start -->
            <form role="form" class="form-content" method="POST" action="AddLoanRequest.php" enctype="multipart/form-data">
              <input type="hidden" id="MembersumSavings" value="<?php echo MembersumSavings($_SESSION['MembershipNumber']);?>">
          <div class="box-body">
			  <div class="row">
				<div class="form-group col-sm-2">
        <label for="Amount">Loan Category</label>
				  <select class="form-control" id="LoanType" name="LoanType" required >
				  <option></option>
				  <option value="New">New Loan</option>
				  </select>
                </div>			  
				<div class="form-group col-sm-2">
                  <label for="Amount">Loan Amount</label>
                  <input type="text" class="form-control InputAmount" id="InputAmount" name="Amount" placeholder="Enter Loan Amount" required autocomplete="off"/>
                </div>
				
				<div class="form-group col-sm-1">
                  <label for="Rate">Rate(%)</label>
                  <input type="text" class="form-control" id="Rate" name="Rate" min=1 readonly />
                </div>
				
				<div class="form-group col-sm-2">
                  <label for="Interest">Interest Amount</label>
                  <input type="text" class="form-control" id="Interest" name="Interest" readonly />
                </div>
			
                <div class="form-group col-sm-2">
                  <label for="TotalAmount">Loan Period (Months)</label>
                  <input type="text" class="form-control" id="LoanPeriod" name="LoanPeriod" readonly />
                </div>
			   
			   <div class="form-group col-sm-2">
                  <label for="TotalAmount">Total Amount</label>
                  <input type="text" class="form-control" id="TotalAmount" name="TotalAmount" readonly />
                </div>
                
		</div>
    <hr/>
					
				<div class="row col-lg-8">
        <div class="col table-responsive">
				<h4 style="color:firebrick; padding-bottom: 10px">Guarantors
				<a href='javascript:void(0);' style="font-size:14px;" id='addMore'><label> Add More <span class="glyphicon glyphicon-plus"></span></label></a>
				</h4>
        <p style="color:brown"><strong>Note:</strong> Guarantors are displayed with the maximum amount that they can gurantee. 
        Each guarantor must Accept or Reject the guarantee request before the loan is issued.</p>

        <table class="table table-bordered" style="background: #D3D3D3" id="GuarantorTable">
				<thead>
				  <tr>
				   <th>Guarantor</th>
					<th>Guranteed Amount</th>
				  </tr>
				</thead>
        <tbody>
            <tr>
                <td>
                    <select class="form-control" name="GuarantorMembershipNumber[]" id="GuarantorAccNumber" required>
                    <option></option>
                    <?php 
                    $members = DB::query('SELECT * from members where AccStatus=%s', 'Active');
                    foreach($members as $member){
                      $savings = DB::queryFirstRow('SELECT sum(Amount) as TotalSavings from savings where MembershipNumber=%s', $member['MembershipNumber']);
                      $memberSavings = $savings['TotalSavings'];
                    
                        //Should not have any running loan
                        $loans = DB::queryFirstRow('SELECT * from loanrequests where MembershipNumber=%s AND Status IN %ls', $member['MembershipNumber'], ['OUTSTANDING', 'PENDING APPROVAL', 'APPROVED']);
                        if(!$loans){
                            $member_name = $member['Fullname'];
                            $gurantAmount = DB::queryFirstRow('SELECT sum(Amount) as guranteedAmount, sum(AmountPaid) as LoanPaid from guarantors where MembershipNumber=%s AND Status=%s AND LoanStatus IN %ls', $member['MembershipNumber'], 'Accepted', ['OUTSTANDING', 'PENDING APPROVAL']);
                            $totalGurantAmt =  $gurantAmount['guranteedAmount'];
                            $totalPaidLoan = $gurantAmount['LoanPaid'];

                            if($member['MembershipNumber'] == $_SESSION['MembershipNumber']){
                                $gurantBalance = ($memberSavings - 0.2*($memberSavings))  - $totalGurantAmt + $totalPaidLoan;
                              }
                              else{
                                $gurantBalance = $memberSavings - $totalGurantAmt + $totalPaidLoan;
                              }
                            
                            if($gurantBalance > 0){ 
                            #Restricted to only those that still have money to guarantee
                    ?>
                    <option value="<?php echo $member['MembershipNumber'];?>"><?php echo $member_name." (".number_format($gurantBalance).")";?></option>
                    <?php  }}}?>
                    </select>
				        </td>
                <td>
					        	<input type="text" class="form-control GuarantorAmount" name="GuarantorAmount[]" onkeyup="sumAmounts()" placeholder="Enter Guarantor's Contribution" autocomplete="off" required />
                </td>
				        <td>
				            <a href='javascript:void(0);' style="font-size:12px;" id='DeleteRow'><i class="fa fa-close" style="color:red"></i></a>
                </td>
		        </tr>
        </tbody>
        <tfoot>
                <tr>
                  <td>Total Guarantors Contribution</td>
                  <td id="guarantSum"></td>
                </tr>
        </tfoot>
           
        </table>
        <p id="infoBox" class="pull-right" style="color:firebrick"></p>
				</div>
        </div>
			  <!-- /.Second Row -->
			  
			<div class="row">
				<div class="col-md-8">
                <label class="container">
                <input type="checkbox" class="flat-red" required > I accept the TREK Investment Club <a style="cursor:pointer" data-toggle="modal" data-target="#termsConditions">Terms and Conditions.</a>
				        <span class="checkmark"></span>
                </label>
              </div>	
			</div>
			  <!-- /.Third Row -->
           
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" id="submitLoanBtn" class="btn btn-success">Submit Loan Request</button>
                <button type="reset" class="btn btn-default">Reset Form</button>
                <a class="btn btn-danger" href="viewLoanRequests.php">Cancel</a>
              </div>
            </form>

          </div>
          <!-- /.box -->
			 </div>
		</div>
      <!-- /.row -->
      <!-- Main row -->
    </section>
  </div>
  
  <!--Terms and Conditions-->
    <div class="modal fade" id="termsConditions">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header bg-green">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h5 class="modal-title"><b>TREK Investment Club</b> Terms and Conditions</h5>
		  </div>
		
			<div class="modal-body">
				
				This agreement is made this day <b><?php echo date('d M, Y');?></b> between the (Lender) <b>TREK Investment Club</b> and (Borrower) <b><?php echo $user['Fullname'];?>.</b><br/>
				<b>And whereas,</b><br/>
				The lender as a financing agency is desirous to lending the borrower and the borrower is desirous of borrowing from the lender and the terms and conditions here in below agreed.<br/>
				<b>THIS AGREEMENT WITNESSETH AS BELOW,</b><br/>
				The lender lends the borrower the principal requested for the specified period to be paid to the lender as principle and interest (Total Amount) there at the rate of <b>3%</b> per month at reducing balance.<br/><br/>
			
				The borrower will inform the lender in time in case of indebtedness and failure to pay so that a new agreement/contract can be entered into and so
				will the lender notify the borrower about his/her current obligation and the period when the contract is expiring.<br/><br/>
				
				The lender will have a right to fully possess the collateral security of the borrower and that is the shares of borrower and the guarantors, after time of expiry of agreement and shall use it to recover his 
				principal amount. <br/><br/>
				In case of ratification of the agreement, the borrower will pay the amount due and any other expenses/charges that might have been incurred by the lender as per that period. After fully 
				fulfilling his/her obligations, the borrower and the guarantors will fully claim their shares back, the lender is not liable according to the law of contract.<br/><br/>
				
				<b>THE AGREEMENT FURTHER WITNESSES THAT;</b><br/>
				The borrower will use his/her shares and shares of his/her guarantors which will be used as collateral security or as a guarantee to acquire the loan.
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
</div>
  <!-- /.content-wrapper -->
    <script>
function commaSeparateNumber(val){
    while (/(\d+)(\d{3})/.test(val.toString())){
      val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
    }
    return val;
  }
var MembersumSavings = document.getElementById("MembersumSavings").value;  
var InputAmount = document.getElementById("InputAmount");
var Rate = document.getElementById("Rate");
var Interest = document.getElementById("Interest");
var LoanType = document.getElementById("LoanType");
var LoanPeriod = document.getElementById("LoanPeriod");
var TotalAmount = document.getElementById("TotalAmount");

var max_loan = (MembersumSavings - (0.2 * MembersumSavings)) * 3;
  LoanType.onchange = function(){
		//If This is the Main Loan
		if(LoanType.value == "New"){
			Rate.value = 2;
			NewInputAmount = InputAmount.value.replace(/,/g,"");
			Interest.value = (NewInputAmount * (Rate.value/100));
			if (NewInputAmount == ""){
				TotalAmount.value = "";
				}
				else{
				TotalAmount.value = commaSeparateNumber(parseInt(NewInputAmount) + parseInt(Interest.value));
			}
			Interest.value = commaSeparateNumber((NewInputAmount * (Rate.value/100)));
				
				//*** Loan Period changes based on the Input Amount ***//
				if((NewInputAmount >= 1) && (NewInputAmount <= 3000000)){
					LoanPeriod.value = 3;
				}
				else if(NewInputAmount > 3000000){
					LoanPeriod.value = 6;
				}
				else{
					LoanPeriod.value = 0;
				}
				//*** END Loan Period changes based on the Input Amount END ***//
		}
	}
//When the Amount Changes
InputAmount.onchange = function() {	
	NewInputAmount = InputAmount.value.replace(/,/g,"");
	Interest.value = (NewInputAmount * (Rate.value/100));
    if(NewInputAmount > max_loan){
      alertify.alert("Error!","You cannot make a loan request of more than <b>UGX "+commaSeparateNumber(max_loan)+".</b>");
      InputAmount.value = "";
    }
		if (NewInputAmount == ""){
		TotalAmount.value = "";
		}
		else{
		TotalAmount.value = commaSeparateNumber(parseInt(NewInputAmount) + parseInt(Interest.value));
			}
	Interest.value = commaSeparateNumber(Interest.value);
	
		//*** Loan Period changes based on the Input Amount ***//
		if((NewInputAmount >= 1) && (NewInputAmount <= 3000000)){
			LoanPeriod.value = 3;
		}
		else if(NewInputAmount > 3000000){
			LoanPeriod.value = 6;
		}
		else{
			LoanPeriod.value = 0;
		}
		//*** END Loan Period changes based on the Input Amount END ***//
	}
	
</script>

<?php include('../scripts/externalScripts.php');?>
<script>
$('.InputAmount').keyup(function(event) {

  // skip for arrow keys
  if(event.which >= 37 && event.which <= 40) return;

  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    ;
  });
});
</script>
<script>
$('.GuarantorAmount').keyup(function(event) {
  // skip for arrow keys
 
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    ;
  });
});

//Deal with the guarantors here
var guarantSum = document.getElementById('guarantSum');
guarantSum.innerHTML = "UGX 0";

var infoBox = document.getElementById('infoBox');

function sumAmounts(){
    var sum = 0;
    $('.GuarantorAmount').each(function(){
        sum += parseFloat(this.value.replace(/,/g,""));
    });
    guarantSum.innerHTML = "UGX "+numberWithCommas(sum);

    if(sum != NewInputAmount){
      infoBox.innerHTML = '<i class="fa fa-exclamation-triangle"></i>'+" The total gurantors contribution must be equal to the Loan Borrowed.";
      $("#infoBox").show();
      $(":submit").attr("disabled", true);
     }
    else if(NewInputAmount > sum){
      $("#infoBox").hide();
      $(":submit").removeAttr("disabled");
    }
    else{
      $("#infoBox").hide();
      $(":submit").removeAttr("disabled");
    }
}
</script>
<script>
//Script to add more rows to the end of venues table
$(function(){
    $('#addMore').on('click', function() {
              var data = $("#GuarantorTable tr:eq(1)").clone(true).appendTo("#GuarantorTable");
              data.find("input").val('');
              data.find("select").val('');
     });
     $('#DeleteRow').on('click', function() {
         var trIndex = $(this).closest("tr").index();
            if(trIndex>=1) {
             $(this).closest("tr").remove();
           } else {
             alertify.alert("Error!","Sorry you Cannot remove this row.");
           }
      });
});      
</script>
<script>
 function numberWithCommas(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1,$2");
    return x;
}

//Date picker
$(function () {
    $('.datepicker').datepicker({
      autoclose: true,
      todayHighlight: true,
      startDate: "currentDate",
    })
  })

</script>
</body>
</html>
