  <footer class="main-footer">
   Copyright &copy; <?php echo date("Y");?>  <strong><a href="#">TREK Investment Club</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- datepicker -->
<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Timepicker -->
<script src="../plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- DataTables -->
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- Select2 -->
<script src="../bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- BoostrapFileUpload -->
<script src="../bower_components/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- Tables to Excel -->
<script src="../dist/js/table2excel.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- Magnific - Image Popup -->
<script src="../bower_components/magnific-popup/magnific-popup.js"></script>
<!-- Magnific PoUp - Examples -->
<script src="../bower_components/magnific-popup/examples.lightbox.js"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>



<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })

	function delRecord(id,table,ctype){
		//Prompt user to confirm
		alertify.confirm('Delete Record!', 'Are you sure you want to delete this '+ctype+' record?', function(){ 
      var hr = new XMLHttpRequest();
	     var url = "deleteRecords.php";
	//Post to file without refreshing page
    var vars = "RowId="+id+"&Table="+table+"&Ctype="+ctype;
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			alertify.alert('Response',return_data);
			function redirect(){window.location.reload();}
			setTimeout(redirect, 1500);
		}	}
    hr.send(vars);
  }, 
  function(){ alertify.error('Action Cancelled')});
		}
</script>

<!--Comma On Amounts -->
<script>
$('.CommaAmount').keyup(function(event) {
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
<!--Comma on Amounts -->

<!--TableExportToExcel -->
<script type="text/javascript">
        function ExportToExcel($tableId, $tableName) {
            $("#"+$tableId).table2excel({
                filename: $tableName+".xls"
            });
        }
    </script>
<!--Comma on Amounts -->

<!--Alerts Starts -->
	<?php
	if(isset($_SESSION['Success'])){
    ?>
    <script>
  	alertify.alert("Success","<?php echo $_SESSION['Success'];?>");
    </script>
    <?php
    unset($_SESSION['Success']);
    } 
  	if(isset($_SESSION['Error'])){
    ?>
    <script>
  	alertify.alert("Error","<?php echo $_SESSION['Error'];?>");
      </script>
    <?php 
    unset($_SESSION['Error']);
      } 
  ?>
<!--Alerts Ends -->

<script>
  //Image Validation
  var _validFileExtensions = [".jpg", ".jpeg", ".png"];    
function ValidateSingleInput(oInput) {
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
            if (!blnValid) {
                alertify.alert("Error","Sorry, the file type is invalid, allowed file extensions are: jpg, jpeg and png");
                oInput.value = "";
                return false;
            }
        }
    }
    return true;
}
</script>