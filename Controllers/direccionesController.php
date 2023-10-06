<?php namespace Controllers;

use Models\Direcciones;
use Models\Departamentos;
use Models\Dispositivos;
use Models\Direcciones_ip;
use Models\setRango;
use Models\Equipos;
use Repository\Procesos1 as Repository1;

    class direccionesController{

        private $direccion;
        private $departamento;
        private $dispositivo;
        private $direccion_ip;
        private $setRangoIp;
        private $equipo;

        public function __construct()
        {
            $this->direccion = new Direcciones();
            $this->departamento = new Departamentos();
            $this->dispositivo = new Dispositivos();
            $this->direccion_ip = new Direcciones_ip();
            $this->setRangoIp = new setRango();
            $this->equipo = new Equipos();
            if (!isset($_SESSION['usuario'])) {
                // El usuario no está autenticado, redirige al formulario de inicio de sesión.
                echo '<script>
                Swal.fire({
                    title: "Error",
                    text: "Tienes que inicar sesion primero!",
                    icon: "warning",
                    showConfirmButton: true,
                    confirmButtonColor: "#3464eb",
                    confirmButtonText: "Iniciar Sesion",
                    customClass: {
                        confirmButton: "rounded-button" // Identificador personalizado
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "' . URL . 'login/index";
                    }
                });
                </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
            }
            if($_SESSION['rol'] != 1){

                // El usuario no es administrador, redirige al inicio
                echo '<script>
                Swal.fire({
                    title: "Error",
                    text: "No tienes autoridad de administrador para hacer esto",
                    icon: "warning",
                    showConfirmButton: true,
                    confirmButtonColor: "#3464eb",
                    confirmButtonText: "Aceptar",
                    customClass: {
                        confirmButton: "rounded-button" // Identificador personalizado
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "' . URL . 'inicio/index";
                    }
                });
                </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

            }
        }

        public function index(){
            $datos['titulo'] = "Direcciones";
            $datos['direcciones'] = $this->direccion->listar();
            return $datos;
        }

        public function getDireccionesLibresporRango(){

                $datos['titulo'] = "Direcciones IP";
                $datos['rango'] = $this->setRangoIp->getRango();
                $datos['direcciones'] = $this->direccion_ip->getDireccionesporRango();
                $datos['dispositivos'] = $this->dispositivo->lista();

                return $datos;
            
        }

        public function rango(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $departamento = $_POST['departamento'];
    
                $this->setRangoIp->set('id_departamento',$departamento);

                //VERIFICANDO SI HAY UN RANGO NO ELIMINADO CORRECTAMENTE
                $cuenta = $this->setRangoIp->validarRango();

                //SI YA EXISTE, ELIMINAR Y LUEGO INSERTAR
                if($cuenta['cuenta'] > 0){

                    $this->setRangoIp->liberarRangoForIp();
                    $this->setRangoIp->setRangoForIp();

                }
                //CASO CONTRARIO, SOLO INSERTAR
                else {

                    $this->setRangoIp->setRangoForIp();

                }
    
                echo '<script>
                                Swal.fire({
                                    title: "Redireccionando...",
                                    text: "Rango de direcciones obtenido!",
                                    icon: "success",
                                    showConfirmButton: true,
                                    confirmButtonColor: "#3464eb",
                                    customClass: {
                                        confirmButton: "rounded-button" // Identificador personalizado
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "' . URL . 'direcciones/new";
                                    }
                                });
                            </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
                }

            $datos['titulo'] = "Seleccione el departamento";
            $datos['departamentos'] = $this->departamento->lista();
            return $datos;
        }

        public function new(){            
           
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $dispositivo = $_POST['dispositivo'];
                $direccion = $_POST['direccion'];
                $numero_bien = $_POST['numero_bien'];

                //SI EL DISPOSITIVO ES UNA COMPUTADORA
                if($dispositivo == 2){
                    
                    //VERIFICANDO SI EL EQUIPO ESTA REGISTRADO
                    $this->equipo->set('numero_bien', $numero_bien);
                    $cuenta = $this->equipo->verificarEquipoBien();

                    //SI LA CUENTA ES MAYOR A 0 ENTONCES ESTA REGISTRADO
                    if($cuenta['cuenta'] > 0){

                        //OBTENIENDO EL ID DEL EQUIPO PARA INSERTARLO
                        $id_equipo = $this->equipo->getEquipobyNumerodeBien();
                        //UNA VEZ OBTENIDO LO SETEAMOS
                        $this->direccion->set('equipo', $id_equipo['id_equipo']);
                        $this->direccion->set('tipo_dispositivo', $dispositivo);
                        $this->direccion->set('id_direccion', $direccion);
                        $this->direccion->set('numero_bien', $numero_bien);

                        //Agregando la nueva direccion a la base de datos
                        $this->direccion->add();

                        //OBTENIENDO LA ID DE ASIGNACION PARA INSERTARLA EN LA TABLA EQUIPOS
                        $this->direccion->set('numero_bien', $numero_bien);
                        $id_asignacion = $this->direccion->getAsignacionIDbyNumeroBien();

                        //INSERTANDO EL ID DE ASIGNACION AL EQUIPO CORRESPONDIENTE
                        $this->equipo->set('id_equipo', $id_equipo['id_equipo']);
                        $this->equipo->set('direccion_ip', $id_asignacion['id_asignacion']);
                        $this->equipo->AsignarDireccionEquipo();

                        //Cambiando estado de 0 libre a 1 ocupado
                        $this->changeEstado($direccion);

                        //Sumando el numero de direcciones asignadas al departamento
                        //El departamento no requiere pasar ninguna variable porque se usa el especificado en el rango
                        $this->actualizarDireccionesenDepartamento();

                        //Sumando el numero de direcciones asignadas al dispositivo
                        $this->actualizarDireccionesenDispositivos($dispositivo);

                        //Liberando el rango en la tabla setrango en la base de datos
                        $this->liberarRango();

                        //PROCESO TERMINADO, REDIRECCIONANDO
                        echo '<script>
                                    Swal.fire({
                                        title: "Redireccionando...",
                                        text: "Asignacion a equipo exitosa",
                                        icon: "success",
                                        showConfirmButton: true,
                                        confirmButtonColor: "#3464eb",
                                        customClass: {
                                            confirmButton: "rounded-button" // Identificador personalizado
                                        }
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "' . URL . 'direcciones/index";
                                        }
                                    });
                                </script>';
                        exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
                    } 
                    //SI LA CUENTA ES INFERIOR A 0 ENTONCES NO ESTA REGISTRADO
                    else {

                        //REDIRECCIONANDO CON UN MENSAJE DE ERROR
                        echo '<script>
                        Swal.fire({
                            title: "Equipo no registrado!",
                            text: "Este equipo no esta registrado, registrelo antes de ingresarlo.",
                            icon: "warning",
                            showConfirmButton: true,
                            confirmButtonColor: "#3464eb",
                            confirmButtonText: "Registrar",
                            customClass: {
                                confirmButton: "rounded-button" // Identificador personalizado
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "' . URL . 'equipos/newregistro";
                            }
                        });
                    </script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
                    }
                }

                $this->direccion->set('tipo_dispositivo', $dispositivo);
                $this->direccion->set('id_direccion', $direccion);
                $this->direccion->set('numero_bien', $numero_bien);

                //Agregando la nueva direccion a la base de datos
                $this->direccion->add();

                //Cambiando estado de 0 libre a 1 ocupado
                $this->changeEstado($direccion);

                //Sumando el numero de direcciones asignadas al departamento
                //El departamento no requiere pasar ninguna variable porque se usa el especificado en el rango
                $this->actualizarDireccionesenDepartamento();

                //Sumando el numero de direcciones asignadas al dispositivo
                $this->actualizarDireccionesenDispositivos($dispositivo);

                //Liberando el rango en la tabla setrango en la base de datos
                $this->liberarRango();

                echo '<script>
                            Swal.fire({
                                title: "Redireccionando...",
                                text: "Asignacion Exitosa!",
                                icon: "success",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'direcciones/index";
                                }
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

            }

        }

        //Liberando el rango en la tabla setrango en la base de datos
        private function liberarRango(){

            $this->setRangoIp->liberarRangoForIp();

        }

        //Sumando el numero de direcciones asignadas al departamento
        private function actualizarDireccionesenDepartamento(){

            $this->departamento->actualizarDireccionesAsignadas();
        }

        //Cambiando estado de 0 libre a 1 ocupado
        private function changeEstado($id){

            $this->direccion_ip->set('id_ip', $id);

            $this->direccion_ip->ocupar();
        }


        //Sumandole +1 al dispositivo asignadoS
        private function actualizarDireccionesenDispositivos($id_dispositivos){

            $this->dispositivo->set('id_dispositivos', $id_dispositivos);

            $this->dispositivo->actualizarDireccionesAsignadas();
        }

        public function delete($id){

            if($_SERVER['REQUEST_METHOD'] == 'GET'){

                //Fijando la asignacion
                $this->direccion->set('id_asignacion', $id);

                //Obteniendo la data necesaria antes de eliminar
                $data = $this->direccion->getDataForLiberation();

                //Eliminando de la DB
                $this->direccion->delete();

                //guardando la direccion
                $id_direccion = $data['id_direccion'];

                //guardando el dispositivo
                $id_dispositivo = $data['tipo_dispositivo'];

                //guardando el equipo
                $id_equipo = $data['equipo'];
                
                //funcion que cambia el estado de la ip, y reduce el total en el departamento y el dispositivo
                $this->liberar($id_direccion, $id_dispositivo, $id_equipo);

                echo '<script>
                            Swal.fire({
                                title: "Exito!",
                                text: "Eliminado Exitosamente.",
                                icon: "warning",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'operadores/index";
                                }
                            });
                        </script>';
                exit;

            }

        }

        //funcion que cambia el estado de la ip, y reduce el total en el departamento y el dispositivo
        public function liberar($id_direccion, $id_dispositivo, $id_equipo){

                //Fijando el dispositivo
                $this->dispositivo->set('id_dispositivos', $id_dispositivo);

                //Fijando la direccion ip
                $this->direccion_ip->set('id_ip', $id_direccion);

                //Fijando el id del equipo
                $this->equipo->set('id_equipo', $id_equipo);

                //Reduciendole uno en asignaciones totales
                $this->dispositivo->reducirDireccionesenAsignadas();

                //Cambiandole el estado de ocupado a libre y reduciendole 1 al departamento correspondiente
                $this->direccion_ip->release();

                //Eliminando la id de asignacion del equipo
                $this->equipo->liberarDireccionEquipo();

                echo '<script>
                            Swal.fire({
                                title: "Redireccionando...",
                                text: "Direccion Liberada Exitosamente.",
                                icon: "success",
                                showConfirmButton: true,
                                confirmButtonColor: "#3464eb",
                                customClass: {
                                    confirmButton: "rounded-button" // Identificador personalizado
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "' . URL . 'direcciones/index";
                                }
                            });
                        </script>';
                exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.

        }

        public function edit($id){

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $nombre = $_POST['nombre'];
                    $apellido = $_POST['apellido'];

                    $this->direccion->set('id_operador', $id);
                    $this->direccion->set('nombre', $nombre);
                    $this->direccion->set('apellido', $apellido);
    
                    $this->direccion->edit();
    
                    echo '<script>window.location.href = "' . URL . 'direcciones/index";</script>';
                    exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
    
                }            
            
        }
      
    }

    $direcciones = new direccionesController();
?>