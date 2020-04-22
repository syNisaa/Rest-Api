<?php
    class dObj
    {
        var $servername = "localhost";
        var $username = "root";
        var $password = "";
        var $dbname = "database";
        var $conn;

        function getConnstring()
        {
            $con = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname) or die ("Connection Fail: " . mysqli_connect_error());
            if (mysqli_connect_errno()) {
                printf("Connect Fail %s\n", mysqli_connect_error());
                exit();
            } else {
                $this->conn = $con;
            }
            return $this->conn;
        }
    }
?>