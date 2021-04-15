<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost","phpmyadmin","root","product");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
if(isset($_REQUEST["term"])){
    // Prepare a select statement
    $sql = "SELECT * FROM product_test WHERE product_name LIKE ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        
        // Set parameters
        $param_term = $_REQUEST["term"] . '%';
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
                echo '<table>
				<tr>
					<th>product_ID</th>
					<th>product_Name</th>
					<th>product_Description</th>
					<th>Stock</th>
					<th>Update</th>
					<th>Delete</th>
					
				</tr>';
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                	echo '<tr>';
                    echo "<td>" . $row["product_ID"] . "</td>";
                    echo "<td>" . $row["product_Name"] . "</td>";
                    echo "<td>" . $row["product_Description"] . "</td>";
                    echo "<td>" . $row["Stock"] . "</td>";
                    $data = $row["product_ID"];
                    echo '<td><a href="update.php?id='.$data.' ">Update</a></td>';
					echo '<td><a href="delete.php?id='.$data.' ">Delete</a></td>';
                    echo '<tr>';
                }
            } else{
                echo "<p>No matches found</p>";
            }
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
}
 
// close connection
mysqli_close($link);
?>
