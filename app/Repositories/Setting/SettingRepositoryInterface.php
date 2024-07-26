<?php 
    namespace  App\Repositories\Setting;

    Interface SettingRepositoryInterface{
        public function storeSetting(array $data);
        public function getSetting();
        public function updateSetting(array $data);
    }
?>