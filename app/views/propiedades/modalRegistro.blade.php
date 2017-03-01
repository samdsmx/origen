<div class="modal fade bs-example-modal-lg" id="modalRegistroPropiedades" tabindex="-1" role="dialog" aria-hidden="true">
    {{ Form::open(array('id' => 'registraPropiedad')) }}
    <div class="modal-dialog modal-lg" >
        <div class="modal-content" style="background: transparent" >
            <div class="modal-header" style="background-color: #3498DB; border-top: 1px solid #70B6E5;border-bottom: 5px solid #2372A7; border-radius: 5px 5px 0 0;">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title" id="registroLabel" style="color: #ffffff; text-align: center; font-weight: bolder;">
                    <span id="numeroPregunta" class="pull-left">Q00</span>
                    <span id="tituloModal" style="color:white;">Crear Popiedad</span>
                </h4>
            </div>
            <div class="modal-body" style="background: #ffffff; padding-bottom: 10px;">
                <input type="hidden" value="" name ="id_propiedad" id="id_propiedad" />
                <div class="col-lg-12">
                    <div class="col-lg-10 form-group" id="ddescripcion" style="text-align: center;" >
                        <h1>
                            <a href="#" id="descripcion_grafical" name="descripcion_grafical" data-type="textarea" 
                               style="text-shadow: 0 1px 0 #ccc,
                               0 2px 0 #c9c9c9,
                               0 3px 0 #bbb,
                               0 4px 0 #b9b9b9,
                               0 5px 0 #aaa,
                               0 6px 1px rgba(0,0,0,.1),
                               0 0 5px rgba(0,0,0,.1),
                               0 1px 3px rgba(0,0,0,.3),
                               0 3px 5px rgba(0,0,0,.2),
                               0 5px 10px rgba(0,0,0,.25),
                               0 10px 10px rgba(0,0,0,.2),
                               0 20px 20px rgba(0,0,0,.15);
                               color: #000;"></a>
                        </h1>
                        <span class="form-control" style="height: 1px; border-bottom: 0 !important; border-left: 0 !important; border-right: 0 !important;"/>
                        <input type="hidden" class="form-control" name="descripcion" id="descripcion" value=""/>
                    </div>      
                    <div class="col-lg-1" style="text-align: right;">
                        <div class='form-group' id="dobligatoria">
                            <input type="checkbox" name="obligatoria" id="obligatoria" value="1" checked />
                            <label>Obligatoria</label>
                        </div>
                    </div>
                </div>

                <div class="row text-center" style="margin-bottom: auto;">
                    <div class="col-lg-4">
                        <div class='form-group' id="did_grupo">
                            <select class="form-control" id="id_grupo" name="id_grupo">
                                <option value="0" selected disabled> -- Grupo -- </option>
                                @foreach($grupos as $grupo)
                                <option value="{{$grupo->id_grupo}}">{{$grupo->grupo}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>        

                    <div class="col-lg-4">
                        <div class='form-group' id="did_tipo">
                            <select class="form-control" name="id_tipo" id="id_tipo">
                                <option value="0" selected disabled> -- Tipo -- </option>
                                @foreach($tipos as $tipo)
                                <option value="{{$tipo->id_tipo}}">{{$tipo->tipo}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class='form-group input-group' id="dorden">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" data-value="decrease" data-target="#orden" data-toggle="spinner">
                                    <span class="glyphicon glyphicon-minus"></span>
                                </button>
                            </span>
                            <input type="text" data-ride="spinner" data-min="-5000" id="orden" name="orden" class="form-control input-number" placeholder="Orden">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default" data-value="increase" data-target="#orden" data-toggle="spinner">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>

                <fieldset>
                    <legend style="color: #bbb">Respuestas predefinidas</legend>
                    <div class="row text-center" style="margin-bottom: 5px;">
                        <div class="col-lg-6">
                            <div class="row text-center">
                                <div class="col-lg-6">
                                    <div class='form-group'>
                                        <input type="text" id="resDef" name="resDef" class="form-control" placeholder="Respuesta por Default" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <button id="addDefaultAnswer" class="btn btn-link"><i class="fa fa-plus"></i> Agregar Respuesta por Default</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6" style="overflow: auto; text-align: right">
                            <ul id="sortable">
                            </ul>
                            <input type="hidden" id="hiddenPredefinidas" name="hiddenPredefinidas" />
                            {{ HTML::image('images/trashbin.png', 'a delete', array('id' => 'trasbinsito', 'width' => '50px', 'height' => '50px')) }}
                        </div>
                    </div>
                </fieldset>

                <fieldset style="margin-bottom: auto !important;">
                    <legend style="color: #bbb">Condiciones</legend>
                    <div class="row text-center" style="margin-bottom: auto;">

                        <div class="col-lg-3">
                            <div class='form-group'>
                                <select class="form-control" id ="grupoCondicion">
                                    <option value="" selected disabled>-- Grupo --</option>
                                    @foreach($grupos as $grupo)
                                    <option value="{{$grupo->id_grupo}}">{{$grupo->grupo}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>  
                        <div class="col-lg-3">
                            <div class='form-group'>
                                <select class="form-control" id="preguntas">
                                    <option value="" selected disabled>-- Propiedad --</option>
                                </select>
                            </div>
                        </div>        
                        <div class="col-lg-2">
                            <div class='form-group'>
                                <select class="form-control" id="asignacion">
                                    <option value="=" selected>=</option>
                                    <option value="<>">&#60;&#62;</option>
                                    <option value=">"> &#62;  </option>
                                    <option value=">="> &#62;= </option>
                                    <option value="<"> &#60; </option>
                                    <option value="<="> &#60;= </option>
                                    <option value="like"> like </option>
                                    <option value="is Null"> is null </option>
                                    <option value="not Null"> not null </option>
                                </select>
                            </div>
                        </div>        
                        <div class="col-lg-3">
                            <div class='form-group'>
                                <input type="text" id="respDef" class="form-control" placeholder="Respuesta por Default" />
                            </div>
                        </div>
                        <a id="agregarCondicion" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i></a>
                    </div>
                    <div class="row text-center" style="margin-bottom: auto;">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <textarea class="form-control" rows="3" id="condicionesAnidadas" placeholder="Sentencia"></textarea>
                                <input type="hidden" id="valorConAn" name="valorConAn">
                            </div>
                        </div>
                    </div>
                    <div class="row text-center" style="margin-bottom: auto;">
                        <div class="col-lg-4 col-lg-offset-8">
                            <button class="btn btn-success disabled">Las unicas teclas permitidas son: Y, O, (, ), !</button>
                        </div>
                    </div>
                </fieldset>

            </div>
            <div class="modal-footer" style="background: #ffffff;">
                {{ Form::reset('Limpiar', array('class' => 'btn btn-primary', 'id' => "resetear")) }}
                {{ Form::submit('Guardar', array('class' => 'btn btn-success', 'id' => 'btnAgregaPropiedad')) }}
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>