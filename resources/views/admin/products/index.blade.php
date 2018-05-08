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
            <h1 class="page-header">Productos</h1>

            @if(session()->has('status'))
                <div class="alert alert-success fade in alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {{session('status')}}
                </div>
            @endif

            @if(count($products))
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
                    @foreach($products as $product)
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
                            <td class="table-fix"><button @click="askDelete('{{$product->name}}',{{$product->id}})" class="btn btn-danger btn-xs">Eliminar Insumo</button></td>
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
                this.deleteLink = '<?php echo route('admin.products.index')?>';
            }
        })
    </script>
@stop
