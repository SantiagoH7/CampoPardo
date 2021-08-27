<?php


namespace App\Models;

require_once ("AbstractDBConnection.php");//Importamos la clase padre
require_once (__DIR__."\..\Interfaces\Model.php");//Importamos la interfaz Model por ahora
require_once (__DIR__ .'/../../vendor/autoload.php');//Importamos todas las clases de vendor por ahora

use App\Interfaces\Model;
use App\Models\AbstractDBConnection;
use phpDocumentor\Reflection\Types\Array_;
use PhpParser\Node\Expr\Cast\Int_;

class Usuarios extends AbstractDBConnection implements Model
{
    private ?int $id;
    private string $Nombres;
    private string $Apellidos;
    private string $TipoDocumento;
    private int $NumeroDocumento;
    private int $Telefono;
    private ?string $Email;
    private ?string $Contrasena;
    private string $Direccion;
    private string $Rol;
    private string $Estado;
    private int $Municipio_id;

    /* Seguridad de contraseña*/
    const HASH = PASSWORD_DEFAULT;
    const COST = 10;

    /**
     * Usuarios constructor.
     * @param int|null $id
     * @param string $Nombres
     * @param string $Apellidos
     * @param string $TipoDocumento
     * @param int $NumeroDocumento
     * @param int $Telefono
     * @param string|null $Email
     * @param string|null $Contrasena
     * @param string $Direccion
     * @param string $Rol
     * @param string $Estado
     * @param int $Municipio_id
     */
    public function __construct(array $Usuario =[])
    {
        parent::__construct();
        $this->setId($Usuario['id'] ?? 0);
        $this->setNombres($Usuario['Nombres'] ?? '');
        $this->setApellidos($Usuario['Apellidos'] ?? '');
        $this->setTipoDocumento($Usuario['TipoDocumento'] ?? '');
        $this->setNumeroDocumento($Usuario['NumeroDocumento'] ?? 0);
        $this->setTelefono($Usuario['Telefono'] ?? 0);
        $this->setEmail($Usuario['Email'] ?? '');
        $this->setContrasena($Usuario['Contrasena'] ?? '');
        $this->setDireccion($Usuario['Direccion'] ?? '');
        $this->setRol($Usuario['Rol'] ?? '');
        $this->setEstado($Usuario['Estado'] ?? '');
        $this->setMunicipioId($Usuario['Municipio_id'] ?? 0);
    }


