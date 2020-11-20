<?php
require_once "src/Proc.php";
$conn = new Mysql(htmlspecialchars($_GET['DB']));

$column = $conn->describeTable(htmlspecialchars($_GET['Table']), TRUE);

echo '<table><tr style="">';
for($x=0; $x < count($column); $x++){

    echo '<td>'.$column[$x].'</td>';
}
echo '</tr><br>';

$colNum = count($column);
$items = $conn->selectfromTable($_GET['Table'], ["*"], TRUE);
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
echo '<h4><a href="/">Comeback to main</a></h4>'
?>