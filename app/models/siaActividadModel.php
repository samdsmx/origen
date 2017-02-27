<?php

/**
 * Description of siaActividadModel
 *
 * @author Angel
 */
class siaActividadModel extends Eloquent{
    protected $table = 'sia_cat_actividad';
    protected $primaryKey = 'id_actividad';
    protected $fillable = ['nombre','descripcion', 'status'];
    
    public function usuarioatividad(){
        return $this->hasMany('siaAsoUsuarioActividadModel', 'id_usuario_actividad');
    }
}
