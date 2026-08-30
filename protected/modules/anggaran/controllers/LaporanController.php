<?php
Yii::import("billingKasir.models.*");
class LaporanController extends MyAuthController {

    public function actionLaporanPemakaiObatAlkes()
    {
        $model = new AGLaporanpemakaiobatalkesruanganV;
        $model->unsetAttributes();
        $format = new MyFormatter();
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');   
        $jenisObat =CHtml::listData($model->getJenisobatalkesItems(),'jenisobatalkes_id','jenisobatalkes_id');
        $model->jenisobatalkes_id = $jenisObat;        
        if(isset($_GET['AGLaporanpemakaiobatalkesruanganV']))
        {
            $model->attributes = $_GET['AGLaporanpemakaiobatalkesruanganV'];
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->jns_periode = $_GET['AGLaporanpemakaiobatalkesruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['AGLaporanpemakaiobatalkesruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AGLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['AGLaporanpemakaiobatalkesruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['AGLaporanpemakaiobatalkesruanganV']['bln_akhir']);
            $model->thn_awal = $_GET['AGLaporanpemakaiobatalkesruanganV']['thn_awal'];
            $model->thn_akhir = $_GET['AGLaporanpemakaiobatalkesruanganV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            
        }
        
        $this->render('pemakaiObatAlkes/adminPemakaiObatAlkes',array(
            'model'=>$model,'format'=>$format
        ));
       
    }

    public function actionPrintLaporanPemakaiObatAlkes() {
        $model = new AGLaporanpemakaiobatalkesruanganV('search');
        $format = new MyFormatter();
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');   
        $judulLaporan = 'Laporan Info Pemakai Obat Alkes Rawat Jalan';

        //Data Grafik       
        $data['title'] = 'Grafik Laporan Pemakai Obat Alkes';
        $data['type'] = $_REQUEST['type'];
        if (isset($_REQUEST['AGLaporanpemakaiobatalkesruanganV'])) {
            $model->attributes = $_REQUEST['AGLaporanpemakaiobatalkesruanganV'];
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->jns_periode = $_GET['AGLaporanpemakaiobatalkesruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['AGLaporanpemakaiobatalkesruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AGLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['AGLaporanpemakaiobatalkesruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['AGLaporanpemakaiobatalkesruanganV']['bln_akhir']);
            $model->thn_awal = $_GET['AGLaporanpemakaiobatalkesruanganV']['thn_awal'];
            $model->thn_akhir = $_GET['AGLaporanpemakaiobatalkesruanganV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal;
            $model->tgl_akhir = $model->tgl_akhir;
        }
        
        $caraPrint = $_REQUEST['caraPrint'];
        $target = 'pemakaiObatAlkes/_printPemakaiObatAlkes';
        
        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
    }
    

    public function actionFrameGrafikLaporanPemakaiObatAlkes() {
        $this->layout = '//layouts/iframe';
        $model = new AGLaporanpemakaiobatalkesruanganV('search');
        $format = new MyFormatter();
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
        $model->jns_periode = "hari";
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
        $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');   

        //Data Grafik
        $data['title'] = 'Grafik Laporan Pemakai Obat Alkes';
        $data['type'] = $_GET['type'];
        if (isset($_GET['AGLaporanpemakaiobatalkesruanganV'])) {
            $model->attributes = $_GET['AGLaporanpemakaiobatalkesruanganV'];
            $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $model->jns_periode = $_GET['AGLaporanpemakaiobatalkesruanganV']['jns_periode'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['AGLaporanpemakaiobatalkesruanganV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AGLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
            $model->bln_awal = $format->formatMonthForDb($_GET['AGLaporanpemakaiobatalkesruanganV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['AGLaporanpemakaiobatalkesruanganV']['bln_akhir']);
            $model->thn_awal = $_GET['AGLaporanpemakaiobatalkesruanganV']['thn_awal'];
            $model->thn_akhir = $_GET['AGLaporanpemakaiobatalkesruanganV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->tgl_awal = $model->tgl_awal;
            $model->tgl_akhir = $model->tgl_akhir;
        }
                
        $this->render('_grafik', array(
            'model' => $model,
            'data' => $data,
        ));
    }
    

    protected function printFunction($model,$data, $caraPrint, $judulLaporan, $target){ // $modDetail untuk apa?
        $format = new MyFormatter();
        $periode = $format->formatDateTimeForUser($model->tgl_awal).' s/d '.$format->formatDateTimeForUser($model->tgl_akhir);
//        echo $caraPrint;
        if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
            $this->layout = '//layouts/printWindows2';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint ));
        } else if ($caraPrint == 'EXCEL') {
            $this->layout = '//layouts/printExcel';
            $this->render($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
        } else if ($_REQUEST['caraPrint'] == 'PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF60('', $ukuranKertasPDF);
            ////$mpdf->useOddEven = 2;
             $footer = '
            <table width="100%">
            <tr>'
            . '<td style = "text-align:left;font-size:12px;"><i><b>{PAGENO}</b></i></td>'
            . '</tr>
             <tr>'
            . '<td style = "text-align:right;font-size:12px;"><i><b>Created At : '.MyFormatter::formatDateTimeId(date('Y-m-d H:i:s')).'</b></i></td>'
            . '<td style = "text-align:right;font-size:12px;"><i><b>Created By : '.$this->pageTitle=Yii::app()->user->nama_pemakai.' </b></i></td>'
            . '</tr>
            </table>';
            $mpdf->SetHtmlFooter($footer,'E');
            $mpdf->SetHtmlFooter($footer,'O');            
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet, 1);
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
            $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode'=>$periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
            $mpdf->Output($judulLaporan.'-'.date('Y/m/d').'.pdf','I');
        }
    }
    
    protected function parserTanggal($tgl){
    $tgl = explode(' ', $tgl);
    $result = array();
    foreach ($tgl as $row){
        if (!empty($row)){
            $result[] = $row;
        }
    }
    return Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($result[0], 'yyyy-MM-dd'),'medium',null).' '.$result[1];
        
    }
	   
	public function actionGetPenjaminPasien($encode=false,$model_nama='',$attr='')
   {
	   if(Yii::app()->request->isAjaxRequest) {
		   $modPasien = new RDPasienM;
		   if($model_nama !=='' && $attr == ''){
			   $carabayar_id = $_POST["$model_nama"]['carabayar_id'];
		   }
			elseif ($model_nama == '' && $attr !== '') {
			   $carabayar_id = $_POST["$attr"];
		   }
		   elseif ($model_nama !== '' && $attr !== '') {
			   $carabayar_id = $_POST["$model_nama"]["$attr"];
		   }
		   $penjamin = null;
		   if($carabayar_id){
			   $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id));
			   $penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
		   }

		   if($encode){
			   echo CJSON::encode($penjamin);
		   } else {
			   if(empty($penjamin)){
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			   }else{
                                if (count((array)$penjamin)>1){
                                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                                }elseif(count((array)$penjamin)==0){
                                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                                }
				   
				   foreach($penjamin as $value=>$name)
				   {
					   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				   }
			   }
		   }
	   }
	   Yii::app()->end();
	}
	
	/**
	* Mengatur dropdown kabupaten
	* @param type $encode jika = true maka return array jika false maka set Dropdown 
	* @param type $model_nama
	* @param type $attr
	*/
   public function actionSetDropdownKabupaten($encode=false,$model_nama='',$attr='')
   {
	   if(Yii::app()->request->isAjaxRequest) {
		   $modPasien = new RDPasienM;
		   if($model_nama !=='' && $attr == ''){
			   $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
		   }
			elseif ($model_nama == '' && $attr !== '') {
			   $propinsi_id = $_POST["$attr"];
		   }
			elseif ($model_nama !== '' && $attr !== '') {
			   $propinsi_id = $_POST["$model_nama"]["$attr"];
		   }
		   $kabupaten = null;
		   if($propinsi_id){
			   $kabupaten = $modPasien->getKabupatenItems($propinsi_id);
			   $kabupaten = CHtml::listData($kabupaten,'kabupaten_id','kabupaten_nama');
		   }
		   if($encode){
			   echo CJSON::encode($kabupaten);
		   } else {
			   if(empty($kabupaten)){
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			   } else {
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				   foreach($kabupaten as $value=>$name) {
					   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				   }
			   }
		   }
	   }
	   Yii::app()->end();
   }
   /**
	* Mengatur dropdown kecamatan
	* @param type $encode jika = true maka return array jika false maka set Dropdown 
	* @param type $model_nama
	* @param type $attr
	*/
   public function actionSetDropdownKecamatan($encode=false,$model_nama='',$attr='')
   {
	   if(Yii::app()->request->isAjaxRequest) {
		   $modPasien = new RDPasienM;
		   if($model_nama !=='' && $attr == ''){
			   $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
		   }
			elseif ($model_nama == '' && $attr !== '') {
			   $kabupaten_id = $_POST["$attr"];
		   }
			elseif ($model_nama !== '' && $attr !== '') {
			   $kabupaten_id = $_POST["$model_nama"]["$attr"];
		   }
		   $kecamatan = null;
		   if($kabupaten_id){
			   $kecamatan = $modPasien->getKecamatanItems($kabupaten_id);
			   $kecamatan = CHtml::listData($kecamatan,'kecamatan_id','kecamatan_nama');
		   }

		   if($encode){
			   echo CJSON::encode($kecamatan);
		   } else {
			   if(empty($kecamatan)){
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			   }else{
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				   foreach($kecamatan as $value=>$name)
				   {
					   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				   }
			   }
		   }
	   }
	   Yii::app()->end();
   }
   /**
	* Mengatur dropdown kelurahan
	* @param type $encode jika = true maka return array jika false maka set Dropdown 
	* @param type $model_nama
	* @param type $attr
	*/
   public function actionSetDropdownKelurahan($encode=false,$model_nama='',$attr='')
   {
	   if(Yii::app()->request->isAjaxRequest) {
		   $modPasien = new RDPasienM;
		   if($model_nama !=='' && $attr == ''){
			   $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
		   }
			elseif ($model_nama == '' && $attr !== '') {
			   $kecamatan_id = $_POST["$attr"];
		   }
		   elseif ($model_nama !== '' && $attr !== '') {
			   $kecamatan_id = $_POST["$model_nama"]["$attr"];
		   }
		   $kelurahan = null;
		   if($kecamatan_id){
			   $kelurahan = $modPasien->getKelurahanItems($kecamatan_id);
//                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
			   $kelurahan = CHtml::listData($kelurahan,'kelurahan_id','kelurahan_nama');
		   }

		   if($encode){
			   echo CJSON::encode($kelurahan);
		   } else {
			   if(empty($kelurahan)){
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			   }else{
				   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				   foreach($kelurahan as $value=>$name)
				   {
					   echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				   }
			   }
		   }
	   }
	   Yii::app()->end();
	}
	
	public function actionGetPenjaminPasienForCheckBox($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
           $carabayar_id = $_POST["$namaModel"]['carabayar_id'];

           if($encode) {
                echo CJSON::encode($penjamin);
           } else {
                if(empty($carabayar_id)){
//                    $penjamin = PenjaminpasienM::model()->findAll();
                    echo '<label>Data Tidak Ditemukan</label>';
                } else {
					$criteria = new CDbCriteria();
					$criteria->addCondition('carabayar_id = '.$carabayar_id);
					$criteria->addCondition('penjamin_aktif is true');
					$criteria->order = 'penjamin_nama ASC';
                    $penjamindata = PenjaminpasienM::model()->findAll($criteria);
                    $penjamin = CHtml::listData($penjamindata,'penjamin_id','penjamin_nama');
                    echo CHtml::hiddenField(''.$namaModel.'[penjamin_id]');
                    echo "<div style='margin-left:0px;'>".CHtml::checkBox('checkAllCaraBayar',true, array('onkeypress'=>"return $(this).focusNextInputField(event)",
                            'class'=>'checkbox-column','onclick'=>'checkAll()','checked'=>'checked'))." Pilih Semua";
                    echo "</div><br/>";
                    $i = 0;
                    if (count((array)$penjamin) > 0){
                        foreach($penjamin as $value=>$name) {
                            echo '<label class="checkbox">';
                            echo CHtml::checkBox(''.$namaModel.'[penjamin_id][]', true, array('value'=>$value));
                            echo '<label for="'.$namaModel.'_penjamin_id_'.$i.'">'.$name.'</label></label>';

                            $i++;
                        }
                    } else{
                        echo '<label>Data Tidak Ditemukan</label>';
                    }
                }
           }
        }
        Yii::app()->end();
    }
    
}
