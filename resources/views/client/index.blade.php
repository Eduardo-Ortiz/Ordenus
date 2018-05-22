<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="theme-color" content="#f7b630">

    <title>Ordenus - Admin Panel</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('favicon.ico') }}" >
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}" />

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}" />

    <link rel="stylesheet" href="{{ URL::asset('css/jquery-ui.min.css') }}" />

    <link rel="stylesheet" href="{{ URL::asset('css/raleway.css') }}" />

    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.offcanvas.css') }}" />

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


        .navbar-default {
            background-color: #f7b630;
            border-color: #e7e7e7;
            border-width: 0 0 1px;
        }
        .navbar-default .navbar-brand {
            color: #ffffff;
        }
        .navbar-default .navbar-brand:hover,
        .navbar-default .navbar-brand:focus {
            color: #ffffff;
        }
        .navbar-default .navbar-text {
            color: #ffffff;
        }
        .navbar-default .navbar-nav > li > a {
            color: #ffffff;
        }
        .navbar-default .navbar-nav > li > a:hover,
        .navbar-default .navbar-nav > li > a:focus {
            color: #ffffff;
        }
        .navbar-default .navbar-nav > .active > a,
        .navbar-default .navbar-nav > .active > a:hover,
        .navbar-default .navbar-nav > .active > a:focus {
            color: #ffffff;
            background-color: #c98d11;
        }
        .navbar-default .navbar-nav > .open > a,
        .navbar-default .navbar-nav > .open > a:hover,
        .navbar-default .navbar-nav > .open > a:focus {
            color: #ffffff;
            background-color: #c98d11;
        }
        .navbar-default .navbar-toggle {
            border-color: #c98d11;
        }
        .navbar-default .navbar-toggle:hover,
        .navbar-default .navbar-toggle:focus {
            background-color: #c98d11;
        }
        .navbar-default .navbar-toggle .icon-bar {
            background-color: #ffffff;
        }
        .navbar-default .navbar-collapse,
        .navbar-default .navbar-form {
            border-color: #ffffff;
        }
        .navbar-default .navbar-link {
            color: #ffffff;
        }
        .navbar-default .navbar-link:hover {
            color: #ffffff;
        }

        .navbar-offcanvas {
            color: #ffffff;
            background-color: #f7b630 !important;
        }

        .navbar-brand {
            padding: 0px;
        }
        .navbar-brand>img {
            height: 100%;
            padding: 2px;
            padding-left: 10px;
            padding-right: 10px;
            width: auto;
        }

        @media (max-width: 767px) {
            .navbar-default .navbar-nav .open .dropdown-menu > li > a {
                color: #ffffff;
            }
            .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
            .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
                color: #ffffff;
            }
            .navbar-default .navbar-nav .open .dropdown-menu > .active > a,
            .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover,
            .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus {
                color: #ffffff;
                background-color: #c98d11;
            }
        }


        .center-crop {
            width:  100%; /*or 70%, or what you want*/
            height: 100%; /*or 70%, or what you want*/
            object-fit: cover;
            -webkit-box-shadow: 10px 10px 5px -10px rgba(0,0,0,0.26);
            -moz-box-shadow: 10px 10px 5px -10px rgba(0,0,0,0.26);
            box-shadow: 10px 10px 5px -10px rgba(0,0,0,0.26);
            border-top: 1px solid #ddd;
        }

        .center-crop-product {
            width:  100px; /*or 70%, or what you want*/
            height: 100px; /*or 70%, or what you want*/
            object-fit: cover;
            border-right: 1px solid #ddd;

        }

        .center-crop-add {
            width:  100px; /*or 70%, or what you want*/
            height: 100px; /*or 70%, or what you want*/
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .center-crop-info {
            width:  100%; /*or 70%, or what you want*/
            height: 155px; /*or 70%, or what you want*/
            object-fit: cover;
        }

        .center-crop-edit {
            width:  100%; /*or 70%, or what you want*/
            height: 60px; /*or 70%, or what you want*/
            object-fit: cover;
        }

        .tittle {
            text-align: left;
            margin-top: 2px;
            margin-bottom: 2px;
            margin-left: 2px;
            font-size: 14px;
            font-weight: 600;
            color: black !important;
        }

        .text {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            line-height: 16px;     /* fallback */
            max-height: 32px;      /* fallback */
            -webkit-line-clamp: 2; /* number of lines to show */
            -webkit-box-orient: vertical;
            font-size: 12px;
        }



        .button-3d {
            font-size: 14px;
            text-align: center;
            cursor: pointer;
            width: 65px;
            color: #000;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 3px #999;
            border: 1px solid #ddd;
        }

        .button-3d:hover {
            background-color: #f1f1f1
        }

        .button-3d:active {
            background-color: #dcdcdc;
            box-shadow: 0 3px #666;
            transform: translateY(1px);
        }

        .modal-dialog {
            position:absolute;
            top:50% !important;
            transform: translate(0, -50%) !important;
            -ms-transform: translate(0, -50%) !important;
            -webkit-transform: translate(0, -50%) !important;
            margin:auto 5%;
            width:90%;
            height:80%;
        }
        .modal-content {
            min-height:100%;
            position:absolute;
            top:0;
            bottom:0;
            left:0;
            right:0;
        }
        .modal-body {
            position:absolute;
            top:45px; /** height of header **/
            bottom:45px;  /** height of footer **/
            left:0;
            right:0;
            overflow-y:auto;
        }
        .modal-footer {
            position:absolute;
            bottom:0;
            left:0;
            right:0;
        }

        .circle {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            font-size: 14px;
            color: #fff;
            text-align: center;
            background: #F44336;
            font-weight: 500;

        }

        .navigation-button {
            width: 44px;
            height: 34px;
            padding: 0;
            border: 1px solid #c98d11;
            float : none
        }

        .navigation-button:hover {
            background-color: #c98d11;
        }

        .orderpading {
            padding-bottom: 115px !important;
        }
    </style>

</head>

<body>


<div id="app">

    <div v-if="compatible">
        <div v-if="config">
            <div class="container">
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
        <div v-if="menu">

            <div id="addProductModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div v-if="selectedProduct" style="text-align: center;margin-top: 5px">
                            <span style="color:black;font-size: 28px;font-weight: 600">Agregar al Carrito</span><br>
                            <span style="color:black;font-size: 17px;font-weight: 800">@{{selectedProduct.name}}</span>
                            <div style="text-align: left;margin-top: 5px;padding-left: 10px;padding-right: 10px">
                                <div style="width: 100px; float: left;">
                                    <img class="center-crop-add" v-bind:src="imagesLink+'products_photos/'+selectedProduct.id+'.png'" >
                                </div>
                                <div style="text-align:center;padding-left: 10px;padding-right:0px;display: inline-block;position: relative;width: calc(100% - 100px);height: 100px">
                                   <span style="font-weight: 600;color:black"><i>Cantidad</i></span>
                                    <div>
                                        <div>
                                            <div style="width: 25%;float: left;text-align: center">
                                                <button :disabled="selectedQuantity==1" v-on:click="changeProductQuantity(-1)" style="width: 45px" class="button-3d">
                                                    <div>
                                                        <i style="padding: 0;color: #f7b630;font-size: 35px"  class="fa fa-minus-circle fa-sa"></i>
                                                    </div>
                                                </button>
                                            </div>
                                            <div style="width: 50%;float: left;margin-top: -3px">
                                                <span style="font-size: 32px;color: black"><strong>@{{selectedQuantity}}</strong></span>
                                            </div>
                                            <div style="width: 25%;float: left;text-align: center">
                                                <button v-on:click="changeProductQuantity(1)" style="width: 45px" class="button-3d">
                                                    <div>
                                                        <i style="padding: 0;color: #f7b630;font-size: 35px"  class="fa fa-plus-circle fa-sa"></i>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div style="width: 100%;text-align: left;margin-top: 5px">
                                            <span style="font-weight: 600;color:black;padding-top: 12px"><i>Total:</i></span>&nbsp;<span style="font-size: 20px;color:#F44336;font-weight: 700">$@{{selectedProduct.price*selectedQuantity}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="position: absolute;bottom: 10px;width: 100%">
                            <div style="width: 50%;float: left;text-align: center">
                                <button type="button" v-on:click="closeAddProduct()" style="width: 120px" class="button-3d">
                                    <div>
                                        <span style="font-weight: 600;color:black"><i>Cancelar</i></span><br>
                                        <i style="padding: 0;color: #f7b630;font-size: 35px"  class="fa fa-window-close fa-sa"></i>
                                    </div>
                                </button>
                            </div>
                            <div style="width: 50%;float: left;text-align: center">
                                <button v-on:click="confirmProduct()" style="width: 120px" class="button-3d">
                                    <div>
                                        <span style="font-weight: 600;color:black"><i>Confirmar</i></span><br>
                                        <i style="padding: 0;color: #f7b630;font-size: 35px"  class="fa fa-check-square fa-sa"></i>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="infoProductModal" class="modal fade" role="dialog">
                <div v-if="selectedProduct" class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <img class="center-crop-info" v-bind:src="imagesLink+'products_photos/'+selectedProduct.id+'.png'" >
                        <div style="text-align: center;margin-top: 5px">
                            <span style="color:black;font-size: 17px;font-weight: 800">@{{selectedProduct.name}}</span>
                            <div style="text-align: left;padding-right: 10px;padding-left: 10px">
                                <span style="font-size: 14px">@{{selectedProduct.description}}</span>
                            </div>

                        </div>





                        <div style="position: absolute;bottom: 10px;width: 100%">
                            <div style="text-align: center;margin-bottom: 5px">
                                <span style="font-size: 16px"><i>Tiempo Aproximado : 15 Minutos</i></span>
                            </div>
                            <div style="width: 30%;float: left;text-align: center">
                                <button v-on:click="closeInfoProduct()" style="width: 90px" class="button-3d">
                                    <div>
                                        <span style="font-weight: 600;color:black;font-size: 14px"><i>Cerrar</i></span><br>
                                        <i style="padding: 0;color: #f7b630;font-size: 28px"  class="fa fa-window-close fa-sa"></i>
                                    </div>
                                </button>
                            </div>
                            <div style="width: 30%;float: left;text-align: center">
                                <button v-on:click="addProductFromInfo()" style="width: 90px" class="button-3d">
                                    <div>
                                        <span style="font-weight: 600;color:black;font-size: 14px"><i>Agregar</i></span><br>
                                        <i style="padding: 0;color: #f7b630;font-size: 28px"  class="fa fa-cart-plus fa-sa"></i>
                                    </div>
                                </button>
                            </div>
                            <div style="width: 40%;float: left;text-align: right;padding-top: 9px;padding-right: 10px">
                                <span style="font-size: 26px;color:#F44336;font-weight: 700">$@{{selectedProduct.price}}</span>
                            </div>
                        </div>




                    </div>
                </div>
            </div>

            <div class="body-offcanvas">
            <header class="clearfix">
                <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <a class="navbar-brand"><img style="margin-top: -1px" src="{{ URL::asset('images/logo_admin.png') }}" alt="Ordenus">
                            </a>




                            <button type="button" class="navbar-toggle offcanvas-toggle pull-right" data-toggle="offcanvas" data-target="#js-bootstrap-offcanvas" style="float:left;">
                                <span class="sr-only">Toggle navigation</span>
                                <span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                        </span>
                            </button>

                            <button v-on:click="explore=false;order=true" type="button" class="navbar-toggle pull-right" data-toggle="offcanvas" style="float:left;width: 44px;height: 34px;padding: 0">
                                <i style="padding: 0;color: white;font-size: 22px"  class="fa fa-shopping-cart fa-sa"></i>
                                <div v-if="cart.length>0" class="circle" style="position: absolute;top:-7px;right: -7px">@{{cart.length}}</div>
                            </button>
                        </div>
                        <div class="navbar-offcanvas navbar-offcanvas-touch" id="js-bootstrap-offcanvas">
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="#">Link</a></li>
                                <li><a href="#">Link</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle">Another Link <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">Separated link</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#">One more separated link</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>
            <div style="padding-top: 65px;padding-bottom: 65px" v-bind:class="{ orderpading: order }" class="container">
                <div v-if="explore" class="row">
                    <div v-for="category in categories" style="padding-left: 5px;padding-right: 5px" class="col-md-4 col-sm-4 col-xs-4">
                        <div v-on:click="getCategoryData(category.id)" class="panel panel-default">
                            <div style="padding: 0px" class="panel-body">
                                <div class="tittle">
                                    @{{category.name}}
                                </div>
                                <img v-bind:src="imagesLink+'menu_categories_photos/'+category.id+'.png'" class="center-crop">
                            </div>
                        </div>
                    </div>
                    <div v-for="(product,index) in products" style="padding-left: 5px;padding-right: 5px" class="col-md-12 col-sm-12 col-xs-12">
                        <div class="panel panel-default">
                            <div style="padding: 0px" class="panel-body">
                                <div style="width: 100px; float: left;"> <img v-bind:src="imagesLink+'products_photos/'+product.id+'.png'" class="center-crop-product"> </div>
                                <div style="padding-left: 10px;padding-right:10px;display: inline-block;position: relative;width: calc(100% - 120px);height: 100px">
                                    <span style="color:black;font-weight: 700;font-size: 15px">@{{product.name}}</span>
                                    <span class="text">@{{product.description}}</span>
                                    <div style="position:absolute;bottom:5px;width: 100%">
                                    <button v-on:click="addProduct(index)" style="margin-top: 2px" class="button-3d">
                                        <span style="font-size: 10px;color:#81878d;font-weight: 600"><i>Agregar</i></span>
                                        <div style="margin-top: -4px">
                                            <i style="padding: 0;color: #f7b630"  class="fa fa-shopping-cart fa-sa"></i>
                                        </div>
                                    </button>
                                    <button v-on:click="infoProduct(index)" class="button-3d">
                                        <span style="font-size: 10px;color:#81878d;font-weight: 600"><i>Información</i></span>
                                        <div style="margin-top: -4px">
                                            <i style="padding: 0;color: #f7b630"  class="fa fa-info-circle fa-sa"></i>
                                        </div>
                                    </button>
                                        <div style="float:right;margin-right: 15px;padding-top:8px;">
                                            <span style="font-size: 20px;color:#F44336;font-weight: 600">$@{{product.price}}</span>
                                        </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <div v-if="order">

                    <div>
                        <div style="text-align: center;margin-bottom: 5px">
                            <span style="font-size: 24px;color:black;font-weight: 600">Mi Orden</span>
                        </div>
                        <div v-for="(product,index) in cart" style="padding-left: 5px;padding-right: 5px;" class="col-md-12 col-sm-12 col-xs-12">
                            <div class="panel panel-default" style="margin-bottom: 5px !important;">
                                <div style="padding: 0px" class="panel-body">
                                    <div style="width: 60px; float: left;"> <img v-bind:src="imagesLink+'products_photos/'+product.id+'.png'" class="center-crop-edit"> </div>
                                    <div style="padding-left: 10px;padding-right:10px;display: inline-block;position: relative;width: calc(100% - 80px);height: 60px">
                                        <span style="color:black;font-weight: 700;font-size: 13px">@{{product.name}}</span><br>
                                        <span style="color:black;font-weight: 700;font-size: 13px">Cantidad: @{{product.quantity}}</span><br>
                                        <span style="font-size: 15px;color:#F44336;font-weight: 700">$@{{product.price*product.quantity}}</span>
                                        <button v-on:click="addProduct(index)" style="position:absolute;bottom: 5px;right: -15px" class="button-3d">
                                            <span style="font-size: 10px;color:#81878d;font-weight: 600"><i>Editar</i></span>
                                            <div style="margin-top: -4px">
                                                <i style="padding: 0;color: #f7b630"  class="fa fa-pencil-square-o fa-sa"></i>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>












            </div>
        </div>



                <div v-if="order" style="overflow: hidden;position: fixed;bottom: 50px;width: 100%;height: 50px;background: #fff;">
                    <div style="width: 70%;float: left;text-align: center">
                        <button v-on:click="sendOrder()" style="width: 185px;height: 40px;margin-top: 3px" class="button-3d">
                            <span style="font-size: 17px;color:#81878d;font-weight: 600"><i>Confirmar Orden</i></span>
                            <i style="padding: 0;font-size: 20px;color: #f7b630"  class="fa fa-check-circle fa-sa"></i>
                        </button>
                    </div>
                    <div style="width: 30%;float: left;">
                        <span style="font-size: 11px;font-weight: 600;color: black"><i>Total:</i></span><br>
                        <span style="color:#F44336;font-size: 20px;font-weight: 600">$@{{total}}</span>
                    </div>


                </div>

            <div style="overflow: hidden;position: fixed;bottom: 0;width: 100%;background-color: #f7b630;height: 50px;    border-top: 1px solid #e7e7e7;">
                <div style="width: 33%;float: left;text-align: center !important">
                    <button type="button" class="navbar-toggle navigation-button">
                        <i style="padding: 0;color: white;font-size: 22px"  class="fa fa-times-circle fa-sa"></i>
                    </button>
                </div>
                <div style="width: 33%;float: left;text-align: center">
                    <button v-on:click="getMainCategory()" type="button" class="navbar-toggle navigation-button">
                        <i style="padding: 0;color: white;font-size: 22px"  class="fa fa-home fa-sa"></i>
                    </button>
                </div>
                <div style="width: 33%;float: left;" class="text-center">
                    <button type="button" class="navbar-toggle navigation-button">
                        <i style="padding: 0;color: white;font-size: 22px"  class="fa fa-chevron-circle-left fa-sa"></i>
                    </button>
                </div>
            </div>






    </div>

    <div v-else>
        <div class="container">
            <div style="text-align: center;margin-top: 40px">
                <img style="margin-top: 30px" height="80px" src="{{ URL::asset('images/logo_admin.png') }}" alt=""><br>
                <i style="font-size: 50px;margin-top: 20px;margin-bottom: -10px" class="fa fa-exclamation-triangle fa-sa"></i><br>
                <span style="font-size: 34px"><b>Error</b></span><br>
                <span style="font-size: 18px">El navegador del dispositivo no es compatible con esta aplicación.</span>
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

<script type="text/javascript" src="{{URL::asset('js/bootstrap.offcanvas.js')}}"></script>





<script>



        var app = new Vue({
        el: '#app',
        data: {
            imagesLink : null,

            compatible : null,
            config : null,

            unassignedTables : null,
            selectedTable : null,

            menu : null,
            explore : null,
            order : null,

            categories : [],
            products : [],

            selectedProduct : null,
            selectedQuantity : 1,

            cart : [],
            total : 0.00
        },
        methods: {
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
            },
            getCategoryData : function (categoryId)
            {
                axios.get(`<?php echo URL::asset('category/childs/') ?>`+"/"+categoryId)
                    .then(response => {
                        app.categories = response.data;
                    });

                axios.get(`<?php echo URL::asset('category/products/') ?>`+"/"+categoryId)
                    .then(response => {
                        app.products = response.data;
                    });
            },
            getMainCategory : function ()
            {
                this.explore = true;
                this.order = false;
                this.products = null;
                axios.get(`<?php echo URL::asset('category/main') ?>`)
                    .then(response => {
                        this.categories = response.data;
                        app.$forceUpdate();
                    });
            },
            addProduct : function (index)
            {
                this.selectedQuantity = 1;
                this.selectedProduct = this.products[index];
                $('#addProductModal').modal('show');
                app.$forceUpdate();
            },
            closeAddProduct : function ()
            {
                $('#addProductModal').modal('hide');
                app.$forceUpdate();
            },
            changeProductQuantity : function (value)
            {
                this.selectedQuantity += value;
            },
            infoProduct : function (index)
            {
                this.selectedProduct = this.products[index];
                $('#infoProductModal').modal('show');
                app.$forceUpdate();
            },
            closeInfoProduct : function ()
            {
                $('#infoProductModal').modal('hide');
                app.$forceUpdate();
            },
            confirmProduct : function ()
            {
                var product =  Object.assign({}, this.selectedProduct);
                product.quantity = this.selectedQuantity;
                this.cart.push(product);
                $('#addProductModal').modal('hide');
                app.$forceUpdate();
                this.total += this.selectedQuantity*product.price;
            },
            addProductFromInfo : function ()
            {
                $('#infoProductModal').modal('hide');
                this.selectedQuantity = 1;
                $('#addProductModal').modal('show');
                app.$forceUpdate();
            },
            sendOrder : function ()
            {
                axios.post('<?php echo URL::asset('orders/send') ?>', {
                    test : 1
                }) .then(response => {

                });
            }
        },
        mounted: function (){
            this.imagesLink = `<?php echo URL::asset('images') ?>`+"/";

            if (localStorage) {
                this.compatible = true;
                if(localStorage.getItem('activated')===null)
                {
                    this.config = true;
                    this.getUnassignedTables();
                }
                else
                {
                    this.getMainCategory();
                    this.menu = true;
                }
            } else {
                this.compatible = false;
            }
        },
            created () {

            },
    })
</script>


</body>



</html>