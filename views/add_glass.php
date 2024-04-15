<?php
require_once "../db.php";

if (isset($_POST["submit"])) {
    $id= $_POST["id"];
    $product_name = $_POST["product_name"];
    $list_price = $_POST["list_price"];
    $product_code = $_POST["product_code"];
    $Rating = $_POST["Rating"];
    $photo = $_FILES["photo"]["name"];
    $photo_tmp = $_FILES["photo"]["tmp_name"];
    move_uploaded_file($photo_tmp, "../images/$photo");
    $reorder_level = $_POST["reorder_level"];
    $Units_In_Stock = $_POST["Units_In_Stock"];
    $category = $_POST["category"];
    $CouNtry= $_POST["CouNtry"];
    $discontinued = $_POST["discontinued"];
    $id=$capsule->table("items")->orderBy('id', 'desc')->first()->id;
    $capsule->table("items")->insert([
        "id"=>$id+1,
        "PRODUCT_code"=>$product_code,
        "product_name"=>$product_name,
        "photo"=>$photo,
        "list_price"=>$list_price,
        "reorder_level"=>$reorder_level,
        "Units_In_Stock"=>$Units_In_Stock,
        "category"=>$category,
        "CouNtry"=>$CouNtry,
        "Rating"=>$Rating,
        "discontinued"=>$discontinued
        
    ]);
    header("Location: glasses_table.php");
}
?>
<html>
    <head>
        <title>Add Glass</title>
    </head>
    <body>
        <h1>Add Glass</h1>
        <form method="post" enctype="multipart/form-data">
            <label for="product_name">Product Name</label>
            <input type="text" name="product_name" id="product_name" required>
            <br>
            <label for="list_price">List Price</label>
            <input type="number" name="list_price" id="list_price" required>
            <br>
            <label for="product_code">Product Code</label>
            <input type="text" name="product_code" id="product_code" required>
            <br>
            <label for="Rating">Rating</label>
            <input type="number" name="Rating" id="Rating" required>
            <br>
            <label for="photo">Photo</label>
            <input type="file" name="photo" id="photo" required>
            <br>
            <label for="reorder_level">Reorder Level</label>
            <input type="number" name="reorder_level" id="reorder_level" required>
            <br>
            <label for="Units_In_Stock">Units In Stock</label>
            <input type="number" name="Units_In_Stock" id="Units_In_Stock" required>
            <br>
            <label for="category">Category</label>
            <input type="text" name="category" id="category" required>
            <br>
            <label for="CouNtry">Country</label>
            <input type="text" name="CouNtry" id="CouNtry" required>
            <br>
            <label for="discontinued">Discontinued</label>
            <input type="number" name="discontinued" id="discontinued" required>
            <br>
            <input type="submit" name="submit" value="Add Glass">
        </form>
    </body>