<?php

namespace App\Models;

require_once ("AbstractDBConnection.php");
require_once (__DIR__."\..\Interfaces\Model.php");
require_once (__DIR__.'/../../vendor/autoload.php');

use App\Interfaces\Model;


class Productos extends AbstractDBConnection implements Model
{
    private ?int $id;
    private string $Nombre;
    private int $Tamano;
    private string $Clasificacion;
    private string $Referencia;
    private int $PrecioProduccion;
    private int $PrecioVenta;
    private string $Presentacion;
    private int $Cantidad;
    private ?string $Descripcion;
    private string $Estado;
    private int $Proveedor_id;

    /**
     * Productos constructor.
     * @param int|null $id
     * @param string $Nombre
     * @param int $Tamano
     * @param string $Clasificacion
     * @param string $Referencia
     * @param int $PrecioProduccion
     * @param int $PrecioVenta
     * @param string $Presentacion
     * @param int $Cantidad
     * @param string|null $Descripcion
     * @param string $Estado
     * @param int $Proveedor_id
     */
    public function __construct(array $Producto = [])
    {
        parent::__construct();
        $this->setId($Producto['id']?? null);
        $this->setNombre($Producto['Nombre']?? '');
        $this->setTamano($Producto['Tamano']?? 0);
        $this->setClasificacion($Producto['Clasificacion']?? '');
        $this->setReferencia($Producto['Referencia']?? '');
        $this->setPrecioProduccion($Producto['PrecioProduccion']?? 0);
        $this->setPrecioVenta($Producto['PrecioVenta']?? 0);
        $this->setPresentacion($Producto['Presentacion']?? '');
        $this->setCantidad($Producto['Cantidad']?? 0);
        $this->setDescripcion($Producto['Descripcion']?? 'Sin descripción');
        $this->setEstado($Producto['Estado']?? '');
        $this->setProveedorId($Producto['Proveedor_id']?? 0);
    }

    public static function productoRegistrado(mixed $Referencia, int $idExcluir = null): bool
    {
        $query =  "SELECT * FROM producto WHERE Referencia = '$Referencia' ".(empty($idExcluir) ? '' : "AND id != $idExcluir");
        $prdTmp= Productos::search($query);
        return (!empty($prdTmp)? true : false);
    }

    public static function productoDescontado(int $CantProd, Productos $Prod): ?bool
    {
        $CantidadDisponible = $Prod->getCantidad();
        $resul = $CantidadDisponible - $CantProd;
        $Prod->setCantidad($resul);
        if($Prod->update())
        {
            return true;
        }else{
            return false;
        }

    }

