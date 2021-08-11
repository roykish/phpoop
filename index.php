<?php

$connection = new PDO ("mysql:host=localhost;dbname=products_crud", "root","");

$connection ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stat = $connection->prepare('SELECT * FROM products ORDER BY create_date DESC');
$stat->execute();
$products = $stat->fetchAll(PDO::FETCH_ASSOC);


?>





<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Products CRUD</title>
</head>
<body>
<h1>Products CRUD</h1>
<a href="insert.php" type="button" class="btn btn-success">Insert Products</a>

<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Image</th>
        <th scope="col">Title</th>
        <th scope="col">Price</th>
        <th scope="col">Create Date</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($products as $i=>$product) : ?>
        <tr>
            <th scope="row"><?php echo $i+1 ?></th>
            <td>
                <img src="<?php echo $product['image']?>"class="thumb-image">
            </td>
            <td><?php echo $product['title']?></td>
            <td><?php echo $product['price']?></td>
            <td><?php echo $product['create_date']?></td>
            <td>

            <button type="button" class="btn  btn-sm btn-outline-primary">Edit</button>
            <button type="button" class="btn btn-sm btn-outline-danger">Delete</button>


            </td>

        </tr>

     <?php endforeach; ?>

    </tbody>
</table>







</body>
</html>