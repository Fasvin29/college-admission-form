<?php include("connection.php");

$id = $_GET['id']; // recieves the data which is passed when edit button as clicked

$query = "SELECT * FROM admissionform WHERE id= '$id'";
$query2 = "SELECT * FROM communicationaddress WHERE id= '$id'";

$data = mysqli_query($connection, $query);
$data2 = mysqli_query($connection, $query2);


$result = mysqli_fetch_assoc($data);
$result2 = mysqli_fetch_assoc($data2);


?>

<?php
if (isset($_POST['update'])) {
    $fname         = $_POST['firstName'];
    $mname         = $_POST['middleName'];
    $lname         = $_POST['lastName'];
    $dob           = $_POST['dateOfBirth'];
    $ph            = $_POST['phoneNumber'];
    $street        = $_POST['streetAddress'];
    $city          = $_POST['city'];
    $state         = $_POST['state'];
    $pincode       = $_POST['postalCode'];
    $country       = $_POST['country'];
    $school        = $_POST['schoolName'];
    $qualification = $_POST['qualification'];
    $marks         = $_POST['marks'];
    $yop           = $_POST['yearOfPassing'];
    $pfname        = $_POST['parentFirstName'];
    $pmname        = $_POST['parentMiddleName'];
    $plname        = $_POST['parentLastName'];
    $pph           = $_POST['parentPhoneNumber'];
    $occupation    = $_POST['occupation'];

    $cStreet        = $_POST['cStreetAddress'];
    $cCity          = $_POST['cCity'];
    $cState         = isset($_POST['cState']) ? $_POST['cState'] : '';  // Check if state exists
    $cpincode       = $_POST['cpincode'];
    $cCountry       = isset($_POST['cCountry']) ? $_POST['cCountry'] : '';  // Check if country exists

    // Insert data into admissionform
    $query = "INSERT INTO admissionform (firstName, middleName, lastName, dateOfBirth, phoneNumber, streetAddress, city, state, pincode, country, school, qualification, marks, yearofpassing, parentfirstname, parentmiddlename, parentlastname, parentphonenumber, occupation) 
              VALUES ('$fname', '$mname', '$lname', '$dob', '$ph', '$street', '$city', '$state', '$pincode', '$country', '$school', '$qualification', '$marks', '$yop', '$pfname', '$pmname', '$plname', '$pph', '$occupation')";
    $data = mysqli_query($connection, $query);

    if ($data) { 
            echo "<script>alert('Your application has been updated successfully!')</script>";
?>
            <meta http-equiv="refresh" content="0;url=http://localhost/admissionform/display.php">
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
                        <label for="fullName" class="form-label h5 mt-3">Full Name of Applicant</label>
                        <div id="fullName" class="row">
                            <div class="col-12 col-md-6 col-lg-4 mt-3">
                                <input type="text" class="form-control" placeholder="First" name="firstName" value="<?php echo $result['firstName']; ?>">
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mt-3">
                                <input type="text" class="form-control" placeholder="Middle" name="middleName" value="<?php echo $result['middleName']; ?>">
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mt-3">
                                <input type="text" class="form-control" placeholder="Last" name="lastName" value="<?php echo $result['lastName']; ?>">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="dateOfBirth" class="form-label h5 mt-3">Date of birth</label>
                        <input type="date" class="form-control" id="dateOfBirth" placeholder="Date of Birth" min="1950-01-01" max="<?php echo date('Y-m-d'); ?>" onchange="calculateAge()"
                            name="dateOfBirth" value="<?php echo $result['dateOfBirth']; ?>">
                    </div>
                    <div class="d-flex mt-3">
                        <label class="form-label h5 me-3">Age</label>
                        <input type="text" class="form-control me-3" id="ageYear" placeholder="Year" name="ageYear" readonly>
                        <input type="text" class="form-control me-3" id="ageMonth" placeholder="Month" name="ageMonth" readonly>
                        <input type="text" class="form-control" id="ageDay" placeholder="Days" name="ageDay" readonly>
                    </div>
                    <div>
                        <label for="phoneNumber" class="form-label h5 mt-3">Applicant's Phone</label>
                        <input type="text" class="form-control" id="phoneNumber" placeholder="" value="<?php echo $result['phoneNumber'] ?>" name="phoneNumber" oninput="validatePhoneNumber(this)" required>
                    </div>
                    <div>
                        <label for="address" class="form-label h5 mt-3">Permanent Address</label>
                        <div id="address" class="row">
                            <div class="col-12">
                                <input type="text" class="form-control" placeholder="Street Address"
                                    name="streetAddress" value="<?php echo $result['StreetAddress']; ?>">
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <input type="text" class="form-control" placeholder="City" name="city" value="<?php echo $result['city']; ?>">
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <select id="country" class="form-select" name="country" required>
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
                                    name="postalCode" value="<?php echo $result['pincode']; ?>">
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <input type="text" class="form-control" placeholder="State" name="state" value="<?php echo $result['state']; ?>">
                            </div>
                        </div>
                </section>
                <section>
                    <h4>Education details</h4>
                    <div>
                        <label for="schoolName" class="form-label h5 mt-3">Last school/ College Name</label>
                        <input type="text" class="form-control" id="schoolName" placeholder="" name="schoolName" value="<?php echo $result['school']; ?>">
                    </div>
                    <div>
                        <label for="qualificatin" class="form-label h5 mt-3">Highest Qualification</label>
                        <input type="text" class="form-control" id="qualificatin" placeholder="" name="qualification" value="<?php echo $result['qualification']; ?>">
                    </div>
                    <div>
                        <label for="marks" class="form-label h5 mt-3">Marks/ Percentage/ Grade</label>
                        <input type="text" class="form-control" id="marks" placeholder="" name="marks" value="<?php echo $result['marks']; ?>">
                    </div>
                    <div>
                        <label for="yearOfPassing" class="form-label h5 mt-3">Year Of Passing</label>
                        <input type="number" class="form-control" id="yearOfPassing" placeholder="" name="yearOfPassing" value="<?php echo $result['yearofpassing']; ?>">
                    </div>
                    <!-- <div>
                        <label for="yearOfPassing" class="form-label h5 mt-3">Year Of Passing</label>
                        <select class="form-control" id="yearOfPassing" name="yearOfPassing" required>
                            <?php
                            $currentYear = date('Y');
                            for ($year = 1950; $year <= $currentYear; $year++) {
                                $selected = ($year == $currentYear) ? 'selected' : '';
                                echo "<option value='$year' $selected>$year</option>";
                            }
                            ?>
                        </select>
                    </div> -->
                    <hr>
                </section>
                <section>
                    <div>
                        <label for="parentFullName" class="form-label h5 ">Parent/ Guardian's Name</label>
                        <div id="parentFullName" class="row">
                            <div class="col-12 col-md-6 col-lg-4 mt-3">
                                <input type="text" class="form-control" placeholder="First" name="parentFirstName" value="<?php echo $result['parentfirstname']; ?>">
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mt-3">
                                <input type="text" class="form-control" placeholder="Middle" name="parentMiddleName" value="<?php echo $result['parentmiddlename']; ?>">
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mt-3">
                                <input type="text" class="form-control" placeholder="Last" name="parentLastName" value="<?php echo $result['parentlastname']; ?>">
                            </div>
                            <div>
                                <label for="parentPhoneNumber" class="form-label h5 mt-3">Parent/ Guardian's
                                    Phone</label>
                                <input type="text" class="form-control" id="parentPhoneNumber"
                                    placeholder="" name="parentPhoneNumber" value="<?php echo $result['parentphonenumber']; ?>" oninput="validatePhoneNumber(this)" required>
                            </div>
                            <div>
                                <label for="occupation" class="form-label h5 mt-3">Occupation</label>
                                <input type="text" class="form-control" id="occupation" placeholder="Occupation" name="occupation" value="<?php echo $result['occupation']; ?>">
                            </div>
                            <hr class="mt-3">
                </section>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                    <!-- <input type="submit" value="Register" class="btn" name="register"> -->
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

        const countrySelect = document.getElementById('country');
        const stateSelect = document.getElementById('state');

        const ccountrySelect = document.getElementById('cCountry');
        const cstateSelect = document.getElementById('cState');


        countrySelect.addEventListener('change', changeState);
        ccountrySelect.addEventListener('change', changeState);

        function changeState() {
            var selectedCountry = countrySelect.value;
            var cselectedCountry = ccountrySelect.value;

            stateSelect.innerHTML = '<option value="" selected disabled>Choose a state</option>';
            cstateSelect.innerHTML = '<option value="" selected disabled>Choose a state</option>';

            if (statesByCountry[selectedCountry]) {
                for (var i = 0; i < statesByCountry[selectedCountry].length; i++) {
                    var state = statesByCountry[selectedCountry][i];
                    var option = document.createElement('option');
                    option.value = state;
                    option.textContent = state;
                    stateSelect.appendChild(option);
                }
            }
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