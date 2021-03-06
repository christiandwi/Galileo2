<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Pegawai;
use Illuminate\Http\Request;
use Session;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $pegawai = Pegawai::where('Nama', 'LIKE', "%$keyword%")
				->orWhere('Alamat', 'LIKE', "%$keyword%")
				->orWhere('JenisKelamin', 'LIKE', "%$keyword%")
				->orWhere('TempatLahir', 'LIKE', "%$keyword%")
				->orWhere('TglLahir', 'LIKE', "%$keyword%")
				->orWhere('NoKtp', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $pegawai = Pegawai::paginate($perPage);
        }

        return view('pegawai.index', compact('pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('pegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $requestData = $request->all();
        
        Pegawai::create($requestData);

        Session::flash('flash_message', 'Pegawai added!');

        return redirect('pegawai');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        return view('pegawai.show', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        return view('pegawai.edit', compact('pegawai'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        $requestData = $request->all();
        
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update($requestData);

        Session::flash('flash_message', 'Pegawai updated!');

        return redirect('pegawai');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Pegawai::destroy($id);

        Session::flash('flash_message', 'Pegawai deleted!');

        return redirect('pegawai');
    }
}
