<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Repositories\Post\PostRepositoryInterface;
use App\ReturnedMessage;
use App\Utility;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    private $postRepository;
    public function __construct(PostRepositoryInterface $postRepository){
        $this->postRepository = $postRepository;
        DB::enableQueryLog();
    }
    public function index(){
        try{
            $posts      = $this->postRepository->getPosts();
            $query_log  = DB::getQueryLog();
            Utility::saveDebugLog((string) "PostsController:index - \n",(array) $query_log);
            return view('backend.posts.show_posts',compact(
                ['posts']
            ));
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "PostsController:index - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function createPost(){
        try{
            return view('backend.posts.form');
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "PostsController:createPost - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function storePost(PostStoreRequest $request){
        try{
            $result     = $this->postRepository->createPost((array) $request->all());
            $query_log  = DB::getQueryLog();
            Utility::saveDebugLog((string) "PostsController:storePost - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('admin-backend/post/index')
                        ->with('success_msg','Post Created Successfully');
            }
            else{
                return redirect('admin-backend/post/index')
                        ->with('error_msg','Post Failed To Create');
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "PostsController:storePost - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function getEditPost(int $id){
        try{
            $post = $this->postRepository->getPostById((int) $id);
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "PostsController:getEditPost - \n",(array) $query_log);
            if($post == null){
                abort(404);
            }
            return view('backend.posts.form',compact(
                ['post']
            ));
        }
        catch(\Exception $e){
            if($e->getMessage() == 0){
                abort(404);
            }
            Utility::saveErrorLog((string) "PostsController:getEditPost - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function updatePost(PostUpdateRequest $request){
        try{
            $result = $this->postRepository->updatePost((array) $request->all());
            $query_log = DB::getQueryLog();
            Utility::saveDebugLog((string) "PostsController:updatePost - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('admin-backend/post/index')
                        ->with('success_msg','Post Updated Successfully');
            }
            else{
                return redirect('admin-backend/post/index')
                        ->with('error_msg','Post Failed To Update');
            }
        }
        catch(\Exception $e){
            Utility::saveErrorLog((string) "PostsController:updatePost - \n",(string) $e->getMessage());
            abort(500);
        }
    }
    public function deletePost(int $id){
        try{
            $post       = $this->postRepository->getPostById((int) $id);
            if($post == null){
                abort(404);
            }
            $result     = $this->postRepository->deletePost((int) $id);
            $query_log  = DB::getQueryLog();
            Utility::saveDebugLog((string) "PostsController:deletePost - \n",(array) $query_log);
            if($result['status'] == ReturnedMessage::STATUS_OK){
                return redirect('admin-backend/post/index')
                        ->with('success_msg','Post Deleted Successfully');
            }
            else{
                return redirect('admin-backend/post/index')
                        ->with('error_msg','Post Failed To Delete');
            }
        }
        catch(\Exception $e){
            if($e->getCode() == 0){
                abort(404);
            }
            Utility::saveErrorLog((string) "PostsController:deletePost - \n",(string) $e->getMessage());
            abort(500);
        }
    }
}
