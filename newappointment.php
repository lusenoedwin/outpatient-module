<?php
session_start();
include ('db_connect.php');
$doctor= $conn->query("SELECT * FROM doctors_list ");
while($row = $doctor->fetch_assoc()){
    $doc_arr[$row['id']] = $row;
}
$patient= $conn->query("SELECT * FROM users where type = 3 ");
while($row = $patient->fetch_assoc()){
    $p_arr[$row['id']] = $row;
}
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM appointment_list where id =".$_GET['id']);
    foreach ($qry->fetch_array() as $key => $value) {
        $$key = $value;
    }

}

?>
<style>
    #uni_modal .modal-footer{
        display: none
    }
</style>
<div class="container-fluid">
    <div class="col-lg-12">
        <div id="msg"></div>
        <form action="" id="manage-appointment">
            <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
            <?php if($_SESSION['login_type'] == 2): ?>
                <input type="hidden" name="doctor_id" value="<?php echo isset($_SESSION['login_doctor_id']) ? $_SESSION['login_doctor_id'] : ''; ?>">
            <?php else: ?>
                <div class="form-group">
                    <label for="" class="control-label">Doctor</label>
                    <select class="browser-default custom-select select2" name="doctor_id">
                        <option value=""></option>
                        <?php foreach($doc_arr as $row): ?>
                            <option value="<?php echo $row['id'] ?>" <?php echo isset($doctor_id) && $doctor_id == $row['id'] ? 'selected' : '' ?>><?php echo "DR. ".$row['name'].', '.$row['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="" class="control-label" >Patient Name*</label>

                <select class="browser-default custom-select select2" name="patient_id" readonly="">
                    <option value=""></option>
                    <?php foreach($p_arr as $row): ?>
                        <option value="<?php echo $row['id'] ?>" <?php echo isset($patient_id) && $patient_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Phone Number</label>
                <input type="number"  name="phone" class="form-control" value="<?php echo $row['contact'] ?>" required>
            </div>

            <div class="form-group">
                <label for="" class="control-label">Condition</label>
                <select class="browser-default custom-select" name="proc">
                    <option value="4" <?php echo isset($proc) && $proc == 4 ? "selected" : '' ; ?>>Wound cleaning</option>
                    <option value="5" <?php echo isset($proc) && $proc == 5 ? "selected" : '' ; ?>>Tetanus Injection</option>
                    <option value="6" <?php echo isset($proc) && $proc == 6 ? "selected" : '' ; ?>>Stitching and dressing</option>

                </select>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Date</label>
                <input type="date"  name="date" class="form-control" value="<?php echo isset($schedule) ? date("Y-m-d",strtotime($schedule)) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="" class="control-label">Time</label>
                <input type="time"  name="time" class="form-control" value="<?php echo isset($schedule) ? date("H:i",strtotime($schedule)) : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="" class="control-label">Status</label>
                <select class="browser-default custom-select" name="status">
                    <option value="0" <?php echo isset($status) && $status == 0 ? "selected" : '' ; ?>>Request</option>
                    <option value="1" <?php echo isset($status) && $status == 1 ? "selected" : '' ; ?>>Examined sent to procedure room</option>
                    <option value="2" <?php echo isset($status) && $status == 2 ? "selected" : '' ; ?>>Rescheduled</option>
                    <option value="3" <?php echo isset($status) && $status == 3 ? "selected" : '' ; ?>>Attended to.</option>
                </select>
            </div>


            <hr>
            <div class="col-md-12 text-center">
                <button class="btn-primary btn btn-sm col-md-4">Update</button>
                <button class="btn btn-secondary btn-sm col-md-4  " type="button" data-dismiss="modal" id="">Close</button>
            </div>
        </form>
    </div>
</div>

<script>

    $("#manage-appointment").submit(function(e){
        e.preventDefault()
        start_load()
        $.ajax({
            url:'ajax.php?action=set_appointment',
            method:'POST',
            data:$(this).serialize(),
            success:function(resp){
                resp = JSON.parse(resp)
                if(resp.status == 1){
                    alert_toast("Outpatient data added successfully");
                    // end_load();
                    $('.modal').modal("hide");
                    setTimeout(function(){
                        location.reload();
                    },1500)
                }else{
                    $('#msg').html('<div class="alert alert-danger">'+resp.msg+'</div>')
                    end_load();
                }
            }
        })
    })
</script>

