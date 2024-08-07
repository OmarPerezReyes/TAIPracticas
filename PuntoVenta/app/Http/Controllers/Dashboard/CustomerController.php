<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $row = (int) request('row', 10);

        if ($row < 1 || $row > 100) {
            abort(400, 'The per-page parameter must be an integer between 1 and 100.');
        }

        return view('customers.index', [
            'customers' => Customer::filter(request(['search']))->sortable()->paginate($row)->appends(request()->query()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Mostrar todos los datos recibidos
        // dd($request->all());
    
        // Eliminar las reglas de validación
        // $rules = [
        //     'photo' => 'image|file|max:1024',
        //     'name' => 'required|string|max:50',
        //     'email' => 'required|email|max:50|unique:customers,email',
        //     'phone' => 'required|string|max:15|unique:customers,phone',
        //     'RFC' => 'required|string|max:13|unique:customers,RFC',
        //     'razon_social' => 'required|string|max:100',
        //     'codigo_postal' => 'required|string|max:5',
        //     'regimen_fiscal' => 'required|string|max:50',
        //     'address' => 'required|string|max:100',
        // ];
    
        // Eliminar la validación de datos
        // $validatedData = $request->validate($rules);
    
        // Mostrar los datos recibidos sin validar
        $validatedData = $request->all();
        //dd($validatedData);
    
        /**
         * Manejar la carga de la imagen con Storage.
         */
        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/customers/';
    
            $file->storeAs($path, $fileName);
            $validatedData['photo'] = $fileName;
    
            // Mostrar los datos después de manejar la imagen
            dd($validatedData);
        }
    
        $customer = Customer::create($validatedData);
    
        // Mostrar el cliente creado
        //dd($customer);
    
        return Redirect::route('customers.index')->with('success', 'Customer has been created!');
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', [
            'customer' => $customer,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', [
            'customer' => $customer
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        
        $rules = [
            'photo' => 'image|file|max:1024',
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:customers,email,'.$customer->id,
            'phone' => 'required|string|max:15|unique:customers,phone,'.$customer->id,
            'RFC' => 'required|string|max:13|unique:customers,RFC,'.$customer->id,
            'razon_social' => 'required|string|max:100',
            'codigo_postal' => 'required|string|max:5',
            'regimen_fiscal' => 'required|string|max:50',
            'address' => 'required|string|max:100',
        ];

        $validatedData = $request->validate($rules);

        
        /**
         * Handle upload image with Storage.
         */
        if ($file = $request->file('photo')) {
            $fileName = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $path = 'public/customers/';

            /**
             * Delete photo if exists.
             */
            if($customer->photo){
                Storage::delete($path . $customer->photo);
            }

            $file->storeAs($path, $fileName);
            $validatedData['photo'] = $fileName;
        }

        Customer::where('id', $customer->id)->update($validatedData);

        return Redirect::route('customers.index')->with('success', 'Customer has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        /**
         * Delete photo if exists.
         */
        if($customer->photo){
            Storage::delete('public/customers/' . $customer->photo);
        }

        Customer::destroy($customer->id);

        return Redirect::route('customers.index')->with('success', 'Customer has been deleted!');
    }
}
