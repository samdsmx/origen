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
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                          </div>
                        </div>

                        <div class="box-body">

                            <div class="form-group col-md-4" style="white-space: nowrap;">
                                <label for="CP">Codigo Postal:</label>
                                <input type="number" class="form-control" id="cp" name="cp" placeholder="#####">
                            </div>

                            <div class="form-group col-md-8">
                                <label for="Estado">Estado:</label>
                                <select name="Estado" id="Estado" class="form-control">
                                    <option value="0">-</option>
                                    @foreach ($estados as $k => $v)
                                        <option value="{{$k}}">{{$v}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="Municipio" 
                                       style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    Delegación o Municipio:
                                </label>
                                <select name="Municipio" id="Municipio" class="form-control">
                                    <option value="0">-</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="Colonia">Colonia:</label>
                                <select name="Colonia" id="Colonia" class="form-control">
                                    <option value="0">-</option>
                                </select>
                            </div>                                                                                    

                        </div>