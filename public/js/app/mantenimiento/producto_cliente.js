function loadData(){
    $('#consulta').DataTable({

        language:{
         url: asset + "/js/spanish.json"
        },
        order:[[0,'desc']],
        destroy:true,
        bAutoWidth: false,
        deferRender:true,
        bProcessing: true,
        stateSave:true,
        iDisplayLength: 10,
        ajax:{
            url:baseurl+'/mantenimiento/producto_cliente/',
            type:'GET',
        },
        columns:[
          {data:'producto'},
          {data:null,render:function(data){
            if (data.logo==null) {
              return ``;
            } else {
              return `
                <a href="${data.logo}" target="_blank" class="btn btn-sm btn-dark">logo</a>
              `;
            }
          }},
          {data:'CNOMCLI'},
          {data:'contacto'},
          {data:'email'},
          {data:'usuario'},
          {data:null,render:function(data){
            if (data.estado==1) {
              return `
                  <span class="badge bg-primary">Activo</span>
              `;
            } else {
              return `
                  <span class="badge bg-danger">Inactivo</span>
              `;
            }
          }},
          {data:null,render:function(data){
            return `<button type="button" class="btn btn-primary btn-sm btn-editar" name="button" data-id="${data.id}" title="editar"><i class="fa fa-edit"></i> </button>
              <button type="button" class="btn btn-dark btn-sm btn-cronograma" name="button" data-id="${data.id}" data-descripcion="${data.producto}" title="campañas"><i class="fas fa-calendar-alt"></i> </button>
              <button type="button" class="btn btn-danger btn-sm btn-eliminar" name="button" data-id="${data.id}" title="eliminar"><i class="fa fa-trash"></i> </button>`
          }},
        ]

    });
}

loadData();

$(document).on('click','.btnAgregarCliente',function(){
  $('#formProductoCliente')[0].reset();
  $('.modal-title').html('Agregar Producto del Cliente')
})

$(document).on('submit','#formProductoCliente',function(e){
  e.preventDefault()
  var formData = new FormData(this);
  $.ajax({
    url: baseurl + '/mantenimiento/producto_cliente/store',
    cache: false,
    contentType: false,
    processData: false,
    data: formData,
    type: 'POST',
    beforeSend: function(){
      swal({
        title: "Cargando",
        imageUrl: asset + "/img/loader.gif",
        text:  "Espere un Momento,no cierre la ventana.",
        showConfirmButton: false
      });
    },
    success: function(data){
      console.log(data.error)

      swal({
        title: data.title,
        type:  data.type,
        text:  data.text,
        timer: 2000,
        showConfirmButton: false
    });
    if (data.type=='success') {
      loadData()
      $('#ProductoClienteModal').modal('hide')
    }
    },
    error: function (request, status, error) {
      if (request.responseJSON.message=='Unauthenticated.') {
      Swal.fire({
          title: 'Sesión Expirada',
          text : 'La sesión ha expirado y el proceso no se ha terminado, por favor ingrese al portal nuevamente',
          icon : 'warning',
          timer: 3000,
          showConfirmButton:false
      });
      setInterval(function(){
        location.reload();
      },3000);
      }
    }
  })
})
$(document).on('click','.btn-editar',function(e){
  e.preventDefault()
  const id = $(this).data('id')
  $('.modal-title').html('Editar Producto del Cliente');
  $('#formProductoCliente input[name=id]').val(id)
  $.ajax({
    url: baseurl + '/mantenimiento/producto_cliente/edit',
    type: 'get',
    data: {id:id},
    success: function(data){
      console.log(data.error)
      $('#ProductoClienteModal').modal('show')
      $('#formProductoCliente input[name=producto]').val(data.producto)
      $('#formProductoCliente input[name=contacto]').val(data.contacto)
      $('#formProductoCliente input[name=email]').val(data.email)
      $('#formProductoCliente select[name=cliente]').val(data.cliente)
      $('#formProductoCliente select[name=estado]').val(data.estado)
    },
    error: function (request, status, error) {
      if (request.responseJSON.message=='Unauthenticated.') {
      Swal.fire({
          title: 'Sesión Expirada',
          text : 'La sesión ha expirado y el proceso no se ha terminado, por favor ingrese al portal nuevamente',
          icon : 'warning',
          timer: 3000,
          showConfirmButton:false
      });
      setInterval(function(){
        location.reload();
      },3000);
      }
    }
  })
})

