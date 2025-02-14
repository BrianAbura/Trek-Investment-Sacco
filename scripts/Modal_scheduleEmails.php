<?php 
require_once('../defines/functions.php');

if($_REQUEST['scheduleEmailID']) {
  $Id = htmlspecialchars(( isset( $_REQUEST['scheduleEmailID'] ) )?  $_REQUEST['scheduleEmailID']: null);
  $scheduleEmail = DB::queryFirstRow('SELECT * from scheduledemails where Id=%s', $Id);
  $schedule = explode(" ", $scheduleEmail['Schedule']);
  $date = date_format(date_create($schedule[0]), 'd-m-Y');
  $time = date_format(date_create($schedule[1]), 'H:i');
}
?>
<!--Edit Savings modal-->
<div class="modal-header bg-navy color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title"> <?php echo "Edit Email: ".$scheduleEmail['Subject']; ?> </h5>
      </div>
      <div class="modal-body">
      <form class="form-content" method="POST" action="ManageScheduledEmails.php" enctype="multipart/form-data">
      <input type="hidden" value="<?php echo $scheduleEmail['Id']?>" name="scheduleEmailID">
      <div class="box-body">
              <div class="form-group">
              <label>Receiver Name</label>
              <input class="form-control" id="EmailSubject" value="<?php echo $scheduleEmail['ReceiverName']?>" readonly>
              </div>
              <div class="form-group">
              <label>Receiver Email</label>
                  <input class="form-control" id="EmailSubject" value="<?php echo $scheduleEmail['ReceiverEmail']?>" readonly>
              </div>
              <div class="form-group">
              <label>Subject</label>
                  <input class="form-control" id="EmailSubject" name="EmailSubject" value="<?php echo $scheduleEmail['Subject']?>" required>
              </div>
              <div class="form-group">
              <label>Message</label>
                    <textarea id="EmailBody" name="EmailBody" class="form-control" style="height: 100px" required><?php echo $scheduleEmail['Message']?></textarea>
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
                        <?php echo $scheduleEmail['Attachments'];?>
                        <p class="help-block">Max 10MB || Accepted Formats: jpg, jpeg and png</p>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <br/>
        
        <div class="row scheduledSMS">
		    <div class="form-group col-sm-4">
          <label>Scheduled Date:</label>
          <div class="input-group date">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right" name="scheduleDate" value="<?php echo $date;?>" />
          </div>
          <!-- /.input group -->
        </div>
        <div class="form-group col-sm-4">
          <label>Scheduled Time:</label>
          <div class="input-group">
            <input type="text" class="form-control timepicker" name="scheduleTime" value="<?php echo $time;?>" />
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
        <button type="submit" class="btn btn-success">Update Schedule</button>
      </div>
    </form>  
      </div>
      <!--Comma On Amounts -->

<script>
    $(function () {
    $('#example1').DataTable()

     //Timepicker
     $('.timepicker').timepicker({
      showInputs: false,
      showMeridian: false,
      minuteStep: 10,
    })
  });

  $(function () {
    //Add text editor
    $("#EmailBody").wysihtml5({});
  });
</script>