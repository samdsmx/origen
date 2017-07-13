                        <div class="box-header with-border">

                          <h3 class="box-title col-sm-3">Localidad</h3>
                          
                          <label class="col-sm-3" style="white-space: nowrap; overflow: hidden;">
                            <input type="radio" name="Localidad" id="Mexico" value="Mexico" onchange="changePais('forma');" checked>
                            México
                          </label>
                          <label class="col-sm-3" style="white-space: nowrap; overflow: hidden;">
                            <input type="radio" name="Localidad" value="Otro" onchange="changePais('forma');">
                            Otro
                          </label>
                          

                          <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                          </div>
                        </div>

                        <div class="box-body">

                            <div class="form-group col-md-4" style="white-space: nowrap;">
                                <label for="CP">Codigo Postal:</label>
                                <input type="number" class="form-control" id="cp" placeholder="#####">
                            </div>

                            <div class="form-group col-md-8">
                                <label for="edad">Entidad:</label>
                                <select name="Estado" id="Estado" class="form-control" onchange="changeEstado('forma');">
                                    <option value="0"></option>
                                    @foreach ($estados as $k => $v)
                                        <option value="{{$k}}">{{$v}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="edad" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Delegación o Municipio:</label>
                                <input name="Municipio" id="Municipio" type="text" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="edad">Colonia:</label>
                                <input name="Colonia" id="Colonia" type="text" class="form-control">
                            </div>                                                                                    

                        </div>
