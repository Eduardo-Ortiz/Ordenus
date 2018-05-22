@extends('admin.layouts.panel')


@section('content')
    <div id="app" class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Mesas</h1>

            @if(session()->has('status'))
                <div class="alert alert-success fade in alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{session('status')}}
                </div>
            @endif

            @if(count($tables))
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th style="width: 10px">Detalle</th>
                        <th style="width: 10px">Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tables as $table)
                        <tr>
                            <td class="table-fix">{{$table->name}}</td>
                            <td class="table-fix">@if($table->enabled==1)Activada @else Desactivada @endif</td>
                            <td class="table-fix" style="text-align: center">
                                <a href="{{route('admin.menu-categories.edit', $table->id)}}" class="btn btn-default btn-xs">Ver Detalle</a>
                            </td>
                            <td class="table-fix"><button @click="askDelete('{{$table->name}}',{{$table->id}})" class="btn btn-danger btn-xs">Eliminar Mesa</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <h4>No hay ninguna mesa creada. Visita la <a href="{{url('admin/tables/create')}}">Pagina de Creación</a> para agregar una nueva mesa.</h4>
            @endif
        </div>

        <!-- Modal -->
        <div id="deleteModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content bigModal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Eliminar la mesa "@{{selectionName}}"</h4>
                    </div>
                    <div class="modal-body">
                        <h2>¿Desea eliminar la mesa @{{selectionName}}?</h2>
                        <h4>Nota: Esta acción no podra revertirse.</h4>
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
                this.deleteLink = '<?php echo route('admin.tables.index')?>';
            }
        })
    </script>
@stop
