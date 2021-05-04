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
            $data = Receipt::orderBy('id', 'desc');
            return DataTables::of($data)
                ->filter(function ($query) use ($request) {
                    if (isset($request->filter)) {
                        $filter = explode(" - ", $request->filter);
                        $start = date("Y-m-d", strtotime($filter[0]));
                        $end = date("Y-m-d", strtotime($filter[1]));
                        $query->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->orderBy('id', 'desc');
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group"><button type="button" data-id="' . $row->id . '" class="btn btn-primary btn-sm btn-edit"><i class="fa fa-eye"></i></button><a target="_ blank" href="'.route('admin.struk.print', $row->id).'" type="button" data-id="' . $row->id . '" class="btn btn-warning btn-sm btn-print"><i class="fa fa-print"></i></a><button type="button" data-id="' . $row->id . '" data-name="' . $row->receipt_number . '" class="btn btn-danger btn-sm btn-delete"><i class="fa fa-trash"></i></button></div>';
                    return $btn;
                })
                ->addColumn('spbu', function($row){
                    return $row->spbu->name;
                })
                ->editColumn('date', '{{ date("d M Y H:i", strtotime($date)) }}')
                ->rawColumns(['action', 'spbu'])
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
        $data = Receipt::where(['id' => $request->input('id')])->first();
        $a['id']                = $data->id;
        $a['receipt_number']    = $data->receipt_number;
        $a['date']              = date('Y-m-d\TH:i', strtotime($data->date));
        $a['shift']             = $data->shift;
        $a['pump_number']       = $data->pump_number;
        $a['product']           = $data->product;
        $a['rate']              = $data->rate;
        $a['volume']            = $data->volume;
        $a['price']             = $data->price;
        $a['vehicle_number']    = $data->vehicle_number;
        $a['operator']          = $data->operator;
        $a['spbu_id']           = $data->spbu_id;
        echo json_encode($a);
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

    public function print(Request $request, $id)
    {
        $data = Receipt::where(['id' => $id])->first();
        $x['data']  = $data;
        return view('admin.receipt.'.$data->spbu->template_id, $x);
    }

    public function printAll(Request $request)
    {
        $data = Receipt::get();
        $x['data']  = $data;
        return view('admin.receipt.all', $x);
    }
}
