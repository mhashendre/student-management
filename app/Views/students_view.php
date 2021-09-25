<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <title>Student Details</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
   <style>
      .container {
         /* max-width: 500px; */
      }

      .error {
         display: block;
         padding-top: 5px;
         font-size: 14px;
         color: red;
      }
      .right-align{
         float: right;
      }
   </style>
</head>

<body>
   <div class="container  mt-4">
      <div class="row">
         <div class="col-lg-12">
            <div class="card">
               <div class="card-header">
                  <div class="row">
                     <div class="col-lg-6">
                        <h4>Student Data</h4>
                     </div>
                     <div class="col-lg-6">
                        <a href="<?php echo site_url('students-form/') ?>" class="btn btn-success mb-2 right-align">Add Student</a>
                     </div>
                  </div>
               </div>
               <div class="card-body">
                  <div class="mt-3">
                     <table class="table table-bordered" id="students-list">
                        <thead>
                           <tr>
                              <th>Student Id</th>
                              <th>First Name</th>
                              <th>Last Name</th>
                              <th>Address</th>
                              <th>NIC</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php if ($students) : ?>
                              <?php foreach ($students as $student) : ?>
                                 <tr>
                                    <td><?php echo $student['studentId']; ?></td>
                                    <td><?php echo $student['firstName']; ?></td>
                                    <td><?php echo $student['lastName']; ?></td>
                                    <td><?php echo $student['address']; ?></td>
                                    <td><?php echo $student['nic']; ?></td>
                                    <td>
                                       <a href="<?php echo base_url('edit-student/' . $student['studentId']); ?>" class="btn btn-primary btn-sm right-align" style="margin-left: 5px;">Edit</a>
                                       <a href="<?php echo base_url('delete/' . $student['studentId']); ?>" class="btn btn-danger btn-sm right-align">Delete</a>
                                    </td>
                                 </tr>
                              <?php endforeach; ?>
                           <?php endif; ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>


   <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
   <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
   <script>
      $(document).ready(function() {
         $('#students-list').DataTable();
      });
   </script>

</body>



</html>