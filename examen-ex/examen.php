<?php

/* Solamente trabajamos si nos han enviado el parámetro "notas" desde el formulario,
    sino, volvemos al formulario */
    
    print "Contenido de post Enviar:".var_export($_POST["Enviar"]);
    print "<hr>";
    print "Contenido de is_set: ".var_export(isset($_POST["Enviar"]));
    print "<hr>";
    print "Contenido de isnull: ".var_export(is_null($_POST["Enviar"]));
    print "<hr>";
    print "Contenido de empty: ".var_export(empty($_POST["notas"]));
    print "<hr>";
       
    if(isset($_POST["Enviar"]) && !estaVacioFormulario($_POST["notas"])){

        $notas=$_REQUEST["notas"];
        $errores=[""];
        $hayErrores= false;

        foreach($notas as $key => $valor ){

            //Marranada para reemplazar el carácter decimal
            $valor = str_replace(",",".", $valor);

            if( !is_numeric($valor) ){
                array_push($errores, "La nota ".($key + 1)." no es numérica. Has puesto ($valor)");
                //echo "La nota $key no es numérica</br>";
                $hayErrores = true;
            }else {
                if(!esRangoAdmitido(intval($valor))){
                    //echo "La nota $key no tiene el rango permitido ($valor).</br>";
                    array_push($errores, "La nota $key no tiene el rango permitido. Has puesto ($valor) y sólo admito números del 0 al 10");
                    $hayErrores = true;
                }
            }        
        }

        if(!$hayErrores){
            $media = array_sum($notas) / count($notas);
            
            $mensaje = "Has suspendido";

            if($media >= 9) {
                $mensaje = "Sobresaliente";
            }elseif ($media >= 7){
                $mensaje = "Notable";
            }elseif ($media >= 5){
                $mensaje = "Suficiente";
            }

            echo "Tu nota media es $media. $mensaje</br>";
            echo "</br>";
            
            header("refresh:5;url=\"examen.html\"");
            echo "Volverás a la página de entrada dentro de 5 segundos";
        }else {
            
            echo "Se han producido los siguientes errores: ";
            foreach ($errores as $key => $error ){
                echo "$error<br/>";
            }

            echo "</br><a href='javascript:history.back();'>Volver atrás</a>";     
        }        
    }else {
       // header('Location: http://localhost/matins/examen-ex/examen.html');
    }

    function esRangoAdmitido($valor){
        return (intval($valor) >= 0 && intval($valor) <=10);
    }

    function estaVacioFormulario($array){
        $liRet = false;

        foreach($array as $key => $valor ){
            
        }

        return $liRet;
    }

?>