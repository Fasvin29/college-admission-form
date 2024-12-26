<?php include("connection.php");

$id = $_GET['id']; // recieves the data which is passed when edit button as clicked

$query = "SELECT * FROM communicationaddress WHERE id= '$id'";

$data = mysqli_query($connection, $query);


$result = mysqli_fetch_assoc($data);


?>

<?php
if (isset($_POST['update'])) {
    $cStreet        = $_POST['cStreetAddress'];
    $cCity          = $_POST['cCity'];
    $cState         = isset($_POST['cState']) ? $_POST['cState'] : '';  // Check if state exists
    $cpincode       = $_POST['cpincode'];
    $cCountry       = isset($_POST['cCountry']) ? $_POST['cCountry'] : '';  // Check if country exists

    // Insert data into admissionform
    $query = "INSERT INTO communicationaddress (streetaddress, city, country, pincode, state) 
    VALUES ('$cStreet', '$cCity', '$cCountry', '$cpincode', '$cState')";
    $data = mysqli_query($connection, $query);

    if ($data) {
        echo "<script>alert('Your application has been updated successfully!')</script>";
?>
        <meta http-equiv="refresh" content="0;url=http://localhost/admissionform/display_communication.php">
<?php
    } else {
        echo "<script>alert('There was an error updating your application. Please try again later.')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Edit form</title>
</head>

<body class="text-bg-dark">
    <section>
        <div class="container my-3">
            <h2 class="text-primary">Edit form</h2>
            <hr>
            <form action="#" method="POST">
                <section>
                    <div>
                        <label for="address" class="form-label h5 mt-3">Communication Address</label>
                        <div id="communicationAddress" class="row">
                            <div class="col-12">
                                <input type="text" class="form-control" placeholder="Street Address"
                                    name="cStreetAddress" value="<?php echo $result['streetaddress']; ?>" required>
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <input type="text" class="form-control" placeholder="City" name="cCity" value="<?php echo $result['city']; ?>" required>
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <select id="cCountry" class="form-select" name="cCountry" required>
                                    <option value="" selected disabled>Country</option>
                                    <option value="us"
                                        <?php if ($result['country'] == 'us') {
                                            echo "selected";
                                        }   ?>>United States</option>
                                    <option value="ca" <?php if ($result['country'] == 'ca') {
                                                            echo "selected";
                                                        }   ?>>Canada</option>
                                    <option value="uk" <?php if ($result['country'] == 'uk') {
                                                            echo "selected";
                                                        }   ?>>United Kingdom</option>
                                    <option value="au" <?php if ($result['country'] == 'au') {
                                                            echo "selected";
                                                        }   ?>>Australia</option>
                                    <option value="in" <?php if ($result['country'] == 'in') {
                                                            echo "selected";
                                                        }   ?>>India</option>
                                    <option value="jp" <?php if ($result['country'] == 'jp') {
                                                            echo "selected";
                                                        }   ?>>Japan</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <input type="number" class="form-control" placeholder="Postal/ Zip Code"
                                    name="cpincode" value="<?php echo $result['pincode']; ?>" required oninput="pincodeValidation(this)">
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <input type="text" class="form-control" placeholder="State" name="state" required value="<?php echo $result['state']; ?>">
                            </div>
                            
                            <br>
                            <br>
                            <br>
                            <hr>
                        </div>
                    </div>
                </section>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                </div>
            </form>
        </div>
    </section>

    <script>
        function calculateAge() {
            const dob = document.getElementById('dateOfBirth').value;
            const birthDate = new Date(dob);
            const currentDate = new Date();

            let ageYears = currentDate.getFullYear() - birthDate.getFullYear();
            let ageMonths = currentDate.getMonth() - birthDate.getMonth();
            let ageDays = currentDate.getDate() - birthDate.getDate();

            //adjusts the negative values (month 2-11 = -9, by adding 12 months it gives 3 and decreases one year)
            if (ageMonths < 0) {
                ageYears--;
                ageMonths += 12;
            }
            if (ageDays < 0) {
                ageMonths--;
                const daysInPrevMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 0).getDate();
                ageDays += daysInPrevMonth;
            }

            document.getElementById('ageYear').value = ageYears + " year" + (ageYears === 1 ? "" : "s");
            document.getElementById('ageMonth').value = ageMonths + " month" + (ageMonths === 1 ? "" : "s");
            document.getElementById('ageDay').value = ageDays + " day" + (ageDays === 1 ? "" : "s");
        }


        //------------------------------------------------------------------------------------------------

        function pincodeValidation(input) {
            let pincode = input.value;
            pincode = pincode.slice(0, 6);

            input.value = pincode;
        }
        const statesByCountry = {
            us: ["California", "Texas", "New York", "Florida"],
            ca: ["Ontario", "Quebec", "British Columbia", "Alberta"],
            uk: ["England", "Scotland", "Wales", "Northern Ireland"],
            au: ["New South Wales", "Victoria", "Queensland", "Western Australia"],
            in: ["Delhi", "Karnataka", "Tamil Nadu", "Kerala", "Mumbai"],
            jp: ["Tokyo", "Osaka", "Hokkaido", "Kyoto"]
        };

     

        const ccountrySelect = document.getElementById('cCountry');
        const cstateSelect = document.getElementById('cState');


        ccountrySelect.addEventListener('change', changeState);

        function changeState() {
            var cselectedCountry = ccountrySelect.value;

            cstateSelect.innerHTML = '<option value="" selected disabled>Choose a state</option>';

            if (statesByCountry[cselectedCountry]) {
                for (var i = 0; i < statesByCountry[cselectedCountry].length; i++) {
                    var cstate = statesByCountry[cselectedCountry][i];
                    var coption = document.createElement('option');
                    coption.value = cstate;
                    coption.textContent = cstate;
                    cstateSelect.appendChild(coption);
                }
            }
        }


        //----------------------------------------------------------------------------------------------------

        function validatePhoneNumber(input) {
            let phoneNumber = input.value.replace(/\D/g, '');

            phoneNumber = phoneNumber.slice(0, 10);

            if (phoneNumber.length > 5) {
                phoneNumber = phoneNumber.slice(0, 5) + ' ' + phoneNumber.slice(5);
            }
            input.value = phoneNumber;
        }

        //---------------------------------------------------------------------------------------------------------
        function comunicationAddress() {
            const isChecked = document.getElementById('check1').checked;

            const streetAddress = document.querySelector('input[name="streetAddress"]').value;
            const city = document.querySelector('input[name="city"]').value;
            const state = document.querySelector('select[name="state"]');
            const postalCode = document.querySelector('input[name="pincode"]').value;
            const country = document.querySelector('select[name="country"]');

            const cStreetAddress = document.querySelector('input[name="cStreetAddress"]');
            const cCity = document.querySelector('input[name="cCity"]');
            const cState = document.querySelector('select[name="cState"]');
            const cPostalCode = document.querySelector('input[name="cpincode"]');
            const cCountry = document.querySelector('select[name="cCountry"]');

            if (isChecked) {
                cStreetAddress.value = streetAddress;
                cCity.value = city;
                cPostalCode.value = postalCode;
                cCountry.value = country.value;
                // Clear existing options and add new options for the communication address state dropdown
                updateStateDropdown(cCountry.value, cState);

                cState.value = state.value;

                cStreetAddress.readOnly = true;
                cCity.readOnly = true;
                cState.disabled = true;
                cPostalCode.readOnly = true;
                cCountry.disabled = true;
            } else {
                cStreetAddress.value = '';
                cCity.value = '';
                cState.value = '';
                cPostalCode.value = '';
                cCountry.value = '';

                cStreetAddress.readOnly = false;
                cCity.readOnly = false;
                cState.disabled = false;
                cPostalCode.readOnly = false;
                cCountry.disabled = false;
            }
        }

        function updateStateDropdown(countryValue, stateSelect) {
            stateSelect.innerHTML = '<option value="" selected disabled>Choose a state</option>';

            const states = statesByCountry[countryValue] || [];
            states.forEach(state => {
                const option = document.createElement('option');
                option.value = state;
                option.textContent = state;
                stateSelect.appendChild(option);
            });
        }
    </script>

</body>

</html>
