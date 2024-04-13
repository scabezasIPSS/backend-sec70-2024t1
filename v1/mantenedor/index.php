<?php
include_once '../version1.php';

//parametros
$existeId = false;
$valorId = 0;

if (count($_parametros)>0){
    foreach($_parametros as $p){
        if(strpos($p, 'id') !== false){
            $existeId = true;
            $valorId = explode('=', $p)[1];
        }
    }
}

if($_version == 'v1'){
    if ($_mantenedor == 'mantenedor'){
        switch ($_metodo){
            case 'GET':
                if($_header == $_token_get){
                    /*include_once 'controller.php';
                    include_once '../conexion.php';
                    $control = new Controlador();
                    $lista = $control->getAll();
                    http_response_code(200);
                    echo json_encode(['data' => $lista]);
                    */
                    
                    $retorno = [
                        [
                            "id" => 0,
                            "nombre" => 'Wena1',
                            "activo" => true
                        ],
                        [
                            "id" => 1,
                            "nombre" => 'Wena2',
                            "activo" => false
                        ],
                        [
                            "id" => 2,
                            "nombre" => 'Wena3',
                            "activo" => true
                        ],
                    ];
                    http_response_code(200);
                    echo json_encode(['data' => $retorno]);

                }else{
                    http_response_code(401);
                    echo json_encode(['error' => 'no tiene autorizacion get']);
                }
                break;
            default:
                break;
        }
    }
}