<?php

namespace App\Http\Controllers\Admin;

use App\SuppliesCategories;
use App\Supply;
use App\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;

class SupplyController extends Controller
{

    public function index()
    {
        $supplies = Supply::all();
        return view('admin/supplies/index', compact('supplies'));
    }

    public function create()
    {
        $categories=SuppliesCategories::orderBy('fullname')->get();
        $units=Unit::all();
        return view('admin/supplies/create', compact('categories','units'));
    }

    public function store(Request $request)
    {
        //

        $this->validate($request, [
            'name' => 'required|unique:supplies',
            'unit_id' => 'required',
            'supplies_category_id' => 'required',
            'photo' => 'required'
        ]);

        $supply = Supply::create([
            'name'=>ucfirst(strtolower(request('name'))),
            'unit_id'=>request('unit_id'),
            'supplies_category_id'=>request('supplies_category_id'),
            'ingredient' => ($request->has('ingredient') ? 1 : 0)
        ]);

        $file=$request->file('photo');
        $image_resize = Image::make($file->getRealPath());
        $image_resize->fit(300, 300)->encode('png', 50);
       /* $image_resize->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        });*/
        $image_resize->save(public_path('images/supplies_photos/' .$supply->id.'.png'));

        $image_resize->fit(50, 50)->encode('png', 50);
        $image_resize->save(public_path('images/supplies_photos/mini/' .$supply->id.'.png'));

        $request->session()->flash('status', 'Insumo '. $request->name .' creado correctamente!');

        return redirect('/admin/supplies');
    }

    public function edit(Supply $supply)
    {
        $categories=SuppliesCategories::orderBy('fullname')->get();
        $units=Unit::all();
        return view('admin/supplies/edit',compact('supply','categories','units'));
    }


    public function update(Request $request, Supply $supply)
    {
        $data = array_filter($request->all());

        if($data["name"]!=$supply->name)
        {
            $this->validate($request, [
                'name' => 'unique:supplies'
            ]);

            $data["name"]= ucfirst(strtolower($data["name"]));
        }

        $data["ingredient"] = $request->has('ingredient') ? 1 : 0;

        $supply->update($data);

        if($request->hasFile('photo'))
        {
            $file=$request->file('photo');
            $image_resize = Image::make($file->getRealPath());
            $image_resize->fit(300, 300)->encode('png', 50);


            /* $image_resize->resize(300, null, function ($constraint) {
                 $constraint->aspectRatio();
             });*/
            $image_resize->save(public_path('images/supplies_photos/' .$supply->id.'.png'));

            $image_resize->fit(50, 50)->encode('png', 50);
            $image_resize->save(public_path('images/supplies_photos/mini/' .$supply->id.'.png'));
        }

        $request->session()->flash('status', 'Insumo '.$supply->name. ' actualizado correctamente!');

        return redirect(route('admin.supplies.index'));
    }

    public function destroy(Supply $supply)
    {
        //
        session()->flash('status', 'Insumo '. $supply->name .' eliminado correctamente!');

        unlink(public_path('images/supplies_photos/' .$supply->id.'.png'));

        unlink(public_path('images/supplies_photos/mini/' .$supply->id.'.png'));

        $supply->delete();

        return redirect('/admin/supplies');
    }

    public function destroyFromParent(Supply $supply)
    {
        //
        session()->flash('status', 'Insumo '. $supply->name .' eliminado correctamente!');

        $parent = $supply->suppliesCategory->id;

        unlink(public_path('images/supplies_photos/' .$supply->id.'.png'));

        unlink(public_path('images/supplies_photos/mini/' .$supply->id.'.png'));

        $supply->delete();

        return redirect('/admin/supplies-categories/'.$parent.'/edit');
    }

    public function getAll(Request $request)
    {
        $supply_category = request('supply');
        $supply_category = SuppliesCategories::find($supply_category)->first();
        return $supply_category->supplies()->get();
    }

    public function  getUnits(Supply $supply)
    {
        return $supply->getUnits();
    }
}
