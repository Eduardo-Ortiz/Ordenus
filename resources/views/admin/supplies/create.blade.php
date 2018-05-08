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

        #img-upload{
            width: 100%;
        }
    </style>

    <div id="app" class="col-lg-12">
        <h1 class="page-header">Nuevo Insumo</h1>

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

        <form method="POST" action="{{route('admin.supplies.store')}}" enctype="multipart/form-data">
            {{csrf_field()}}

            <div class="row">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-4">
                            <div  class="form-group">
                                <label for="name">Nombre del Insumo:</label>
                                <input value="{{old('name')}}" id="name" name="name" class="form-control"> </input>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div  class="form-group">
                                <label for="name">Pertenece a la categoría:</label>
                                <select data-size="15" id="supplies_category_id" name="supplies_category_id" data-live-search="true" class="selectpicker form-control" title="Seleccionar Categoría de Insumos">
                                    @foreach($categories as $category)
                                        <option @if ($category->id == old('supplies_category_id'))
                                                selected="selected"
                                                @endif
                                                data-content="<img height='20px' src='{{URL::asset('/images/icons/mini')}}/{{$category->icon_id}}.png'></img> <span>{{$category->fullname}}</span>" value="{{$category->id}}">{{$category->fullname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Enabled Input -->
                        <div class="col-xs-2 col-sm-2 col-md-2">
                            <div class="form-group">
                                <label for="enabled">Tipo de Insumo:</label>
                                <input style="padding: 32px !important;" checked="checked" type="checkbox" data-toggle="toggle" data-on="Ingrediente" id="ingredient" name="ingredient"
                                       data-off="Producto" data-onstyle="default" data-width="100%">
                            </div>
                        </div>

                        <div  class="col-xs-2 col-sm-2 col-md-2">
                            <div  class="form-group">
                                <label for="name">Unidad de Medida:</label>
                                <select id="unit_id" name="unit_id"  class="selectpicker form-control">
                                    @foreach($units as $unit)
                                        <option
                                                @if ($unit->id == old('unit_id'))
                                                selected="selected"
                                                @endif
                                                value="{{$unit->id}}">{{$unit->name}} ({{$unit->abreviation}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-8 col-sm-8 col-md-8">
                            <div class="form-group">
                                <label>Imagen de Muestra: </label>
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
                </div>

                <div class="col-md-2">
                    <label>Vista Previa de Imagen: </label>
                    <div style="text-align: center">
                        <img src="{{URL::asset('images/utility/placeholder.png')}}" class="img-thumbnail img-responsive" style=" position: relative;width: auto;max-height: 114px" id='img-upload'/>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="pull-left">
                        <button style="margin-top: 14px" type="submit" class="btn btn-success btn-lg btn-block"><i class="fa fa-floppy-o fa-fw"></i> Agregar Insumo</button>
                    </div>
                </div>
            </div>
        </form>


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
                axios.get(`<?php echo URL::asset('/icons/all') ?>`)
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
