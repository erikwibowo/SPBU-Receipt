<?php

namespace App\Http\Controllers;

use App\Models\Spbu;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpbuController extends Controller
{
    public function index()
    {
        $x['title']     = "SPBU";
        $x['data']      = Spbu::get();
        $x['dtemp']     = Template::get();
        return view('admin.spbu', $x);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required',
            'name' => 'required',
            'address' => 'required',
            'template_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('admin.spbu.index'))
            ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'number' => $request->number,
            'name' => $request->name,
            'address' => $request->address,
            'template_id' => $request->template_id,
            'created_at' => now()
        ];
        try {
            Spbu::insert($data);
            session()->flash('type', 'success');
            session()->flash('notif', 'Data berhasil ditambah');
        } catch (\Throwable $th) {
            session()->flash('type', 'error');
            session()->flash('notif', $th->getMessage());
        }
        return redirect(route('admin.spbu.index'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required',
            'name' => 'required',
            'address' => 'required',
            'template_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('admin.spbu.index'))
            ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'number' => $request->number,
            'name' => $request->name,
            'address' => $request->address,
            'template_id' => $request->template_id,
        ];
        try {
            Spbu::where(['id' => $request->id])->update($data);
            session()->flash('type', 'success');
            session()->flash('notif', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            session()->flash('type', 'error');
            session()->flash('notif', $th->getMessage());
        }
        return redirect(route('admin.spbu.index'));
    }

    public function data(Request $request)
    {
        echo json_encode(Spbu::where(['id' => $request->input('id')])->first());
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        try {
            Spbu::where(['id' => $id])->delete();
            session()->flash('notif', 'Data berhasil dihapus');
            session()->flash('type', 'success');
        } catch (\Throwable $th) {
            session()->flash('type', 'error');
            session()->flash('notif', $th->getMessage());
        }
        return redirect(route('admin.spbu.index'));
    }
}