$(document).on('click','.btn-eliminar',function(e){
  e.preventDefault()
  const id = $(this).data('id')
  swal({
      title: `Desactivar Registro`,
      text: "¿Está Seguro de desactivar el registro?",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Si, estoy seguro",
      cancelButtonText:"Cerrar",
      closeOnConfirm: false
    },
    function(){
      $.ajax({
        url:baseurl+'/mantenimiento/producto_cliente/destroy',
        type:'GET',
        data:{
          'id':id
        },
        dataType:'JSON',
        beforeSend:function(){
          swal({
            title: "Cargando",
            imageUrl: asset + "/img/loader.gif",
            text:  "Espere un Momento,no cierre la ventana.",
            showConfirmButton: false
          });
        },
        success:function(data){
          console.log(data.error)
          swal({
              title: data.title,
              type:  data.type,
              text:  data.text,
              timer: 2000,
              showConfirmButton: false
          });
          if (data.type=='success') {
            loadData()
          }
        },
        error: function (request, status, error) {
          if (request.responseJSON.message=='Unauthenticated.') {
          Swal.fire({
              title: 'Sesión Expirada',
              text : 'La sesión ha expirado y el proceso no se ha terminado, por favor ingrese al portal nuevamente',
              icon : 'warning',
              timer: 3000,
              showConfirmButton:false
          });
          setInterval(function(){
            location.reload();
          },3000);
          }
        }
      });
    });
  })

  function loadCampaña(producto){
    var campañas;
       $.ajax({
          async: false,
          url:baseurl+'/mantenimiento/producto_cliente/get_campana/'+producto,
          type:'GET',
          global: false,
          dataType:'JSON',
          success: function(data){
            campañas = data.data
          },
        })
        console.log(campañas)
      $('#tableCampaña').DataTable({
        language:{
         url: asset + "/js/spanish.json"
        },
        destroy:true,
        bAutoWidth: false,
        deferRender:true,
        bProcessing: true,
        stateSave:true,
        iDisplayLength: 10,
        ajax:{
            url:baseurl+'/mantenimiento/producto_cliente/get_campana/'+producto,
            type:'GET',
        },
        columns:[
          {data:'campaña'},
          {data:'periodo'},
          {data:'periodo_fin'},
          {data:null,render:function(data,row){
            option = '';
            campañas.forEach((item, i) => {
              option += `<option value="${item.id}" ${item.id==data.predecesor ? 'selected' : ''}>${item.campaña}</option>`
            });
            html= `<select class="form-control form-control-sm" name="campaña_predecesor">
              <option value="">Ninguno</option>
              ${option}
            </select>`
            return html
          }},
          {data:null,render:function(data,row){
            if (data.adjunto_comentarios==null) {
              return `
                  <button class="btn btn-secondary btn-cargar" data-id="${data.id}" type="button" >Cargar</button>
              `
            }else {
              return `
              <center>
                <a class="btn btn-outline-secondary btn-sm btn-ver" href="${data.adjunto_comentarios}" target="_blank" type="button" >Ver</a>
                <button type="button" class="btn btn-danger btn-sm btn-eliminar-adjunto-campaña" name="button" data-url="${data.adjunto_comentarios}" data-id="${data.id}"><i class="fa fa-trash"></i> </button>
               </center>
              `
            }
          }},
          {data:null,render:function(data){
            return `<button type="button" class="btn btn-danger btn-sm btn-eliminar-campaña" name="button" data-id="${data.id}"><i class="fa fa-trash"></i> </button>`
          }},
          {data:'id'},
        ],
        "columnDefs": [
          {
            "targets": [6],
            className: "d-none"
            }
         ]
      });
    }

    $(document).on('click','.btn-cronograma',function(e){
      e.preventDefault()
      const id = $(this).data('id')
      const producto = $(this).data('descripcion')
      $("#ProductoCalendarioModal").modal("show")
      $('.modal-title').html('Campañas - Producto : '+producto);
      $('#formProductoCalendario input[name=id]').val(id)
      loadCampaña(id)
    })

    $(document).on('submit','#formProductoCalendario',function(e){
      e.preventDefault()
      const form = $(this)
      $.ajax({
        url: baseurl + '/mantenimiento/producto_cliente/storeCampaña',
        type: 'POST',
        data: form.serialize(),
        beforeSend: function(){
          swal({
            title: "Cargando",
            imageUrl: asset + "/img/loader.gif",
            text:  "Espere un Momento,no cierre la ventana.",
            showConfirmButton: false
          });
        },
        success: function(data){
          console.log(data.error)

          swal({
            title: data.title,
            type:  data.type,
            text:  data.text,
            timer: 2000,
            showConfirmButton: false
        });
        if (data.type=='success') {
          $('#tableCampaña').DataTable().ajax.reload();
        }
        },
        error: function (request, status, error) {
          if (request.responseJSON.message=='Unauthenticated.') {
          Swal.fire({
              title: 'Sesión Expirada',
              text : 'La sesión ha expirado y el proceso no se ha terminado, por favor ingrese al portal nuevamente',
              icon : 'warning',
              timer: 3000,
              showConfirmButton:false
          });
          setInterval(function(){
            location.reload();
          },3000);
          }
        }
      })
    })
    $(document).on('click','.btn-eliminar-campaña',function(e){
      e.preventDefault()
      const id = $(this).data('id')
      swal({
          title: `Desactivar Registro`,
          text: "¿Está Seguro de desactivar el registro?",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Si, estoy seguro",
          cancelButtonText:"Cerrar",
          closeOnConfirm: false
        },
        function(){
          $.ajax({
            url:baseurl+'/mantenimiento/producto_cliente/destroyCampaña',
            type:'GET',
            data:{
              'id':id
            },
            dataType:'JSON',
            beforeSend:function(){
              swal({
                title: "Cargando",
                imageUrl: asset + "/img/loader.gif",
                text:  "Espere un Momento,no cierre la ventana.",
                showConfirmButton: false
              });
            },
            success:function(data){
              console.log(data.error)
              swal({
                  title: data.title,
                  type:  data.type,
                  text:  data.text,
                  timer: 2000,
                  showConfirmButton: false
              });
              if (data.type=='success') {
                $('#tableCampaña').DataTable().ajax.reload();
              }
            },
            error: function (request, status, error) {
              if (request.responseJSON.message=='Unauthenticated.') {
              Swal.fire({
                  title: 'Sesión Expirada',
                  text : 'La sesión ha expirado y el proceso no se ha terminado, por favor ingrese al portal nuevamente',
                  icon : 'warning',
                  timer: 3000,
                  showConfirmButton:false
              });
              setInterval(function(){
                location.reload();
              },3000);
              }
            }
          });
        });
      })
