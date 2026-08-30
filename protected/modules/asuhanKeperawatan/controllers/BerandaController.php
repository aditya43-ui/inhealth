<?php

/**
 * contoller utama untuk menampilkan data dahboard
 * 
 * @package     application.modules.asuhanKeperawatan
 * @subpackage  controllers 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id> 
 * @version     2.0.0
 * @link        http://172.9.1.15/simpp/docs/
 * @link        http://piindonesia.co.id 
 */
class BerandaController extends MyAuthController {

    public $defaultAction = 'index';
    public $path_view = 'asuhanKeperawatan.views.beranda.';
    public $init = '';
        
    public function actionDashboardOPPE(){
        
        $model = new ASCustomModel();
        $model->tgl_awal = MyFormatter::formatMonthForUser(date('Y-m-d'));
        $model->tgl_akhir = MyFormatter::formatMonthForUser(date('Y-m-d'));
                       
        $data = $model->generateDashboardOPPE();
                
        $this->render($this->path_view.'oppe/index',array('model'=>$model,'data_grafik' => $data));
    }
    
    /**
     * mencari data sesuai periode laporan
     */
    public function actionCariData(){
        if (Yii::app()->request->isAjaxRequest){
            $tgl_awal = isset($_POST['tgl_awal'])?$_POST['tgl_awal']:null;
            $tgl_akhir = isset($_POST['tgl_akhir'])?$_POST['tgl_akhir']:null;
            $smf_nama = isset($_POST['smf_nama'])?$_POST['smf_nama']:null;
            $dokter = isset($_POST['dokter'])?$_POST['dokter']:null;
            $pegawai_id = isset($_POST['pegawai_id'])?$_POST['pegawai_id']:null;
            $smf_id = isset($_POST['smf_id'])?$_POST['smf_id']:null;
            
            $model = new ASCustomModel();
            $model->tgl_awal = $tgl_awal;
            $model->tgl_akhir = $tgl_akhir;
            $model->smf_nama = $smf_nama;
            $model->nama_pegawai = $dokter;
            $model->pegawai_id = $pegawai_id;
            $model->smf_id = $smf_id;
            
            $data = $model->generateDashboardOPPE();
            
            $return['sukses'] = 1;            
            $return['grafik'] = $data['grafik'];
            $return['list'] = $data['list'];
            $return['tooltip'] = $data['tooltip'];
            $return['div_grafik'] = $this->renderPartial($this->path_view.'oppe/_grafikChart',array('list'=>$data['list']), true);
            
            echo json_encode($return);
            Yii::app()->end();
        }
    }
}
