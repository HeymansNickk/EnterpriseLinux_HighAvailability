<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        $search = $_GET ['search'];
        echo gethostname() . PHP_EOL;
        #echo $search;
        #echo $button;
        $dbhost = "192.168.69.17";
        $dbuser = "nick";
        $dbpass = "vagrant";
        $db = "test";
        $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

        if($conn->connect_error){
            echo "connection failed";
        }
        #echo "connection succesfull";

        $query = "SELECT * FROM test WHERE naam = '".$search."'";
        $result = $conn->query($query) or die(mysql_error);

        if ($result->num_rows>0)
        {
            while($row = $result->fetch_assoc())
            {
                echo "id: " . $row["id"]. " - Name: " . $row["naam"]. " " . $row["leeftijd"]. "<br>";
            }
        } else {
            echo "0 results";
        }

        mysqli_close($con)
    ?>
</body>
</html>