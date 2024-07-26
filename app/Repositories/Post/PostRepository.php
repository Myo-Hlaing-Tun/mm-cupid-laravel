<?php 
    namespace App\Repositories\Post;

    use App\Models\Post;
    use App\ReturnedMessage;
    use App\Utility;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Storage;

    class PostRepository implements PostRepositoryInterface{
        public function getPosts(){
            $posts = Post::SELECT('id','thumb','title','description')
                    ->whereNull('deleted_at')
                    ->get();
            return $posts;
        }
        public function createPost(array $data){
            $returned_array         = [];
            $insert                 = [];
            $insert['title']        = $data['title'];
            $insert['description']  = $data['description'];
            if(isset($data['post_photo']) && $data['post_photo']->isValid()){
                $file               = $data['post_photo'];
                $unique_name        = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME) . "_" . date('Ymd_His') . "_" . uniqid() . "." . $file->getClientOriginalExtension();
                $insert['thumb']            = "thumb_" . $unique_name;
                $insert['fullsize_photo']   = $unique_name;
                $paramObj                   = Utility::addCreatedBy((array) $insert);
                $result                     = Post::create($paramObj);
                if($result){
                    $destination_path   = storage_path('app/public/posts');
                    if(!File::exists($destination_path)){
                        File::makeDirectory($destination_path, 0755, true);
                    }
                    $filesave = $file->storeAs('posts/'.$result->id,$unique_name,'public');
                    if($filesave){
                        $thumb_path = storage_path('app/public/posts/'.$result->id."/thumb");
                        if(!File::exists($thumb_path)){
                            File::makeDirectory($thumb_path, 0755, true);
                        }
                        $thumb_destination = storage_path('app/public/posts/'.$result->id."/thumb/"."thumb_" .$unique_name);
                        $fullsize_path = storage_path('app/public/posts/' . $result->id . "/" . $unique_name);
                        $thumb_save = Utility::saveFile($fullsize_path,$thumb_destination,150,150);
                        if($thumb_save){
                            $returned_array['status'] = ReturnedMessage::STATUS_OK;
                        }
                    }
                }
                else{
                    $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
                }
            }
            return $returned_array;
        }
        public function getPostById(int $id){
            $post = Post::find($id);
            return $post;
        }
        public function updatePost(array $data){
            $returned_array         = [];
            $post_id                = $data['id'];
            $post                   = Post::find($post_id);
            $insert                 = [];
            $insert['title']        = $data['title'];
            $insert['description']  = $data['description'];
            if(isset($data['post_photo']) && $data['post_photo']->isValid()){
                $file               = $data['post_photo'];
                $unique_name        = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME) . "_" . date('Ymd_His') . "_" . uniqid() . "." . $file->getClientOriginalExtension();
                $insert['thumb']            = "thumb_" . $unique_name;
                $insert['fullsize_photo']   = $unique_name;
                $old_image_path             = "posts/" . $post_id . "/" . $post->fullsize_photo;
                Storage::disk('public')->delete($old_image_path);
                $old_thumb_path             = "posts/" . $post_id . "/thumb/" . $post->thumb;
                Storage::disk('public')->delete($old_thumb_path);

                $destination_path   = storage_path('app/public/posts');
                if(!File::exists($destination_path)){
                    File::makeDirectory($destination_path, 0755, true);
                }
                $filesave = $file->storeAs('posts/'.$post_id,$unique_name,'public');
                if($filesave){
                    $thumb_path = storage_path('app/public/posts/'.$post_id."/thumb");
                    if(!File::exists($thumb_path)){
                        File::makeDirectory($thumb_path, 0755, true);
                    }
                    $thumb_destination = storage_path('app/public/posts/'.$post_id."/thumb/"."thumb_" .$unique_name);
                    $fullsize_path = storage_path('app/public/posts/' . $post_id . "/" . $unique_name);
                    Utility::saveFile($fullsize_path,$thumb_destination,150,150);
                }
            }
            $paramObj   = Utility::addUpdatedBy((array) $insert);
            $result     = $post->update($paramObj);
            if($result){
                $returned_array['status'] = ReturnedMessage::STATUS_OK;
            }
            else{
                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            return $returned_array;
        }
        public function deletePost(int $id){
            $returned_array = [];
            $insert         = [];
            $paramObj       = Utility::addDeletedBy((array) $insert);
            $post           = Post::find($id);
            $result         = $post->update($paramObj);
            if($result){
                $returned_array['status'] = ReturnedMessage::STATUS_OK;
            }
            else{
                $returned_array['status'] = ReturnedMessage::INTERNAL_SERVER_ERROR;
            }
            return $returned_array;
        }
    }
?>