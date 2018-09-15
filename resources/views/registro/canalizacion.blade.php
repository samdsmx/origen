<div class="box-header with-border">
  <h3 class="box-title">Canalización</h3>
  <div class="box-tools pull-right">
    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
  </div>
</div>

<div class="box-body">

    <div class="form-group col-md-6">
        <label for="CanaOtro">Abogado:</label>
        <select name="CanaLegal" 
            id="canalLegal" 
            @if($numeroLlamada > 0) disabled @endif
            multiple 
            class="form-control js-example-basic-multiple">
            <option value="0">-</option>
            @foreach ($cleg as $v)
                <option @if(in_array($v['Nombre'],$datosGenerales['CanaLegal'])) selected @endif value="{{$v['Nombre']}}">{{$v['Nombre']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-6">
        <label for="edad"></label>
        <input type="text" class="form-control" placeholder="####-####">
    </div>

    <div class="form-group col-md-12">
        <button type="button" 
        class="btn bg-gray-gradient" 
        data-toggle="modal" 
        @if($numeroLlamada > 0) disabled @endif
        data-target="#modalRegistroOrganismo"><i class="fa fa-search"></i></button>
        <label for="CanaOtro">Organismo:</label>
        <textarea name="CanaOtro" 
            id="CanaOtro" 
            class="form-control" 
            rows="3" 
            @if($numeroLlamada > 0) disabled @endif
            cols="25" 
            placeholder="..." 
            wrap="hard">{{ $datosGenerales['CanaOtro'] }}</textarea>
    </div>

   

</div>