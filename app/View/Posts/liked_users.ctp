<!-- File: /app/View/Posts/liked_users.ctp -->

<h1>Users who liked '<?php echo h($post['Post']['title']); ?>'</h1>

<?php 
if($noLikes)
    echo "<p>This post has no likes.</p>";
else
?>

<ul>
    <?php foreach ($likedUsernames as $likedUsername): ?>
        <li><?php echo h($likedUsername); ?></li>
    <?php endforeach; ?>
</ul>

<!-- Back to post link -->
<p><?php echo $this->Html->link('Back to Post', array('action' => 'view', $post['Post']['id'])); ?></p>
