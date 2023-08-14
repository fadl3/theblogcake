<h1>Edit Post:</h1>
<?php
echo $this->Form->create('Post');
echo $this->Form->input('title');
echo $this->Form->input('body', ['rows' => '3']);
echo $this->Form->input('group_id', [
    'options' => [
        1 => 'Sports',
        2 => 'Politics',
        3 => 'Economics',
    ]
]);
echo $this->Form->input('id',['type'=>'hidden']);

echo $this->Form->end('Edit Post');

?>