<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use RealRashid\SweetAlert\Facades\Alert; // if you're using SweetAlert package

class PaymentController extends Controller
{
    public function list()
    {
        $payments = Payment::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.payment.list', compact('payments'));
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);

        Payment::create([
            'account_number' => $request->account_number,
            'account_name'   => $request->account_name,
            'type'           => $request->type,
            'note'           => $request->note,
        ]);

        Alert::success('Success', 'Payment account added.');
        return redirect()->route('payment#list');
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        return view('admin.payment.edit', compact('payment'));
    }

    public function update(Request $request, $id)
    {
        $this->validateRequest($request, $id);

        Payment::where('id', $id)->update([
            'account_number' => $request->account_number,
            'account_name'   => $request->account_name,
            'type'           => $request->type,
            'note'           => $request->note,
        ]);
        // dd($request->all());
        Alert::success('Success', 'Payment account updated.');
        return redirect()->route('payment#list');
    }

    public function delete($id)
    {
        Payment::where('id', $id)->delete();
        Alert::success('Deleted', 'Payment account deleted.');
        return back();
    }

    private function validateRequest(Request $request, $id = null)
    {
        // account_number unique rule: ignore current id on update
        // $uniqueRule = 'unique:payments,account_number';
        // if ($id) {
        //     $uniqueRule .= ',' . $id;
        // }

        $request->validate([
            // 'account_number' => ['required', 'string', 'max:50', $uniqueRule],
            'account_number' => ['required', 'string', 'max:50'],
            'account_name'   => 'required|string|max:255',
            'type'           => 'required|string|max:100',
            'note'           => 'nullable|string|max:1000',
        ], [
            'account_number.required' => 'Account number is required.',
            'account_name.required'   => 'Account name is required.',
            'type.required'           => 'Type is required.',
        ]);
    }
}
