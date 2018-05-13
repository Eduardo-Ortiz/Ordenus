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


    </style>

    <div id="app" class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Areas de Trabajo</h1>

            @if(session()->has('status'))
                <div class="alert alert-success fade in alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{session('status')}}
                </div>
            @endif

            @if(count($areas))
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 68px">Icono</th>
                        <th>Nombre</th>
                        <th style="width: 10px">Modo</th>
                        <th style="width: 10px">Tipo</th>
                        <th style="width: 10px">Detalle</th>
                        <th style="width: 10px">Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($areas as $area)
                        <tr>
                            <td style="text-align: center"><img height="25px" src="{{URL::asset('/images/icons/mini')."/".$area->icon_id.".png"}}" alt=""></td>
                            <td>{{$area->name}}</td>
                            <td>@if($area->touch) Touch  @else Normal @endif</td>
                            <td>@if($area->multiple) Multiple @else Simple @endif</td>
                            <td style="text-align: center">
                                <a href="{{route('admin.areas.edit', $area->id)}}" class="btn btn-default btn-xs">Ver Detalle</a>
                            </td>
                            <td class="table-fix"><button @click="askDelete('{{$area->name}}',{{$area->id}})" class="btn btn-danger btn-xs">Eliminar Area</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <h4>No hay ninguna area de trabajo creada. Visita la <a href="{{url('admin/areas/create')}}">Pagina de Creación</a> para agregar una nueva area de trabajo.</h4>
            @endif
        </div>

        <!-- Modal -->
        <div id="deleteModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content bigModal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Eliminar el area "@{{selectionName}}"</h4>
                    </div>
                    <div class="modal-body">
                        <h2>¿Desea eliminar el area @{{selectionName}}?</h2>
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
                this.deleteLink = '<?php echo route('admin.areas.index')?>';
            }
        })
    </script>
@stop
