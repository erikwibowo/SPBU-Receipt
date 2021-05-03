<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class TemplateController extends Controller
{
    public function index()
    {
        $x['title']     = "Template";
        $x['data']      = Template::get();
        return view('admin.template', $x);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required',
            'template' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('admin.template.index'))
            ->withErrors($validator)
                ->withInput();
        }

        $filenametostore = "admin_" . time() . '.' . $request->photo->extension();
        $thumbnailstore = "admin" . '_thumb_' . time() . '.' . $request->photo->extension();

        $data = [
            'name' => $request->input('name'),
            'template' => $request->input('template'),
            'photo' => $filenametostore,
            'thumb' => $thumbnailstore,
            'created_at' => now()
        ];
        if (Template::insert($data)) {
            //Upload File
            $request->photo->storeAs('public/templates', $filenametostore);
            $request->photo->storeAs('public/templates/thumbnail', $thumbnailstore);
            //create thumbnail
            $thumbnail = public_path('storage/templates/thumbnail/' . $thumbnailstore);
            $this->createThumbnail($thumbnail, 300, 185);

            session()->flash('type', 'success');
            session()->flash('notif', 'Data berhasil ditambah');
        } else {
            session()->flash('type', 'error');
            session()->flash('notif', 'Data gagal ditambah');
        }
        return redirect(route('admin.template.index'));
    }

    public function createThumbnail($path, $width, $height)
    {
        $img = Image::make($path)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'template' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('admin.template.index'))
            ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'name' => $request->input('name'),
            'template' => $request->input('template')
        ];

        if ($request->hasFile('photo')) { //Jika ada foto
            $filenametostore = "admin_" . time() . '.' . $request->photo->extension();
            $thumbnailstore = "admin" . '_thumb_' . time() . '.' . $request->photo->extension();
            $data = [
                'photo' => $filenametostore,
                'thumb' => $thumbnailstore,
            ];
            $old = Template::where(['id' => $request->id])->first();
            try {
                Template::where('id', $request->input('id'))->update($data);
                //delete old photo
                File::delete('storage/templates/' . $old->photo);
                File::delete('storage/templates/thumbnail/' . $old->thumb);
                //Upload File
                $request->photo->storeAs('public/templates', $filenametostore);
                $request->photo->storeAs('public/templates/thumbnail', $thumbnailstore);
                //create thumbnail
                $thumbnail = public_path('storage/templates/thumbnail/' . $thumbnailstore);
                $this->createThumbnail($thumbnail, 300, 185);
                session()->flash('type', 'success');
                session()->flash('notif', 'Data berhasil disimpan');
            } catch (\Throwable $th) {
                session()->flash('type', 'error');
                session()->flash('notif', $th->getMessage());
            }
        } else {
            try {
                Template::where('id', $request->input('id'))->update($data);
                session()->flash('type', 'success');
                session()->flash('notif', 'Data berhasil disimpan');
            } catch (\Throwable $th) {
                session()->flash('type', 'error');
                session()->flash('notif', $th->getMessage());
            }
        }
        return redirect(route('admin.template.index'));
    }

    public function data(Request $request)
    {
        echo json_encode(Template::where(['id' => $request->input('id')])->first());
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        $old = Template::where(['id' => $id])->first();
        try {
            Template::where(['id' => $id])->delete();
            File::delete('storage/templates/' . $old->photo);
            File::delete('storage/templates/thumbnail/' . $old->thumb);
            session()->flash('notif', 'Data berhasil dihapus');
            session()->flash('type', 'success');
        } catch (\Throwable $th) {
            session()->flash('notif', $th->getMessage());
            session()->flash('type', 'error');
        }
        return redirect(route('admin.template.index'));
    }
}
