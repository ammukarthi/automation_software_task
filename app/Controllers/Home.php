<?php

namespace App\Controllers;

class Home extends BaseController
{

    public function index(): string
    {
        return view('welcome_message');
    }

    public function login(): string
    {
        return view('login');
    }

    public function products()
    {
        return view('products');
    }

    public function postLogin(){

        $this->session->remove('user');

        $user_name = $this->request->getPost('user_name');
        $password = $this->request->getPost('password');

        $query = $this->db->query("SELECT * FROM ilance_users where username = '".$user_name."' limit 1"); 

        $result = $query->getResult();

        if(count($result) == 0){

          $this->session->setFlashdata('error', 'You are not a valid user');

           return redirect('/');
        }

        //621f2122371d07da485bdd31493c38e3*YW%Z 

        //890825ddcfc0eeaad575d881980d1fbb //new hashed password of admin

        //old password - 85db96ea4df0cafc47254bdab484de3f

        $hashed_password = md5(md5($password).$result[0]->salt);

        if($hashed_password != $result[0]->password){

            $this->session->setFlashdata('error', 'Please check your password again');

            return redirect('/');
        }

        $user = ['user_id' => $result[0]->user_id,'username' => $result[0]->username,'salt' => $result[0]->salt,'logged_in' => true];

        $this->session->set('user',$user);  

        $this->session->setFlashdata('success', 'Welcome');
        
        return redirect('products');
         
    }

    public function productData($record,$sorting) {

        $pager = service('pager');

		$recordPerPage = 2;
		if($record != 0){
			$record = ($record-1) * $recordPerPage;
		}      	
      	$recordCount = $this->getRecordCount();
      	$projectRecord = $this->getRecord($record,$recordPerPage,$sorting);
   
		
		$data['pagination'] =  $pager->makeLinks($record, $recordPerPage, $recordCount);
		$data['projectRecord'] = $projectRecord;
        $data['record'] = $record;
        $data['sorting'] = $sorting;

		echo json_encode($data);		
	}

    public function getRecord($rowno,$rowperpage,$sorting) {

        if($sorting == "recent_projects"){

            $sort_by = "ilance_projects.id desc";

        }else if($sorting == "category_name"){

            $sort_by = "ilance_categories.category_name";

        }else if($sorting == "user_name"){

            $sort_by = "ilance_users.username";

        }else{

            $sort_by = "ilance_projects.project_title";
        }

		$query = $this->db->query("SELECT ilance_projects.id,ilance_projects.project_title,ilance_projects.user_id,ilance_projects.cid,ilance_users.user_id,ilance_users.username,ilance_categories.category_id,ilance_categories.category_name FROM `ilance_projects` inner join ilance_users on ilance_projects.user_id = ilance_users.user_id left join ilance_categories on ilance_projects.cid = ilance_categories.category_id order by $sort_by limit $rowno,$rowperpage"); 
        return $query->getResult();    	
	}

	public function getRecordCount() {
    	
        $query = $this->db->query("SELECT ilance_projects.id,ilance_projects.project_title,ilance_projects.user_id,ilance_projects.cid,ilance_users.user_id,ilance_users.username,ilance_categories.category_id,ilance_categories.category_name FROM `ilance_projects` inner join ilance_users on ilance_projects.user_id = ilance_users.user_id left join ilance_categories on ilance_projects.cid = ilance_categories.category_id order by ilance_projects.id desc"); 
        $result = $query->getResult();
        
      	return count($result);
    }

    public function logout(){

        $this->session->remove('user');

        $this->session->setFlashdata('success', 'Logged Out Successfully !');
        
        return redirect('/');
    }

}
