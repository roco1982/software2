<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gradientes</title>
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


</head>
<body>
<div class="container theme-showcase" role="main">
    <div class="col-sm-4">
    </div>
    <div class="col-sm-7">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title" align="center">Anualidades</h3>
        </div>
        <div class="panel-body">
          <form action="" method="post" class="form-horizontal" id="frm_dato" name="frm_dato" role="form"> 
<?php

  $vp=$_POST['inicial'];
  $vf=$_POST['final'];
  $x=$_POST['cuota'];
  $n=$_POST['periodo'];
  $pi=$_POST['per_ini'];
  $in=$_POST['tasa']/100;
  $n_extras=$_POST['extra'];

  if($_POST['tipo']==1){
    $mul=1;
  }else{
    $mul=1+$in;
  }

  if($_POST['variacion']==1){
    $signo=1;
  }else{
    $signo=-1;
  }

  if($_POST['clase']==1){
    $grad=$_POST['gradiente'];
    $label1="<span class='input-group-addon'>$</span>";
    $label2="";
  }else{
    $grad=$_POST['gradiente']/100; 
    $label1="";
    $label2="<span class='input-group-addon'>%</span>";
  }
  
  if($n_extras>0){
    $matriz[$n_extras][2];
    $tot_extras=0;

    $matriz[0][1]=strtok($_POST['pe'],'-');
    for($i=1; $i<$n_extras; $i++){
        $matriz[$i][1]=strtok('-');
    }

    $matriz[0][2]=strtok($_POST['ce'],'-');
    for($i=1; $i<$n_extras; $i++){
        $matriz[$i][2]=strtok('-');
    }
    
    if($matriz[0][1]==0){
      $ci=$matriz[0][2];
      for($i=1; $i<$n_extras; $i++){
          $tot_extras=$tot_extras+($matriz[$i][2]*pow(1+$in,-$matriz[$i][1]));
      }
    }else{
      for($i=0; $i<$n_extras; $i++){
          $tot_extras=$tot_extras+($matriz[$i][2]*pow(1+$in,-$matriz[$i][1]));
      }
    }
  }

  $etiqueta1="";
  $etiqueta2="";
  $etiqueta3="";
  $etiqueta4="";
  $etiqueta5="";
  $etiqueta6="";
  $etiqueta7="";

  $opc=$_POST['variable']."-".$_POST['clase'];

