<?php

namespace App\Controllers;

require 'vendor/autoload.php';

use App\Models\InActiveStudentsModel;
use App\Models\MarksModel;
use App\Models\StudentModel;
use CodeIgniter\Controller;
use App\Models\SubjectModel;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Size;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class StudentsController extends Controller
{

    public function __construct()
    {
        helper('form');
    }


    public function index()
    {
        return view('students_view');
    }

    public function searchResult()
    {
        $value = $_GET['idText'];
        if ($value != '') {
            $studentModel = new StudentModel();
            $data['marks'] = $studentModel->getStudentsWithResults($value);
            return view('students_view', $data);
        }else {
            return view('students_view');  
        }
    }

    public function uploadFile()
    {
        if ($this->request->getMethod() == 'post') {

            $subjects = $this->getAllSubjects();

            $validation = \Config\Services::validation();

            $valid = $this->validate(
                [
                    'upload_file' => [
                        'label' => 'Input File',
                        'rules' => 'uploaded[upload_file]|ext_in[upload_file,xls,xlsx]',
                        'errors' => [
                            'uploaded' => '{field} Invalid File Format',
                            'ext_in' => '{field} extenstion is wrong'
                        ]
                    ]
                ]
            );

            if (!$valid) {
                $this->session->setFlashData('Invalid File Format', $validation->getError('upload_file'));
                echo 'Invalid File Format';
            } else {
                $excel_file = $this->request->getFile('upload_file');
                $ext = $excel_file->getClientExtension();
                if ($ext == 'xls') {
                    $render  = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                } else if ($ext == 'xlsx') {
                    $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spredsheet = $render->load($excel_file);
                $data = $spredsheet->getActiveSheet()->toArray();


                $this->readExcelSheet($data, $subjects);
            }
        }
        return view('students_view');
    }

    private function getSubjectId($subjects, $code)
    {
        foreach ($subjects as $x => $sub) {
            if ($sub['code'] == $code) {
                return $sub['id'];
            }
        }
    }

    private function getSubjectCode($subjects, $code)
    {
        foreach ($subjects as $x => $sub) {
            if ($sub['code'] == $code) {
                return $sub['code'];
            }
        }
    }

    private function getSubjectStatus($subjects, $code)
    {
        foreach ($subjects as $x => $sub) {
            if ($sub['code'] == $code) {
                return $sub['status'];
            }
        }
    }

    private function saveStudent($studentData)
    {
        $studentModel = new StudentModel();
        $student = $this->getStudentByStudentId($studentData['student_id']);
        if ($student == null) {
            $studentModel->insert($studentData, true);
            return $this->getStudentByStudentId($studentData['student_id']);
        } else {
            return $student;
        }
    }

    private function getAllStudents()
    {
        $studentModel = new StudentModel();
        return $data['students'] = $studentModel->findAll();
    }

    private function getStudentByStudentId($id)
    {
        $studentModel = new StudentModel();
        return  $studentModel->where('student_id', $id)->first();
    }

    private function getAllSubjects()
    {
        $subModel = new SubjectModel();
        return $result['subjects'] = $subModel->findAll();
    }

    private function saveMarks($marks)
    {
        $marksModel = new MarksModel();
        foreach ($marks as $x => $mark) {
            $marksModel->insert($mark);
        }
    }

    private function saveNotUploadedMarks($notActiveMarks)
    {
        $notActiveMarksModel = new InActiveStudentsModel();
        foreach ($notActiveMarks as $x => $markk) {
            $notActiveMarksModel->insert($markk);
        }
    }

    private function readExcelSheet($data, $subjects)
    {
        $moduleMarks = [];
        $inActiveModuleMarks = [];
        foreach ($data as $x => $row) {
            if ($x == 0) {
                continue;
            }

            if ($row[0] != null) {

                $studentData = [
                    'student_id' =>  $row[0],
                    'student_name'  =>  $row[1],
                    'total'  => $row[19],
                    'nic'  => $row[2],
                    'avg'  => (is_numeric($row[19]) ? is_numeric($row[19] / 9) : 0),
                    'grade'  => $row[20],
                    'status'  => 'active'
                ];

                $savedData = $this->saveStudent($studentData);

                if ($row[3] != "NA" && $row[3] != "-") {
                    $status =  $this->getSubjectStatus($subjects, "HKTH");
                    if ($status == "Active") {
                        array_push($moduleMarks, [
                            'exam_id' => $savedData['id'],
                            'module_id' => $this->getSubjectId($subjects, "HKTH"),
                            'grade' =>  $row[4],
                            'marks' => $row[3],
                            'state' => $this->getSubjectStatus($subjects, "HKTH")
                        ]);
                    } else {
                        array_push($inActiveModuleMarks, [
                            'student_id' => $savedData['id'],
                            'name' => $savedData['student_name'],
                            'mod_code' => $this->getSubjectCode($subjects, "HKTH"),
                            'grade' =>  $row[4],
                            'marks' => $row[3]
                        ]);
                    }
                }

                if ($row[5] != "NA" && $row[5] != "-") {
                    $status =  $this->getSubjectStatus($subjects, "HKPR");
                    if ($status == "Active") {
                        array_push($moduleMarks, [
                            'exam_id' => $savedData['id'],
                            'module_id' => $this->getSubjectId($subjects, "HKPR"),
                            'grade' =>  $row[6],
                            'marks' => $row[5],
                            'state' => $this->getSubjectStatus($subjects, "HKPR")
                        ]);
                    } else {
                        array_push($inActiveModuleMarks, [
                            'student_id' => $savedData['id'],
                            'name' => $savedData['student_name'],
                            'mod_code' => $this->getSubjectCode($subjects, "HKPR"),
                            'grade' =>  $row[6],
                            'marks' => $row[5]
                        ]);
                    }
                }

                if ($row[7] != "NA" && $row[7] != "-") {
                    $status =  $this->getSubjectStatus($subjects, "HENGL");
                    if ($status == "Active") {
                        array_push($moduleMarks, [
                            'exam_id' => $savedData['id'],
                            'module_id' => $this->getSubjectId($subjects, "HENGL"),
                            'grade' =>  $row[8],
                            'marks' => $row[7],
                            'state' => $this->getSubjectStatus($subjects, "HENGL")
                        ]);
                    } else {
                        array_push($inActiveModuleMarks, [
                            'student_id' => $savedData['id'],
                            'name' => $savedData['student_name'],
                            'mod_code' => $this->getSubjectCode($subjects, "HENGL"),
                            'grade' =>  $row[8],
                            'marks' => $row[7]
                        ]);
                    }
                }

                if ($row[9] != "NA" && $row[9] != "-") {
                    $status =  $this->getSubjectStatus($subjects, "GLAN");
                    if ($status == "Active") {
                        array_push($moduleMarks, [
                            'exam_id' => $savedData['id'],
                            'module_id' => $this->getSubjectId($subjects, "GLAN"),
                            'grade' =>  $row[10],
                            'marks' => $row[9],
                            'state' => $this->getSubjectStatus($subjects, "GLAN")
                        ]);
                    } else {
                        array_push($inActiveModuleMarks, [
                            'student_id' => $savedData['id'],
                            'name' => $savedData['student_name'],
                            'mod_code' => $this->getSubjectCode($subjects, "GLAN"),
                            'grade' =>  $row[10],
                            'marks' => $row[9]
                        ]);
                    }
                }

                if ($row[11] != "NA" && $row[11] != "-") {
                    $status =  $this->getSubjectStatus($subjects, "PAPD");
                    if ($status == "Active") {
                        array_push($moduleMarks, [
                            'exam_id' => $savedData['id'],
                            'module_id' => $this->getSubjectId($subjects, " PAPD"),
                            'grade' =>  $row[12],
                            'marks' => $row[11],
                            'state' => $this->getSubjectStatus($subjects, " PAPD")
                        ]);
                    } else {
                        array_push($inActiveModuleMarks, [
                            'student_id' => $savedData['id'],
                            'name' => $savedData['student_name'],
                            'mod_code' => $this->getSubjectCode($subjects, "PAPD"),
                            'grade' =>  $row[12],
                            'marks' => $row[11]
                        ]);
                    }
                }

                if ($row[13] != "NA" && $row[13] != "-") {
                    $status =  $this->getSubjectStatus($subjects, "OSHA");
                    if ($status == "Active") {
                        array_push($moduleMarks, [
                            'exam_id' => $savedData['id'],
                            'module_id' => $this->getSubjectId($subjects, "OSHA"),
                            'grade' =>  $row[14],
                            'marks' => $row[13],
                            'state' => $this->getSubjectStatus($subjects, "OSHA")
                        ]);
                    } else {
                        array_push($inActiveModuleMarks, [
                            'student_id' => $savedData['id'],
                            'name' => $savedData['student_name'],
                            'mod_code' => $this->getSubjectCode($subjects, "OSHA"),
                            'grade' =>  $row[12],
                            'marks' => $row[11]
                        ]);
                    }
                }

                if ($row[15] != "NA" && $row[15] != "-") {
                    $status =  $this->getSubjectStatus($subjects, "SQ");
                    if ($status == "Active") {
                        array_push($moduleMarks, [
                            'exam_id' => $savedData['id'],
                            'module_id' => $this->getSubjectId($subjects, "SQ"),
                            'grade' =>  $row[16],
                            'marks' => $row[15],
                            'state' => $this->getSubjectStatus($subjects, "SQ")
                        ]);
                    } else {
                        array_push($inActiveModuleMarks, [
                            'student_id' => $savedData['id'],
                            'name' => $savedData['student_name'],
                            'mod_code' => $this->getSubjectCode($subjects, "SQ"),
                            'grade' =>  $row[16],
                            'marks' => $row[15]
                        ]);
                    }
                }

                if ($row[17] != "NA" && $row[17] != "-") {
                    $status =  $this->getSubjectStatus($subjects, "IHOS");
                    if ($status == "Active") {
                        array_push($moduleMarks, [
                            'exam_id' => $savedData['id'],
                            'module_id' => $this->getSubjectId($subjects, "IHOS"),
                            'grade' =>  $row[18],
                            'marks' => $row[17],
                            'state' => $this->getSubjectStatus($subjects, "IHOS")
                        ]);
                    } else {
                        array_push($inActiveModuleMarks, [
                            'student_id' => $savedData['id'],
                            'name' => $savedData['student_name'],
                            'mod_code' => $this->getSubjectCode($subjects, "IHOS"),
                            'grade' =>  $row[18],
                            'marks' => $row[17]
                        ]);
                    }
                }

                $this->saveMarks($moduleMarks);
                $this->saveNotUploadedMarks($inActiveModuleMarks);
            }
        }
    }
}
