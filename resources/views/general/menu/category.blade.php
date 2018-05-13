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

        .center-crop {
            width:  100%; /*or 70%, or what you want*/
            height: 165px; /*or 70%, or what you want*/
            object-fit: cover;
            -webkit-box-shadow: 10px 10px 5px -10px rgba(0,0,0,0.26);
            -moz-box-shadow: 10px 10px 5px -10px rgba(0,0,0,0.26);
            box-shadow: 10px 10px 5px -10px rgba(0,0,0,0.26);
            border : 1px solid #f5f5f5 !important;
        }

        .overlay {
            display:none;
        }

        .item {
            position:relative;
            display:inline-block;
            cursor: pointer;
        }

        .item:hover .overlay {
            width:100%;
            height:100%;
            background:rgba(0,0,0,.5);
            border-radius: 6px;
            position:absolute;
            top:0;
            left:0;
            text-align:center;
            color:white;
            padding:12px;
            cursor: pointer;
            display: table-cell;
            vertical-align: middle;
            transform: scale(1.08);
            font-size: 18px;
        }

        .item:hover .center-crop
        {
            transform: scale(1.08);
        }


        .tittle a
        {
            text-decoration: none;
            color : #5c5c5c;
        }

        .row.display-flex {
            display: flex;
            flex-wrap: wrap;
        }
        .row.display-flex > [class*='col-'] {
            display: flex;
            flex-direction: column;
        }

    </style>

</head>

<body>


<div id="app">

    <div style="width: 100%;height: 5px;background-color: #f7b630;">

    </div>


    <div style="height: 80px">
        <div class="container">
            <img style="margin-top: 8px" height="80px" src="{{URL::asset('images/logo_admin.png') }}" alt="">
        </div>
    </div>

    <hr>

    <div class="container">
        <div style="text-align: center;">
            <span style="font-weight: 700;font-size: 32px;color: #f7b630">{{strtoupper($menu_category->name)}}</span>

            <div style="margin-top: 3px">
                <span style="font-size: 20px;font-weight: 300;margin-top: 5px">{{$menu_category->description}}</span>
            </div>

            <div>

                <div class="row display-flex">
                    @foreach($categories as $category)
                        <div class="col-md-3" style="margin-top: 20px">
                            <a href="{{route('menu.categories',$category->id)}}">
                                <div class="item">
                                    <img  class="img-rounded center-crop" src="{{URL::asset('images/menu_categories_photos')}}/{{$category->id}}.png">
                                    <div  class="overlay">{{$category->description}}</div>
                                </div>
                            </a>
                            <div class="tittle" style="text-align: left;margin-top: 8px">
                                <a href="{{route('menu.categories',$category->id)}}"><span style="font-size: 20px;font-weight: 700">{{$category->name}}</span></a>
                            </div>
                        </div>
                    @endforeach

                        @foreach($products as $product)
                            <div class="col-md-3" style="margin-top: 20px">
                                <a href="{{route('menu.categories',$product->id)}}">
                                    <div class="item">
                                        <img  class="img-rounded center-crop" src="{{URL::asset('images/products_photos')}}/{{$product->id}}.png">
                                        <div  class="overlay">{{$product->description}}</div>
                                    </div>
                                </a href="{{route('menu.categories',$product->id)}}">
                                <div class="tittle" style="text-align: left;margin-top: 8px">
                                    <a href="{{route('menu.categories',$product->id)}}"><span style="font-size: 20px;font-weight: 700">{{$product->name}}</span></a>
                                </div>
                            </div>
                        @endforeach
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