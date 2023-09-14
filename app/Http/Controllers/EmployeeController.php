<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::OrderBy('id', 'ASC')->paginate(5);
        return view('employee.list', ['employees' => $employees]);
    }

    public function create()
    {
        return view('employee.create');
    }
    public function store(Request $request)
    {
        $validator = validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'image' => 'sometimes|image:gif,png,jpeg,jpg',
        ]);
        if ($validator->passes()) {
            // save employee data
            $employee = new Employee();
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->address = $request->address;
            $employee->save();

            // Upload image 
            if ($request->image) {
                $exten = $request->image->getClientOriginalExtension();
                $newFileName = time() . '.' . $exten;
                $request->image->move(public_path() . '/uploads/employees/', $newFileName); // saving image file into the folder
                $employee->image = $newFileName;
                $employee->save();
            }
          //   $request->session()->flash('success', 'Employee added successfully');
            return redirect()->route('employees.index')->with('success', 'Employee added successfully');

        } else {
            // return with errors
            return redirect()->route('employees.create')->withErrors($validator)->withInput();
        }
    }
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employee.edit', ['employee' => $employee]);

    }

    public function update($id, Request $request)
    {
        $validator = validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'image' => 'sometimes|image:gif,png,jpeg,jpg',
        ]);
        if ($validator->passes()) {
            // save employee data
            $employee = Employee::find($id);
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->address = $request->address;
            $employee->save();

            // Upload image 
            if ($request->image) {
                $oldImage = $employee->image;
                $exten = $request->image->getClientOriginalExtension();
                $newFileName = time() . '.' . $exten;
                $request->image->move(public_path() . '/uploads/employees/', $newFileName); // saving image file into the folder
                $employee->image = $newFileName;
                $employee->save();

                file::delete(public_path() . '/uploads/employees/' . $oldImage);
            }
            return redirect()->route('employees.index')->with('success', 'Employee update successfully');

        } else {
            // return with errors
            return redirect()->route('employees.edit', $id)->withErrors($validator)->withInput();
        }

    }

    public function destroy($id, Request $request)
    {

        $employee = Employee::findOrFail($id);
        file::delete(public_path() . '/uploads/employees/' . $employee->image);
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully');

    }

}