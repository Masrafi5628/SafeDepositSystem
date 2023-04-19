<?php
// handle report generation
require_once('Classes/Database.php');
$db = new Database("localhost", "root", "", "test");
$conn = $db->getConnection();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['generate_report'])) {
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $query = "SELECT DATE(check_in_time) AS check_in_date,
            COUNT(id) AS checked_in_users,
            COUNT(CASE WHEN check_out_time IS NOT NULL THEN customer_id END) AS checked_out_users
            FROM test.box_activity_log
            WHERE check_in_time BETWEEN '$start_time' AND '$end_time'
            GROUP BY check_in_date";

    // prepare query to get report data
    // $query = "SELECT DATE_FORMAT(check_in_time, '%Y-%m-%d %H:%i:%s') AS check_in_time,
    //             COUNT(id) AS checked_in_users,
    //             COUNT(CASE WHEN check_out_time IS NOT NULL THEN customer_id END) AS checked_out_users,
    //             COUNT(CASE WHEN check_out_time IS NULL THEN customer_id END) AS missing_keys,
    //             COUNT(CASE WHEN check_in_time = check_out_time THEN customer_id END) AS extra_keys
    //             FROM test.box_activity_log
    //             WHERE DATE(check_in_time) BETWEEN '$start_date' AND '$end_date'
    //             GROUP BY check_in_time";

    $result = $conn->query($query);
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Analyst Profile</title>
    <style>
        .container {
            margin: 50px auto;
            width: 50%;
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
        }

        input[type=datetime-local] {
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        button {
            padding: 10px 20px;
            font-size: 18px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 100%;
            max-width: 800px;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Generate Report</h1>
        <form method="post">
            <label for="start_time">Start Time:</label>
            <input type="datetime-local" id="start_time" name="start_time" required><br>
            <label for="end_time">End Time:</label>
            <input type="datetime-local" id="end_time" name="end_time" required><br>
            <button type="submit" name="generate_report">Generate Report</button>
        </form>

        <?php
        // display report table
        if (isset($result) && $result->num_rows > 0) {
            echo "<div id='report'>";
            echo "<h2>Report</h2>";
            echo "<table>";
            echo "<tr><th>Date</th><th>Checked In Users</th><th>Checked Out Users</th><th>Missing Keys</th><th>Extra Keys</th></tr>";
            while ($row = $result->fetch_assoc()) {
                $checked_in_users = $row['checked_in_users'];
                $checked_out_users = $row['checked_out_users'];
                $missing_keys = max(0, $checked_in_users - $checked_out_users);
                $extra_keys = max(0, $checked_out_users - $checked_in_users);

                echo "<tr><td>" . $row['check_in_date'] . "</td><td>" . $checked_in_users . "</td><td>" . $checked_out_users . "</td><td>" . $missing_keys . "</td><td>" . $extra_keys . "</td></tr>";
            }
            echo "</table>";
            echo "</div>";
        } else {
            echo "<p>No results found.</p>";
        }
        ?>
        <button onclick="window.print()">Print Report</button>

        <style>
            @media print {
                body * {
                    visibility: hidden;
                }

                #report,
                #report * {
                    visibility: visible;
                }

                #report {
                    position: absolute;
                    left: 0;
                    top: 0;
                }
            }
        </style>
    </div>

</body>

</html>