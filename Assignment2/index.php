<?php
    require('dbinit.php');

    $query = 'SELECT * FROM carsdata;'; 
    $results = @mysqli_query($dbc,$query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" 
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" 
        crossorigin="anonymous">
    <link rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <link rel="stylesheet" href="style.css">

    <!-- <style>
        .dont {
            display : none;
        }
    </style> -->

</head>
<body>

    <?php

        // Function to validate car name ex "Honda", "BMW X8" 
        function validate_car($value) {
            $value = trim($value);

            if (preg_match('/^[a-zA-Z]+( [A-Za-z\d]+)?$/', $value)) {
                return true;
            } else {
                return false;
            }
        }

        function validate_numbers($value) {
            $value = trim($value);

            if (preg_match('/^[\d]+$/', $value)) {
                return true;
            } else {
                return false;
            }
        }

        function validate_price($value) {
            $value = trim($value);

            if (preg_match('/^[\d]{3, 6}(\.[\d]{1,2})?$/', $value)) {
                return true;
            } else {
                return false;
            }
        }

        function validate_name($value) {
            $value = trim($value);

            if (preg_match('/^[a-zA-Z]+$/', $value)) {
                return true;
            } else {
                return false;
            }
        }

        // Do not do the validation if the page is loaded first
        // validation is done only if submit button is clicked
        if (!empty($_POST)) {

            // Do the data validation here
            $car_id = $_POST['cID'];
            $car_name = $_POST['cName'];
            $car_desc = $_POST['cDesc'];
            $car_quantity = $_POST['cQuantity'];
            $car_price = $_POST['cPrice'];
            $car_fuel = $_POST['cFuel'];
            $car_drive = $_POST['cDrive'];
            $car_added = "Charith";

            // Define an errors array
            $errors = [];

            // Validate if car name is empty or if it has alphabets only
            if (empty($car_name)) {
                $errors['car_name'] = "Car Name cannot be empty";
            } else if (!validate_car($car_name)){
                $errors['car_name'] = "Car Name must contain only letters.";
            }

            // Validate if car name is empty or if it has alphabets only
            if (empty($car_desc)) {
                $errors['car_desc'] = "Car Description cannot be empty";
            }

            // Validate if car quantity is empty or if it has alphabets only
            if (empty($car_quantity)) {
                $errors['car_quantity'] = "Car Name cannot be empty";
            } else if (!validate_numbers($car_quantity)){
                $errors['car_quantity'] = "Car Name must contain only digits.";
            }

            // Validate if car name is empty or if it has alphabets only
            if (empty($car_price)) {
                $errors['car_price'] = "Car Price cannot be empty";
            } 
            // else if (!validate_price($car_price)){
            //     $errors['car_price'] = "Car Price must be between 100 and 999,999.99.";
            // }

            // Validate if car name is empty or if it has alphabets only
            if (empty($car_added)) {
                $errors['car_added'] = "Car Name cannot be empty";
            } else if (!validate_name($car_added)){
                $errors['car_added'] = "Car Name must contain only letters.";
            }

            if (empty($car_fuel)) {
                $errors['car_fuel'] = 'Please select a fuel.';
            }

            if (empty($car_drive)) {
                $errors['car_drive'] = 'Please select a drive type.';
            }

            if (!empty($errors)) {
                // If there are errors save it session
                $_SESSION['errors'] = $errors;
                $_SESSION['form_data'] = $_POST;
                // header('Location: index.php#add-edit-car-data');
            } else {
                // If there are no errors then unset the session
                unset($_SESSION['errors']);
                unset($_SESSION['form_data']);
                // header("Location: success.php");

                $car_id = prepare_string($dbc, $car_id);
                $car_name = prepare_string($dbc, $car_name);
                $car_desc = prepare_string($dbc, $car_desc);
                $car_quantity = prepare_string($dbc, $car_quantity);
                $car_added = prepare_string($dbc, $car_added);
                $car_price = prepare_string($dbc, $car_price);
                $car_fuel = prepare_string($dbc, $car_fuel);
                $car_drive = prepare_string($dbc, $car_drive);

                $result = null;

                if (empty($car_id)) {
                    $query = "INSERT INTO `carsdata`(`carName`, `carDescription`, `quantityAvailable`, `price`, `fuelType`, `driveType`, `addedBy`) 
                                VALUES ('$car_name', '$car_desc', '$car_quantity', '$car_price', '$car_fuel', '$car_drive', '$car_added')";

                    // insert in database 
                    $result = mysqli_query($dbc, $query);
                } else {
                    $query = "UPDATE `carsdata`
                              SET `carName` = \"$car_name\", `carDescription` = \"$car_desc\", 
                                  `quantityAvailable` = $car_quantity, `price` = $car_price, 
                                  `fuelType` = \"$car_fuel\", `driveType` = \"$car_drive\"
                              WHERE `carID` = $car_id";

                    $result = mysqli_query($dbc, $query);
                }

                

                if ($result) {
                    echo "Part added successfully.";
                    header('Location: index.php');
                } else {
                    echo "Something went wrong. Part not added.";
                }

            }

        }

        // Use the session data to prefill the form
        $form_data = $_SESSION['form_data'] ?? [];
        $errors = $_SESSION['errors'] ?? [];
    ?>

    <div class="table-container">

        <div id="show-car-data">
            <div>
                <h1>Please see the list of all cars.</h1>
                <span id="operation"></span>
                <a href="#add-edit-car-data"><button id="add-car">Add new car</button></a>
                
            </div>

            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Car ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Price</th>
                        <th scope="col">Fuel Type</th>
                        <th scope="col">Drive Type</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Added by</th>
                        <th scope="col">Edit/Delete</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        $sr_no = 0;
                        while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)){
                            $sr_no++;
                            $str_to_print = "";
                            $str_to_print = "<tr>";
                            $str_to_print .= "<th scope=\"row\" id=\"cid-{$row['carID']}\">{$row['carID']}</th>";
                            $str_to_print .= "<td id=\"cname-{$row['carID']}\">{$row['carName']}</td>";
                            $str_to_print .= "<td id=\"cdesc-{$row['carID']}\">{$row['carDescription']}</td>";
                            $str_to_print .= "<td id=\"cprice-{$row['carID']}\">{$row['price']}</td>";
                            $str_to_print .= "<td id=\"cfuel-{$row['carID']}\">{$row['fuelType']}</td>";
                            $str_to_print .= "<td id=\"cdrive-{$row['carID']}\">{$row['driveType']}</td>";
                            $str_to_print .= "<td id=\"cquantity-{$row['carID']}\">{$row['quantityAvailable']}</td>";
                            $str_to_print .= "<td>{$row['addedBy']}</td>";
                            $str_to_print .= "<td>
                                                <a href=\"#add-edit-car-data\"><button id=\"edit-car-{$row['carID']}\" class=\"edit-car\"><i class=\"fa-regular fa-pen-to-square\"></i></button></a> 
                                                    |
                                                     <button id=\"delete-car-{$row['carID']}\" class=\"delete-car\"><i class=\"fa-solid fa-trash-arrow-up\"></i></button></td>";
                            $str_to_print .= "</tr>";
                            // $str_to_print .= "<td> <a href='edit_user.php?user_id={$row['user_id']}'>Edit</a> | <a href='delete_user.php?user_id={$row['user_id']}'>Delete</a> </td> </tr>";

                            echo $str_to_print;
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <div id="add-edit-car-data">
            <form name="add_edit_car" class="needs-validation"
                method="post" action="index.php" novalidate>

                <h1 class="text-center" id="add-edit-form-heading">
                    Please fill the form to add new car
                </h1>

                <p>
                    <label for="cID">Car ID:  </label>
                    <input type="text" name="cID" id="cID" 
                        class="form-control"
                        value="<?= isset($form_data['cID']) ? $form_data['cID'] : "" ?>">
                </p>

                <p> 
                    <label for="cName">Car Name:  </label>
                    <input type="text" name="cName" id="cName" 
                        class="form-control <?= isset($errors['car_name']) ? "invalidval" : "" ?>"
                        placeholder="Please enter your first name" 
                        value="<?= isset($form_data['cName']) ? $form_data['cName'] : "" ?>">
                    <span class="errortext"><?= isset($errors['car_name']) ? $errors['car_name'] : "" ?></span>
                </p>

                <p> 
                    <label for="cDesc">Car Description:  </label>
                    <textarea name="cDesc" id="cDesc" 
                        class="form-control <?= isset($errors['car_desc']) ? "invalidval" : "" ?>"
                        placeholder="Please enter the description of car"
                        value="<?= isset($form_data['cDesc']) ? $form_data['cDesc'] : "" ?>"></textarea>
                    <span class="errortext"><?= isset($errors['car_desc']) ? $errors['car_desc'] : "" ?></span>
                </p>

                <p> 
                    <label for="cQuantity">Car Quantity:  </label>
                    <input type="text" name="cQuantity" id="cQuantity" 
                        class="form-control <?= isset($errors['car_quantity']) ? "invalidval" : "" ?>"
                        placeholder="Please enter stock available" 
                        value="<?= isset($form_data['cQuantity']) ? $form_data['cQuantity'] : "" ?>">
                    <span class="errortext"><?= isset($errors['car_quantity']) ? $errors['car_quantity'] : "" ?></span>
                </p>

                <p> 
                    <label for="cPrice">Car Price:  </label>
                    <input type="text" name="cPrice" id="cPrice" 
                        class="form-control <?= isset($errors['car_price']) ? "invalidval" : "" ?>"
                        placeholder="Please the price of the car" 
                        value="<?= isset($form_data['cPrice']) ? $form_data['cPrice'] : "" ?>">
                    <span class="errortext"><?= isset($errors['car_price']) ? $errors['car_price'] : "" ?></span>
                </p>

                <p> 
                    <label for="cFuel">Car Fuel:  </label>
                    <select name="cFuel" id="cFuel"
                        class="form-select <?= isset($errors['car_fuel']) ? "invalidval" : "" ?>">
                        <option value=""
                            <?= isset($form_data['cFuel']) && $form_data['cFuel'] == "" ? "selected" : "" ?>>
                            Select One</option>
                        <option value="Gas"
                            <?= isset($form_data['cFuel']) && $form_data['cFuel'] == "Gas" ? "selected" : "" ?>>
                            Gas</option>
                        <option value="Electric"
                            <?= isset($form_data['cFuel']) && $form_data['cFuel'] == "Electric" ? "selected" : "" ?>>
                            Electric</option>
                        <option value="Hybrid"
                            <?= isset($form_data['cFuel']) && $form_data['cFuel'] == "Hybrid" ? "selected" : "" ?>>
                            Hybrid</option>
                    </select>
                    <span class="errortext"><?= isset($errors['car_fuel']) ? $errors['car_fuel'] : "" ?></span>
                </p>

                <p> 
                    <label for="cDrive">Car Drive Type:  </label>
                    <select name="cDrive" id="cDrive"
                        class="form-select <?= isset($errors['car_drive']) ? "invalidval" : "" ?>">
                        <option value=""
                            <?= isset($form_data['cDrive']) && $form_data['cDrive'] == "" ? "selected" : "" ?>>
                            Select One</option>
                        <option value="AWD"
                            <?= isset($form_data['cDrive']) && $form_data['cDrive'] == "AWD" ? "selected" : "" ?>>
                            AWD</option>
                        <option value="RWD"
                            <?= isset($form_data['cDrive']) && $form_data['cDrive'] == "RWD" ? "selected" : "" ?>>
                            RWD</option>
                        <option value="FWD"
                            <?= isset($form_data['cDrive']) && $form_data['cDrive'] == "FWD" ? "selected" : "" ?>>
                            FWD</option>
                    </select>
                    <span class="errortext"><?= isset($errors['car_drive']) ? $errors['car_drive'] : "" ?></span>
                </p>

                <p class="btn-row">
                    <input type="submit" id="submit" value="Submit" class="btn btn-primary submitbtn"/>
                    <input type="reset" id="cancel-add" value="Cancel" class="btn btn-danger submitbtn"/>
                </p>

            </form>
        </div>

        <div>

        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="script.js"></script>

</body>
</html>

