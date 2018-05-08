@extends('admin.layouts.panel')


@section('content')
    <link rel="stylesheet" href="{{ URL::asset('css/icon-selector.css') }}" />

    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-select.min.css') }}" />

    <style>
        .btn-file {
            position: relative;
            overflow: hidden;
        }
        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }

        .fix-text-selection {
            display:inline-block;font-size:18px;
        }

        #img-upload{
            width: 100%;
        }

        .center-crop {
            width:  50px; /*or 70%, or what you want*/
            height: 50px; /*or 70%, or what you want*/
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .table-fix {
            padding-top: 21px !important;
        }
    </style>


    <div id="app" class="col-lg-12">
        <h1 class="page-header">Categoría de Menú: {{$menu_category->name}}</h1>

        @if(count($errors))
            <div class="alert alert-danger fade in alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Han ocurrido los siguientes errores:
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session()->has('status'))
            <div class="alert alert-success fade in alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{session('status')}}
            </div>
        @endif

        <form method="POST" action="{{route('admin.menu-categories.update',$menu_category->id)}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="PUT" />
            <div class="row">
                <div class="col-md-10">

                    <div class="row">
                        <div class="col-md-4">
                            <div  class="form-group">
                                <label for="name">Nombre de la categoría:</label>
                                <input value="{{$menu_category->name}}" id="name" name="name" class="form-control"> </input>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Imagen de la categoría: </label>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <span class="btn btn-default btn-file">
                                            Seleccionar… <input accept="image/png, image/jpeg, image/gif" name="photo" id="photo" type="file">
                                        </span>
                                    </span>
                                    <input accept="image/png, image/jpeg, image/gif" type="text" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-8 col-sm-8 col-md-8">
                            <div  class="form-group">
                                <label for="name">Pertenece a la categoría:</label>
                                <select data-size="10" id="parent_id" name="parent_id" data-live-search="true" class="selectpicker form-control">
                                    <option data-content="<img height='35px' src='{{URL::asset('/images/icons/extra/prohibited.png')}}'></img> <span class='fix-text-selection'>Sin categoría padre</span>" value="0">No Pertenece a Ninguna Categoría</option>
                                    @foreach($categories as $category)
                                        <option @if ($category->id == $menu_category->parent_id)
                                                selected="selected"
                                                @endif
                                                data-content="<img class='img-thumbnail' style='height:35px' src='{{URL::asset('/images/menu_categories_photos/mini')}}/{{$category->id}}.png'></img>  <span class='fix-text-selection'>{{$category->fullname}}</span>" value="{{$category->id}}">{{$category->fullname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div  class="form-group">
                                <label for="name">Horario:</label>
                                <select data-size="15" id="schedule_id" name="schedule_id" class="selectpicker form-control">
                                    <option value="0">Siempre Disponible</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
                    <label>Vista Previa de Imagen: </label>
                    <div style="text-align: center">
                        <img src="{{URL::asset('images/menu_categories_photos/')}}/{{$menu_category->id}}.png" class="img-thumbnail img-responsive" style=" position: relative;width: auto;max-height: 114px" id='img-upload'/>
                    </div>
                </div>
            </div>


            <div style="margin-top: 10px" class="row">
                <div class="col-md-12">
                    <div  class="form-group">
                        <label for="name">Descripcion de la categoría:</label>
                        <textarea id="description" name="description" class="form-control" rows="3">{{$menu_category->description}}</textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="pull-left">
                        <button style="margin-top: 14px" type="submit" class="btn btn-success btn-lg btn-block"><i class="fa fa-floppy-o fa-fw"></i>Agregar Categoria</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pull-right">
                        <button type="button" style="margin-top: 14px" class="btn btn-danger btn-lg btn-block" data-toggle="modal" data-target="#deleteCategoryModal"><i class="fa fa-trash fa-fw"></i> Eliminar Categoría</button>
                    </div>
                </div>
            </div>
        </form>

        <h3>Categorias Hijas</h3>
        @if(count($menu_category->childCategories()->get()))
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th style="width: 68px">Icono</th>
                    <th>Nombre</th>
                    <th>Nombre Completo</th>
                    <th style="width: 10px">Subcategorias</th>
                    <th style="width: 10px">Insumos</th>
                    <th style="width: 10px">Detalle</th>
                    <th style="width: 10px">Eliminar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($menu_category->childCategories()->get() as $category)
                    <tr>
                        <td><img class="center-crop img-thumbnail" src="{{URL::asset('/images/menu_categories_photos/mini')."/".$category->id.".png"}}" alt=""></td>
                        <td class="table-fix">{{$category->name}}</td>
                        <td class="table-fix">{{$category->fullname}}</td>
                        <td class="table-fix" style="text-align: center">{{$category->childCategories()->count()}}</td>
                        <td class="table-fix" style="text-align: center">0</td>
                        <td class="table-fix" style="text-align: center">
                            <a href="{{route('admin.menu-categories.edit', $category->id)}}" class="btn btn-default btn-xs">Ver Detalle</a>
                        </td>
                        <td class="table-fix"><button @click="askDeleteMenuCategory('{{$category->name}}',{{$category->id}})" class="btn btn-danger btn-xs">Eliminar Insumo</button></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <h4>No hay ninguna otra categoría de menú perteneciente a esta categoría. Visita la <a href="{{url('admin/menu-categories/create')}}">Pagina de Creación</a> para agregar una nueva categoría de menú.</h4>
        @endif


        <hr>

        <h3>Productos Asociados</h3>
        @if(count($menu_category->products()->get()))
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th style="width: 68px">Icono</th>
                    <th>Nombre</th>
                    <th style="width:220px">Categoría</th>
                    <th style="width: 10px">Precio</th>
                    <th style="width: 10px">Habilitado</th>
                    <th style="width: 10px">Detalle</th>
                    <th style="width: 10px">Eliminar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($menu_category->products()->get() as $product)
                    <tr>
                        <td><img class="center-crop img-thumbnail" src="{{URL::asset('/images/products_photos/mini')."/".$product->id.".png"}}" alt=""></td>
                        <td class="table-fix">{{$product->name}}</td>
                        <td style="padding-top: 18px !important"><img class="center-crop img-thumbnail" style="height: 30px;width: 30px" src='{{URL::asset('/images/menu_categories_photos/mini')}}/{{$product->menuCategory->id}}.png' alt=""> {{$product->menuCategory->fullname}} </td>
                        <td class="table-fix">${{$product->price}}</td>
                        <td class="table-fix" style="text-align: center">
                            @if($product->enabled)
                                <span style="font-size: 15px;font-weight: normal !important;" class="label label-success">Si</span>
                            @else
                                <span style="font-size: 15px;font-weight: normal !important;" class="label label-danger">No</span>
                            @endif
                        </td>
                        <td class="table-fix" style="text-align: center">
                            <a href="{{route('admin.products.edit', $product->id)}}" class="btn btn-default btn-xs">Ver Detalle</a>
                        </td>
                        <td class="table-fix"><button @click="askDeleteProduct('{{$product->name}}',{{$product->id}})" class="btn btn-danger btn-xs">Eliminar Insumo</button></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <h4>No hay ningun producto asociado a esta categoría. Visita la <a href="{{url('admin/products/create')}}">Pagina de Creación</a> para agregar un nuevo producto.</h4>
        @endif


        <!-- Modal -->
        <div id="deleteCategoryModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content bigModal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Eliminar la categoría de menú "{{$menu_category->name}}"</h4>
                    </div>
                    <div class="modal-body">
                        <h2>¿Desea eliminar la categoría de menú {{$menu_category->name}}?</h2>
                        <h4>Nota: Esta acción no podra revertirse y se eliminaran las demas categorias y productos asociados.</h4>
                    </div>

                    <div class="modal-footer">

                        <form method="POST" action="{{route('admin.menu-categories.destroy',$menu_category->id)}}">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="DELETE" />
                            <button type="button" class="btn-lg btn btn-default" data-dismiss="modal">Cancelar</button> &nbsp;&nbsp;
                            <button type="submit" class="btn-lg btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div id="deleteMenuCategoryModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content bigModal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Eliminar la categoría de menú "@{{selectionName}}"</h4>
                    </div>
                    <div class="modal-body">
                        <h2>¿Desea eliminar la categoría de menú @{{selectionName}}?</h2>
                        <h4>Nota: Esta acción no podra revertirse y se eliminaran las demas categorias y productos asociados.</h4>
                    </div>

                    <div class="modal-footer">

                        <form method="POST" v-bind:action="action">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="DELETE" />
                            <button type="button" class="btn-lg btn btn-default" data-dismiss="modal">Cancelar</button> &nbsp;&nbsp;
                            <button type="submit" class="btn-lg btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="deleteProductModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content bigModal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Eliminar el producto "@{{selectionName}}"</h4>
                    </div>
                    <div class="modal-body">
                        <h2>¿Desea eliminar el producto @{{selectionName}}?</h2>
                        <h4>Nota: Esta acción no podra revertirse</h4>
                    </div>

                    <div class="modal-footer">

                        <form method="POST" v-bind:action="action">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="DELETE" />
                            <button type="button" class="btn-lg btn btn-default" data-dismiss="modal">Cancelar</button> &nbsp;&nbsp;
                            <button type="submit" class="btn-lg btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop


@section('footer')
    <script type="text/javascript" src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>

    <script>
        $(document).ready( function() {
            $(document).on('change', '.btn-file :file', function() {
                var input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
            });

            $('.btn-file :file').on('fileselect', function(event, label) {
                var input = $(this).parents('.input-group').find(':text'),
                    log = label;

                if( input.length ) {
                    input.val(log);
                } else {
                    if( log ) alert(log);
                }
            });
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#img-upload').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#photo").change(function(){
                readURL(this);
            });
        });
    </script>

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                selectedParent : null,
                selectionName : null,
                deleteProductLink : null,
                deleteChildLink : null,
                action : null
            },
            methods: {
                askDeleteProduct: function(name,id){
                    this.selectionName = name;
                    $('#deleteProductModal').modal('show');
                    this.action = this.deleteProductLink+id;
                },
                askDeleteMenuCategory: function(name,id){
                    this.selectionName = name;
                    $('#deleteMenuCategoryModal').modal('show');
                    this.action = this.deleteChildLink+id;
                }
            },
            mounted: function(){
                this.deleteProductLink = '<?php echo route('admin.products.index')?>'+"/parent/";
                this.deleteChildLink = '<?php echo route('admin.menu-categories.index')?>'+"/parent/";
            }

        })
    </script>
@stop
