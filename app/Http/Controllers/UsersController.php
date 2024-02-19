<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = Users::paginate(10);
        return response()->json([
            'data' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $users = Users::create([
            'id' => $request->id,
            'username' => $request->username,
            'email'=> $request->email,
            'password'=> $request->password
            ]);
            return response()->json([
                'data'=> $users
                ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Users $users)
    {
        return response()->json([
            'data'=> $users
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Users $users)
    {
        $user->id = $request->id;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return response()->json([
            'data'=> $user
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Users $users)
    {
        $users->delete();
        return response()->json([
            'message' => 'user deleted'
            ], 204);
    }
}
