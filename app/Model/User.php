<?php 

App::uses('BlowfishPasswordHasher','Controller/Component/Auth');


class User extends AppModel{

    public function beforeSave($options =[]){

        if(isset($this->data['User']['password'])){
            $passwordHasher=new BlowfishPasswordHasher();
            $this->data['User']['password']=$passwordHasher->hash($this->data['User']['password']);

        }

        return True;
    }

    

    public $validate = [
        'username'=>[
            'required'=>[
                'rule'=>'notBlank',
                'message'=>'username cant be blank']
        ],
        'password'=>[
            'required'=>[
                'rule'=>'notBlank',
                'message'=>'password cant be blank']
        ]

    ];

    public function get_user_info(){
        $this->virtualFields['full_name'] = 'concat(User.first_name," ",User.family_name)';


        $users_info =$this->find('all',[
            'recursive'=>-1,
            'fields'=>['User.username','User.id','User.first_name','User.family_name','Group.name','Role.title','full_name'],
            'conditions'=>['User.deleted'=>0],
            'joins'=>[[
                'table'=>'groups',
                'alias'=>'Group',
                'type'=>'inner',
                'conditions'=>['User.group_id=Group.id']
            ],[
                'table'=>'roles',
                'alias'=>'Role',
                'type'=>'inner',
                'conditions'=>['User.role_id=Role.id']
            ]]
        ]);
        return $users_info;
    }
    public function get_not_deleted_group_info($deleted=0){
        
        $group_model=ClassRegistry::init('Group');

        if(isset($deleted)){
            $conditions=['Group.deleted'=>$deleted];
        }
        else
            $conditions=['Group.deleted'=>0,'User.role_id=1'];
        
        $group_model->virtualFields['full_name']='concat(User.first_name," ",User.family_name)';
        
        $group_model->virtualFields['group_count']='count(Group.id)';
        
        $group_info=$group_model->find('all',[
            'resursive'=>-1,
            'fields'=>['Group.id','Group.name','count(Group.id) as Group__group_count'],
            'group'=>'Group.id',
            'conditions'=> $conditions,
            'joins'=>[[
                'table'=>'users',
                'alias'=>'User',
                'type'=>'inner',
                'conditions'=>['User.group_id=Group.id']
            ]]
        ]);

        

        return $group_info;
    }
}