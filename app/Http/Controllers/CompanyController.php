<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('companies.index');
    }

    public function getCompanies(Request $request)
    {
        if ($request->ajax()) {
            $data = Company::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="companies/'.$row->id.'/edit" class="edit btn btn-success btn-sm">Edit</a> 
                    <button onclick="deletecompany('.$row->id.')" class="delete btn btn-danger btn-sm">Delete</button>';
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
    public function create()
    {
        return view('companies.create');
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
            'name' =>'required|unique:companies,name',
            'address' =>'required',
            'image'=>'required|mimes:jpg,png,jpeg'
        ]);
        $path = storage_path('app/public/companies');

            if($file = $request->file('image')) {
                $fileName   = time(). $request->input('name') . $file->getClientOriginalName();
                $request->image->move($path,$fileName);
                Company::create([
                    'name' => $request->input('name'),
                    'address' => $request->input('address'),
                    'logo' => 'companies/' . $fileName,
                ]);
            }
    
            return redirect()
                ->back()
                ->with('success', 'Company successfully created.');
        
    }

    
    public function edit($id)
    {
        $company=Company::find($id);
        return view('companies.edit')->with('company' , $company);
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
            'name'=>'required|unique:companies,name,'.$id,
            'address'=>'required',
        ]);
        $company =Company::find($id);
        if($request->image!=null){
            $path = storage_path('app/public/companies');
                if($file = $request->file('image')) {
                    $fileName   = time(). $request->input('name') . $file->getClientOriginalName();
                    $request->image->move($path,$fileName);
                    if (file_exists((storage_path('app/public/') . $company->logo))) {
                        $file_path = storage_path('app/public/').$company->logo;
                        
                        $test=unlink($file_path);

                    }
                    $company->update([
                        'name' => $request->input('name'),
                        'address' => $request->input('address'),
                        'logo' => 'companies/' . $fileName,
                    ]);
                }
            }else{             
                $company->update([
                    'name' => $request->input('name'),
                    'address' => $request->input('address'),
                ]);
            }
            
            return redirect()->route('companies.index')
                        ->with('success','Companies updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company =Company::where('id',$id)->delete();
        return redirect('/companies');
    }
}
