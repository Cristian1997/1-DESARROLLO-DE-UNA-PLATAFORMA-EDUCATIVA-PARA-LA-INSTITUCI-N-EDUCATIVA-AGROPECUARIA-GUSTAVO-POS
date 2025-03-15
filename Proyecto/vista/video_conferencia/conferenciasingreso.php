
<?php
session_start();
if(!isset($_SESSION['S_IDUSUARIO'])){
    header('Location: ../Login/index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="conferencia.css">
    <title>EducaNet | Dashboard</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lobster+Two&display=swap" rel="stylesheet">
    <!-- my css file-->
    <script src='https://8x8.vc/vpaas-magic-cookie-c2891bbdaedf4d58aaf01898d2d3651c/external_api.js'></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <div class="thebody text-center">
        <div class="container align-items-center" style="margin-top: 1%;">
            <input type="text" id="roomNameInput" class="form-control" placeholder="Ingrese el nombre de la sala">
            <button id="start" class="btn btn-light btn-lg" type="button" onclick="iniciarVideoLlamada()" style="margin-top: 1%;"><b>Iniciar nueva video llamada</b></button>
        </div>
    </div>

    <div id="jitsi-container" class="container align-items-center" style="margin-top: 5%;">
    </div>

    <script>
    var container = document.querySelector('#jitsi-container');
    var api = null;

    function ocultarBotonYMostrarInput() {
        document.getElementById('start').style.display = 'none';
        document.getElementById('roomNameInput').style.display = 'none';
    }

    function iniciarVideoLlamada() {
        var fullRoomName = document.getElementById('roomNameInput').value;

        // Extraer el nombre de sala despues de 'https://meet.jit.si/'
        var roomName = fullRoomName.replace('https://meet.jit.si/', '');

        if (roomName.length < 50) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ingrese un nombre de sala válido',
            });
            return;
        }

        ocultarBotonYMostrarInput();

        var domain = "meet.jit.si";
        var options = {
            roomName: roomName,
            parentNode: container,
            width: window.innerWidth > 768 ? 1100 : window.innerWidth - 20,
            height: window.innerWidth > 768 ? 500 : 550,
            configOverwrite: {
        startWithAudioMuted: true,
        startWithVideoMuted: true
    },
    interfaceConfigOverwrite: {
  TOOLBAR_BUTTONS: [
    'microphone', 'camera', 'desktop', 'fullscreen',
    'hangup', 'profile', 'chat', 'settings', 'raisehand',
    'videoquality', 'tileview', 'download', 'help'
  ],
  SHOW_JITSI_WATERMARK: false, 
  HIDE_KICK_BUTTON_FOR_GUESTS: true
}

        };

        api = new JitsiMeetExternalAPI(domain, options);

        window.addEventListener('resize', () => {
            if (api) {
                api.executeCommand('avatarUrl', 'your_avatar_url');
                api.resize(window.innerWidth > 768 ? 1100 : window.innerWidth - 20, window.innerWidth > 768 ? 500 : 200);
            }
        });
    }
    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

