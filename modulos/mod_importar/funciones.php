<?php

include ("./../mod_conexion/conexionBaseDatos.php");
$nombretabla = $_POST['nombretabla'];
$pulsado = $_POST['pulsado'];

function borrar($nombretabla, $BDImportRecambios) {
    $consulta = "Delete from " . $nombretabla;
    mysqli_query($BDImportRecambios, $consulta);
}

function contarVacios($nombretabla, $BDImportRecambios) {
    $consulta = "SELECT RefFabPrin,linea FROM " . $nombretabla . " where Estado = ''";
    $consultaContador = mysqli_query($BDImportRecambios, $consulta);
    $i = 0;
    while ($row_planets = $consultaContador->fetch_assoc()) {
        $array[$i]["id"] = $row_planets['RefFabPrin'];
        $array[$i]["linea"] = $row_planets['linea'];
        $i++;
    }
    header("Content-Type: application/json;charset=utf-8");
    echo json_encode($array);
}

function contarVaciosCru($BDImportRecambios) {
    $consulta = "SELECT * FROM `referenciascruzadas` where Estado = '' limit 400";
    $consultaContador = mysqli_query($BDImportRecambios, $consulta);
    $i = 0;
    while ($row_planets = $consultaContador->fetch_assoc()) {
        $array[$i]["id"] = $row_planets['RefProveedor'];
        $array[$i]["linea"] = $row_planets['linea'];
        $array[$i]["F_rec"] = $row_planets['Fabr_Recambio'];
        $array[$i]["Ref_F"] = $row_planets['Ref_Fabricante'];
        $i++;
    }



    header("Content-Type: application/json;charset=utf-8");
    echo json_encode($array);
}

function verNuevosRef($BDImportRecambios) {
    $consulta = "Select * From listaprecios";
    $conNuevo = mysqli_query($BDImportRecambios, $consulta);
    $i = 0;
    while ($row_planets = $conNuevo->fetch_assoc()) {
        $array[$i]['coste'] = $row_planets['Coste'];
        $array[$i]['des'] = $row_planets['Descripcion'];
        $array[$i]['ref'] = $row_planets['RefFabPrin'];
        $array[$i]['estado'] = $row_planets['Estado'];
        $array[$i]['id'] = $row_planets['RecambioID'];
        $i++;
    }
    header("Content-Type: application/json;charset=utf-8");
    echo json_encode($array);
}

function contador($nombretabla, $BDImportRecambios) {
    $consulta = "SELECT count(linea) as cuenta FROM " . $nombretabla;
    $consultaContador = mysqli_query($BDImportRecambios, $consulta);
    $contador = $consultaContador->fetch_assoc();
    echo $contador['cuenta'];
}

function BuscarErrorFab($BDImportRecambios) {
    $array = array();
    $consulta = "SELECT DISTINCT(Fabr_Recambio) FROM `referenciascruzadas` WHERE Estado = ''";
    $conNuevo = mysqli_query($BDImportRecambios, $consulta);
    $i = 0;
    while ($row_planets = $conNuevo->fetch_assoc()) {
        $array[$i]['Fabr_Recambio'] = $row_planets['Fabr_Recambio'];

        $i++;
    }
    header("Content-Type: application/json;charset=utf-8");
    echo json_encode($array);
}

function comprobar($nombretabla, $BDImportRecambios, $BDRecambios) {
    $id = $_POST['idrecambio'];
    $l = $_POST['linea'];
    $f = $_POST['fabricante'];


    $consul = "SELECT * FROM referenciascruzadas where RefFabricanteCru ='" . $id . "'";
    $consultaReca = mysqli_query($BDRecambios, $consul);
    $consfinal = $consultaReca->fetch_assoc();

    if ($consfinal['RefFabricanteCru'] == $id && $consfinal['IdFabricanteCru'] == $f) {
        $actu = "UPDATE `listaprecios` SET `Estado`='existe',`RecambioID`=" . $consfinal['RecambioID'] . " WHERE `linea` ='" . $l . "'";
        mysqli_query($BDImportRecambios, $actu);
        $existente = 1;
    } else {
        $actu = "UPDATE `listaprecios` SET `Estado`='nuevo' WHERE `linea` ='" . $l . "'";
        mysqli_query($BDImportRecambios, $actu);
        $nuevo = 1;
    }

    $datos[0]['n'] = $nuevo;
    $datos[0]['e'] = $existente;
    $datos[0]['t'] = $l;
    header("Content-Type: application/json;charset=utf-8");
    echo json_encode($datos);
}

