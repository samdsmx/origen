<div class="modal fade bs-example-modal-sm" id="modalBaja" tabindex="-1" role="dialog" aria-hidden="true">
    {{ Form::open(array('id' => 'bajaSistema')) }}
    <div class="modal-dialog modal-sm" >
        <div class="modal-content" style="background: transparent" >
            <div class="modal-header" style="background-color: #3498DB; border-top: 1px solid #70B6E5;border-bottom: 5px solid #2372A7; border-radius: 5px 5px 0 0;">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title" id="registroLabel" style="color: #ffffff; text-align: center; font-weight: bolder;">Dar de baja Sistema</h4>
            </div>
            <div class="modal-body" style="background: #ffffff; padding-bottom: 10px;">
                <input type="hidden" id="id_hidden_sis" name="id_hidden_sis" value=""/>
                <div class="row text-center">
                    <div class="col-lg-12">
                        <div class='form-group has-feedback'>
                            <input id="baja_razon" name="baja_razon" type="text" class="form-control" placeholder="Razon" autocomplete="off"/>
                            <i class="fa fa-pencil fa-lg form-control-feedback" style="padding: 10px; opacity: 0.25;"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: #ffffff;">
                {{ Form::reset('Borrar', array('class' => 'btn btn-primary', 'id' => "resetear")) }}
                {{ Form::submit('Dar de baja', array('class' => 'btn btn-success', 'id' => 'btnBajaSistema')) }}
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>