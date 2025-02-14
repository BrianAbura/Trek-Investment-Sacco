<?php 
require_once('../defines/functions.php');

if($_REQUEST['scheduleSMSID']) {
  $Id = htmlspecialchars(( isset( $_REQUEST['scheduleSMSID'] ) )?  $_REQUEST['scheduleSMSID']: null);
  $scheduleSMS= DB::queryFirstRow('SELECT * from scheduledsms where Id=%s', $Id);
  $schedule = explode(" ", $scheduleSMS['Schedule']);
  $date = date_format(date_create($schedule[0]), 'd-m-Y');
  $time = date_format(date_create($schedule[1]), 'H:i');
}
?>
<!--Edit Savings modal-->
<div class="modal-header bg-navy color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title"> <?php echo "Edit SMS Message"; ?> </h5>
      </div>
      <div class="modal-body">
      <form class="form-content" method="POST" action="ManageScheduledSMS.php" enctype="multipart/form-data">
      <input type="hidden" value="<?php echo $scheduleSMS['Id']?>" name="scheduleSMSID">
      <div class="box-body">
			  <div class="row">
			  <div class="form-group col-sm-4">
          <label for="InputName">Receiver:</label>
          <input class="form-control" id="SMSMember" value="<?php echo $scheduleSMS['MSISDN']?>" readonly>
        </div>

        <div class="form-group col-sm-5">
          <label for="InputPhone">Message</label>
          <textarea class="form-control" name="SMSmessage" rows="4" cols="50"  onkeyup="countChar(this)" required><?php echo $scheduleSMS['Message']?></textarea>
          <div id="charNum"></div>
        </div>

        <div class="form-group col-sm-3">
          <label for="InputPhone"> <i style="cursor:pointer;color:teal;font-size:15px" title="Information" class="fa fa-info-circle"></i></label>
        <h6>1 Message = 160 Characters<br/>
            2 Messages = 310 Characters
        </h6>
        </div>   
				<!-- /.First Row -->
        </div>

        <div class="row scheduledSMS">
        <br/>
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