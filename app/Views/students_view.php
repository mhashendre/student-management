<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <title>Student Results</title>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
   <style>
      .container {
         margin-top: 20px;
         /* min-width: 100%; */
      }

      .error {
         display: block;
         padding-top: 5px;
         font-size: 14px;
         color: red;
      }

      .right-align {
         float: right;
      }
   </style>
</head>

<body>
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="card">
               <div class="card-header">
                  <div class="row">
                     <div class="col-lg-6">
                        <h4>Student Results</h4>
                     </div>
                     <div class="col-lg-6">
                        <div class="row">
                           <form method="post" class="col-lg-12" action="<?php echo base_url('studentscontroller/uploadFile'); ?>" enctype="multipart/form-data">
                              <div class="row">
                                 <div class="form-group col-lg-9">
                                    <input type="file" name="upload_file" style="padding: 3px;" class="form-control" placeholder="Enter Name" id="upload_file" required>
                                 </div>
                                 <div class="form-group col-lg-3">
                                    <input type="submit" name="submit" class="btn btn-primary right-align">
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  <hr>
                  <div class="row">
                     <form name="form" class="col-lg-12" action="<?php echo base_url('searchResult/'); ?>" method="get">
                        <div class="row">
                           <div class="col-lg-6">
                              <input type="text" name="idText" placeholder="Enter Student Index">
                           </div>
                           <div class="col-lg-6">
                              <input type="submit" name="submit" class="btn btn-success mb-2">
                              <!-- <a href="<?php echo site_url('searchResult/') ?>" class="btn btn-success mb-2">Search</a> -->
                           </div>
                        </div>
                     </form>
                  </div>
                  <div class="row">
                     <div class="col-lg-3">
                        Index : <?php echo $marks[0]->student_id ?>
                     </div>
                     <div class="col-lg-3">
                        Name : <?php echo $marks[0]->student_name ?>
                     </div>
                     <div class="col-lg-2">
                        Total Marks : <?php echo $marks[0]->total ?>
                     </div>
                     <div class="col-lg-2">
                        Average Marks : <?php echo $marks[0]->avg ?>
                     </div>
                     <div class="col-lg-2">
                        Grade : <?php echo $marks[0]->grade ?>
                     </div>
                  </div>
               </div>

               <div class="card-body">
                  <div class="">
                     <table class="table table-bordered" id="students-list">
                        <thead>
                           <tr>
                              <th>Subject Code</th>
                              <th>Subject Name</th>
                              <th>Marks</th>
                              <th>Grade</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php if ($marks) : ?>
                              <?php foreach ($marks as $row) : ?>
                                 <tr>
                                    <td><?php echo $row->code ?></td>
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->marks; ?></td>
                                    <td><?php echo $row->grade; ?></td>
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

   <div id="myModal" class="modal">

      <!-- Modal content -->
      <div class="modal-content">
         <div class="modal-header">
            <span class="close">&times;</span>
            <h2>Modal Header</h2>
         </div>
         <div class="modal-body">
            <p>Some text in the Modal Body</p>
            <p>Some other text...</p>
         </div>
         <div class="modal-footer">
            <h3>Modal Footer</h3>
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