<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <!--
    <meta http-equiv="X-Frame-Options" content="sameorigin">
    -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{$modulo}}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" type="text/javascript"></script>
  </head>
  <body style="padding: 10px">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <div id="content">
    <div class="container">
        <div class="row">
            <span style="color:rgb(27, 102, 201);font-weight:bold">Consulta Afp </span><br>
            <span style="color:rgb(0, 0, 0);font-weight:none">Obtener el AFP de la persona ingresando DNI </span><br>
        </div>
        <div class="row">
            <div class="col">               
                <div class="shadow-lg p-3 mb-5 mt-4 bg-body rounded">                                    
                    <div class="row g-3">
                        <div class="col-md-4 position-relative">
                            <label for="nombre" class="form-label">Ingrese Documento de <b>Identidad {DNI}</b>:</label>
                            <input type="text" class="form-control" id="serv_txt_dni" name="dni" value="" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 position-relative" style="padding: 10px">
                            <button id="serv_btnConsultarAfp" class="btn btn-warning fw-none float-end btnConsultarAfp" type="button"><i class="bi bi-search"></i> Consultar <b>AFP</b></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
                <div id="div_contenido_mostrar"></div>
        </div>
        <div class="row">
                <div id="div_contenido" style="display: none;"> </div>
        </div>
    </div>
    </div>
</body>
</html>

<script>      

    /*********[ CSRF-KEY ]********/
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function(){

        /*********[ MANTENIMIENTO ]********/
        
        //enter key buscar   
        var input = document.getElementById("serv_txt_dni");
        input.addEventListener("keyup", function(event) {
            if (event.keyCode === 13) {
                console.log('keypress serv_txt_dni');
                event.preventDefault();
                document.getElementById("serv_btnConsultarAfp").click();
            }
        });
        
        $(".btnConsultarAfp").click(function(){
            console.log('Obtener AFP');
            
            dni = $('#serv_txt_dni').val();
            
            console.log(dni);		
            
            $.post('{{asset('serv_afp/fun_obtener_afp')}}',
                {
                    dni 	: dni
                }, 
                function(data){
                    console.log(data);
                    $("#div_contenido").html(data);
                    
                    var elem = document.getElementById('ApellidoPaterno');
                    
                    console.log(elem);
                    
                    if(elem == null || elem == undefined ) {
                        console.log('fail');
                        //alert(data);
                        alert('No se ha encontrado ningún afiliado con el documento de identidad ingresado.');
                        $("#div_contenido_mostrar").html(data);
                        return false;		
                        
                    }else{
                        console.log('succes');
                    }
                    
                    var ap=document.getElementById("ApellidoPaterno").value;
                    var am=document.getElementById("ApellidoMaterno").value;
                    var nm1=document.getElementById("PrimerNombre").value;
                    var nm2=document.getElementById("SegundoNombre").value;
                    var fe=document.getElementById("FechaNacimiento").value;
                    var afp=document.getElementById("AFP").value;
                    
                    console.log(afp);
                    html = '';
                    html = html+'<center><table cellspacing="5" cellpadding="3" border="0">';
                        html = html+'<tr><td align="right">Apellido Paterno </td><td align="left">: <b>'+ap+'</b> </td><tr>';
                        html = html+'<tr><td align="right">Apellido Materno </td><td align="left">: <b>'+am+'</b> </td><tr>';
                        html = html+'<tr><td align="right">1er Nombre 		</td><td align="left">: <b>'+nm1+'</b> </td><tr>';
                        html = html+'<tr><td align="right">2do Nombre 		</td><td align="left">: <b>'+nm2+'</b> </td><tr>';
                        html = html+'<tr><td align="right">Fecha Nacimiento </td><td align="left">: <b>'+fe+'</b> </td><tr>';
                        html = html+'<tr><td align="right">AFP 				</td><td align="left">: <b>'+afp+'</b> </td><tr>';
                    html = html+'</table></center>';
                    
                    $("#div_contenido_mostrar").html(html);
                    
                }).fail(
                    function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                        console.log((jqXHR['responseJSON'])['message']);
                        console.log(textStatus);
                        console.log(errorThrown);
                        alert((jqXHR['responseJSON'])['message']);
                }
            );
        });
    });

</script>   