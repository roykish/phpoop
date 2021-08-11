<?php

$connection = new PDO ("mysql:host=localhost;dbname=products_crud", "root","");
$connection ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);






$errors = [];
$title = '';
$price = '';
$description = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $date = date('Y-m-d H:i:s');

    if (!$title) {
        $errors[] = 'Product title is required.';
    }
    if (!$price) {
        $errors[] = 'Product price is required.';
    }

    if(!is_dir('images')) mkdir('images');


    if (empty($errors)) {

        $image = $_FILES['image'] ?? null;
        $imagePath = '';
        if($image && $image['tmp_name']){

            $imagePath = 'images/'.randomName(8).'/'.$image['name'];
            mkdir(dirname($imagePath));

            move_uploaded_file($image['tmp_name'], $imagePath);

        }



        $stat = $connection->prepare("INSERT INTO products(title, description,image,price, create_date)
                VALUES (:title,:description,:image, :price,:date)");
        $stat->bindValue(':title', $title);
        $stat->bindValue(':description', $description);
        $stat->bindValue(':image', $imagePath);
        $stat->bindValue(':price', $price);
        $stat->bindValue(':date', $date);
        $stat->execute();
        header('location: index.php');
    }
}

function randomName($n){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for($i=0; $i<$n; $i++){
        $index = rand(0, strlen($characters)-1);
        $str .= $characters[$index];
    }
}
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
<h1>Insert New product</h1>
<?php if(!empty($errors)): ?>
<div class="alert alert-danger">
    <?php foreach ($errors as $error) : ?>
    <div>
        <?php echo $error?>
    </div>
    <?php endforeach;?>
</div>
<?php endif;?>


<form action="insert.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label>Product Image</label>
        <input type="file" class="form-control" name="image" >
    </div>
    <div class="mb-3">
        <label class="form-label">Product Title</label>
        <input type="text" class="form-control" name="title" value="<?php echo $title?> ">
    </div>
    <div class="mb-3">
        <label class="form-label">Product Description</label>
        <textarea class="form-control" name="description"><?php echo $description?></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Product Price</label>
        <input type="number" step="0.01" class="form-control" name="price" value="<?php echo $price?>">
    </div>

    <button type="submit" class="btn btn-primary" name="submit">Insert</button>
</form>







</body>
</html>