<?php


namespace App\Controllers;

use App\Models\GeneralFunctions;
use App\Models\DetalleVentas;

class DetalleVentasController
{
    private array $dataDetalleVenta;

    /**
     * DetallePedidosController constructor.
     * @param array $dataDetalleVenta
     */
    public function __construct(array $_FORM)
    {
        $this->dataDetalleVenta = array();
        $this->dataDetalleVenta['id'] = $_FORM['id'] ?? null;
        $this->dataDetalleVenta['Producto_id'] = $_FORM['Producto_id'] ?? 0;
        $this->dataDetalleVenta['Venta_id'] = $_FORM['Venta_id'] ?? 0;
        $this->dataDetalleVenta['CantidadProducto'] = $_FORM['CantidadProducto'] ?? null;
    }

    public function create()
    {
        try {
            if (!empty($this->dataDetalleVenta['Producto_id']) && !empty($this->dataDetalleVenta['Venta_id']) &&
                !DetalleVentas::detalleVentaRegistrada($this->dataDetalleVenta['Producto_id'], $this->dataDetalleVenta['Venta_id'])){
                if (!empty($this->dataDetalleVenta['CantidadProducto']) && DetalleVentas::CantidadDisponible($this->dataDetalleVenta['CantidadProducto'], $this->dataDetalleVenta['Producto_id'])){
                    $DetalleVenta = new DetalleVentas($this->dataDetalleVenta);
                    if ($DetalleVenta->insert()) {
                        unset($_SESSION['frmCreateDetalleVenta']);
                        header("Location: ../../views/modules/detalle_venta/index.php?respuesta=success&mensaje=Detalle Venta Registrada");
                    }
                }else{
                    header("Location: ../../views/modules/detalle_venta/create.php?respuesta=error&mensaje=No hay esa cantidad de producto disponible");
                }
            }else{
                header("Location: ../../views/modules/detalle_venta/create.php?respuesta=error&mensaje=Ya existe un detalle venta con este producto y venta a la vez");
            }
        }catch (\Exception $e){
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }
     public function edit()
     {
         try {
                if (!DetalleVentas::detalleVentaRegistrada($this->dataDetalleVenta['Producto_id'], $this->dataDetalleVenta['Venta_id'],
                    $this->dataDetalleVenta['id'])){
                    if (!empty($this->dataDetalleVenta['CantidadProducto']) && DetalleVentas::CantidadDisponible($this->dataDetalleVenta['CantidadProducto'], $this->dataDetalleVenta['Producto_id'])) {
                        $dtvta = new DetalleVentas($this->dataDetalleVenta);
                        if ($dtvta->update()) {
                            unset($_SESSION['frmEditDetalleVenta']);
                        }
                        header("Location: ../../views/modules/detalle_venta/show.php?id=" . $dtvta->getId() . "&respuesta=success&mensaje=Detalle Venta Actualizada");
                    }else{
                        header("Location: ../../views/modules/detalle_venta/edit.php?id=" . $this->dataDetalleVenta['id'] . "&respuesta=error&mensaje=No hay esa cantidad de producto disponible");
                    }
                }else{
                    header("Location: ../../views/modules/detalle_venta/edit.php?id=" . $this->dataDetalleVenta['id'] . "&respuesta=error&mensaje=Ya existe un detalle venta con este producto y venta a la vez");
                }
         }catch (\Exception $e){
             GeneralFunctions::logFile('Exception',$e, 'error');
         }
     }
     static public function searchForId(array $data)
     {
         try {
             $result = DetalleVentas::searchForId($data['id']);
             if (!empty($data['request']) and $data['request'] === 'ajax' and !empty($result)) {
                 header('Content-type: application/json; charset=utf-8');
                 $result = json_encode($result->jsonSerialize());
             }
             return $result;
         } catch (\Exception $e) {
             GeneralFunctions::logFile('Exception',$e, 'error');
         }
         return null;
     }
    static public function getAll(array $data = null)
    {
        try {
            $result = DetalleVentas::getAll();
            if (!empty($data['request']) and $data['request'] === 'ajax') {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result);
            }
            return $result;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    static public function selectDetalleVenta(array $params = []) {

        //Parametros de Configuracion
        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "detalleVenta_id";
        $params['name'] = $params['name'] ?? "detalleVenta_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array(); //[Bebidas, Frutas]
        $params['request'] = $params['request'] ?? 'html';

        $arrDetalleVenta = array();
        if ($params['where'] != "") {
            $base = "SELECT * FROM DetalleVenta WHERE ";
            $arrDetalleVenta = DetalleVentas::search($base . ' ' . $params['where']);
        } else {
            $arrDetalleVenta = DetalleVentas::getAll();
        }

        $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (is_array($arrDetalleVenta) && count($arrDetalleVenta) > 0) {
            /* @var $arrDetalleVenta DetalleVentas[] */
            foreach ($arrDetalleVenta as $detalleVenta)
                if (!DetalleVentasController::detalleVentaIsInArray($detalleVenta->getId(), $params['arrExcluir']))
                    $htmlSelect .= "<option " . (($detalleVenta != "") ? (($params['defaultValue'] == $detalleVenta->getId()) ? "selected" : "") : "") . " value='" . $detalleVenta->getId() . "'>" ."Detalle venta con id producto: ". $detalleVenta->getProductoId() . " con cantidad de producto: " . $detalleVenta->getCantidadProducto() . "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }
    private static function detalleVentaIsInArray($idDetalleVenta, $arrDetalleVenta): ?bool
    {
        if (count($arrDetalleVenta) > 0) {
            foreach ($arrDetalleVenta as $DetalleVenta) {
                if ($DetalleVenta->getId() == $idDetalleVenta) {
                    return true;
                }
            }
        }
        return false;
    }
}