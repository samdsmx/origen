<div class="box-header with-border">
  <h3 class="box-title">Contacto</h3>
  <div class="box-tools pull-right">
    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
  </div>
</div>

<div class="box-body">

    <div class="form-group col-md-4">
        <label for="edad">Teléfono:</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-phone"></i></span>
            <input type="text" class="form-control" placeholder="####-####">
        </div>
    </div>

    <div class="form-group col-md-5">
        <label for="edad" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Correo Electronico:</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
            <input type="email" class="form-control" placeholder="Email">
        </div>
    </div>

    <div class="form-group col-md-3">
        <label for="medioContacto" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Medio de contacto:</label>
        <select name="medioContacto" class="form-control">
            <option selected="">Teléfono</option>
            <option>Chat</option>
            <option>Mail</option>
        </select>
    </div>                            

    <div class="form-group col-md-9">
        <label for="enteraste">Como te enteraste:</label>
        <div class="row">
          <div class="col-md-8">
            <select name="enteraste" class="form-control" onchange="rellenaMedios('forma');" >
                <option value="0">-</option>
                @foreach ($cte as $v)
                    <option value="{{$v['Nombre']}}">{{$v['Nombre']}}</option>
                @endforeach
            </select>
          </div>
          <div class="col-md-4">
            <select name="enteraste2" class="form-control" disabled>
              <option value="">-</option>
            </select>
          </div>
        </div>
    </div>

    <div class="form-group col-md-3">
      <label for="otrosEnteraste">Otros:</label>
      <input type="text" class="form-control" name="otrosEnteraste">
    </div>

</div>