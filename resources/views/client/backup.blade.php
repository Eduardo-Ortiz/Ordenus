<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather PWA</title>
    <link rel="stylesheet" type="text/css" href="styles/inline.css">

    <title>Ordenus - Admin Panel</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('favicon.ico') }}" >
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" />

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}" />

    <link rel="stylesheet" href="{{ URL::asset('css/jquery-ui.min.css') }}" />

    <link rel="stylesheet" href="{{ URL::asset('css/raleway.css') }}" />

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
            background-color: #ffffff;
            font-family: 'Raleway';
            color : #5c5c5c;
        }
    </style>

</head>

<body>


<div id="app">


    <div class="container ">

        <div v-if="compatible">
            <div v-if="config">
                <div style="text-align: center;margin-top: 40px">
                    <img style="margin-top: 30px" height="80px" src="{{ URL::asset('images/logo_admin.png') }}" alt=""><br>
                    <i style="font-size: 50px;margin-top: 20px;margin-bottom: -10px" class="fa fa-cogs fa-sa"></i><br>
                    <span style="font-size: 34px"><b>Configuración</b></span><br>
                    <div style="margin-top: 5px">
                        <span style="font-size: 18px">Seleccione la mesa a la que esta ligada este dispositivo.</span>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="form-group">
                                    <select v-if="unassignedTables.length>0" style="font-size: 18px" v-model="selectedTable" class="form-control" id="sel1">
                                        <option v-bind:value="table.id" v-for="table in unassignedTables">@{{table.name}}</option>
                                    </select>
                                    <div v-else>
                                        No hay mesas sin asignar registradas
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="text-align: center">
                                <button :disabled="unassignedTables.length===0" v-on:click="selectTable()" type="button" class="btn btn-default btn-lg"><i class="fa fa-check-circle fa-fw"></i> Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-else>
            <div style="text-align: center;margin-top: 40px">
                <img style="margin-top: 30px" height="80px" src="{{ URL::asset('images/logo_admin.png') }}" alt=""><br>
                <i style="font-size: 50px;margin-top: 20px;margin-bottom: -10px" class="fa fa-exclamation-triangle fa-sa"></i><br>
                <span style="font-size: 34px"><b>Error</b></span><br>
                <span style="font-size: 18px">El navegador del dispositivo no es compatible con esta aplicación.</span>
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
    var app = new Vue({
        el: '#app',
        data: {
            compatible : null,
            config : null,

            unassignedTables : null,
            selectedTable : null


        },
        methods: {
            remove : function () {

            },
            getUnassignedTables : function() {
                axios.get(`<?php echo URL::asset('tables/unassigned') ?>`)
                    .then(response => {
                        this.unassignedTables = response.data;
                    });
            },
            selectTable : function ()
            {
                axios.post('<?php echo URL::asset('tables/assign') ?>', {
                    table_id : app.selectedTable
                }) .then(response => {
                    localStorage.setItem('activated', true);
                    localStorage.setItem('table_id', app.selectedTable);
                    localStorage.setItem('device_id', response.data);
                });
            }
        },
        mounted: function (){
            if (localStorage) {
                this.compatible = true;
                if(localStorage.getItem('activated')===null)
                {
                    this.config = true;
                    this.getUnassignedTables();
                }
                else
                {

                }
            } else {
                this.compatible = false;
            }
        }
    })
</script>


</body>



</html>