<?php

class UsersController extends AppController{
    public function index(){
        
        
        $users_info =$this->User->get_user_info();

        $this->set('users_info', $users_info);
    }

    public function add(){
        if($this->request->is('post')){
            $this->User->create();
            if($this->User->save($this->request->data)){
                $this->Flash->success(__('The user has been saved'));
                return $this->redirect(['action'=>'index']);
            }
            $this->Flash->error(__('Sorry something went wrong'));
        }

    }

    public function beforeFilter(){

        parent::beforeFilter();
        $this->Auth->allow('add','logout');
    }

    public function logout(){
        return $this->redirect($this->Auth->logout());
    }

    public function login(){
        if($this->request->is('post')){
            if($this->Auth->login()){
                $this->Flash->success(__('User logged in successfully'));
                return $this->redirect($this->Auth->redirectUrl());
            }

            $this->Flash->error(__('Something went wrong'));
        }
    }

    public function view($id=null){
        if(empty($id)){
            throw new NotFoundException(__('Invalid user'));
        }
        
        $user_info=$this->User->findById($id);

        if(empty($user_info)){
            throw new NotFoundException(__('No user found in DB'));
        }

        
        $this->set('user_info',$user_info);


    }
    
    public function edit($id=null){
        if(empty($id)){
            throw new NotFoundException(__('Invalid user'));
        }


        if(empty($this->request->data)){
            $user_info=$this->User->findById($id);
            $this->request->data=$user_info;
            unset($this->request->data['User']['password']);
        }
        else{
            if(!empty($this->request->data['User']['new_password'])){
                $this->request->data['User']['password']=$this->request->data['User']['new_password'];
            }
            unset($this->request->data['User']['new_password']);
            if($this->User->save($this->request->data)){
                $this->Flash->success(__('This user has been saved'));
                return $this->redirect(['action'=>'index']);
            }
        }



        
   

    }

}