    public static function usuarioRegistrado(mixed $NumeroDocumento,mixed $Email,mixed $Telefono,int $idExcluir = null): bool
    {
        $query = "SELECT * FROM usuario WHERE NumeroDocumento = '$NumeroDocumento' or Email = '$Email' or Telefono = '$Telefono'";
        $arrUsr = Usuarios::search($query);
        if (!empty($arrUsr) && is_array($arrUsr)){
            if(count($arrUsr) > 1){
                return true;
            }elseif($arrUsr[0]->getId() != $idExcluir){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function __destruct()
    {
        //isConnected y Disconnect son metodos de la clase AbstractDBConnection
        if ($this->isConnected()) {//pregunta si la base de datos esta conectada
            $this->Disconnect();//destruye la coneccion
        }
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNombres(): string
    {
        return $this->Nombres;
    }

    /**
     * @return string
     */
    public function getApellidos(): string
    {
        return $this->Apellidos;
    }

    /**
     * @return string
     */
    public function getTipoDocumento(): string
    {
        return $this->TipoDocumento;
    }

    /**
     * @return int
     */
    public function getNumeroDocumento(): int
    {
        return $this->NumeroDocumento;
    }

    /**
     * @return int
     */
    public function getTelefono(): int
    {
        return $this->Telefono;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->Email;
    }

    /**
     * @return string|null
     */
    public function getContrasena(): ?string
    {
        return $this->Contrasena;
    }

    /**
     * @return string
     */
    public function getDireccion(): string
    {
        return $this->Direccion;
    }

    /**
     * @return string
     */
    public function getRol(): string
    {
        return $this->Rol;
    }

    /**
     * @return string
     */
    public function getEstado(): string
    {
        return $this->Estado;
    }

    /**
     * @return int
     */
    public function getMunicipioId(): int
    {
        return $this->Municipio_id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $Nombres
     */
    public function setNombres(string $Nombres): void
    {
        $this->Nombres = $Nombres;
    }

    /**
     * @param string $Apellidos
     */
    public function setApellidos(string $Apellidos): void
    {
        $this->Apellidos = $Apellidos;
    }

    /**
     * @param string $TipoDocumento
     */
    public function setTipoDocumento(string $TipoDocumento): void
    {
        $this->TipoDocumento = $TipoDocumento;
    }

    /**
     * @param int $NumeroDocumento
     */
    public function setNumeroDocumento(int $NumeroDocumento): void
    {
        $this->NumeroDocumento = $NumeroDocumento;
    }

    /**
     * @param int $Telefono
     */
    public function setTelefono(int $Telefono): void
    {
        $this->Telefono = $Telefono;
    }

    /**
     * @param string|null $Email
     */
    public function setEmail(?string $Email): void
    {
        $this->Email = $Email;
    }

    /**
     * @param string|null $Contrasena
     */
    public function setContrasena(?string $Contrasena): void
    {
        $this->Contrasena = $Contrasena;
    }

    /**
     * @param string $Direccion
     */
    public function setDireccion(string $Direccion): void
    {
        $this->Direccion = $Direccion;
    }

    /**
     * @param string $Rol
     */
    public function setRol(string $Rol): void
    {
        $this->Rol = $Rol;
    }

    /**
     * @param string $Estado
     */
    public function setEstado(string $Estado): void
    {
        $this->Estado = $Estado;
    }

    /**
     * @param int $Municipio_id
     */
    public function setMunicipioId(int $Municipio_id): void
    {
        $this->Municipio_id = $Municipio_id;
    }
    public function getMunicipio(): ?Municipios
    {
        if (!empty($this->Municipio_id)) {
            return Municipios::searchForId($this->Municipio_id) ?? new Municipios();
        }
        return null;
    }
    protected function save(string $query): ?bool
    {
        $hashPassword = password_hash($this->Contrasena, self::HASH, ['cost' =>self::COST]);//Encripta la contraseña del ususario

        $arrData = [
            ':id' => $this->getId(),
            ':Nombres' => $this->getNombres(),
            ':Apellidos' => $this->getApellidos(),
            ':TipoDocumento' => $this->getTipoDocumento(),
            ':NumeroDocumento' => $this->getNumeroDocumento(),
            ':Telefono' => $this->getTelefono(),
            ':Email' => $this->getEmail(),
            ':Contrasena' => $hashPassword,//Asigna la contraseña encriptada
            ':Direccion' => $this->getDireccion(),
            ':Rol' => $this->getRol(),
            ':Estado' => $this->getEstado(),
            ':Municipio_id' => $this->getMunicipioId(),
        ];

        $this->Connect();
        $result = $this->insertRow($query, $arrData);//insertRow es el que inserta los datos que organiza el save
        $this->Disconnect();
        return $result;
    }

    public function insert(): ?bool
    {
        $query = "INSERT INTO usuario VALUES (
            :id,:Nombres,:Apellidos,:TipoDocumento,:NumeroDocumento,:Telefono,:Email,:Contrasena,:Direccion,:Rol,:Estado,:Municipio_id)";
        if ($this->save($query)) {
            $idUsuario = $this->getLastId('usuario');
            $this->setId($idUsuario);
            return true;
        } else {
            return false;
        }
    }

    public function update(): ?bool
    {
        $query = "UPDATE usuario SET 
            Nombres = :Nombres, Apellidos = :Apellidos, TipoDocumento = :TipoDocumento, NumeroDocumento =:NumeroDocumento, Telefono = :Telefono,Email = :Email,Contrasena = :Contrasena, Direccion = :Direccion,  
             Rol = :Rol, Estado = :Estado, Municipio_id = :Municipio_id WHERE id = :id";
        return $this->save($query);

    }

    public function deleted(): ?bool
    {
        $this->setEstado('Inactivo');
        return $this->update();
    }


    public static function search($query): ?array
    {
        try {
            $arrUsuario = array();
            $tmp = new Usuarios();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            if (!empty($getrows)) {
                foreach ($getrows as $valor) {
                    $Usuario = new Usuarios($valor);
                    array_push($arrUsuario, $Usuario);//aca meter el contenido del segundo parametro dentro del primero
                    unset($Usuario); //Borrar el contenido del objeto
                }
                return $arrUsuario;
            }
            return null;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e);
        }
        return null;
    }

    public static function searchForId(int $id): ?Usuarios
    {
        try {
            if ($id > 0) {
                $tmpUsuario = new Usuarios();
                $tmpUsuario->Connect();
                $getrow = $tmpUsuario->getRow("SELECT * FROM usuario WHERE id = ?", array($id));

                $tmpUsuario->Disconnect();
                return ($getrow) ? new Usuarios($getrow) : null;
            } else {
                throw new \Exception('Id de usuario Invalido');
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e);
        }
        return null;
    }

    public static function getAll(): ?array
    {
        return Usuarios::search("SELECT * FROM usuario");
    }

    public function login($Email, $Constrasena): Usuarios|String|null//si no retorna un objeto usuario retornara un string
    {
        try {
            $resultUsuarios = Usuarios::search("SELECT * FROM usuario WHERE Email = '$Email'");
            /* @var $resultUsuarios Usuarios[] */
            if (!empty($resultUsuarios) && count($resultUsuarios) >= 1) {
                if (password_verify($Constrasena, $resultUsuarios[0]->getContrasena())) {
                    if ($resultUsuarios[0]->getEstado() == 'Activo') {
                        return $resultUsuarios[0];
                    } else {
                        return "Usuario Inactivo";
                    }
                } else {
                    return "Contraseña Incorrecta";
                }
            } else {
                return "Usuario Incorrecto";
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e);
            return "Error en Servidor";
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'Nombres' => $this->getNombres(),
            'Apellidos' => $this->getApellidos(),
            'TipoDocumento' => $this->getTipoDocumento(),
            'NumeroDocumento' => $this->getNumeroDocumento(),
            'Telefono' => $this->getTelefono(),
            'Email' => $this->getEmail(),
            'Contrasena' => $this->getContrasena(),//Asigna la contraseña encriptada
            'Direccion' => $this->getDireccion(),
            'Rol' => $this->getRol(),
            'Estado' => $this->getEstado(),
            'Municipio_id' => $this->getMunicipioId(),
        ];
    }

}