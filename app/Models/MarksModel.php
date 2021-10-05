<?php namespace App\Models;

use CodeIgniter\Model;

class MarksModel extends Model {
    protected $table = 'exam_module';
    protected $useAutoIncrement = true;
    protected $primaryKey = 'id';
    protected $allowedFields = ['exam_id', 'module_id' , 'marks' ,'grade' , 'state'];
}