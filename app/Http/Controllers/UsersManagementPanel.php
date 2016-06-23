<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UsersManagementPanel extends Controller
{

    public function DeleteUser($user_id)
    {
        DB::table('users')->where('id', '=', $user_id)->delete();
        DB::table('role_user')->where('user_id', '=', $user_id)->delete();
        return redirect()->back();
    }

    public function EditUserRole(Request $request)
    {
        if(!empty($request->roles))
        {
            $user = User::find($request->userId);
            DB::table('role_user')->where('user_id', '=', $request->userId)->delete();

            foreach($request->roles as $role)
            {
                $userRole = Role::where('role_name',$role)->first();
                if($userRole)
                {
                    $user->roles()->save($userRole);
                }
            }
        }
        return response()->json(['new_roles' => $request->roles],200);
    }


    public function JsonUserDetail($user_id)
    {
        $user = User::where('id', '=', $user_id)->first();
        $user->load('roles');
        return $user;
    }

    public function JsonAllRoles()
    {
        $roles = Role::distinct()->get(['role_name']);
        return $roles;
    }

    public function setRolesFilterSessionVariable(Request $request)
    {
        $rolesArray = array();
        if(count($request->rolesFilters)>0)
        {
            if(Session::has('rolesFilters'))
            {
                Session::forget('rolesFilters');
            }

            foreach($request->rolesFilters as $role)
            {
                array_push($rolesArray,$role);
            }
            Session::put('rolesFilters',$rolesArray);
        }

        $searchWord = $request->search;
        Session::put('searchWord',$searchWord);

        return redirect()->back();
    }

    public function ShowUsers($page_num)
    {
        $currentPage = $page_num;
        $page_num--;
        $UsersOnPage = 24;
        $roles = Role::distinct()->get(['role_name']);

        if(Session::has('rolesFilters'))
        {
            $Chosenroles = Session::get('rolesFilters');
            $ChosenrolesIds = array();

            foreach($Chosenroles as $roleName)
            {
                $role = Role::where('role_name',$roleName)->select('id')->get();
                array_push($ChosenrolesIds,$role[0]->id);
            }

            $UsersIds = DB::table('role_user')->whereIn('role_id',$ChosenrolesIds)->select('user_id')->distinct()->get();
            $UserIdsArray = array();

            foreach($UsersIds as $UserId)
            {
                array_push($UserIdsArray,$UserId->user_id);
            }

            if(Session::has('searchWord') && !empty( Session::get('searchWord')))
            {

                $UsersIdsAfterSearchWord = DB::table('users')
                ->whereIn('id',$UserIdsArray)
                ->where(function ($query) {
                        $query->where('name', 'like', '%'.Session::get('searchWord').'%')
                              ->orWhere('surname', 'like', '%'.Session::get('searchWord').'%')
                              ->orWhere('email', 'like', '%'.Session::get('searchWord').'%');
                        })
                ->select('id')
                ->get();



                $UserIdsArray = array();
                foreach($UsersIdsAfterSearchWord as $UserId)
                {
                    array_push($UserIdsArray,$UserId->id);
                }
            }


            $users = User::with('roles')->whereIn('id',$UserIdsArray)->take($UsersOnPage)->skip($page_num*$UsersOnPage)->get();
            $totalNumOfUsers = count($UserIdsArray);

        }
        else
        {
            $users = User::with('roles')->take($UsersOnPage)->skip($page_num*$UsersOnPage)->get();
            $totalNumOfUsers = User::query();
            $totalNumOfUsers = $totalNumOfUsers->count();
        }
        $totalNumOfPages = ceil($totalNumOfUsers/$UsersOnPage);

        return view('UsersManagementPanel.AllUsers',['roles'=>$roles,'users'=>$users , 'totalNumOfPages' => $totalNumOfPages, 'currentPage'=>$currentPage]);

    }

    public function AddNewUser()
    {
        $roles = Role::distinct()->get(['role_name']);
        return view('UsersManagementPanel.AddNewUserForm',['roles'=>$roles]);
    }

    public function InsertNewUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'roles'=>'required',
        ]);

        $user = new \App\User;
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        foreach($request->roles as $role)
        {
            $userRole = Role::where('role_name',$role)->first();
            if($userRole)
            {
                $user->roles()->save($userRole);
            }
        }
        $message = "Utowrzono nowego użytkownika";
        return redirect()->back()->with(['message'=>$message]);
    }
}
