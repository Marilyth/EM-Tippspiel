<?php
session_start();

$spielID = $_POST['id'];
$Username = $_SESSION['username'];
$tipp1 = $_POST['bet1'];
$tipp2 = $_POST['bet2'];

$connection = mysqli_connect('localhost', 'root', '', 'tipp-spiel');

if(mysqli_num_rows(mysqli_query($connection, "SELECT * FROM tipp WHERE Username = '$Username' AND ID='$spielID'")) > 0)
    $sql = "UPDATE tipp SET Tore1='$tipp1', Tore2='$tipp2' WHERE ID='$spielID' AND Username = '$Username'";
else $sql = "INSERT INTO `tipp` (`Username`, `ID`, `Tore1`, `Tore2`) VALUES ('$Username', '$spielID', '$tipp1', '$tipp2')";

echo "'$sql' <br>Was succesfully executed!";
mysqli_query($connection, $sql);
?>

<html>
	<body>
	   <form action="tipps.php" method="post">
	       <table border="0">
    
	       <tr>
	           <td colspan="2" align="center"><input type="submit" value="View Bets"/></td>
	       </tr>
    
	       </table>
	   </form>
	</body>
</html>