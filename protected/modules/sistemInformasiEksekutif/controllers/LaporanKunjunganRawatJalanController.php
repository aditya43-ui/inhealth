<?php
class LaporanKunjunganRawatJalanController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
        public $defaultAction = 'index';

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{

            $model = new SELaporankunjunganrjV;

            $format = new MyFormatter();
            $model->unsetAttributes();
            $model->jns_periode = "hari";
            $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
            $model->tgl_akhir = date('Y-m-d');
            $model->bln_awal = date('Y-m', strtotime('first day of january'));
            $model->bln_akhir = date('Y-m');
            $model->thn_awal = date('Y');
            $model->thn_akhir = date('Y');
            if (isset($_GET['SELaporankunjunganrjV'])) {
                $model->attributes = $_GET['SELaporankunjunganrjV'];
                $model->jns_periode = $_GET['SELaporankunjunganrjV']['jns_periode'];
                $model->tgl_awal = $format->formatDateTimeForDb($_GET['SELaporankunjunganrjV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SELaporankunjunganrjV']['tgl_akhir']);
                $model->bln_awal = $format->formatMonthForDb($_GET['SELaporankunjunganrjV']['bln_awal']);
                $model->bln_akhir = $format->formatMonthForDb($_GET['SELaporankunjunganrjV']['bln_akhir']);
                $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
                $model->thn_awal = $_GET['SELaporankunjunganrjV']['thn_awal'];
                $model->thn_akhir = $_GET['SELaporankunjunganrjV']['thn_akhir'];
                $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
                switch($model->jns_periode){
                    case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                    case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                    default : null;
                }
                $model->tgl_awal = $model->tgl_awal;
                $model->tgl_akhir = $model->tgl_akhir;
            }
            
            $dataProvider = $model->searchGrafikBatangPieRawatJalan();
            $dataProviderGaris = $model->searchGrafikGaris();
            $dataProviderSpeedo = $model->searchSpeedo();
            $data['title'] = 'Jumlah Kunjungan Rawat Jalan';
            $data['tgl_awal'] = $format->formatDateTimeId(date('Y-m-d',(strtotime($model->tgl_awal))));
            $data['tgl_akhir'] = $format->formatDateTimeId(date('Y-m-d',(strtotime($model->tgl_akhir))));
            
//            $model->tgl_awal = $format->formatDateTimeForUser(date('Y-m-d',(strtotime($model->tgl_awal))));
//            $model->tgl_akhir = $format->formatDateTimeForUser(date('Y-m-d',(strtotime($model->tgl_akhir))));
//            $model->bln_awal = $format->formatMonthForUser(date('Y-m',(strtotime($model->bln_awal))));
//            $model->bln_akhir = $format->formatMonthForUser(date('Y-m',(strtotime($model->bln_akhir))));
            

            $this->render('index', array(
                'model'=>$model, 
                'data'=>$data,
                'dataProvider'=>$dataProvider,
                'dataProviderGaris'=>$dataProviderGaris,
                'dataProviderSpeedo'=>$dataProviderSpeedo,
            ));
	}
        /**
         * update nilai grafik garis dan speedo dari request ajax
         */
        public function actionUpdateGrafik(){
            if(Yii::app()->request->isAjaxRequest) {
                $model = new SELaporankunjunganrjV();
                $format = new MyFormatter();
                if (isset($_POST['SELaporankunjunganrjV'])) {
                    $model->attributes = $_POST['SELaporankunjunganrjV'];
                    $model->tgl_awal = $format->formatDateTimeForDb($_POST['SELaporankunjunganrjV']['tgl_awal'])." 00:00:00";
                    $model->tgl_akhir = $format->formatDateTimeForDb($_POST['SELaporankunjunganrjV']['tgl_akhir'])." 23:59:59";
                }
                $index_garis = array();
                $result_garis = array();
                $periodeGrafik = $format->formatDateTimeId(date('Y-m-d',(strtotime($model->tgl_awal))))." s.d ".$format->formatDateTimeId(date('Y-m-d',(strtotime($model->tgl_akhir))));
                $return['title'] = "Grafik Kunjungan Rawat jalan <br> Periode: ".$periodeGrafik;
                if(isset($_POST['ruangan_nama'])){
                    if(!empty($_POST['ruangan_nama']))
                        $return['title'] = 'Grafik Kunjungan '.(ucfirst(strtolower($_POST['ruangan_nama'])))."<br>Periode : ".$periodeGrafik;
                    $model->ruangan_nama = strtolower($_POST['ruangan_nama']);
                }
                $dataProviderGaris = $model->searchGrafikGaris();
                $dataProviderSpeedo = $model->searchSpeedo();
                $hasilGaris = $dataProviderGaris->getData(); 
                foreach ($hasilGaris as $i=>$v){
                    if(strlen($v['data']) > 2){
                        $index_garis[] = $format->formatDateTimeForUser($v['data']);
                    }else{
                        $index_garis[] = $format->getMonthUser((int)$v['data'])." ".$v['data_2'];
                    }
                    $result_garis[] = array($i+1,(int)$v['jumlah']);
                }
                $return['garis']['result'] = $result_garis;
                $return['garis']['index'] = $index_garis;
                $return['speedo']['result'] = (int)$dataProviderSpeedo->getTotalItemCount();

                echo json_encode($return);
                Yii::app()->end();
            }
        }
	
}
