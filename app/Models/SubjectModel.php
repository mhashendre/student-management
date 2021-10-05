<?php namespace App\Models;

use CodeIgniter\Model;

class SubjectModel extends Model {
    protected $table = 'master_module_data';
    protected $useAutoIncrement = true;
    protected $primaryKey = 'id';
    protected $allowedFields = ['code', 'name' , 'status'];
}