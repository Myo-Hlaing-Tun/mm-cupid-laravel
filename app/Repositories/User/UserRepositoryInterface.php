<?php 
    namespace App\Repositories\User;

    interface UserRepositoryInterface{
        public function getUserInfoByUsername(string $username);
        public function getRolePermissionByRoleId(int $role);
        public function storeUser(array $data);
        public function getUsers();
        public function getUserById(int $id);
        public function updateUser(array $data);
        public function changePassword(array $data);
        public function deleteUser(int $id);
        public function banUser(int $id);
        public function unbanUser(int $id);
    }
?>