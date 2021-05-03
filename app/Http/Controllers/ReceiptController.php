<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\Spbu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ReceiptController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Receipt::latest();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group"><button type="button" data-id="' . $row->id . '" class="btn btn-primary btn-sm btn-edit"><i class="fa fa-eye"></i></button><button type="button" data-id="' . $row->id . '" data-name="' . $row->receipt . '" class="btn btn-danger btn-sm btn-delete"><i class="fa fa-trash"></i></button></div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $x['title'] = "Data Struk";
        $x['spbu']  = Spbu::get();
        return view('admin.receipt', $x);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receipt_number' => 'required',
            'date' => 'required',
            'pump_number' => 'required',
            'product' => 'required',
            'rate' => 'required',
            'volume' => 'required',
            'price' => 'required',
            'spbu_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('admin.struk.index'))
            ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'receipt_number' => $request->receipt_number,
            'shift' => $request->shift,
            'date' => $request->date,
            'pump_number' => $request->pump_number,
            'product' => $request->product,
            'rate' => $request->rate,
            'volume' => $request->volume,
            'price' => $request->price,
            'vehicle_number' => $request->vehicle_number,
            'operator' => $request->operator,
            'spbu_id' => $request->spbu_id,
            'created_at' => now()
        ];
        try {
            Receipt::insert($data);
            session()->flash('type', 'success');
            session()->flash('notif', 'Data berhasil ditambah');
        } catch (\Throwable $th) {
            session()->flash('type', 'error');
            session()->flash('notif', $th->getMessage());
        }
        return redirect(route('admin.struk.index'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receipt_number' => 'required',
            'date' => 'required',
            'pump_number' => 'required',
            'product' => 'required',
            'rate' => 'required',
            'volume' => 'required',
            'price' => 'required',
            'spbu_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('admin.struk.index'))
            ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'receipt_number' => $request->receipt_number,
            'shift' => $request->shift,
            'date' => $request->date,
            'pump_number' => $request->pump_number,
            'product' => $request->product,
            'rate' => $request->rate,
            'volume' => $request->volume,
            'price' => $request->price,
            'vehicle_number' => $request->vehicle_number,
            'operator' => $request->operator,
            'spbu_id' => $request->spbu_id,
        ];
        try {
            Receipt::where(['id' => $request->id])->update($data);
            session()->flash('type', 'success');
            session()->flash('notif', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            session()->flash('type', 'error');
            session()->flash('notif', $th->getMessage());
        }
        return redirect(route('admin.struk.index'));
    }

    public function data(Request $request)
    {
        echo json_encode(Receipt::where(['id' => $request->input('id')])->first());
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        try {
            Receipt::where(['id' => $id])->delete();
            session()->flash('notif', 'Data berhasil dihapus');
            session()->flash('type', 'success');
        } catch (\Throwable $th) {
            session()->flash('type', 'error');
            session()->flash('notif', $th->getMessage());
        }
        return redirect(route('admin.struk.index'));
    }
}
