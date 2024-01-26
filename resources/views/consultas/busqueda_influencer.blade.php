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
                <div id="divTable" >
                  <table id="tabla" class="table table-bordered">
                    <thead>
                      <tr>
                        <th></th>
                        <th>INFLUENCER</th>
                        <th>HANDLE</th>
                        <th>PERFIL</th>
                        <th style="display:none">PERFIL</th>
                        <th>UBICACIÓN</th>
                        <th>CATEGORIAS</th>
                        <th>RED SOCIAL</th>
                        <th>ER</th>
                        <th>SEGUIDORES</th>
                      </tr>
                    </thead>
                  </table>
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
                <label for="">Handle del influencer</label>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control"  id="handle" value="" placeholder="">
              </div>
            </div><br>
            <div class="row">
              <div class="col-md-6">
                <label for="">Nombre del influencer</label>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control"  id="nombre" value="" placeholder="">
              </div>
            </div><br>
            <div class="row">
              <div class="col-md-6">
                <label for="">Ubicación del influencer</label>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control"  id="ubicacion" value="" placeholder="">
              </div>
            </div><br>
            <div class="row">
              <div class="col-md-6">
                <label for="">Red Social</label>
              </div>
              <div class="col-md-6">
                <select class="form-control" id="red_social" required>

                </select>
              </div>
            </div><br>
            <div class="row">
              <div class="col-md-6">
                <label for="">Número Mínimo de Seguidores</label>
              </div>
              <div class="col-md-6">
                <input type="number" class="form-control"  id="seguidores" step='1000' min='0' value="" required>
              </div>
            </div><br>
            <div class="row">
              <div class="col-md-6">
                <label for="">Número Máximo de Seguidores</label>
              </div>
              <div class="col-md-6">
                <input type="number" class="form-control"  id="max_seguidores" step='1000' min='0' value="" required>
              </div>
            </div><br>
            <div class="row">
              <div class="col-md-6">
                <label for="">Categoria</label>
              </div>
              <div class="col-md-6 categoria_div">
                <select id="categoria" name="categoria[]" multiple >

                </select>
              </div>
              <div class="col-md-12">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="checkAll">
                  <label class="form-check-label" for="checkAll">
                     Todas las categorias
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-info" name="button">Filtrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <input type="hidden" id="influencer_string" name="" value="">
</main>
@endsection
