@extends('admin.layouts.panel')


@section('content')
    <link rel="stylesheet" href="{{ URL::asset('css/icon-selector.css') }}" />

    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-select.min.css') }}" />




    <div id="app" class="col-lg-12">
        <h1 class="page-header">Nueva Area de Trabajo</h1>

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

        <div v-if="errors.length>0" class="alert alert-danger fade in alert-dismissable">
            <a v-on:click="closeAlert()" href="#" class="close" aria-label="close">&times;</a>
            Han ocurrido los siguientes errores:
            <ul>
                <li v-for="error in errors">@{{error}}</li>
            </ul>
        </div>

        <form method="POST" action="{{route('admin.supplies-categories.store')}}">
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-5">
                    <div  class="form-group">
                        <label for="name">Nombre del Area:</label>
                        <input v-model="name" value="{{old('name')}}" id="name" name="name" class="form-control"> </input>
                    </div>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2">
                    <div class="form-group">
                        <label for="ingredient">Modo:</label>
                        <input style="padding: 32px !important;" checked="checked" type="checkbox" data-toggle="toggle" data-on="Touch <i class='fa fa-hand-pointer-o fa-fw'></i>" id="mode" name="mode"
                               data-off="Normal <i class='fa fa-reorder fa-fw'></i>" data-onstyle="default" data-width="100%">
                    </div>
                </div>

                <div class="col-xs-2 col-sm-2 col-md-2">
                    <div class="form-group">
                        <label for="ingredient">Tipo:</label>
                        <input style="padding: 32px !important;" checked="checked" type="checkbox" data-toggle="toggle" data-on="Simple <i class='fa fa-user fa-fw'></i>" id="type" name="type"
                               data-off="Multiple <i class='fa fa-users fa-fw'></i>" data-onstyle="default" data-width="100%">
                    </div>
                </div>

                <div class="col-md-3" v-if="!multiple">
                    <div  class="form-group">
                        <label for="name">Codigo de Acceso:</label>
                        <input v-model="code" type="password" value="{{old('name')}}" id="name" name="name" class="form-control"> </input>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-9">
                    <div  class="form-group">
                        <label for="name">Descripcion del Area:</label>
                        <textarea v-model="description" id="description" name="description" class="form-control" rows="3">{{old('description')}}</textarea>
                    </div>
                </div>

                <div class="col-md-3">
                    <div  class="form-group">
                        <label style="font-size: 16px !important;margin-top: 3px !important;" for="name">Icono del Area:</label><br>

                        <button v-if="selectedIcon==0" v-on:click="openCatalog()" style="height: 78px;width: 100%;" type="button" class="btn-lg btn btn-default" data-dismiss="modal">
                            Seleccionar Icono
                        </button>

                        <button v-else v-on:click="openCatalog()" style="height: 78px;width: 100%;" type="button" class="btn-lg btn btn-default">
                            <img style="margin-top: -7px" height="70" v-bind:src="fullImageLink+'/'+selectedIcon+'.png'" alt="">
                        </button>
                        <input type="hidden" name="icon_id" value="" id="icon_id">
                    </div>
                </div>

                <div class="col-md-12" v-if="!multiple">
                    <div class="pull-left">
                        <button style="margin-top: 14px" type="button" @click="saveArea()" class="btn btn-success btn-lg btn-block"><i class="fa fa-floppy-o fa-fw"></i>Guardar Area</button>
                    </div>
                </div>
            </div>


            <div v-if="multiple" class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="name">Nombre de de Subarea:</label>
                        <input v-model="subName" value="{{old('name')}}" id="name" name="name" class="form-control"> </input>
                    </div>
                </div>
                <div class="col-md-3">
                    <div  class="form-group">
                        <label for="name">Codigo de Acceso:</label>
                        <input v-model="subCode" type="password" value="{{old('name')}}" id="name" name="name" class="form-control"> </input>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="pull-left">
                        <button @click="addSub()" style="margin-top: 14px" type="button" class="btn btn-success btn-lg btn-block"><i class="fa fa-plus-circle fa-fw"></i>Agregar Subarea</button>
                    </div>
                </div>


                <div class="col-md-12">
                    <div v-if="childs.length==0" style="text-align: center"><h2>No se han agregado subareas</h2></div>
                    <table v-else class="table table-striped table-bordered" style="table-layout: fixed;">
                        <thead>
                        <tr>
                            <th>Subarea</th>
                            <th>Codigo</th>
                            <th style="width: 138px">Eliminar</th>
                        </tr>
                        </thead>
                        <tbody >
                        <tr v-for="(child,index) in childs">
                            <td>@{{name}}-@{{child.name}}</td>
                            <td><button v-on:mouseover="showCode(index)" v-on:mouseleave="hideCode(index)" style="padding-top : 2px!important;padding-bottom : 1px!important;" class="btn btn-default btn-sm"><i style="font-size: 18px;" class="fa fa-eye fa-fw"></i></button> <span v-show="!child.showpassword">@{{transformCode(child.code)}}</span><span v-show="child.showpassword">@{{child.code}}</span></td>
                            <td style="text-align: center"><button v-on:click="deleteSub(index)" type="button"  class="btn btn-danger btn-xs">Eliminar Subarea</button></td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12" v-if="multiple">
                    <button style="margin-top: 14px" type="button" @click="saveArea()" class="btn btn-success btn-lg"><i class="fa fa-floppy-o fa-fw"></i>Guardar Area</button>
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
                name : null,
                description : null,
                mode : null,
                multiple : false,
                touch : true,
                code : null,
                childs: [],
                selectedIcon : null,
                subName : null,
                subCode : null,


                allIcons : [],
                icons : [],
                imageLink : null,
                fullImagelLink : null,
                filterMode : "",
                filterText : "",

                errors : []

            },
            methods: {
                addSub : function ()
                {
                    if(this.subName!==null&&this.subCode!==null&&this.subName!==""&&this.subCode!=="")
                    {
                        this.childs.push({name : this.subName, code : this.subCode, showpassword: false});
                        this.subName = null;
                        this.subCode = null;
                    }
                },
                deleteSub : function (index)
                {
                    this.childs.splice(index, 1);
                },
                transformCode : function (code)
                {
                    return Array(code.length+1).join("•");
                },
                hideCode : function (index)
                {
                    this.childs[index].showpassword = false;
                },
                showCode : function (index)
                {
                    this.childs[index].showpassword = true;
                },
                saveArea : function ()
                {
                    this.errors = [];
                    if(this.name===null||this.name==="")
                        this.errors.push("Se debe ingresar un nombre para el area");
                    if(this.description===null)
                        this.errors.push("Se debe seleccionar una descripción para el area");
                    if(this.selectedIcon===null||this.selectedIcon==="")
                        this.errors.push("Se debe seleccionar un icono para el area");
                    if(!this.multiple)
                    {
                        if(this.code===null||this.code==="")
                            this.errors.push("Se debe ingresar un codigo de acceso para el area");
                    }
                    else
                    {
                        if(this.childs.length===0)
                            this.errors.push("Se debe ingresar al menos una subarea");
                    }

                    if(this.errors.length===0)
                    {
                        var data = new FormData();
                        data.append('name', this.name);
                        data.append('description', this.description);
                        data.append('code', this.code);
                        data.append('childs', JSON.stringify(this.childs));
                        data.append('icon_id', this.selectedIcon);
                        data.append('multiple', this.multiple);
                        data.append('touch', this.touch);

                        axios({
                            method: 'post',
                            url: `<?php echo URL::asset('admin/areas') ?>`,
                            data: data,
                            config: { headers: {'Content-Type': 'multipart/form-data' }}
                        })
                            .then(function (response) {
                                //handle success
                                //window.location = '<?php echo URL::asset('/admin/areas') ?>';
                            })
                            .catch(function (response) {
                                //handle error
                                console.log(response);
                            });
                    }
                },
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
                axios.get(`<?php echo URL::asset('/icons/areas') ?>`)
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

    <script>
        $(function() {
            $('#type').change(function() {
                app.multiple=!app.multiple;
            });

            $('#mode').change(function() {
                app.mode=!app.mode;
            });


        });
    </script>
@stop
