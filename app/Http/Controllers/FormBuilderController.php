<?php

namespace App\Http\Controllers;

use App\Models\FormBuilder;
use App\Models\InputField;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FormBuilderController extends Controller
{
    function index() {
        $inputs = InputField::get();
        $forms = FormBuilder::get();
        return Inertia::render('FormBuilder', ['inputs' => $inputs, 'forms' => $forms]);
    }

    function store(Request $req) {
        $form_builder = new FormBuilder();
        $form_builder->title = $req->title;
        $form_builder->method = $req->method;
        $form_builder->action = $req->action;
        $form_builder->fields = $req->fields;
        $form_builder->save();

        return response()->json(['status' => true, 'msg' => 'success', 200]);

        // return to_route('form_builder.list');
    }

    function view($id) {
        $form = FormBuilder::find($id);
        return Inertia::render('ViewForm', ['form' => $form]);
    }

    function show($id) {
        $inputs = InputField::get();
        $form = FormBuilder::findOrFail($id);
        return Inertia::render('FormBuilderEdit', ['inputs' => $inputs, 'form' => $form]);
    }

    function update(Request $req, $id) {
        $form_builder = FormBuilder::findOrFail($id);
        $form_builder->title = $req->title;
        $form_builder->method = $req->method;
        $form_builder->action = $req->action;
        $form_builder->fields = $req->fields;
        $form_builder->save();
        
        return to_route('form_builder.list');
    }

    function destroy($id) {
        FormBuilder::where('id', $id)->delete();
        return to_route('form_builder.list');
    }


}
