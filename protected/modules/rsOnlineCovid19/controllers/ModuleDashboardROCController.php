<?php

Yii::import("pendaftaranPenjadwalan.controllers.ModuleDashboardNeonController");
Yii::import("pendaftaranPenjadwalan.models.*");

class ModuleDashboardROCController extends ModuleDashboardNeonController {

    public $path_view = 'pendaftaranPenjadwalan.views.moduleDashboardNeon.';

    public function actionIndex() {
        $this->render('index');
    }

    /**
     * menampilkan halaman dashboard (iframe)
     * beberapa menggunakan DAO (createCommand) agar lebih cepat
     */
    public function actionSetIFrameDashboard() {

        $this->layout = '//layouts/iframeNeon';
        $format = new MyFormatter();
        //=== start 4 kolom ===
        $dataKolom = array();
        $dataAreaChart = array();
        $dataLineChart = array();
        $dataDonutChart = array();
        $dataPieChart = array();
        $dataBarChart = array();

        $result = array();
        $result['jumlah'] = 0;
        


        $dataKolom[1] = $result['jumlah'];


        $dataKolom[2] = $result['jumlah'];


        $dataKolom[3] = $result['jumlah'];


        $dataKolom[4] = $result['jumlah'];

        //=== end 4 kolom ===
        //=== chart ===

        $dataAreaChart = array();
        //=== chart ===

        $dataLineChart = array();

        $dataDonutChart = array();

        $dataPieChart = array();

        $dataKolom[5] = $result['jumlah'];

        $dataKolom[6] = $result['jumlah'];

        $dataBarChart = array();
        //=== end chart ===
        //=== start table ===

        $dataTable = $result['jumlah'];

        //=== end table ===
        //=== start todo list ===
        $modTodolist = new PPTodolistR;
        $dataProviderTodolist = $modTodolist->searchTodolistWidget();
        //=== end todo list ===
        //=== start map ===

        $dataMap = $result['jumlah'];


        // var_dump(prin)
        // echo "<pre>";
        // print_r($dataMap);
        // exit(Yii::app()->user->getState('propinsi_id'));
        $profil = ProfilrumahsakitM::model()->find();

        $modPropinsi = PropinsiM::model()->findByPk($profil->propinsi_id);
        $latitude = $modPropinsi->latitude;
        $longitude = $modPropinsi->longitude;
        //=== end map ===

        $this->render('dashboard', array(
            'dataKolom' => $dataKolom,
            'dataAreaChart' => $dataAreaChart,
            'dataLineChart' => $dataLineChart,
            'dataDonutChart' => $dataDonutChart,
            'dataPieChart' => $dataPieChart,
            'dataBarChart' => $dataBarChart,
            'dataTable' => $dataTable,
            'modTodolist' => $modTodolist,
            'dataProviderTodolist' => $dataProviderTodolist,
            'dataMap' => $dataMap,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ));
    }

}

?>