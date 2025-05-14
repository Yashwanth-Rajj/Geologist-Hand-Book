<?php 
  include 'Connection.php'; 
  ?> 
   <!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Geologist Hand Book!</title>
</head>

<body>
                 <div class="container my-5" > 
                 <table class="table">
  <thead>
    <tr>
      <th scope="col">Sl No</th>
      <th scope="col">First Name </th>
      <th scope="col">Last Name </th>
      <th scope="col">Email</th>
      <th scope="col">Mobile</th>
    </tr>
  </thead>
  <tbody>
   <?php

 $sql = "SELECT * FROM mine" ;
 $result = mysqli_query($con, $sql); 
 while ($row = mysqli_fetch_assoc($result)){
   $id = $row ['ID'];
    $fname =  $row['fname'];
    $lname =  $row['lname'];
    $email = $row['email'];
    $Mobile =   $row['Mobile'];
   echo ' <tr>
      <th scope="row">'.$id.'</th>
      <td>'.$fname.'</td>
      <td>'.$lname.'</td>
      <td>'.$email.'</td>
      <td>'.$Mobile.'</td>
    </tr>';
     
   
 }
 
 
 
 ?>
    
      </tbody>
</table>


</div>

 