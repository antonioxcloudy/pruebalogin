<?php 

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;

use App\Http\Resources\UserDataResource;
use App\Models\PasswordReset;
use App\Models\Permission;
use App\Models\Role;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Resources\Admin\RoleResource;


class AuthController extends Controller
{
   


  
    public function login(Request $request): JsonResponse
    {
        // $request->validate([
        //     'email' => 'required|string|email',
        //     'password' => 'required|string',
        //     'remember_me' => 'boolean'
        // ]);
        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json(['error'=>['email' => 'Email o contraeña incorrectos']], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('ProcoafAccessToken')->accessToken;
        $token = $tokenResult->token;
        
        // dd($token);

        $roles=$user->roles()->pluck('title');
        
        // $kk=RoleResource::make($pp);
        // dd($kk);
            //Añado una semana de remember me
        // if ($request->input('remember_me'))
        //     $token->expires_at = Carbon::now()->addWeeks();
        // $token->save();

            
         $ability= '{"action":"read","subject":"Auth"}';
       
     
        
        return response()->json([
            'userData' => UserDataResource::make($user),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'roles' => $roles,
            'ability' => [json_decode($ability)],
            
            
            // 'expires_at' => Carbon::parse(
            //     $tokenResult->token->expires_at
            // )->toDateTimeString()
        ]);
    }

    /**
     * Get the authenticated User
     * *
     * @param Request $request
     * @return JsonResponse [json] user object
     */
    public function user(Request $request): JsonResponse
    {
        return response()->json(UserDataResource::make($request->user()));
    }

   
    /**
     * @param Request $request
     * @return JsonResponse [string] message
     */
    // public function forgotPassword(Request $request): JsonResponse
    // {
    //     $request->validate(['email' => 'required|email']);
    //     $userEmail = $request->input('email');

    //     $user = User::where('email', $userEmail)->first();
    //     if (!$user)
    //         return response()->json([
    //             'message' => 'Мы не можем найти пользователя с таким адресом электронной почты'
    //         ], 404);

    //     $passwordReset = PasswordReset::query()->updateOrCreate(
    //         ['email' => $userEmail],
    //         [
    //             'email' => $userEmail,
    //             'token' => Str::random(60)
    //         ]);

    //     if ($passwordReset)
    //         $user->notify(new PasswordResetRequest($passwordReset->token));


    //     return response()->json([
    //         'message' => 'Мы отправили вам ссылку для сброса пароля по электронной почте!'
    //     ]);
    // }

    /**
     * @param Request $request
     * @return JsonResponse [string] message
     */
    // public function findResetPassword(Request $request): JsonResponse
    // {
    //     $token = $request->input('token');
    //     $passwordReset = PasswordReset::where('token', $token)->first();

    //     if (!$passwordReset)
    //         return response()->json(['message' => 'Этот токен сброса пароля недействителен.'], 404);


    //     if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
    //         $passwordReset->delete();
    //         return response()->json([
    //             'message' => 'Мы не можем найти пользователь с этим адресом электронной почты.'
    //         ], 404);
    //     }

    //     return response()->json([
    //         'email' => $passwordReset->email,
    //     ]);
    // }

    /**
     * @param Request $request
     * @return JsonResponse [string] message
     */
    // public function resetPassword(Request $request): JsonResponse
    // {
    //     $valid = Validator::make($request->all(), [
    //         'email' => 'required|string|email',
    //         'password' => 'required|string|confirmed',
    //         'token' => 'required|string'
    //     ]);
    //     if ($valid->fails()) return response()->json(['message' => 'Не удалось сбросить пароль'], 400);

    //     $passwordReset = PasswordReset::where([
    //         ['token', $request->input('token')],
    //         ['email', $request->input('email')]
    //     ])->first();

    //     if (!$passwordReset)
    //         return response()->json(['message' => 'Этот токен сброса пароля недействителен.'], 404);

    //     $user = User::where('email', $passwordReset->email)->first();
    //     if (!$user)
    //         return response()->json([
    //             'message' => 'Мы не можем найти пользователя с таким адресом электронной почты.'
    //         ], 404);

    //     $user->password = bcrypt($request->input('password'));
    //     $user->save();

    //     $passwordReset->delete();
    //     $user->notify(new PasswordResetSuccess());

    //     return response()->json([
    //         'message' => 'Пароль сброшен!'
    //     ]);
    // }
}
