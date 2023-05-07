<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\CreditManipulation;
use App\Models\Deposit;
use App\Models\Influencer;
use App\Models\Marketer;
use App\Models\Project;
use App\Models\Transfer;
use App\Models\User;
use App\Models\Withdrawal;
use Exception;
use Faker\Provider\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FinanceController extends Controller
{
    public function listAllTransactions()
    {
        return Deposit::with('Agent', 'User')->get();
    }


    public function listAllDeposits()
    {
        return Deposit::with('Agent', 'User')->get();
    }

    public function viewDeposit($id)
    {
        return Deposit::with('Agent', 'User')->where('id', $id)->first();
    }

    public function updateTransaction(Request $request, $id, $type)
    {
        $transaction = null;

        if ($type == 'deposit') {
            $transaction = Deposit::with('Agent', 'User')->where('id',$id)->first();
        } elseif ($type = 'withdrawal') {
            $transaction = Withdrawal::with('Agent', 'User')->where('id',$id)->first();
        }

        //verify agent
        if ($transaction->agent->id != Auth::user()->id) {
            return [
                'status' => false,
                'message' => 'Unauthorized action'
            ];
        }

        //verify that the transaction had not been processed
        if ($transaction->status != 'Unprocessed') {
            return [
                'status' => false,
                'message' => 'Transaction is already processed'
            ];
        }

        DB::beginTransaction();

        try {

            $response = null;

            //respond to cancellation
            if ($request['status'] == 'Canceled') {
                $transaction->status = 'Canceled';
                $transaction->save();

                $response = [
                    'status' => true,
                    'message' => 'Transaction was canceled'
                ];
            }

            //respond to rejection
            if ($request['status'] == 'Rejected') {
                $transaction->status = 'Rejected';
                $transaction->notes = $request['notes'];
                $transaction->save();

                $response = [
                    'status' => true,
                    'message' => 'Transaction was rejected'
                ];
            }


            //respond to Confirmation
            if ($request['status'] == 'Confirmed') {

                $transaction->status = 'Confirmed';
                $transaction->notes = $request['notes'];
                $transaction->save();

                if ($type == 'deposit') {
                    $creditManipulation = CreditManipulation::create([
                        'agent_id' => Auth::user()->id,
                        'manipulation_type' => 'credit_generation',
                        'manipulation_amount' => $transaction->amount,
                        'notes' => 'Made a deposit to a user.Deposit ID: ' . $transaction->id . '.',
                    ]);
                } elseif ($type = 'withdrawal') {
                    $creditManipulation = CreditManipulation::create([
                        'agent_id' => Auth::user()->id,
                        'manipulation_type' => 'credit_deletion',
                        'manipulation_amount' => $transaction->amount,
                        'notes' => 'Made a withdrawal to a user.Withdrawal ID: ' . $transaction->id . '.',
                    ]);
                }

                if ($type == 'deposit') {
                    $user = User::where('id', $transaction->user_id)->first();
                    $user->creditBalance = $user->creditBalance + $transaction->amount;
                    $user->save();
                } elseif ($type = 'withdrawal') {
                    $user = User::where('id', $transaction->user_id)->first();
                    $user->creditBalance = $user->creditBalance - $transaction->amount;
                    $user->save();
                }

                $response = [
                    'status' => true,
                    'message' => 'Transaction was confirmed'
                ];
            }

            DB::commit();

            return $response;
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }


    }


    public function listAllWithdraws()
    {
        return Withdrawal::with('Agent', 'User')->get();
    }

    public function viewWithdraw($id)
    {
        return Withdrawal::with('Agent', 'User')->where('id', $id)->first();
    }


    public function FinanceAccount()
    {
        $financialData = null;

        $user = Auth::user();
        $user = User::where('id', Auth::user()->id)->first();

        //credit balance
        $financialData['Balance']['creditBalance'] = $user->creditBalance;


        //escrow value
        if ($user->marketer) {
            $financialData['Balance']['escrowValue'] = $this->marketerEscrowValue($user);
            if ($financialData['Balance']['escrowValue'] > 0) {
                $financialData['Balance']['creditBalance'] = $user->creditBalance - $financialData['Balance']['escrowValue'];
            }
        } else if ($user->influencer) {
            $financialData['Balance']['escrowValue'] = $this->influencerEscrowValue($user);
        }


        //deposits
        $financialData['Balance']['pendingDeposits'] = $user->deposits()->where('status', 'Like', '%Unprocessed%')->sum('deposits.amount');
        $financialData['Balance']['pendingWithdrawals'] = $user->withdrawals()->where('status', 'Like', '%Unprocessed%')->sum('withdrawals.amount');
        $financialData['Balance']['transactions'] = $this->getTransactions(Auth::user()->id);

        //deposit
        $financialData['Deposit']['agents'] = $this->getAgents();

        //deposit
        $financialData['Withdrawal']['agents'] = $this->getAgents();


        return $financialData;
    }


    public function makeDeposit(Request $request)
    {
        DB::beginTransaction();

        try {
            $agent = $this->getAgent($request['agent']);

            $transaction = Deposit::create([
                'agent_id' => $agent->id,
                'user_id' => Auth::user()->id,
                'amount' => $request['amount'],
                //TODO:Verify phone number
                'phone' => '0719445697',
                'transaction_code' => $request['transactionCode'],
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }

    public function makeWithdrawal(Request $request)
    {
        DB::beginTransaction();

        $user = User::find(Auth::user()->id);

        if (!Hash::check($request['password'], $user->password)) {
            return [
                'status' => false,
                'message' => 'Unauthorised'
            ];
        }

        if (!($user->creditBalance >= $request['amount'])) {
            return [
                'status' => false,
                'message' => 'Insufficient fund to complete this transaction'
            ];
        }

        try {
            $agent = $this->getAgent($request['agent']);

            $transaction = Withdrawal::create([
                'agent_id' => $agent->id,
                'user_id' => Auth::user()->id,
                'amount' => $request['amount'],
                'phone' => $request['phone'],
                'transaction_code' => 'Unverified',
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }

        return [
            'status' => true,
            'message' => 'Request made successfully'
        ];
    }

    public function makeTransfer($from, $to, $amount, $metadata)
    {
        DB::beginTransaction();

        try {
            $transaction = Transfer::create([
                'from' => $from,
                'to' => $to,
                'amount' => $amount,
                'transaction_code' => $metadata['transaction_code'],
                'notes' => $metadata['notes'] ? $metadata['notes'] : null,
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception($e->getMessage());
        }
    }


    private function marketerEscrowValue($user)
    {
        if (count($user->marketer->projects) <= 0) {
            return 0;
        } else {
            $marketer = Marketer::where('user_id', Auth::user()->id)->first();

            $un_bid_projects_value = Project::where('marketer_id', $marketer->id)
                ->where('status', '<>', 'completed')->sum('projects.budget');

            $sum = intval($un_bid_projects_value);

            $projects = Project::where('marketer_id', $marketer->id)
                ->where('status', '<>', 'completed')->get();

            foreach ($projects as $key => $project) {
                $bid = Bid::where('project_id', $project->id)->first();

                if ($bid) {
                    $sum = $sum - intval($project->budget);
                    $sum = $sum + intval($bid->bid_amount);
                }

            }

            return $sum;

        }
    }

    private function influencerEscrowValue($user)
    {
        if (count($user->influencer->projects) <= 0) {
            return 0;
        } else {
            $influencer = Influencer::where('user_id', Auth::user()->id)->first();
            return Bid::where('influencer_id', $influencer->id)->where('status', 'assigned')->sum('bids.bid_amount');
        }
    }

    private function getAgents()
    {
        $agents = User::where('designation', 'Agent')->get();

        foreach ($agents as $agent) {
            $agent['name'] = $agent->first_name;
            $agent['username'] = $agent->first_name . ' ' . $agent->last_name;
            $agent['limit'] = array(
                'lower_limit' => 500,
                'upper_limit' => 5000,
            );
            $agent['methods'] = array(
                [
                    'name' => 'Mpesa',
                    'account' => '0700000002'
                ]
            );
            $agent['wait_time'] = [
                'unit' => 'Minutes',
                'value' => 60,
            ];
        }

        return $agents;
    }

    private function getAgent($name)
    {
        return User::where('first_name', $name)->firstOrFail();
    }

    private function getTransactions($id){
        $deposits = Deposit::where('user_id',$id)->get();
        $withdrawals = Withdrawal::where('user_id',$id)->get();
        $payments = Transfer::where('from',$id)->orWhere('to',$id)->get();
        $combined = [];

        if($deposits){
            foreach ($deposits as $deposits){
                $data = [];
                $data['type'] = 'deposits';
                $data['Agent'] = User::where('id',$deposits->agent_id)->first()->first_name;
                $data['value'] = $deposits->amount;
                $data['ref'] = 'DP-'.$deposits->id;
                $data['status'] = $deposits->status;
                $data['date'] = date('y-m-d', strtotime($deposits->created_at));
                array_push($combined,$data);
            }
        }

        if($withdrawals){
            foreach ($withdrawals as $withdrawals){
                $data = [];
                $data['type'] = 'withdrawals';
                $data['Agent'] = User::where('id',$withdrawals->agent_id)->first()->first_name;
                $data['value'] = $withdrawals->amount;
                $data['ref'] = 'WD-'.$withdrawals->id;
                $data['status'] = $withdrawals->status;
                $data['date'] = date('y-m-d', strtotime($withdrawals->created_at));
                array_push($combined,$data);
            }
        }

        if($payments){
            foreach ($payments as $payments){
                $data = [];
                $data['type'] = 'payments';
                $data['Agent'] = null;
                $data['value'] = $payments->amount;
                $data['ref'] = 'TS-'.$payments->id;
                $data['status'] = $payments->status;
                $data['date'] = date('y-m-d', strtotime($payments->created_at));
                array_push($combined,$data);
            }
        }

        return $combined;
    }
}
