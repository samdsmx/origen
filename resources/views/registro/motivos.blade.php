<div class="box-header with-border">
  <h3 class="box-title">Motivos</h3>
  <div class="box-tools pull-right">
    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
  </div>
</div>

<div class="box-body">

    <div class="form-group col-md-12">
        <label for="estadoCivil">PSICOLOGICO:</label>
        <select name="mpsicologico" multiple class="form-control js-example-basic-multiple">
            <option value="0">-</option>
            @foreach ($mpsicologicos as $v)
                <option value="{{$v['Nombre']}}">{{$v['Nombre']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-12">
        <label for="estadoCivil">LEGAL:</label>
        <select name="estadoCivil" multiple class="form-control js-example-basic-multiple">
            <option value="0">-</option>
            @foreach ($mlegales as $v)
                <option value="{{$v['Nombre']}}">{{$v['Nombre']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-12">
        <label for="estadoCivil">MEDICO:</label>
        <select name="estadoCivil" multiple class="form-control js-example-basic-multiple">
            <option value="0">-</option>
            @foreach ($mMed as $v)
                <option value="{{$v['Nombre']}}">{{$v['Nombre']}}</option>
            @endforeach
        </select>
    </div>                          

    <div class="form-group col-md-12">
        <label for="estadoCivil">OTROS:</label>
        <select name="estadoCivil" multiple class="form-control js-example-basic-multiple">
            <option value="0">-</option>
            @foreach ($mOtr as $v)
                <option value="{{$v['Nombre']}}">{{$v['Nombre']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-12">
        <label for="estadoCivil">TIPO DE VIOLENCIA:</label>
        <select name="estadoCivil" multiple class="form-control js-example-basic-multiple">
            <option value="0">-</option>
            @foreach ($tv as $v)
                <option value="{{$v['Nombre']}}">{{$v['Nombre']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-12">
        <label for="estadoCivil">MODALIDAD DE VIOLENCIA:</label>
        <select name="estadoCivil" multiple class="form-control js-example-basic-multiple">
            <option value="0">-</option>
            @foreach ($mv as $v)
                <option value="{{$v['Nombre']}}">{{$v['Nombre']}}</option>
            @endforeach
        </select>
    </div>

</div>

