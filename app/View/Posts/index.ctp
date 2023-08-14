<h1>Blog Posts</h1>
<?php echo $this->Html->link('Add Post',['controller'=>'posts','action'=>'add']); ?>
<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Action</th>
        <th>created</th>
    </tr>
    <?php foreach ($posts as $post) : ?>
    <tr>
        <td><?php echo $post['Post']['id'];?></td>
        <td><?php echo $post['Post']['title']; ?></td>
        <td><?php echo $this->Html->link('Edit',['controller'=>'posts','action'=>'edit',$post['Post']['id']]).' '.$this->Html->link('View',['controller'=>'posts','action'=>'view',$post['Post']['id']]);  ?></td>
        <td><?php echo $post['Post']['created'];?></td>
    </tr>
    <?php endforeach;?>
</table>