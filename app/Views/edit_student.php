<!DOCTYPE html>
<html>

<head>
    <title>Codeigniter 4 CRUD - Edit User Demo</title>
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
    </style>
</head>

<body>
    <div class="container  mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Student Data</h4>
                    </div>
                    <div class="card-body">
                        <div class="container mt-5">
                            <form method="post" id="update_student" name="update_student" action="<?= site_url('/update') ?>">
                                <input type="hidden" name="studentId" id="studentId" value="<?php echo $student_obj['studentId']; ?>">

                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="firstName" class="form-control" value="<?php echo $student_obj['firstName']; ?>">
                                </div>

                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="lastName" class="form-control" value="<?php echo $student_obj['lastName']; ?>">
                                </div>

                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" value="<?php echo $student_obj['address']; ?>">
                                </div>

                                <div class="form-group">
                                    <label>NIC</label>
                                    <input type="text" name="nic" class="form-control" value="<?php echo $student_obj['nic']; ?>">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger btn-block">Update Student</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>
    <script>
        if ($("#update_student").length > 0) {
            $("#update_student").validate({
                rules: {
                    firstName: {
                        required: true,
                    },
                    lastName: {
                        required: true,
                    },
                    nic: {
                        required: true,
                        maxlength: 10
                    },
                },
                messages: {
                    firstName: {
                        required: "First Name is required.",
                    },
                    lastName: {
                        required: "Last Name is required.",
                    },
                    nic: {
                        required: "NIC is required.",
                        email: "It does not seem to be a valid nic.",
                        maxlength: "The nic should be or equal to 10 chars.",
                    },
                },
            })
        }
    </script>
</body>

</html>