<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<style>
body{ 
    color:white;
    background-color:gray;
    text-align:center;
    padding-top:20%;
    font-family: Arial, Helvetica, sans-serif;
}
table, td, th {
  border: 1px solid black;
}
table {
  border-collapse: collapse;
}
td {
  text-align: center;
  padding-right:19px;
}
</style>

    <?php 
        $button = $_GET ['submit'];
        $search = $_GET ['search'];
        echo gethostname() . PHP_EOL;
        #echo $search;
        #echo $button;
        $dbhost = "192.168.69.17";
        $dbuser = "nick";
        $dbpass = "itsasekrit";
        $db = "test";
        $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

        if($conn->connect_error){
            echo "connection failed";
        }
        #echo "connection succesfull";

        $query = "SELECT * FROM test WHERE naam LIKE '%".$search."%'";
        $result = $conn->query($query) or die(mysql_error);

        if ($result->num_rows>0)
        {
            $rowcount=mysqli_num_rows($result);
            printf("<br>%d users were found.\n",$rowcount);
            echo "
                <table>
                <tr>
                    <th>Id</th>
                    <th>Firstname</th>
                    <th>Age</th>
                </tr>
                </table>";
            while($row = $result->fetch_assoc())
            {
                echo "
                <table>
                <tr>
                        <td>" . $row["id"]. "</td>
                         <td>" . $row["naam"]. "</td>
                         <td>" . $row["leeftijd"]. "</td>
                </tr>
                </table>";
            }
        } else {
            echo "0 results";
        }


        mysqli_close($con)
    ?>
</body>
</html>