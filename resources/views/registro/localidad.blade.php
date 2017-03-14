                        <div class="box-header with-border">

                          <h3 class="box-title col-sm-3">Localidad</h3>
                          
                          <label class="col-sm-3" style="white-space: nowrap; overflow: hidden;">
                            <input type="radio" name="Localidad" value="Mexico" onchange="changePais('forma');" checked>
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
                                <label for="edad">Codigo Postal:</label>
                                <input type="number" class="form-control" placeholder="#####">
                            </div>

                            <div class="form-group col-md-8">
                                <label for="edad">Entidad:</label>
                                <select name="Estado" id="Estado" class="form-control" onchange="changeEstado('forma');">
                                <option value="">-</option>
                                <option>Aguascalientes</option>
                                <option>Baja California</option>
                                <option>Baja California Sur</option>
                                <option>Campeche</option>
                                <option>Chiapas</option>
                                <option>Chihuahua</option>
                                <option>Coahuila de Zaragoza</option>
                                <option>Colima</option>
                                <option>Distrito Federal</option>
                                <option>Durango</option>
                                <option>Guanajuato</option>
                                <option>Guerrero</option>
                                <option>Hidalgo</option>
                                <option>Jalisco</option>
                                <option>México</option>
                                <option>Michoacán de Ocampo</option>
                                <option>Morelos</option>
                                <option>Nayarit</option>
                                <option>Nuevo León</option>
                                <option>Oaxaca</option>
                                <option>Puebla</option>
                                <option>Querétaro</option>
                                <option>Quintana Roo</option>
                                <option>San Luis Potosí</option>
                                <option>Sinaloa</option>
                                <option>Sonora</option>
                                <option>Tabasco</option>
                                <option>Tamaulipas</option>
                                <option>Tlaxcala</option>
                                <option>Veracruz de Ignacio de la Llave</option>
                                <option>Yucatán</option>
                                <option>Zacatecas</option>
                                <option value="Extranjero">Extranjero</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="edad" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Delegación o Municipio:</label>
                                <input type="text" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="edad">Colonia:</label>
                                <input type="text" class="form-control">
                            </div>                                                                                    

                        </div>
