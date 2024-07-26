<?php 
    namespace App\Repositories\Point;
    use App\Constants;
    use App\Models\Members;
    use App\Models\Point_logs;
    use App\Models\Point_Purchase;
    use App\ReturnedMessage;
    use App\Utility;
    use Illuminate\Support\Facades\DB;

    class PointRepository implements PointRepositoryInterface{
        public function getMembers(){
            $base_url = url('/');
            $members = Point_Purchase::select('member_id',
                                    DB::raw("CONCAT('". $base_url ."/storage/purchases/', member_id, '/', screenshot) AS screenshot_path"),
                                )
                                ->where('status','=',Constants::PURCHASE_SENT_STATUS)
                                ->paginate(Constants::RECORDS_PER_PAGE);
            return $members;
        }
        public function addPoints(array $data){
            DB::beginTransaction();
            try{
                $returned_array = [];
                $purchase       = Point_Purchase::find($data['id']);
                $update         = [];
                $update['status'] = Constants::PURCHASE_SUCCESS_STATUS;
                $update['point']  = $data['point'];
                $purchase->update($update);
                DB::commit();
                try{
                    $member = Members::find($purchase->member_id);
                    $member_update = [];
                    $member_update['point'] = $member->point + $data['point'];
                    $member->update($member_update);
                    DB::commit();
                    try{
                        $insert                 = [];
                        $insert['added_point']  = $data['point'];
                        $insert['member_id']    = $purchase->member_id;
                        $insert['purchase_id']  = $purchase->id;
                        $paramObj               = Utility::addCreatedBy($insert);
                        Point_logs::create($paramObj);
                        DB::commit();
                        $returned_array['status'] = ReturnedMessage::STATUS_OK;
                    }
                    catch (\Exception $e) {
                        DB::rollBack();
                        Utility::saveErrorLog((string) "PointRepository:addPoints - \n",(string) $e->getMessage());
                        abort(500);
                    }
                    $returned_array['status'] = ReturnedMessage::STATUS_OK;
                    return $returned_array;
                }
                catch (\Exception $e) {
                    DB::rollBack();
                    Utility::saveErrorLog((string) "PointRepository:addPoints - \n",(string) $e->getMessage());
                    abort(500);
                }
            }
            catch (\Exception $e) {
                DB::rollBack();
                Utility::saveErrorLog((string) "PointRepository:addPoints - \n",(string) $e->getMessage());
                abort(500);
            }
        }
        public function rejectPurchase(int $id){
            $returned_array     = [];
            $update             = [];
            $update['status']   = Constants::PURCHASE_FAILED_STATUS;
            $purchase           = Point_Purchase::find($id);
            $paramObj           = Utility::addUpdatedBy((array) $update);
            $result             = $purchase->update($paramObj);
            if($result){
                $returned_array['status'] = ReturnedMessage::STATUS_OK;
            }
            else{
                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            return $returned_array;
        }
        public function showPoints(){
            $point_logs = Point_logs::select('member_id','purchase_id','added_point','created_by')
                                ->whereNull('subtracted_point')
                                ->whereNull('date_request_id')
                                ->paginate(5);
            return $point_logs;
        }
    }
?>