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
        <label for="mlegal">LEGAL:</label>
        <select name="mlegal" id="mlegal" multiple class="form-control js-example-basic-multiple">
            <option value="0">-</option>
            @foreach ($mlegales as $v)
                <option value="{{$v['Nombre']}}">{{$v['Nombre']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-12">
        <label for="mmedico">MEDICO:</label>
        <select name="mmedico" id="mmedico" multiple class="form-control js-example-basic-multiple">
            <option value="0">-</option>
            @foreach ($mMed as $v)
                <option value="{{$v['Nombre']}}">{{$v['Nombre']}}</option>
            @endforeach
        </select>
    </div>                          

    <div class="form-group col-md-12">
        <label for="motros">OTROS:</label>
        <select name="motros" id="motros" multiple class="form-control js-example-basic-multiple">
            <option value="0">-</option>
            @foreach ($mOtr as $v)
                <option value="{{$v['Nombre']}}">{{$v['Nombre']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-12">
        <label for="tviolencia">TIPO DE VIOLENCIA:</label>
        <select name="tviolencia" multiple class="form-control js-example-basic-multiple">
            <option value="0">-</option>
            @foreach ($tv as $v)
                <option value="{{$v['Nombre']}}">{{$v['Nombre']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-12">
        <label for="modviolencia">MODALIDAD DE VIOLENCIA:</label>
        <select name="modviolencia" multiple class="form-control js-example-basic-multiple">
            <option value="0">-</option>
            @foreach ($mv as $v)
                <option value="{{$v['Nombre']}}">{{$v['Nombre']}}</option>
            @endforeach
        </select>
    </div>

</div>

