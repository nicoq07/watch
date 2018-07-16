<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Empleados Controller
 *
 * @property \App\Model\Table\EmpleadosTable $Empleados
 *
 * @method \App\Model\Entity\Empleado[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmpleadosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $empleados = $this->paginate($this->Empleados);
        
        $this->set(compact('empleados'));
    }

    /**
     * View method
     *
     * @param string|null $id
     *            Empleado id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $empleado = $this->Empleados->get($id, [
            'contain' => []
        ]);
        
        $this->set('empleado', $empleado);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $empleado = $this->Empleados->newEntity();
        if ($this->request->is('post')) {
            $empleado = $this->Empleados->patchEntity($empleado, $this->request->getData());
            if ($this->Empleados->save($empleado)) {
                $this->Flash->success(__('Empleado guardado.'));
                
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('Ha ocurrido un error, por favor reintente. Sí el error persiste informe al desarrollador.'));
        }
        $this->set(compact('empleado'));
    }

    /**
     * Edit method
     *
     * @param string|null $id
     *            Empleado id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $empleado = $this->Empleados->get($id, [
            'contain' => []
        ]);
        if ($this->request->is([
            'patch',
            'post',
            'put'
        ])) {
            $empleado = $this->Empleados->patchEntity($empleado, $this->request->getData());
            if ($this->Empleados->save($empleado)) {
                $this->Flash->success(__('Acción realizada correctamente.'));
                
                return $this->redirect([
                    'action' => 'index'
                ]);
            }
            $this->Flash->error(__('Ha ocurrido un error, por favor reintente. Sí el error persiste informe al desarrollador.'));
        }
        $this->set(compact('empleado'));
    }

    /**
     * Delete method
     *
     * @param string|null $id
     *            Empleado id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod([
            'post',
            'delete'
        ]);
        $empleado = $this->Empleados->get($id);
        if ($this->Empleados->delete($empleado)) {
            $this->Flash->success(__('The empleado has been deleted.'));
        } else {
            $this->Flash->error(__('Ha ocurrido un error, por favor reintente. Sí el error persiste informe al desarrollador.'));
        }
        
        return $this->redirect([
            'action' => 'index'
        ]);
    }

    public function home()
    {}

    public function procesar()
    {
        $dirNueva = null;
        $this->autoRender = false;
        if (isset($this->request->getData()['dat'])) {
            if (! $this->request->getData()['dat']['error'] == 0) {
                $this->Flash->error('El archivo esta dañado. Pruebe extraer el archivo nuevamente.');
                return $this->redirect([
                    'action' => 'home'
                ]);
            } else {
                
                $nombreArchivo = $this->request->getData()['dat']['name'];
                $dirArchivo = $this->request->getData()['dat']['tmp_name'];
                $dirNueva = ROOT . DS . 'files' . DS . date('d-m-Y H.i.s') . $nombreArchivo;
                // copio a la carpeta files
                $checkCopy = copy($dirArchivo, $dirNueva);
                
                if ($checkCopy) {
                    error_log(date('d-m-Y , h:i:s') . ": Archivo copiado. \n ", 3, LOGEO);
                    $this->mostrarReporte($this->laburar($dirNueva));
                } else {
                    error_log(date('d-m-Y , h:i:s') . ": No se copió el archivo. \n ", 3, LOGEO);
                }
            }
        } else {
            $this->Flash->error('Debe seleccionar el archivo nuevamente.');
            return $this->redirect([
                'action' => 'home'
            ]);
        }
    }

    public function mostrarReporte(array $reporte)
    {
        $listado = $reporte;
        $this->autoRender = false;
        $this->set(compact('listado'));
        $this->render('reporte');
    }

    private function laburar($dirNueva)
    {
        $listEmpleados = $this->Empleados->find()->toArray();
        
        $this->loadComponent('Report');
        $arrayProcesado = $this->Report->procesarDat($dirNueva);
        
        $reporte = null;
        foreach ($arrayProcesado as $empleado => $valores) {
            
            foreach ($listEmpleados as $emp) {
                if ($empleado == $emp->legajo) {
                    $reporte[$emp->presentacion] = $valores;
                    // $reporte[$emp->presentacion] = $this->Report->calcularDiferencia($valores);
                    // debug($valores);
                    // die();
                }
            }
        }
        if (empty($reporte)) {
            $this->Flash->error('Error generando el reporte. Por favor reintente. Sí se reitera el error informe al desarrollado.');
            return $this->redirect([
                'action' => 'home'
            ]);
        }
        
        return $reporte;
    }
}
