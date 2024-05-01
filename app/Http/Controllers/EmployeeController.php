<?php

namespace App\Http\Controllers;

use App\Mail\ValidateEmployee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function searchbyEmployee(Request $request)
{
    // Get the search query from the request
    $searchQuery = $request->input('query');

    // Get the sorting criteria from the request
    $sortBy = $request->input('sortBy', 'name');

    // Define the default order direction
    $sortOrder = $request->input('sortOrder', 'asc');

    // Query companies and users based on the search query


    $users = User::where('name', 'like', "%$searchQuery%")
                 ->where('role_id','=',2)
                 ->orderBy($sortBy, $sortOrder)
                 ->get();

    // Return the results as a JSON response
    return response()->json([

        'users' => $users
    ]);
}




public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 400);
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role_id' =>2 ,
    ]);



    //    // Générer l'URL de validation
    //    $verificationUrl = URL::signedRoute('user.verify', ['user' => $user]);

    //    // Envoyer l'e-mail de validation
    //    Mail::to($user->email)->send(new ValidateEmployee($user, $verificationUrl));


    return response()->json(['message' => 'Utilisateur créé avec succès', 'user' => $user], 201);
}

}
