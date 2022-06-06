<?php
//// include 'db_connect.php';
//
//
//$con  = mysqli_connect("localhost","root","","outpatientmodule");
//if (!$con) {
//    # code...
//    echo "Problem in database connection! Contact administrator!" . mysqli_error();
//}else {
//    $sql = "SELECT * FROM appointment_list WHERE status=3";
//    $result = mysqli_query($con, $sql);
//    $chart_data = "";
//    while ($row = mysqli_fetch_array($result)) {
//
//
////        $wound = $row['status'];
////        $tetanus = $row['id'];
//
//        $wound = mysqli_field_count($row['status']);
//
//
//    $dataPoints = array(
//
//        array("y" => $wound, "label" => "Wound cleaning"),
//        array("y" => 0, "label" => "Tetanus injection"),
//        array("y" => 0, "label" => "Stitching and dressing"),
//
//    );
//}
//}
//?>

<?php
$con  = mysqli_connect("localhost","root","","outpatientmodule");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}



$sql="SELECT status,proc FROM appointment_list WHERE  status=3 && proc=5;";
$sql1="SELECT status,proc FROM appointment_list WHERE  status=3 && proc=6;";
$sql2="SELECT status,proc FROM appointment_list WHERE  status=3 && proc=7;";

if ($result=mysqli_query($con,$sql)) {
    // Return the number of rows in result set
    $rowcount = mysqli_num_rows($result);
//    printf("Result set has %d rows.\n",$rowcount);
    // Free result set
    mysqli_free_result($result);
    if ($result1 = mysqli_query($con, $sql1)) {

        // Return the number of rows in result set
        $rowcount1 = mysqli_num_rows($result1);
//    printf("Result set has %d rows.\n",$rowcount);
        // Free result set
        mysqli_free_result($result1);

        if ($result2 = mysqli_query($con, $sql2)) {

            // Return the number of rows in result set
            $rowcount2 = mysqli_num_rows($result2);
//    printf("Result set has %d rows.\n",$rowcount);
            // Free result set
            mysqli_free_result($result2);

            $dataPoints = array(

                array("y" => $rowcount, "label" => "Wound cleaning"),
                array("y" => $rowcount1, "label" => "Tetanus injection"),
                array("y" => $rowcount2, "label" => "Stitching and dressing"),

            );
        }
    }
}
mysqli_close($con);
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<script>
window.onload = function() {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title:{
		text: "Outpatient procedure room reports & Analytics"
	},
	axisY: {
		title: "No of Patients",
		includeZero: true,
		prefix: "",
		suffix:  "Patients"
	},
	data: [{
		type: "bar",
		yValueFormatString: "",
		indexLabel: "{y}",
		indexLabelPlacement: "inside",
		indexLabelFontWeight: "bolder",
		indexLabelFontColor: "white",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>          