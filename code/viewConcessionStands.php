<?php
session_start();

if(isset($_SESSION['id'])){
    $username = $_SESSION['username']; 
    $id = $_SESSION['id'];
    $roleId = $_SESSION['roleId'];
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
} else{
    header("Location: index.php");
}

require("themeparkSiteBuilder.php");
$siteBuilder = new themeParkSiteBuilder();

$siteBuilder->getOpeningHtmlTags('Concession Stand');

$siteBuilder->getGreyOverLay();

$siteBuilder->getSubTitle();

$siteBuilder->getMenu();
?>
<div class = "content" >
    <h1>Concession Stands</h1>
    <form action="viewConcessionStands.php" method="post">
       <select name = 'by'>
            <option value="idConcession_Stands">ID</option>
            <option value="name">Name</option>
            <option value="description">Description</option>
            <option value="location">Location</option>
        </select>
      <input type="submit">
      <a href="insertConcessionStandForm.php" class="button">Add New Shift</a>
    </form>


    
        <?php
            if(isset($_POST['by'])){
                
            $by = $_POST['by'];

                echo '<form action="editingConcessionStand.php" method="post" enctype="multipart/form=data"> 
                            <button type="submit" name="by" value="' . $by . '">Select</button>
                        </form> ';
                echo '<div class="reports">';
                
                $query = "SELECT idConcession_Stands, name, description, location FROM Concession_Stands ORDER BY " . $by;
            } else{
                
                 echo '<form action="editingConcessionStand.php" method="post" enctype="multipart/form=data"> 
                        <button type="submit" value="">Select</button>
                    </form> ';
                echo '<div class="reports">';
            
                $query = "SELECT idConcession_Stands, name, description, location FROM Concession_Stands";
                
            }
            require_once('../db_connection.php');

            $response = @mysqli_query($dbc, $query);
            
            if($response){
            echo '<table align="left"
            cellspacing="5" cellpadding="8" class="report">

            <tr><td align="left"><b>ID</b></td>
            <td align="left"><b>Name</b></td>
            <td align="left"><b>Last Name</b></td>
            <td align="left"><b>Description</b></td>
            <td align="left"><b>Location</b></td></tr>';

        
            while($row = mysqli_fetch_array($response)){

            echo '<tr><td align="left">' . 
            $row['idConcession_Stands'] . '</td><td align="left">' . 
            $row['name'] . '</td><td align="left">' .
            $row['name'] . '</td><td align="left">' . 
            $row['description'] . '</td><td align="left">' .
            $row['location'] . '</td><td align="left">';

            echo '</tr>';
            }

            echo '</table>';
            } else {

            echo "Couldn't issue database query<br />";

            echo mysqli_error($dbc);

            }

            mysqli_close($dbc);

            echo '</div>';
        ?>
  
</div>

<?php
$siteBuilder->getClosinghtmlTags();
?>
