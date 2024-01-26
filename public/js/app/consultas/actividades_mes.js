function consulta(){
  $.ajax({
    url:baseurl+'/consultas/actividades_mes',
    data:{mes:$('#mes').val(),ejecutivo:$('#ejecutivo').val()},
    type:'GET',
    beforeSend: function(){
      $('#divTable').html('<center><img  src="'+asset+'/img/loader.gif'+'"></center>')
    },
    success:function(data){
      $('#divTable').html(data)
    }
  })
}
// $(document).ready(function(){
//   $('#busquedaModal').modal('show')
//
// })


consulta();

$(document).on('click','#filtrar',function(){
  consulta();

})
