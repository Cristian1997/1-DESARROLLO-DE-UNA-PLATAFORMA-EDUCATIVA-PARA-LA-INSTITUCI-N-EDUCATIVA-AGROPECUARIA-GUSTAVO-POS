<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
   
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
    require '../../modelo/modelo_usuario.php';

    $MU = new Modelo_Usuario();
    $email = htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8');
    $contraactual= htmlspecialchars($_POST['contrasena'],ENT_QUOTES,'UTF-8');
    $contra = password_hash($_POST['contrasena'],PASSWORD_DEFAULT,['cost'=>10]);
    $consulta = $MU->Restablecer_Contra($email,$contra);

    if($consulta=="1"){

   
        
     // Instantiation and passing `true` enables exceptions
     $mail = new PHPMailer(true);

     try {
         $mail->SMTPOptions = array(
             'ssl' => array(
             'verify_peer' => false,
             'verify_peer_name' => false,
             'allow_self_signed' => true
             )
         );
         //Server settings
         $mail->SMTPDebug = 0;                      // Enable verbose debug output
         $mail->isSMTP();                                            // Send using SMTP
         $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
         $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
         $mail->Username='tu coreosoportetecnico@gmail.com';//este debe ir en el address?
         $mail->Password='clave api';                            // SMTP password
         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
         $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

         //Recipients
         $mail->setFrom('tu coreosoportetecnico@gmail.com', 'Soporte EducaNet');
         $mail->addAddress($email);     // Add a recipient

         // Content
         $mail->isHTML(true);                                  // Set email format to HTML
         $mail->Subject = 'Restablecer Password';
         $mail->Body    = '<!DOCTYPE html>
         <html lang="en">
         <head>
             <meta charset="UTF-8">
             <meta name="viewport" content="width=device-width, initial-scale=1.0">
         </head>
         <body>
             <table style="border: 1px solid black;width: 100%;">
                 <thead>
                     <tr>
                         <td style="text-align: center;background: rgb(0, 140, 255);color:#FFFFFF" colspan="2">
                             <h1><b>EducaNet</b></h1>
                         </td>
                     </tr>
                     <tr>
                        
                         <td style="text-align: center;"><span style="font-size: 25px;">Le recomendamos que cambie su contraseña temporal por una personalizada lo antes posible,<br>Si tiene alguna pregunta o necesita ayuda, no dude en ponerse en contacto con nuestro equipo de soporte técnico.<br><br>Se ha generado una nueva contraseña provisional<br> Nueva contraseña: </b>'.$contraactual.'<br><br>APRECIADO USUARIO, ESTE CORREO FUE ENVIADO DE MANERA AUTOMATICA, FAVOR NO RESPONDER.</br></span></td>
                     </tr>
                 </thead>
             </table>
         </body>
         </html>';

         $mail->send();
         echo '1';
     } catch (Exception $e) {
         echo $e;
     }
 }else{
     echo '2';
 }
?>

