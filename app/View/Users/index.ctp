<h1>Users</h1>
<table>
<tr>
    <th>Full Name</th>
    <th>Group</th>
    <th>Role</th>
    <th>Action</th>
</tr>
<?php foreach ($users_info as $user){
    echo '<tr>';
    echo '<td>'.$user['User']['full_name'].'</td>';
    echo '<td>'.$user['Group']['name'].'</td>';
    echo '<td>'.$user['Role']['title'].'</td>';
    echo '<td>'.$this->Html->link('View',[
        'controller'=>'users',
        'action'=>'view',
        $user['User']['id']
    ]).' '. $this->Html->link('Edit',[
        'controller'=>'users',
        'action'=>'edit',
        $user['User']['id']
    ]).'</td>';
    echo '</tr>';
} ?>
</table>