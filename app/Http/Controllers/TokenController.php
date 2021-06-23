<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthException;
use App\Exceptions\CustomException;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TokenController extends Controller
{
    public function login(Request $request)
    {
        try {
            // Faz a validação dos inputs
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // Verifica se o usuario existe no banco
            $userModel = User::query()->where('email', $request->get('email'))->first();
            if (is_null($userModel)) {
                throw new AuthException();
            }

            // Valida se a senha cadastrada no banco é igual a senha passada
            if (!Hash::check($request->password, $userModel->password)) {
                throw new AuthException();
            }

            $token = JWT::encode(["email" => $request->email], env('JWT_KEY'));
            return response()->json(["access_token" => $token], 200);
        } catch (CustomException $e) {
            return response()->json($e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
