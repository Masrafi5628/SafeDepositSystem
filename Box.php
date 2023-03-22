<?php
class Box
{
    private $size;
    private $rent;
    public function __construct($size, $rent)
    {
        $this->size = $size;
        $this->rent = $rent;
    }

    public function saveToDatabase($con)
    {
        $size = $this->size;
        $rent = $this->rent;
        $sql = "INSERT INTO `test`.`Box` ( `size`, `Due_Amount`) VALUES ( '$size', '$rent');";

        if ($con->query($sql) == true) {
            return true;
        } else {
            echo "ERROR: $sql <br> $con->error";
            return false;
        }
    }

}
?>