function comprobarCruzadas($BDImportRecambios, $BDRecambios) {
    $ref = $_POST['idrecambio'];
    $l = $_POST['linea'];
    $f = $_POST['fabricante'];
    $ref_f = $_POST['Ref_fa'];
    $fab_ref = $_POST['Fab_ref'];

    $conRefFab = "SELECT * FROM `referenciascruzadas` WHERE RefFabricanteCru = '" . $ref . "' and IdFabricanteCru = '" . $f . "'";
    $ejconRefFab = mysqli_query($BDRecambios, $conRefFab);
    $resul = mysqli_fetch_assoc($ejconRefFab);
    if ($resul) {
//        $datos[0]['respuesta'] = "exite la referencia principal";
        $busFacruz = "SELECT id FROM `fabricantesrecambios` WHERE Nombre = '" . $fab_ref . "'";
        $ejbusFacruz = mysqli_query($BDRecambios, $busFacruz);
        $resulFabCruz = mysqli_fetch_assoc($ejbusFacruz);
        $id = $resulFabCruz['id'];

////         $datos[0]['respuesta']="esta id de proveedor ".$id;
        $ConCruRefFab = "SELECT * FROM `referenciascruzadas` WHERE RefFabricanteCru = '" . $ref_f . "' and IdFabricanteCru = '" . $id . "'";
        $ejConCruRefFab = mysqli_query($BDRecambios, $ConCruRefFab);
        $resulCru = mysqli_fetch_assoc($ejConCruRefFab);

        if ($resulCru) {
            $buscarcruces = "SELECT * FROM `crucesreferencias` where idReferenciaCruz =" . $resulCru['id'];
            $consul = mysqli_query($BDRecambios, $buscarcruces);
            $resulbuscCru = mysqli_fetch_assoc($consul);
            $datos[0]['respuesta']=$resulbuscCru;
            if ($resulbuscCru) {
                $consul = "UPDATE `referenciascruzadas` SET `Estado`='ya existia en crueces referencias' WHERE RefProveedor ='" . $ref . "' and linea ='" . $l . "'";
                mysqli_query($BDImportRecambios, $consul);
            } else {
                $insert = "INSERT INTO `crucesreferencias`(`idReferenciaCruz`, `idRecambio`, `idFabricanteCruz`) VALUES (" . $resulCru['id'] . "," . $resulCru['RecambioID'] . "," . $id . ")";
                mysqli_query($BDRecambios, $insert);
                $consulact = "UPDATE `referenciascruzadas` SET `Estado`='no existia en cruce referencias' WHERE RefProveedor ='" . $ref . "' and linea ='" . $l . "'";
                mysqli_query($BDImportRecambios, $consulact);
            }
        } else {
          
            $creaCru = "INSERT INTO `referenciascruzadas`( `RecambioID`, `IdFabricanteCru`, `RefFabricanteCru`) VALUES ('0','" . $id . "','" . $ref_f . "')";
            mysqli_query($BDRecambios, $creaCru);
            $idrefCruzadas = $BDRecambios->insert_id;
            $insert = "INSERT INTO `crucesreferencias`( `idReferenciaCruz`, `idRecambio`, `idFabricanteCruz`) VALUES (" . $idrefCruzadas . "," . $resul['RecambioID'] . "," . $id . ")";
            mysqli_query($BDRecambios, $insert);
            $consul = "UPDATE `referenciascruzadas` SET `Estado`='Guardada en cruzadas' WHERE RefProveedor ='" . $ref . "' and linea ='" . $l . "'";
            mysqli_query($BDImportRecambios, $consul);
//            $datos[0]['respuesta']='tiene que crear la referencia cruzada id '.$idrefCruzadas." id remabio ".$resulCru[0]['RecambioID']." id_fabr_cru ".$id;
        }
    } else {
        $consul = "UPDATE `referenciascruzadas` SET `Estado`='ERROR[Referencia Principal]' WHERE RefProveedor ='" . $ref . "' and linea ='" . $l . "'";
        mysqli_query($BDImportRecambios, $consul);
        $datos[0]['respuesta'] = 'No existe la referencia principal';
    }
    header("Content-Type: application/json;charset=utf-8");
    echo json_encode($datos);
}

function BuscarError($BDImportRecambios) {
    $consul = "UPDATE `referenciascruzadas` SET `Estado`='ERR:[CampoVacio]' WHERE LENGTH(Fabr_Recambio) < 2 or LENGTH(Ref_Fabricante) < 2";
    $ConsErr = mysqli_query($BDImportRecambios, $consul);
}

