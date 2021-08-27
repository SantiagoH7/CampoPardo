<?php


namespace App\Controllers;

use App\Models\GeneralFunctions;
use App\Models\Productos;

class ProductosController
{
    private array $dataProducto;

    public function __construct(array $_FORM)
    {
        $this->dataProducto = array();
        $this->dataProducto ['id'] = $_FORM['id']?? null;
        $this->dataProducto ['Nombre'] = $_FORM['Nombre']?? null;
        $this->dataProducto ['Tamano'] = $_FORM['Tamano']?? null;
        $this->dataProducto ['Clasificacion'] = $_FORM['Clasificacion']?? null;
        $this->dataProducto ['Referencia'] = $_FORM['Referencia']?? null;
        $this->dataProducto ['PrecioProduccion'] = $_FORM['PrecioProduccion']?? null;
        $this->dataProducto ['PrecioVenta'] = $_FORM['PrecioVenta']?? null;
        $this->dataProducto ['Presentacion'] = $_FORM['Presentacion']?? null;
        $this->dataProducto ['Cantidad'] = $_FORM['Cantidad']?? null;
        $this->dataProducto ['Descripcion'] = (!empty($_FORM['Descripcion']))? $_FORM['Descripcion'] : 'Sin descripción';
        $this->dataProducto ['Estado'] = $_FORM['Estado']?? 'Activo';
        $this->dataProducto ['Proveedor_id'] = $_FORM['Proveedor_id']?? null;
    }

    public function create()
    {
        try {
            if (!empty($this->dataProducto['Referencia']) && !Productos::productoRegistrado($this->dataProducto['Referencia'])) {
                $Producto = new Productos($this->dataProducto);
                if ($Producto->insert()) {
                    unset($_SESSION['frmCreateProducto']);
                    header("Location: ../../views/modules/producto/index.php?respuesta=success&mensaje=Producto Registrado");
                }
            } else {
                header("Location: ../../views/modules/producto/create.php?respuesta=error&mensaje=La referencia de este producto ya existe");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception', $e, 'error');
        }
    }

    public function edit()
    {
        try {
            if (!Productos::productoRegistrado($this->dataProducto['Referencia'], $this->dataProducto['id']) ) {
                $prd = new Productos($this->dataProducto);
                if($prd->update()){
                    unset($_SESSION['frmEditProducto']);
                }
                header("Location: ../../views/modules/producto/show.php?id=" . $prd->getId() . "&respuesta=success&mensaje=Producto Actualizado");
            } else {
                header("Location: ../../views/modules/producto/edit.php?id=" . $this->dataProducto['id'] . "&respuesta=error&mensaje=La referencia de este producto ya existe");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function searchForID(array $data)
    {
        try {
            $result = Productos::searchForId($data['id']);
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
            $result = Productos::getAll();
            if (!empty($data['request']) and $data['request'] === 'ajax'){
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result);
            }
            return $result;
        }catch (\Exception $e){
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    static public function restaurar(int $id)
    {
        try {
            $ObjProducto = Productos::searchForId($id);
            $ObjProducto->setEstado("Activo");
            if ($ObjProducto->update()) {
                header("Location: ../../views/modules/producto/restore.php?respuesta=success&mensaje=Producto restaurado");
            } else {
                header("Location: ../../views/modules/producto/restore.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function inactivate(int $id)
    {
        try {
            $ObjProducto = Productos::searchForId($id);
            $ObjProducto->setEstado("Inactivo");
            if ($ObjProducto->update()) {
                header("Location: ../../views/modules/producto/index.php?respuesta=success&mensaje=Producto inhabilitado");
            } else {
                header("Location: ../../views/modules/producto/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function selectProducto(array $params = []) {

        //Parametros de Configuracion
        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "Producto_id";
        $params['name'] = $params['name'] ?? "Producto_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrProductos = array();
        if ($params['where'] != "") {
            $base = "SELECT * FROM producto WHERE ";
            $arrProductos = Productos::search($base . ' ' . $params['where']);
        } else {
            $arrProductos = Productos::getAll();
        }

        $htmlSelect = "<select " . (($params['isMultiple']) ? "multiple" : "") . " " . (($params['isRequired']) ? "required" : "") . " id= '" . $params['id'] . "' name='" . $params['name'] . "' class='" . $params['class'] . "' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (is_array($arrProductos) && count($arrProductos) > 0) {
            /* @var $arrProductos Productos[] */
            foreach ($arrProductos as $producto)
                if (!ProductosController::productoIsInArray($producto->getId(), $params['arrExcluir']))
                    $htmlSelect .= "<option " . (($producto != "") ? (($params['defaultValue'] == $producto->getId()) ? "selected" : "") : "") . " value='" . $producto->getId() . "'>" . $producto->getNombre(). "</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }
    private static function productoIsInArray($idProducto, mixed $ArrProductos): ?bool
    {
        if (count($ArrProductos) > 0){
            foreach ($ArrProductos as $Producto){
                if ($Producto->getId() == $idProducto){
                    return true;
                }
            }
        }
        return false;
    }
}