<?php
include_once '../version2.php';

//parametros
$existeId = false;
$valorId = 0;
$existeAccion = false;
$valorAccion = 0;


if (count($_parametros) > 0) {
    foreach ($_parametros as $p) {
        if (strpos($p, 'id') !== false) {
            $existeId = true;
            $valorId = explode('=', $p)[1];
        }
        if (strpos($p, 'accion') !== false) {
            $existeAccion = true;
            $valorAccion = explode('=', $p)[1];
        }
    }
}

if ($_version == 'v2') {
    if ($_mantenedor == 'info-contacto') {
        switch ($_metodo) {
            case 'GET':
                if ($_header == $_token_get) {
                    include_once 'controller.php';
                    include_once '../conexion.php';
                    $control = new Controlador();
                    $lista = $control->getAll();
                    http_response_code(200);
                    echo json_encode(['data' => $lista]);
                } else {
                    http_response_code(401);
                    echo json_encode(['error' => 'no tiene autorizacion get']);
                }
                break;
            case 'POST':
                if ($_header == $_token_post) {
                    include_once 'controller.php';
                    include_once '../conexion.php';
                    $control = new Controlador();
                    $body = json_decode(file_get_contents("php://input", true));
                    // var_dump($body);
                    //trae el getall y corrobora q el dato a insertar no exista. Si existe. salta al error 409. 
                    //Si no existe, entonces se intenta insertar
                    $respuesta = $control->postNuevo($body);
                    if ($respuesta) {
                        http_response_code(201);
                        echo json_encode(['data' => $respuesta]);
                    } else {
                        http_response_code(409);
                        echo json_encode(['error' => 'tiene conflicto pq el dato ya existe']);
                    }
                } else {
                    http_response_code(401);
                    echo json_encode(['error' => 'no tiene autorizacion post']);
                }
                break;
            case 'PATCH':
                if ($_header == $_token_patch) {
                    include_once 'controller.php';
                    include_once '../conexion.php';
                    $control = new Controlador();
                    if ($existeId && $existeAccion) {
                        if ($valorAccion == 'apagar') {
                            $respuesta = $control->patchEncenderApagar($valorId, 'false');
                            // echo "patch... $valorId - $valorAccion";
                            http_response_code(200);
                            echo json_encode(['data' => $respuesta]);
                        } else if ($valorAccion == 'encender') {
                            $respuesta = $control->patchEncenderApagar($valorId, 'true');
                            http_response_code(200);
                            echo json_encode(['data' => $respuesta]);
                        } else {
                            echo 'error con acciones';
                        }
                    } else {
                        echo 'faltan parametros';
                    }
                } else {
                    http_response_code(401);
                    echo json_encode(['error' => 'no tiene autorizacion patch']);
                }
                break;
            case 'PUT':
                if ($_header == $_token_put) {
                    include_once 'controller.php';
                    include_once '../conexion.php';
                    $body = json_decode(file_get_contents("php://input", true));
                    // var_dump($body);
                    $control = new Controlador();
                    if (strlen($body->nombre) > 0) {
                        $respuesta = $control->putNombreById($body->nombre, $body->id);
                    }
                    if (strlen($body->icono) > 0) {
                        $respuesta = $control->putIconoById($body->icono, $body->id);
                    }
                    if (strlen($body->texto) > 0) {
                        $respuesta = $control->putTextoById($body->texto, $body->id);
                    }
                    if (strlen($body->texto_adicional) > 0) {
                        $respuesta = $control->putTextoAdicionalById($body->texto_adicional, $body->id);
                    }
                    http_response_code(200);
                    echo json_encode(['data' => $respuesta]);
                } else {
                    http_response_code(401);
                    echo json_encode(['error' => 'no tiene autorizacion put']);
                }
                break;
            case 'DELETE':
                if ($_header == $_token_delete) {
                    include_once 'controller.php';
                    include_once '../conexion.php';
                    $control = new Controlador();
                    $respuesta = $control->deleteById($valorId);
                    http_response_code(200);
                    echo json_encode(['data' => $respuesta]);
                } else {
                    http_response_code(401);
                    echo json_encode(['error' => 'no tiene autorizacion put']);
                }
                break;
            default:
                break;
        }
    }
}
