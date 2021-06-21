<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show(int $id)
    {
        return User::find($id);
    }

    public function create(Request $request)
    {
        $validated = $this->validate($request, [
            'user_type_id' => 'required|numeric',
            'name'         => 'required|string',
            'cpf'          => 'required|string',
            'email'        => 'required|email',
            'password'     => 'required',
        ]);

        try {
            $userModel = new User();
            $userModel->user_type_id = $validated['user_type_id'];
            $userModel->name         = $validated['name'];
            $userModel->cpf          = str_replace([' ', '.', '-'], '', $validated['cpf']);
            $userModel->email        = $validated['email'];
            $userModel->password     = Hash::make($validated['password']);
            $userModel->save();

            $walletModel = Wallet::create([
                'user_id'     => $userModel->id,
                'wallet_hash' => Uuid::uuid4()->toString(),
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function update(int $id, Request $request)
    {
        try {
            $userModel = User::find($id);
            // Se não encontrar o usuario lançar excessão
            $userModel->update($request->toArray());
            $userModel->save();
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function delete(int $id)
    {
        try {
            $userModel = User::find($id);
            // Se não encontrar o usuario lançar excessão
            $userModel->delete();
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
