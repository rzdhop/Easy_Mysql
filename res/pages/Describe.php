<?php
require_once "src/Proc.php";
$conn = new Mysql(htmlspecialchars($_GET['DB']));

?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>Form</title>
    </head>
    <body>
        <?php
        $column = $conn->describeTable(htmlspecialchars($_GET['Table']), TRUE);
        $colNum = count($column);
        echo '<table><tr>';
        for($x=0; $x < $colNum; $x++){
        
            echo '<td>'.$column[$x].'</td>';
        }
        echo '</tr><br>';
        
        $items = $conn->selectfromTable($_GET['Table'], ["*"], TRUE);
        if(count($items) < 1){echo "</table><h2>Empty...</h2>";}
        else if (count($items) >= 1){
            $itemsNum = count($items);
            $itemNumNum = count($items[0]);
            
            for ($i =0 ; $i < $itemsNum; $i++)
            {   
                echo '<tr>';
                for($x = 0; $x < $itemNumNum; $x++){
                    echo "<td>".$items[$i][$x]."<td>";
                }
                echo '<tr><br>';
            }
            echo '</table>';  
        }
        echo '<h4><a href="/">Comeback to main</a></h4>';
        ?>
    </body>
</html>