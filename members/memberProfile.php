<!DOCTYPE html>
<html>

<head>
  <?php include('headLinks.php'); ?>
  <style>
    .text-muted {
      padding-bottom: 3px;
      color: royalblue;
    }
  </style>
</head>

<body class="hold-transition skin-green sidebar-mini">
  <div class="wrapper">

    <?php include('header.php'); ?>

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
          <li class="active">
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

          <li class="treeview">
            <a href="#">
              <span class="glyphicon glyphicon-list-alt"></span>
              <span>Loan Requests</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                <?php
                if (GuaranteeRequests($_SESSION['MembershipNumber']) != 0) {
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
              <li><a href="viewLoanRequests.php"><i class="fa fa-circle-o"></i> View Loan Requests</a></li>
              <li><a href="GuaranteeRequests.php"><i class="fa fa-circle-o"></i> Guarantee Requests
                  <?php
                  if (GuaranteeRequests($_SESSION['MembershipNumber']) != 0) {
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
          Profile
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Member Profile</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <?php
          $member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $_SESSION['MembershipNumber']);
          ?>
          <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-success">
              <div class="box-body box-profile">
                <img class="profile-user-img img-responsive" src="<?php echo $member['ProfilePicture']; ?>" alt="User profile picture">
                <h4 class="text-center"><?php echo $member['Fullname'] . "<br/> " . $member['MembershipNumber']; ?></h3>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->


            <div class="box box-success">
              <!-- /.box-header -->
              <div class="box-body">
                <strong><i class="fa fa-calendar"></i> Date Joined</strong>
                <p class="text-muted">
                  <?php echo date_format(date_create($member['Joining_date']), 'd-M-Y'); ?>
                </p>

                <strong><i class="fa fa-phone"></i> Mobile</strong>
                <p class="text-muted">
                  <?php echo $member['MSISDN']; ?>
                </p>

                <strong><i class="fa fa-globe"></i> Email</strong>
                <p class="text-muted">
                  <?php echo $member['EmailAddress']; ?>
                </p>

                <strong><i class="fa fa-credit-card"></i> ID Number</strong>
                <p class="text-muted">
                  <?php echo $member['IDNum']; ?>
                </p>

                <strong><i class="fa fa-building"></i> Workplace</strong>
                <p class="text-muted">
                  <?php echo $member['Workplace']; ?>
                </p>

                <strong><i class="fa fa-home"></i> Residence</strong>
                <p class="text-muted">
                  <?php echo $member['Residence']; ?>
                </p>

                <strong><i class="fa fa-envelope"></i> Postal Address</strong>
                <p class="text-muted">
                  <?php echo $member['Postal_Address']; ?>
                </p>
                <br />
                <hr>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>

          <div class="col-md-9">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#passwordChange" data-toggle="tab">Change Password</a></li>
                <li><a href="#nextofKin" data-toggle="tab">Next of Kin</a></li>
              </ul>

              <div class="tab-content">
                <!--Alerts Starts -->
                <?php
                if (isset($_SESSION['Success'])) {
                ?>
                  <div class="alert alert-success alert-dismissible small">
                    <label class="close" data-dismiss="alert" aria-hidden="true">&times;</label>
                    <i class="icon fa fa-check"></i>
                    <?php echo $_SESSION['Success']; ?>
                  </div>
                <?php
                  unset($_SESSION['Success']);
                } else if (isset($_SESSION['Error'])) {
                ?>
                  <div class="alert alert-danger alert-dismissible small">
                    <label class="close" data-dismiss="alert" aria-hidden="true">&times;</label>
                    <i class="icon fa fa-ban"></i>
                    <?php echo $_SESSION['Error']; ?>
                  </div>
                <?php
                  unset($_SESSION['Error']);
                }
                ?>
                <!--Alerts End -->
                <div class="active tab-pane" id="passwordChange">
                  <form class="form-horizontal" method="POST" action="changePassword.php">
                    <div class="form-group">
                      <label for="inputName" class="col-sm-2 control-label">Old Password</label>
                      <div class="col-sm-8">
                        <input class="form-control hidden" id="inputName" name="user_id" value="#">
                        <input type="password" class="form-control" id="inputName" name="oldPass" placeholder="Enter your old password">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputEmail" class="col-sm-2 control-label">New Password</label>
                      <div class="col-sm-8">
                        <input type="password" class="form-control" id="inputEmail" name="newPass" placeholder="Enter new password">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="inputName" class="col-sm-2 control-label">Repeat New Password</label>
                      <div class="col-sm-8">
                        <input type="password" class="form-control" id="inputName" name="newPass2" placeholder="Repeat new password">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success" name="btn" value="password_change">Change Password</button>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- Next of Kin Information -->
                <div class="tab-pane" id="nextofKin">
                  <div class="card-header-action">

                    <a data-toggle="modal" data-target="#addkin" class="btn btn-sm btn-primary">Add Next of Kin</a>
                  </div>
                  <div class="box-body table-responsive">
                    <table id="example1" class="table table-striped small">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Fullname</th>
                          <th>Phone Number</th>
                          <th>Email Address</th>
                          <th>Relationship</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $next_of_kin = DB::query('SELECT * from next_of_kin where MembershipNumber=%s order by Id desc', $_SESSION['MembershipNumber']);
                        $cnt = 1;
                        foreach ($next_of_kin as $member) {
                        ?>
                          <tr>
                            <td><?php echo $cnt; ?></td>
                            <td><?php echo $member['Fullname']; ?></td>
                            <td><?php echo $member['MSISDN']; ?></td>
                            <td><?php echo $member['EmailAddress']; ?></td>
                            <td><?php echo $member['Relation']; ?></td>
                            <td> <a data-toggle="modal" data-target="#editNextofkin" data-id="<?php echo $member['Id']; ?>" class="btn btn-sm btn-info">Edit</a>
                              <a data-toggle="modal" data-target="#delNextofkin" data-id="<?php echo $member['Id']; ?>" class="btn btn-sm btn-danger">Delete</a>
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
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
        </div>
        <!-- /.row -->
        <!-- Main row -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Next of Kin div -->
    <div class="modal fade" id="addkin">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-blue">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h5 class="modal-title">Add Next Of Kin</h5>
          </div>
          <form role="form" class="form-content" method="POST" action="ManageNextofKin.php">
            <input type="hidden" name="kin_action" value="Create">
            <div class="modal-body mt-2">
              <div class="form-group col-sm-3">
                <label for="Amount">Fullname</label>
                <input type="text" class="form-control" name="Fullname" placeholder="Enter Fullname" required autocomplete="off" />
              </div>
              <div class="form-group col-sm-3">
                <label for="Amount">Phone Number</label>
                <input type="text" class="form-control" name="Phone_Number" placeholder="Enter Phone Number" required autocomplete="off" />
              </div>
              <div class="form-group col-sm-3">
                <label for="Amount">Email Address</label>
                <input type="email" class="form-control" name="Email_Address" placeholder="Enter Email Address" required autocomplete="off" />
              </div>
              <div class="form-group col-sm-3">
                <label for="Amount">Relationship</label>
                <input type="text" class="form-control" name="Relationship" placeholder="Enter Relationship" required autocomplete="off" />
              </div>
            </div>
            <div class="modal-footer mt-2">
              <button type="submit" class="btn btn-success">Add Next of Kin</button>
              <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- End Next of kin div -->
    <?php include('../scripts/externalScripts.php'); ?>
    <script>
      $(function() {
        $('#example1').DataTable({
          'ordering': false,
        })
      })
    </script>
    <!-- Edit Modal-->
    <div class="modal fade" id="editNextofkin">
      <div class="modal-dialog modal-lg">
        <div class="modal-content ">

          <div class="fetched-data"></div> <!--Fetched Header and body-->

        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <script>
      $(document).ready(function() {
        $('#editNextofkin').on('show.bs.modal', function(e) {
          var nokID = $(e.relatedTarget).data('id');
          var kin_action = 'Edit';
          $.ajax({
            type: 'post',
            url: 'Modal_nok.php', //Here you will fetch records 
            data: 'nokID=' + nokID + '&kin_action=' + kin_action, //Pass $id
            success: function(data) {
              $('.fetched-data').html(data); //Show fetched data from database
            }
          });
        });
      });
    </script>

    <!-- Delete Modal-->
    <div class="modal fade" id="delNextofkin">
      <div class="modal-dialog modal-lg">
        <div class="modal-content ">

          <div class="fetched-data"></div> <!--Fetched Header and body-->

        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <script>
      $(document).ready(function() {
        $('#delNextofkin').on('show.bs.modal', function(e) {
          var nokID = $(e.relatedTarget).data('id');
          var kin_action = 'Delete';
          $.ajax({
            type: 'post',
            url: 'Modal_nok.php', //Here you will fetch records 
            data: 'nokID=' + nokID + '&kin_action=' + kin_action, //Pass $id
            success: function(data) {
              $('.fetched-data').html(data); //Show fetched data from database
            }
          });
        });
      });
    </script>
</body>

</html>