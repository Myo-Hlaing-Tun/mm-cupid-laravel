<?php 
    namespace App\Repositories\Member;

    interface MemberRepositoryInterface{
        public function getMemberById(int $id);
        public function getMemberByEmail(string $email);
        public function getMemberByResetCode(string $code);
        public function emailExists($email);
        public function storeMemberDetails(array $data);
        public function confirmEmail(string $code);
        public function generateToken(int $id);
        public function confirmPasswordResetCode(string $code);
        public function resetPassword(array $data);
        public function login(string $email);
        public function syncMembers(array $data);
        public function updateView(int $id);
        public function requestDate(int $id);
        public function getMember(int $id);
        public function updateMemberDetails(array $data);
        public function updatePhoto(array $data);
        public function deletePhoto(int $sort);
        public function photoVerification(string $base64);
        public function respondInvitation(array $data);
        public function getMembers();
        public function deleteMember(int $id);
        public function confirmMember(int $id);
        public function purchasePoint(array $data);
        public function subtractPoints(array $data);
        public function filterMembers(string $keyword);
        public function getRegisteredMembers();
        public function getTotalRegisteredMembers();
        public function getTodayRegisteredMembers();
        public function getTodayEmailConfirmedMembers();
        public function getTodayDateRequestsCount();
        public function getTodayDateRequests();
        public function getApprovedDatingRequests();
    }
?>