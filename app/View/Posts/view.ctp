<!-- File: /app/View/Posts/view.ctp -->

<h1>
    <?php echo h($post['Post']['title']); ?>
</h1>

<p>
    <small>Created:
        <?php echo $post['Post']['created']; ?>
    </small>
</p>

<p>
    <?php echo h($post['Post']['body']); ?>
</p>

<p>
    <?php echo $this->Html->image($post['Post']['image_name']); ?>
</p>


<!-- Like Button -->
<p>
    <?php
    $buttonText = $liked ? 'Unlike' : 'Like';

    echo $this->Form->postLink(
        $buttonText,
        [
            'controller' => 'posts',
            'action' => 'like_unlike',
            $post['Post']['id']
        ]
    );
    ?>
</p>


<!-- Display Likes -->
<p>
    <?php
    // Link to show users who liked the post
    echo $this->Html->link(
        $post['Post']['likes'] . ' likes',
        // Link text
        array('controller' => 'posts', 'action' => 'liked_users', $post['Post']['id'])
    );
    ?>
</p>


<p><small>
        <?php echo h('This post has been viewed ' . $post['Post']['views'] . ' times.'); ?>
    </small></p>

<p><small>
        <?php echo h('This post has been viewed by ' . $post['Post']['uqviews'] . ' users.'); ?>
    </small></p>