switch($opc){
  case '1-1':   //Gradiente cuota-Lineal
    if($vp==0){
      $final=($vf*pow(1+$in,-$n));
    }else{
      $final=-($vf*pow(1+$in,-$n));  
    }
    $x=((($vp-$ci-$tot_extras+$final)/($mul*pow(1+$in,0-$pi)))-(((($grad*$signo)/$in)*(((1-pow(1+$in,-$n))/$in)-($n*pow(1+$in,-$n))))))/(((1-pow(1+$in,-$n))/$in));
    $etiqueta4="has-error'";
  break;


  case '1-2':   //Gradiente cuota-geometrico
    if($vp==0){
      $final=($vf*pow(1+$in,-$n));
    }else{
      $final=-($vf*pow(1+$in,-$n));  
    }
    $x=((($vp-$ci-$tot_extras+$final)/($mul*pow(1+$in,0-$pi)))*(($grad*$signo)-$in))/((pow(1+($grad*$signo),$n)*pow(1+$in,-$n))-1);
    $grad=$grad*100;
    $etiqueta4="has-error'";
  break;


  case '2-1':   //Gradiente Valor_Inicial-Lineal
    $vp=(($x*((1-pow(1+$in,-$n))/$in)+((($grad*$signo)/$in)*(((1-pow(1+$in,-$n))/$in)-($n*pow(1+$in,-$n)))))*$mul*pow(1+$in,0-$pi))+$tot_extras+$ci;
    $etiqueta1="has-error";
  break;


  case '2-2':   //Gradiente Valor_Inicial-Geometrico
    $vp=((($x*((pow(1+($grad*$signo),$n)*pow(1+$in,-$n))-1))/(($grad*$signo)-$in))*$mul*pow(1+$in,0-$pi))+$tot_extras+$ci;
    $grad=$grad*100;
    $etiqueta1="has-error";
  break;


  case '3-1':   //Gradiente Valor_final-Lineal
      $vf=((($x*((pow(1+$in,$n)-1)/$in))+((($grad*$signo)/$in)*(((pow(1+$in,$n)-1)/$in)-$n)))*$mul*pow(1+$in,0-$pi))+$tot_extras+$ci;
      $etiqueta3="has-error";
  break;


  case '3-2':   //Gradiente Valor_final-Geometrico
    $vf=((($x*(pow(1+($grad*$signo),$n)-pow(1+$in,$n)))/(($grad*$signo)-$in))*$mul*pow(1+$in,0-$pi))+$tot_extras+$ci;
    $grad=$grad*100;
    $etiqueta3="has-error";
  break;


  case '4-1':   //Gradiente Periodo-Lineal
    $n=0.001;
    do{
      $y=($vp-$ci-$tot_extras)-(($x*((1-pow(1+$in,-$n))/$in)+((($grad*$signo)/$in)*(((1-pow(1+$in,-$n))/$in)-($n*pow(1+$in,-$n)))))*$mul*pow(1+$in,0-$pi));
      $n=$n+0.001;
    } while($y>=0);
    $etiqueta5="has-error";
  break;


  case '4-2':   //Gradiente Periodo-Geometrico
    $n=0.001;
    do{
      $y=($vp-$ci-$tot_extras)-((($x*((pow(1+($grad*$signo),$n)*pow(1+$in,-$n))-1))/(($grad*$signo)-$in))*$mul*pow(1+$in,0-$pi));
      $n=$n+0.001;
    } while($y>=0);
    $grad=$grad*100;
    $etiqueta5="has-error";
  break;

  case '5-1':   //Gradiente Tasa-Lineal
   $in=0.0000001;
    do{
      if($_POST['tipo']==1){
        $mul=1;
      }else{
        $mul=1+$in;
      }
      $y=($vp-$ci-$tot_extras)-(($x*((1-pow(1+$in,-$n))/$in)+((($grad*$signo)/$in)*(((1-pow(1+$in,-$n))/$in)-($n*pow(1+$in,-$n)))))*$mul*pow(1+$in,0-$pi));
      $in=$in+0.0000001;
    } while($y<=0);
    $etiqueta6="has-error";
  break;


  case '5-2':   //Gradiente Tasa-Geometrico
    $in=0.0000001;
    do{
      if($_POST['tipo']==1){
        $mul=1;
      }else{
        $mul=1+$in;
      }
      $y=($vp-$ci-$tot_extras)-((($x*((pow(1+($grad*$signo),$n)*pow(1+$in,-$n))-1))/(($grad*$signo)-$in))*$mul*pow(1+$in,0-$pi));
      $in=$in+0.0000001;
    } while($y<=0);

    $grad=$grad*100;
    $etiqueta6="has-error";
  break;


  case '6-1':   //Gradiente Cuota_inicial_lineal
    $ci=$vp-$tot_extras-(($x*((1-pow(1+$in,-$n))/$in)+((($grad*$signo)/$in)*(((1-pow(1+$in,-$n))/$in)-($n*pow(1+$in,-$n)))))*$mul*pow(1+$in,0-$pi));
    $etiqueta2="has-error";
  break;


  case '6-2':   //Gradiente Cuota_inicial_Geometrico
    $ci=$vp-$tot_extras-((($x*((pow(1+($grad*$signo),$n)*pow(1+$in,-$n))-1))/(($grad*$signo)-$in))*$mul*pow(1+$in,0-$pi));
    $etiqueta2="has-error";
  break;


  case '7-1':   //Gradiente Gradiente-Lineal
    $grad=(((($vp-$ci-$tot_extras)/($mul*pow(1+$in,0-$pi)))-($x*((1-pow(1+$in,-$n))/$in)))*$in)/(((1-pow(1+$in,-$n))/$in)-($n*pow(1+$in,-$n)));
    $etiqueta7="has-error";
  break;


  case '7-2':   //Gradiente Gradiente-Geometrico
    $grad=0.00001;
    if($signo==1){
      do{
        $y=($vp-$ci-$tot_extras)-((($x*((pow(1+($grad*$signo),$n)*pow(1+$in,-$n))-1))/(($grad*$signo)-$in))*$mul*pow(1+$in,0-$pi));
        $grad=$grad+0.00001;
      } while($y>=0);
    }else{
      do{
        $y=($vp-$ci-$tot_extras)-((($x*((pow(1+($grad*$signo),$n)*pow(1+$in,-$n))-1))/(($grad*$signo)-$in))*$mul*pow(1+$in,0-$pi));
        $grad=$grad+0.00001;
      } while($y<=0);

    }
    $grad=$grad*100;
    $etiqueta7="has-error";
  break;
}

  echo "<div class='form-group ".$etiqueta1."'>
          <label for='inicial' class='col-xs-4 control-label'>Valor Inicial:</label> 
          <div class='col-xs-6'>
            <div class='input-group'>
              <span class='input-group-addon'>$</span>
              <input name='inicial' type='text' class='form-control' id='inicial' placeholder='' maxlength='10' readonly='true' value='".number_format($vp, 0, '.', ',')."'> 
            </div>
          </div> 
        </div>

        <div class='form-group'>
          <label for='per_ini' class='col-xs-4 control-label'>Periodo Inicial:</label> 
          <div class='col-xs-6'>
              <input name='per_ini' type='text' class='form-control' id='per_ini' placeholder='' maxlength='10' readonly='true' value='".$pi."'> 
          </div> 
        </div>

        <div class='form-group ".$etiqueta2."'>
          <label for='cuota_i' class='col-xs-4 control-label'>Cuota Inicial:</label> 
          <div class='col-xs-6'>
            <div class='input-group'>
              <span class='input-group-addon'>$</span>
              <input name='cuota_i' type='text' class='form-control' id='cuota_i' placeholder='' readonly='true' maxlength='10' value='".number_format($ci, 0, '.', ',')."'> 
            </div>
          </div> 
        </div>

        <div class='form-group ".$etiqueta3."'>
          <label for='final' class='col-xs-4 control-label'>Valor Final:</label> 
          <div class='col-xs-6'>
            <div class='input-group'>
              <span class='input-group-addon'>$</span>
              <input name='final' type='text' class='form-control' id='final' placeholder='' readonly='true' maxlength='10' value='".number_format($vf, 0, '.', ',')."'> 
            </div>
          </div> 
        </div>

        <div class='form-group ".$etiqueta4."'>
          <label for='cuota' class='col-xs-4 control-label'>Valor Cuota:</label> 
          <div class='col-xs-6'>
            <div class='input-group'>
              <span class='input-group-addon'>$</span>
              <input name='cuota' type='text' class='form-control' id='cuota' placeholder='' readonly='true' maxlength='10' value='".number_format($x, 0, '.', ',')."'> 
            </div>
          </div> 
        </div>

        <div class='form-group ".$etiqueta5."'>
          <label for='salida' class='col-xs-4 control-label'>No. Periodos:</label> 
          <div class='col-xs-6'>
            <input name='salida' type='text' class='form-control' id='salida' placeholder='' maxlength='10' readonly='true' value='".number_format($n, 2, '.', ',')."'> 
          </div> 
        </div>

        <div class='form-group ".$etiqueta6."'>
          <label for='tasa' class='col-xs-4 control-label'>Tasa:</label> 
          <div class='col-xs-6'>
            <div class='input-group'>
              <input name='tasa' type='text' class='form-control' id='tasa' placeholder='' maxlength='10' readonly='true' value='".number_format($in*100, 4, '.', ',')."'> 
              <span class='input-group-addon'>%</span>
            </div>
          </div> 
        </div>

        <div class='form-group ".$etiqueta7."'>
          <label for='gradiente' class='col-xs-4 control-label'>Gradiente:</label> 
          <div class='col-xs-6'>
            <div class='input-group'>
              ".$label1."
              <input name='gradiente' type='text' class='form-control' id='gradiente' placeholder='' readonly='true' maxlength='10' value='".number_format(($grad*$signo), 2, '.', ',')."'>
              ".$label2."
            </div>
          </div> 
        </div>";

  echo "<div class='table-responsive'>
        <div class='panel panel-default>
        <div class='panel-heading'>
          <h3>
            <span class='label label-success'>Tabla de Amortizaci&oacute;n</span>
          </h3>
        </div>
          <table class='table table-bordered'>
            <thead>
              <tr>
                <th align='center'>No.</th>
                <th align='center'>Vr. Cuota</th>
                <th align='center'>Vr. Interes</th>
                <th align='center'>Abono Capital</th>
                <th align='center'>Cuota Extra</th>
                <th align='center'>Saldo</th>
              </tr>
            </thead>
            <tbody>";
  
  if($n!=nan){
    $n1=Ceil($n)+$pi;
  }else{
    $n1=0;
  }
  
  $sal=$vp;
  $s_x=0;
  $s_inc=0;
  $v_extra=0;
  $xx=$x;

  if($_POST['tipo']==1){    //Tabla de amortización Gradiente Vencida
    echo"<tr>";
    echo "<td>0</td>";
    echo "<td align='right'>$0</td>";
    echo "<td align='right'>$0</td>";
    echo "<td align='right'>$".number_format($ci, 0, '.', ',')."</td>";
    echo "<td align='right'>$".number_format(0, 0, '.', ',')."</td>";
    echo "<td align='right'>$".number_format($sal=$sal-$ci, 0, '.', ',')."</td>";
    echo "</tr>";
    for($i=1;$i<=$n1;$i++){

      $inc=$sal*$in;

      if($i==$n1 && $sal<$x){
        $x=$sal+$inc-$v_extra;
      }

      if($n_extras==0){
        $v_extra=0; 
      }else{
        for($j=0; $j<$n_extras; $j++){
          if($matriz[$j][1]==$i){
            $v_extra=$matriz[$j][2];
            break;
          }else{
            $v_extra=0;
          }
        }
      }
      
      if($i<=$pi){
        $abono=0;  
        $x=0;
      }else{
        $x=$xx;
        $abono=$x-$inc;

        if($_POST['clase']==1){
          $xx=$x+($grad*$signo);
        }else{
          $xx=$x+($x*(($grad*$signo)/100));
        }

      }

      if($vp==0){
        $sal=$sal+$inc+$x+$v_extra;
        $abono=0;
      }else{
        $sal=$sal+$inc-$x-$v_extra;  
      }

      echo"<tr>";
      echo "<td>".$i."</td>";
      echo "<td align='right'>$".number_format($x, 0, '.', ',')."</td>";
      echo "<td align='right'>$".number_format($inc, 0, '.', ',')."</td>";
      echo "<td align='right'>$".number_format($abono, 0, '.', ',')."</td>";
      echo "<td align='right'>$".number_format($v_extra, 0, '.', ',')."</td>"; 
      echo "<td align='right'>$".number_format($sal, 0, '.', ',')."</td>";
      echo "</tr>";

      $s_x=$s_x+$x;
      $s_inc=$s_inc+$inc;
      $v_extra=0;

    }

  }else{                  //Tabla de Amortización Gradiente Anticipada

    if($pi>0){
      $x=0;
    }else{
      $x=$xx;
    }

    $s_x=$x;
    $inc=0;    

    echo"<tr>";
    echo "<td>0</td>";
    echo "<td align='right'>$".number_format($x, 0, '.', ',')."</td>";
    echo "<td align='right'>$0</td>";
    echo "<td align='right'>$".number_format($ci+$x, 0, '.', ',')."</td>";
    echo "<td align='right'>$0</td>";
    echo "<td align='right'>$".number_format($sal=$sal-($ci+$x), 0, '.', ',')."</td>";
    echo "</tr>";

    for($i=1;$i<$n1;$i++){

      $inc=$sal*$in;

      if($i<$pi){
        $abono=0;  
        $x=0;
      }else{
        $x=$xx;
        $abono=$x-$inc;

        if($_POST['clase']==1){
          $xx=$x+($grad*$signo);
        }else{
          $xx=$x+($x*(($grad*$signo)/100));
        }

      }


      if($i==($n1-1)){
        $x=$sal+$inc-$v_extra;
        $abono=$x-$inc;
      }

      if($n_extras==0){
        $v_extra=0; 
      }else{
        for($j=0; $j<$n_extras; $j++){
          if($matriz[$j][1]==$i){
            $v_extra=$matriz[$j][2];
            break;
          }else{
            $v_extra=0;
          }
        }
      }

      if($vp==0){
        $sal=$sal+$inc+$x+$v_extra;
        $abono=0;
      }else{
        $sal=$sal+$inc-$x-$v_extra;  
      }

      echo"<tr>";
      echo "<td>".$i."</td>";
      echo "<td align='right'>$".number_format($x, 0, '.', ',')."</td>";
      echo "<td align='right'>$".number_format($inc, 0, '.', ',')."</td>";
      echo "<td align='right'>$".number_format($abono, 0, '.', ',')."</td>";
      echo "<td align='right'>$".number_format($v_extra, 0, '.', ',')."</td>"; 
      echo "<td align='right'>$".number_format($sal, 0, '.', ',')."</td>";
      echo "</tr>";
      
      $s_x=$s_x+$x;
      $s_inc=$s_inc+$inc;
      $v_extra=0;
    }

  }

  echo"<tr>";
  echo "<td><strong>∑</strong></td>";
  echo "<td align='right'><strong>$".number_format($s_x, 0, '.', ',')."</strong></td>";
  echo "<td align='right'><strong>$".number_format($s_inc, 0, '.', ',')."</strong></td>";
  echo "<td align='right'>&nbsp;</td>";
  echo "<td align='right'>&nbsp;</td>";
  echo "<td align='right'>&nbsp;</td>";
  echo "</tr>";

?>
            </tbody>
          </table>
        </div>
      </div>
            <div class="form-group" align="center"> 
              <button type="button" class="btn btn-warning" onclick="javascript:location.href='principal.php'">Aceptar</button>
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