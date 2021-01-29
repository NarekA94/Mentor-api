<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class GroupController extends Controller
{
    public function create(Request $request){
        $data = $request->all();
        $data['owner_id'] = Auth::id();
        $validator = Validator::make($data, [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response($validator->getMessageBag(),422);
        };
        $group = Group::create($data);
        if($group){
            return response($group, 200);
        }
        return response('Something went wrong', 500 );
    }

    public function edit(Request $request,$id){
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response($validator->getMessageBag(),422);
        };
        $group = Group::find($id);
        if($group){
            $group->fill($data);
            if($group->save()){
                return response($group, 200);
            }
        }
        return response('Something went wrong', 500 );
    }

    public function getUserGroup(Request $request){
        $group = Group::query()->where('owner_id',Auth::id())->with('members')->first();
        return response($group, 200);
    }
}