function anahirRecam($BDRecambios) {

    $estado = $_POST['estado'];
    $ref = $_POST['referen'];
    $coste = $_POST['coste'];
    if ($estado == "nuevo") {
        $tab = $_POST['nombretabla'];
        $familia = $_POST['familia'];
        $cons = "SELECT * FROM `familiasrecambios` WHERE id = " . $familia;
        $consFa = mysqli_query($BDRecambios, $cons);
        $bfa = $consFa->fetch_assoc();
        $desdef = $bfa["Familia_es"];

        $fabricante = $_POST['fabricante'];
        $consulFab = "SELECT * FROM `fabricantesrecambios` where id =" . $fabricante;
        $cFa = mysqli_query($BDRecambios, $consulFab);
        $bFa = $cFa->fetch_assoc();
        $desdef .= " " . $bFa['Nombre'];

        $coste = $_POST['coste'];
        $descripcion = $_POST['descrip'];
        $desdef .= " " . $descripcion;
        $ref = $_POST['referen'];

        $pvp = ($coste + (($coste * 40) / 100)) * 1.21;
        $fecha = date('Y-m-d');
        $consul = "INSERT INTO " . $tab . "( `Descripcion`, `coste`, `margen`, `iva`, `pvp`, `IDFabricante`, `FechaActualiza`) VALUES ('" . $desdef . "'," . $coste . ",40,21," . $pvp . "," . $fabricante . "," . $fecha . ")";
        $BDRecambios->query($consul);
        $resul = $BDRecambios->insert_id;

        $consulta = "INSERT INTO `referenciascruzadas`( `IdFabricanteCru`, `RecambioID`, `RefFabricanteCru`) VALUES ('" . $fabricante . "','" . $resul . "','" . $ref . "')";
        $BDRecambios->query($consulta);
        $resFinal = $BDRecambios->insert_id;

        $consulta = "INSERT INTO `recambiosfamilias`( `IdRecambio`, `IdFamilia`) VALUES (" . $resul . "," . $familia . ")";
        $BDRecambios->query($consulta);
        $resFinal2 = $BDRecambios->insert_id;
    } else {
        $fecha = date('Y-m-d');
        $id = $_POST['idrecam'];
        $cnsulta = "select * from recambios where id =" . $id;
        $consultaReca = mysqli_query($BDRecambios, $cnsulta);
        $contador = $consultaReca->fetch_assoc();
        $margen = $contador['margen'];
        $iva = "1." . $contador['iva'];
        $pvp = ($coste + (($coste * $margen) / 100)) * $iva;
        $modifcoste = "UPDATE `recambios` SET `coste`=" . $coste . ",`pvp`=" . $pvp . ",`FechaActualiza`='" . $fecha . "' WHERE `id` =" . $id;
        mysqli_query($BDRecambios, $modifcoste);
    }
}

function errorFab($BDImportRecambios, $BDRecambios) {
    $fab = $_POST['fabricante'];
    $consul = "SELECT * FROM `fabricantesrecambios` WHERE Nombre ='" . $fab . "'";
    $consFa = mysqli_query($BDRecambios, $consul);
    $consultaFabricante = $consFa->fetch_assoc();
    if ((int) $consultaFabricante['id'] == 0) {
        $con = "  UPDATE `referenciascruzadas` SET `Estado`= 'ERR:[RefFabPrin no existe]' WHERE Fabr_Recambio ='" . $fab . "'";
        $consFa = mysqli_query($BDImportRecambios, $con);
    }
}

function resumen($BDImportRecambios) {

    $consulta = "SELECT count(Fabr_Recambio) as total FROM `referenciascruzadas` WHERE Estado = 'ERR:[RefFabPrin no existe]'";
    $conmys = mysqli_query($BDImportRecambios, $consulta);
    $efab = $conmys->fetch_assoc();

    $consulta2 = "SELECT count(Fabr_Recambio) as total FROM `referenciascruzadas` WHERE Estado = 'ERR:[CampoVacio]'";
    $conmys2 = mysqli_query($BDImportRecambios, $consulta2);
    $eref = $conmys2->fetch_assoc();

    $consulta3 = "SELECT count(linea) as total FROM `referenciascruzadas` WHERE Estado = ''";
    $conmys3 = mysqli_query($BDImportRecambios, $consulta3);
    $conpro = $conmys3->fetch_assoc();
    $datos[0]['f'] = $efab['total'];
    $datos[0]['e'] = $eref['total'];
    $datos[0]['c'] = $conpro['total'];

    header("Content-Type: application/json;charset=utf-8");
    echo json_encode($datos);
}

switch ($pulsado) {
    case 'borrar':
        borrar($nombretabla, $BDImportRecambios);
        break;
    case 'contar':
        contador($nombretabla, $BDImportRecambios);
        break;
    case 'comprobar':
        comprobar($nombretabla, $BDImportRecambios, $BDRecambios);
        break;
    case 'contarVacios':
        contarVacios($nombretabla, $BDImportRecambios);
        break;
    case 'verNuevos':
        verNuevosRef($BDImportRecambios);
        break;
    case 'anahirRecam':
        anahirRecam($BDRecambios);
        break;
    case 'BuscarError':
        BuscarError($BDImportRecambios);
        break;
    case 'BuscarErrorFab':
        BuscarErrorFab($BDImportRecambios);
        break;
    case 'comPro':
        errorFab($BDImportRecambios, $BDRecambios);
        break;
    case 'resumen':
        resumen($BDImportRecambios);
        break;
    case 'contarVacioscruzados':
        contarVaciosCru($BDImportRecambios);
        break;
    case 'comprobar2cruz':
        comprobarCruzadas($BDImportRecambios, $BDRecambios);
        break;
}


mysqli_close($BDImportRecambios);
mysqli_close($BDRecambios);
