<!DOCTYPE html>
<html lang="en">
<head>
  <title>How To Import Excel and CSV File Using CodeIgniter - XpertPhp</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
 
<div class="container" style="margin-top:50px;">
  <div class="row">
 <div class="col-lg-10"><h2>codeigniter excel Import</h2></div>
 <div class="col-lg-1">&nbsp;</div>
 <div class="col-lg-1"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#importModal">Import</button></div>
  </div>  
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Id</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Address</th>
        <th>Email</th>
        <th>Mobile</th>
      </tr>
    </thead>
    <tbody>
 <?php
 foreach($user_data as $row) {
 ?>
      <tr>
        <td><?php echo $row['id'];?></td>
        <td><?php echo $row['first_name'];?></td>
        <td><?php echo $row['last_name'];?></td>
        <td><?php echo $row['email'];?></td>
        <td><?php echo $row['phone'];?></td>
        <td><?php echo $row['created'];?></td>
      </tr>
 <?php 
 } ?> 
    </tbody>
  </table>
</div>
 
<!-- Modal -->
  <div class="modal fade" id="importModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload Csv file</h4>
        </div>
        <div class="modal-body">
          <form action="<?php echo base_url();?>import/uploadData" method="post" enctype="multipart/form-data">
 <div class="col-lg-12">
 <div class="form-group">
 <input type="file" name="uploadFile" id="uploadFile" class="filestyle" data-icon="false">
 </div>
 </div> 
 <div class="col-lg-12">
 <input type="submit" value="Upload file" id="upload_btn">
 </div> 
   </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
</body>
</html>