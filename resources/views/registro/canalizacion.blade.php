<div class="box-header with-border">
  <h3 class="box-title">Canalización</h3>
  <div class="box-tools pull-right">
    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
  </div>
</div>

<div class="box-body">

    <div class="form-group col-md-6">
        <label for="edad">Abogado:</label>
        <select name="estadoCivil" multiple class="form-control js-example-basic-multiple">
            <option value="0">-</option>
            @foreach ($cleg as $v)
                <option value="{{$v['Nombre']}}">{{$v['Nombre']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-6">
        <label for="edad"></label>
        <input type="text" class="form-control" placeholder="####-####">
    </div>

    <div class="form-group col-md-12">
        <label for="edad">Otro:</label>
        <textarea class="form-control" rows="3" cols="25" placeholder="..." wrap="hard"></textarea>
    </div>

   

</div>