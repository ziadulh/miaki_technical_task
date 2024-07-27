<?php

namespace App\Http\Controllers;

use App\Models\InputField;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class InputFieldController extends Controller
{
    function index() : object {
        $inputs = InputField::get();
        return Inertia::render('InputField', ['inputs' => $inputs]);
    }

    function store(Request $req) {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:50',
            'label' => 'required|string|max:50',
            'placeholder' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $field = new InputField();
        
        $field->type = $req->type;
        $field->name = $req->name;
        $field->label = $req->label;
        $field->placeholder = $req->placeholder;
        $field->required = $req->required;
        $field->save();

        $inputs = InputField::get();
        return response()->json(['status' => true, 'msg' => 'success', 'inputs' => $inputs, 200]);
    }

    function show($id) {
        $field = InputField::findOrFail($id);
        return Inertia::render('InputFieldEdit', ['field' => $field]);
    }

    function update(Request $req, $id) {

        $field = InputField::findOrFail($id);

        $field->type = $req->type;
        $field->name = $req->name;
        $field->label = $req->label;
        $field->placeholder = $req->placeholder;
        $field->required = $req->required;
        $field->save();

        $inputs = InputField::get();
        return response()->json(['status' => true, 'msg' => 'success', 'inputs' => $inputs, 200]);
    }

    function destroy($id) {
        InputField::where('id', $id)->delete();
        $inputs = InputField::get();
        return response()->json(['status' => true, 'msg' => 'success', 'inputs' => $inputs, 200]);
    }
}
