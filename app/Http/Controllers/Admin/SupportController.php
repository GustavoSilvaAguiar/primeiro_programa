<?php

namespace App\Http\Controllers\Admin;

use App\Models\Support;
use Illuminate\Http\Request as HttpRequest;

class SupportController {
    private $path = 'admin/supports';

    public function index(Support $support) {
        $supports = $support->all();
        return view($this->path.'/index', compact('supports'));
    }

    public function create() {
        return view($this->path.'/create');
    }

    public function store(HttpRequest $request, Support $support) {
        $data = $request->all();
        $data['status'] = 'a';

        $support->create($data);
        
        return redirect()->route('supports.index');
    }

    public function show(string|int $id) {
        if(!$support = Support::find($id)) {
            return back();
        }
        
        return view($this->path.'/show', compact('support'));
    }

    public function edit(Support $support, string|int $id) {
        if(!$support = $support->where('id', $id)->first()) {
            return back();
        }
        
        return view($this->path.'/edit', compact('support'));
    }

    public function update(HttpRequest $request, Support $support, string|int $id) {
        if(!$support = $support->find($id)){
            return back();
        }

        $support->update($request->only([
            'subject', 'body'
        ]));

        return redirect()->route('supports.index');
    }
}