    public function __destruct()
    {
        if ($this->isConnected()){
            $this->Disconnect();
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
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->Nombre;
    }

    /**
     * @param string $Nombre
     */
    public function setNombre(string $Nombre): void
    {
        $this->Nombre = $Nombre;
    }

    /**
     * @return int
     */
    public function getTamano(): int
    {
        return $this->Tamano;
    }

    /**
     * @param int $Tamano
     */
    public function setTamano(int $Tamano): void
    {
        $this->Tamano = $Tamano;
    }

    /**
     * @return string
     */
    public function getClasificacion(): string
    {
        return $this->Clasificacion;
    }

    /**
     * @param string $Clasificacion
     */
    public function setClasificacion(string $Clasificacion): void
    {
        $this->Clasificacion = $Clasificacion;
    }

    /**
     * @return string
     */
    public function getReferencia(): string
    {
        return $this->Referencia;
    }

    /**
     * @param string $Referencia
     */
    public function setReferencia(string $Referencia): void
    {
        $this->Referencia = $Referencia;
    }

    /**
     * @return int
     */
    public function getPrecioProduccion(): int
    {
        return $this->PrecioProduccion;
    }

    /**
     * @param int $PrecioProduccion
     */
    public function setPrecioProduccion(int $PrecioProduccion): void
    {
        $this->PrecioProduccion = $PrecioProduccion;
    }

    /**
     * @return int
     */
    public function getPrecioVenta(): int
    {
        return $this->PrecioVenta;
    }

    /**
     * @param int $PrecioVenta
     */
    public function setPrecioVenta(int $PrecioVenta): void
    {
        $this->PrecioVenta = $PrecioVenta;
    }

    /**
     * @return string
     */
    public function getPresentacion(): string
    {
        return $this->Presentacion;
    }

    /**
     * @param string $Presentacion
     */
    public function setPresentacion(string $Presentacion): void
    {
        $this->Presentacion = $Presentacion;
    }

    /**
     * @return int
     */
    public function getCantidad(): int
    {
        return $this->Cantidad;
    }

    /**
     * @param int $Cantidad
     */
    public function setCantidad(int $Cantidad): void
    {
        $this->Cantidad = $Cantidad;
    }

    /**
     * @return string|null
     */
    public function getDescripcion(): ?string
    {
        return $this->Descripcion;
    }

    /**
     * @param string|null $Descripcion
     */
    public function setDescripcion(?string $Descripcion): void
    {
        $this->Descripcion = $Descripcion;
    }

    /**
     * @return string
     */
    public function getEstado(): string
    {
        return $this->Estado;
    }

    /**
     * @param string $Estado
     */
    public function setEstado(string $Estado): void
    {
        $this->Estado = $Estado;
    }

    /**
     * @return int
     */
    public function getProveedorId(): int
    {
        return $this->Proveedor_id;
    }

    /**
     * @param int $Proveedor_id
     */
    public function setProveedorId(int $Proveedor_id): void
    {
        $this->Proveedor_id = $Proveedor_id;
    }
    public function getProveedor():?Usuarios
    {
        if (!empty($this->Proveedor_id)){
            return Usuarios::searchForId($this->Proveedor_id)?? new Usuarios();
        }
        return null;
    }

    protected function save(string $query): ?bool
    {
        $arrData = [
            ':id' => $this->getId(),
            ':Nombre' => $this->getNombre(),
            ':Tamano' => $this->getTamano(),
            ':Clasificacion' => $this->getClasificacion(),
            ':Referencia' => $this->getReferencia(),
            ':PrecioProduccion' => $this->getPrecioProduccion(),
            ':PrecioVenta' => $this->getPrecioVenta(),
            ':Presentacion' => $this->getPresentacion(),
            ':Cantidad' => $this->getCantidad(),
            ':Descripcion' => $this->getDescripcion(),
            ':Estado' => $this->getEstado(),
            ':Proveedor_id' => $this->getProveedorId()
        ];
        $this->Connect();
        $result = $this->insertRow($query, $arrData);
        $this->Disconnect();
        return $result;
    }

    public function insert(): ?bool
    {
        $query = "INSERT INTO producto VALUES (
            :id, :Nombre, :Tamano, :Clasificacion, :Referencia, :PrecioProduccion, :PrecioVenta, 
             :Presentacion, :Cantidad, :Descripcion, :Estado, :Proveedor_id)";

        if ($this->save($query)){
            $idProducto = $this->getLastId('producto');
            $this->setId($idProducto);
            return true;
        }else{
            return false;
        }
    }

    public function update(): ?bool
    {
        $query = "UPDATE producto SET
            Nombre = :Nombre, Tamano = :Tamano, Clasificacion = :Clasificacion, Referencia = :Referencia, 
            PrecioProduccion = :PrecioProduccion, PrecioVenta = :PrecioVenta, Presentacion = :Presentacion,
            Cantidad = :Cantidad, Descripcion = :Descripcion, Estado = :Estado, Proveedor_id = :Proveedor_id
            WHERE id = :id";
        return $this->save($query);
    }

    public function deleted(): ?bool
    {
        $this->setEstado("Inactivo");
        return $this->update();
    }

    public static function search($query): ?array
    {
        try {
            $arrProductos = array();
            $tmp = new Productos();

            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            if (!empty($getrows)) {
                foreach ($getrows as $valor) {
                    $Producto = new Productos($valor);
                    array_push($arrProductos, $Producto);
                    unset($Producto);
                }
                return $arrProductos;
            }
            return null;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e);
        }
        return null;
    }

    public static function searchForId(int $id): ?Productos
    {
        try {
            if ($id > 0) {
                $tmpProducto = new Productos();
                $tmpProducto->Connect();
                $getrow = $tmpProducto->getRow("SELECT * FROM producto WHERE id = ?", array($id) );

                $tmpProducto->Disconnect();
                return ($getrow) ? new Productos($getrow) : null;
            } else {
                throw new \Exception('Id de producto Invalido');
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e);
        }
        return null;
    }

    static public function getAll(): ?array
    {
        return Productos::search("SELECT * FROM producto");
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'Nombre' => $this->getNombre(),
            'Tamano' => $this->getTamano(),
            'Clasificacion' => $this->getClasificacion(),
            'Referencia' => $this->getReferencia(),
            'PrecioProduccion' => $this->getPrecioProduccion(),
            'PrecioVenta' => $this->getPrecioVenta(),
            'Presentacion' => $this->getPresentacion(),
            'Cantidad' => $this->getCantidad(),
            'Descripcion' => $this->getDescripcion(),
            'Estado' => $this->getEstado(),
            'Proveedor_id' => $this->getProveedorId()
        ];
    }
}