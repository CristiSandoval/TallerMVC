<?php

namespace app\controllers;

use App\models\entities\Plato;

Class PlatoController{

    function guardarNuevoPlato($request){
        $model = new Plato();
        $model->set('descripcion', $request['descripcion']);
        $model->set('categoria_id', $request['categoria_id']);
        $model->set('precio', $request['precio']);
        $res = $model->guardar();
        return $res? "yes" : "no";
    }
}


?>