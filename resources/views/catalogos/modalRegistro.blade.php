<div class="modal fade bs-example-modal-sm" id="modalRegistroGrupo" tabindex="-1" role="dialog" aria-hidden="true">
    {!! Form::open(array('id' => 'registraGrupo')) !!}
    <div class="modal-dialog modal-sm" >
        <div class="modal-content" style="background: transparent" >
            <div class="modal-header" style="background-color: #3498DB; border-top: 1px solid #70B6E5;border-bottom: 5px solid #2372A7; border-radius: 5px 5px 0 0;">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title" id="registroLabel" style="color: #ffffff; text-align: center; font-weight: bolder;">Crear Grupo</h4>
            </div>
            <div class="modal-body" style="background: #ffffff; padding-bottom: 10px;">
                <input type="hidden" id="id_grupo" name="id_grupo"/>
                <input type="hidden" id="id_orden" name="id_orden"/>
                <div class="col-lg-12">
                    <div id="dgrupo" class='form-group has-feedback'>
                        <input id="grupo" name="grupo" type="text" class="form-control" placeholder="Grupo" autocomplete="off"/>
                        <i class="fa fa-pencil fa-lg form-control-feedback" style="padding: 10px; opacity: 0.25;"></i>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class='form-group' id="dorden">
                        <input id="orden" name="orden" type="text" class="form-control" placeholder="Orden" />
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: #ffffff;">
                {!! Form::reset('Limpiar', array('class' => 'btn btn-primary', 'id' => "resetear")) !!}
                {!! Form::submit('Guardar', array('class' => 'btn btn-success', 'id' => 'btnGuardarGrupo')) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>