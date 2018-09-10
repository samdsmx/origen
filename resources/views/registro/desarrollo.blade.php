<div class="box-header with-border">
  <h3 class="box-title">Desarrollo del caso</h3>
  <div class="box-tools pull-right">
    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
  </div>
</div>

<div class="box-body">
    <div class="form-group">
      <label for="ComentariosAdicionales">Motivo de llamada:</label>
      <textarea id="ComentariosAdicionales" 
        name="ComentariosAdicionales" 
        class="form-control" 
        rows="3" 
        cols="25" 
        @if($numeroLlamada > 0) disabled @endif
        placeholder="..." 
        wrap="hard">{{ $datosGenerales['ComentariosAdicionales'] }}</textarea>
    </div>
    <div class="form-group">
      <label for="tipocaso">Objetivo:</label>
      <textarea name="tipocaso" 
        id="tipocaso" 
        class="form-control" 
        rows="3" 
        cols="25" 
        placeholder="..." 
        @if($numeroLlamada > 0) disabled @endif
        wrap="hard">{{$datosGenerales['tipocaso']}}</textarea>
    </div>
    <div class="form-group">
      <label for="PosibleSolucion">¿Qué tendría que pasar en esta llamada para saber que te fue de utilidad?</label>
      <textarea name="PosibleSolucion"
        @if($datosGenerales['posibleSolucion']  != '' && $numeroLlamada > 0) disabled @endif 
        class="form-control" 
        rows="3" 
        cols="25" 
        placeholder="..." 
        wrap="hard">{{ $datosGenerales['posibleSolucion'] }}</textarea>
    </div>    
    <div class="form-group">
      <label for="recFort">Recursos y fortalezas:</label>
      <textarea name="Estatus" 
        @if($datosGenerales['Estatus']  != '' && $numeroLlamada > 0) disabled @endif 
        id="recFort" 
        class="form-control" 
        rows="3" cols="25" 
        placeholder="..." 
        wrap="hard">{{ $datosGenerales['Estatus'] }}</textarea>
    </div>      
    <div class="form-group">
      <label for="DesarrolloCaso">Desarrollo del caso:</label>
      <textarea name="DesarrolloCaso" 
        id="DesarrolloCaso" 
        class="form-control" 
        rows="5" 
        cols="25" 
        @if($numeroLlamada > 0) disabled @endif
        placeholder="..." 
        wrap="hard">{{$datosGenerales['DesarrolloCaso']}}</textarea>
    </div>   
</div>