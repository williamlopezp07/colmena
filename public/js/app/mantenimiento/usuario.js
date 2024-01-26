$(document).on('submit','#formUsuario',function(e){
  e.preventDefault()
  const form = $(this)
  $.ajax({
    url: baseurl + '/mantenimiento/usuario/store',
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
      setTimeout(function(){
        location.reload()
      }, 2000);
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

$(document).on('submit','#formChangePass',function(e){
  e.preventDefault()
  const form = $(this)
  $.ajax({
    url: baseurl + '/mantenimiento/usuario/changePass',
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
      $('#changePassModal').modal('hide')
      setTimeout(function(){
        location.reload()
      }, 2000);
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
