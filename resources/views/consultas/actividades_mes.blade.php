@extends('layouts.app')
@section('title')
{{$title}}
@endsection
@section('js'){{$js}}@endsection
@section('content')
<style media="screen">
  input,select{
    font-size: 9pt;
  }
</style>
<main>
  <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
      <div class="container-xl px-4">
          <div class="page-header-content pt-4">
              <div class="row align-items-center justify-content-between">
                  <div class="col-auto mt-4">
                      <h1 class="page-header-title">
                          <div class="page-header-icon"><i data-feather="layout"></i></div>
                          {{$title}}
                      </h1>
                  </div>
              </div>
              <nav class="mt-4 rounded" aria-label="breadcrumb">
                  <ol class="breadcrumb px-3 py-2 rounded mb-0">
                      <li class="breadcrumb-item ">Reportes</li>
                      <li class="breadcrumb-item active">{{$title}}</li>
                  </ol>
              </nav>
          </div>
      </div>
  </header>
  <!-- Main page content-->
  <div class="container-xl px-4 mt-n10">
      <div class="card">
          <div class="card-header text-secondary">{{$title}}</div>
          <div class="card-body">
            <div class="row">
              <div class="col-xl-3">
                <button type="button" class="btn btn-info" name="button" data-bs-toggle="modal" data-bs-target="#busquedaModal" ><i class="faa fa-filter"></i> Filtrar</button>
              </div>
            </div><br>
            <div class="row">
              <div class="table-responsive col-md-12">
                <div id="divTable">
                </div>
              </div>
            </div>
          </div>
      </div>
  </div>
  <div class="modal fade" id="busquedaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modalTitle">Filtros</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="formBusqueda">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <label for="">Mes</label>
                <input type="month" class="form-control"  id="mes"   value="{{date('Y-m')}}" required>
              </div>
              <div class="col-md-6">
                <label for="">Ejecutiva(o) de Cuenta</label>
                <select class="form-control" id="ejecutivo" name="" required>
                    <option value="ALL">Todos</option>
                  <?php foreach ($ejecutivos as $key): ?>
                    <option value="{{$key->documento}}">{{$key->nombre.' '.$key->apepat.' '.$key->apemat}}</option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div><br>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info" id="filtrar">Filtrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>
@endsection
