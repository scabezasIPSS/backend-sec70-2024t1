<?php

class Controlador{

    private $lista;

    public function __construct()
    {
        $this->lista = [];
    }

    public function getAll(){
        $con = new Conexion();
        $sql = 'SELECT aui.valor_titulo as "titulo", aui.valor_descripcion as "descripcion", au.titulo as "seccion", i.corto
        FROM about_us_idioma as aui 
            JOIN about_us as au ON (aui.about_us_id = au.id)
            JOIN idiomas as i ON (aui.idioma_id = i.id);';
        $rs = mysqli_query($con->getConnection(), $sql);
        if ($rs){
            while ($tupla = mysqli_fetch_assoc($rs)){
                //$tupla['activo'] = $tupla['activo'] == 1 ? true: false;
                $aux = [
                    $tupla['seccion'] =>[
                        "titulo" => [
                            $tupla['corto'] => $tupla['titulo']
                        ],
                        "descripcion" => [
                            $tupla['corto'] => $tupla['descripcion']
                        ]
                    ]
                ];
                array_push($this->lista, $aux);
                //array_push($this->lista, $tupla);
            }
            mysqli_free_result($rs);
        }
        $con->closeConnection();
        return $this->lista;
    }

}