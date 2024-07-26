<?php 
    namespace App\Repositories\Point;

    interface PointRepositoryInterface{
        public function getMembers();
        public function addPoints(array $data);
        public function rejectPurchase(int $id);
        public function showPoints();
    }
?>