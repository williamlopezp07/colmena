
$(document).ready(function(){
  $('#busquedaModal').modal('show')
  $.ajax({
    url:baseurl+'/consultas/influencer',
    type:'GET',
    success:function(data){
      (data.red_social).forEach((item, i) => {
        $('#red_social').append('<option value="'+item.id+'">'+item.red_social+'</option>')
      });
      $('#categoria').selectize({
          valueField: 'id',
          labelField: 'descripcion',
          searchField: 'descripcion',
          options: data.categorias,
          create: false
      })
      // (data.categorias).forEach((item, i) => {
      //   $('#categoria').append('<option value="'+item.id+'">'+item.descripcion+'</option>')
      // });
        $('#influencer_string').val(JSON.stringify(data.influencers))
        // sessionStorage.setItem('influencers',JSON.stringify(data.influencers))
        sessionStorage.setItem('categorias',JSON.stringify(data.categorias))
        // sessionStorage.setItem('red_social',JSON.stringify(data.red_social))

    }
  })
})
$(document).on('change','#checkAll',function(e){
  if($('#checkAll').prop('checked')) {
    $('#categoria').attr('disabled','disabled')
      $('.categoria_div').hide()
  }else {
    $('.categoria_div').show()
    $('#categoria').attr('disabled',false)
  }
})
$(document).on('submit','#formBusqueda',function(e){
  e.preventDefault()
  influencers = $('#influencer_string').val()
  categorias = sessionStorage.getItem('categorias')
  // red_social = sessionStorage.getItem('red_social')
  sessionStorage.setItem('red_social_selected',$('#red_social  option:selected').text())
  data = []
  handle = ''
  seguidores =''
  er =''
  if ($('#categoria').val().length==0 ) {
    categorias_elegidas=[]
    JSON.parse(categorias).forEach((item, i) => {
      categorias_elegidas.push(item.id)
    });

  }else {
    categorias_elegidas =$('#categoria').val()
  }
  // categorias_elegidas =( $('#categoria').val().length==0 ?  : $('#categoria').val());
  console.log(categorias_elegidas)
// categorias_elegidas = $('#categoria').val()
  JSON.parse(influencers).forEach((item, i) => {
    if ($('#categoria').val().length>0 ) {
      categorias_elegidas.forEach((itemCat, j) => {
        if (item.categorias!=null && item.categorias!='') {
          if (item.categorias.split(',').includes(itemCat)) {
            if (item.metricas!=null ) {
              JSON.parse(item.metricas).forEach((item1, j) => {
                if (item1[0].red_social==$('#red_social  option:selected').text()) {
                  condicion = false;
                  (item1[0].metricas).forEach((item2, k) => {
                    if (item2.input=='seguidores' && parseInt(item2.valor)>=$('#seguidores').val() && parseInt(item2.valor)<=$('#max_seguidores').val()) {
                      condicion = true;
                    }
                  });
                  (item1[0].metricas).forEach((item2, k) => {
                    if (condicion) {
                      if (item2.input=='handle') {
                        handle = item2.valor
                      }
                      if (item2.input=='seguidores') {
                        seguidores = item2.valor
                      }
                      if ($('#red_social').val()=='1') {
                        if (item2.input=='er_reel') {
                          er = item2.valor
                        }
                      }
                      if ($('#red_social').val()=='2') {
                        if (item2.input=='er_video') {
                          er = item2.valor
                        }
                      }
                    }
                  });
                  if (condicion) {
                    data.push({
                      influencer : item.influencer_descripcion,
                      influencer_codigo : item.influencer_codigo,
                      categorias : item.categorias,
                      ciudad : (item.ciudad!=null) ? item.ciudad : '',
                      handle : handle,
                      er : er,
                      seguidores : new Intl.NumberFormat().format(seguidores),
                      red_social : item1[0].red_social
                    })
                  }
                }
              });
            }
          }
        }
      });
    } else {
        if (item.categorias!=null && item.categorias!='') {
            if (item.metricas!=null ) {
              JSON.parse(item.metricas).forEach((item1, j) => {
                if (item1[0].red_social==$('#red_social  option:selected').text()) {
                  condicion = false;
                  (item1[0].metricas).forEach((item2, k) => {
                    if (item2.input=='seguidores' && parseInt(item2.valor)>=$('#seguidores').val() && parseInt(item2.valor)<=$('#max_seguidores').val()) {
                      condicion = true;
                    }
                  });
                  (item1[0].metricas).forEach((item2, k) => {
                    if (condicion) {
                      if (item2.input=='handle') {
                        handle = item2.valor
                      }
                      if (item2.input=='seguidores') {
                        seguidores = item2.valor
                      }
                      if ($('#red_social').val()=='1') {
                        if (item2.input=='er_reel') {
                          er = item2.valor
                        }
                      }
                      if ($('#red_social').val()=='2') {
                        if (item2.input=='er_video') {
                          er = item2.valor
                        }
                      }
                    }
                  });
                  if (condicion) {
                    data.push({
                      influencer : item.influencer_descripcion,
                      influencer_codigo : item.influencer_codigo,
                      categorias : item.categorias,
                      ciudad : (item.ciudad!=null) ? item.ciudad : '',
                      handle : handle,
                      er : er,
                      seguidores : new Intl.NumberFormat().format(seguidores),
                      red_social : item1[0].red_social
                    })
                  }
                }
              });
            }
        }
    }

  });
  $('#tabla').DataTable().destroy()
  data_filtrada = data.filter(x => (x.handle).includes($('#handle').val()) && (x.influencer).includes($('#nombre').val()) && (x.ciudad).includes($('#ubicacion').val()))
  $('#tabla').DataTable({
    dom: 'Bfrtip',
    buttons: [
      {
        extend: 'excelHtml5',
        exportOptions: {
          columns: [ 1, 2, 4, 5, 6, 7,8,9]
        },
        attr: {
          "data-toggle" : "tooltip",
          "data-placement" : "top",
          "title" : "Exportar las filas seleccionadas a Excel"
        },
      },{
          text: 'PDF',
          action: function ( e, dt, node, config ) {
            var table= $('#tabla').DataTable();
            var rows = table.column(0).checkboxes.selected();
            var items = [];
            if (rows.length==0) {
              alert("Seleccione por lo menos un influencer para generar el pdf")
            }else {
              $.each(rows,function(index,rowId){
                items.push(rowId);
              });
              console.log(items)
              $.ajax({
                url:baseurl+'/consultas/influencer/pdf',
                data:{items,red_social:sessionStorage.getItem('red_social_selected')},
                type:  'post',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data){
                  window.open(data)
                }
              });
            }
          }
        }
    ],
    data: data_filtrada,
    columns: [
        { data: 'influencer_codigo' },
        { data: 'influencer' },
        { data: 'handle' },
        {data:null,render:function(data){
          info = '';
          if (data.red_social=='instagram') {
            info = info + '<center><a href="https://www.instagram.com/' + (data.handle).replace('@', '')+'" target="_blank"><span class="badge bg-pink" >IG</span> </a></center><br>'
          }else if (data.red_social=='tiktok') {
            info = info + '<center><a href="https://www.tiktok.com/@' + (data.handle).replace('@', '')+'" target="_blank"><span class="badge bg-dark" >TT</span> </a></center><br>'
          }else if (data.red_social=='twitter') {
            info = info + '<center><a href="https://twitter.com/' + (data.handle).replace('@', '')+'" target="_blank"><span class="badge bg-cyan" >TW</span> </a></center><br>'
          }else if (data.red_social=='youtube') {
            info = info + '<center><a href="https://www.youtube.com/c/' + (data.handle).replace('@', '')+'" target="_blank"><span class="badge bg-danger" >YT</span> </a></center><br>'
          }else if (data.red_social=='facebook') {
            info = info + '<center><a href="https://www.facebook.com/' + (data.handle).replace('@', '')+'" target="_blank"><span class="badge bg-primary" >FB</span> </a></center><br>'
          }
          return info
        }},
        {data:null,render:function(data){
          info = '';
          if (data.red_social=='instagram') {
            info = info + 'https://www.instagram.com/' + (data.handle).replace('@', '')+''
          }else if (data.red_social=='tiktok') {
            info = info + 'https://www.tiktok.com/@' + (data.handle).replace('@', '')+''
          }else if (data.red_social=='twitter') {
            info = info + 'https://twitter.com/' + (data.handle).replace('@', '')+''
          }else if (data.red_social=='youtube') {
            info = info + 'https://www.youtube.com/c/' + (data.handle).replace('@', '')+''
          }else if (data.red_social=='facebook') {
            info = info + 'https://www.facebook.com/' + (data.handle).replace('@', '')+''
          }
          return info
        }},
        { data: 'ciudad' },
        {data:null,render:function(data){
          string = '';
          if (data.categorias!=null) {
            categoriesSelecteds = data.categorias.split(',');
            if (categoriesSelecteds.length>0) {
              categoriesSelecteds.forEach(element => string = string + (JSON.parse(categorias).filter(word => word.id==element)[0].descripcion)  + '<br>');
            }

          }
          return string;
        }},
        { data: 'red_social' },
        { data: 'er' },
        { data: 'seguidores' },
    ],
    select: {
      'style': 'multi'
     },
    "columnDefs": [
      {
        'targets': 0,
        'render': function(data, type, row, meta){
          if(type === 'display'){
            data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
          }
          return data;
        },
        'checkboxes': {
          'selectRow': true,
          'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
        }
      },
      {
        "targets": [ 4 ],
        className: "d-none"
        }
     ]
});
$('#busquedaModal').modal('hide')
})
