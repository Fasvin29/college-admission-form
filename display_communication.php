<?php
include("connection.php");

$query = "SELECT * FROM communicationaddress"; //fetch all the values and display
$data = mysqli_query($connection, $query); //it is used to execute queries on a MySQL database. It allows you to send SQL queries to the database.
$total = mysqli_num_rows($data); //no. of rows(entries) in the table

// you can use if condition if you want to display the table, only if the table contains entry (if no entries, blank page will be displayed)
// if ($total !=0)
// {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Communication Address</title>
</head>

<body>
<nav class="navbar navbar-expand-sm fixed-top text-bg-dark navbar-dark">
    <div class="container-fluid d-flex my-2">
        <h5 class="mx-5">LOGO</h5>
        <a class="btn btn-primary me-5 active" href="#">Display table</a>
        <a class="btn btn-primary ms-auto me-5" href="http://localhost/admissionform/">Add new</a>
    </div>
</nav>

    <div class="table-responsive mt-5 pt-3">
    <table class="table table-bordered table-striped" > <!-- table creation -->
        <tr>
            <th>ID</th>
            <th>Street Address</th>
            <th>City</th>
            <th>Country</th>
            <th>Pincode</th>
            <th>State</th>
            <th>Admission ID</th>
            <th>Operations</th>
        </tr>

        <?php
        while ($result = mysqli_fetch_assoc($data)) //fetch the data given by the user and store in table
        {
            echo "<tr>
            <td>" . $result['id'] . "</td>
            <td>" . $result['streetaddress'] . "</td>
            <td>" . $result['city'] . "</td>
            <td>" . $result['country'] . "</td>
            <td>" . $result['pincode'] . "</td>
            <td>" . $result['state'] . "</td>
            <td>" . $result['admissionid'] . "</td>
            <td><div class='d-flex justify-content-center gap-2'>
                    <a class='btn btn-primary' href='edit_communication.php?id=$result[id]'>Edit</a> 
                    
                </div>
                </td>
        </tr>";
        }

        // } closing of if condition
        ?>
    </table>
    </div>
    <!-- <script>
        function checkdelete() // function to confirm delete
        {
            return confirm('Are you sure you want to delete the entire row?');
        }
    </script> -->
</body>

</html>