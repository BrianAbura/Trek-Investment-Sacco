<?php
require_once('../defines/functions.php');

if ($_REQUEST['kin_action'] == 'Edit') {
    $nok_id = htmlspecialchars((isset($_REQUEST['nokID'])) ?  $_REQUEST['nokID'] : null);
    $nok_member = DB::queryFirstRow('SELECT * from next_of_kin where Id=%s', $nok_id);
?>
    <div class="modal-header bg-blue">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title">Update Next Of Kin Details</h5>
    </div>
    <form role="form" class="form-content" method="POST" action="ManageNextofKin.php">
        <input type="hidden" name="kin_action" value="Edit">
        <input type="hidden" name="MembershipNumber" value="<?php echo $nok_member['MembershipNumber']; ?>">
        <input type="hidden" name="nok_id" value="<?php echo $nok_id; ?>">
        <div class="modal-body mt-2">
            <div class="form-group col-sm-3">
                <label for="Amount">Fullname</label>
                <input type="text" class="form-control" name="Fullname" value="<?php echo $nok_member['Fullname']; ?>" required autocomplete="off" />
            </div>
            <div class="form-group col-sm-3">
                <label for="Amount">Phone Number</label>
                <input type="text" class="form-control" name="Phone_Number" value="<?php echo $nok_member['MSISDN']; ?>" required autocomplete="off" />
            </div>
            <div class="form-group col-sm-3">
                <label for="Amount">Email Address</label>
                <input type="email" class="form-control" name="Email_Address" value="<?php echo $nok_member['EmailAddress']; ?>" required autocomplete="off" />
            </div>
            <div class="form-group col-sm-3">
                <label for="Amount">Relationship</label>
                <input type="text" class="form-control" name="Relationship" value="<?php echo $nok_member['Relation']; ?>" required autocomplete="off" />
            </div>
        </div>
        <div class="modal-footer mt-2">
            <button type="submit" class="btn btn-success">Update Details</button>
            <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
        </div>
    </form>
<?php } ?>

<?php
// Delete the nxt of Kin
if ($_REQUEST['kin_action'] == 'Delete') {
    $nok_id = htmlspecialchars((isset($_REQUEST['nokID'])) ?  $_REQUEST['nokID'] : null);
    $nok_member = DB::queryFirstRow('SELECT * from next_of_kin where Id=%s', $nok_id);
    $member = DB::queryFirstRow('SELECT * from members where MembershipNumber=%s', $nok_member['MembershipNumber']);
?>
    <div class="modal-header bg-blue">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title">Delete Next Of Kin</h5>
    </div>
    <form role="form" class="form-content" method="POST" action="ManageNextofKin.php">
        <input type="hidden" name="kin_action" value="Delete">
        <input type="hidden" name="MembershipNumber" value="<?php echo $nok_member['MembershipNumber']; ?>">
        <input type="hidden" name="nok_id" value="<?php echo $nok_id; ?>">
        <div class="modal-body mt-2">
            <strong>
                <h4 class="text-danger text-center">Are you sure you want to remove <?php echo $nok_member['Fullname']; ?> as <?php echo $member['Fullname']; ?>'s Next of kin?</h4>
            </strong>
        </div>
        <div class="modal-footer mt-2">
            <button type="submit" class="btn btn-success">Confirm Delete</button>
            <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
        </div>
    </form>
<?php } ?>