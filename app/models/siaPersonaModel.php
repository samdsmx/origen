<?php

/**
 * Description of siaPersonaModel
 *
 * @author Angel
 */
class siaPersonaModel extends Eloquent{
    
    protected $table = 'sia_persona';
    protected $primaryKey = 'id_persona';
    protected $fillable = ['primer_apellido', 'segundo_apellido', 'nombres', 'curp', 'correo', 'telefono', 'id_unidad_responsable', 'status'];
    
    public $timestamp = true;
    
    public function ur(){
        return $this->belongsTo('siaUnidadResponsableModel', 'id_unidad_responsable');
    }
    
    public function usuario(){
        return $this->hasOne('User', 'id_usuario');
    }
    
    public function nombre_completo(){
        return $this->nombres.' '.$this->primer_apellido.' '.$this->segundo_apellido;
    }
}
