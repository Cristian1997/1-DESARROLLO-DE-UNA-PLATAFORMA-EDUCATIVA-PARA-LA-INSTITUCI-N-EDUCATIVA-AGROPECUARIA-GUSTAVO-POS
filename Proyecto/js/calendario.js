// calendario.js

// Función para generar los días del calendario
function generarDias() {
    var now = new Date();
    var mesActual = now.getMonth();
    var añoActual = now.getFullYear();
    var diaActual = now.getDate();
  
    var daysInMonth = new Date(añoActual, mesActual + 1, 0).getDate();
    var firstDay = new Date(añoActual, mesActual, 1).getDay();
  
    var calendarBody = document.getElementById('calendar-body');
    calendarBody.innerHTML = '';
  
    var dayCounter = 1;
    for (var i = 0; i < 6; i++) {
      var row = document.createElement('tr');
  
      for (var j = 0; j < 7; j++) {
        var cell = document.createElement('td');
        if (i === 0 && j < firstDay) {
          cell.textContent = '';
        } else if (dayCounter > daysInMonth) {
          cell.textContent = '';
        } else {
          cell.textContent = dayCounter;
          if (añoActual === now.getFullYear() && mesActual === now.getMonth() && dayCounter === diaActual) {
            cell.classList.add('current-day');
          }
          dayCounter++;
        }
        row.appendChild(cell);
      }
  
      calendarBody.appendChild(row);
    }
  }
  
  // Función para actualizar el título del mes y año
  function actualizarTitulo() {
    var now = new Date();
    var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
      "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];
    var mes = meses[now.getMonth()];
    var año = now.getFullYear();
  
    var titulo = mes + ' ' + año;
    document.querySelector('.datepicker-switch').textContent = titulo;
  }
  
  // Función para determinar si un año es bisiesto
  function esBisiesto(año) {
    return (año % 4 === 0 && año % 100 !== 0) || (año % 400 === 0);
  }
  
  // Llamar a las funciones iniciales
  generarDias();
  actualizarTitulo();
  
  // Llamar a la función cada segundo para actualizar la fecha y hora
  setInterval(actualizarTitulo, 1000);

  // Función para calcular los porcentajes basados en los periodos
  function calcularPorcentajes() {
    var ahora = new Date();
    var dia = ahora.getDate();
    var mes = ahora.getMonth() + 1; // Se suma 1 porque los meses van de 0 a 11
    var año = ahora.getFullYear();
  
    // Define los periodos, teniendo en cuenta las vacaciones
    var diasEnPeriodo = {
      periodo1: 71,  // 20 enero al 31 marzo
      periodo2: 81,  // 1 abril al 20 junio
      periodo3: 73,  // 20 julio al 30 septiembre
      periodo4: 62   // 1 octubre al 1 diciembre
    };
  
    // Calcula los días transcurridos para el periodo 1 (20 enero al 31 marzo)
    var inicioPeriodo1 = new Date(año, 0, 20);
    var finPeriodo1 = new Date(año, 2, 31);
    var diasTranscurridos1 = Math.max(0, Math.min(diasEnPeriodo.periodo1, (ahora - inicioPeriodo1) / (1000 * 60 * 60 * 24)));
    var porcentaje1 = (diasTranscurridos1 / diasEnPeriodo.periodo1) * 100;
  
    // Calcula los días transcurridos para el periodo 2 (1 abril al 20 junio)
    var inicioPeriodo2 = new Date(año, 3, 1);
    var finPeriodo2 = new Date(año, 5, 20);
    var diasTranscurridos2 = Math.max(0, Math.min(diasEnPeriodo.periodo2, (ahora - inicioPeriodo2) / (1000 * 60 * 60 * 24)));
    var porcentaje2 = (diasTranscurridos2 / diasEnPeriodo.periodo2) * 100;
  
    // Calcula los días transcurridos para el periodo 3 (20 julio al 30 septiembre)
    var inicioPeriodo3 = new Date(año, 6, 20);
    var finPeriodo3 = new Date(año, 8, 30);
    var diasTranscurridos3 = Math.max(0, Math.min(diasEnPeriodo.periodo3, (ahora - inicioPeriodo3) / (1000 * 60 * 60 * 24)));
    var porcentaje3 = (diasTranscurridos3 / diasEnPeriodo.periodo3) * 100;
  
    // Calcula los días transcurridos para el periodo 4 (1 octubre al 1 diciembre)
    var inicioPeriodo4 = new Date(año, 9, 1);
    var finPeriodo4 = new Date(año, 11, 1);
    var diasTranscurridos4 = Math.max(0, Math.min(diasEnPeriodo.periodo4, (ahora - inicioPeriodo4) / (1000 * 60 * 60 * 24)));
    var porcentaje4 = (diasTranscurridos4 / diasEnPeriodo.periodo4) * 100;
  
    // Actualiza los elementos HTML con los porcentajes
    document.getElementById('periodo1').textContent = porcentaje1.toFixed(2) + '%';
    document.getElementById('barra1').style.width = porcentaje1 + '%';
  
    document.getElementById('periodo2').textContent = porcentaje2.toFixed(2) + '%';
    document.getElementById('barra2').style.width = porcentaje2 + '%';
  
    document.getElementById('periodo3').textContent = porcentaje3.toFixed(2) + '%';
    document.getElementById('barra3').style.width = porcentaje3 + '%';
  
    document.getElementById('periodo4').textContent = porcentaje4.toFixed(2) + '%';
    document.getElementById('barra4').style.width = porcentaje4 + '%';
  }
  
  // Llama a la función para calcular los porcentajes
  calcularPorcentajes();
  