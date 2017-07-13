<div class="modal fade bs-example-modal-lg" id="modalResponsable" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content" style="background: transparent" >
            <div class="modal-header" style="background-color: #3498DB; border-top: 1px solid #70B6E5;border-bottom: 5px solid #2372A7; border-radius: 5px 5px 0 0;">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title" id="registroLabel" style="color: #ffffff; text-align: center; font-weight: bolder;">
		    Responsables del Sistema: <span id="modalResponsableSistema">Sistema</span> 
                </h4>
            </div>
            <div class="modal-body text-center" style="background: #ffffff; padding-bottom: 10px;">
		<div id="modalResponsableMensaje" class='hidden'> </div>
		<table class="text-left" id="modalResponsablePersonas" style="margin-left: 40%;">
		    <tr>
			<td>Nombre del usuario</td> <td style="padding-left: 100%;"><span class="eliminarPersona"><i class="fa fa-times" aria-hidden="true"></i></span></td> 
		    </tr>
		</table>
		<p><a class="btn btn-default" id="modalResponsableAgregar"><i class="fa fa-plus" aria-hidden="true"></i></a></p>
		<form id="buscarResponsable" class="hidden">
		    <input type="hidden" value="" id="modalResponsableISistema">
		    <select id="modalResponsableCandidato" class="form-control">
			<option value="0" disabled="" selected="">--- Seleccione un responsable ---</option>
			@foreach($posiblesResponsables as $pr)
			<option value="{!!$pr->id_persona!!}">{!!$pr->nombres.' '.$pr->primer_apellido.' '.$pr->segundo_apellido!!}</option>
			@endforeach	
		    </select>
		    <a id="modalResponsableEnviar" class="btn btn-success" style="margin: 2%;">Agregar responsable</a>
		</form>
            </div>
            <div class="modal-footer" style="background: #ffffff;">
		<a class="btn btn-default" data-dismiss="modal">Cerrar</a>
            </div>
        </div>
    </div>
</div>