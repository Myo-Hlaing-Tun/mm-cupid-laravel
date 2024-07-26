<?php 
    namespace App\Repositories\Hobby;

    interface HobbyRepositoryInterface{
        public function getHobbies();
        public function createHobby(array $data);
        public function getHobbyById(int $id);
        public function editHobby(array $data);
    }
?>