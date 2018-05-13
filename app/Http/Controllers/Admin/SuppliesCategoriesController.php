<?php

namespace App\Http\Controllers\Admin;

use App\SuppliesCategories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SuppliesCategoriesController extends Controller
{
    //
    public function index()
    {
        $categories=SuppliesCategories::orderBy('fullname')->get();
        return view('admin/supplies_categories/index', compact('categories'));
    }

    public function create()
    {
        $categories=SuppliesCategories::orderBy('fullname')->get();
        return view('admin/supplies_categories/create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:supplies_categories',
            'description' => 'required',
            'icon_id' => 'required'
        ]);

        $fullname = ucfirst(strtolower(request('name')));


        $parent_id = null;

        if(request('parent_id')>0)
        {
            $parent_id = request('parent_id');
            $parent = SuppliesCategories::find(request('parent_id'));
            while(!is_null($parent))
            {
                $fullname = $parent->name . "/" . $fullname;
                $parent = SuppliesCategories::find($parent->parent_id);
            }
        }

        SuppliesCategories::create([
            'name'=>ucfirst(strtolower(request('name'))),
            'description'=>request('description'),
            'icon_id'=>request('icon_id'),
            'parent_id' => $parent_id,
            'fullname' => $fullname,
        ]);

        $request->session()->flash('status', 'Caregoría '. $request->name .' creada correctamente!');

        return redirect('/admin/supplies-categories');
    }

    public function edit(SuppliesCategories $supplies_category)
    {
        $categories=SuppliesCategories::orderBy('fullname')->get();
        return view('admin.supplies_categories.edit',compact('supplies_category','categories'));
    }

    public function update(Request $request, SuppliesCategories $supplies_category)
    {

        $data = array_filter($request->all());

        if($data["name"]!=$supplies_category->name)
        {
            $this->validate($request, [
                'name' => 'sometimes|unique:supplies_categories'
            ]);
        }

        $data["fullname"] = ucfirst(strtolower(request('name')));

        if(request('parent_id')>0)
        {
            $parent = SuppliesCategories::find(request('parent_id'));
            while(!is_null($parent))
            {
                $data["fullname"] = $parent->name . "/" . $data["fullname"];
                $parent = SuppliesCategories::find($parent->parent_id);
            }
        }
        else
        {
            $data["parent_id"] = null;
        }

        $previousFullname = $supplies_category->fullname;

        $supplies_category->update($data);

        if($data["fullname"]!= $previousFullname)
        {
            $childs = $supplies_category->childCategories()->get();
            $this->updateChilds($childs,$previousFullname,$supplies_category->fullname);
        }

        $request->session()->flash('status', 'Categoría '.$supplies_category->name. ' actualizada correctamente!');

        return redirect(route('admin.supplies-categories.index'));
    }

    public function destroy(SuppliesCategories $supplies_category)
    {
        //
        session()->flash('status', 'Categoría de insumos '. $supplies_category->name .' eliminada correctamente!');

        $supplies_category->delete();

        return redirect('/admin/supplies-categories');
    }



    public function destroyFromParent(SuppliesCategories $supplies_category)
    {
        //
        session()->flash('status', 'Categoría '. $supplies_category->name .' eliminado correctamente!');

        $parent = $supplies_category->parentCategory->id;

        $supplies_category->delete();

        return redirect('/admin/supplies-categories/'.$parent.'/edit');
    }

    private function updateChilds($childs,$previous,$new)
    {

        foreach($childs as $child)
        {
            $previousFullname = $child->fullname;
            $child->fullname=str_replace($previous,$new,$child->fullname);
            $child->save();
            if(sizeof($child->childCategories()->get()))
            {
                $this->updateChilds($child->childCategories()->get(),$previousFullname,$child->fullname);
            }
        }
    }

    public function getChilds(Request $request)
    {


        return DB::table('supplies')
            ->where('supplies_category_id', (int)request('category'))
            ->where('ingredient', request('mode'))->get();
    }

}
