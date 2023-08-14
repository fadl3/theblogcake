<?php
class Post extends AppModel{
    public $validate=[
        'title'=>[
            'rule'=>'notBlank'
        ],
        'body'=>[
            'rule'=>'notBlank'
        ],
        'user_id'=>[
            'rule'=>'notBlank'
        ],
        'group_id'=>[
            'rule'=>'notBlank'
        ]
    ];

}