<?php
require_once "src/Proc.php";
$conn = new Mysql("CoursMSG");

if (isset($_POST["Msg"])) {
    if(isset($_POST["isOver18"])){
        $conn->InjectIntable("Messages", array(htmlspecialchars($_POST['Msg']), htmlspecialchars($_POST['isOver18'])));
    }else {
        $conn->InjectIntable("Messages", array(htmlentities($_POST['Msg']), 0));
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <title>Form</title>
    </head>
    <body>
        <h1>Formulaire</h1>
        <form method="POST" name="Message">
            <label for="TxtMsg">Message</label><br>
            <input id="TxtMsg" type="text" name="Msg"><br>
            <label for="isMajeur" type="text">Majeur ?</label>
            <input id="isMajeur" type="checkbox" name="isOver18" value="1"><br>
            <input type="submit">
        </form>
        <br>
        <a href="?Form">See resutls (Actualize)</a>
        <br>
        <h1>Messages in DB :</h1><br>
            <table>
                <?php
                    
                    $columns = $conn->describeTable("Messages",TRUE);
                    $colNum = count($columns);
                    $items = $conn->selectfromTable("Messages", ["*"], TRUE);
                    $itemsNum = count($items);
                    $itemNumNum = count($items[0]);
                    echo "<tr>";
                    for ($i =0 ; $i < $colNum; $i++)
                    {
                        echo "<td>".$columns[$i]."<td>";
                    }
                    echo "</tr>";
                    for ($i =0 ; $i < $itemsNum; $i++)
                    {   
                        echo "<tr>";
                            for($x = 0; $x < $itemNumNum; $x++){
                                echo "<td>".$items[$i][$x]."<td>";
                            }
                        echo "</tr>";
                    }
                    
                ?>
            </table>
            <a href="/">Comeback to main</a>

    </body>
</html>