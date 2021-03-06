<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\UserUpdateRequest;
use App\Http\Resources\UsersResource;
use App\Traits\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use Response;

    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $user = Auth::user();
            $token = $user->createToken('auth_token', [request()->getClientIp()])->plainTextToken;
            return (new UsersResource(auth()->user()))->additional(['token' => $token]);
        } else {
            return $this->error("Invalid Email or Password.");
        }
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth()->user()->tokens()->delete();
        return $this->success(null, "Logout successfully.");
    }

    public function userDetails(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $address = $user->address;
        $data = [
            'first_name' => $user->f_name,
            'last_name' => $user->l_name,
            'profile_image' => asset('storage/UserProfile/' . $user->ProfilePicture->name),
            'profile_complete' => '95%',
            'dob' => $user->dob,
            'phone' => '+' . $user->PhoneNumber,
            'gender' => $user->gender,
            'email' => $user->email,
            'str_address' => $address->address,
            'zipcode' => $address->zipcode,
            'city' => $address->city->name ?? null,
            'state' => $address->state->name ?? null,
            'country' => $address->country->name ?? null,
        ];
        return $this->success($data);
    }

    public function userUpdate(UserUpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        (new \App\Http\Controllers\UserController)->profileUpdate($request);
        return Response()->json(['message' => 'profile data update successfully']);
    }
}
