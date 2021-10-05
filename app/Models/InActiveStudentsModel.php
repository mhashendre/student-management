<?php namespace App\Models;

use CodeIgniter\Model;

class InActiveStudentsModel extends Model {
    protected $table = 'not_upload_list';
    protected $useAutoIncrement = true;
    protected $primaryKey = 'id';
    protected $allowedFields = ['student_id', 'name' , 'mod_code' ,'marks' , 'grade'];
}