<?php

namespace App\Http\Controllers\Admin;

use App\MenuCategories;
use App\SuppliesCategories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;

class MenuCategoriesController extends Controller
{
    //
    public function index()
    {
        $categories=MenuCategories::orderBy('fullname')->get();
        return view('admin/menu_categories/index', compact('categories'));
    }


    public function create()
    {
        $categories=MenuCategories::orderBy('fullname')->get();
        return view('admin/menu_categories/create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:menu_categories',
            'description' => 'required',
            'photo' => 'required'
        ]);

        $fullname = ucfirst(strtolower(request('name')));

        $parent_id = null;

        if(request('parent_id')>0)
        {
            $parent_id = request('parent_id');
            $parent = MenuCategories::find(request('parent_id'));
            while(!is_null($parent))
            {
                $fullname = $parent->name . "/" . $fullname;
                $parent = MenuCategories::find($parent->parent_id);
            }
        }

        $schedule_id = null;

        if(request('schedule_id')>0)
        {

        }

        $menu_category = MenuCategories::create([
            'name'=>ucfirst(strtolower(request('name'))),
            'description'=>request('description'),
            'parent_id' => $parent_id,
            'fullname' => $fullname,
            'schedule_id' => $schedule_id
        ]);

        $file=$request->file('photo');
        $image_resize = Image::make($file->getRealPath());
        $image_resize->fit(450, 450)->encode('png', 50);
        /* $image_resize->resize(300, null, function ($constraint) {
             $constraint->aspectRatio();
         });*/
        $image_resize->save(public_path('images/menu_categories_photos/' . $menu_category->id.'.png'));

        $image_resize->fit(50, 50)->encode('png', 50);
        $image_resize->save(public_path('images/menu_categories_photos/mini/' . $menu_category->id.'.png'));

        $request->session()->flash('status', 'Caregoría de Menú'. $request->name .' creada correctamente!');

        return redirect('/admin/menu-categories');
    }


    public function edit(MenuCategories $menu_category)
    {
        $categories=MenuCategories::orderBy('fullname')->get();
        return view('admin/menu_categories/edit',compact('menu_category','categories'));
    }

    public function update(Request $request, MenuCategories $menu_category)
    {
        $data = array_filter($request->all());

        if($data["name"]!=$menu_category->name)
        {
            $this->validate($request, [
                'name' => 'unique:menu_categories'
            ]);
        }

        $data["fullname"] = ucfirst(strtolower(request('name')));



        if(request('schedule_id')>0)
        {

        }
        else
        {
            $data["schedule_id"] = null;
        }

        if(request('parent_id')>0)
        {
            $parent = MenuCategories::find(request('parent_id'));
            while(!is_null($parent))
            {
                $data["fullname"] = $parent->name . "/" . $data["fullname"];
                $parent = MenuCategories::find($parent->parent_id);
            }
        }

        else
        {
            $data["parent_id"] = null;
        }

        $previousFullname = $menu_category->fullname;

        $menu_category->update($data);

        if($data["fullname"]!= $previousFullname)
        {
            $childs = $menu_category->childCategories()->get();
            $this->updateChilds($childs,$previousFullname,$menu_category->fullname);
        }

        $request->session()->flash('status', 'Categoría '.$menu_category->name. ' actualizada correctamente!');

        return redirect(route('admin.menu-categories.index'));
    }

    public function destroy(MenuCategories $menu_category)
    {
        //
        session()->flash('status', 'Categoría de menú '. $menu_category->name .' eliminada correctamente!');

        $menu_category->delete();

        unlink(public_path('images/menu_categories_photos/' .$menu_category->id.'.png'));

        unlink(public_path('images/menu_categories_photos/mini/' .$menu_category->id.'.png'));

        return redirect('/admin/menu-categories');
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

    public function destroyFromParent(MenuCategories $menu_category)
    {
        //


        session()->flash('status', 'Categoría de Menú '. $menu_category->name .' eliminada correctamente!');

        $parent = $menu_category->parentCategory->id;

        $menu_category->delete();

        unlink(public_path('images/menu_categories_photos/' .$menu_category->id.'.png'));

        unlink(public_path('images/menu_categories_photos/mini/' .$menu_category->id.'.png'));

        return redirect('/admin/menu-categories/'.$parent.'/edit');
    }
}
