<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Mobile List</title>
   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
   <div class="container col-md-7 mt-4">
         <table class="table table-border text-center">
         <thead>
            <tr>
               <th>Mobile Id</th>
               <th>Mobile Name</th>
               <th>Mobile Image</th>
               <th>Edit</th>
               <th>Delete</th>
            </tr>
         </thead>
         <tbody>
            <?php 
               $i=1;
               foreach ($mobile as $m) {
            ?>
            <tr>
               <td><?= $i ?></td>
               <td><?= $m->name ?></td>
               <td>
                  <!-- tạo đường link cho ảnh theo array index (id-1) -->
                  <a href="index.php?action=detail&id=<?= $i-1 ?>" >
                     <img src="<?= $m->image ?>" width="100" height="100">
                  </a>
               </td>
               <td>
                  <a href="index.php?action=edit&id=<?= $i-1 ?>" >
                     <img src="https://thumbs.dreamstime.com/b/edit-symbol-icon-monogram-blue-colors-crystal-design-illustration-image-edit-button-symbol-icon-monogram-179562562.jpg"
                     width="50" height="50">
                  </a>
               </td>
               <td>
                  <a href="index.php?action=delete&id=<?= $i-1 ?>" 
                  onclick="return confirm('Do you want to delete this mobile ?')";
                  >
                     <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRa-7ckfH-dcZ8fKq-UlbNpiydNckY2VP64lw&usqp=CAU"
                     width="50" height="50">
                  </a>
               </td>
            </tr>
            <?php
               $i++; 
               }
            ?>
         </tbody>
      </table>
      <div class="container col-md-5 text-center">
         <form action="" method="POST">
            <div class="form-group">
               <label>Mobile name</label>
               <input type="text" class="form-control" name="name">
            </div>
            <div class="form-group">
               <label>Mobile brand</label>
               <input type="text" class="form-control" name="brand">
            </div>
            <div class="form-group">
               <label>Mobile price</label>
               <input type="number" class="form-control" name="price">
            </div>
            <div class="form-group">
               <label>Mobile color</label>
               <input type="text" class="form-control" name="color">
            </div>
            <div class="form-group">
               <label>Mobile image</label>
               <input type="text" class="form-control" name="image">
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Save</button>
         </form>  
      </div>         
   </div>
</body>
</html>