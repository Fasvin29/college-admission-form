<?php
include("connection.php");

$query = "SELECT * FROM admissionform"; //fetch all the values and display
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
    <title>Display</title>
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
        <table class="table table-bordered table-striped"> <!-- table creation -->
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Date of birth</th>
                <th>Phone number</th>
                <th>Street address</th>
                <th>City</th>
                <th>State</th>
                <th>Pincode</th>
                <th>Country</th>
                <th>School</th>
                <th>Qualification</th>
                <th>Marks</th>
                <th>Year of passing</th>
                <th>Parent first name</th>
                <th>Parent middle name</th>
                <th>Parent last name</th>
                <th>Parent phone number</th>
                <th>Occupation</th>
                <th>Operations</th>
            </tr>

            <?php
            while ($result = mysqli_fetch_assoc($data)) //fetch the data given by the user and store in table
            {
                
                echo "<tr>
            <td>" . $result['id'] . "</td>
            <td>" . $result['firstName'] . "</td>
            <td>" . $result['middleName'] . "</td>
            <td>" . $result['lastName'] . "</td>
            <td>" . $result['dateOfBirth'] . "</td>
            <td>" . $result['phoneNumber'] . "</td>
            <td>" . $result['StreetAddress'] . "</td>
            <td>" . $result['city'] . "</td>
            <td>" . $result['state'] . "</td>
            <td>" . $result['pincode'] . "</td>
            <td>" . $result['country'] . "</td>
            <td>" . $result['school'] . "</td>
            <td>" . $result['qualification'] . "</td>
            <td>" . $result['marks'] . "</td>
            <td>" . $result['yearofpassing'] . "</td>
            <td>" . $result['parentfirstname'] . "</td>
            <td>" . $result['parentmiddlename'] . "</td>
            <td>" . $result['parentlastname'] . "</td>
            <td>" . $result['parentphonenumber'] . "</td>
            <td>" . $result['occupation'] . "</td>
            <td><div class='d-flex gap-2'>
                    <a class='btn btn-primary' href='edit_design.php?id=$result[id]'>Edit</a> 

                    <a class='btn btn-danger' href='delete.php?id=$result[id]' onclick='return checkdelete()' >Delete</a>
                </div>
                <a class='btn btn-success my-2' data-bs-toggle='modal' data-bs-target='#myModal'>Communication Address</a> 
            </td>
            </tr>";
        }

        // } closing of if condition
        ?>
    </div>
    </table>
                <div class='modal' id='myModal'>
                <div class='modal-dialog modal-lg'>
                    <div class='modal-content'>

                    <div class='modal-header'>
                        <h4 class='modal-title'>Communication Address</h4>
                        <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                    </div>

                    <div class='modal-body'>
                        <div class="table-responsive">
                        
                       <table class='table table-bordered table-striped' > <!-- table creation -->
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

                        // $id2 = $_GET['id'];WHERE admissionid = '$id2'

                        $query2 = "SELECT * FROM communicationaddress ";
                        $data2 = mysqli_query($connection, $query2);


                        while ($result2 = mysqli_fetch_assoc($data2)) //fetch the data given by the user and store in table
                        {
                        echo "<tr>
                        <td>" . $result2['id'] . "</td>
                        <td>" . $result2['streetaddress'] . "</td>
                        <td>" . $result2['city'] . "</td>
                        <td>" . $result2['country'] . "</td>
                        <td>" . $result2['pincode'] . "</td>
                        <td>" . $result2['state'] . "</td>
                        <td>" . $result2['admissionid'] . "</td>
                        <td><div class='d-flex justify-content-center gap-2'>
                                <a class='btn btn-primary' href='edit_communication.php?id=$result2[id]'>Edit</a>  
                                                           
                            </div>
                        </td>
                        </tr>";
                        }
                        ?>
                    </table>
                    </div>

                    <div class='modal-footer'>
                        <button type='button' class='btn btn-danger' data-bs-dismiss='modal'>Close</button>
                    </div>

                    </div>
                </div>
                </div>

    </div>
    <script>
        function checkdelete() // function to confirm delete
        {
            return confirm('Are you sure you want to delete the entire row?');
        }
    </script>
</body>

</html>