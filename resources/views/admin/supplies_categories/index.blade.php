@extends('admin.layouts.panel')


@section('content')
    <div id="app" class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Categorias de Insumos</h1>

            @if(session()->has('status'))
                <div class="alert alert-success fade in alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{session('status')}}
                </div>
            @endif

            @if(count($categories))
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
                    @foreach($categories as $category)
                        <tr>
                            <td style="text-align: center"><img height="25px" src="{{URL::asset('/images/icons/mini')."/".$category->icon_id.".png"}}" alt=""></td>
                            <td>{{$category->name}}</td>
                            <td>{{$category->fullname}}</td>
                            <td style="text-align: center">{{$category->getChildsNumber()}}</td>
                            <td style="text-align: center">{{$category->supplies->count()}}</td>
                            <td style="text-align: center">
                                <a href="{{route('admin.supplies-categories.edit', $category->id)}}" class="btn btn-default btn-xs">Ver Detalle</a>
                            </td>
                            <td class="table-fix"><button @click="askDelete('{{$category->name}}',{{$category->id}})" class="btn btn-danger btn-xs">Eliminar Categoría</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <h4>No hay ninguna categoría creada. Visita la <a href="{{url('admin/supplies-categories/create')}}">Pagina de Creación</a> para agregar una nueva categoría.</h4>
            @endif
        </div>


        <!-- Modal -->
        <div id="deleteModal" class="modal fade" role="dialog">
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
            mounted: function(){
                this.deleteLink = '<?php echo route('admin.supplies-categories.index')?>';
            }
        })
    </script>
@stop
