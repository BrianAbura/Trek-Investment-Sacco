<?php 
require_once('../defines/functions.php');

if($_REQUEST['AdminId']) {
  $Id = htmlspecialchars(( isset( $_REQUEST['AdminId'] ) )?  $_REQUEST['AdminId']: null);
  $sysUser = DB::queryFirstRow('SELECT * from systemusers where Id=%s', $Id);
  $sysRole = DB::queryFirstRow('SELECT Designation from roles where RoleId=%s', $sysUser['Role']);
}
?>
<!--Edit Savings modal-->
<div class="modal-header bg-navy color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title">Edit Role - <?php echo $sysUser['Fullname'];?> </h5>
      </div>
      <div class="modal-body">
      <form role="form" class="form-content" method="POST" action="ManageAdmins.php" enctype="multipart/form-data">
      <input type="hidden" value="<?php echo $sysUser['Id'];?>" name="EditMemID">
      <input type="hidden" value="Edit_Admin" name="AdminAction">
            <div class="box-body">
              
			<div class="row">
               <div class="form-group col-sm-3">
                <label for="SelectMem">Role Assigned</label>
                <select class="form-control" name="Role" id="Role" required>
                <option value="<?php echo $sysUser['Role'];?>"><?php echo $sysRole['Designation']; ?></option>
                <?php 
                $roles = DB::query('SELECT * from roles');
                foreach($roles as $role){
                  if (($role['Designation'] == "Member") || ($role['Designation'] == $sysRole['Designation'])) {
                    continue;
                }
                ?>
                <option value="<?php echo $role['RoleId'];?>"><?php echo $role['Designation'];?></option>
                <?php }?>
                </select>
                </div>

                <div class="form-group col-sm-3">
                <label for="SelectMem">Status</label>
                <select class="form-control" name="AccStatus" id="AccStatus" >
                <option value="<?php echo $sysUser['AccStatus']; ?>"><?php echo $sysUser['AccStatus']; ?></option>
                <option vaue="Active">Active</option>
                <option vaue="Inactive">Inactive</option>
                </select>
                </div>

                <div class="form-group">
                <label class="col-md-4 control-label">Signature</label>
                <div class="col-md-5">
                  <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="input-append">
                      <div class="uneditable-input">
                        <span class="fileupload-preview" style="font-size: 12px; color:blue"></span>
                      </div>
                      <span class="btn btn-default btn-file">
                        <span class="fileupload-exists">Change</span>
                        <span class="fileupload-new">Select file</span>
                        <input type="file" name="SignatureUpload" onchange="ValidateSingleInput(this);"/>
                      </span>
                      <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                      <p class="help-block">Accepted Formats: jpg, jpeg and png</p>
                      <?php echo str_replace('../fileUploads/signatures/', '', $sysUser['Signature']);?>
                    </div>
                  </div>
                </div>
              </div>
			</div>
            </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Update Record</button>
              </div>
            </form> 
      </div>
      <!--Comma On Amounts -->