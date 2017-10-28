<div class="box-header with-border">
<div id="dmotivos" class="form-group">
    <h3 id="motivos" class="box-title"><label>Motivos</label></h3>
</div>
    <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
</div>

<div class="form-group box-body">
    
    <div class="form-group col-md-12">
        <label for="AyudaPsicologico">PSICOLOGICO:</label>
        <select name="AyudaPsicologico" id="AyudaPsicologico" multiple class="form-control js-example-basic-multiple">
            <option value="0">-</option>
            @foreach ($mpsicologicos as $v)
                <option value="{{$v['Nombre']}}">{{$v['Nombre']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-12">
        <label for="AyudaLegal">LEGAL:</label>
        <select name="AyudaLegal" id="AyudaLegal" multiple class="form-control js-example-basic-multiple">
            <option value="0">-</option>
            @foreach ($mlegales as $v)
                <option value="{{$v['Nombre']}}">{{$v['Nombre']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-12">
        <label for="AyudaMedica">MEDICO:</label>
        <select name="AyudaMedica" id="AyudaMedica" multiple class="form-control js-example-basic-multiple">
            <option value="0">-</option>
            @foreach ($mMed as $v)
                <option value="{{$v['Nombre']}}">{{$v['Nombre']}}</option>
            @endforeach
        </select>
    </div>                          

    <div class="form-group col-md-12">
        <label for="AyudaOtros">OTROS:</label>
        <select name="AyudaOtros" id="AyudaOtros" multiple class="form-control js-example-basic-multiple">
            <option value="0">-</option>
            @foreach ($mOtr as $v)
                <option value="{{$v['Nombre']}}">{{$v['Nombre']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-12">
        <label for="TipoViolencia">TIPO DE VIOLENCIA:</label>
        <select name="TipoViolencia" multiple class="form-control js-example-basic-multiple">
            <option value="0">-</option>
            @foreach ($tv as $v)
                <option value="{{$v['Nombre']}}">{{$v['Nombre']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-12">
        <label for="ModalidadViolencia">MODALIDAD DE VIOLENCIA:</label>
        <select name="ModalidadViolencia" multiple class="form-control js-example-basic-multiple">
            <option value="0">-</option>
            @foreach ($mv as $v)
                <option value="{{$v['Nombre']}}">{{$v['Nombre']}}</option>
            @endforeach
        </select>
    </div>

</div>

