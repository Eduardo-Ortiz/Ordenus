<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\MenuCategories;
use App\Product;
use App\SuppliesCategories;
use App\Supply;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        return view('admin/products/index', compact('products'));
    }

    public function create()
    {
        $categories=MenuCategories::orderBy('fullname')->get();
        $units=Unit::all();
        $supply_categories=SuppliesCategories::orderBy('fullname')->get();
        return view('admin/products/create', compact('categories','units','supply_categories'));
    }

    public function edit(Product $product)
    {
        $categories=MenuCategories::orderBy('fullname')->get();
        $units=Unit::all();
        $supply_categories=SuppliesCategories::orderBy('fullname')->get();
        return view('admin/products/edit', compact('product','categories','units','supply_categories'));
    }


    public function store(Request $request)
    {

        $ingredients = json_decode(request('ingredients'));

        $product = Product::create([
            'name'=>request('name'),
            'description'=>request('description'),
            'menu_category_id'=>request('menu_category_id'),
            'recipe'=>request('recipe') === 'true'? true: false,
            'enabled'=>request('enabled')=== 'true'? true: false,
            'price'=>request('price'),
            'time'=>request('time'),
            'supply_id'=>request('supply_id')
        ]);

        if(!is_null($ingredients))
        {
            foreach ($ingredients as $ingredient)
            {
                $supply = Supply::find($ingredient->id);
                $product->ingredients()->attach($supply,
                    [
                        'unit_id' => $ingredient->unitId,
                        'removable' => $ingredient->removable,
                        'quantity' => $ingredient->quantity,
                        'extra' => $ingredient->extra,
                        'extra_price' => $ingredient->extraPrice,
                        'extra_quantity' => $ingredient->extraQuantity,
                        'extra_unit' => $ingredient->extraUnit,
                    ]);
            }
        }

        $file=$request->file('photo');
        $image_resize = Image::make($file->getRealPath());
        $image_resize->fit(300, 300)->encode('png', 50);
        $image_resize->save(public_path('images/products_photos/' .$product->id.'.png'));
        $image_resize->fit(50, 50)->encode('png', 50);
        $image_resize->save(public_path('images/products_photos/mini/' .$product->id.'.png'));

        session()->flash('status', 'Producto '. $product->name .' agregado correctamente al menú!');

        return redirect('/admin/products');
    }

    public function updateProduct(Request $request,Product $product)
    {



        $product->name = request('name');
        $product->description = request('description');
        $product->menu_category_id = request('menu_category_id');
        $product->enabled = request('enabled')=== 'true'? true: false;
        $product->price = request('price');
        $product->time = request('time');
        $product->supply_id = request('supply_id');


        $product->save();

        $ingredients = json_decode(request('ingredients'));

        if(!is_null($ingredients))
        {
            $product->ingredients()->sync([]);
            foreach ($ingredients as $ingredient)
            {
                $supply = Supply::find($ingredient->id);
                $product->ingredients()->attach($supply,
                    [
                        'unit_id' => $ingredient->unitId,
                        'removable' => $ingredient->removable,
                        'quantity' => $ingredient->quantity,
                        'extra' => $ingredient->extra,
                        'extra_price' => $ingredient->extraPrice,
                        'extra_quantity' => $ingredient->extraQuantity,
                        'extra_unit' => $ingredient->extraUnit,
                    ]);
            }
        }

        if($request->hasFile('photo'))
        {
            $file=$request->file('photo');
            $image_resize = Image::make($file->getRealPath());
            $image_resize->fit(300, 300)->encode('png', 50);
            $image_resize->save(public_path('images/products_photos/' .$product->id.'.png'));
            $image_resize->fit(50, 50)->encode('png', 50);
            $image_resize->save(public_path('images/products_photos/mini/' .$product->id.'.png'));
        }

    }

    public function destroy(Product $product)
    {
        session()->flash('status', 'Producto '. $product->name .' eliminado correctamente!');

        unlink(public_path('images/products_photos/' .$product->id.'.png'));

        unlink(public_path('images/products_photos/mini/' .$product->id.'.png'));

        $product->delete();

        return redirect('/admin/products');
    }

    public function destroyFromParent(Product $product)
    {



        session()->flash('status', 'Producto '. $product->name .' eliminado correctamente!');

        $parent = $product->menuCategory->id;

        unlink(public_path('images/products_photos/' .$product->id.'.png'));

        unlink(public_path('images/products_photos/mini/' .$product->id.'.png'));

        $product->delete();

        return redirect('/admin/menu-categories/'.$parent.'/edit');
    }
}
