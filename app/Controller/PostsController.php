<?php

class PostsController extends AppController
{
    public $helpers = array('Html', 'Form');

    public function index()
    {
        $posts = $this->Post->find('all');

        $this->set('posts', $posts);
    }
    public function view($id = null)
    {

        $this->loadModel('PostView');

        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $post = $this->Post->findById($id);

        if (!$post) {
            throw new NotFoundException(__('No such post exists'));
        }

        // Check if the current user has already viewed the post
        $userId = $this->Auth->user('id');

        $hasViewed = $this->PostView->find(
            'count',
            array(
                'conditions' => array(
                    'PostView.user_id' => $userId,
                    'PostView.post_id' => $id
                )
            )
        ) > 0;

        if (!$hasViewed) {
            // Increment unique views and create a new PostView record
            $post['Post']['uqviews'] += 1;
            $this->Post->save($post);

            $this->PostView->create();
            $this->PostView->save(array('user_id' => $userId, 'post_id' => $id));
        }

        // Increment total views and update the post record
        $post['Post']['views'] += 1;
        $this->Post->save($post);

        //to change like button text
        $this->loadModel('PostLike');
        $liked = $this->PostLike->find('count', [
            'conditions' => [
                'PostLike.user_id' => $userId,
                'PostLike.post_id' => $id
            ]
        ]) > 0;
        $this->set('liked',$liked);
        $this->set('post', $post);
    }

    public function add()
    {
        if ($this->request->is('post')) {
            $this->Post->create();

            $this->request->data['Post']['user_id'] = $this->Auth->user('id');

            // Handle file upload
            $image = $this->request->data['Post']['image_name'];
            $imagePath = WWW_ROOT . 'img' . DS . 'uploads' . DS . $image['name'];
            $this->request->data['Post']['image_name'] = $this->request->data['Post']['image_name']['name'];

            if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                // File uploaded successfully, proceed to save
                if ($this->Post->save($this->request->data)) {
                    $this->Flash->success(__('Your post has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('Unable to add your post.'));
                }
            } else {
                $this->Flash->error('Failed to upload file.');
            }
        }
    }
    public function like_unlike($id = null)
    {
        $this->loadModel('PostLike');

        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $post = $this->Post->findById($id);

        if (!$post) {
            throw new NotFoundException(__('No such post exists'));
        }

        $userId = $this->Auth->user('id');

        $existingLike = $this->PostLike->find(
            'first',
            array(
                'conditions' => array(
                    'PostLike.user_id' => $userId,
                    'PostLike.post_id' => $id
                )
            )
        );



        if ($existingLike) {
            // Unlike the post
            $post['Post']['likes'] -= 1;
            $this->Post->save($post);

            $this->PostLike->delete($existingLike['PostLike']['id']);
        } else {
            // Like the post
            $post['Post']['likes'] += 1;
            $this->Post->save($post);

            $this->PostLike->create();
            $this->PostLike->save(array('user_id' => $userId, 'post_id' => $id));
        }

        // Redirect back to the post view
        return $this->redirect(['action' => 'view', $id]);
    }

    public function liked_users($id = null)
    {
        $this->loadModel('PostLike');
        $this->loadModel('User');
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $post = $this->Post->findById($id);

        if (!$post) {
            throw new NotFoundException(__('No such post exists'));
        }

        // Retrieve the list of users who liked the post
        $likedUsers = $this->PostLike->find(
            'all',
            array(
                'conditions' => array(
                    'PostLike.post_id' => $id
                ),
                'contain' => array('User') // Include associated User data
            )
        );

        // Pass the liked users data to the view
        $this->set('post', $post);

        $likedusersIds = [];

        foreach ($likedUsers as $likedUser)
            $likedUsersIds[] = $likedUser['PostLike']['user_id'];

        $noLikes = 1;
        $likedUsernames = [];

        if (!empty($likedUsersIds)) {
            $likedUsers = $this->User->find(
                'all',
                array(
                    'conditions' => array(
                        'User.id' => $likedUsersIds
                    )
                )
            );

            foreach ($likedUsers as $user) {
                $likedUsernames[] = $user['User']['username'];
            }
            $noLikes = 0;
        }

        $this->set('noLikes', $noLikes);
        $this->set('likedUsernames', $likedUsernames);
    }

    public function edit($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }
        $post = $this->Post->findById($id);
        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }
        if ($post['Post']['user_id'] !== $this->Auth->user('id')) {
            throw new ForbiddenException(__('You are not authorized to edit this post.'));
        }
        if ($this->request->is(['post', 'put'])) {
            $this->Post->id = $id;
            if ($this->Post->save($this->request->data)) {
                $this->Flash->success(__('Your post has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your post.'));
        }
        if (!$this->request->data) {
            $this->request->data = $post;
        }
    }
}