<?php

namespace App\Http\Controllers\Admin;

use App\Devices;
use App\Table;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TablesController extends Controller
{
    //


    public function index()
    {
        $tables = Table::all();
        return view('admin/tables/index', compact('tables'));
    }


    public function create()
    {
        return view('admin/tables/create');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:tables',
        ]);

        $table = Table::create([
            'name' => request('name'),
            'enabled' => ($request->has('enabled') ? 1 : 0),
        ]);

        session()->flash('status', 'Mesa '. $table->name .' creada correctamente');

        return redirect('/admin/tables');
    }

    public function unassigned()
    {
        return Table::where('assigned','=',false)->get();
    }

    public function assign(Request $request)
    {
        $device = Devices::create([
            'table_id'=>request('table_id')
        ]);

        $table = Table::find(request('table_id'));
        $table->assigned = true;
        $table->save();

        return $device->id;
    }
}
