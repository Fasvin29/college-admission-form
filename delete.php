<?php include("connection.php");

$id = $_GET['id']; // recieves the data which is passed when delete button as clicked

$query = "DELETE FROM admissionform WHERE id='$id'"; //Delete the row with reference 'id'
$data = mysqli_query($connection, $query);

if($data)
{
    echo "<script>alert('Your row has been deleted successfully!')</script>";
    ?>
        <meta http-equiv="refresh" content="0;url=http://localhost/admissionform/display.php">
        <?php
}
else
{
    echo "<script>alert('There was an error in deleting your row. Please try again later.')</script>";
 
}
?>