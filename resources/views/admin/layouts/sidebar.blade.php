<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Buscar...">
                    <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                </div>
                <!-- /input-group -->
            </li>
            <li>
                <a href="{{url('admin')}}"><i class="fa fa-dashboard fa-fw"></i> Principal</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-archive fa-fw"></i> Inventarios<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{url('admin/supplies')}}">Explorar</a>
                    </li>
                    <li>
                        <a href="{{url('admin/supplies/create')}}">Registrar Insumo</a>
                    </li>
                    <li>
                        <a href="#">Categorias<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level collapse">
                            <li>
                                <a href="{{url('admin/supplies-categories')}}">Explorar</a>
                            </li>
                            <li>
                                <a href="{{url('admin/supplies-categories/create')}}">Crear</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="tables.html"><i class="fa fa-book fa-fw"></i> Menú<span class="fa arrow"></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="#">Categorias<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level collapse">
                            <li>
                                <a href="{{url('admin/menu-categories')}}">Explorar</a>
                            </li>
                            <li>
                                <a href="{{url('admin/menu-categories/create')}}">Crear</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Productos<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level collapse">
                            <li>
                                <a href="{{url('admin/products')}}">Explorar</a>
                            </li>
                            <li>
                                <a href="{{url('admin/products/create')}}">Crear</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li>
                <a href="tables.html"><i class="fa fa-cogs fa-fw"></i> Configuracion<span class="fa arrow"></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{url('admin/units')}}">Unidades de Medida</a>
                    </li>
                    <li>
                        <a href="#">Areas de Trabajo<span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level collapse">
                            <li>
                                <a href="{{url('admin/areas')}}">Explorar</a>
                            </li>
                            <li>
                                <a href="{{url('admin/areas/create')}}">Crear</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>