<?php namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model {

    protected $table = 'student';
    protected $useAutoIncrement = true;
    protected $primaryKey = 'studentId';
    protected $allowedFields = ['firstName', 'lastName' , 'address' ,'nic'];

}