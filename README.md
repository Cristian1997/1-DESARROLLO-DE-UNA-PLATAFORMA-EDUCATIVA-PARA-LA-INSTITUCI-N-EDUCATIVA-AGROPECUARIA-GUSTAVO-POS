# Desarrollo de una Plataforma Educativa para la Institución Educativa Agropecuaria Gustavo Posada

EducaNet es una plataforma educativa web diseñada para la Institución Educativa Agropecuaria Gustavo Posada de Istmina. Su objetivo es facilitar el acceso a la educación en entornos digitales, promoviendo la equidad en comunidades con recursos limitados.

## Tecnologías utilizadas

**Arquitectura:** Modelo-Vista-Controlador (MVC)  
**Frontend:** HTML, CSS, JavaScript, AJAX  
**Backend:** PHP, MySQL  
**Metodología:** Kanban  

## Estructura del Proyecto

El proyecto sigue la arquitectura **Modelo-Vista-Controlador (MVC)**, organizada de la siguiente manera:

📂 **Proyecto** - Código fuente de la plataforma  
&nbsp;&nbsp;&nbsp;&nbsp;📂 **Plantilla** - Dashboard de AdminLTE  
&nbsp;&nbsp;&nbsp;&nbsp;📂 **modelo** - Archivos relacionados con la base de datos y lógica de negocio  
&nbsp;&nbsp;&nbsp;&nbsp;📂 **vista** - Archivos HTML y recursos visuales  
&nbsp;&nbsp;&nbsp;&nbsp;📂 **controlador** - Archivos PHP encargados de la gestión de las vistas y la lógica de la aplicación  
&nbsp;&nbsp;&nbsp;&nbsp;📂 **js** - Archivos JavaScript para la interacción y dinamismo de la plataforma  
&nbsp;&nbsp;&nbsp;&nbsp;📂 **Login** - Plantilla de inicio de sesión basada en Bootstrap  

📂 **Documentación** - Archivos PDF con información del proyecto  
&nbsp;&nbsp;&nbsp;&nbsp;📄 **Documentación-EducaNet.pdf** - Informe detallado del proyecto  
&nbsp;&nbsp;&nbsp;&nbsp;📄 **Manual de usuario EducaNet.pdf** - Guía de uso de la plataforma  

📂 **Base de Datos** - Scripts SQL para la configuración de la base de datos  
&nbsp;&nbsp;&nbsp;&nbsp;📄 **academia.sql** - Script de creación de la base de datos 

  ## Credenciales de Prueba

- **Administrador**  
  - Usuario: admin  
  - Contraseña: 123456  

- **Docente**  
  - Usuario: docente  
  - Contraseña: 123456  

- **Estudiante**  
  - Usuario: alumno  
  - Contraseña: 123456  

## ⚠Advertencia⚠


1. **Archivos faltantes de la plantilla:**  
   Dentro de la carpeta `Proyecto` se encuentra una subcarpeta llamada **"Plantilla"**, la cual contiene el dashboard de **AdminLTE**. Es posible que esta carpeta no contenga todos los elementos necesarios, ya que GitHub a veces limita la subida de archivos. Para solucionar esto, dentro de la raíz de la carpeta `Proyecto` se encuentra un archivo comprimado llamado **"Plantilla.rar"**, el cual contiene todos los archivos completos. Solo es necesario descomprimirlo para restaurar los archivos faltantes.  

2. **Librerías para generación de reportes:**  
   Dentro de `Proyecto/controlador/calificaciones/` se encuentran archivos `.rar` con las librerías necesarias para la generación de reportes en Excel y PDF. Debido a las limitaciones de GitHub, algunos archivos no se suben correctamente, por lo que es necesario extraerlos manualmente:  
   - **PhpSpreadsheet.rar**: Contiene **todos los archivos completos** de la librería **PhpSpreadsheet**, necesaria para generar reportes en **Excel**.  
   - **mpdf.part1.rar** y **mpdf.part2.rar**: Contienen **todos los archivos completos** de la librería **mPDF**, necesaria para la generación de reportes en **PDF**.  

   **Nota:** Para que las funcionalidades de generación de reportes funcionen correctamente, es imprescindible descomprimir estos archivos en sus respectivas ubicaciones.  

 

## Documentación

En la carpeta `Documentación` ubicada en la raíz del proyecto, se encuentran los siguientes archivos:  

- **Documentación-EducaNet.pdf**: Contiene la descripción detallada del proyecto, sus objetivos y alcance.  
- **Manual de usuario EducaNet.pdf**: Guía para el uso de la plataforma, explicando sus funciones y características principales.

## Aviso de Uso

Este proyecto fue desarrollado para la **Institución Educativa Agropecuaria Gustavo Posada** como trabajo de grado para optar por el título de **Ingeniería de Sistemas** en la **Fundación Universitaria Claretiana | Uniclaretiana**.  

**Queda estrictamente prohibido su uso con fines comerciales.** Este software está destinado exclusivamente para fines educativos.  

