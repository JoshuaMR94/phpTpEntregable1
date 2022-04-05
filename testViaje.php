<?php

//Algoritmo principal para probar la clase viaje

//Se construira el objeto llamado viaje (Array de objetos tipo viaje)

include "viaje.php";
//Se toma como un arreglo ya que pueden existir varios viajes
function cargarViaje(){
  	echo "cuantas viajes se van a realizar?: ";
    $cantViajes=trim(fgets(STDIN));
  	for($i=0; $i < $cantViajes; $i++){
      echo "Ingrese el codigo del viaje: ";
      $codigo = trim(fgets(STDIN));
      echo "Ingrese el destino del viaje: ";
      $destino = trim(fgets(STDIN));
      echo "Cuanto es la cantidad maxima de pasajeros para este viaje?: ";
      $maxPasajeros = trim(fgets(STDIN));
      $pasajeros = cargarPasajero($maxPasajeros);
      $viaje[$i] = new viaje($codigo, $destino,$pasajeros,$maxPasajeros);
    }
    return $viaje;
}
//Se cargan los pasajeros del viaje en cuestion
function cargarPasajero($maxPasajeros){
    echo "Cuantos pasajeros habra en el viaje?: ";
    $cantPasajeros=trim(fgets(STDIN));   
        if($maxPasajeros > 0 && $cantPasajeros <= $maxPasajeros){
            $pasajero = [];
            for ($i=0; $i < $cantPasajeros; $i++){
                echo "Ingrese el nombre del pasajero : ";
                $nombre = trim(fgets(STDIN));
                echo "Ingrese el apellido del pasajero : ";
                $apellido = trim(fgets(STDIN));
                echo "Dni del pasajero: ";
                $dni = trim(fgets(STDIN));
                $pasajero[$i] = ['nombre' => $nombre,
                                'apellido' => $apellido,
                                'dni' => $dni ];   
            }
            return $pasajero;
        }else{
        echo "Error, la cantidad de pasajeros no puede ser mayor a la cantidad maxima permitida";
        }
    
}
//Modulo hecho para poder modificar los datos del viaje
function modificarViaje($viaje){ // FUNCION QUE MODIFICA EL VIAJE
  echo "Ingrese el codigo del viaje que desea modificar: ";
  $codigoMod = trim(fgets(STDIN));
  $esCodigo=true;
  $i=0;
  while($esCodigo && $i < count($viaje)){
    if($viaje[$i]->getCodigo()==$codigoMod){
      echo "quiere modificar el destino del viaje (S/N): ";
      $opcion=trim(fgets(STDIN));
      if($opcion== "S"||$opcion == "s"){
        echo"cual es el nuevo destino?: ";
        $nuevoDest=trim(fgets(STDIN));
        $viaje[$i]->setDestino($nuevoDest);
      }
      echo "quiere modificar la cantidad maxima de pasajeros (S/N): ";
      $opcion=trim(fgets(STDIN));
      if($opcion== "S"||$opcion == "s"){
        echo"cual es la nueva cantidad maxima de pasajeros?: ";
        $nuevoMaxPasajeros=trim(fgets(STDIN));
        $viaje[$i]->setCanMax($nuevoMaxPasajeros);
      }
      $esCodigo=false;  
    }else{
      $i++;  
    }
  }  
}
/*Modulo para poder modificar los pasajeros de cierto viaje. Se busca el numero de viaje
ya que todos los pasajeros de cierto viaje tendran el codigo de ese viaje, de localizar el viaje
con ese codigo, se buscara entre los pasaejeros el dni, con esos datos se podran editar los datos del pasajero*/
function modificarDatosPasajeros($viaje){
  
  echo "Ingrese el codigo del viaje del pasajero: ";
  $codigoMod = trim(fgets(STDIN));
  $esCodigo=true;
  $i=0;
  while ($esCodigo && $i < count($viaje)) {
    if ($viaje[$i]->getCodigo()==$codigoMod) {
      echo "Ingrese documento del pasajero: ";
      $documento = trim(fgets(STDIN));
      $oldDNI = $viaje[$i]->getPasajeros()[$i][$i]["dni"];
      if ($documento == $oldDNI){

        echo "Ingrese el nuevo nombre del pasajero: ";
        $nombre = trim(fgets(STDIN));
        echo "Ingrese el nuevo apellido del pasajero: ";
        $apellido = trim(fgets(STDIN));
        echo "Ingrese nuevo Dni del pasajero: ";
        $dni = trim(fgets(STDIN));
        $pasajero = ['nombre' => $nombre,
                        'apellido' => $apellido,
                        'dni' => $dni ]; 
        $viaje[$i]->setPasajeros($pasajero);
      }else {
        echo "No se ah encontrado ningun pasajero con esa numeracion.. \n";
      }
    }
    $i++;
  }
}
//Modulo para poder ver los datos del viaje y sus pasajeros
function verDatosViaje($viaje){

  echo "Ingrese codijo del viaje: ";
  $code = trim(fgets(STDIN));
  $esCodigo=true;
  $i = 0;
  while ($esCodigo && $i < count($viaje)) {
    if ($viaje[$i]->getCodigo()==$code) {
      echo $viaje[$i]->__toString();
      echo "\nDesea ver los datos de cada usuario?(s/n): ";
      $usuario = trim(fgets(STDIN));
      if ($usuario == "s") {
        echo "Los datos de los pasajeros son los siguientes: \n";
        print_r($viaje[$i]->getPasajeros());
      }
      $esCodigo=false;
    }else {
      $i++;
    }
  }
}
//Menu
function menu(){
    /** @var int $opcion 
     *@var boolean $esValido */
    $esValido = false;

    echo "--------------------------------------------------------------";
    echo "\n ( 1 ) Cargar los datos del viaje";
    echo "\n ( 2 ) Modificar datos del viaje";
    echo "\n ( 3 ) Modificar datos de los pasajeros";
    echo "\n ( 4 ) Ver los datos del viaje";
    echo "\n ( 5 ) Salir del programa";
    echo "\n--------------------------------------------------------------\n";
    echo "\n"." Ingrese una opcion: " . "\n";

    do {
        $opcion = trim(fgets(STDIN));

        if ($opcion >= 1 && $opcion <= 5) {
            $esValido = true;
        } else {
            echo "Ingrese una opcion valida." . "\n";
        }
    } while (!$esValido);

    return $opcion;
}
#######################################################################################  
 
//Switch creado para elejir entre las opciones del menu
do {
    $opcion = menu();
   
    switch ($opcion) { 
        case 1: 
        
        $viajeCargado = cargarViaje();
        break;
 		    
        case 2:

            modificarViaje($viajeCargado);
            break;
        case 3:
          modificarDatosPasajeros($viajeCargado);
            break;
       
        case 4:
          
          verDatosViaje($viajeCargado);
          break;

        case 5:
          echo "Programa finalizado";
          break;
        }
} while ($opcion !=5);
