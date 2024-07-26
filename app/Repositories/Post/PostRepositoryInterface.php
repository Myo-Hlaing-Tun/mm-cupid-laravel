<?php 
    namespace App\Repositories\Post;

    interface PostRepositoryInterface{
        public function getPosts();
        public function createPost(array $data);
        public function getPostById(int $id);
        public function updatePost(array $data);
        public function deletePost(int $id);
    }
?>