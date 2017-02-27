<div class="modal fade bs-example-modal-sm" id="modalCreaPeriodos" tabindex="-1" role="dialog" aria-hidden="true">
    {{ Form::open(array('id' => 'creaPeriodo')) }}
    <div class="modal-dialog modal-sm" >
        <div class="modal-content" style="background: transparent" >
            <div class="modal-header" style="background-color: #3498DB; border-top: 1px solid #70B6E5;border-bottom: 5px solid #2372A7; border-radius: 5px 5px 0 0;">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title" id="registroLabel" style="color: #ffffff; text-align: center; font-weight: bolder;">Crear periodo</h4>
            </div>
            <div class="modal-body" style="background: #ffffff; padding-bottom: 10px;">
                <input type="hidden" id="id_periodo" name="id_periodo"/>
                <div class='form-group col-lg-12' id="dfecha_inicio">
                    <label class="text-center text-info">Inicio del periodo: </label>
                    <input class="col-lg-5 form-control" type="text" id="fecha_inicio" name="fecha_inicio" />
                </div>
                <div class='form-group col-lg-12' id="dfecha_fin">
                    <label class="text-center text-info">Fin del periodo: </label>
                    <input class="col-lg-5 form-control" type="text" id="fecha_fin" name="fecha_fin" />
                </div>
                <div class='form-group col-lg-12' id="dcomentarios">
                    <label class="text-center text-info">Descripción:</label>
                    <input class="col-lg-12 form-control" type="text" id="comentarios" name="comentarios"/>
                </div>
            </div>
            <div class="modal-footer" style="background: #ffffff;">
                {{ Form::reset('Limpiar', array('class' => 'btn btn-primary', 'id' => "resetear")) }}
                {{ Form::submit('Guardar', array('class' => 'btn btn-success', 'id' => 'btnCrearperiodo')) }}
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>