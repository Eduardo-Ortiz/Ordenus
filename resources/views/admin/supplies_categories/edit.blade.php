@extends('admin.layouts.panel')


@section('content')
    <link rel="stylesheet" href="{{ URL::asset('css/icon-selector.css') }}" />

    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-select.min.css') }}" />



    <style>
        .disabled-font {
            color: #999 !important;
        }

        .disabled-font > img {
            -webkit-filter: grayscale(100%); /* Safari 6.0 - 9.0 */
            filter: grayscale(100%);
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
        <h1 class="page-header">Categoría de Insumos: {{$supplies_category->name}}</h1>

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

        <form method="POST" action="{{route('admin.supplies-categories.update',$supplies_category->id)}}">
            {{csrf_field()}}
            <input type="hidden" name="_method" value="PUT" />
            <div class="row">
                <div class="col-md-4">
                    <div  class="form-group">
                        <label for="name">Nombre de la categoría:</label>
                        <input value="{{$supplies_category->name}}" id="name" name="name" class="form-control"> </input>
                    </div>
                </div>
                <div class="col-md-8">
                    <div  class="form-group">
                        <label for="name">Pertenece a la categoría:</label>
                        <select data-size="15" id="parent_id" name="parent_id" data-live-search="true" class="selectpicker form-control">
                            <option data-content="<img height='20px' src='{{URL::asset('/images/icons/extra/prohibited.png')}}'></img> <span>Sin categoría padre</span>" value="0">No Pertenece a Ninguna Categoría</option>

                            @foreach($categories as $category)
                                <option @if ($category->id == $supplies_category->parent_id)
                                        selected="selected"
                                        @endif
                                        @if(preg_match("/^".preg_quote($supplies_category->fullname, '/')."/i",$category->fullname))
                                                disabled class='disabled-font'
                                        @endif
                                        data-content="<img height='20px' src='{{URL::asset('/images/icons/mini')}}/{{$category->icon_id}}.png'></img> <span>{{$category->fullname}}</span>" value="{{$category->id}}">{{$category->fullname}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9">
                    <div  class="form-group">
                        <label for="name">Descripcion de la categoría:</label>
                        <textarea id="description" name="description" class="form-control" rows="3">{{$supplies_category->description}}</textarea>
                    </div>
                </div>

                <div class="col-md-3">
                    <div  class="form-group">
                        <label style="font-size: 16px !important;margin-top: 3px !important;" for="name">Icono de la categoría:</label><br>

                        <button v-if="selectedIcon==0" v-on:click="openCatalog()" style="height: 78px;width: 100%;" type="button" class="btn-lg btn btn-default" data-dismiss="modal">
                            Seleccionar Icono
                        </button>

                        <button v-else v-on:click="openCatalog()" style="height: 78px;width: 100%;" type="button" class="btn-lg btn btn-default">
                            <img style="margin-top: -7px" height="70" v-bind:src="fullImageLink+'/'+selectedIcon+'.png'" alt="">
                        </button>
                        <input type="hidden" name="icon_id" value="{{$supplies_category->icon_id}}" id="icon_id">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="pull-left">
                        <button style="margin-top: 14px" type="submit" class="btn btn-success btn-lg btn-block"><i class="fa fa-floppy-o fa-fw"></i>Guardar Cambios</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pull-right">
                        <button type="button" style="margin-top: 14px" class="btn btn-danger btn-lg btn-block" data-toggle="modal" data-target="#deleteCategoryModal"><i class="fa fa-trash fa-fw"></i> Eliminar Categoría</button>
                    </div>
                </div>
            </div>
        </form>

        <hr>

        <h3>Categorias Hijas</h3>
        @if(count($supplies_category->childCategories()->get()))
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th style="width: 10px">Icono</th>
                    <th>Nombre</th>
                    <th>Nombre Completo</th>
                    <th style="width: 10px">Subcategorias</th>
                    <th style="width: 10px">Insumos</th>
                    <th style="width: 10px">Detalle</th>
                    <th style="width: 10px">Eliminar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($supplies_category->childCategories()->get() as $category)
                    <tr>
                        <td style="text-align: center"><img height="25px" src="{{URL::asset('/images/icons/mini')."/".$category->icon_id.".png"}}" alt=""></td>
                        <td>{{$category->name}}</td>
                        <td>{{$category->fullname}}</td>
                        <td style="text-align: center">{{$category->getChildsNumber()}}</td>
                        <td style="text-align: center">{{$category->getChildsNumber()}}</td>
                        <td style="text-align: center">
                            <a href="{{route('admin.supplies-categories.edit', $category->id)}}" class="btn btn-default btn-xs">Ver Detalle</a>
                        </td>
                        <td><button @click="askDeleteSupplyCategory('{{$category->name}}',{{$category->id}})" class="btn btn-danger btn-xs">Eliminar Categoría</button></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <h4>No hay ninguna otra categoría perteneciente a esta categoría. Visita la <a href="{{url('admin/supplies-categories/create')}}">Pagina de Creación</a> para agregar una nueva categoría.</h4>
        @endif


        <hr>


        <h3>Insumos Pertenecientes</h3>
        @if(count($supplies_category->supplies()->get()))
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th style="width: 68px">Icono</th>
                    <th>Nombre</th>
                    <th style="width: 1px">Categoría</th>
                    <th style="width: 10px">Unidad</th>
                    <th style="width: 10px">Detalle</th>
                    <th style="width: 10px">Eliminar</th>
                </tr>
                </thead>
                <tbody>
                @foreach($supplies_category->supplies()->get() as $supply)
                    <tr>
                        <td><img class="center-crop img-thumbnail" src="{{URL::asset('/images/supplies_photos/mini')."/".$supply->id.".png"}}" alt=""></td>
                        <td class="table-fix">{{$supply->name}}</td>
                        <td style="white-space:nowrap; !important" class="table-fix"><img style="height: 15px;width: 15px" src='{{URL::asset('/images/icons/mini')}}/{{$supply->suppliesCategory->icon_id}}.png' alt="">  {{$supply->suppliesCategory->fullname}}</td>
                        <td class="table-fix">{{$supply->unit->name}}&nbsp;({{$supply->unit->abreviation}})</td>
                        <td class="table-fix" style="text-align: center">
                            <a href="{{route('admin.supplies.edit', $supply->id)}}" class="btn btn-default btn-xs">Ver Detalle</a>
                        </td>
                        <td class="table-fix"><button @click="askDeleteSupply('{{$supply->name}}',{{$supply->id}})" class="btn btn-danger btn-xs">Eliminar Insumo</button></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <h4>No hay ningun insumo perteneciente a esta categoría. Visita la <a href="{{url('admin/supplies/create')}}">Pagina de Creación</a> para agregar un nuevo insumo.</h4>
        @endif

        <div id="iconsCatalogModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content bigModal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4  class="modal-title">Catalogo de Iconos</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="height: 290px">
                            <div class="col-md-2 col-xs-3" style="height: 100%;border-right: 2px solid #e5e5e5;padding: 0">
                                <div v-on:click="changeFilterMode('')" v-bind:class="{'menu-selected': filterMode=='', 'menu': filterMode!='' }">
                                    Todos <i style="font-size: 17px" class="fa fa-arrow-circle-right fa-fw"></i>
                                </div>
                                <div v-on:click="changeFilterMode('basicos')" v-bind:class="{'menu-selected': filterMode=='basicos', 'menu': filterMode!='basicos' }">
                                    Basicos <i style="font-size: 17px" class="fa fa-arrow-circle-right fa-fw"></i>
                                </div>
                                <div v-on:click="changeFilterMode('fruteria')" v-bind:class="{'menu-selected': filterMode=='fruteria', 'menu': filterMode!='fruteria' }">
                                    Fruteria<i style="font-size: 17px" class="fa fa-arrow-circle-right fa-fw"></i>
                                </div>
                                <div v-on:click="changeFilterMode('proteinas')" v-bind:class="{'menu-selected': filterMode=='proteinas', 'menu': filterMode!='proteinas' }">
                                    Proteinas <i style="font-size: 17px" class="fa fa-arrow-circle-right fa-fw"></i>
                                </div>
                                <div v-on:click="changeFilterMode('bebidas')" v-bind:class="{'menu-selected': filterMode=='bebidas', 'menu': filterMode!='bebidas' }">
                                    Bebidas <i style="font-size: 17px" class="fa fa-arrow-circle-right fa-fw"></i>
                                </div>
                                <div v-on:click="changeFilterMode('postres')" v-bind:class="{'menu-selected': filterMode=='postres', 'menu': filterMode!='postres' }">
                                    Postres <i style="font-size: 17px" class="fa fa-arrow-circle-right fa-fw"></i>
                                </div>
                                <div v-on:click="changeFilterMode('utensilios')" v-bind:class="{'menu-selected': filterMode=='utensilios', 'menu': filterMode!='utensilios' }">
                                    Utensilios<i style="font-size: 17px" class="fa fa-arrow-circle-right fa-fw"></i>
                                </div>
                                <div v-on:click="changeFilterMode('otros')" v-bind:class="{'menu-selected': filterMode=='otros', 'menu': filterMode!='otros' }">
                                    Otros <i style="font-size: 17px" class="fa fa-arrow-circle-right fa-fw"></i>
                                </div>
                            </div>
                            <div class="col-md-10 col-xs-9" style="padding: 0">
                                <div style="margin-top: 15px;margin-left: 20px;margin-right: 20px" class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-search fa-fw"></i></span>
                                    <input autocomplete="off"  v-model="filterText" v-on:keyup="filter(filterText)" style="font-size: 18px;font-weight: normal !important;"  id="email" type="text" class="form-control search-icon" name="email" placeholder="Buscar Icono...">
                                </div>
                                <div class="icon-container">
                                    <div v-on:click="selectIcon(icon.id)" v-for="icon in icons" class="col-md-1 col-xs-2 icon-button">
                                        <img v-bind:src="imageLink+'/'+icon.id+'.png'" alt="Smiley face" height="45" width="45"><br>
                                        <span style="font-size: 12px">@{{icon.name}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div id="deleteCategoryModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content bigModal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Eliminar la categoría de insumos "{{$supplies_category->name}}"</h4>
                    </div>
                    <div class="modal-body">
                        <h2>¿Desea eliminar la categoría de insumos {{$supplies_category->name}}?</h2>
                        <h4>Nota: Esta acción no podra revertirse y se eliminaran todas las categorias e insumos asociados</h4>
                    </div>

                    <div class="modal-footer">

                        <form method="POST" action="{{route('admin.supplies-categories.destroy',$supplies_category->id)}}">
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
        <div id="deleteSupplyModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content bigModal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Eliminar el insumo "@{{selectionName}}"</h4>
                    </div>
                    <div class="modal-body">
                        <h2>¿Desea eliminar el insumo @{{selectionName}}?</h2>
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

        <!-- Modal -->
        <div id="deleteSupplyCategoryModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content bigModal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Eliminar la categoría de insumos "@{{selectionName}}"</h4>
                    </div>
                    <div class="modal-body">
                        <h2>¿Desea eliminar la categoría de insumos @{{selectionName}}?</h2>
                        <h4>Nota: Esta acción no podra revertirse y se eliminaran todas las categorias e insumos asociados</h4>
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
        var app = new Vue({
            el: '#app',
            data: {
                allIcons : [],
                icons : [],
                imageLink : null,
                fullImagelLink : null,
                filterMode : "",
                filterText : "",
                selectedIcon : 0,
                selectedParent : null,
                selectionName : null,
                deleteSupplyLink : null,
                deleteChildLink : null,
                action : null
            },
            methods: {
                openCatalog : function (){
                    $('#iconsCatalogModal').modal('show');
                },
                selectIcon : function (id){
                    $('#iconsCatalogModal').modal('hide');
                    this.selectedIcon = id;
                    document.getElementById("icon_id").value = id;
                },
                changeFilterMode : function (mode){
                    this.filterMode = mode;
                    this.filter(this.filterText);
                },
                filter : function (text){
                    var re = new RegExp(text,'i');
                    var mode = new RegExp(this.filterMode,'i');
                    this.icons = this.allIcons.filter(function (el) {

                        return (re.test(el.tags)||re.test(el.name))&&mode.test(el.tags);
                    });
                    app.$forceUpdate();
                },
                onChange : function (){
                    alert(app.selectedParent);
                    $('#parent_id').selectpicker('render');

                },
                askDeleteSupply: function(name,id){
                    this.selectionName = name;
                    $('#deleteSupplyModal').modal('show');
                    this.action = this.deleteSupplyLink+id;
                },
                askDeleteSupplyCategory: function(name,id){
                    this.selectionName = name;
                    $('#deleteSupplyCategoryModal').modal('show');
                    this.action = this.deleteChildLink+id;
                }

            },
            mounted: function(){

                this.deleteChildLink = '<?php echo route('admin.supplies-categories.index')?>'+"/parent/";
                this.deleteSupplyLink = '<?php echo route('admin.supplies.index')?>'+"/parent/";

                axios.get(`<?php echo URL::asset('/icons/supplies') ?>`)
                    .then(response => {
                    app.allIcons = response.data;
                app.icons = app.allIcons;
            });

                this.imageLink = `<?php echo URL::asset('/images/icons/mini') ?>`;
                this.fullImageLink = `<?php echo URL::asset('/images/icons/normal') ?>`;

                var oldIcon = `<?php echo $supplies_category->icon_id ?>`;

                if(oldIcon!=null)
                {
                    this.selectedIcon = oldIcon;
                }
            },

        })
    </script>
@stop
