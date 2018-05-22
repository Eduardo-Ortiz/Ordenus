<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<div id="app">

Test


</div>
<!-- Vue.js -->
<script type="text/javascript" src="{{URL::asset('js/vue.js')}}"></script>

<script src="{{URL::asset('js/app.js')}}"> </script>
<script>



    var user = <?php echo Auth::user() ?>


    var app = new Vue({
        el: '#app',
        data: {

        },
        methods: {

        },
        created: function (){


            console.log('user-'+user.id);
            Echo.private('user-'+user.id)
                .listen('OrderSent', (e) => {
                    alert("NUEVO");
                });
        }
    })
</script>