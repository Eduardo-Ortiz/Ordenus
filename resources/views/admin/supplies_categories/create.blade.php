@extends('admin.layouts.panel')


@section('content')
    <link rel="stylesheet" href="{{ URL::asset('css/icon-selector.css') }}" />

    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-select.min.css') }}" />




    <div id="app" class="col-lg-12">
        <h1 class="page-header">Nueva Categoría de Insumos</h1>

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

        <form method="POST" action="{{route('admin.supplies-categories.store')}}">
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-4">
                    <div  class="form-group">
                        <label for="name">Nombre de la categoría:</label>
                        <input value="{{old('name')}}" id="name" name="name" class="form-control"> </input>
                    </div>
                </div>
                <div class="col-md-8">
                    <div  class="form-group">
                        <label for="name">Pertenece a la categoría:</label>
                        <select data-size="15" id="parent_id" name="parent_id" data-live-search="true" class="selectpicker form-control">
                            <option data-content="<img height='20px' src='{{URL::asset('/images/icons/extra/prohibited.png')}}'></img> <span>Sin categoría padre</span>" value="0">No Pertenece a Ninguna Categoría</option>
                            @foreach($categories as $category)
                                <option @if ($category->id == old('parent_id'))
                                        selected="selected"
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
                        <textarea id="description" name="description" class="form-control" rows="3">{{old('description')}}</textarea>
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
                        <input type="hidden" name="icon_id" value="" id="icon_id">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="pull-left">
                        <button style="margin-top: 14px" type="submit" class="btn btn-success btn-lg btn-block"><i class="fa fa-floppy-o fa-fw"></i>Agregar Categoria</button>
                    </div>
                </div>
            </div>
        </form>



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
                selectedIcon : 0
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
                }

            },
            mounted: function(){
                axios.get(`<?php echo URL::asset('/icons/supplies') ?>`)
                    .then(response => {
                    app.allIcons = response.data;
                    app.icons = app.allIcons;
                });

                this.imageLink = `<?php echo URL::asset('/images/icons/mini') ?>`;
                this.fullImageLink = `<?php echo URL::asset('/images/icons/normal') ?>`;

                var oldIcon = `<?php echo old('icon_id') ?>`;

                if(oldIcon!=null)
                {
                    this.selectedIcon = oldIcon;
                }
            },

        })
    </script>
@stop
