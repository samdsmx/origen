<div class="modal fade bs-example-modal-md" id="modalRegistroOrganismo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" >
        <div class="modal-content" style="background: transparent" >
            <div class="modal-header" 
                 style="background-color: #ff8018; border-top: 1px solid #fda65f; 
                 border-bottom: 5px solid #fda65f; border-radius: 5px 5px 0 0;">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Cerrar</span>
                </button>
                <h4 class="modal-title" id="registroLabel" style="color: #ffffff; text-align: center; font-weight: bolder;">
                    Organismos
                </h4>
            </div>
            {!! Form::open(array('id' => 'buscaOrganismosCanalizacion', 'method'=>'POST')) !!}
                @include('organismos.busqueda')
            {!! Form::close() !!}
        </div>
    </div>
</div>