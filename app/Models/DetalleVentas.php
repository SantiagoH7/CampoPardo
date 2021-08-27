<?php


namespace App\Models;

require_once ("AbstractDBConnection.php");
require_once (__DIR__.'\..\interfaces\Model.php');
require_once (__DIR__ .'/../../vendor/autoload.php');

use App\Interfaces\Model;

class DetalleVentas extends AbstractDBConnection implements Model
{
    private ?int $id;
    private int $Producto_id;
    private int $Venta_id;
    private int $CantidadProducto;

    /**
     * DetalleVentas constructor.
     * @param int|null $id
     * @param int $Producto_id
     * @param int $Venta_id
     * @param int $CantidadProducto
     */
    public function __construct( array $DetalleVenta = [])
    {
        parent::__construct();
        $this->setId($DetalleVenta['id']?? 0);
        $this->setProductoId($DetalleVenta['Producto_id']?? 0);
        $this->setVentaId($DetalleVenta['Venta_id']?? 0);
        $this->setCantidadProducto($DetalleVenta['CantidadProducto']?? 0);
    }

    public static function detalleVentaRegistrada(mixed $Producto_id, mixed $Venta_id, int $idEscluir = null): bool
    {
        $query = "SELECT * FROM DetalleVenta WHERE Producto_id = '$Producto_id' and Venta_id = '$Venta_id' ".
                  (empty($idEscluir) ? '' : "AND id != $idEscluir");
        $dtvTmp = DetalleVentas::search($query);
        return (!empty($dtvTmp)? true : false);
    }

    public static function CantidadDisponible(int $CantProd, int $idProd): ?bool
    {
        $Prod = Productos::searchForId($idProd);
        if (!empty($Prod)){
            $CantidadDisponible = $Prod->getCantidad();
            if ($CantProd > $CantidadDisponible){
                return false;
            }else{
                return Productos::productoDescontado($CantProd, $Prod);
            }
        }else {
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
     * @return int
     */
    public function getProductoId(): int
    {
        return $this->Producto_id;
    }

    /**
     * @param int $Producto_id
     */
    public function setProductoId(int $Producto_id): void
    {
        $this->Producto_id = $Producto_id;
    }

    /**
     * @return int
     */
    public function getVentaId(): int
    {
        return $this->Venta_id;
    }

    /**
     * @param int $Venta_id
     */
    public function setVentaId(int $Venta_id): void
    {
        $this->Venta_id = $Venta_id;
    }

    /**
     * @return int
     */
    public function getCantidadProducto(): int
    {
        return $this->CantidadProducto;
    }

    /**
     * @param int $CantidadProducto
     */
    public function setCantidadProducto(int $CantidadProducto): void
    {
        $this->CantidadProducto = $CantidadProducto;
    }

    public function getVenta():?Ventas
    {
        if (!empty($this->Venta_id))
        {
            return Ventas::searchForId($this->Venta_id)?? new Ventas();
        }
        return null;
    }

    public function getProducto(): ?Productos
    {
        if (!empty($this->Producto_id))
        {
            return Productos::searchForId($this->Producto_id)?? new Productos();
        }
        return null;
    }

    protected function save(string $query): ?bool
    {
        $arrayData = [
            ':id' => $this->getId(),
            ':Producto_id' => $this->getProductoId(),
            ':Venta_id' => $this->getVentaId(),
            ':CantidadProducto' => $this->getCantidadProducto()
        ];

        $this->Connect();
        $result = $this->insertRow($query, $arrayData);
        $this->Disconnect();
        return $result;
    }

    public function insert(): ?bool
    {
        $query = "INSERT INTO DetalleVenta VALUES (
            :id,:Producto_id,:Venta_id,:CantidadProducto)";
        if ($this->save($query)) {
            $idDetalleVenta = $this->getLastId('DetalleVenta');
            $this->setId($idDetalleVenta);
            return true;
        } else {
            return false;
        }
    }

    public function update(): ?bool
    {
        $query = "UPDATE DetalleVenta SET 
           Producto_id = :Producto_id, Venta_id = :Venta_id,
           CantidadProducto = :CantidadProducto WHERE id = :id";
        return $this->save($query);
    }

    public function deleted(): ?bool
    {

    }

    static function search($query): ?array
    {
        try {
            $arrDetalleVentas = array();
            $tmp = new DetalleVentas();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);

            $tmp->Disconnect();

            if (!empty($getrows)) {
                foreach ($getrows as $valor) {
                    $DetalleVentas = new DetalleVentas($valor);
                    array_push($arrDetalleVentas, $DetalleVentas);//aca meter el contenido del segundo parametro dentro del primero
                    unset($DetalleVentas); //Borrar el contenido del objeto
                }
                return $arrDetalleVentas;
            }
            return null;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e);
        }
        return null;
    }

    static function searchForId(int $id): ?DetalleVentas
    {
        try {
            if ($id > 0) {
                $tmpDetalleVenta = new DetalleVentas();
                $tmpDetalleVenta->Connect();
                $getrow = $tmpDetalleVenta->getRow("SELECT * FROM DetalleVenta WHERE id = ?", array($id) );

                $tmpDetalleVenta->Disconnect();
                return ($getrow) ? new DetalleVentas($getrow) : null;
            } else {
                throw new \Exception('Id de detalle venta Invalido');
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e);
        }
        return null;
    }

    static function getAll(): ?array
    {
        return DetalleVentas::search("SELECT * FROM DetalleVenta");
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'Producto_id' => $this->getProductoId(),
            'Venta_id' => $this->getVentaId(),
            'CantidadProducto' => $this->getCantidadProducto()
        ];
    }
}