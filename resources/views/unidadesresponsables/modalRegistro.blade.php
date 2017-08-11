<div class="modal fade bs-example-modal-sm" id="modalRegistroUR" tabindex="-1" role="dialog" aria-hidden="true">
    {!! Form::open(array('id' => 'registraUR')) !!}
    <div class="modal-dialog modal-sm" >
        <div class="modal-content" style="background: transparent" >
            <div class="modal-header" style="background-color: #3498DB; border-top: 1px solid #70B6E5;border-bottom: 5px solid #2372A7; border-radius: 5px 5px 0 0;">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title" id="registroLabel" style="color: #ffffff; text-align: center; font-weight: bolder;">Unidad Responsable</h4>
            </div>
            <div class="modal-body" style="background: #ffffff; padding-bottom: 10px;">
                <input type="hidden" value="" name ="id_unidad_responsable" id="id_unidad_responsable" />
                <div class="row text-center">
                    <div class="col-lg-12">
                        <div class='form-group has-feedback' id="dnombre_ur">
                            <input id="nombre_ur" name="nombre_ur" type="text" class="form-control" placeholder="Nombre de la UR" autocomplete="off"/>
                            <i class="fa fa-pencil fa-lg form-control-feedback" style="padding: 10px; opacity: 0.25;"></i>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-lg-12">
                        <div class='form-group has-feedback' id="dnombre_corto">
                            <input id="nombre_corto" name="nombre_corto" type="text" class="form-control" placeholder="Nombre corto de la UR" autocomplete="off"/>
                            <i class="fa fa-pencil fa-lg form-control-feedback" style="padding: 10px; opacity: 0.25;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: #ffffff;">
                {!! Form::reset('Borrar', array('class' => 'btn btn-primary', 'id' => "resetear")) !!}
                {!! Form::submit('Guardar', array('class' => 'btn btn-success', 'id' => 'registraUR')) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>