function loadData(){
    $('#consulta').DataTable({

        language:{
         url: asset + "/js/spanish.json"
        },
        order:[[0,'desc']],
        destroy:true,
        bAutoWidth: false,
        bProcessing: true,
        iDisplayLength: 25,
        ajax:{
            url:baseurl+'/mantenimiento/influencer/',
            type:'GET',
        },
        columns:[
          {data:'influencer_codigo'},
          {data:null,render:function(data){
            if (data.foto==null || data.foto=='') {
                return ''
            } else {
              return '<img class="avatar-img img-fluid" src="'+data.foto+'"">';
            }
          }},
          {data:'influencer_descripcion'},
          {data:'representacion'},
          {data:'persona_contacto'},
          {data:null,render:function(data){
            if (data.exclusividad_agencia==null || data.exclusividad_agencia=='') {
                return ''
            } else {
              return data.exclusividad_agencia;
            }
          }},
          {data:'celular'},
          {data:'correo'},
          {data:'ciudad'},
          {data:null,render:function(data){
            string = '';

            if (data.categorias!=null) {
              categoriesSelecteds = data.categorias.split(',');
              if (categoriesSelecteds.length>0) {
                categoriesSelecteds.forEach(element => string = string + (categoriasArray.filter(word => word.id==element)[0].descripcion)  + '<br>');
              }

            }
            return string;
          }},
          {data:null,render:function(data){
            if (data.metricas==null) {
              return '';
            }else {
              info = '';
              JSON.parse(data.metricas).forEach((item, i) => {
                item[0].metricas.forEach((item1, j) => {
                  if (item1.input=='handle' && item1.valor!='') {
                    if (item[0].red_social=='instagram') {
                      info = info + '<center><a href="https://www.instagram.com/' + (item1.valor).replace('@', '')+'" target="_blank"><span class="badge bg-pink" >IG</span> </a></center><br>'
                    }else if (item[0].red_social=='tiktok') {
                      info = info + '<center><a href="https://www.tiktok.com/@' + (item1.valor).replace('@', '')+'" target="_blank"><span class="badge bg-dark" >TT</span> </a></center><br>'
                    }else if (item[0].red_social=='twitter') {
                      info = info + '<center><a href="https://twitter.com/' + (item1.valor).replace('@', '')+'" target="_blank"><span class="badge bg-cyan" >TW</span> </a></center><br>'
                    }else if (item[0].red_social=='youtube') {
                      info = info + '<center><a href="https://www.youtube.com/c/' + (item1.valor).replace('@', '')+'" target="_blank"><span class="badge bg-danger" >YT</span> </a></center><br>'
                    }else if (item[0].red_social=='facebook') {
                      info = info + '<center><a href="https://www.facebook.com/' + (item1.valor).replace('@', '')+'" target="_blank"><span class="badge bg-primary" >FB</span> </a></center><br>'
                    }
                  }
                });
              });
              return info
            }
          }},
          {data:'usuario'},
          {data:null,render:function(data){
            return `
            <button type="button" class="btn btn-info btn-sm btn-editar" name="button" data-id="${data.influencer_codigo}">datos</button>
            <button type="button" class="btn btn-dark btn-sm btn-metricas" name="button" data-id="${data.influencer_codigo}">metricas</button>
            <button type="button" class="btn btn-dark btn-sm btn-historial" name="button" data-id="${data.influencer_codigo}">historial</button>
            <button type="button" class="btn btn-warning btn-sm btn-campañas" name="button" data-id="${data.influencer_codigo}">campañas</button>
              `
          }},
        ]

    });
}
function loadHistorial(influencer){
    $('#tableHistorial').DataTable({

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
            url:baseurl+'/mantenimiento/influencer/historialMetrica',
            type:'GET',
            data:{influencer:influencer}
        },
        columns:[
          {data:'fecha'},
          {data:'usuario'},
          {data:null,render:function(data){
            return `
            <button type="button" class="btn btn-dark btn-sm btn-metricas-historial" name="button" data-id="${data.id}">metricas</button>
              `
          }},
        ]

    });
}
function loadCampaña(influencer){
    $('#tblCampaña').DataTable({

        language:{
         url: asset + "/js/spanish.json"
        },
        // order:[[0,'desc']],
        destroy:true,
        "ordering": false,
        bAutoWidth: false,
        deferRender:true,
        bProcessing: true,
        stateSave:true,
        iDisplayLength: 10,
        ajax:{
            url:baseurl+'/mantenimiento/influencer/getHistorialCampaña',
            type:'GET',
            data:{influencer:influencer}
        },
        columns:[
          {data:'PCNOMBRE'},
          {data:'producto'},
          {data:'campaña'},
          {data:'PDGLOSA'},
          {data:'PDFECPRO'},
          {data:'PDPRETAR'},
          {data:'PDPREUNIT'},
          {data:'PDMONEDA'},
        ]
    });
}
loadData();

