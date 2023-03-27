<?php

class Box
{
    private $size;
    private $rent;
    private $shelf;

    public function __construct($size = null, $shelf = null)
    {
        $this->size = $size;
        $this->shelf = $shelf;
    }

    public function saveToDatabase($con)
    {
        $size = $this->size;
        $rent = $this->rent;
        $shelf = $this->shelf;
        $sql = "INSERT INTO `test`.`Box` (`size`, `shelf`, `Due_Amount`)
        SELECT '$size', '$shelf', `rent`.`rent`
        FROM `test`.`rent`
        INNER JOIN (
            SELECT `box_size`, MAX(`date`) AS `max_date`
            FROM `test`.`rent`
            WHERE `box_size` = '$size'
            GROUP BY `box_size`
        ) AS `max_rent` ON `rent`.`box_size` = `max_rent`.`box_size` AND `rent`.`date` = `max_rent`.`max_date`;";

        if ($con->query($sql) == true) {
            return true;
        } else {
            echo "ERROR: $sql <br> $con->error";
            return false;
        }
    }

    public function getAssignedBoxByCustomerId($database, $customerId)
    {
        $sql = "SELECT * FROM `Box` WHERE `Customer_ID` = $customerId";
        $result = $database->query($sql);
        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function assignBoxToCustomer($database, $customerId, $boxId)
    {
        // Check if the box is available
        $sql = "SELECT * FROM `Box` WHERE `ID` = $boxId AND `Customer_ID` IS NULL";
        $result = $database->query($sql);
        if ($result->num_rows == 1) {
            // Update the box's customer ID and rent date/time
            $sql = "UPDATE `Box` SET `Customer_ID` = $customerId, `rent_date_time` = NOW(), `Due_Date_Time` = DATE_ADD(NOW(), INTERVAL 1 MONTH) WHERE `ID` = $boxId";
            if ($database->query($sql)) {
                return true;
            } else {
                echo "ERROR: $sql <br> $database->error";
                return false;
            }
        } else {
            return false;
        }
    }

    public function getAvailableBoxes($database)
    {
        $sql = "SELECT * FROM `Box` WHERE `Customer_ID` IS NULL";
        $result = $database->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return array();
        }
    }
}