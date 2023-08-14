<h1>Add Post:</h1>
<?php
echo $this->Form->create('Post', ['type' => 'file']);
echo $this->Form->input('title');
echo $this->Form->input('body', ['rows' => '3','type'=>'textarea']);
echo $this->Form->input('group_id', [
    'options' => [
        1 => 'Sports',
        2 => 'Politics',
        3 => 'Economics',
    ]
]);
echo $this->Form->file('image_name', ['type' => 'file']);  // Use 'image_name' instead of 'image_path'
echo $this->Form->end('Save Post');
?>