<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Conversion de Tasa</title>
<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap theme -->
	<link href="css/bootstrap-theme.min.css" rel="stylesheet">
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<!-- Custom styles for this template -->
	<link href="css/theme.css" rel="stylesheet">
<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	<script src="js/ie-emulation-modes-warning.js"></script>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!--  Archivos para funcion de Validacion con Bootstrap (Parte I)
    <link href='css/bootstrapValidator.min.css' rel='stylesheet'>
    <script src='js/jquery-1.11.1.min.js'></script>
    <script src='js/es_ES.min.js'></script>
 =========================================================== -->

<!--  ===================CONVERSION DE TASA====================== -->
<script type='text/javascript'>

function validar(){
  var Enviar=true
  with (document.frm_dato){
   if ((tasa1.value=="" || isNaN(tasa1.value)) && Enviar)       
   {
      Enviar=false
      alert("Tasa inicial no valida.")        
      tasa1.focus()
   }
   if (tipo1.value=="0" && Enviar)     
   {
      Enviar=false
      alert("No ha seleccionado el tipo de tasa inicial.")        
      tipo1.focus()
   }
   if (periodo1.value=="0" && Enviar)        
   {
      Enviar=false
      alert("No ha seleccionado el periodo de la tasa inicial.")        
      periodo1.focus()
   }
   if (forma1.value=="0" && Enviar)        
   {
      Enviar=false
      alert("No ha seleccionado la forma de la tasa inicial.")        
      forma1.focus()
   }

   if (tipo2.value=="0" && Enviar)     
   {
      Enviar=false
      alert("No ha seleccionado el tipo de tasa final.")        
      tipo2.focus()
   }
   if (periodo2.value=="0" && Enviar)        
   {
      Enviar=false
      alert("No ha seleccionado el periodo de la tasa final.")        
      periodo2.focus()
   }
   if (forma2.value=="0" && Enviar)        
   {
      Enviar=false
      alert("No ha seleccionado la forma de la tasa final.")        
      forma2.focus()
   }
   
    if (Enviar==true){
      convertir();
    }
  }
}


function convertir(){
 with (document.frm_dato){
  
  ts1=(tasa1.value)/100;
  
  if(tipo1.value==1 && forma1.value==1){
    tp1="E";  
  }else{
    if(tipo1.value==1 && forma1.value==2){
      tp1="Ea";  
    }else{
      if(tipo1.value==2 && forma1.value==1){
        tp1="N"; 
      }else{
        tp1="Na"; 
      }
    }
  }
  
  pr1=periodo1.value;
  pr2=periodo2.value;
  
  ///Inicial Nominal Anticipada
  if(tp1=="Na"){
    A=ts1;
  }else{
    A=0;
  }
  ///Inicial Efectiva Anticipada
  if(tp1=="Ea"){
    B=ts1;
  }else{
    B=A/pr1;
  }
  ///Inicial Nominal
  if(tp1=="N"){
    C=ts1;
  }else{
    C=A/pr1;
  }
  ///Inicial Efectiva
  if(tp1=="E"){
    D=ts1;
  }else{
    if(tp1=="N"){
      D=C/pr1;
    }else{
      D=B/(1-B);
    }
  }  
  ///Final Efectiva
  E=Math.pow(1+D,pr1/pr2)-1;  
  ///Final Efectiva Anticipada
  F=E/(1+E);  
  ///Final Nominal Anticipada
  G=F*pr2;  
  ///Final Nominal
  H=E*pr2;  

  if(tipo2.value==1 && forma2.value==1){
    tasa2.value=parseFloat(E*100).toFixed(7);
    }else{
    if(tipo2.value==1 && forma2.value==2){
      tasa2.value=parseFloat(F*100).toFixed(7);  
    }else{
      if(tipo2.value==2 && forma2.value==1){
        tasa2.value=parseFloat(H*100).toFixed(7); 
      }else{
        tasa2.value=parseFloat(G*100).toFixed(7); 
      }
    }
  }
 }
}
</script>
<!--  =========================================================== -->

