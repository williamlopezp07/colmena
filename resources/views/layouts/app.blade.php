
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title') - {{ config('app.name') }}</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="{{asset('css/styles.css')}}" rel="stylesheet" />
        <!-- SweetAlert -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
        <script src="https://kit.fontawesome.com/fdf9de8f5b.js" crossorigin="anonymous"></script>
        <link rel="icon" type="image/x-icon" href="{{asset('img/colmena_logo_corto.png')}}" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{asset('assets/selectize/selectize.default.css')}}" >
        {{-- Calendar --}}
        <link rel="stylesheet" href="{{asset('assets/fullcalendar/lib/main.css')}}">
        <style media="screen">
          table{
            width: 100%
          }
          #calendar_home .fc-day-today{
              background-color: #ffe0b3 !important;
          }
        </style>
  </head>
    <body class="nav-fixed">
        <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
            <!-- Sidenav Toggle Button-->
            <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i data-feather="menu"></i></button>
            <!-- Navbar Brand-->
            <!-- * * Tip * * You can use text or an image for your navbar brand.-->
            <!-- * * * * * * When using an image, we recommend the SVG format.-->
            <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
            <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="{{ route('home') }}">{{ config('app.name') }}</a>
            <!-- Navbar Search Input-->
            <!-- * * Note: * * Visible only on and above the lg breakpoint-->
            <!--<form class="form-inline me-auto d-none d-lg-block me-3">
                <div class="input-group input-group-joined input-group-solid">
                    <input class="form-control pe-0" type="search" placeholder="Search" aria-label="Search" />
                    <div class="input-group-text"><i data-feather="search"></i></div>
                </div>
            </form>-->
            <!-- Navbar Items-->
            <ul class="navbar-nav align-items-center ms-auto">
                <!-- Documentation Dropdown-->
                <!-- <li class="nav-item dropdown no-caret d-none d-md-block me-3">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownDocs" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="fw-500">Documentation</div>
                        <i class="fas fa-chevron-right dropdown-arrow"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end py-0 me-sm-n15 me-lg-0 o-hidden animated--fade-in-up" aria-labelledby="navbarDropdownDocs">
                        <a class="dropdown-item py-3" href="https://docs.startbootstrap.com/sb-admin-pro" target="_blank">
                            <div class="icon-stack bg-primary-soft text-primary me-4"><i data-feather="book"></i></div>
                            <div>
                                <div class="small text-gray-500">Documentation</div>
                                Usage instructions and reference
                            </div>
                        </a>
                        <div class="dropdown-divider m-0"></div>
                        <a class="dropdown-item py-3" href="https://docs.startbootstrap.com/sb-admin-pro/components" target="_blank">
                            <div class="icon-stack bg-primary-soft text-primary me-4"><i data-feather="code"></i></div>
                            <div>
                                <div class="small text-gray-500">Components</div>
                                Code snippets and reference
                            </div>
                        </a>
                        <div class="dropdown-divider m-0"></div>
                        <a class="dropdown-item py-3" href="https://docs.startbootstrap.com/sb-admin-pro/changelog" target="_blank">
                            <div class="icon-stack bg-primary-soft text-primary me-4"><i data-feather="file-text"></i></div>
                            <div>
                                <div class="small text-gray-500">Changelog</div>
                                Updates and changes
                            </div>
                        </a>
                    </div>
                </li> -->
                <!-- Navbar Search Dropdown-->
                <!-- * * Note: * * Visible only below the lg breakpoint-->
                <li class="nav-item dropdown no-caret me-3 d-lg-none">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="searchDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="search"></i></a>
                    <!-- Dropdown - Search-->
                    <div class="dropdown-menu dropdown-menu-end p-3 shadow animated--fade-in-up" aria-labelledby="searchDropdown">
                        <form class="form-inline me-auto w-100">
                            <div class="input-group input-group-joined input-group-solid">
                                <input class="form-control pe-0" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                                <div class="input-group-text"><i data-feather="search"></i></div>
                            </div>
                        </form>
                    </div>
                </li>
                @role('Administrador')
                <li class="nav-item dropdown no-caret d-none d-sm-block me-3 dropdown-notifications">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownInvoice" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-file-invoice-dollar"></i></a>
                    <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownInvoice" id="pendingInvoice">
                        <h6 class="dropdown-header dropdown-notifications-header bg-secondary">
                          <i class="me-2 fas fa-file-invoice-dollar"></i>
                            Pendientes por Pagar
                        </h6>
                        <a class="dropdown-item dropdown-notifications-footer"  href="{{route('procesos.comp_pagar.mantenimiento')}}">Ir a Actualización de Pagos</a>
                    </div>
                </li>
                @endrole
                @can('programacion')
                <!-- Alerts Dropdown-->
                <li class="nav-item dropdown no-caret d-none d-sm-block me-3 dropdown-notifications">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownAlerts" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="bell"></i></a>
                    <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownAlerts" id="pendingAlerts">
                        <h6 class="dropdown-header dropdown-notifications-header bg-secondary">
                            <i class="me-2" data-feather="bell"></i>
                            Pendientes por Cerrar
                        </h6>
                        @role('Administrador')
                        <a class="dropdown-item dropdown-notifications-footer"  href="{{route('reportes.actividades_pendientes.index')}}">Ir a Actividades Pendientes</a>
                        @endrole
                        @role('Ejecutiva de Cuenta')
                        <a class="dropdown-item dropdown-notifications-footer"  href="{{route('procesos.programacion.index')}}">Ir a Calendario</a>
                        @endrole
                    </div>
                </li>
                @endcan
                <!-- User Dropdown-->
                <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="{{asset('img/colmena_logo_corto.png')}}" /></a>
                    <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                        <h6 class="dropdown-header d-flex align-items-center">
                            <img class="dropdown-user-img" src="{{asset('img/colmena_logo_corto.png')}}" />
                            <div class="dropdown-user-details">
                                <div class="dropdown-user-details-name">{{ Auth::user()->nombre.' '.Auth::user()->apepat.' '.Auth::user()->apemat }}</div>
                                <div class="dropdown-user-details-email">{{Auth::user()->email}}</div>
                            </div>
                        </h6>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('mantenimiento.usuario.index')}}">
                            <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                            Actualizar información de Usuario
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                            Cerrar Sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
          @include('layouts.aside')

            <div id="layoutSidenav_content">
                @yield('content')
                <footer class="footer-admin mt-auto footer-light">
                    <div class="container-xl px-4">
                        <div class="row">
                            <div class="col-md-6 small">Copyright &copy; App Colmena 2022</div>
                            <div class="col-md-6 text-md-end small">
                                <a href="#!">DISAD</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- SweetAlert -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
        <!-- DataTables -->

        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>

        <!-- SummerNote -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote.js"></script>

        <!-- DataTable Export -->
        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.js"></script>
        <!-- <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
        <script src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
        <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
        <script src="{{asset('assets/selectize/selectize.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="{{asset('js/scripts.js')}}"></script>
        {{-- Calendar Script --}}
        <script src="{{asset('assets/fullcalendar/lib/main.js')}}"></script>
        @role('Administrador')
        <script type="text/javascript"> rolSession = 1</script>
        @endrole
        @role('Base de Datos')
        <script type="text/javascript">  rolSession = 2</script>
        @endrole
        @role('Ejecutiva de Cuenta')
        <script type="text/javascript">  rolSession = 3</script>
        @endrole
        @role('Cliente')
        <script type="text/javascript">  rolSession = 4</script>
        @endrole
        @role('Contabilidad')
        <script type="text/javascript">  rolSession = 5</script>
        @endrole
        <script type="text/javascript">
          const baseurl = '{{ url('') }}';
          const asset = '{{ asset('') }}';
          const activate_tooltip = () => {
            $('[data-bs-toggle="tooltip"]').tooltip()
        }
        var Mayuscula = (e) => {
          e.value = e.value.toUpperCase();
        }
        var usuarioSession = '{{Auth::user()->documento}}'
        @can('cotizaciones')
        @endcan
        function valideKey(evt){
            var code = (evt.which) ? evt.which : evt.keyCode;
            if(code==8) {
              return true;
            } else if(code>=48 && code<=57) {
              return true;
            } else{
              return false;
            }
        }
        $(document).on('change','input[type=number]',function(){
          if ($(this).val()<0) {
            $(this).val('')
          }
        })
        $.ajax({
          url: baseurl + '/pendientes',
          type:'get',
          success: function(data){
            data.forEach((item, i) => {
              $('#pendingAlerts').append(`
                <a class="dropdown-item dropdown-notifications-item" ${rolSession==1 ? `href="{{route('reportes.actividades_pendientes.index')}}"` : `href="{{route('procesos.programacion.index')}}"`} style="padding:0.5rem">
                    <div class="dropdown-notifications-item-icon ${(data[0].PDINPUT=='tarifa_story') ? (data[0].dias_trascurridos>1) ? 'bg-danger' : 'bg-warning' : (data[0].dias_trascurridos>7) ? 'bg-danger': 'bg-warning'}">
                      <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-details">${(rolSession==1 ? data[0].usuario_nom + ' - ' : '')  +data[0].PDFECPRO}</div>
                        <div class="dropdown-notifications-item-content-text" style="font-size: 0.6rem;">${data[0].PDDESCRI + '-' + data[0].PDGLOSA}</div>
                        <div class="dropdown-notifications-item-content-text" style="font-size: 0.6rem;">${data[0].producto + '-' + data[0].campaña}</div>
                    </div>
                </a>
                `)
            });
            $('#navbarDropdownAlerts').append(`<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill ${data.length==0 ? 'bg-success' : 'bg-danger'} " style="font-size: 0.5em;">
              ${data.length==0 ? '<i class="fas fa-check"></i>' : data.length}
              <span class="visually-hidden">mensajes no leídos</span>
            </span>`)
          }
        })
        $.ajax({
          url: baseurl + '/pendientesFacturas',
          type:'get',
          success: function(data){
            data.forEach((item, i) => {
              $('#pendingInvoice').append(`
                <a class="dropdown-item dropdown-notifications-item" ${rolSession==1 ? `href="{{route('reportes.actividades_pendientes.index')}}"` : `href="{{route('procesos.programacion.index')}}"`} style="padding:0.5rem">
                    <div class="dropdown-notifications-item-icon ${(item.dias_trascurridos>1) ? 'bg-danger' : 'bg-warning'}">
                      <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-details">${(rolSession==1 ? item.destino + ' - ' : '')  +item.fecha_pago}</div>
                        <div class="dropdown-notifications-item-content-text" style="font-size: 0.6rem;">${((item.tipo_comprobante=='factura')? 'FT' : 'RH') + ' - ' + item.comprobante}</div>
                        <div class="dropdown-notifications-item-content-text" style="font-size: 0.6rem;">${((item.moneda=='PEN')? 'S/' : '$') + (parseFloat(item.monto).toFixed(2)).toLocaleString('es-MX')}</div>
                    </div>
                </a>
                `)
            });
            $('#navbarDropdownInvoice').append(`<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill ${data.length==0 ? 'bg-success' : 'bg-danger'} " style="font-size: 0.5em;">
              ${data.length==0 ? '<i class="fas fa-check"></i>' : data.length}
              <span class="visually-hidden">Sin Pagos Pendientes </span>
            </span>`)
          }
        })
        </script>
        <script src="{{asset('js/app/')}}/@yield('js').js?{{date('YmdHis')}}"></script>
    </body>
</html>
