<?php

namespace App\Http\Controllers;

use App\Crud;
use Illuminate\Http\Request;
use Validator;
class CrudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $crud =  Crud::all();
            return response($crud, 200);
        } catch (\Throwable $th) {
            return response($th, 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:55',
                'apellidos' => 'required|string|max:155',
                'direccion' => 'string|required',
                'telefono' => 'numeric|required|unique:cruds',
                'correo' => 'required|string|email|max:255|unique:cruds', 
            ]);	
            if ($validator->fails()) {
                $error = $validator->errors();
                return response($error, 401);
            }else{
                $crud = new Crud;
                $crud->nombre = $request->nombre;
                $crud->apellidos = $request->apellidos;
                $crud->direccion = $request->direccion;
                $crud->telefono = $request->telefono;
                $crud->correo = $request->correo;
                $crud->save();
                return response($crud, 201);
            }
        } catch (\Throwable $th) {
            return response($th, 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Crud  $crud
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $crud =  Crud::where('id',$id);
            return response($crud, 200);
        } catch (\Throwable $th) {
            return response($th, 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Crud  $crud
     * @return \Illuminate\Http\Response
     */
    public function edit(Crud $crud)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Crud  $crud
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $crud =  Crud::find($id);
            $crud->nombre = $request->nombre;
            $crud->apellidos = $request->apellidos;
            $crud->direccion = $request->direccion;
            $crud->telefono = $request->telefono;
            $crud->correo = $request->correo;
            $crud->save();
            return response($crud, 200);
        } catch (\Throwable $th) {
            return response($th, 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Crud  $crud
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $crud =  Crud::find($id);
            $crud->delete();
            return response($crud, 200);
        } catch (\Throwable $th) {
            return response($th, 401);
        }
    }
}
