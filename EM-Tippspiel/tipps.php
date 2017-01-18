<?php
session_start();

$connection = mysqli_connect('localhost', 'root', '', 'tipp-spiel');

if(isset($_SESSION['username']) && !isset($_POST['username'])){
    $Username = $_SESSION['username'];   
}

else{
    $Username = $_POST['username'];
    $Password = $_POST['password'];
    
    if(mysqli_num_rows(mysqli_query($connection, "SELECT * FROM person WHERE Password = '$Password' AND Username = '$Username'")) < 1){
    echo "Wrong Information.";
    exit();
    }
    $_SESSION['username'] = $Username;
}

echo "Logged in as $Username";

$records = mysqli_query($connection, "SELECT spiel.*, NT.Tore1 as Tipp1, NT.Tore2 as Tipp2 FROM spiel left join (SELECT * FROM tipp WHERE tipp.Username ='$Username') as NT on spiel.ID = NT.ID ORDER BY Anpfiff ASC");

?>

<html>
<head>
 <title>Tipps</title>   
</head>
    <body>
        <table width="600" border="1" cellpadding="1" cellspacing="1">
            <tr>
                <th>Mannschaft 1</th>
                <th>Mannschaft 2</th>
                <th>Tore 1</th>
                <th>Tore 2</th>
                <th>Anpfiff</th>
                <th>Tipp Tore 1</th>
                <th>Tipp Tore 2</th>
                <th></th>
                
            <tr>
                <?php
                while($query=mysqli_fetch_assoc($records)){
                    echo '<form action="tippinput.php" method="post">';
                    echo '<input type="hidden" name="id" value="' . (int)$query['ID'] . '" />';
                    echo "<tr>";
                    
                    echo "<td>".$query['Verein1']."</td>";
                    echo "<td>".$query['Verein2']."</td>";
                    echo "<td>".$query['Tore1']."</td>";
                    echo "<td>".$query['Tore2']."</td>";
                    echo "<td>".$query['Anpfiff']."</td>";

                    setTable(new DateTime($query['Anpfiff']) <= new DateTime(), $query);
                    
                    echo "<tr>";
                    echo "</form>";
                }
                ?>
        </table>
    </body>
</html>

<?php
 function setTable($expired, $query){
     if($expired){
         if($query['Tipp1']!=null){echo "<td>".$query['Tipp1']."</td>"; echo "<td>".$query['Tipp2']."</td>";}
         else{echo "<td>Expired</td>"; echo "<td>Expired</td>";}
         
         return;
     }
     else{
         echo '<td align="center"><input type="number" name="bet1" min="0" max="10" value="'.$query['Tipp1'].'"/></td>';
         echo '<td align="center"><input type="number" name="bet2" min="0" max="10" value="'.$query['Tipp2'].'"/></td>';
     }
     echo '<td colspan="2" align="center"><input type="submit" id="'.$query['ID'].'" value="Save"/></td>';
 }
?>