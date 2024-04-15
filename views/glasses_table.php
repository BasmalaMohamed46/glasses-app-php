<?php

require_once "../db.php";
error_reporting(E_ERROR | E_PARSE);

if(isset($_POST["delete_id"])) {
    $id = $_POST["delete_id"];
    $item = $capsule->table("items")->find($id);
    $imageFilename = $item->Photo;

    $capsule->table("items")->where("id", $id)->delete();

    $imagePath = "../images/" . $imageFilename;
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
    header("Location: glasses_table.php");
    exit();
}

$record = (array)$capsule->table("items")->first();
$columns_names = array_keys($record);
array_pop($columns_names);
$search_results = [];

if(isset($_POST["search"])) {
    foreach($columns_names as $column) {
        $itemsFound = $capsule->table("items")->orWhere($column,"like","%".$_POST["search"]."%")->get();
        foreach ($itemsFound as $item) {
            if (!in_array($item->id, $search_results)) {
                array_push($search_results, $item->id);
        }
    }
    }
    if(count($search_results) == 0) {
        echo "<h1>No results found</h1>";
    }
}
?>

<html>
    <head>
        <title>Glasses Table</title>
        <style>
            table, th, td {
                border: 1px solid black;
            }
        </style>
    </head>

    <body>
        <form action="glasses_table.php" method="post">
            <Label for="search">Search</Label>
            <input type="text" id="search" name="search">
            <button>Search</button>
        </form>

        <button><a href="glasses_table.php">Reset</a></button>
        <button><a href="add_glass.php">Add</a></button>

        <h1>Glasses Table</h1>
        <table>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>More Info</td>
                <td>Delete</td>
            </tr>
            <?php if($_GET["searchPage"] || $_POST["search"]) {
                if (isset($_GET["searchPage"])) {
                    $searchPage = intval($_GET["searchPage"]);
                } else {
                    $searchPage = 1;
                }
                if($_GET["search_results"]) {
                    $search_results = unserialize(urldecode($_GET["search_results"]));
                } 
                $start_index = ($searchPage - 1) * RECORDS_PER_PAGE;
                $end_index = min($start_index + RECORDS_PER_PAGE, $_GET["search_results"]?count(unserialize(urldecode($_GET["search_results"]))):count($search_results));
                for ($i = $start_index; $i < $end_index; $i++) {
                    $item = $capsule->table("items")->find($_GET["search_results"]?unserialize(urldecode($_GET["search_results"]))[$i]:$search_results[$i]);
            ?>
                    <tr>
                        <td><?php echo $item->id; ?></td>
                        <td><?php echo $item->product_name; ?></td>
                        <td><a href='glass_info.php?item=<?php echo $item->id; ?>'>More</a></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="delete_id" value="<?php echo $item->id; ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
            <?php 
                }
                echo "</table>";
                if ($searchPage > 1) {
                    echo "<a href='glasses_table.php?searchPage=".($searchPage-1)."&search_results=".urlencode(serialize($search_results))."'>Previous</a>";
                }
                if ($end_index < count($search_results)) {
                    echo "<a href='glasses_table.php?searchPage=".($searchPage+1)."&search_results=".urlencode(serialize($search_results))."'>Next</a>";
                }
            } else {
                if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                } else {
                    $page = 1;
                }
                
                $itemsCount = $capsule->table("items")->count();
                $items = $capsule->table("items")->select()->skip(($page-1)*RECORDS_PER_PAGE)->take(RECORDS_PER_PAGE)->get();
                foreach ($items as $item): ?>
                    <tr>
                        <td><?php echo $item->id; ?></td>
                        <td><?php echo $item->product_name; ?></td>
                        <td><a href='glass_info.php?item=<?php echo $item->id; ?>'>More</a></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="delete_id" value="<?php echo $item->id; ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach;
                echo "</table>";
                if ($page > 1) {
                    echo "<a href='glasses_table.php?page=".($page-1)."'>Previous</a>";
                }
                if ($page * RECORDS_PER_PAGE < $itemsCount) {
                    echo "<a href='glasses_table.php?page=".($page+1)."'>Next</a>";
                }
            }
            ?>
    </body>
</html>
