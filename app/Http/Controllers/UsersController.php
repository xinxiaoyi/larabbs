<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    //用户信息展示页
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    //用户信息编辑页
    public function edit(User $user)
    {
    	$this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    //修改用户信息操作
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
    	$this->authorize('update', $user);
    	$data = $request->all();
    	if($request->avatar){
    		$result = $uploader->save($request->avatar, 'avatars',$user->id, 362);
    		if($result){
    			$data['avatar'] = $result['path'];
    		}
    	}
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