$(document).on('change','input[type=file]',function(){
  const MAXIMO_TAMANIO_BYTES = 2000000;
  const $this = this
  const archivo = $this.files[0];
  if (archivo.size > MAXIMO_TAMANIO_BYTES) {
    const tamanioEnMb = MAXIMO_TAMANIO_BYTES / 1000000;
    alert(`El tamaño máximo es ${tamanioEnMb} MB`);
    swal({
        title: "TAMAÑO DE ARCHIVO!",
        type:"info",
        text: "SÓLO SE PERMITE UN TAMAÑO MÁXIMO DE 2MB!!!",
        timer: 3000,
        showConfirmButton: false
      });
    $this.value = "";
  }
})

$(document).on('submit','#formMantto',function(e){
  e.preventDefault()
  var formData = new FormData(this);
  var checkbox = $('#formMantto input[type=checkbox]:checked');//Filas Seleccionadas
  var categorias = [];//Array que contendrá los elementos

    $.each(checkbox,function(index,rowId){
      categorias.push(rowId.value);
    });
    formData.append('categorias',categorias);
  $.ajax({
    url: baseurl + '/mantenimiento/influencer/store',
    type: 'POST',
    cache: false,
    contentType: false,
    processData: false,
    data: formData,
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
      location.reload();
      // loadData()
      $('#Modal').modal('hide')
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
$(document).on('click','#changeImage',function(e){
  $('#changeImage').hide()
  $('#formFile').show()
})

$(document).on('click','.btn-editar',function(e){
  e.preventDefault()
  const id = $(this).data('id')
  $('.modal-title').html('Actualizar Datos');
  $('#formMantto input[name=influencer]').val(id)
  $('#formMantto input[name=influencer_descripcion]').attr('readonly','readonly')
  $('#formMantto input[name=influencer_foto]').val('')
  $('#changeImage').show()
  $('#formFile').hide()
  $.ajax({
    url: baseurl + '/mantenimiento/influencer/edit',
    type: 'get',
    data: {id:id},
    beforeSend: function(){
      $('#formMantto img').attr('src','https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_960_720.png')
    },
    success: function(data){
      console.log(data.error)
      if (data.foto==null || data.foto=='') {
      }else {
        $('#formMantto img').attr('src',data.foto)
      }
      $('#Modal').modal('show')
      $('#formMantto input[name=influencer]').val(data.influencer_codigo)
      $('#formMantto input[name=influencer_descripcion]').val(data.influencer_codigo)
      $('#formMantto input[name=representacion]').val(data.representacion)
      $('#formMantto input[name=correo]').val(data.correo)
      $('#formMantto input[name=celular]').val(data.celular)
      $('#formMantto input[name=ruc]').val(data.ruc)
      $('#formMantto input[name=banco]').val(data.banco)
      $('#formMantto input[name=nro_cta_bancaria]').val(data.nro_cta_bancaria)
      $('#formMantto input[name=banco_usd]').val(data.banco_usd)
      $('#formMantto input[name=nro_cta_bancaria_usd]').val(data.nro_cta_bancaria_usd)
      $('#formMantto input[name=nro_cta_detraccion]').val(data.nro_cta_detraccion)
      $('#formMantto input[name=ciudad]').val(data.ciudad)
      $('#formMantto input[name=persona_contacto]').val(data.persona_contacto)
      // $('#formMantto select[name=moneda_cta_bancaria]').val(data.moneda_cta_bancaria)
      $('#formMantto select[name=moneda_cta_detraccion]').val(data.moneda_cta_detraccion)
      $('#formMantto select[name=exclusividad_agencia]').val(data.exclusividad_agencia)
      $('#formMantto input[type=checkbox]').prop("checked",false)
      if (data.categorias!='') {
        categoriesSelecteds = data.categorias.split(',');
      }else {
        categoriesSelecteds = []
      }
      if (categoriesSelecteds.length>0) {
        categoriesSelecteds.forEach(element => $('#categoria'+element).prop("checked",true));
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
$(document).on('click','.btn-metricas',function(e){
  e.preventDefault()
  const id = $(this).data('id')
  $('.modal-title').html('Métricas del Influencer');
  $('#formMetricas input[name=influencer]').val(id)
  $.ajax({
    url: baseurl + '/mantenimiento/influencer/editMetrica',
    type: 'get',
    data: {id:id},
    success: function(data){
      console.log(data.error)
      $('#MetricasModal').modal('show')
      $('#divMetricas').html(data)
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
$(document).on('click','.btn-historial',function(e){
  e.preventDefault()
  const id = $(this).data('id')
  $('.modal-title').html('Historial de Métricas');
  loadHistorial(id)
  $('#HistorialModal').modal('show')
})
$(document).on('click','.btn-campañas',function(e){
  e.preventDefault()
  const id = $(this).data('id')
  loadCampaña(id)
  $('#CampañasModal').modal('show')
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
        url:baseurl+'/mantenimiento/accion/destroy',
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
  function ArrayAvg(myArray) {
      var i = 0, summ = 0, ArrayLen = myArray.length;
      while (i < ArrayLen) {
          summ = summ + parseInt(myArray[i++]);
  }
      return summ / ArrayLen;
  }

  function actualizarMetrica(){
    $(".array_prom").each(function () {

      const div_pane = $(this).parents('.tab-pane')
      const valor = $(this).val();
      const name = $(this).attr('name');
      console.log(div_pane.attr('id'));

      const array = valor.split(',')
        prom = ArrayAvg(array);

      let castigo = div_pane.find('input[name=castigo_'+name+']').val();
          div_pane.find('input[name=prom_'+name+']').val((prom*castigo/100).toFixed(2))
          if (div_pane.find('input[name=seguidores]').val()>0) {
            er = (prom*castigo/100)/(div_pane.find('input[name=seguidores]').val())
          }else {
            er = 0
          }

          div_pane.find('input[name=er_'+name+']').val((er) ? (er*100).toFixed(2) : 0.00)
          // console.log((er*100).toFixed(2))
          // console.log(name)
          div_pane.find('input[name=er_'+name+']').removeClass("border-danger")
          div_pane.find('input[name=er_'+name+']').removeClass("border-success")
          if (er>=0.10) {
            div_pane.find('input[name=er_'+name+']').addClass("border border-4 border-success")
          }else {
            div_pane.find('input[name=er_'+name+']').addClass("border border-4 border-danger")
          }

          if (prom>0) {
            div_pane.find('input[name=er_'+name+']').attr('min','1')
            div_pane.find('input[name=er_'+name+']').attr('max','100')
          } else {
            div_pane.find('input[name=er_'+name+']').removeAttr('min','1')
            div_pane.find('input[name=er_'+name+']').removeAttr('max','100')
          }
    })
  }
  $(document).on('change','.array_prom,.seguidores,.castigo',function(){
    actualizarMetrica()
  })
  $(document).on('submit','#formMetricas',function(e){
    e.preventDefault()
    var items = [];
    form = $(this)
    $(".tab-pane").each(function(){
      json_total=''
      $(this).find('input').each(function(){
        json ='';
        json = json + '"input":"'+$(this).attr('name')+'",'+'"valor":"'+$(this).val()+'"'
        obj=('{'+json+'}');
        json_total=json_total+','+(obj);
      })
      $(this).find('select').each(function(){
        json ='';
        json = json + '"input":"'+$(this).attr('name')+'",'+'"valor":"'+$(this).val()+'"'
        obj=('{'+json+'}');
        json_total=json_total+','+(obj);
      })
      $(this).find('textarea').each(function(){
        json ='';
        json = json + '"input":"'+$(this).attr('name')+'",'+'"valor":"'+$(this).val()+'"'
        obj=('{'+json+'}');
        json_total=json_total+','+(obj);
      })
      var array_json=('['+json_total.substr(1)+']');

      array = '[{"red_social":"'+$(this).attr('id')+'","metricas":'+array_json+'}]';

      items = items+','+array
        //items.push(JSON.parse(array));

    })
    items = JSON.parse('['+items.substr(1)+']')
    $.ajax({
      url: baseurl + '/mantenimiento/influencer/storeMetrica',
      type: 'POST',
      data: form.serialize()+'&metricasArray='+JSON.stringify(items),
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

  $(document).on('click','.btn-metricas-historial',function(){
    var id = $(this).data('id')
    $.ajax({
      url: baseurl + '/mantenimiento/influencer/getHistorialMetrica',
      type: 'get',
      data: {id:id},
      beforeSend: function(){
        $('#divMetricasHistorial').html('<center><img  src="'+asset+'/img/loader.gif'+'"></center>')
      },
      success: function(data){
        $('#MetricasInfluencerModal').modal('show')
        $('#divMetricasHistorial').html(data)
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
