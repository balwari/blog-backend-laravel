<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Posts;
use App\User;

use Validator;

class Home extends Controller
{
    public function index(){
        $data = Posts::paginate(10);
        return $data;
    }

    public function paginateData(Request $request){
        if(empty($request->perPage)){  
            $default = 10; 
        }else{ 
            $default = $request->perPage; 
        }

        if(empty($request->sortBy) && empty($request->sortDesc)){
            $sort = 'id';
            $order = 'asc';
        }else{
            $sort = $request->sortBy;
            $order = $request->sortDesc;
        }

        $data = Posts::where('title', 'LIKE', $request->letter.'%')
                       ->orWhere('created_at', 'LIKE', $request->letter.'%')
                       ->orderBy($sort, $order)
                       ->paginate($default);

        return $data;
    }

    public function addPost(Request $request){
        Posts::insert($request->all());
        return "success";
    }

    public function deletePost(Request $request){
        Posts::where('id', $request->input('id'))->delete();
        return "Deleted";
    }

    public function getPost(Request $request){
        $data = Posts::where('id', $request->input('id'))->get();

        return $data;
    }

    public function updatePost(Request $request){
        $data = Posts::where('id', $request->input('id'))
                      ->update(['title'=> $request->input('title'),
                                'content'=> $request->input('content')]);
        if($data){
            return "success";
        }else{
            return "ERROR";
        }
        
    }


    public function customers(Request $request){
        $data = User::where([['name','!=', 'admin'], ['name', 'LIKE', $request->letter.'%']])->orWhere([['name','!=', 'admin'], ['email', 'LIKE', $request->letter.'%']])->paginate(10);
         return $data;
    }

    public function deleteUser(Request $request){
        $data = User::where('id', $request->id)->delete();
        if($data){
            return "success";
        }else{
            return "ERROR";
        }

    }

    public function updateUser(Request $request){
        $data = User::where('id', $request->userId)->update(['name'=> $request->name, 'email' => $request->email]);
        if($data){
            return "success";
        }else{
            return "Error";
        }
    }

    public function count(){
        $posts = Posts::count(); 
        $users = User::count();
        $blockedUsers = User::where('blocked', '1')->count();
        return response(['posts' => $posts, 'users' => $users, 'blockedUsers' => $blockedUsers]);
    }

    public function blockUser(Request $request){
        $data = User::where('id', $request->id)->update(['blocked'=>'1']);
        if($data){
            return "success";
        }else{
            return "Error";
        }
    }

    public function unblockUser(Request $request){
        $data = User::where('id', $request->id)->update(['blocked'=> '0']);
        if($data){
            return "success";
        }else{
            return "Error";
        }
    }


}