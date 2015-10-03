<html>

<body>
    
  <h1>Welcome</h1>
    
    <?php 
        <?php 
        echo $_POST["name"] . "<br>";

        echo "<a href='mailto:" . $_POST["email"] . "'>" .$_POST["email"] . "</a> <br>";

        echo $_POST["major"] . "<br>";

        
        $tempArray = $_POST["placesVisited"];
        echo count(tempArray);
        for ($x = 0; $x <= count(tempArray); $x++) {
            echo $tempArray[$x];
        }
        //echo $_POST["placesVisited"] . "<br>";

        echo $_POST["comments"]."<br>";
    ?>   
    ?>  
    
</body>

</html>