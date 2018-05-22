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

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css?family=Passion+One" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{URL::asset('js/html5shiv.js')}}"></script>
    <script type="text/javascript" src=" {{URL::asset('js/respond.min.js')}}"></script>
    <![endif]-->
    <script src="{{URL::asset('js/app.js')}}"> </script>

</head>

<body>


        <style>
            html, body {
                height: 100%;
            }

            #top-bar {
                height: 100px;
                background-color: #f7b630;
                box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
                z-index: 1000;
            }

            #container {
                background-color: #DDDDDD;
                position: absolute;
                top: 101px;
                bottom: 0;
                width:100%;
            }

            #work-panel {
                background-color: #DDDDDD;
                position: absolute;
                float: left;
                top: 100px;
                bottom: 0;
                width:220px;
            }

            #side-panel {
                position: absolute;
                left: 0;
                top: 0;
                bottom: 0;
                width: 250px;
                background-color: #f8f6f6;
                overflow-y: auto;
                box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
                z-index: 2000;

            }

            #orders {
                position: absolute;
                left: 250px;
                top: 0;
                bottom: 0;
                right: 0;
                background-color: white;
                padding-bottom: 16px;
            }

            .order {
                width: 230px !important;
                max-height: 280px !important;
                margin-left: 9px;
                margin-top: 5px;
                margin-bottom: 8px !important;
            }

            .order-card {
                margin-top: 5px;
                margin-right: 5px;
                margin-left: 5px;
                margin-bottom: 5px;
                padding: 0 !important;
                cursor: pointer;
            }

            .order-time {
                padding-top:4px;
                width: 35%;
                height: 100px;
                float:left;
                text-align: center;
                color: white;
            }

            .order-card-body {
                padding: 0;
                font-size: 16px;
            }

            .order-data {
                width: 65%;
                height: 100px;
                float:left;
                padding-left: 6px;
            }

            .order-header {
                height: 19px;
                border-bottom: 1px solid #dddddd;
                color: white;
                font-size: 12px;
                padding-top: 1px;
                padding-left: 5px;
                box-shadow: 0 1px 2px 0 rgba(0,0,0,0.15);
            }

            .product {
                min-height: 54px;
                font-size: 13px;
                border-top:1px solid #dddddd;
                padding-left: 7px
            }

            .draggable {
                width: 250px !important;
                max-height: 300px !important;
                cursor: move;
                float: left;
                position: absolute;
            }

            .red-background {
                background-color: #F44336;
            }

            .yellow-background {
                background-color: #FBC02D;
            }

            .green-background {
                background-color: #4CAF50;
            }

            .button {
                background-color: #f8f6f6;
                color: black;
                padding-top: 0;
                padding-left: .5px;

                border: 1px solid #dddddd;
                width: 17px;
                height: 17px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 11px;
                margin: 4px 2px;
                border-radius: 50px;
                cursor: pointer;
            }

            .button:hover {
                transform: scale(1.25);
            }

            .close-button:hover {
                background-color: #e81123;
                color:white;
                -webkit-transition: background-color .25s linear;
                -ms-transition: background-color .25s linear;
                transition: background-color .25s linear;
            }

            .close-icon:after {
                content: '✖'; /* UTF-8 symbol */
            }

            .minimize-icon:after {
                content: '⚊'; /* UTF-8 symbol */

            }

            .alert-text {
                -webkit-animation:redglow 4s;
                -webkit-animation-iteration-count: infinite;
            }

            @keyframes redglow
            {
                0%   { color: #4a4a4a }
                40% { color: #ff3860; }
                100%   { color: #4a4a4a }
            }

            @-webkit-keyframes redglow /* Safari and Chrome */
            {
                0%   { color: #4a4a4a }
                40% { color: #ff3860; }
                100%   { color: #4a4a4a }
            }
        </style>

        <div id="app">
            <div id="top-bar">
                <img style="margin-left: 10px;margin-top: 10px" height="80px" src="{{ URL::asset('images/logo_admin.png') }}" alt="">


                <div style="position: absolute;top: 20px;right: 10px" class="panel panel-default">
                    <div class="panel-body">
                        <img style="width: 25px;height: 25px" src="{{URL::asset('images/icons/normal')}}/{{Auth::user()->area->icon_id}}.png" alt="">
                        <div style="float: right;margin-top: 3px">
                            <span style="font-size: 17px;margin-top: 2px"><strong>{{Auth::user()->area->name}}</strong></span>
                        </div>
                    </div>
                </div>

            </div>

            <div id="container">

                <div id="side-panel">

                    <div v-for="(order,index) in orders" class="panel panel-default order-card" @click="openOrder(index)">
                        <div  class="panel-body order-card-body">
                            <div class="order-time red-background">
                                <i style="">Hace<br><span style="font-size: 34px"><strong>@{{order.time}}</strong></span><br>Minutos</i>
                            </div>
                            <div class="order-data">
                                <span style="font-size: 21px"><strong>Mesa 1</strong></span><br>
                                <span>Orden #@{{order.id}}</span><br>
                                <span>Proceso: 10 Min</span><br>
                                <span>Platillos: 1</span>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="orders">
                    <div class="draggable" v-for="(data,index) in work">
                        <div v-if="data!=null" class="panel panel-default">
                            <div @click="remove(index)" class="button close-button" style="position:absolute; top: 0;right: 1px;display:inline-block">
                                <span class="close-icon"></span>
                            </div>
                            <div class="button" style="position:absolute; top: 0;right: 21px;display:inline-block">
                                <i class="fa fa-window-maximize fa-fw"></i>
                            </div>
                            <div @click="minimize(index)" class="button" style="position:absolute; top: 0;right: 41px;display:inline-block">
                                <span class="minimize-icon"></span>
                            </div>

                            <div  class="panel-body order-card-body">
                                <div style="text-align: center;font-size: 13px;margin-top: 5px"><b>Orden #@{{data.id}}</b></div>
                                <div class="panel panel-default order">
                                    <div  class="panel-body order-card-body">
                                        <div class="order-header red-background">
                                            <i><b>Enviada hace 16 Minutos</b></i>
                                        </div>

                                        <div style="height: 60px">
                                            <span style="padding-left: 7px">Mesa: 1</span>
                                            <button style="padding-left: 5px;padding-right: 5px" class="btn btn-default center-block"><strong>Marcar Orden Completada  <i class="fa fa-check fa-fw"></i></strong></button>
                                        </div>

                                        <div class="product">
                                            <span>Pedido #1</span><br>
                                            <span>Platillo: Test</span><br>
                                            <span>Cantidad: 1</span><br>
                                            <span class="alert-text" style="font-size: 11px;"> <i class="fa fa-exclamation-circle fa-fw"></i>Información Adicional del Pedido: </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div style="position: absolute;bottom: 0;width:100%;height:37px;left: 0;border-top:1px solid #dddddd;">

                        <div v-for="(data,index) in minimized" style="height: 36px;margin: 0;width: 175px;float: left" class="panel panel-default">

                            <div class="panel-body" style="padding: 0;position:relative">
                                <div class="button close-button" style="position:absolute; top: 0;right: 1px;display:inline-block">
                                    <span class="close-icon"></span>
                                </div>
                                <div class="button" style="position:absolute; top: 0;right: 21px;display:inline-block">
                                    <i class="fa fa-window-maximize fa-fw"></i>
                                </div>
                                <div @click="comeback(index)" class="button" style="position:absolute; top: 0;right: 41px;display:inline-block">
                                    <i class="fa fa-location-arrow fa-fw"></i>
                                </div>
                                <div style="height: 35px;width: 15px;border-radius:2px;border-right:1px solid #dddddd;position:absolute; top: 0;left: 0;display:inline-block" class="red-background">
                                </div>

                                <strong style="padding-left: 20px;margin-top:8px;font-size: 13px;display: block">Orden @{{data.id}}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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


    var user = <?php echo Auth::user() ?>

    var counter = 0;

    var app = new Vue({
        el: '#app',
        data: {
            orders : [],
            work : [],
            minimized : [],
            container : {
                height : 0,
                width : 0
            },
            id : 1,
            data : null
        },
        methods: {

            openOrder : function (index){
                cleanArray(this.work);
                this.work.push(this.orders[index]);
                this.orders.splice(index, 1);
                this.$nextTick(function () {
                    $( function() {
                        $( ".draggable" ).draggable();
                        $( ".draggable" ).draggable({ containment: "parent" });
                        var top = (45*counter) + 101, left = (45*counter) + 250;
                        if(top+350>app.container.height)
                        {
                            counter=0;
                            top = (45*counter) + 101;
                            left = (45*counter) + 250;
                        }
                        counter +=1;
                        $('#orders').children('.draggable').last().css({ top: top, left: left });
                    });
                })
                app.$forceUpdate();

            },
            remove : function (index) {
                counter-=1;
                this.work[index]=null;
                app.$forceUpdate();
            },
            minimize : function (index)
            {
                counter-=1;
                var backup = this.work[index];
                this.minimized.push(backup);
                this.work[index]=null;
                app.$forceUpdate();
            },
            comeback : function (index)
            {
                cleanArray(this.work);
                this.work.push(this.minimized[index]);
                this.minimized.splice(index, 1);
                this.$nextTick(function () {
                    $( function() {
                        $( ".draggable" ).draggable();
                        $( ".draggable" ).draggable({ containment: "parent" });
                        var top = (45*counter) + 101, left = (45*counter) + 250;
                        if(top+350>app.container.height)
                        {
                            counter=0;
                            top = (45*counter) + 101;
                            left = (45*counter) + 250;
                        }
                        counter +=1;
                        $('#orders').children('.draggable').last().css({ top: top, left: left });
                    });
                });
                app.$forceUpdate();
            }

        },
        mounted: function (){
            this.container.height=document.getElementById('orders').clientHeight;
            this.container.width=document.getElementById('orders').clientWidth;
        },
        created: function (){
            console.log('user-'+user.id);
            Echo.private('user-'+user.id)
                .listen('OrderSent', (e) => {
                    app.orders.push(e.order);
                    app.orders[app.orders.length-1].time = 0;
                });
        }
    })

    function cleanArray(actual) {
        var newArray = new Array();
        for (var i = 0; i < actual.length; i++) {
            if (actual[i]) {
                newArray.push(actual[i]);
            }
        }
        return newArray;
    }
</script>


</body>



</html>