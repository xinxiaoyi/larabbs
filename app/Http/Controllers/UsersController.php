<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;

class UsersController extends Controller
{
    //用户信息展示页
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    //用户信息编辑页
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    //修改用户信息操作
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }
}
