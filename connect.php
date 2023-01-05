<?php
if (isset($_POST['Submit'])) {
    if (isset($_POST['fn']) && isset($_POST['ln']) &&
        isset($_POST['g']) && isset($_POST['age']) &&
        isset($_POST['ph']) && isset($_POST['email']) && 
        isset($_POST['address'])) {
        
        $fn = $_POST['fn'];
        $ln = $_POST['ln'];
        $g = $_POST['g'];
        $age = $_POST['age'];
        $ph = $_POST['ph'];
        $email = $_POST['email'];
        $address = $_POST['address'];

        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "registration";
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT email FROM application WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO application(fn, ln, g, age, ph, email, address) values(?, ?, ?, ?, ?, ?, ?)";
            $Display = "SELECT * FROM application";
            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();

                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("sssiiss",$fn, $ln, $g, 
$age, $ph, $email, $address);
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.";
                $stmt = $conn->query($Display);
                if($stmt) {
                    while($row = $stmt->fetch_assoc() )
                    {
                        $fn = $row["fn"];
                        $ln = $row["ln"];
                        $g = $row["g"];
                        $a = $row["age"];
                        $p = $row["ph"];
                        $email = $row["email"];
                        $addr = $row["address"];
                        echo $fn;
                        echo "<br/>";
                        echo $ln;
                        echo "<br/>";
                        echo $g;
                        echo "<br/>";
                        echo $a;
                        echo "<br/>";
                        echo $p;
                        echo "<br/>";
                        echo $email;
                        echo "<br/>";
                        echo $addr;

                    }

                }
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                    echo "Someone already registered with this email id";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}


?>