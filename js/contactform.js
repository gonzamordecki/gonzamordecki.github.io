jQuery(document).ready(function($) {
  "use strict";

  $.ajaxSetup({
    cache: false,
    type: 'POST',
    dataType: 'json',
    url: './php/ajax.php'
  });


  var leDebug = true,
      leClick = false,
      leError = false,
      leErrorCount = 0,

      leChorizo = /^(|(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6})$/i;


  cargarForm();

  // FORMULARIO //
  function recargaForm() {
    var $nombre = $('#nombre'),
        $apellido = $('#apellido'),
        $cedula = $('#cedula'),
        $email = $('#email'),
        $telefono = $('#telefono');

        $nombre.val('');
        $apellido.val('');
        $cedula.val('');
        $email.val('');
        $telefono.val('');
  }

  function validarCedula(ci) {
    if (leDebug) console.log(ci);
    var arrCoefs = [2,9,8,7,6,3,4,1];
    var suma = 0;
    var difCoef = parseInt(arrCoefs.length - ci.length);
    for (var i = ci.length - 1; i > -1; i--) {
      ss = ci.toString();
      var dig = ss.substring(i, i+1);
      var digInt = parseInt(dig);
      var coef = arrCoefs[i+difCoef];
      suma = suma + digInt * coef;
    }

    if ( (suma % 10) == 0 ) {
      return true;
    } else {
      return false;
    }
  }

  function cargarForm() {
    if (leDebug) console.log('cargarForm()');

    var $nombre = $('#nombre'),
        $apellido = $('#apellido'),
        $cedula = $('#cedula'),
        $email = $('#email'),
        $telefono = $('#telefono'),

        $leError = $('.msgError');

    $cedula.keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
      if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
        // Allow: Ctrl+A
        (e.keyCode == 65 && e.ctrlKey === true) ||
        // Allow: Ctrl+C
        (e.keyCode == 67 && e.ctrlKey === true) ||
        // Allow: Ctrl+X
        (e.keyCode == 88 && e.ctrlKey === true) ||
        // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
          // let it happen, don't do anything
          return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
      }
    });

    $('input[type="text"]').on('focus', function() {
      var $leThis = $(this);
      if ($leThis.hasClass('inputError')) {
        $leThis.removeClass('inputError');
      }
      leErrorCount--;
      if (leErrorCount === 0) {
        $leError.css({
          'opacity': 0,
          'visibility': 'hidden'
        });
      }
    });

    $('#formDatos').on('submit', 'form', function(e) {
      e.preventDefault();

      if (!leClick) {
        if (leDebug) console.log('leClick: true');
        leClick = true,
        leErrorCount = 0,
        leError = false;

        if (leDebug) console.log('validation');

        if ($nombre.val() === '' || $nombre.val() === $nombre.attr('placeholder')) {
          leError = true;
          $nombre.addClass('inputError');
          leErrorCount++;
          if (leDebug) console.log('error: $nombre');
          if (leErrorCount == 1) $leError.html($nombre.data('error'));
        }

        if ($apellido.val() === '' || $apellido.val() === $apellido.attr('placeholder')) {
          leError = true;
          $apellido.addClass('inputError');
          leErrorCount++;
          if (leDebug) console.log('error: $apellido');
          if (leErrorCount == 1) $leError.html($apellido.data('error'));
        }

        if ($cedula.val() === '' || $cedula.val() === $cedula.attr('placeholder')) {
          leError = true;
          $cedula.addClass('inputError');
          leErrorCount++;
          if (leDebug) console.log('error: $cedula');
          if (leErrorCount == 1) $leError.html($cedula.data('error'));
        } else {
          ciValida = validarCedula($cedula.val());
          if (ciValida == false) {
            leError = true;
            $cedula.addClass('inputError');
            leErrorCount++;
            if (leDebug) console.log('error: $cedula');
            if (leErrorCount == 1) $leError.html($cedula.data('error'));
            console.log('la cedula es '+ciValida);
          }
          console.log('la cedula es '+ciValida);
        }

        if (!leChorizo.test($email.val()) || $email.val() === '' || $email.val() === $email.attr('placeholder')) {
          leError = true;
          $email.addClass('inputError');
          leErrorCount++;
          if (leDebug) console.log('error: $email');
          if (leErrorCount == 1) $leError.html($email.data('error'));
        }

        if ($telefono.val() === '' || $telefono.val() === $telefono.attr('placeholder')) {
          leError = true;
          $telefono.addClass('inputError');
          leErrorCount++;
          if (leDebug) console.log('error: $telefono');
          if (leErrorCount == 1) $leError.html($telefono.data('error'));
        }

        if (leDebug) console.log('leError: ' + leError);
        if (leError) {
          if (leDebug) console.log('leErrorCount: '+ leErrorCount);
          if (leErrorCount > 1)
            $leError.html('Completar todos los campos');
          $leError.css({
            'visibility': 'visible',
            'opacity': 1
          });
          leClick = false;
          return;
        }

        var nombre = $nombre.val(),
            apellido = $apellido.val(),
            cedula = $cedula.val(),
            email = $email.val(),
            telefono = $telefono.val()

      saveFormData(nombre, apellido, cedula, email, telefono);
      }
    });
  }

  function saveFormData(nombre, apellido, cedula, email, telefono) {
    if (leDebug) console.log('saveFormData()');
    if (leDebug) console.log(nombre +' '+ apellido +' '+ cedula +' '+ email +' '+ telefono);

    $.ajax({
      data: {
        'leType': 'saveFormData',
        'leNombre': nombre,
        'leApellido': apellido,
        'leCedula': cedula,
        'leEmail': email,
        'leTelefono': telefono
      },

      success: function(data) {
        leClick = false;
        if (leDebug) console.log('status: ' + data.status + ' 01');

        if (data.status === 'ok') {

          $('.formDatos').css({
            'opacity': '0',
            'visibility': 'hidden'
          });
          $('.formDatosThk').css({
            'opacity': '1',
            'visibility': 'visible'
          });

          recargaForm();

          setTimeout(function(){
            $('.formDatos').css({
              'opacity': '1',
              'visibility': 'visible'
            });
            $('.formDatosThk').css({
              'opacity': '0',
              'visibility': 'hidden'
            });

          }, 5000);

          $.ajax({
            data: {
              'leType': 'mandaMail',
              'leNombre': nombre,
              'leApellido': apellido,
              'leCedula': cedula,
              'leEmail': email,
              'leTelefono': telefono
            },
            success: function(data) {
            }
          });

        } else {
          if (leDebug) console.log('status: ' + data.status + ' Status NO OK');
        }
      }
    });
    if (leDebug) console.log('FIN');
  }
});