<?php
require_once 'Classes/Database.php';
require_once 'Classes/Box.php';

// Check if the customer has rented a box
$customerId = $_SESSION['customer_id'];
$database = new Database("localhost", "root", "", "test");
$box = new Box();
$rentedBox = $box->getAssignedBoxByCustomerId($database, $customerId);

// Rent a box
if (isset($_POST['rent'])) {
    $boxId = $_POST['box_id'];
    $result = $box->assignBoxToCustomer($database, $customerId, $boxId);
    if ($result) {
        $rentedBox = $box->getAssignedBoxByCustomerId($database, $customerId);
        echo "<p class='success'>Box rented successfully!</p>";
    } else {
        echo "<p class='error'>Error: Failed to rent box.</p>";
    }
}

// Get available boxes for rent
$availableBoxes = $box->getAvailableBoxes($database);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Sriracha&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="customerProfile.css">
</head>

<body>
    <div class="container">
        <h1>Welcome to your profile!</h1>
        <p>Here are the available boxes for rent:</p>

        <table>
            <tr>
                <th>ID</th>
                <th>Size</th>
                <th>Rent</th>
                <th>Select</th>
            </tr>
            <?php foreach ($availableBoxes as $availableBox): ?>
                <tr>
                    <td>
                        <?php echo $availableBox['ID'] ?>
                    </td>
                    <td>
                        <?php echo $availableBox['size'] ?>
                    </td>
                    <td>
                        <?php echo $availableBox['Due_Amount'] ?>
                    </td>
                    <td>
                        <form action="customerProfile.php" method="post">
                            <input type="hidden" name="box_id" value="<?php echo $availableBox['ID'] ?>">
                            <button class="btn" name='rent' <?php echo $rentedBox ? 'disabled' : '' ?>>
                                <?php echo $rentedBox ? 'Box already rented' : 'Rent this box' ?>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <?php if ($rentedBox): ?>
            <p>You have rented box
                <?php echo $rentedBox['ID'] ?> of size
                <?php echo $rentedBox['size'] ?> for $
                <?php echo $rentedBox['Due_Amount'] ?>.
            </p>
            <p>Your box is due on
                <?php echo date('Y-m-d H:i:s', strtotime($rentedBox['Due_Date_Time'])) ?>
            </p>
        <?php endif; ?>

        <form action="logout.php" method="post">
            <button class="btn" name="logout">Logout</button>
        </form>
    </div>
</body>

</html>