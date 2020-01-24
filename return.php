<?php
session_start();
if(!isset($_SESSION['loggedin'])){
header('Location: index.php');
exit();
}
?>

<!DOCTYPE html>
<html>
<?php
include('header.php')
?>


<body class="form-v8 loggedin" id="fade">

<div id="loader">
    <div class="loader"><div></div><div></div><div></div><div></div></div>
</div>

<?php include('navbar.php'); ?>

<div class="content">
    <div>
        <h2>Return</h2>

        <p>
            <?php
            include('serverconnect.php');
            $name = $_SESSION['name'];
            $user_id = $_SESSION['id'];
            $resultset = mysqli_query($db, "
select l.equipment_id, l.returnDate, E.equipment, e.leftQuantity,l.users_id,l.checkoutRequests_id
from EqManage.log L 
left JOIN EqManage.equipment E on L.equipment_id = E.id 
where l.returnDate is null
");
            echo $user_id;
//            while ($row = mysqli_fetch_array($resultset)){
//                if($row['users_id'] = $user_id){
//                    echo $row['equipment_id'];
//                    $equipmentName = $row['equipment'];
//                    $equipmentID = $row['equipment_id'];
//                    echo "<option value='$equipmentID' >$equipment</option>";
//                }
//
//
//
//            }




            ?>
        <div class="select-style" style="width:500px; margin: auto">
            <form action="confirmation.php" style="width: 100%;" method="POST">
                <select name="equipment" class="select-picker" onchange="getID(this)">
                    <option value=""  disabled selected>Select the Equipment</option>
                    <?php
                    while ($row = mysqli_fetch_array($resultset)){
                        if($row['users_id'] = $user_id){
                            echo $row['equipment_id'];
                            $equipmentName = $row['equipment'];
                            $equipmentID = $row['equipment_id'];
                            $checkoutRequestsID = $row['checkoutRequests_id'];
                            echo $checkoutRequestsID;
                            echo "<option value='$equipmentID' data-checkoutRequestsID='$checkoutRequestsID'>$equipmentName</option>";
                        }



                    }
                    ?>
                </select>
                <input type="hidden" id="checkoutRequestsID" name="checkoutRequestsID" value="">
                <input name="request" type="submit" value="Return" style="width: 100%; margin-top: 20px">
            </form>
        </div>
        </p>

    </div>

</div>
<script>
    function getID(id) {
        id = id.options[id.selectedIndex].getAttribute('data-checkoutRequestsID');
        console.log(id);
        document.getElementById("checkoutRequestsID").setAttribute("value",id);

    }
</script>
