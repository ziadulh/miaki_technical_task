<?php

namespace App\Http\Controllers;

use App\Models\InputField;
use App\Models\InputFieldJson;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class InputFieldController extends Controller
{
    function index(): object
    {
        $inputs = InputField::get();
        $json_inputs = InputFieldJson::get();
        return Inertia::render('InputField', ['inputs' => $inputs, 'json_inputs' => $json_inputs]);
    }

    function store(Request $req)
    {
        if (isset($req['isJson']) && $req['isJson']) {

            $field = new InputFieldJson();
            $field->json_data = $req->jsonData;
            $field->save();

        } else {
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
            $field->options = $req->options;
            $field->save();
        }


        $inputs = InputField::get();
        $json_inputs = InputFieldJson::get();
        return response()->json(['status' => true, 'msg' => 'success', 'inputs' => $inputs, 'json_inputs' => $json_inputs, 200]);
    }

    function show($type, $id)
    {
        if($type == 'input'){
            $field = InputField::findOrFail($id);
        }elseif($type == 'json_input'){
            $field = InputFieldJson::findOrFail($id);
        }
        return Inertia::render('InputFieldEdit', ['field' => $field, 'type' => $type]);
    }

    function update(Request $req, $type, $id)
    {

        if($type == 'input'){
            $field = InputField::findOrFail($id);

            $field->type = $req->type;
            $field->name = $req->name;
            $field->label = $req->label;
            $field->placeholder = $req->placeholder;
            $field->required = $req->required;
            $field->options = $req->options;
            $field->save();
        }elseif($type == 'json_input'){
            $field = InputFieldJson::findOrFail($id);
            $field->json_data = $req->jsonData;
            $field->save();
        }

        
        $json_inputs = InputFieldJson::get();
        $inputs = InputField::get();
        return response()->json(['status' => true, 'msg' => 'success', 'inputs' => $inputs, 'json_inputs' => $json_inputs, 200]);
    }

    function destroy($type, $id)
    {
        if($type == 'input'){
            InputField::where('id', $id)->delete();
        }elseif($type == 'json_input'){
            InputFieldJson::where('id', $id)->delete();
        }
        $inputs = InputField::get();
        return response()->json(['status' => true, 'msg' => 'success', 'inputs' => $inputs, 200]);
    }
}
