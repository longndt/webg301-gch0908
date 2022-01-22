<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Mobile Detail</title>
   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
   <div class="container col-md-6 mt-4 text-center">
      <div class="row mb-5">
         <div class="col">
            <img src="<?= $mobile->image ?>" width="300" height="300">
         </div>
         <div class="col">
            <h1 class="text text-primary"><?= $mobile->name ?></h1>
            <h3>Brand: <?= $mobile->brand ?></h3>
            <h3>Price: <?= $mobile->price ?> USD </h3>
            <h3>Color: <?= $mobile->color ?></h3>
         </div>
      </div>
      <a href="index.php">
         <img src="https://thumbs.dreamstime.com/b/back-arrow-icon-glassy-blue-round-button-abstract-illustration-back-arrow-icon-glassy-blue-round-button-105849761.jpg"
         width="80" height="80">
      </a>
   </div>
</body>
</html>