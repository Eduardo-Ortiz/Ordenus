@extends('admin.layouts.panel')


@section('content')

    <div id="app" class="col-lg-12">
        <h1 class="page-header">Unidades de Medida</h1>
        @if(count($errors))
            <div class="alert alert-danger fade in alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Han ocurrido los siguientes errores:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{route('admin.units.store')}}">
            {{csrf_field()}}
            <div class="row">
                <!-- Name Input -->
                <div class="col-xs-3 col-sm-3 col-md-3">
                    <div class="form-group">
                        <label for="name">Nombre de la Unidad:</label>
                        <input required type="text" class="form-control" id="name" name="name"  value="{{old('name')}}">
                    </div>
                </div>
                <!-- Name Input -->
                <div class="col-xs-2 col-sm-2 col-md-2">
                    <div class="form-group">
                        <label for="name">Abreviacion:</label>
                        <input required type="text" class="form-control" id="abreviation" name="abreviation"  value="{{old('abreviation')}}">
                    </div>
                </div>

                <div class="col-xs-2 col-sm-2 col-md-2">
                    <button style="margin-top: 14px" type="submit" class="btn btn-success btn-lg"><i class="fa fa-floppy-o fa-fw"></i> Agregar Unidad</button>
                </div>
            </div>
        </form>


        <label for="name">Unidades Registradas:</label>
        @if(count($units))
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Nombre de la Unidad</th>
                    <th style="width: 10px">Abreviación</th>
                    <th style="width: 10px">Equivalencias</th>
                    <th style="width: 10px">Editar</th>
                    <th style="width: 10px">Eliminar</th>
                </tr>
                </thead>
                <tbody>
                @for ($i=0; $i<count($units); $i++)
                    <tr>
                        <td>{{$units[$i]->name}}</td>
                        <td>{{$units[$i]->abreviation}}</td>
                        <td style="text-align: center"><button @click="equivalences({{$units[$i]->id}},{{$i}})"  class="btn btn-default btn-xs">Ver Equivalencias</button></td>
                        <td style="text-align: center"><button @click="askEdit({{$i}})" class="btn btn-default btn-xs">Editar Unidad</button></td>
                        <td style="text-align: center"><button @click="askDelete({{$i}})" class="btn btn-danger btn-xs">Eliminar Unidad</button></td>
                    </tr>
                @endfor
                </tbody>
            </table>
        @else
            <br>
           <span style="font-size: 32px">No hay ninguna unidad registrada.</span>
        @endif



        <!-- Modal -->
        <div id="equivalencesModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content bigModal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 v-if="selectedUnit!=null" class="modal-title">Equivalencias de la Unidad @{{unitsData[selectedUnit].name}} (@{{unitsData[selectedUnit].abreviation}})</h4>
                    </div>
                    <div class="modal-body">
                        <div v-if="conversions.length>0" class="row">
                            <!-- Name Input -->
                            <div class="col-md-offset-2 col-sm-offset-0 col-xs-2 col-sm-3 col-md-2">
                                <div  class="form-group">
                                    <label for="name">A la Unidad:</label>
                                    <select class="form-control" id="sel1" v-model="newEqTo">
                                        <option v-for="unit in conversions" v-bind:value="unit.id">
                                            @{{ unit.name }} (@{{unit.abreviation}})
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <!-- Name Input -->
                            <div class="col-xs-2 col-sm-3 col-md-2">
                                <div class="form-group">
                                    <label for="name">Ratio:</label>
                                    <input v-model="newEqRatio" required type="number" class="form-control" id="abreviation" name="abreviation"  value="{{old('abreviation')}}">
                                </div>
                            </div>

                            <div class="col-xs-4 col-sm-6 col-md-4">
                                <button v-on:click="storeEquivalence()" :disabled="newEqTo==null||newEqRatio==null" style="margin-top: 14px" type="submit" class="btn btn-success btn-lg btn-block"><i class="fa fa-floppy-o fa-fw"></i> Agregar Equivalencia</button>
                            </div>
                        </div>
                        <div style="text-align: center" v-else>
                            <h2>No hay otras unidades para crear equivalencias</h2>
                        </div>
                        <hr>
                        <table v-if="unitEquivalences.length>0" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Unidad</th>
                                <th>Equivalencia</th>
                                <th style="width: 10px">Eliminar</th>
                            </tr>
                            </thead>
                            <tbody >
                            <tr v-for="equivalence in unitEquivalences">
                                <td>@{{equivalence.name}} (@{{equivalence.abreviation}})</td>
                                <td>@{{equivalence.ratio}} @{{equivalence.abreviation}}</td>
                                <td style="text-align: center"><button v-on:click="deleteEquivalence(equivalence.id)"  class="btn btn-danger btn-xs">Eliminar Equivalencia</button></td></td>
                            </tr>
                            </tbody>
                        </table>
                        <div style="text-align: center" v-else>
                            <h2>No hay equivalencias registradas para esta unidad</h2>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-lg btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div id="editModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 v-if="selectedUnit!=null" class="modal-title">Editar la Unidad @{{unitsData[selectedUnit].name}} (@{{unitsData[selectedUnit].abreviation}})</h4>
                    </div>
                    <div v-if="selectedUnit!=null" class="modal-body">
                        <div class="row">
                            <!-- Name Input -->
                            <div class="col-xs-8 col-sm-8 col-md-8">
                                <div class="form-group">
                                    <label for="name">Nombre de la Unidad:</label>
                                    <input v-model="editName" required type="text" class="form-control" id="name" name="name"  value="{{old('name')}}">
                                </div>
                            </div>
                            <!-- Name Input -->
                            <div class="col-xs-4 col-sm-4 col-md-4">
                                <div class="form-group">
                                    <label for="name">Abreviacion:</label>
                                    <input v-model="editAbreviation" required type="text" class="form-control" id="abreviation" name="abreviation"  value="{{old('abreviation')}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button v-on:click="editUnit()" type="button" class="btn-lg btn btn-success" data-dismiss="modal">Guardar Cambios</button>
                        <button type="button" class="btn-lg btn btn-default" data-dismiss="modal">Cancelar</button> &nbsp;&nbsp;
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="deleteModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content bigModal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 v-if="selectedUnit!=null" class="modal-title">Eliminar la Unidad @{{unitsData[selectedUnit].name}} (@{{unitsData[selectedUnit].abreviation}})</h4>
                    </div>
                    <div v-if="selectedUnit!=null" class="modal-body">
                        <h2>¿Desea eliminar la unidad @{{unitsData[selectedUnit].name}} (@{{unitsData[selectedUnit].abreviation}})?</h2>
                        <h4>Nota: Esta acción no podra revertirse</h4>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn-lg btn btn-default" data-dismiss="modal">Cancelar</button> &nbsp;&nbsp;
                        <button v-on:click="deleteUnit()" type="button" class="btn-lg btn btn-danger" data-dismiss="modal">Eliminar</button>
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
                unitsData : [],
                unitEquivalences : [],
                conversions : [],
                selectedUnit : null,
                newEqTo : null,
                newEqRatio : null,
                editName : null,
                editAbreviation : null

            },
            methods: {
                equivalences: function(id,index){
                    this.unitEquivalences = [];
                    this.selectedUnit = index;
                    this.newEqTo = null;
                    this.newEqRatio = null;
                    this.loadEquivalenceData(id);
                    $('#equivalencesModal').modal('show');
                },
                storeEquivalence : function()
                {
                    axios.post('<?php echo URL::asset('/admin/equivalences') ?>', {
                        from_id: app.unitsData[app.selectedUnit].id,
                        to_id: app.newEqTo,
                        ratio : app.newEqRatio
                    }) .then(function (response) {
                        app.loadEquivalenceData(app.unitsData[app.selectedUnit].id);
                    });
                    this.newEqRatio = null;
                },
                askDelete : function(index)
                {
                    this.selectedUnit = index;
                    $('#deleteModal').modal('show');
                },
                askEdit : function(index)
                {
                    this.selectedUnit = index;
                    this.editName = app.unitsData[app.selectedUnit].name;
                    this.editAbreviation = app.unitsData[app.selectedUnit].abreviation;
                    $('#editModal').modal('show');
                },
                deleteUnit : function()
                {
                    axios.delete('<?php echo URL::asset('/admin/units') ?>'+"/"+app.unitsData[app.selectedUnit].id
                    ).then(function (response) {
                        window.location = '<?php echo URL::asset('/admin/units') ?>';
                    });
                },
                editUnit : function()
                {
                    axios.post('<?php echo URL::asset('/admin/units/edit') ?>'+"/"+app.unitsData[app.selectedUnit].id, {
                        name : app.editName,
                        abreviation : app.editAbreviation
                    }) .then(function () {
                        window.location = '<?php echo URL::asset('/admin/units') ?>';
                    });
                },
                deleteEquivalence : function(to)
                {
                    axios.delete('<?php echo URL::asset('/admin/equivalences') ?>',
                        {params:   {
                            from_id: app.unitsData[app.selectedUnit].id,
                            to_id: to
                        }}
                      ).then(function (response) {
                        app.loadEquivalenceData(app.unitsData[app.selectedUnit].id);
                    });
                },
                loadEquivalenceData : function(id)
                {
                    axios.get(`<?php echo URL::asset('/admin/equivalences') ?>`+"/"+id)
                        .then(response => {
                        app.unitEquivalences = response.data;
                    app.$forceUpdate();
                    });

                    axios.get(`<?php echo URL::asset('/admin/equivalences/available') ?>`+"/"+id)
                        .then(response => {
                        app.conversions = response.data;
                    app.$forceUpdate();
                    });
                }
            },
            mounted: function(){
                this.unitsData = <?php echo $units ?>;
            },
            ready: function() {

            }
        })
    </script>
@stop
