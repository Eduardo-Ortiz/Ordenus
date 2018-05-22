@extends('admin.layouts.panel')


@section('content')
    <link rel="stylesheet" href="{{ URL::asset('css/icon-selector.css') }}" />

    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap-select.min.css') }}" />




    <div id="app" class="col-lg-12">
        <h1 class="page-header">Nueva Mesa</h1>

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

        <form method="POST" action="{{route('admin.tables.store')}}">
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-9">
                    <div  class="form-group">
                        <label for="name">Nombre de la Mesa:</label>
                        <input value="{{old('name')}}" id="name" name="name" class="form-control"> </input>
                    </div>
                </div>

                <div class="col-xs-3 col-sm-3 col-md-3">
                    <div class="form-group">
                        <label for="ingredient">Activiada:</label>
                        <input style="padding: 32px !important;" checked="checked" type="checkbox" data-toggle="toggle" data-on="Si" id="enabled" name="enabled"
                               data-off="No" data-onstyle="default" data-width="100%">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <button type="submit"  class="btn btn-success btn-lg"><i class="fa fa-floppy-o fa-fw"></i>Guardar Mesa</button>
                </div>
            </div>
        </form>
    </div>
@stop


@section('footer')
    <script type="text/javascript" src="{{URL::asset('js/bootstrap-select.min.js')}}"></script>

    <script>
        var app = new Vue({
            el: '#app',
            data: {


            },
            methods: {


            }

        })
    </script>
@stop
