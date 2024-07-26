<?php 
    namespace App\Repositories\City;

    interface CityRepositoryInterface{
        public function getCities();
        public function addCity(array $data);
        public function getEditCity(int $id);
        public function updateCity(array $data);
    }
?>