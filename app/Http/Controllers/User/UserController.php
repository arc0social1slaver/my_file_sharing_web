<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\SysUser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = SysUser::orderBy('lastname', 'asc')->orderBy('firstname', 'asc')->orderBy('middlename', 'asc')->get();
        return view('pages/users/index', compact('users'));
    }
    public function home()
    {
        $documents = Document::getDocs(auth('my_sys')->id());
        $users = SysUser::getNorm();
        return view('pages/home', compact('documents', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = 'Add new User';
        return view('pages/users/form', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'firstname' => 'required',
            'middlename' => 'required',
            'lastname' => 'required',
            'contact' => 'required',
            'email' => 'required|unique:sys_users',
            'img' => 'image',
            'password' => 'required',
            'cpass' => 'required|same:password'
        ], [
            'firstname.required' => 'Firstname khong dc bo trong',
            'middlename.required' => 'Middlename khong dc bo trong',
            'lastname.required' => 'Lastname khong dc bo trong',
            'contact.required' => 'Contact khong dc bo trong',
            'email.required' => 'Email khong dc bo trong',
            'password.required' => 'Password khong dc bo trong',
            'cpass.required' => 'Confirm password khong dc bo trong',
            'cpass.same' => 'Mat khau khong trung khop',
            'img.image' => 'Avatar phai o dang hinh anh',
            'email.unique' => 'Email khong duoc trung',
        ]);
        $data = $request->only('firstname', 'middlename', 'lastname', 'contact', 'email');
        $data['password'] = bcrypt($request->password);
        if ($request->has('address')) {
            $data['address'] = $request['address'];
        }
        if ($request->has('img')) {
            $img  = $request->img->hashName();
            $request->img->move(public_path('assets/uploads'), $img);
            $data['avatar'] = $img;
        }
        $check = SysUser::create($data);
        if ($check) {
            return redirect()->route('users.index');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SysUser  $user
     * @return \Illuminate\Http\Response
     */
    public function show(SysUser $user)
    {
        //
        return view('pages/users/view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SysUser  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(SysUser $user)
    {
        //
        $title = 'Edit User ' . $user->email;
        return view('pages/users/form', compact('title', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SysUser  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SysUser $user)
    {
        //
        $request->validate([
            'firstname' => 'required',
            'middlename' => 'required',
            'lastname' => 'required',
            'contact' => 'required',
            'email' => 'required|unique:sys_users,email,'.$user->id,
            'img' => 'image',
            'cpass' => 'same:password'
        ], [
            'firstname.required' => 'Firstname khong dc bo trong',
            'middlename.required' => 'Middlename khong dc bo trong',
            'lastname.required' => 'Lastname khong dc bo trong',
            'contact.required' => 'Contact khong dc bo trong',
            'email.required' => 'Email khong dc bo trong',
            'cpass.same' => 'Mat khau khong trung khop',
            'img.image' => 'Avatar phai o dang hinh anh',
            'email.unique' => 'Email khong duoc trung',
        ]);
        $data = $request->only('firstname', 'middlename', 'lastname', 'contact', 'email','address','type');
        if($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }
        if($request->has('img')) {
            $img_old = public_path('assets/uploads').'/'.($user->avatar);
            if(file_exists($img_old)) {
                unlink($img_old);
            }
            $img_new = $request->img->hashName();
            $request->img->move(public_path('assets/uploads'), $img_new);
            $data['avatar'] = $img_new;
        }
        $check = $user->update($data);
        if($check) {
            return redirect()->route('users.index');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SysUser  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(SysUser $user)
    {
        //
        $img_name = $user->avatar;
        if($user->delete()) {
            $path_del = public_path('assets/uploads').'/'.$img_name;
            if(file_exists($path_del)) {
                unlink($path_del);
            }
        }
        return redirect()->route('users.index');
    }
    public function logout()
    {
        auth('my_sys')->logout();
        return redirect()->route('login');
    }
}
