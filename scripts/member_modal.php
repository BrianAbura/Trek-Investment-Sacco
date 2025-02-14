
<?php 
require_once('../defines/functions.php');

if(isset($_REQUEST['MembershipNumber'])) {
  $MemberID = htmlspecialchars(( isset( $_REQUEST['MembershipNumber'] ) )?  $_REQUEST['MembershipNumber']: null);
  $Member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $MemberID);
?>
<!--Edit Client modal-->
<div class="modal-header bg-navy color-palette">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
    <h5 class="modal-title">Edit Member</h5>
    </div>
    <div class="modal-body">
    <form role="form" class="form-content" method="POST" action="ManageMembers.php" enctype="multipart/form-data">
    <input type="hidden" id="MemAction" name="MemAction" value="Edit_MEM">
    <input type="hidden" id="EditMemID" name="EditMemID" value="<?php echo $MemberID;?>">
              <div class="box-body">
			<div class="row">
				<div class="form-group col-sm-4">
          <label for="InputName">Fullname</label>
          <input type="text" class="form-control" id="InputName" name="Name" value="<?php echo $Member['Fullname']?>" required>
        </div>

        <div class="form-group col-sm-3">
          <label for="exampleInputEmail1">Email Address</label>
          <input type="email" class="form-control" id="exampleInputEmail1" name="EmailAddress" value="<?php echo $Member['EmailAddress']?>" required>
        </div>

        <div class="form-group col-sm-3">
          <label for="InputPhone">Phone Number</label>
          <input type="text" class="form-control" id="InputPhone" name="MSISDN" value="<?php echo $Member['MSISDN']?>" required>
        </div>
			</div>
      <br/>


      <div class="row">
        <div class="form-group col-sm-4">
          <label for="exampleInputEmail1">National ID / Passport No</label>
          <input type="text" class="form-control" id="exampleInputEmail1" name="IDNum" value="<?php echo $Member['IDNum']?>" required>
        </div>

        <div class="form-group col-sm-4">
          <label for="InputOccupation">Workplace/Employer</label>
          <input type="text" class="form-control" id="InputOccupation" name="Workplace"  value="<?php echo $Member['Workplace']?>">
        </div>

        <div class="form-group col-sm-4">
          <label for="InputPhone">Residence</label>
          <input type="text" class="form-control" id="InputPhone" name="Residence" value="<?php echo $Member['Residence']?>" >
        </div>
			</div>
				</br>


      <div class="row">
        <div class="form-group col-sm-3">
          <label for="exampleInputEmail1">Postal Address</label>
          <textarea class="form-control" name="Postal_Address" id="Postal_Address" rows="3" cols="5"  ><?php echo $Member['Postal_Address']?></textarea>
        </div>

        <div class="form-group col-sm-3">
        <label for="datepicker">Date of Joining</label>
        <div class="input-group date">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="text" class="form-control" name="joining_date"  id="ModalDatepicker" value="<?php echo $Member['Joining_date']?>" required>
          
        </div>
        </div>

        <div class="form-group">
                <label class="col-md-6 control-label">Profile Photo</label>
                <div class="col-md-6">
                  <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="input-append">
                      <div class="uneditable-input">
                        <span class="fileupload-preview" style="font-size: 12px; color:blue"></span>
                      </div>
                      <span class="btn btn-default btn-file">
                        <span class="fileupload-exists">Change</span>
                        <span class="fileupload-new">Select file</span>
                        <input type="file" name="ProfilePicture" onchange="ValidateSingleInput(this);"/>
                      </span>
                      <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                      <?php echo str_replace('../fileUploads/profiles', '', $Member['ProfilePicture']);?>
                      <p class="help-block">Accepted Formats: jpg, jpeg and png</p>
                    </div>
                  </div>
                </div>
              </div>
			</div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-success">Update</button>
              </div>
            </form>   
    </div>
<?php } ?>
<script>

    //Date picker
   </script>
    

    