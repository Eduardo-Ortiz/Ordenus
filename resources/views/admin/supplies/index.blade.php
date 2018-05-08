@extends('admin.layouts.panel')


@section('content')
    <style>
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

    <div id="app" class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Insumos</h1>

            @if(session()->has('status'))
                <div class="alert alert-success fade in alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{session('status')}}
                </div>
            @endif

            @if(count($supplies))
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
                    @foreach($supplies as $supply)
                        <tr>
                            <td><img class="center-crop img-thumbnail" src="{{URL::asset('/images/supplies_photos/mini')."/".$supply->id.".png"}}" alt=""></td>
                            <td class="table-fix">{{$supply->name}}</td>
                            <td style="white-space:nowrap; !important" class="table-fix"><img style="height: 15px;width: 15px" src='{{URL::asset('/images/icons/mini')}}/{{$supply->suppliesCategory->icon_id}}.png' alt="">  {{$supply->suppliesCategory->fullname}}</td>
                            <td class="table-fix">{{$supply->unit->name}}&nbsp;({{$supply->unit->abreviation}})</td>
                            <td class="table-fix" style="text-align: center">
                                <a href="{{route('admin.supplies.edit', $supply->id)}}" class="btn btn-default btn-xs">Ver Detalle</a>
                            </td>
                            <td class="table-fix"><button @click="askDelete('{{$supply->name}}',{{$supply->id}})" class="btn btn-danger btn-xs">Eliminar Insumo</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <h4>No hay ninguna categoría creada. Visita la <a href="{{url('admin/supplies/create')}}">Pagina de Creación</a> para agregar una nueva categoría.</h4>
            @endif
        </div>

        <!-- Modal -->
        <div id="deleteModal" class="modal fade" role="dialog">
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

    </div>



@stop


@section('footer')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                selectionName : null,
                deleteLink : null,
                action : null
            },
            methods: {
                askDelete: function(name,id){
                    this.selectionName = name;
                    $('#deleteModal').modal('show');
                    this.action = this.deleteLink+"/"+id;
                }
            },
            mounted: function (){
                this.deleteLink = '<?php echo route('admin.supplies.index')?>';
            }
        })
    </script>
@stop
