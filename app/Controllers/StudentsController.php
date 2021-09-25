<?php

namespace App\Controllers;

use App\Models\StudentModel;
use CodeIgniter\Controller;

class StudentsController extends Controller
{

   public function index()
   {
      $studentModel = new StudentModel();
      $data['students'] = $studentModel->orderBy('studentId', 'ASC')->findAll();
    //   print_r($data);
      return view('students_view' , $data);
   }

  // add user form
  public function create(){
      return view('add_student');
  }

  // insert data
  public function store() {
      $studentModel = new StudentModel();
      $data = [
        'firstName' => $this->request->getVar('firstName'),
        'lastName'  => $this->request->getVar('lastName'),
        'address'  => $this->request->getVar('address'),
        'nic'  => $this->request->getVar('nic'),
      ];
      $studentModel->insert($data);
      return $this->response->redirect(site_url('/students'));
  }

  // show single user
  public function singleStudent($id = null){
      $studentModel = new StudentModel();
      $data['student_obj'] = $studentModel->where('studentId', $id)->first();
      return view('edit_student', $data);
  }

  // update user data
  public function update(){
      echo "Updating !";
      $studentModel = new StudentModel();
      $id = $this->request->getVar('studentId');
      $data = [
          'firstName' => $this->request->getVar('firstName'),
          'lastName'  => $this->request->getVar('lastName'),
          'address'  => $this->request->getVar('address'),
          'nic'  => $this->request->getVar('nic'),
      ];
      $studentModel->update($id, $data);
      return $this->response->redirect(site_url('/students'));
  }

  // delete user
  public function delete($id = null){
      $studentModel = new StudentModel();
      $data['user'] = $studentModel->where('studentId', $id)->delete($id);
      return $this->response->redirect(site_url('/students'));
  }  

}
