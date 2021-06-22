<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Services\ExternalAuthorizerService;
use App\Services\TransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function transaction(Request $request)
    {
        $this->validate($request, [
            'amount'            => 'required|numeric|gt:0',
            'payer_wallet_hash' => 'required|uuid',
            'payee_wallet_hash' => 'required|uuid'
        ]);

        try {
            DB::beginTransaction();

            $amount          = $request->get('amount');
            $walletPayerHash = $request->get('payer_wallet_hash');
            $walletPayeeHash = $request->get('payee_wallet_hash');

            $authorizorService  = new ExternalAuthorizerService();
            $transactionService = new TransferService($amount, $walletPayerHash, $walletPayeeHash, $authorizorService);
            $transactionService->transfer();

            DB::commit();
            return response()->json("Transferência criada com sucesso", 201);
        } catch (CustomException $e) {
            DB::rollback();
            return response()->json($e->getMessage(), $e->getCode());
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return response()->json("O servidor respondeu com um erro inesperado.", 500);
        }
    }
}
