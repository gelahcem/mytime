<?php

class TimesheetController extends Controller {
    
    public $datashort;
    public $messe;
    public $oggimesse;
    public $lunedisem;
    public $martedisem;
    public $mercoledisem;
    public $giovedisem;
    public $venerdisem;
    public $sabatosem;
    public $domenicasem;
    public $lunediOggi;
    public $martediOggi;
    public $mercolediOggi;
    public $giovediOggi;
    public $venerdiOggi;
    public $sabatoOggi;
    public $domenicaOggi;
    
    
    public function init() {
        parent::init();
        
        $this->datashort = date('Y-m-d', strtotime('today'));
        $this->oggimesse = date('M Y', strtotime('today'));
        $this->lunedisem = date('Y-m-d', strtotime('monday this week'));//Salva record con questa data
        $this->martedisem = date('Y-m-d', strtotime('tuesday this week'));
        $this->mercoledisem = date('Y-m-d', strtotime('wednesday this week'));
        $this->giovedisem = date('Y-m-d', strtotime('thursday this week'));
        $this->venerdisem = date('Y-m-d', strtotime('friday this week'));
        $this->sabatosem = date('Y-m-d', strtotime('saturday this week'));
        $this->domenicasem = date('Y-m-d', strtotime('sunday this week'));
        
        $this->lunediOggi = date('d M', strtotime('monday this week'));
        $this->martediOggi = date('d M', strtotime('tuesday this week'));
        $this->mercolediOggi = date('d M', strtotime('wednesday this week'));
        $this->giovediOggi = date('d M', strtotime('thursday this week'));
        $this->venerdiOggi = date('d M', strtotime('friday this week'));
        $this->sabatoOggi = date('d M', strtotime('saturday this week'));
        $this->domenicaOggi = date('d M', strtotime('sunday this week'));
        
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                //'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform these actions
                'actions' => array('index', 'view', 'quickCreate', 'editableGrid', 'addRow', 'admin', 'delete', 'create', 'update', 'getsuccess'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform these actions
                'actions' => array(),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform these actions
                'actions' => array(),
                'users' => array('admin'),
            ),
            array('deny', // deny anonymous users
                'users' => array('*'),
            ),
        );
    }

    public function actionCreate() {
        $model = new Timesheet;
        $model->RISORSA = Yii::app()->user->getState('profile')->cn;
        $model->INSERITO = date('Y-m-d H:m:s');
        //$model->DATASHORT = $_POST[''];
        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);
        if (isset($_POST['Timesheet'])) {
            $model->attributes = $_POST['Timesheet'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'commessa registrata con successo, niente ti può fermare');
                $this->redirect(['admin']);
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionDelete($ID) {
        $model = $this->loadModel($ID);
        $model->delete() ? Yii::app()->user->setFlash('danger', "commessa cancellata") : "";
        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('error', 'Registro cancellato');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $ID the ID of the model to be loaded
     * @return Timesheet the loaded model
     * @throws CHttpException
     */
    public function loadModel($ID) {
        $model = Timesheet::model()->findByPk($ID);
        if ($model === null)
            throw new CHttpException(404, Yii::t('site', 'The requested page does not exist.'));
        return $model;
    }

    public function actionIndex() {
        $this->redirect('admin');
    }
    
    public function actionUpdate() {
        $this->render('update');
    }

    public function actionAdmin() {
        $model = new Timesheet('search');
        //$model->unsetAttributes();  // clear any default values
        //$model->RISORSA = Yii::app()->user->getState('profile')->cn;
        if (isset($_GET['Timesheet']))
            $model->attributes = $_GET['Timesheet'];
        $this->render('admin', array(
            'model' => $model,
        ));
    }
    
    public function actionGrid() {
        $this->render('grid');
    }

    public function actionQuickCreate() {
        $model = new Timesheet;
        if (isset($_POST['Timesheet'])) {
            $model->attributes = $_POST['Timesheet'];
            ($model->save()) ? $this->redirect(array('admin')) : "";
        }
    }

    /**
     * Allows direct edit and update a row in the CgridView.
     */
    public function actionEditableGrid() {
        $model = new Timesheet('search');

        if (isset($_POST['Timesheet'])) {
            foreach ($model->search()->data as $i => $item) {
                if (isset($_POST['Timesheet'][$i])) {
                    $item->attributes = $_POST['Timesheet'][$i];
                    $item->save()? Yii::app()->user->setFlash('success', "commessa registrata"):'';
                }
            }
            $this->redirect(array('admin'));
        }
    }

    public function actionAddRow() {
        $descrizione = Yii::app()->request->getParam('DESCRIZIONE');
        $result = Yii::app()->db->createCommand()->select('MAX(ID)')->from('timesheet')->queryScalar();
        $ID = $result + 1;

        $des = Timesheet::model()->findByPk($descrizione);
        $ido = Timesheet::model()->findByPk($ID);

        $des->save();
        $ido->save();
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'timesheet-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    private $success = array(
        array('commessa registrata con successo, niente ti può fermare'),
        array('Bravo. Prova a aggiungere più commesse'),
        array('stai lavorando molto, sei un grande'),
        array('Il segreto per andare avanti è iniziare. Continua così'),
        array("Non aspettare il momento giusto per fare le cose, l'unico momento giusto è adesso."),
    );

    private function getRandomSuccess() {
        return $this->success[array_rand($this->success, 1)];
    }

    function actionGetSuccess($success) {
        $this->getRandomSuccess();
        echo $success[0];
    }

}
