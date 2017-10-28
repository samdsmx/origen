<div class="box-header with-border">
  <h3 class="box-title">Datos Generales</h3>
  <div class="box-tools pull-right">
    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
  </div>
</div>

<div class="box-body">

    <div id="dNombre" class="form-group col-md-6">
      <label for="Nombre">Nombre:</label>
      <input type="text" class="form-control" id="Nombre" name="Nombre" placeholder="Nombre completo">
    </div>

    <div class="form-group col-md-2">
      <label for="Edad">Edad:</label>
      <input type="number" class="form-control" name="Edad" placeholder="Edad en años" >
    </div>

    <div class="form-group col-md-4">
        <label for="EstadoCivil">Estado Civil:</label>
        <select name="EstadoCivil" class="form-control" style="width: 100%;">
         <option>-</option>
         <option value="Soltera">Soltera</option>
         <option value="Divorciada">Divorciada</option>
         <option value="Viuda">Viuda</option>
         <option value="Casada">Casada</option>
         <option value="Separada">Separada</option>
         <option value="Concubinato">Concubinato</option>
         <option value="Union Libre">Union Libre</option>
        </select>
    </div>

    <div class="form-group col-md-3">
      <label for="Sexo">Genero:</label>
      <div class="radio">
        <label class="col-md-6 col-sm-6" style="white-space: nowrap; overflow: hidden;">
          <input type="radio" name="Sexo" value="f" checked>
          Femenino
        </label>
        <label class="col-md-6 col-sm-6" style="white-space: nowrap; overflow: hidden;">
          <input type="radio" name="Sexo" value="m">
          Masculino
        </label>
      </div>
    </div>

    <div class="form-group col-md-5">
        <label for="NivelEstudios">Nivel de estudios:</label>
        <select name="NivelEstudios" class="form-control">
            <option selected>-</option>
            <option>Analfabeta</option>
            <option>Primaria</option>
            <option>Secundaria</option>
            <option>Preparatoria</option>
            <option>Carrera Técnica</option>
            <option>Carrera Universitaria</option>
            <option>Posgrado</option>
        </select>
    </div>

    <div class="form-group col-md-4">
        <label for="Religion">Religión:</label>
        <select name="Religion" class="form-control">
         <option selected>-</option>
         <option>Catolica</option>
         <option>Musulmana</option>
         <option>Judia</option>
         <option>Pentecostes</option>
         <option>Mormona</option>
         <option>Evangelica</option>
         <option>Cristiana</option>
         <option>Testigo de Jehova</option>
         <option>Ninguna</option>
        </select>
    </div>

    <div class="form-group col-md-3">
      <label for="LenguaIndigena" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">¿Habla alguna lengua indigena?</label>
      <div class="radio">
        <label class="col-md-6 col-sm-6" style="white-space: nowrap; overflow: hidden;">
          <input type="radio" name="LenguaIndigena" value="no" checked>
          No
        </label>
        <label class="col-md-6 col-sm-6" style="white-space: nowrap; overflow: hidden;">
          <input type="radio" name="LenguaIndigena" value="si">
          Si
        </label>
      </div>
    </div>

    <div class="form-group col-md-5">
      <label for="Ocupacion">Ocupación:</label>
      <select name="Ocupacion" class="form-control" style="width: 100%;" onchange="showfield(this.options[this.selectedIndex].value)">
        <option selected>-</option>
        <option>Ama de casa</option>
        <option>Empleada</option>
        <option>Empleada Domestica</option>
        <option>Negocio propio</option>
        <option>Jubilado y/o pensionado</option>
        <option>Estudiante</option>
        <option>Desempleada</option>
        <option value="Otra">Otra :</option>
      </select>
    </div>

    <div class="form-group col-md-4">
      <label for="VivesCon">Vives con...</label>
      <select name="VivesCon" class="form-control" style="width: 100%;">
            <option>Sola</option>
            <option>Padres</option>
            <option>Pareja</option>
            <option selected>Familia</option>
            <option>Hijos</option>
            <option>Padre</option>
            <option>Madre</option>
            <option>Otros</option>
      </select>
    </div>

</div>