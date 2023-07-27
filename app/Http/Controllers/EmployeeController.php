<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;
use DB;
use Hash;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('employees.index');
    }

    public function getEmplyees(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('employees')
            ->join('companies', 'employees.company_id', '=', 'companies.id')
            ->select('employees.*', 'companies.name as company')
            ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="employees/'.$row->id.'/edit" class="edit btn btn-success btn-sm">Edit</a> 
                    <button onclick="deleteemployee('.$row->id.')" class="delete btn btn-danger btn-sm">Delete</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $companies=Company::all();
        return view('employees.index')->with('companies' , $companies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies=Company::all();
        return view('employees.create')->with('companies' , $companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required',
            'email' =>'required|unique:employees,email',
            'password' => 'required|string|confirmed',
            'image'=>'required|mimes:jpg,png,jpeg'
        ]);
        $path = storage_path('app/public/employees');

            if($file = $request->file('image')) {
                $fileName   = time(). $request->input('name') . $file->getClientOriginalName();
                $request->image->move($path,$fileName);
                Employee::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                    'company_id' => $request->input('company_id'),
                    'image' => 'employees/' . $fileName,
                ]);
                app('App\Http\Controllers\mailController')->sendMail($request->input('name'),$request->input('email'));
            }
    
            return redirect()
                ->route('employees.index')
                ->with('success', 'Employee successfully created.');
    }


    public function edit($id)
    {
        $companies=Company::all();
        $employee=Employee::find($id);
        return view('employees.Edit')->with([
            'companies' => $companies,
            'employee' => $employee
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' =>'required',
            'email' =>'required|unique:employees,email,'.$id,
            'password' => 'required|string|confirmed',
        ]);
        $employee =Employee::find($id);
        if($request->image!=null){
            $path = storage_path('app/public/employees');
                if($file = $request->file('image')) {
                    $fileName   = time(). $request->input('name') . $file->getClientOriginalName();
                    $request->image->move($path,$fileName);
                    if (file_exists((storage_path('app/public/') . $employee->image))) {
                        $file_path = storage_path('app/public/').$employee->image;
                        
                        $test=unlink($file_path);

                    }
                    $employee->update([
                        'name' => $request->input('name'),
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'password' => Hash::make($request->input('password')),
                        'company_id' => $request->input('company_id'),
                        'image' => 'employees/' . $fileName,
                    ]);
                }
            }else{             
                $employee->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                    'company_id' => $request->input('company_id'),
                ]);
            }
            
            return redirect()->route('employees.index')
                        ->with('success','Employee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee =Employee::where('id',$id)->delete();
        return redirect()
                ->route('employees.index')
                ->with('success', 'Employee successfully Deleted.');
    }
}
