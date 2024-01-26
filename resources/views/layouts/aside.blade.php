<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <div class="sidenav-menu-heading">Menús</div>
                <!-- Sidenav Accordion (Dashboard)-->
                @role(['Administrador'])

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseDashboard" aria-expanded="false" aria-controls="collapseDashboard">
                    <div class="nav-link-icon"><i class="fas fa-chart-pie"></i></div>
                    Dashboard
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseDashboard" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        <a class="nav-link" href="{{route('dashboard.cotizaciones.index')}}">Cotizaciones</a>
                        <a class="nav-link" href="{{route('dashboard.programaciones.index')}}">Programaciones</a>
                        <a class="nav-link" href="{{route('dashboard.clientes.index')}}">Deudas Clientes</a>
                        <a class="nav-link" href="{{route('dashboard.influencers.index')}}">Deudas Influencers</a>
                        <a class="nav-link" href="{{route('dashboard.top_influencers.index')}}">Top Influencers</a>
                    </nav>
                </div>
                @endrole
                <!-- Sidenav Accordion (Dashboard)-->
                @canany(['clientes','producto_cliente','forma_pago','accion','influencer','redsocial','categoria_redsocial'])

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseMantenimiento" aria-expanded="false" aria-controls="collapseMantenimiento">
                    <div class="nav-link-icon"><i class="fas fa-tools"></i></div>
                    Mantenimiento
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseMantenimiento" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                        @can('clientes')<a class="nav-link" href="{{route('mantenimiento.clientes.index')}}">Clientes</a>@endcan
                        @can('producto_cliente')<a class="nav-link" href="{{route('mantenimiento.producto_cliente.index')}}">Productos de Clientes</a>@endcan
                        @can('forma_pago')<a class="nav-link" href="{{route('mantenimiento.forma_pago.index')}}">Formas de Pago</a>@endcan
                        @can('accion')<a class="nav-link" href="{{route('mantenimiento.accion.index')}}">Acciones</a>@endcan
                        @can('influencer')<a class="nav-link" href="{{route('mantenimiento.influencer.index')}}">Influencers</a>@endcan
                        @can('redsocial')<a class="nav-link" href="{{route('mantenimiento.redsocial.index')}}">Redes Sociales</a>@endcan
                        @can('categoria_redsocial')<a class="nav-link" href="{{route('mantenimiento.categoria_redsocial.index')}}">Categorias de Red Social</a>@endcan
                    </nav>
                </div>
                @endcanany
                @canany(['cotizaciones','cotizaciones.mantenimiento','cotizaciones.versionar'])

                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseCotizacion" aria-expanded="false" aria-controls="collapseCotizacion">
                    <div class="nav-link-icon"><i class="fas fa-hand-holding-usd"></i></div>
                    Cotizaciones
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseCotizacion" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                      @can('cotizaciones')<a class="nav-link" href="{{route('procesos.cotizaciones.index')}}">Nueva Cotización</a>@endcan
                      @can('cotizaciones.mantenimiento')<a class="nav-link" href="{{route('procesos.cotizaciones.mantenimiento')}}">Editar Cotizaciones</a>@endcan
                      @can('cotizaciones.versionar')<a class="nav-link" href="{{route('procesos.cotizaciones.versionar')}}">Versionar Cotizaciones</a>@endcan
                    </nav>
                </div>
                @endcanany
                @canany(['programacion','programacion.mantenimiento'])
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseProgramacion" aria-expanded="false" aria-controls="collapseProgramacion">
                    <div class="nav-link-icon"><i class="fas fa-calendar"></i></div>
                    Programaciones
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseProgramacion" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                      @can('programacion')<a class="nav-link" href="{{route('procesos.programacion.index')}}">Calendario</a>@endcan
                      @can('programacion.mantenimiento')<a class="nav-link" href="{{route('procesos.programacion.mantenimiento')}}">Mantto. Programaciones</a>@endcan
                      <a class="nav-link" href="{{route('procesos.programacion.aprobacion_acciones')}}">Aprobación de Nuevas Acciones</a>
                    </nav>
                </div>
                @endcanany
                @canany(['comp_pagar.index','comp_cobrar.index','comp_pagar.mantenimiento','comp_cobrar.mantenimiento','comp_pagar.nota_credito'])
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseComprobantes" aria-expanded="false" aria-controls="collapseComprobantes">
                    <div class="nav-link-icon"><i class="fas fa-file-invoice"></i></div>
                    Gestion de Pagos y Cobros
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseComprobantes" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                      @can('comp_pagar.index')<a class="nav-link" href="{{route('procesos.comp_pagar.index')}}">Comprobantes por Pagar</a>@endcan
                      @can('comp_cobrar.index')<a class="nav-link" href="{{route('procesos.comp_cobrar.index')}}">Comprobantes por Facturar</a>@endcan
                      @can('comp_pagar.mantenimiento')<a class="nav-link" href="{{route('procesos.comp_pagar.mantenimiento')}}">Actualización de Pagos</a>@endcan
                      @can('comp_cobrar.mantenimiento')<a class="nav-link" href="{{route('procesos.comp_cobrar.mantenimiento')}}">Actualización de Cobros</a>@endcan
                       @can('comp_pagar.nota_credito')<a class="nav-link" href="{{route('procesos.comp_pagar.notas_credito')}}">Notas de Crédito</a> @endcan
                    </nav>
                </div>
                @endcanany
                @unlessrole (['Cliente','Influencers' ])
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseConsultas" aria-expanded="false" aria-controls="collapseConsultas">
                    <div class="nav-link-icon"><i class="fas fa-question"></i></div>
                    Consultas
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseConsultas" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                      @unlessrole (['Contabilidad' ])
                      <a class="nav-link" href="{{route('consultas.influencer.busqueda')}}">Busqueda de Influencers</a>
                      <a class="nav-link" href="{{route('consultas.actividades_mes.index')}}">Actividades del Mes</a>
                      @endunlessrole
                      @can('reportes.actividades_pendientes')<a class="nav-link" href="{{route('reportes.actividades_pendientes.index')}}">Actividades Pendientes</a>@endcan
                      @can('reportes.resultados_cotizacion')<a class="nav-link" href="{{route('reportes.resultados_cotizacion.index')}}">Resultados por Cotización</a>@endcan
                      @can('reportes.progreso_campanas')<a class="nav-link" href="{{route('reportes.progreso_campanas.index')}}">Progreso de Campaña</a>@endcan
                      @can('reportes.ctaxcobrar')<a class="nav-link" href="{{route('reportes.ctaxcobrar.index')}}">Ctas x Cobrar</a>@endcan
                      @can('reportes.ctaxpagar')<a class="nav-link" href="{{route('reportes.ctaxpagar.index')}}">Ctas x Pagar</a>@endcan
                      @can('reportes.ctaxpagar')<a class="nav-link" href="{{route('reportes.relacion_facturas.index')}}">Relacion de Facturas</a>@endcan
                    </nav>
                </div>
                @endunlessrole
                @role('Cliente')
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseReportes" aria-expanded="false" aria-controls="collapseReportes">
                    <div class="nav-link-icon"><i class="fas fa-filter"></i></div>
                    Reportes
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseReportes" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                      @can('reportes.progreso_campanas')<a class="nav-link" href="{{route('reportes.progreso_campanas.index')}}">Progreso de Campaña</a>@endcan
                    </nav>
                </div>
                @endrole
                <!-- @canany(['reportes.ctaxcobrar','reportes.ctaxpagar','reportes.actividades_pendientes','reportes.resultados_cotizacion','reportes.progreso_campanas'])
                <a class="nav-link collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#collapseReportes" aria-expanded="false" aria-controls="collapseReportes">
                    <div class="nav-link-icon"><i class="fas fa-filter"></i></div>
                    Reportes
                    <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseReportes" data-bs-parent="#accordionSidenav">
                    <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavPages">
                      @can('reportes.ctaxcobrar')<a class="nav-link" href="{{route('reportes.ctaxcobrar.index')}}">Ctas x Cobrar</a>@endcan
                      @can('reportes.ctaxpagar')<a class="nav-link" href="{{route('reportes.ctaxpagar.index')}}">Ctas x Pagar</a>@endcan
                      @can('reportes.actividades_pendientes')<a class="nav-link" href="{{route('reportes.actividades_pendientes.index')}}">Actividades Pendientes</a>@endcan
                      @can('reportes.resultados_cotizacion')<a class="nav-link" href="{{route('reportes.resultados_cotizacion.index')}}">Resultados por Cotización</a>@endcan
                      @can('reportes.progreso_campanas')<a class="nav-link" href="{{route('reportes.progreso_campanas.index')}}">Progreso de Campaña</a>@endcan
                    </nav>
                </div>
                @endcanany -->

            </div>
        </div>
        <!-- Sidenav Footer-->
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Ha iniciado sesión como:</div>
                <div class="sidenav-footer-title">{{ Auth::user()->nombre.' '.Auth::user()->apepat.' '.Auth::user()->apemat }}</div>
            </div>
        </div>
    </nav>
</div>
