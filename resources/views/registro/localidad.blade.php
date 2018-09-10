<div class="box-header with-border">

  <h3 class="box-title col-sm-3">Localidad</h3>
  
  <label class="col-sm-3" style="white-space: nowrap; overflow: hidden;">
    <input type="radio" name="Pais" id="Mexico" value="Mexico" onchange="changePais('forma');" 
        @if($datosGenerales['Pais'] != "Otro") checked 
        @elseif($datosGenerales['Pais'] == "Otro" && $numeroLlamada > 0) disabled 
        @endif >
    México
  </label>
  <label class="col-sm-3" style="white-space: nowrap; overflow: hidden;">
    <input type="radio" name="Pais" value="Otro" onchange="changePais('forma');"
        @if($datosGenerales['Pais'] == "Otro") checked 
        @elseif($datosGenerales['Pais'] != "Otro" && $numeroLlamada > 0) disabled 
        @endif >
    Otro
  </label>

  <div class="box-tools pull-right">
    <button type="button" class="btn btn-box-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
    </button>
  </div>
</div>

<div class="box-body">

    <div class="form-group col-md-4" style="white-space: nowrap;">
        <label for="CP">Codigo Postal:</label>
        <input type="number" 
            class="form-control" 
            id="CP" 
            value="{{ $datosGenerales['CP'] }}"
            @if($numeroLlamada > 0) disabled @endif
            name="CP" 
            placeholder="#####">
    </div>

    <div class="form-group col-md-8">
        <label for="Estado">Estado:</label>
        <select name="Estado"
            id="Estado" 
            @if($numeroLlamada > 0) disabled @endif
            class="form-control">
            <option value="0">-</option>
            @foreach ($estados as $k => $v)
                <option @if($datosGenerales['Estado'] == $v) selected @endif value="{{$k}}">{{$v}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-6">
        <label for="Municipio" 
               style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
            Delegación o Municipio:
        </label>
        <select name="Municipio" 
            id="Municipio" 
            @if($numeroLlamada > 0) disabled @endif
            class="form-control">
            <option value="0">-</option>
            @if($numeroLlamada > 0)
                <option selected> {{ $datosGenerales['Municipio'] }} </option>
            @endif
        </select>
    </div>

    <div class="form-group col-md-6">
        <label for="Colonia">Colonia:</label>
        <select name="Colonia" 
            id="Colonia" 
            @if($numeroLlamada > 0) disabled @endif
            class="form-control">
            <option value="0">-</option>
            @if($numeroLlamada > 0)
                <option selected> {{ $datosGenerales['Colonia'] }} </option>
            @endif
        </select>
    </div>                                                                                    
</div>