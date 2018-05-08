<!DOCTYPE html>
<html lang="es">

<head>
    <meta  charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ordenus - Admin Panel</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('favicon.ico') }}" >
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" />

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}" />

    <link rel="stylesheet" href="{{ URL::asset('css/jquery-ui.min.css') }}" />

    <link href="https://fonts.googleapis.com/css?family=Passion+One" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{URL::asset('js/html5shiv.js')}}"></script>
    <script type="text/javascript" src=" {{URL::asset('js/respond.min.js')}}"></script>
    <![endif]-->

    <style>
        html, body {
            height: 100%;
            background-color: #f7b630;
            font-family: 'Passion One', cursive;
        }

        .btn-default:hover {
            transform: scale(1.18);
        }

        .btn-success {
            color: #ffffff !important;
            background-color: #f7b630 !important;;
            border-color: #DFA945 !important;
            letter-spacing: 1px;
            font-size: 20px;
        }

        .btn-success:hover,
        .btn-success:focus,
        .btn-success:active,
        .btn-success.active,
        .open .dropdown-toggle.btn-success {
            color: #ffffff !important;;
            background-color: #ae7e1a !important;;
            border-color: #ae7e1a !important;;
        }

        .btn-success:active,
        .btn-success.active,
        .open .dropdown-toggle.btn-success {
            background-image: none !important;;
        }

        .btn-success.disabled,
        .btn-success[disabled],
        fieldset[disabled] .btn-success,
        .btn-success.disabled:hover,
        .btn-success[disabled]:hover,
        fieldset[disabled] .btn-success:hover,
        .btn-success.disabled:focus,
        .btn-success[disabled]:focus,
        fieldset[disabled] .btn-success:focus,
        .btn-success.disabled:active,
        .btn-success[disabled]:active,
        fieldset[disabled] .btn-success:active,
        .btn-success.disabled.active,
        .btn-success[disabled].active,
        fieldset[disabled] .btn-success.active {
            background-color: #f7b630 !important;;
            border-color: #502039 !important;;
        }

        .btn-success .badge {
            color: #f7b630 !important;;
            background-color: #ffffff !important;;
        }
    </style>

</head>

<body>


<div id="app">
    <div style="text-align: center">
        <img style="margin-top: 30px" height="160px" src="{{ URL::asset('images/logo_admin.png') }}" alt="">
    </div>

    @if(!$area->multiple)
        <form method="POST" action="{{ URL::asset('control/orders/login')}}">
            @csrf
            <div style="text-align: center;margin-top: 30px" class="container">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div>
                            <span style="font-size: 40px">Ingrese el Codigo de Acceso</span><br>
                            <div style="text-align: center">
                                <span style="font-size: 26px">{{$area->name}}</span><br>
                                <img style="width: 100px;height: 100px" src="{{URL::asset('images/icons/normal')}}/{{$area->icon_id}}.png" alt="">
                            </div>
                            <div class="row" style="margin-bottom: 13px;margin-top: 10px">
                                <div class="col-md-4 col-md-offset-4">
                                    <input type="hidden" name="username" value="{{$area->name}}">
                                    <input style="font-size: 26px;text-align: center" type="password" v-model="name" id="password" name="password" class="form-control"> </input>
                                </div>
                            </div>
                            <div style="text-align: center">
                                <button style="font-size: 25px" type="submit" class="btn-lg btn btn-success"><i class="fa fa-sign-in fa-fw"></i> Ingresar</button> &nbsp;
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @else
        <div style="text-align: center;margin-top: 30px" class="container">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div style="text-align: center;">
                        <span style="font-size: 40px">Subareas de {{$area->name}}</span><br>
                        <div>
                            @foreach($area->getChilds as $subareas)
                                <a href="{{URL::asset('control/orders/login')}}/{{$subareas->id}}" style="width: 150px;height: 120px;margin-right: 10px;margin-left: 10px;margin-bottom: 13px" class="btn btn-default btn-lg">
                                    <span style="font-size: 21px">{{$subareas->name}}</span><br>
                                    <img style="width: 70px;height: 70px" src="{{URL::asset('images/icons/normal')}}/{{$subareas->icon_id}}.png" alt="">
                                </a>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif
</div>


</body>

<!-- jQuery -->
<script type="text/javascript" src="{{URL::asset('js/jquery.min.js')}}"></script>

<!-- jQuery -->
<script type="text/javascript" src="{{URL::asset('js/jquery-ui.min.js')}}"></script>

<!-- Bootstrap Core JavaScript -->
<script type="text/javascript" src="{{URL::asset('js/bootstrap.min.js')}}"></script>

<!-- Vue.js -->
<script type="text/javascript" src="{{URL::asset('js/vue.js')}}"></script>


<script type="text/javascript" src="{{URL::asset('js/axios.min.js')}}"></script>


<script>


    $( function() {
        $( ".draggable" ).draggable();
        $( ".draggable" ).draggable({ containment: "parent" });
    } );



    var counter = 0;

    var app = new Vue({
        el: '#app',
        data: {
            test : [],
            container : {
                height : 0,
                width : 0
            }

        },
        methods: {

            addData : function (){
                this.test.push(1);
                this.$nextTick(function () {
                    $( function() {
                        $( ".draggable" ).draggable();
                        $( ".draggable" ).draggable({ containment: "parent" });


                        var top = (45*counter) + 101, left = (45*counter) + 250;
                        counter +=1;


                        $('#orders').children('.draggable').last().css({ top: top, left: left });



                    });
                })

            },
            remove : function (index) {
                this.test.splice(index, 1);


            }

        },
        mounted: function (){
            this.container.height=document.getElementById('orders').clientHeight;
            this.container.width=document.getElementById('orders').clientWidth;
        }
    })
</script>


</body>



</html>