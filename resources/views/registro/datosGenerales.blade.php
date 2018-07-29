<div class="box-header with-border">
  <h3 class="box-title">Datos Generales</h3>
  <div class="box-tools pull-right">
    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
  </div>
</div>

<div class="box-body">

    <div id="dNombre" class="form-group col-md-6">
      <label for="Nombre">Nombre:</label>
      <input type="text"
        @if($datosGenerales['nombre']  != '') disabled @endif 
        value="{{ $datosGenerales['nombre'] }}"
        class="form-control" 
        id="Nombre"
        name="Nombre" 
        placeholder="Nombre completo">
    </div>

    <div class="form-group col-md-2">
      <label for="Edad">Edad:</label>
      <input 
        @if($datosGenerales['edad']  != '') disabled @endif 
        value="{{ $datosGenerales['edad'] }}"
        type="number"
        class="form-control" 
        name="Edad" 
<<<<<<< HEAD
        id="Edad" 
=======
>>>>>>> 54441381fc792ce67d2c4dcd8fa3c3969ef0a3c1
        placeholder="Edad en años" >
    </div>

    <div class="form-group col-md-4">
        <label for="EstadoCivil">Estado Civil:</label>
<<<<<<< HEAD
        <select @if($datosGenerales['estadoCivil']  != '') disabled @endif  id="EstadoCivil" name="EstadoCivil" class="form-control" style="width: 100%;">
=======
        <select @if($datosGenerales['estadoCivil']  != '') disabled @endif name="EstadoCivil" class="form-control" style="width: 100%;">
>>>>>>> 54441381fc792ce67d2c4dcd8fa3c3969ef0a3c1
         <option @if($datosGenerales['estadoCivil']  == '') selected @endif >-</option>
         <option @if($datosGenerales['estadoCivil']  == 'Soltera') selected @endif value="Soltera">Soltera</option>
         <option @if($datosGenerales['estadoCivil']  == 'Divorciada') selected @endif value="Divorciada">Divorciada</option>
         <option @if($datosGenerales['estadoCivil']  == 'Viuda') selected @endif value="Viuda">Viuda</option>
         <option @if($datosGenerales['estadoCivil']  == 'Casada') selected @endif value="Casada">Casada</option>
         <option @if($datosGenerales['estadoCivil']  == 'Separada') selected @endif value="Separada">Separada</option>
         <option @if($datosGenerales['estadoCivil']  == 'Concubinato') selected @endif value="Concubinato">Concubinato</option>
         <option @if($datosGenerales['estadoCivil']  == 'Union Libre') selected @endif value="Union Libre">Union Libre</option>
        </select>
    </div>

    <div class="form-group col-md-3">
      <label for="Sexo">Genero:</label>
      <div class="radio">
        <label class="col-md-6 col-sm-6" style="white-space: nowrap; overflow: hidden;">
          <input type="radio" name="Sexo" value="f" @if($datosGenerales['genero'] != 'm') checked @endif>
          Femenino
        </label>
        <label class="col-md-6 col-sm-6" style="white-space: nowrap; overflow: hidden;">
          <input type="radio" name="Sexo" value="m" @if($datosGenerales['genero'] == 'm') checked @endif>
          Masculino
        </label>
      </div>
    </div>

    <div class="form-group col-md-5">
        <label for="NivelEstudios">Nivel de estudios:</label>
<<<<<<< HEAD
        <select @if($datosGenerales['estudios']  != '') disabled @endif id="NivelEstudios" name="NivelEstudios" class="form-control">
=======
        <select @if($datosGenerales['estudios']  != '') disabled @endif name="NivelEstudios" class="form-control">
>>>>>>> 54441381fc792ce67d2c4dcd8fa3c3969ef0a3c1
            <option @if($datosGenerales['estudios']  == '') selected @endif >-</option>
            <option @if($datosGenerales['estudios']  == 'Analfabeta') selected @endif >Analfabeta</option>
            <option @if($datosGenerales['estudios']  == 'Primaria') selected @endif >Primaria</option>
            <option @if($datosGenerales['estudios']  == 'Secundaria') selected @endif >Secundaria</option>
            <option @if($datosGenerales['estudios']  == 'Preparatoria') selected @endif >Preparatoria</option>
            <option @if($datosGenerales['estudios']  == 'Carrera Técnica') selected @endif >Carrera Técnica</option>
            <option @if($datosGenerales['estudios']  == 'Carrera Universitaria') selected @endif >Carrera Universitaria</option>
            <option @if($datosGenerales['estudios']  == 'Posgrado') selected @endif >Posgrado</option>
        </select>
    </div>

    <div class="form-group col-md-4">
        <label for="Religion">Religión:</label>
<<<<<<< HEAD
        <select  @if($datosGenerales['religion']  != '') disabled @endif id="Religion" name="Religion" class="form-control">
=======
        <select  @if($datosGenerales['religion']  != '') disabled @endif name="Religion" class="form-control">
