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

        .table-fix {
            padding-top: 12px !important;
        }
    </style>

    <div id="app" class="col-lg-12">
        <h1 class="page-header">Editar Producto: {{$product->name}}</h1>

        <div v-if="errors.length>0" class="alert alert-danger fade in alert-dismissable">
            <a v-on:click="closeAlert()" href="#" class="close" aria-label="close">&times;</a>
            Han ocurrido los siguientes errores:
            <ul>
                <li v-for="error in errors">@{{error}}</li>
            </ul>
        </div>

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
                                <label for="name">Nombre del Producto:</label>
                                <input v-model="name" id="name" name="name" class="form-control"> </input>
                            </div>
                        </div>
                        <div class="col-xs-8 col-sm-8 col-md-8">
                            <div  class="form-group">
                                <label for="name">Pertenece a la categoría:</label>
                                <select v-model="category" data-size="10" id="parent_id" name="parent_id" data-live-search="true" class="selectpicker form-control" title="Seleccionar Categoría">
                                    @foreach($categories as $category)
                                        <option @if ($category->id == $product->menu_category_id)
                                                selected="selected"
                                                @endif
                                                data-content="<img class='img-thumbnail' style='height:35px' src='{{URL::asset('/images/menu_categories_photos/mini')}}/{{$category->id}}.png'></img>  <span class='fix-text-selection'>{{$category->fullname}}</span>" value="{{$category->id}}">{{$category->fullname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 8px" class="row">
                        <!-- Enabled Input -->
                        <div class="col-xs-2 col-sm-2 col-md-2">
                            <div class="form-group">
                                <label for="enabled">Estado:</label>
                                <input style="padding: 32px !important;" @if($product->enabled)checked="checked"@endif type="checkbox" data-toggle="toggle" data-on="Activado" id="enabled" name="enabled"
                                       data-off="Desactivado" data-onstyle="default" data-width="100%">
                            </div>
                        </div>

                        <div class="col-xs-2 col-sm-2 col-md-2">
                            <div class="form-group">
                                <label for="ingredient">Tipo:</label>
                                <input disabled style="padding: 32px !important;" checked="checked" type="checkbox" data-toggle="toggle" data-on="Receta" id="type" name="type"
                                       data-off="Insumo" data-onstyle="default" data-width="100%">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div  class="form-group">
                                <label for="name">Precio:</label>
                                <input v-model="price" type="number" value="{{old('name')}}" id="name" name="name" class="form-control"> </input>
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <div class="form-group">
                                <label>Imagen de Muestra: </label>
                                <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    Seleccionar… <input ref="photoPath" v-on:change="selectedPhoto()" accept="image/png, image/jpeg, image/gif" name="photo" id="photo" type="file">
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
                        <img src="{{URL::asset('images/products_photos/'.$product->id.'.png')}}" class="img-thumbnail img-responsive" style=" position: relative;width: auto;max-height: 122px" id='img-upload'/>
                    </div>
                </div>
            </div>


            <div style="margin-top: 10px" class="row">
                <div class="col-md-12">
                    <div  class="form-group">
                        <label for="name">Descripcion del producto:</label>
                        <textarea v-model="description" id="description" name="description" class="form-control" rows="2">{{old('description')}}</textarea>
                    </div>
                </div>
            </div>


            <div v-show="recipe" style="margin-top: 4px" class="row">
                <div class="col-md-12">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">Configuracion de Receta</div>
                            <div class="panel-body">

                                <div class="row">
                                    <div  class="col-xs-1 col-sm-1 col-md-1">
                                        <div class="form-group">
                                            <label for="name">Horas:</label>
                                            <select v-on:change="timeChange()" v-model="hours"  class="selectpicker form-control">
                                                <option>0</option>
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div  class="col-xs-2 col-sm-2 col-md-2">
                                        <div  class="form-group">
                                            <label for="name">Minutos:</label>
                                            <div class="row">
                                                <div  class="col-xs-6 col-sm-6 col-md-6">
                                                    <select v-on:change="timeChange()" v-model="minutes_one" id="unit_id" name="unit_id"  class="selectpicker form-control">
                                                        <option>0</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                        <option>6</option>
                                                    </select>
                                                </div>
                                                <div  class="col-xs-6 col-sm-6 col-md-6">
                                                    <select v-on:change="timeChange()" v-model="minutes_two" id="minutes_two" name="minutes_two"  class="selectpicker form-control">
                                                        <option>0</option>
                                                        <option v-if="minutes_one<6">1</option>
                                                        <option v-if="minutes_one<6">2</option>
                                                        <option v-if="minutes_one<6">3</option>
                                                        <option v-if="minutes_one<6">4</option>
                                                        <option v-if="minutes_one<6">5</option>
                                                        <option v-if="minutes_one<6">6</option>
                                                        <option v-if="minutes_one<6">7</option>
                                                        <option v-if="minutes_one<6">8</option>
                                                        <option v-if="minutes_one<6">9</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div style="margin-top: -14px"  class="col-xs-12 col-sm-12 col-md-12">
                                        <p><i>(Tiempo de Preparación aproximado de la receta)</i></p>
                                    </div>
                                </div>


                                <label for="">Ingredientes: </label>
                                <div class="row">
                                    <div  class="col-xs-5 col-sm-5 col-md-5">
                                        <select v-on:change="loadSupply()" v-model="supplyCategory" title="Seleccionar Categoría..." data-size="10" id="parent_id" name="parent_id" data-live-search="true" class="selectpicker form-control">
                                            @foreach($supply_categories as $category)
                                                <option @if ($category->id == old('parent_id'))
                                                        selected="selected"
                                                        @endif
                                                        data-content="<img class='img-thumbnail' style='height:35px' src='{{URL::asset('/images/icons/mini')}}/{{$category->icon_id}}.png'></img>  <span class='fix-text-selection'>{{$category->fullname}}</span>" value="{{$category->id}}">{{$category->fullname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div  class="col-xs-5 col-sm-5 col-md-5">
                                        <div v-show="supplyCategory!=null">
                                            <select title="Sin resultados para esta categoría" v-model="selectedSupply" data-size="10" id="supplys" name="supplys" data-live-search="true" class="selectpicker form-control">
                                                <option v-bind:value="index" v-bind:data-content="getSupplyList(supply)"
                                                        v-for="(supply,index) in supplies">@{{supply.name}}</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-xs-2 col-sm-2 col-md-2">
                                        <button v-on:click="openIngredientModal()" v-show="selectedSupply>=0&&selectedSupply!=null" type="button" class="btn btn-success btn-lg btn-block"><i class="fa fa-floppy-o fa-fw"></i> Agregar Ingrediente</button>
                                    </div>
                                </div>




                                <div v-if="ingredients.length>0" style="margin-top: 20px" class="row">
                                    <div  class="col-xs-12 col-sm-12 col-md-12">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th style="width: 30px">Icono</th>
                                                <th>Ingrediente</th>
                                                <th>Cantidad</th>
                                                <th style="width: 30px">Removible</th>
                                                <th>Precio Extra</th>
                                                <th style="width: 10px">Editar</th>
                                                <th style="width: 10px">Eliminar</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(ingredient,index) in ingredients">
                                                <td style="text-align: center"><img class='img-thumbnail' style='height:30px' v-bind:src="imagesLink+'/supplies_photos/mini/'+ingredient.id+'.png'" alt=""></td>
                                                <td class="table-fix">@{{ingredient.name}}</td>
                                                <td class="table-fix">@{{ingredient.quantityText}}</td>
                                                <td style="text-align: center" class="table-fix" v-if="ingredient.removable"><span style="font-size: 18px;font-weight: normal !important;" class="label label-success">Si</span></td>
                                                <td style="text-align: center" class="table-fix" v-else><span style="font-size: 18px;font-weight: normal !important;" class="label label-danger">No</span></td>
                                                <td class="table-fix" v-if="ingredient.extra">@{{ingredient.extraText}}</td>
                                                <td class="table-fix" v-else><span><i style="color: darkgrey">No Aplica</i></span></td>
                                                <td class="table-fix" style="text-align: center">
                                                    <button type="button" v-on:click="editIngredient(index)" class="btn btn-default btn-xs">Editar</button>
                                                </td>
                                                <td class="table-fix">
                                                    <button type="button" v-on:click="deleteIngredient(index)" class="btn btn-danger btn-xs">Eliminar</button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>
                </div>
            </div>


            <div v-show="!recipe" style="margin-top: 4px" class="row">
                <div class="col-md-12">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">Configuracion de Insumo</div>
                            <div class="panel-body">
                                <label for="name">Insumo Asociado:</label>
                                <div class="row" style="margin-bottom: 15px">
                                    <div  class="col-xs-5 col-sm-5 col-md-5">
                                        <select v-on:change="loadSupplyDirect()" v-model="supplyCategoryDirect" title="Seleccionar Categoría..." data-size="10" id="parent_id" name="parent_id" data-live-search="true" class="selectpicker form-control">
                                            @foreach($supply_categories as $category)
                                                <option @if ($category->id == old('parent_id'))
                                                        selected="selected"
                                                        @endif
                                                        data-content="<img class='img-thumbnail' style='height:35px' src='{{URL::asset('/images/icons/mini')}}/{{$category->icon_id}}.png'></img>  <span class='fix-text-selection'>{{$category->fullname}}</span>" value="{{$category->id}}">{{$category->fullname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div  class="col-xs-5 col-sm-5 col-md-5">
                                        <div v-show="supplyCategoryDirect!=null">
                                            <select title="Sin resultados para esta categoría" v-model="selectedSupplyDirect" data-size="10" id="supplyDirect" name="supplyDirect" data-live-search="true" class="selectpicker form-control">
                                                <option v-bind:value="index" v-bind:data-content="getSupplyList(supply)"
                                                        v-for="(supply,index) in supplies">@{{supply.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div v-if="supplyData!=null" id="ingredientModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content bigModal">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Agregar Ingrediente @{{supplyData.name}} </h4>
                        </div>
                        <div class="modal-body">
                            <div v-if="ingredientData.errors.length>0" style="margin-top: 15px" class="alert alert-danger fade in alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                Han ocurrido los siguientes errores:
                                <ul>
                                    <li v-for="error in ingredientData.errors">@{{error}}</li>
                                </ul>
                            </div>


                            <div class="row" style="margin-top: 10px">
                                <div class="col-md-offset-1 col-md-3">
                                    <div  class="form-group">
                                        <label for="name">Cantidad:</label>
                                        <input v-model="ingredientData.quantity" type="number" value="{{old('name')}}" id="name" name="name" class="form-control"> </input>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div  class="form-group">
                                        <label for="name">Unidad:</label>
                                        <select v-model="ingredientData.unit" class="form-control" id="sel1">
                                            <option v-for="(unit,index) in supplyUnits" v-bind:value="index">@{{unit.name}} (@{{unit.abreviation}})</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <label for="enabled">Removible:</label>
                                        <input v-model="ingredientData.removable" checked="checked" type="checkbox" data-on="Si" id="ingredient" name="ingredient" data-off="No" ><br>
                                        <span><i>(Puede ser retirado del platillo al ordenarlo)</i></span>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-md-offset-1 col-xs-3 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label for="enabled">Aumentable:</label>
                                        <input v-model="ingredientData.extra" checked="checked" type="checkbox" data-on="Si" id="ingredient" name="ingredient" data-off="No" ><br>
                                        <span><i>(Puede ser aumentado en el platillo)</i></span>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div  class="form-group">
                                        <label for="name">Cantidad:</label>
                                        <input :disabled="!ingredientData.extra" v-model="ingredientData.extraQuantity" type="number" value="{{old('name')}}" id="name" name="name" class="form-control"> </input>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div  class="form-group">
                                        <label for="name">Unidad:</label>
                                        <select :disabled="!ingredientData.extra" v-model="ingredientData.extraUnit" class="form-control" id="sel1">
                                            <option v-for="(unit,index) in supplyUnits" v-bind:value="index">@{{unit.name}} (@{{unit.abreviation}})</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div  class="form-group">
                                        <label for="name">Precio:</label>
                                        <input :disabled="!ingredientData.extra" v-model="ingredientData.extraPrice" type="number" value="{{old('name')}}" id="name" name="name" class="form-control"> </input>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button v-on:click="confirmIngredient()" type="button" class="btn-lg btn btn-success">Confirmar</button> &nbsp;&nbsp;
                            <button type="button" class="btn-lg btn btn-default" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md-6">
                    <div class="pull-left">
                        <button v-on:click="saveProduct()" style="margin-top: 14px" type="button" class="btn btn-success btn-lg btn-block"><i class="fa fa-floppy-o fa-fw"></i>Guardar Producto</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="pull-right">
                        <button type="button" style="margin-top: 14px" class="btn btn-danger btn-lg btn-block" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash fa-fw"></i> Eliminar Insumo</button>
                    </div>
                </div>
            </div>

        </form>

        <!-- Modal -->
        <div id="deleteModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content bigModal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Eliminar el producto "{{$product->name}}"</h4>
                    </div>
                    <div class="modal-body">
                        <h2>¿Desea eliminar el insumo {{$product->name}}?</h2>
                        <h4>Nota: Esta acción no podra revertirse</h4>
                    </div>

                    <div class="modal-footer">

                        <form method="POST" action="{{route('admin.products.destroy',$product->id)}}">
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

        function zeroPad(num, places) {
            var zero = places - num.toString().length + 1;
            return Array(+(zero > 0 && zero)).join("0") + num;
        }
    </script>


    <script>
        var app = new Vue({
            el: '#app',
            data: {
                productData : null,
                unitsData : [],


                name : null,
                enabled: true,
                recipe: true,
                time : 0,
                category : null,
                price : null,
                description : null,
                photo : null,


                supplyCategory : null,
                supplies : [],
                imagesLink : null,
                hours : "0",
                minutes_one : "0",
                minutes_two : "0",


                selectedSupply : null,
                supplyData : null,
                ingredients : [],
                supplyUnits : [],



                supplyCategoryDirect : null,
                selectedSupplyDirect : null,

                ingredientData : {
                    quantity : null,
                    unit : null,
                    removable : true,
                    extra : false,
                    extraQuantity : null,
                    extraUnit : null,
                    extraPrice : null,
                    errors : []
                },

                errors : []
            },
            methods: {
                loadSupply: function ()
                {
                    app.supplies = [];
                    axios.post('<?php echo URL::asset('admin/supplies-categories/supplies') ?>', {
                        category: app.supplyCategory,
                        mode: 1
                    })
                        .then(function (response) {

                            app.supplies = response.data;
                            if(app.supplies.length>0)
                                app.selectedSupply = 0;
                            else
                                app.selectedSupply = null;
                            Vue.nextTick(function () {
                                $('#supplys').selectpicker('refresh');

                            }.bind(this));
                            app.$forceUpdate;
                        })
                },
                loadSupplyDirect: function ()
                {
                    app.supplies = [];
                    axios.post('<?php echo URL::asset('admin/supplies-categories/supplies') ?>', {
                        category: app.supplyCategoryDirect,
                        mode: 0
                    })
                        .then(function (response) {
                            app.supplies = response.data;
                            Vue.nextTick(function () {
                                $('#supplyDirect').selectpicker('refresh');
                            }.bind(this));
                            if(app.supplies.length>0)
                                app.selectedSupplyDirect = null;
                            else
                                app.selectedSupplyDirect = null;
                            app.$forceUpdate;

                        })
                },
                getSupplyList: function (supply)
                {
                    var imageLink = this.imagesLink + "/supplies_photos/mini/" + supply.id;
                    return  "<img class=\'img-thumbnail\' style=\'height:35px\' src=" +
                        imageLink +
                        ".png><\/img>  <span class=\'fix-text-selection\'>" +
                        supply.name +
                        "<\/span>";
                },
                timeChange : function ()
                {
                    Vue.nextTick(function () {
                        $('#minutes_two').selectpicker('refresh');
                    }.bind(this))
                    this.time = this.hours*60+this.minutes_one*10+this.minutes_two*1;
                },
                openIngredientModal : function ()
                {
                    this.supplyData = this.supplies[this.selectedSupply];
                    this.ingredientData = {
                        quantity : null,
                        unit : null,
                        removable : true,
                        extra : false,
                        extraQuantity : null,
                        extraUnit : null,
                        extraPrice : null,
                        errors : []
                    };
                    axios.get(`<?php echo URL::asset('admin/supplies/allunits/') ?>`+"/"+this.supplyData.id)
                        .then(response => {
                            app.supplyUnits = response.data;
                            app.$forceUpdate;
                        });
                    Vue.nextTick(function () {
                        $('#ingredientModal').modal('show');
                    }.bind(this));
                },
                confirmIngredient : function ()
                {
                    this.ingredientData.errors = [];
                    if(this.ingredientData.quantity==null)
                        this.ingredientData.errors.push("Se debe ingresar la cantidad del ingrediente");
                    if(this.ingredientData.unit==null)
                        this.ingredientData.errors.push("Se debe seleccionar la unidad de medida del ingrediente");
                    if(this.ingredientData.extra&&this.ingredientData.extraQuantity==null)
                        this.ingredientData.errors.push("Se debe ingresar la cantidad al agregar ingrediente extra");
                    if(this.ingredientData.extra&&this.ingredientData.extraPrice==null)
                        this.ingredientData.errors.push("Se debe ingresar el precio al agregar ingrediente extra");
                    if(this.ingredientData.extra&&this.ingredientData.extraUnit==null)
                        this.ingredientData.errors.push("Se debe ingresar la unidad del ingrediente extra");
                    app.$forceUpdate;

                    if(this.ingredientData.errors.length===0)
                    {
                        var data = {
                            name: this.supplyData.name,
                            id: this.supplyData.id,
                            quantity : this.ingredientData.quantity,
                            unitId : this.supplyUnits[this.ingredientData.unit].id,
                            quantityText : this.ingredientData.quantity + " " + this.supplyUnits[this.ingredientData.unit].name
                            + " (" + this.supplyUnits[this.ingredientData.unit].abreviation + ")",
                            removable : this.ingredientData.removable,
                            extra : this.ingredientData.extra,
                            extraQuantity : this.ingredientData.extraQuantity,
                            extraUnit : null,
                            extraPrice : this.ingredientData.extraPrice
                        };
                        if(data.extra)
                        {
                            data.extraUnit = this.supplyUnits[this.ingredientData.extraUnit].id;
                            data.extraText = this.ingredientData.extraPrice + "$ por " + this.ingredientData.extraQuantity + " " +
                                this.supplyUnits[this.ingredientData.extraUnit].name  + " (" +
                                this.supplyUnits[this.ingredientData.extraUnit].abreviation + ")" + " Extra";
                        }
                        else
                        {
                            data.extraQuantity = null;
                            data.extraUnit = null;
                            data.extraPrice = null;
                        }

                        if(this.editingIngredient!=null)
                        {
                            this.ingredients[this.editingIngredient] = data;
                            this.editingIngredient = null;
                            app.$forceUpdate;
                            $('#ingredientModal').modal('hide');
                        }
                        else
                        {
                            this.ingredients.push(data);
                            $('#ingredientModal').modal('hide');
                        }
                    }
                },
                selectedPhoto : function ()
                {
                    this.photo = this.$refs.photoPath.value;
                },
                saveProduct : function ()
                {
                    this.errors = [];
                    if(this.name===null||this.name==="")
                        this.errors.push("Se debe ingresar un nombre para el producto");
                    if(this.category===null)
                        this.errors.push("Se debe seleccionar una categoría para el producto");
                    if(this.price===null||this.price==="")
                        this.errors.push("Se debe ingresar un precio para el producto");
                    if(this.description===null||this.description==="")
                        this.errors.push("Se debe ingresar una descripción para el producto");

                    if(this.recipe)
                    {
                        if(this.time===0)
                            this.errors.push("Se debe ingresar el tiempo aproximado de preparación");
                        if(this.ingredients.length===0)
                            this.errors.push("Se debe seleccionar al menos un ingrediente para la receta");
                    }
                    else
                    {
                        if(this.selectedSupplyDirect===null)
                            this.errors.push("Se debe ingresar el insumo asociado al producto");
                    }

                    if(this.errors.length===0)
                    {
                        var imagefile = document.querySelector('#photo');


                        var data = new FormData();

                        data.append('name', this.name);
                        data.append('description', this.description);
                        data.append('menu_category_id', this.category);
                        data.append('recipe', this.recipe);
                        data.append('enabled', this.enabled);
                        data.append('price', this.price);
                        data.append('photo', imagefile.files[0]);

                        if(this.recipe)
                        {
                            data.append('ingredients', JSON.stringify(this.ingredients));
                            data.append('time', this.time);
                        }
                        else
                        {
                            data.append('supply_id', this.supplies[this.selectedSupplyDirect].id);
                        }
                        axios({
                            method: 'post',
                            url: `<?php echo URL::asset('admin/products/update/') ?>`+"/"+<?php echo $product->id ?>,
                            data: data,
                            config: { headers: {'Content-Type': 'application/x-www-form-urlencoded' }}
                        })
                            .then(function (response) {
                                //handle success
                                window.location = '<?php echo URL::asset('/admin/products') ?>';
                            })
                            .catch(function (response) {
                                //handle error
                                console.log(response);
                            });
                    }
                },
                deleteIngredient : function (index)
                {
                    this.ingredients.splice(index, 1);
                },
                editIngredient : function (index)
                {
                    var supplyData = {
                        id : this.ingredients[index].id,
                        ingredient : 1,
                        name : this.ingredients[index].name,
                    };

                    this.supplyData = supplyData;

                    this.editingIngredient = index;
                    this.ingredientData.extra = this.ingredients[index].extra;
                    this.ingredientData.extraPrice = this.ingredients[index].extraPrice;
                    this.ingredientData.extraQuantity = this.ingredients[index].extraQuantity;
                    this.ingredientData.quantity = this.ingredients[index].quantity;
                    this.ingredientData.removable = this.ingredients[index].removable;

                    axios.get(`<?php echo URL::asset('admin/supplies/allunits/') ?>`+"/"+this.ingredients[index].id)
                        .then(response => {
                            app.supplyUnits = response.data;

                            for(i=0;i<app.supplyUnits.length;i++)
                            {
                                if(app.supplyUnits[i].id===this.ingredients[index].unitId)
                                {
                                    app.ingredientData.unit = i;
                                }
                            }

                            if(app.ingredientData.extra)
                            {
                                for(i=0;i<app.supplyUnits.length;i++)
                                {
                                    if(app.supplyUnits[i].id===this.ingredients[index].extraUnit)
                                    {
                                        app.ingredientData.extraUnit = i;
                                    }
                                }
                            }
                            app.$forceUpdate;
                        });

                    Vue.nextTick(function () {
                        $('#ingredientModal').modal('show');
                    }.bind(this));
                },
                closeAlert : function ()
                {
                    this.errors = [];
                }
            },
            mounted: function(){
                this.imagesLink = `<?php echo URL::asset('/images/') ?>`;
                this.productData = <?php echo $product?>;
                this.unitsData = <?php echo $units?>;
                this.name = this.productData.name;
                this.description = this.productData.description;
                this.price = this.productData.price;
                this.enabled = Boolean(this.productData.enabled);
                this.time = this.productData.time;
                this.recipe = this.productData.recipe;

                this.hours = (Math.floor(this.time/60)).toString();
                var minutes = this.time % 60;

                if(this.recipe)
                {
                    if(minutes<10)
                    {
                        this.minutes_one="0";
                        this.minutes_two = minutes.toString();
                    }
                    else
                    {
                        this.minutes_one = minutes.toString()[0];
                        this.minutes_two = minutes.toString()[1];
                    }

                    var ingredientsJson = <?php echo $product->ingredients?>;

                    for(i=0;i<ingredientsJson.length;i++)
                    {
                        var unitData;
                        for(j=0;j<this.unitsData.length;j++)
                        {
                            if(this.unitsData[j].id===ingredientsJson[i].pivot.unit_id)
                            {
                                unitData = this.unitsData[j];
                            }
                        }

                        var data = {
                            name: ingredientsJson[i].name,
                            id: ingredientsJson[i].id,
                            quantity : ingredientsJson[i].pivot.quantity,
                            unitId : ingredientsJson[i].pivot.unit_id,
                            quantityText : ingredientsJson[i].pivot.quantity + " " + unitData.name
                            + " (" + unitData.abreviation + ")",
                            removable : Boolean(ingredientsJson[i].pivot.removable),
                            extra : Boolean(ingredientsJson[i].pivot.extra),
                            extraQuantity : ingredientsJson[i].pivot.extra_quantity,
                            extraUnit : ingredientsJson[i].pivot.extra_unit,
                            extraPrice : ingredientsJson[i].pivot.extra_price
                        };
                        if(data.extra)
                        {
                            var extraUnitData;
                            for(j=0;j<this.unitsData.length;j++)
                            {
                                if(this.unitsData[j].id===ingredientsJson[i].pivot.extra_unit)
                                {
                                    extraUnitData = this.unitsData[j];
                                }
                            }
                            data.extraText = ingredientsJson[i].pivot.extra_price + "$ por " + ingredientsJson[i].pivot.extra_quantity
                                + " " + extraUnitData.name
                                + " (" + extraUnitData.abreviation + ")" + " Extra";
                        }
                        this.ingredients.push(data);
                    }
                }

                var categoriesData = <?php echo $categories?>;

                for(i=0;i<categoriesData.length;i++)
                {
                    if(this.productData.menu_category_id===categoriesData[i].id)
                    {
                        this.category=i+1;
                    }
                }
            }
        })
    </script>

    <script>
        $(function() {
            $('#type').change(function() {
                app.recipe=!app.recipe;
            });

            $('#enabled').change(function() {
                app.enabled=!app.enabled;
            })
        });

        $(document).on('change', '#supply', function () {
            $('#supply').selectpicker('refresh');
        });


    </script>
@stop
