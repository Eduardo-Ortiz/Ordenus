<?php

namespace App\Http\Controllers\Admin;

use App\Area;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AreaController extends Controller
{
    //
    public function index()
    {
        $areas = Area::whereNull('parent_id')->get();

        return view('admin/areas/index',compact('areas'));
    }

    public function create()
    {
        return view('admin/areas/create');
    }

    public function edit(Area $area)
    {


        return view('admin/areas/edit',compact('area'));
    }

    public function store(Request $request)
    {
        $area = Area::create([
            'name'=>request('name'),
            'description'=>request('description'),
            'icon_id'=>request('icon_id'),
            'multiple'=>request('multiple')=== 'true'? true: false,
            'touch'=>request('touch')=== 'true'? true: false,
            'code' =>request('code')
        ]);

        $childs = json_decode(request('childs'));

        if(sizeof($childs)>0)
        {
            if(!is_null($childs)) {
                foreach ($childs as $child) {

                    $subarea = Area::create([
                        'name'=>$child->name,
                        'description'=>request('description'),
                        'icon_id'=>request('icon_id'),
                        'multiple'=>false,
                        'touch'=>request('touch')=== 'true'? true: false,
                        'parent_id' => $area->id,
                        'code' => $child->code
                    ]);

                    $user = User::create([
                        'password'=>bcrypt($child->code),
                        'username'=>'AR|'.request('name')."-".$child->name,
                        'type'=>"AR",
                        'area_id' => $subarea->id
                    ]);
                }
            }
        }
        else
        {
            $user = User::create([
                'password'=>bcrypt(request('code')),
                'username'=>'AR|'.request('name'),
                'type'=>"AR",
                'area_id' => $area->id
            ]);
        }

        session()->flash('status', 'Area '. $area->name .' creada correctamente');

        return redirect('/admin/areas');
    }

    public function update(Request $request,Area $area)
    {
        $area = Area::create([
            'name'=>request('name'),
            'description'=>request('description'),
            'icon_id'=>request('icon_id'),
            'multiple'=>request('multiple')=== 'true'? true: false,
            'touch'=>request('touch')=== 'true'? true: false,
            'code' =>request('code')
        ]);

        $childs = json_decode(request('childs'));

        if(sizeof($childs)>0)
        {
            if(!is_null($childs)) {
                foreach ($childs as $child) {

                    $subarea = Area::create([
                        'name'=>$child->name,
                        'description'=>request('description'),
                        'icon_id'=>request('icon_id'),
                        'multiple'=>false,
                        'touch'=>request('touch')=== 'true'? true: false,
                        'parent_id' => $area->id,
                        'code' => $child->code
                    ]);

                    $user = User::create([
                        'password'=>bcrypt($child->code),
                        'username'=>request('name')."-".$child->name,
                        'type'=>"AR",
                        'area_id' => $subarea->id
                    ]);
                }
            }
        }
        else
        {
            $user = User::create([
                'password'=>bcrypt(request('code')),
                'username'=>'AR|'.request('name'),
                'type'=>"AR",
                'area_id' => $area->id
            ]);
        }

        session()->flash('status', 'Area '. $area->name .' creada correctamente');

        return redirect('/admin/areas');
    }


    public function destroy(Area $area)
    {
        session()->flash('status', 'Insumo '. $area->name .' eliminada correctamente!');

        $area->delete();

        foreach ($area->getChilds as $subarea)
        {
            $subarea->delete();
        }

        return redirect('/admin/areas');
    }
}
