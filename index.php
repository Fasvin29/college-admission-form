<?php include("connection.php"); ?>

<?php
if (isset($_POST['register'])) {
    // Collecting form data
    $fname         = $_POST['firstName'];
    $mname         = $_POST['middleName'];
    $lname         = $_POST['lastName'];
    $dob           = $_POST['dateOfBirth'];
    $ph            = $_POST['phoneNumber'];
    $street        = $_POST['streetAddress'];
    $city          = $_POST['city'];
    $state         = $_POST['state'];
    $pincode       = $_POST['pincode'];
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
        // Get the admission form ID (auto incremented)
        $admissionId = mysqli_insert_id($connection);

        // Insert data into communicationaddress
        $query2 = "INSERT INTO communicationaddress (streetaddress, city, country, pincode, state, admissionid) 
                   VALUES ('$cStreet', '$cCity', '$cCountry', '$cpincode', '$cState', '$admissionId')";
        $data2 = mysqli_query($connection, $query2);

        if ($data2) {
            echo '<div class="alert alert-success">Your application has been submitted successfully!</div>';
        } else {
            echo '<div class="alert alert-danger">There was an error submitting your communication address. Please try again later.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">There was an error submitting your application. Please try again later.</div>';
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
    <title>admission form</title>
    <style>
        body {
            background-color: rgb(185, 185, 185);
        }
    </style>
</head>

<body>
    <section>
        <div class="container my-3">
            <h2 class="text-danger">College Admission Form</h2>
            <p>If you'd like to apply to our college, please fill in this College Admission Form and we will contact you
                as soon as possible</p>
            <hr>
            <form action="#" method="POST">
                <section>
                    <div>
                        <label for="fullName" class="form-label h5 mt-3">Full Name of Applicant</label>
                        <div id="fullName" class="row">
                            <div class="col-12 col-md-6 col-lg-4 mt-3">
                                <input type="text" class="form-control" placeholder="First" name="firstName" required>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mt-3">
                                <input type="text" class="form-control" placeholder="Middle" name="middleName">
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mt-3">
                                <input type="text" class="form-control" placeholder="Last" name="lastName" required>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="dateOfBirth" class="form-label h5 mt-3">Date of birth</label>
                        <input type="date" class="form-control" id="dateOfBirth" placeholder="Date of Birth" name="dateOfBirth" required min="1950-01-01" max="<?php echo date('Y-m-d'); ?>" onchange="calculateAge()">
                    </div>
                    <div class="d-flex mt-3">
                        <label class="form-label h5 me-3">Age</label>
                        <input type="text" class="form-control me-3" id="ageYear" placeholder="Year" name="ageYear" readonly>
                        <input type="text" class="form-control me-3" id="ageMonth" placeholder="Month" name="ageMonth" readonly>
                        <input type="text" class="form-control" id="ageDay" placeholder="Days" name="ageDay" readonly>
                    </div>

                    <div>
                        <label for="phoneNumber" class="form-label h5 mt-3">Applicant's Phone</label>
                        <input type="text" class="form-control" id="phoneNumber" placeholder="" name="phoneNumber" oninput="validatePhoneNumber(this)" required>
                    </div>
                    <div>
                        <label for="address" class="form-label h5 mt-3">Permanent Address</label>
                        <div id="address" class="row">
                            <div class="col-12">
                                <input type="text" class="form-control" placeholder="Street Address"
                                    name="streetAddress" required>
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <input type="text" class="form-control" placeholder="City" name="city" required>
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <select id="country" class="form-select" name="country" required>
                                    <option value="" selected disabled>Country</option>
                                    <option value="us">United States</option>
                                    <option value="ca">Canada</option>
                                    <option value="uk">United Kingdom</option>
                                    <option value="au">Australia</option>
                                    <option value="in">India</option>
                                    <option value="jp">Japan</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <input type="number" class="form-control" placeholder="Postal/ Zip Code"
                                    name="pincode" required oninput="pincodeValidation(this)">
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <!-- <input type="text" class="form-control" placeholder="State" name="state" required> -->
                                <select id="state" class="form-select" name="state" required>
                                    <option value="" selected disabled>Choose a state</option>
                                </select>
                            </div>
                            <br>

                        </div>
                    </div>
                    <div>
                        <label for="address" class="form-label h5 mt-3">Communication Address</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="check1" name="comunication_check" value="something" onclick="comunicationAddress()">
                            <label class="form-check-label h6" for="check1">Communication address is same as Permanent address</label>
                        </div>
                        <div id="communicationAddress" class="row">
                            <div class="col-12">
                                <input type="text" class="form-control" placeholder="Street Address"
                                    name="cStreetAddress" required>
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <input type="text" class="form-control" placeholder="City" name="cCity" required>
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <select id="cCountry" class="form-select" name="cCountry" required>
                                    <option value="" selected disabled>Country</option>
                                    <option value="us">United States</option>
                                    <option value="ca">Canada</option>
                                    <option value="uk">United Kingdom</option>
                                    <option value="au">Australia</option>
                                    <option value="in">India</option>
                                    <option value="jp">Japan</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <input type="number" class="form-control" placeholder="Postal/ Zip Code"
                                    name="cpincode" required oninput="pincodeValidation(this)">
                            </div>
                            <div class="col-12 col-md-6 mt-3">
                                <!-- <input type="text" class="form-control" placeholder="State" name="state" required> -->
                                <select id="cState" class="form-select" name="cState" required>
                                    <option value="" selected disabled>Choose a state</option>
                                </select>
                            </div>
                            <br>
                            <br>
                            <br>
                            <hr>
                        </div>
                    </div>
                </section>
                <section>
                    <h4>Education details</h4>
                    <div>
                        <label for="schoolName" class="form-label h5 mt-3">Last school/ College Name</label>
                        <input type="text" class="form-control" id="schoolName" placeholder="" name="schoolName" required>
                    </div>
                    <div>
                        <label for="qualificatin" class="form-label h5 mt-3">Highest Qualification</label>
                        <input type="text" class="form-control" id="qualificatin" placeholder="" name="qualification" required>
                    </div>
                    <div>
                        <label for="marks" class="form-label h5 mt-3">Marks/ Percentage/ Grade</label>
                        <input type="text" class="form-control" id="marks" placeholder="" name="marks" required>
                    </div>
                    <div>
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
                    </div>

                    <hr>
                </section>
                <section>
                    <div>
                        <label for="parentFullName" class="form-label h5 ">Parent/ Guardian's Name</label>
                        <div id="parentFullName" class="row">
                            <div class="col-12 col-md-6 col-lg-4 mt-3">
                                <input type="text" class="form-control" placeholder="First" name="parentFirstName" required>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mt-3">
                                <input type="text" class="form-control" placeholder="Middle" name="parentMiddleName">
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mt-3">
                                <input type="text" class="form-control" placeholder="Last" name="parentLastName" required>
                            </div>
                            <div>
                                <label for="parentPhoneNumber" class="form-label h5 mt-3">Parent/ Guardian's
                                    Phone</label>
                                <input type="text" class="form-control" id="parentPhoneNumber"
                                    placeholder="" name="parentPhoneNumber" required oninput="validatePhoneNumber(this)">
                            </div>
                            <div>
                                <label for="occupation" class="form-label h5 mt-3">Occupation</label>
                                <input type="text" class="form-control" id="occupation" placeholder="Occupation"
                                    name="occupation">
                            </div>
                            <hr class="mt-3">
                        </div>
                    </div>
                </section>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" name="register">Submit</button>
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