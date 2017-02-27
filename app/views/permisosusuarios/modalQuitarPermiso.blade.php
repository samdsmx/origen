<div class="modal fade bs-example-modal-sm" id="modalQuitarPermiso" tabindex="-1" role="dialog" aria-hidden="true">
    {{ Form::open(array('id' => 'quitaPermiso')) }}
    <div class="modal-dialog modal-sm" >
        <div class="modal-content" style="background: transparent" >
            <div class="modal-header" style="background-color: #3498DB; border-top: 1px solid #70B6E5;border-bottom: 5px solid #2372A7; border-radius: 5px 5px 0 0;">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title" id="registroLabel" style="color: #ffffff; text-align: center; font-weight: bolder;">Eliminar permiso</h4>
            </div>
            <div class="modal-body" style="background: #ffffff; padding-bottom: 10px;">
                <input type="hidden" value="" name ="id" id="id" />
                <div class="row text-center">
                    <p style="font-weight: bold; font-size: large">¿Esta seguro?</p>
                </div>
            </div>
            <div class="modal-footer" style="background: #ffffff;">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                {{ Form::submit('Continuar', array('class' => 'btn btn-success', 'id' => 'btnAgregaPropiedad')) }}
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>