<?php

namespace App\Controllers;
use App\Interfaces\Model;
use App\Models\AbstractDBConnection;
use App\Models\Ventas;
use App\Models\GeneralFunctions;
use Carbon\Carbon;
use Carbon\Traits\Creator;

class VentasController
{
    private array $dataVenta;

    public function __construct(array $_FORM)
    {
        $this->dataVenta = array();
        $this->dataVenta['id'] = $_FORM['id'] ?? NULL;
        $this->dataVenta['Numero'] = $_FORM['Numero'] ?? NULL;
        $this->dataVenta['FechaVenta'] = !empty($_FORM['FechaVenta']) ? Carbon::parse($_FORM['FechaVenta']) : new Carbon();
        $this->dataVenta['MedioPago'] = $_FORM['MedioPago'] ?? NULL;
        $this->dataVenta['Estado'] = $_FORM['Estado'] ?? NULL;
        $this->dataVenta['Cliente_id'] = $_FORM['Cliente_id'] ?? NULL;

    }
    public function create(){
        try {
            $Venta = new Ventas($this->dataVenta);
            if ($Venta->insert()) {
                unset($_SESSION['frmCreateVenta']);
                header("Location: ../../views/modules/venta/index.php?respuesta=success&mensaje=Venta Registrada");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }
    public function edit()
    {
        try {
            $oldVenta = Ventas::searchForId($this->dataVenta['id']);
            $this->dataVenta['Numero'] = $oldVenta->getNumero();
            unset($oldVenta);

            if (!Ventas::ventaRegistrada($this->dataVenta['Numero'],$this->dataVenta['id'])) {
                    $fta = new Ventas($this->dataVenta);
                if($fta->update()){
                    unset($_SESSION['frmEditVenta']);
                }
                header("Location: ../../views/modules/venta/show.php?id=" . $fta->getId() . "&respuesta=success&mensaje=Venta Actualizada");
            } else {
                header("Location: ../../views/modules/venta/edit.php?id=" . $this->dataVenta['id'] . "&respuesta=error&mensaje=Ya existe una venta con este numero");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }
    static public function searchForID(array $data)
    {
        try {
            $result = Ventas::searchForId($data['id']);
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
            $result = Ventas::getAll();
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
    static public function statusPendiente(int $id)
    {
        try {
            $ObjVenta = Ventas::searchForId($id);
            $ObjVenta->setEstado("Pendiente");
            if ($ObjVenta->update()){
                header("Location: ../../views/modules/venta/index.php");
            }else{
                header("Location: ../../views/modules/venta/index.php?respuesta=error&mensaje=Error al guardar");
            }
        }catch (\Exception $e){
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }
    static public function statusSaldada(int $id)
    {
        try {
            $ObjVenta = Ventas::searchForId($id);
            $ObjVenta->setEstado("Saldada");
            if ($ObjVenta->update()){
                header("Location: ../../views/modules/venta/index.php");
            }else{
                header("Location: ../../views/modules/venta/index.php?respuesta=error&mensaje=Error al guardar");
            }
        }catch (\Exception $e){
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }
    static public function statusCancelada(int $id)
    {
        try {
            $ObjVenta = Ventas::searchForId($id);
            $ObjVenta->setEstado("Cancelada");
            if ($ObjVenta->update()){
                header("Location: ../../views/modules/venta/index.php?respuesta=success&mensaje=Venta cancelada");
            }else{
                header("Location: ../../views/modules/venta/index.php?respuesta=error&mensaje=Error al guardar");
            }
        }catch (\Exception $e){
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }
    static public function statusRestaurar(int $id)//Restaura una venta ques esta en la papelera
    {
        try {
            $ObjVenta = Ventas::searchForId($id);
            $ObjVenta->setEstado("Pendiente");
            if ($ObjVenta->update()){
                header("Location: ../../views/modules/venta/restore.php?respuesta=success&mensaje=Venta restaurada");
            }else{
                header("Location: ../../views/modules/venta/restore.php?respuesta=error&mensaje=Error al guardar");
            }
        }catch (\Exception $e){
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }
    static public function selectVenta(array $params = []) {

        //Parametros de Configuracion
        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "venta_id";
        $params['name'] = $params['name'] ?? "venta_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrVentas = array();
        if ($params['where'] != "") {
            $base = "SELECT * FROM venta WHERE ";
            $arrVentas = Ventas::search($base . ' ' . $params['where']);
        } else {
            $arrVentas = Ventas::getAll();
        }

        $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (is_array($arrVentas) && count($arrVentas) > 0) {
            /* @var $arrVentas Ventas[] */
            foreach ($arrVentas as $venta)
                if (!VentasController::ventaIsInArray($venta->getId(), $params['arrExcluir']))
                    $htmlSelect .= "<option " . (($venta != "") ? (($params['defaultValue'] == $venta->getId()) ? "selected" : "") : "") . " value='" . $venta->getId() . "'>"
                        . $venta->getNumero().
            "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }
    private static function ventaIsInArray(?int $idVenta, mixed $ArrVentas): ?bool
    {
        if (count($ArrVentas) > 0) {
            foreach ($ArrVentas as $Venta) {
                if ($Venta->getId() == $idVenta) {
                    return true;
                }
            }
        }
        return false;
    }
}
