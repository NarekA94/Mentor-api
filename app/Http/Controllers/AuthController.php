<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;

class AuthController extends Controller
{
    public function signIn(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response($validator->getMessageBag(),422);
        };

        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials)){
            $token = Auth::user()->createToken('notes-api');
            return response(Auth::user(), 200)->withHeaders(['Authorization' => $token->plainTextToken]);
        }
        return response('invalid email or password', 401 );
    }

    public function signUp(Request $request){
        $data = $request->except('avatar');
        $validator = Validator::make($data, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'repeat_password' => 'required|same:password',
            'gender' => 'required'
        ]);

        if ($validator->fails()) {
            return response($validator->getMessageBag(),422);
        };
        $data = $request->all();
        if($request->has('avatar') && $request->input('avatar')){
            $file = $request->input('avatar');
            $fileName = uniqid('user').uniqid().'.jpg';
            $image = Image::make($file)->resize(500, 500)->encode('jpg',100);
            Storage::disk('public')->put( "/images/users/$fileName",$image);
            $data['avatar'] = '/storage/images/users'.$fileName;
        }
        try{
           $user = User::create($data);
           Auth::loginUsingId($user->id);
           $token = $user->createToken('notes-api');
           $groupData = [
               'owner_id' => $user->id,
               'name' => $data['group_name']
           ];
           $group = Group::create($groupData);
           GroupMember::create([
            'group_id' => $group->id,
            'user_id' => $user->id
        ]);
           foreach($data['group_members'] as $groupMember){
               GroupMember::create([
                   'group_id' => $group->id,
                   'user_id' => $groupMember
               ]);
           }
           return response(Auth::user(), 200)->withHeaders(['Authorization' => $token->plainTextToken]);
        }catch(Exception $ex){
            dd($ex->getMessage());
        }

    }

    public function refreshToken(){
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        $token = $user->createToken('notes-api');
        return response(true, 200)->header('Authorization', $token->plainTextToken);
    }

    public function signOut(){
        if(Auth::user()->currentAccessToken()->delete()){
            return response(true, 200);
        }
        return  response(false, 500);
    }
}
