<h1>Edit User:</h1>



<?php
    echo $this->Form->create();
    echo $this->Form->input('id',['type'=>'hidden']);
    echo $this->Form->input('username');
    echo $this->Form->input('new_password',['type'=>'password','value'=>'']);
    echo $this->Form->input('first_name');
    echo $this->Form->input('family_name');
    echo $this->Form->input('role_id',[
        'options'=>[
            1=> 'Manager',
            2=> 'Editor',
            3=> 'Author',
            4=> 'Admin',
            5=> 'Super'
        ]
    ]);
    echo $this->Form->input('group_id',[
        'options'=>[
            1=> 'Sports',
            2=> 'Politics',
            3=> 'Economics',
        ]
    ]);
    echo $this->Form->end('save');
?>
