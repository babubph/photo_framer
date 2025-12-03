<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function LoginPage(){
        return view('admin.login');
      }

    // Attempt Login Process ---->
    public function LoginProcess(LoginRequest $request){
        if (Auth::attempt([
            'email'    => $request->validated('email'),
            'password' => $request->password,
            'status'   => 1,
            ])) {

            // Find User ID via user email
        $email=$request->email;
        $user=User::query()->where('email', 'LIKE', "%{$email}%")->get();

            return redirect()->route('dashboard')
            ->with('massage', 'Logged in successfully!');

        }else{
            return redirect()->route('login')
            ->with('massage', 'Invalid users | Access Denied')
            ->with('msg_type', 'danger');
        }
    }

    public function Dashboard(){
        return view('admin.dashboard');
      }

       // User Logout ---->
    public function LogOut(){
        auth()->logout();
        return redirect()->route('login')
        ->with('massage', 'Logout Successfully')
        ->with('msg_type', 'success');
      }

      public function getAllUsers() {
        $data['user']= User::all();
        return view('admin.users.all_users', $data);
      }

      // New User Form ---->
    public function NewUsers_form(){
        return view('admin.users.new_users');
    }

       // Create A new User ---->
   public function InsertUser(Request $request){
    //---Validation
    $rules = [
      'name' => 'required',
      'email' => 'required|email|unique:users,email',
      'contact' => 'required|max:13|min:6|unique:users,contact',
      'password' => 'min:6|required_with:confirm_password|same:confirm_password',
      'confirm_password' => 'min:6'
       ];

       $messages = [
         'required'  => 'The :attribute field is required.',
         'unique'    => ':attribute is already used',
         'max'    => ':attribute is maximum 13 character',
         'min'    => ':attribute is minimum 8 character',
       ];
       $request->validate($rules,$messages);
        //---End validation--

      $data=[
        'name' => trim($request->input('name')),
        'email' => strtolower(trim($request->input('email'))),
        'contact' => $request->input('contact'),
        'user_type' => $request->input('user_type'),
        'password' => bcrypt($request->input('password')),
        'status' => $request->input('status') == 1 ? '1' : '0',
      ];


      try {
       $user = User:: create($data);
        return redirect()->route('new-users')
        ->with('massage', 'User Account Created')
        ->with('msg_type', 'success');
      } catch(Exception $e){
        $this->setErrorMsg($e->getMessage());
        return redirect()->back();
      }
    }

    public function DeleteUser($id){
        $user = User::find($id);
        $user->delete();
   
        return redirect()->route('all-users')
        ->with('massage', 'User Delete Successfully')
        ->with('msg_type', 'error');
      }

      public function EditUser($id){
       $data['user']= User::find($id);
       return view('admin.users.edit_users',$data);
     }


      public function UpdateUser($id, Request $request){
       try {
         $user = User:: find($id);
         $user->update([
           'name' => trim($request->input('name')),
           'email' => strtolower(trim($request->input('email'))),
           'contact' => $request->input('contact'),
           'user_type' => $request->input('user_type'),
         ]);

         return redirect()->route('edit-user',$id)
         ->with('massage', 'User Account Updated')
         ->with('msg_type', 'success');
       } catch(Exception $e){
         $this->setErrorMsg($e->getMessage());
         return redirect()->back();
       }

     }

       // Password Change Form ---->
    public function PasswordChange($id){
      $data['user'] = User:: find($id);
      return view('admin.users.password_change',$data);
    }

    // Update Password ---->
    public function UpdatePassword($id, Request $request)
    {
       //---Validation
    $rules = [
        'password' => 'min:6|required_with:confirm_password|same:confirm_password',
        'confirm_password' => 'min:6'
         ];
  
         $messages = [
           'required'  => 'The :attribute field is required.',
           'unique'    => ':attribute is already used',
           'max'    => ':attribute is maximum 13 character',
           'min'    => ':attribute is minimum 8 character',
         ];
         $request->validate($rules,$messages);
          //---End validation--
  

      try {
        $user = User:: find($id);
        $user->update([
          'password' => bcrypt($request->input('password')),
        ]);
        return redirect()->route('password-change',$id)
        ->with('massage', 'Password Updated')
        ->with('msg_type', 'success');
      } catch(Exception $e){
        $this->setErrorMsg($e->getMessage());
        return redirect()->back();
      }

    }

    // Passwor Change Form ---->
     public function UserProfile($id){
       $data['user'] = User:: find($id);
       return view('admin.users.user_profile',$data);
     }

     //User Active ---->
    public function UserActive($id, Request $request){
        $user = User:: find($id);
        $user->update([
          'status' => 1,
        ]);
        return redirect()->route('all-users')
        ->with('massage', 'User Activated')
        ->with('msg_type', 'success');
      }
  
     //User Inactive ---->
      public function UserInActive($id, Request $request)
      {
        $user = User:: find($id);
        $user->update([
          'status' => 0,
        ]);
        return redirect()->route('all-users')
        ->with('massage', 'User Inactivated')
        ->with('msg_type', 'error');
      }
  
}