</head>
<body>
<div class="container theme-showcase" role="main">
    <div class="col-sm-4">
    </div>
    <div class="col-sm-5">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title" align="center">Conversi&oacute;n de Tasas</h3>
        </div>
        <div class="panel-body">
          <form action="tasa.php" method="post" class="form-horizontal" id="frm_dato" name="frm_dato" role="form"> 
           <h3>
              <span class="label label-success" >Tasa Inicial</span>
            </h3>
            <div class="form-group">
              <label for="tasa1" class="col-xs-3 control-label">Tasa:</label> 
              <div class="col-xs-7">
                <div class="input-group">
                  <input name="tasa1" type="text" class="form-control" id="tasa1" placeholder="Tasa Inicial" maxlength="10" value=""> 
                  <span class="input-group-addon">%</span>
                </div>
              </div> 
            </div>
            <div class="form-group"> 
              <label for="tipo1" class="col-xs-3 control-label">Tipo:</label> 
              <div class="col-xs-7"> 
                <select name="tipo1" id="tipo1" class="form-control">
                  <option value="0">Seleccione</option>
                  <option value="1">Efectiva</option>
                  <option value="2">Nominal</option>
                </select>
              </div> 
            </div>
            <div class="form-group"> 
              <label for="periodo1" class="col-xs-3 control-label">Periodo:</label> 
              <div class="col-xs-7"> 
                <select name="periodo1" id="periodo1" class="form-control">
                  <option value="0">Seleccione</option>
                  <option value="360">Diario</option>
                  <option value="12">Mensual</option>
                  <option value="6">Bimestral</option>
                  <option value="4">Trimestral</option>
                  <option value="2">Semestral</option>
                  <option value="1">Anual</option>
                </select>
              </div> 
            </div>
            <div class="form-group"> 
              <label for="forma1" class="col-xs-3 control-label">Forma:</label> 
              <div class="col-xs-7"> 
                <select name="forma1" id="forma1" class="form-control">
                  <option value="0">Seleccione</option>
                  <option value="1">Vencida</option>
                  <option value="2">Anticipada</option>
                </select>
              </div> 
            </div>
           <h3>
              <span class="label label-default" >Tasa Final</span>
            </h3>
            
            <div class="form-group"> 
              <label for="tipo2" class="col-xs-3 control-label">Tipo:</label> 
              <div class="col-xs-7"> 
                <select name="tipo2" id="tipo2" class="form-control">
                  <option value="0">Seleccione</option>
                  <option value="1">Efectiva</option>
                  <option value="2">Nominal</option>
                </select>
              </div> 
            </div>
            <div class="form-group"> 
              <label for="periodo2" class="col-xs-3 control-label">Periodo:</label> 
              <div class="col-xs-7"> 
                <select name="periodo2" id="periodo2" class="form-control">
                  <option value="0">Seleccione</option>
                  <option value="360">Diario</option>
                  <option value="12">Mensual</option>
                  <option value="6">Bimestral</option>
                  <option value="4">Trimestral</option>
                  <option value="2">Semestral</option>
                  <option value="1">Anual</option>
                </select>
              </div> 
            </div>
            <div class="form-group"> 
              <label for="forma2" class="col-xs-3 control-label">Forma:</label> 
              <div class="col-xs-7"> 
                <select name="forma2" id="forma2" class="form-control">
                  <option value="0">Seleccione</option>
                  <option value="1">Vencida</option>
                  <option value="2">Anticipada</option>
                </select>
              </div> 
            </div>
            <div class="form-group">
              <label for="tasa2" class="col-xs-3 control-label">Tasa:</label> 
              <div class="col-xs-7">
                <div class="input-group"> 
                  <input name="tasa2" type="text" class="form-control" id="tasa2" placeholder="" maxlength="30" value="" readonly="true"> 
                  <span class="input-group-addon">%</span>
                </div>
              </div> 
            </div>
            <div class="form-group" align="center"> 
              <button type="button" class="btn btn-info" onclick="validar();">Convertir</button>
              <button type="button" class="btn btn-warning" onclick="javascript:location.href='principal.php'">Cancelar</button>
            </div> 
          </form>
        </div>
      </div>
    </div><!-- /.col-sm-4 -->
</div> <!-- /container -->
    <!-- Bootstrap core JavaScrip -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/js/ie10-viewport-bug-workaround.js"></script>

<!-- Archivos para funcion de Validacion con Bootstrap(Parte II)  
    <script src='js/bootstrapValidator.min.js'></script>
    <script src="js/jquery.validate.js"></script>
    <script src='js/vali-tasa.js'></script>
 =========================================================== -->
</body>
</html>