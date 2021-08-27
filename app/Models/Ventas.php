<?php
namespace App\Models;

require_once ("AbstractDBConnection.php");
require_once (__DIR__."\..\Interfaces\Model.php");
require_once (__DIR__.'/../../vendor/autoload.php');

use Carbon\Carbon;
use App\Interfaces\Model;
use App\Models\AbstractDBConnection;
use Carbon\Traits\Creator;


class Ventas extends AbstractDBConnection implements Model
{
    private ?int $id;
    private  int $Numero;
    private  Carbon $FechaVenta;
    private  string $MedioPago;
    private  string $Estado;
    private  int $Cliente_id;

    /* Relaciones*/
    private ?array $DetalleVenta;

    /**
     * Ventas constructor.
     * @param int|null $id
     * @param int $Numero
     * @param Carbon $FechaVenta
     * @param string $MedioPago
     * @param string $Estado
     * @param int $Cliente_id
     */
    public function __construct($venta=[])
    {
        parent::__construct();
        $this->setId( $venta['id']?? null);
        $this->setNumero( $venta['Numero']?? 0);
        $this->setFechaVenta(!empty($venta['FechaVenta'])? Carbon::parse($venta['FechaVenta']): new Carbon());
        $this->setMedioPago( $venta['MedioPago']?? '');
        $this->setEstado( $venta['Estado']?? '');
        $this->setClienteId($venta['Cliente_id']?? 0);
    }

    public static function ventaRegistrada(mixed $Numero, int $idExcluir = null): bool
    {
        $query = "SELECT * FROM venta WHERE  Numero = '$Numero'".(empty($idExcluir) ? '' : "AND id != $idExcluir");
        $ftaTmp = Ventas::search($query);
        return (!empty($ftaTmp)? true :false);
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
    public function getNumero(): ?int
    {
        return $this->Numero ?? NULL;
    }

    /**
    * @param int $Numero
    */
    public function setNumero(int $Numero): void
    {
        if(empty($Numero) && empty($this->getNumero())){
            $this->Connect();
            $tmpfActura = ($this->getRow('select Numero from venta ORDER BY Numero desc limit 1')['Numero'] ?? 0);
            $this->Numero = ($tmpfActura+1) ?? $Numero;
            $this->Disconnect();
        }else{
            $this->Numero = $Numero;
        }
    }

    /**
     * @return Carbon
     */
    public function getFechaVenta(): Carbon
    {
        return $this->FechaVenta;
    }

    /**
     * @param Carbon $FechaVenta
     */
    public function setFechaVenta(Carbon $FechaVenta): void
    {
        $this->FechaVenta = $FechaVenta;
    }

    /**
     * @return string
     */
    public function getMedioPago(): string
    {
        return $this->MedioPago;
    }

    /**
     * @param string $MedioPago
     */
    public function setMedioPago(string $MedioPago): void
    {
        $this->MedioPago = $MedioPago;
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
    public function getClienteId(): int
    {
        return $this->Cliente_id;
    }

    /**
     * @param int $Cliente_id
     */
    public function setClienteId(int $Cliente_id): void
    {
        $this->Cliente_id = $Cliente_id;
    }
    public function getCliente(): ?Usuarios
    {
        if (!empty($this->Cliente_id)){
            return Usuarios::searchForId($this->Cliente_id)?? new Usuarios();
        }
        return null;
    }

    public function getDetalleVentasVenta(): ?array
    {
        if (!empty($this->getId())) {
            $this-> DetalleVentasVenta = DetalleVentas::search(
                "SELECT * FROM detalleventa WHERE Venta_id = ".$this->getId()
            );
            return ($this->DetalleVentasVenta)?? null;
        }
        return null;
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
        $arrdetalles = $this->getDetalleVentasVenta();
        $this->Total = 0;
        if(is_array($arrdetalles)){
            /* @var $arrdetalles DetalleVentas */
            foreach ($arrdetalles as $detalle){
                if($detalle->getProducto() != null){
                    $this->Total += ($detalle->getProducto()->getPrecioVenta() * $detalle->getCantidadProducto());
                }
            }
        }
        return $this->Total;
    }
    protected function save(string $query): ?bool
    {
        $arrData = [
            ':id' => $this->getId(),
            ':Numero' => $this->getNumero(),
            ':FechaVenta' => $this->getFechaVenta(),
            ':MedioPago'    => $this->getMedioPago(),
            ':Estado'   => $this->getEstado(),
            ':Cliente_id'  => $this->getClienteId(),
        ];
        $this->Connect();
        $result = $this->insertRow($query, $arrData);
        $this->Disconnect();
        return $result;
    }
    public function insert(): ?bool
    {
        $query = "INSERT INTO venta VALUES (
            :id,:Numero,:FechaVenta,:MedioPago,:Estado,:Cliente_id)";
        if ($this->save($query)){
            $idVenta = $this->getLastId('venta');
            $this->setId($idVenta);
            return true;
        }else{
            return false;
        }
    }
    public function update(): ?bool
    {
        $query = "UPDATE venta SET
                Numero = :Numero, FechaVenta = :FechaVenta, MedioPago = :MedioPago,
                 Estado = :Estado, Cliente_id = :Cliente_id WHERE id = :id";
        return $this->save($query);
    }
    public function deleted(): ?bool
    {
        $this->setEstado('Cancelada');
        return $this->update();
    }

    public static function search($query): ?array
    {
        try {
            $arrVentas = array();
            $tmp = new Ventas();

            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            if (!empty($getrows)) {
                foreach ($getrows as $valor) {
                    $Venta = new Ventas($valor);
                    array_push($arrVentas, $Venta);//aca meter el contenido del segundo parametro dentro del primero
                    unset($Venta);
                }
                return $arrVentas;
            }
            return null;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e);
        }
        return null;
    }
    public static function searchForId(int $id): ?Ventas
    {
        try {
            if ($id > 0) {
                $tmpVenta = new Ventas();
                $tmpVenta->Connect();
                $getrow = $tmpVenta->getRow("SELECT * FROM venta WHERE id = ?", array($id) );

                $tmpVenta->Disconnect();
                return ($getrow) ? new Ventas($getrow) : null;
            } else {
                throw new \Exception('Id de venta invalido');
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e);
        }
        return null;
    }
    public static function getAll(): ?array
    {
        return Ventas::search("SELECT * FROM venta");
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'Numero' => $this->getNumero(),
            'FechaVenta' => $this->getFechaVenta()->toDateString(),
            'MedioPago' => $this->getMedioPago(),
            'Estado' => $this->getEstado(),
            'Cliente_Id' => $this->getClienteId(),
        ];
    }
}



