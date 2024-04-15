<?php
require_once "../db.php";

if (!isset($capsule)) {
    die("Error: Capsule not available");
}
$item_id = $_GET["item"];
$one_item = $capsule->table("items")->where("id", $item_id)->first();
?>
<html>
    <head>
        <title>Glass Info</title>
        <style>
            table, th, td {
            border: 1px solid black;
            }
        </style>
    </head>
    <body>
        <?php echo "Type:$one_item->product_name"; ?>
            <table>
                <tr>
                    <td><?php echo "Type:$one_item->product_name"; ?></td> 
                    <td><?php echo "price:$one_item->list_price"; ?></td>
                </tr>
                <tr>
                    <td>
                        <?php echo "Details:<br>
                        code:$one_item->PRODUCT_code<br>
                        Item ID:$one_item->id<br>
                        rating:$one_item->Rating"; ?>
                    </td>
                    <td>
                        <img src="../images/<?php echo $one_item->Photo; ?>" alt="Image" width="200" height="200">
                    </td>
                </tr>
            </table>

    </body>
 
 </html>