$(document).on('change','select[name=campaña_predecesor]',function(){
  var fila = $(this).parents('tr')
  var id=fila.find('td').eq(5).html()
  var valor = $(this).val()
  $.ajax({
    url:baseurl+'/mantenimiento/producto_cliente/cambiarCamPred',
    type:'GET',
    data:{id:id,valor:valor},
    success:function(data){
    }
  })
})

$(document).on('click','.btn-cargar',function(e){
  console.log($(this).data('id'));
  $('#formAdjuntoComentario input[name=id]').val($(this).data('id'))
  $('#AdjuntoComentarioModal').modal('show')
})

$(document).on('submit','#formAdjuntoComentario',function(e){
  e.preventDefault()
  var id = $(this).data('id')
  var formData = new FormData(this);
  console.log(formData);
  console.log($(this).serialize());
  $.ajax({
    url: baseurl + '/mantenimiento/producto_cliente/cargarAdjCamp',
    cache: false,
    contentType: false,
    processData: false,
    data: formData,
    type: 'POST',
    beforeSend: function(){
      swal({
        title: "Cargando",
        imageUrl: asset + "/img/loader.gif",
        text:  "Espere un Momento,no cierre la ventana.",
        showConfirmButton: false
      });
    },
    success: function(data){
      console.log(data.error)
      swal({
        title: data.title,
        type:  data.type,
        text:  data.text,
        timer: 2000,
        showConfirmButton: false
    });
    if (data.type=='success') {
      // loadData()
      $('#AdjuntoComentarioModal').modal('hide')
      producto = $('#formProductoCalendario input[name=id]').val()
      loadCampaña(producto)
    }
    },
    error: function (request, status, error) {
      if (request.responseJSON.message=='Unauthenticated.') {
      Swal.fire({
          title: 'Sesión Expirada',
          text : 'La sesión ha expirado y el proceso no se ha terminado, por favor ingrese al portal nuevamente',
          icon : 'warning',
          timer: 3000,
          showConfirmButton:false
      });
      setInterval(function(){
        location.reload();
      },3000);
      }
    }
  })
})

$(document).on('click','.btn-eliminar-adjunto-campaña',function(){
  id = $(this).data('id')
  url = $(this).data('url')
  $.ajax({
    url: baseurl + '/mantenimiento/producto_cliente/eliminarAdjCamp',
    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    type: 'get',
    data: {id,url},
    beforeSend: function(){
      swal({
        title: "Cargando",
        imageUrl: asset + "/img/loader.gif",
        text:  "Espere un Momento,no cierre la ventana.",
        showConfirmButton: false
      });
    },
    success: function(data){
      console.log(data.error)
      swal({
        title: data.title,
        type:  data.type,
        text:  data.text,
        timer: 2000,
        showConfirmButton: false
    });
    if (data.type=='success') {
      // loadData()
      producto = $('#formProductoCalendario input[name=id]').val()
      loadCampaña(producto)
    }
    },
    error: function (request, status, error) {
      if (request.responseJSON.message=='Unauthenticated.') {
      Swal.fire({
          title: 'Sesión Expirada',
          text : 'La sesión ha expirado y el proceso no se ha terminado, por favor ingrese al portal nuevamente',
          icon : 'warning',
          timer: 3000,
          showConfirmButton:false
      });
      setInterval(function(){
        location.reload();
      },3000);
      }
    }
  })
})
