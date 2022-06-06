<?php
	include 'db_connect.php';
	$doctor= $conn->query("SELECT * FROM doctors_list ");
	while($row = $doctor->fetch_assoc()){
		$doc_arr[$row['id']] = $row;
	}
	$patient= $conn->query("SELECT * FROM users where type = 3 ");
	while($row = $patient->fetch_assoc()){
		$p_arr[$row['id']] = $row;
	}
?>
<div class="container-fluid">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<button class="btn-primary btn btn-sm" type="button" id="new_appointment"><i class="fa fa-plus"></i> New Outpatient</button>
				<br>
				<table class="table table-bordered">
					<thead>
						<tr style="color: blue;">
                            <th>Id</th>
						<th>Schedule</th>
						<th>Doctor</th>
						<th> Patient Name</th>
                            <th>Phone number</th>
                            <th>Condition</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
					</thead>
					<?php 
					$where = '';
					if($_SESSION['login_type'] == 2)
						$where = " where  doctor_id = ".$_SESSION['login_doctor_id'];
					$qry = $conn->query("SELECT * FROM appointment_list ".$where." order by id desc ");
					while($row = $qry->fetch_assoc()):
					?>
					<tr>
                        <td><?php echo $p_arr[$row['patient_id']]['id'] ?></td>
						<td><?php echo date("l M d, Y h:i A",strtotime($row['schedule'])) ?></td>
						<td><?php echo "DR. ".$doc_arr[$row['doctor_id']]['name'].', '.$doc_arr[$row['doctor_id']]['name'] ?></td>
						<td><?php echo $p_arr[$row['patient_id']]['name'] ?></td>
                        <td><?php echo $p_arr[$row['patient_id']]['contact'] ?></td>
                        <td style="font-size: 20px;">
                            <?php if($row['proc'] == 4): ?>
                                <span class="badge badge-warning">Unknown</span>
                            <?php endif ?>
                            <?php if($row['proc'] == 5): ?>
                                <span class="badge badge-primary">Wound cleaning</span>
                            <?php endif ?>
                            <?php if($row['proc'] == 6): ?>
                                <span class="badge badge-info">Tetanus injection</span>
                            <?php endif ?>
                            <?php if($row['proc'] == 7): ?>
                                <span class="badge badge-info">Stitching and dressing</span>
                            <?php endif ?>
                            <?php if($row['proc'] == 8): ?>
                                <span class="badge badge-info">Wound cleaning and Tetanus Injection</span>
                            <?php endif ?>
                            <?php if($row['proc'] == 9): ?>
                                <span class="badge badge-info">Wound cleaning and Stitching</span>
                            <?php endif ?>
                            <?php if($row['proc'] == 10): ?>
                                <span class="badge badge-info">Tetanus injection and Stitching</span>
                            <?php endif ?>
                            <?php if($row['proc'] == 11): ?>
                                <span class="badge badge-info">Wound cleaning,Tetanus injection,Stitching and dressing</span>
                            <?php endif ?>
                        </td>
						<td>
							<?php if($row['status'] == 0): ?>
								<span class="badge badge-warning">Pending Request</span>
							<?php endif ?>
							<?php if($row['status'] == 1): ?>
								<span class="badge badge-primary">Examined sent to procedure room</span>
							<?php endif ?>
							<?php if($row['status'] == 2): ?>
								<span class="badge badge-info">Rescheduled</span>
							<?php endif ?>
							<?php if($row['status'] == 3): ?>
								<span class="badge badge-info">Attended to</span>
							<?php endif ?>
						</td>
						<td class="text-center">
							<button  class="btn btn-primary btn-sm update_app" type="button" data-id="<?php echo $row['id'] ?>">Update</button>
							<button  class="btn btn-danger btn-sm delete_app" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
						</td>
					</tr>
				<?php endwhile; ?>
				</table>
			</div>
		</div>
	</div>
</div>


<script>

	$('.update_app').click(function(){

		uni_modal("Edit Outpatient Information","set_appointment.php?id="+$(this).attr('data-id'),"mid-large")
	})
	$('#new_appointment').click(function(){
		uni_modal("Add New Outpatient","set_appointment.php","mid-large")
	})
	$('.delete_app').click(function(){
		_conf("Are you sure to delete this Outpatient?","delete_app",[$(this).attr('data-id')])
	})
	function delete_app($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_appointment',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Outpatient data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},3000)

				}
			}
		})
	}

</script>
<?php if($_SESSION['login_type'] == 4): ?>
    <style>
        .delete_app ,#new_appointment,.nav-docto,.nav-categories{
            display: none!important;
        }
    </style>

    <?php elseif ($_SESSION['login_type'] == 2): ?>
        <style>
            .delete_app ,#new_appointment,.nav-docto,.nav-categories{
                display: none!important;
            }
        </style>
<?php endif ?>