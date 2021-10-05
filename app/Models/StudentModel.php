<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{

    protected $table = 'exam';
    protected $useAutoIncrement = true;
    protected $primaryKey = 'id';
    protected $allowedFields = ['student_id', 'student_name', 'total', 'nic', 'avg', 'grade', 'status'];

    public function getStudentsWithResults($student_id)
    {
        $query = "select e.student_id,e.student_name ,e.total, e.avg,e.grade, em.module_id , em.marks , em.grade ,mmd.code , mmd.name from exam e right join exam_module
            em on e.id = em.exam_id join master_module_data mmd on mmd.id = em.module_id where e.student_id = ?";
        $query = $this->db->query($query, [$student_id]);
        return $query->getResult();
    }
}
