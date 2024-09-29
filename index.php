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

</head>
<body>

    <div class="table-container">

        <div>
            <h1>Please see the list of all cars.</h1>
            <a href="register_car.php"><button>Add new car</button></a>
        </div>

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Car ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Fuel Type</th>
                    <th scope="col">Drive Type</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Added by</th>
                    <th scope="col">Edit/Delete</th>
                </tr>
            </thead>
            <tbody>
                <!-- <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr> -->

                <?php
                    $sr_no = 0;
                    while($row = mysqli_fetch_array($results, MYSQLI_ASSOC)){
                        $sr_no++;
                        $str_to_print = "";
                        $str_to_print = "<tr>";
                        $str_to_print .= "<th scope=\"row\">{$row['carID']}</th>";
                        $str_to_print .= "<td>{$row['carName']}</td>";
                        $str_to_print .= "<td>{$row['carDescription']}</td>";
                        $str_to_print .= "<td>{$row['fuelType']}</td>";
                        $str_to_print .= "<td>{$row['driveType']}</td>";
                        $str_to_print .= "<td>{$row['quantityAvailable']}</td>";
                        $str_to_print .= "<td>{$row['addedBy']}</td>";
                        $str_to_print .= "<td><button><i class=\"fa-regular fa-pen-to-square\"></i></button> | <button><i class=\"fa-solid fa-trash-arrow-up\"></i></button></td>";
                        $str_to_print .= "</tr>";
                        // $str_to_print .= "<td> <a href='edit_user.php?user_id={$row['user_id']}'>Edit</a> | <a href='delete_user.php?user_id={$row['user_id']}'>Delete</a> </td> </tr>";

                        echo $str_to_print;
                    }
                ?>
            </tbody>
        </table>

        <div>

        </div>
    </div>
</body>
</html>

