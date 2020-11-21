<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Http\Controllers\Controller;
use App\Models\Pichula;
use Illuminate\Http\Request;
use App\Rules\Custom_email;
use Illuminate\Support\Facades\Validator;

class PichulaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
                    'nombre' => ['required', 'string', 'max:45'],
                    'telefono' => ['required', 'numeric', 'digits:10'],
                    'correo' =>['required', 'email', 'max:45'] ,
                    'direccion' =>['required', 'max:30'],
                    'rfc' => ['required', 'max:13','unique:cliente,rfc'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Pago
     */
    protected function create(array $pichula)
    {

        $new = Pichula::create([
                'nombre' => $pichula['nombre'],
                'longitud' => $pichula['longitud'],
                'ancho' => $pichula['ancho'],
                'largoCm' => $pichula['largoCm'],
                'largoMt'=>$pichula['largoMt'],
        ]);

        return ['new' =>$new,'data'=>[],'errors' => 'Pichula capturada'];
    }

    protected function update(array $pichula)
    {
        //programen aqui
        $new = Pichula::whereId($pichula['idPichula'])
        ->update([
            'nombre' => $pichula['nombre'],
            'longitud' => $pichula['longitud'],
            'ancho' => $pichula['ancho'],
            'largoCm' => $pichula['largoCm'],
            'largoMt'=>$pichula['largoMt'],
        ]);

        return ['new' =>0,'data'=>[],'errors' => ''];
    }

    protected function delete(array $pichula)
    {

        $error = Pichula::whereId($pichula['idPichula'])->delete(); // si iban a usarlo como arreglo esto tenía que ser un arreglo
        // no se necesita más que ubicar el registro y borrarlo, no se pasa info al borrar, que clase de update creen que es esto?

        return ['new' =>$error,'data'=>[],'errors' => ''];
    }

    protected function search(array $pichula)
    {
        //regresa true si lo encontro o false si no( no es cierto, cuando regresa false? nisiquiera existía un if)
        $pichulaEncontrada = Pichula::whereId($pichula['idPichula'])->first(); //asi de fácil estaba
        //programen aqui/intento hecho uwu grazias(mal intento)

        return ['new' =>$pichulaEncontrada,'data'=>[],'errors' =>'', true ];
    }

    protected function validate($pichula)
    {
        //Checar reglas de validación de laravel
        //este estuvo muy bien, los tkm
        return Validator::make($pichula, [
            'nombre' => ['required', 'string', 'max:45'],//por si acaso uwu
            'longitud' => ['required', 'numeric', 'digits:10'],
            'ancho' =>['required', 'numeric','digits:10'],
            'largoCm' =>['required','numeric', 'digits:10'],
            'largoMt' => ['required', 'numeric','digits:10'],
            ]);
    }
}