>>>>>>> 54441381fc792ce67d2c4dcd8fa3c3969ef0a3c1
         <option @if($datosGenerales['religion']  == '') selected @endif>-</option>
         <option @if($datosGenerales['religion']  == 'Catolica') selected @endif>Catolica</option>
         <option @if($datosGenerales['religion']  == 'Musulmana') selected @endif>Musulmana</option>
         <option @if($datosGenerales['religion']  == 'Judia') selected @endif>Judia</option>
         <option @if($datosGenerales['religion']  == 'Pentecostes') selected @endif>Pentecostes</option>
         <option @if($datosGenerales['religion']  == 'Mormona') selected @endif>Mormona</option>
         <option @if($datosGenerales['religion']  == 'Evangelica') selected @endif>Evangelica</option>
         <option @if($datosGenerales['religion']  == 'Cristiana') selected @endif>Cristiana</option>
         <option @if($datosGenerales['religion']  == 'Testigo de Jehova') selected @endif>Testigo de Jehova</option>
         <option @if($datosGenerales['religion']  == 'Ninguna') selected @endif>Ninguna</option>
        </select>
    </div>

    <div class="form-group col-md-3">
      <label for="LenguaIndigena" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">¿Habla alguna lengua indigena?</label>
      <div class="radio">
        <label class="col-md-6 col-sm-6" style="white-space: nowrap; overflow: hidden;">
          <input type="radio" name="LenguaIndigena" value="no"  @if($datosGenerales['lengua'] != 'Si') checked @endif>
          No
        </label>
        <label class="col-md-6 col-sm-6" style="white-space: nowrap; overflow: hidden;">
          <input type="radio" name="LenguaIndigena" value="si" @if($datosGenerales['lengua']  == 'Si') checked @endif>
          Si
        </label>
      </div>
    </div>

    <div class="form-group col-md-5">
      <label for="Ocupacion">Ocupación:</label>
<<<<<<< HEAD
      <select @if($datosGenerales['ocupacion']  != '') disabled @endif id="Ocupacion" name="Ocupacion" class="form-control" style="width: 100%;" onchange="showfield(this.options[this.selectedIndex].value)">
=======
      <select @if($datosGenerales['ocupacion']  != '') disabled @endif name="Ocupacion" class="form-control" style="width: 100%;" onchange="showfield(this.options[this.selectedIndex].value)">
>>>>>>> 54441381fc792ce67d2c4dcd8fa3c3969ef0a3c1
        <option @if($datosGenerales['ocupacion']  == '') selected @endif>-</option>
        <option @if($datosGenerales['ocupacion']  == 'Ama de casa') selected @endif>Ama de casa</option>
        <option @if($datosGenerales['ocupacion']  == 'Empleada') selected @endif>Empleada</option>
        <option @if($datosGenerales['ocupacion']  == 'Empleada Domestica') selected @endif>Empleada Domestica</option>
        <option @if($datosGenerales['ocupacion']  == 'Negocio propio') selected @endif>Negocio propio</option>
        <option @if($datosGenerales['ocupacion']  == 'Jubilado y/o pensionado') selected @endif>Jubilado y/o pensionado</option>
        <option @if($datosGenerales['ocupacion']  == 'Estudiante') selected @endif>Estudiante</option>
        <option @if($datosGenerales['ocupacion']  == 'Desempleada') selected @endif>Desempleada</option>
        <option @if($datosGenerales['ocupacion']  == 'Otra :') selected @endif value="Otra">Otra :</option>
      </select>
    </div>

    <div class="form-group col-md-4">
      <label for="VivesCon">Vives con...</label>
<<<<<<< HEAD
      <select @if($datosGenerales['vives']  != '') disabled @endif id="VivesCon" name="VivesCon" class="form-control" style="width: 100%;">
=======
      <select @if($datosGenerales['vives']  != '') disabled @endif name="VivesCon" class="form-control" style="width: 100%;">
>>>>>>> 54441381fc792ce67d2c4dcd8fa3c3969ef0a3c1
            <option @if($datosGenerales['vives']  == 'Sola') selected @endif>Sola</option>
            <option @if($datosGenerales['vives']  == 'Padres') selected @endif>Padres</option>
            <option @if($datosGenerales['vives']  == 'Pareja') selected @endif>Pareja</option>
            <option @if($datosGenerales['vives']  == '' || 
              $datosGenerales['vives']  == 'Familia') selected @endif>Familia</option>
            <option @if($datosGenerales['vives']  == 'Hijos') selected @endif>Hijos</option>
            <option @if($datosGenerales['vives']  == 'Padre') selected @endif>Padre</option>
            <option @if($datosGenerales['vives']  == 'Madre') selected @endif>Madre</option>
            <option @if($datosGenerales['vives']  == 'Otros') selected @endif>Otros</option>
      </select>
    </div>

</div>