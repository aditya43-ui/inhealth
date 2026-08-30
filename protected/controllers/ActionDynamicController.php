<?php
/**
 * RND-7811 : INI SUDAH TIDAK DIGUNAKAN LAGI, FUNCTION PINDAHKAN KE CONTROLLER MASING2
 */
class ActionDynamicController extends Controller
{
    
    public function init() {
        parent::init();
        Yii::import('farmasiApotek.controllers.*');
    }
    
 
  /*
 * Mencari Ruangan berdasarkan instalasi di tabel kelas Ruangan M
 * and open the template in the editor.
 */
    public function actionGetKelasPelayanDariRuangan($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
  
            $idRuangan = $_POST["$namaModel"]['ruangan_id'];
            $ruangan = KelasruanganM::model()->with('kelaspelayanan')->findAll('ruangan_id='.$idRuangan.'');
            
            $kelasPelayanan=CHtml::listData($ruangan,'kelaspelayanan_id','kelaspelayanan.kelaspelayanan_nama');
            
            if(empty($kelasPelayanan)){
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-Pilih-'),true);
            }else{
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-Pilih-'),true);
                foreach($kelasPelayanan as $value=>$name)
                {
                    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
            }
        }
        Yii::app()->end();
    }       
    
      
    
    /*
 * Mencari Ruangan berdasarkan Kelaspelayanan_id di tabel kelas Ruangan M
 * and open the template in the editor.
 */
    public function actionGetRuangan($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $kelaspelayanan_id = $_POST["$namaModel"]['kelaspelayanan_id'];
            $ruangan = KelasruanganM::model()->with('ruangan')->findAll('kelaspelayanan_id='.$kelaspelayanan_id.'');
            
            $ruangan=CHtml::listData($ruangan,'ruangan_id','ruangan.ruangan_nama');
            
            if(empty($ruangan)){
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih Ruangan --'),true);
            }else{
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih Ruangan --'),true);
                foreach($ruangan as $value=>$name)
                {
                    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
            }
        }
        Yii::app()->end();
    }
    
    public function actionGetDokterRuangan($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $ruangan_id = $_POST["$namaModel"]['ruangan_id'];
            $dokter = DokterV::model()->findAll('ruangan_id='.$ruangan_id.'');
            
            $dokter=CHtml::listData($dokter,'pegawai_id','namaLengkap');
            
            if(empty($dokter)){
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
            }else{
                if (count((array)$dokter)>1){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }elseif (count((array)$dokter)==0){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }
                
                foreach($dokter as $value=>$name)
                {
                    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
            }
        }
        Yii::app()->end();
    }
    
    
     /*
 * Mencari Ruangan berdasarkan instalasi_id di tabel Ruangan M
 * and open the template in the editor.
 */
    public function actionGetRuanganDariInstalasi($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $instalasi_id = $_POST["$namaModel"]['instalasi_id'];
			if (!empty($instalasi_id)){
				$ruangan = RuanganM::model()->findAll('instalasi_id='.$instalasi_id.' and ruangan_aktif = true ORDER BY ruangan_nama ASC');            
				$ruangan=CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
			}else{
				$ruangan = null;
			}
            
            if(empty($ruangan)){
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
            }else{
                if (count((array)$ruangan) > 1){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }elseif (count((array)$ruangan) == 0){                
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }
                foreach($ruangan as $value=>$name)
                {
                    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
            }
        }
        Yii::app()->end();
    }   
    
/*
 * Mencari Ruangan berdasarkan instalasiasal_id di tabel kelas Ruangan M
 * and open the template in the editor.
 */
    public function actionGetRuanganAsalDariInstalasiAsal($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $instalasi = $_POST["$namaModel"]['instalasiasal_id'];
			if (!empty($instalasi)){
				$ruangan = RuanganM::model()->findAll('instalasi_id='.$instalasi.' and ruangan_aktif = true');

				$ruangan=CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
			}else{
				$ruangan = array();
			}
            
            if(empty($ruangan)){
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
            }else{
                if (count((array)$ruangan) > 1){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }elseif (count((array)$ruangan) == 0){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }
                foreach($ruangan as $value=>$name)
                {
                    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
            }
        }
        Yii::app()->end();
    }
    
         
    
 
    
    
    
    
    
    public function actionGetActions($encode=false)
    {
        if(Yii::app()->request->isAjaxRequest) {
            $namaModul = $_POST['namaModul'];
            $contorllerId = $_POST['namaController'];
            $actions = CustomFunction::getActions($contorllerId, $namaModul);
            
            if($encode)
            {
                echo CJSON::encode($actions);
            } else {
                foreach ($actions as $value => $name)
                {
					echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
                }
            }
        }
        Yii::app()->end();
    }
    
    

    public function actionGetKelasKamarRuangan($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $kelasPelayanan_id = $_POST["$namaModel"]['kelaspelayanan_id'];
           if($encode) {
                if(empty($kelasPelayanan_id)){
                    $kamarRuangan = array();
                } else {
                    $kamarRuangan = KamarruanganM::model()->findAllByAttributes(array('kelaspelayanan_id'=>$kelasPelayanan_id, 'ruangan_id'=>Params::RUANGAN_ID_BEDAH));
                    $kamarRuangan = CHtml::listData($kamarRuangan,'kamarruangan_id','KamarDanTempatTidur');
                }
                echo CJSON::encode($kamarRuangan);
           } else {
                if(empty($kelasPelayanan_id)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                } else {
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        $kamarRuangan = KamarruanganM::model()->findAllByAttributes(array('kelaspelayanan_id'=>$kelasPelayanan_id, 'ruangan_id'=>Params::RUANGAN_ID_BEDAH));
                        $kamarRuangan = CHtml::listData($kamarRuangan,'kamarruangan_id','KamarDanTempatTidur');
                        foreach($kamarRuangan as $value=>$name) {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                }
           }
        }
        Yii::app()->end();
    }
    
    public function actionGetKabupaten($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $modPasien = new PasienM;
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
        
    public function actionGetKabupatenNama($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $modPasien = new PasienM;
                if($model_nama !=='' && $attr == ''){
                    $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
                }
                 elseif ($model_nama == '' && $attr !== '') {
                    $propinsi_id = $_POST["$attr"];
                }
                 elseif ($model_nama !== '' && $attr !== '') {
                    $propinsi_id = $_POST["$model_nama"]["$attr"];
                }
                
                $propinsi = PropinsiM::model()->findByAttributes(array(
                    'propinsi_nama'=>$propinsi_id,
                ));
                
                $kabupaten = null;
                if(!empty($propinsi)){
                    $kabupaten = $modPasien->getKabupatenItems($propinsi->propinsi_id);
                    $kabupaten = CHtml::listData($kabupaten,'kabupaten_nama','kabupaten_nama');
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
        
        public function actionGetKecamatan($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $modPasien = new PasienM;
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
        
        public function actionGetKecamatanNama($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $modPasien = new PasienM;
                if($model_nama !=='' && $attr == ''){
                    $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
                }
                 elseif ($model_nama == '' && $attr !== '') {
                    $kabupaten_id = $_POST["$attr"];
                }
                 elseif ($model_nama !== '' && $attr !== '') {
                    $kabupaten_id = $_POST["$model_nama"]["$attr"];
                }
                $kabupaten = KabupatenM::model()->findByAttributes(array('kabupaten_nama'=>$kabupaten_id));
                $kecamatan = null;
                if($kabupaten){
                    $kecamatan = $modPasien->getKecamatanItems($kabupaten->kabupaten_id);
                    $kecamatan = CHtml::listData($kecamatan,'kecamatan_nama','kecamatan_nama');
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
        public function actionGetKelurahan($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $modPasien = new PasienM;
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
    

    public function actionGetKabupatendrNamaPropinsi($encode=false,$namaModel='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            if ($namaModel == '' && $attr !== '') {
                $propinsi_nama = $_POST["$attr"];
            }
             elseif ($namaModel !== '' && $attr !== '') {
                $propinsi_nama = $_POST["$namaModel"]["$attr"];
            }
            $propinsi = PropinsiM::model()->findByAttributes(array('propinsi_nama'=>$propinsi_nama));
            $propinsi_id = $propinsi->propinsi_id;
            if (count((array)$propinsi)<1) {$propinsi_id=$propinsi_nama;}
            $kabupaten = KabupatenM::model()->findAll("propinsi_id='$propinsi_id' ORDER BY kabupaten_nama asc");
            $kabupaten = CHtml::listData($kabupaten,'kabupaten_id','kabupaten_nama');
            
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
    
    
    
    
    public function actionGetNamaRujukan($encode=false,$namaModel='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            if($namaModel !=='' && $attr == ''){
                $asalrujukan_id = $_POST["$namaModel"]['asalrujukan_id'];
            }
             elseif ($namaModel == '' && $attr !== '') {
                $asalrujukan_id = $_POST["$attr"];
            }
            elseif ($namaModel !== '' && $attr !== '') {
                $asalrujukan_id = $_POST["$namaModel"]["$attr"];
            }
            $namarujukan = RujukandariM::model()->findAll('asalrujukan_id='.$asalrujukan_id.'');
            $namarujukan = CHtml::listData($namarujukan,'namaperujuk','namaperujuk');
            
            if($encode){
                echo CJSON::encode($namarujukan);
            } else {
                if(empty($namarujukan)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }else{
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    foreach($namarujukan as $value=>$name)
                    {
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
    
    public function actionGetKasusPenyakit($encode=false,$namaModel='',$attr='',$listDropdown=false)
    {
        if(Yii::app()->request->isAjaxRequest) {
            if($namaModel !== ''){
                $ruangan_id = $_POST["$namaModel"]['ruangan_id'];
            }
             elseif ($namaModel == '' && $attr !== '') {
                $ruangan_id = $_POST["$attr"];
            }
            
            $jenisKasusPenyakit = array();
            if(!empty($ruangan_id)) {
                $sql = "SELECT jeniskasuspenyakit_m.jeniskasuspenyakit_id, jeniskasuspenyakit_m.jeniskasuspenyakit_nama 
                        FROM jeniskasuspenyakit_m
                        JOIN kasuspenyakitruangan_m ON jeniskasuspenyakit_m.jeniskasuspenyakit_id = kasuspenyakitruangan_m.jeniskasuspenyakit_id
                        JOIN ruangan_m ON kasuspenyakitruangan_m.ruangan_id = ruangan_m.ruangan_id
                        WHERE ruangan_m.ruangan_id = '$ruangan_id'
                        ORDER BY jeniskasuspenyakit_m.jeniskasuspenyakit_id";
                $modJenKasusPenyakit = JeniskasuspenyakitM::model()->findAllBySql($sql);

                $jenisKasusPenyakit = CHtml::listData($modJenKasusPenyakit,'jeniskasuspenyakit_id','jeniskasuspenyakit_nama');
            }
            
            if($encode){
                echo CJSON::encode($jenisKasusPenyakit);
            } else if(!$listDropdown) {
                if(empty($jenisKasusPenyakit)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }else{
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    foreach($jenisKasusPenyakit as $value=>$name)
                    {
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
            
            if($listDropdown) {
                if(empty($jenisKasusPenyakit)){
                    $option = CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }else{
                    $option = CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    foreach($jenisKasusPenyakit as $value=>$name)
                    {
                        $option .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
                $dataList['listPenyakit'] = $option;
                echo json_encode($dataList);
            }
        }
        Yii::app()->end();
    }
        
    

    public function actionKamarRuanganEkios()
    {
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            if(!empty($_POST['idRuangan'])){
                $idRuangan = $_POST['idRuangan'];
                $data = KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$idRuangan),array('order'=>'kamarruangan_nokamar'));
                $data = CHtml::listData($data,'kamarruangan_id','KamarDanTempatTidur');

                if(empty($data)){
                    $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }else{
                    $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    foreach($data as $value=>$name) {
                            $option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                    }
                }

                $dataList['listKamarRuangan'] = $option;
            } else {
                $dataList['listKamarRuangan'] = $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
            }

            echo json_encode($dataList);
            Yii::app()->end();
        }
    }

    public function actionKelasPelayananEkios()
    {
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            if(!empty($_POST['idKelasPelayanan'])){
                $idKelasPelayanan = $_POST['idKelasPelayanan'];
                $data = KamarruanganM::model()->with('kelaspelayanan')->findAllByAttributes(array('kamarruangan_id'=>$idKelasPelayanan),array());
                $data = CHtml::listData($data,'kelaspelayanan_id','kelaspelayanan.kelaspelayanan_nama');

                if(empty($data)){
                    $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }else{
                    $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    foreach($data as $value=>$name) {
                            $option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                    }
                }

                $dataList['listKelasPelayanan'] = $option;
            } else {
                $dataList['listKelasPelayanan'] = $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
            }

            echo json_encode($dataList);
            Yii::app()->end();
        }
    }
    /**
     *penggunaannya
     * 1. digunakan di pendaftaran rawat inap
     * @param type $encode
     * @param type $namaModel
     * @param type $attr 
     */
    public function actionGetKamarKosong($encode=false,$namaModel='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
            if (empty($ruangan_id) && isset($_POST[$namaModel]['ruangan_id']))
                $ruangan_id = $_POST[$namaModel]['ruangan_id'];
            
            $bookingkamar_id = (isset($_POST['bookingkamar_id']) ? $_POST['bookingkamar_id'] : null);
            if (empty($bookingkamar_id) && isset($_POST[$namaModel]['bookingkamar_id']))
                $bookingkamar_id = $_POST[$namaModel]['bookingkamar_id'];

            $kamarKosong = array();
            if(!empty($ruangan_id)) {
                if(!empty($bookingkamar_id)){
                    $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'kamarruangan_status'=>true));

                    $modBookingKamar = BookingkamarT::model()->findByPk($bookingkamar_id);
                }else{
                    $kamarKosong = KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id,'kamarruangan_status'=>true));
                }
                $kamarKosong = CHtml::listData($kamarKosong,'kamarruangan_id','KamarDanTempatTidur');
            }
            
            if($encode){
                echo CJSON::encode($kamarKosong);
            } else {
                if(empty($kamarKosong)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
                }else{
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
                    foreach($kamarKosong as $value=>$name)
                    {
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
    
    /**
     * Digunakan untuk filter ruangan
     * @param type $encode
     * @param type $namaModel
     * @param type $attr
     */
    public function actionGetKamarRuangan($encode=false,$namaModel='',$attr='') {
        if(Yii::app()->request->isAjaxRequest) {
            $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
            if (empty($ruangan_id) && isset($_POST[$namaModel]['ruangan_id']))
                $ruangan_id = $_POST[$namaModel]['ruangan_id'];

            if (empty($ruangan_id) && isset($_POST[$namaModel]['ruanganakhir_id']))
                $ruangan_id = $_POST[$namaModel]['ruanganakhir_id'];

            $kamar = array();
            if(!empty($ruangan_id)) {
                $kamar = KamarruanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan_id, 'kamarruangan_aktif'=>true));
                $kamar = CHtml::listData($kamar,'kamarruangan_id','KamarDanTempatTidur');
            }
            
            if($encode){
                echo CJSON::encode($kamar);
            } else {
                if(empty($kamar)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
                }else{
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
                    foreach($kamar as $value=>$name)
                    {
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
    
    /**
     * Digunakan untuk filter ruangan
     * @param type $encode
     * @param type $namaModel
     * @param type $attr
     */
    public function actionGetKamarKelas($encode=false,$namaModel='',$attr='') {
        if(Yii::app()->request->isAjaxRequest) {
            $kelaspelayanana_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
            if (empty($kelaspelayanana_id) && isset($_POST[$namaModel]['kelaspelayanan_id']))
                $kelaspelayanana_id = $_POST[$namaModel]['kelaspelayanan_id'];

           

            $kamar = array();
            if(!empty($kelaspelayanana_id)) {
                $kamar = KamarruanganM::model()->findAllByAttributes(
                    array('kelaspelayanan_id'=>$kelaspelayanana_id, 'kamarruangan_aktif'=>true),
                    array('order'=>'kamarruangan_nokamar, kamarruangan_nobed')
                   );
                $kamar = CHtml::listData($kamar,'kamarruangan_id','KamarDanTempatTidurPolos');
            }
            
            if($encode){
                echo CJSON::encode($kamar);
            } else {
                if(empty($kamar)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
                }else{
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode("-- Pilih --"),true);
                    foreach($kamar as $value=>$name)
                    {
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
    
    public function actionGetAnastesi($encode=false,$namaModel='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            if($namaModel !=='' && $attr == ''){
                $jenisanastesi_id = $_POST["$namaModel"]['jenisanastesi_id'];
            }
             elseif ($namaModel == '' && $attr !== '') {
                $jenisanastesi_id = $_POST["$attr"];
            }
             elseif ($namaModel !== '' && $attr !== '') {
                $jenisanastesi_id = $_POST["$namaModel"]["$attr"];
            }
            $anastesi = AnastesiM::model()->findAll('jenisanastesi_id = '.$jenisanastesi_id.' AND anastesi_aktif = TRUE ORDER BY anastesi_nama');
            $anastesi = CHtml::listData($anastesi,'anastesi_id','anastesi_nama');
            
            if($encode){
                echo CJSON::encode($anastesi);
            } else {
                if(empty($anastesi)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }else{
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    foreach($anastesi as $value=>$name)
                    {
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
    
    public function actionGetTypeAnastesi($encode=false,$namaModel='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            if($namaModel !=='' && $attr == ''){
                $anastesi_id = $_POST["$namaModel"]['anastesi_id'];
            }
             elseif ($namaModel == '' && $attr !== '') {
                $anastesi_id = $_POST["$attr"];
            }
             elseif ($namaModel !== '' && $attr !== '') {
                $anastesi_id = $_POST["$namaModel"]["$attr"];
            }
            $typeanastesi = TypeAnastesiM::model()->findAll('typeanastesi_id = '.$anastesi_id.' ORDER BY typeanastesi_nama');
            $typeanastesi = CHtml::listData($typeanastesi,'typeanastesi_id','typeanastesi_nama');
            
            if($encode){
                echo CJSON::encode($typeanastesi);
            } else {
                if(empty($typeanastesi)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }else{
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    foreach($typeanastesi as $value=>$name)
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
                if(empty($carabayar_id)){
                    $penjamin = array();
                } else {
                    $penjamindata = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id), array('order'=>'penjamin_nama ASC'));
                    $penjamin = CHtml::listData($penjamindata,'penjamin_id','penjamin_nama');
                }
                echo CJSON::encode($penjamin);
           } else {
                if(empty($carabayar_id)){
//                    $penjamin = PenjaminpasienM::model()->findAll();
                    echo '<label>Data Tidak Ditemukan</label>';
                } else {
                    $penjamindata = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id), array('order'=>'penjamin_nama ASC'));
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
    
    public function actionGetPenjaminForDropCheck($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
           $carabayar_id = $_POST["$namaModel"]['carabayar_id'];

           if($encode) {
                if(empty($carabayar_id)){
                    $penjamin = array();
                } else {
                    $penjamindata = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id), array('order'=>'penjamin_nama ASC'));
                    $penjamin = CHtml::listData($penjamindata,'penjamin_id','penjamin_nama');                    
                }
                echo CJSON::encode($penjamin);
           } else {
                if(empty($carabayar_id)){
//                    $penjamin = PenjaminpasienM::model()->findAll();
                    
                } else {
                    $penjamindata = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id), array('order'=>'penjamin_nama ASC'));
                    $penjamin = CHtml::listData($penjamindata,'penjamin_id','penjamin_nama');                    
                    $i = 0;
                    if (count((array)$penjamin) > 0){
                        foreach($penjamin as $value=>$name) {
                            echo '<label class="checkbox inline">';
                            echo CHtml::checkBox(''.$namaModel.'[penjamin_id][]', true, array('value'=>$value));
                            echo '<label for="'.$namaModel.'_penjamin_id_'.$i.'">'.$name.'</label></label>';

                            $i++;
                        }
                    } else{
                      
                    }
                }
           }
        }
        Yii::app()->end();
    }
    
    
    public function actionGetPenjaminPasien($encode=false,$namaModel='',$is_informasi='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $carabayar_id = isset($_POST["$namaModel"]['carabayar_id']) ? $_POST["$namaModel"]['carabayar_id'] : null;

           if($encode)
           {
                if(empty($carabayar_id)){
                    $penjamin = array();
                } else {
                    $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true), array('order'=>'penjamin_nama ASC'));
                    $penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
                }
                echo CJSON::encode($penjamin);
           } else {
                if(empty($carabayar_id)){
                    if($is_informasi != '') {
                        $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif'=>true), array('order'=>'penjamin_nama ASC'));
                        if(count((array)$penjamin) > 1)
                        {
                            echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        }
                        $penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
                        foreach($penjamin as $value=>$name) {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    } else {
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    }
                } else {
                    $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true), array('order'=>'penjamin_nama ASC'));
                    if(count((array)$penjamin) > 1)
                    {
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    }
                    $penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
                    foreach($penjamin as $value=>$name) {
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
           }
        }
        Yii::app()->end();
    }
	
    public function actionGetPenjaminPasienDariIDCarabayar()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $carabayar_id = $_POST['carabayar_id'];

			if(empty($carabayar_id)){
				echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			} else {
				$penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id,'penjamin_aktif'=>true), array('order'=>'penjamin_nama ASC'));
				if(count((array)$penjamin) > 1)
				{
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				}
				$penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
				foreach($penjamin as $value=>$name) {
					echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
				}
			}
        }
        Yii::app()->end();
    }
    
    
    
        
    
    public function actionGetRuanganAsalForCheckBox($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
           $instalasi_id = $_POST["$namaModel"]['instalasiasal_id'];

           if($encode) {
                if(empty($instalasi_id)){
                    $ruangan = array();
                } else {
                    $ruangan = RuanganM::model()->findAll('instalasi_id='.$instalasi_id.'');
                    
                    $ruangan = CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
                    
                }
                echo CJSON::encode($ruangan);
           } else {
                if(empty($instalasi_id)){
                    echo '<label>Data Tidak Ditemukan</label>';
                } else {
                    $ruangan = RuanganM::model()->findAll('instalasi_id='.$instalasi_id.'');
                    
                    $ruangan = CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
                    echo CHtml::hiddenField(''.$namaModel.'[ruanganasal_id]');
                    $i = 0;
                    if (count((array)$ruangan) > 0){
                        foreach($ruangan as $value=>$name) {
    //                        echo '<label class="checkbox">';
    //                        echo CHtml::checkBox(''.$namaModel."[ruangan_id][]", true, array('value'=>$value));
    //                        echo '<label for="'.$namaModel.'_ruangan_id_'.$i.'">'.$name.'</label>';
    //                        echo '</label>';
                            $selects[] = $value;
                            $i++;
                        }
                        echo CHtml::checkBoxList(''.$namaModel."[ruanganasal_id]", $selects, $ruangan, array('template'=>'<label class="checkbox">{input}{label}</label>', 'separator'=>''));
                    }
                    else{
                        echo '<label>Data Tidak Ditemukan</label>';
                    }
                }
                
           }
        }
        Yii::app()->end();
    }
    
    
       
    
    public function actionRuanganPemesanDariInstalasi($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
  
            $idInstalasi = $_POST["$namaModel"]['instalasipemesan_id'];
            if (empty($idInstalasi)){
                $ruangan = RuanganM::model()->findAll();
            }
            else{
                $ruangan = RuanganM::model()->findAll('instalasi_id='.$idInstalasi.'');
            }
            
            $ruangan=CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
            
            echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                foreach($ruangan as $value=>$name)
                {
                    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
            
        }
        Yii::app()->end();
    }   
    
    public function actionGetRuanganAsalNamaForCheckBox($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
           $instalasi_id = $_POST["$namaModel"]['instalasiasal_nama'];

           if($encode) {
                if(empty($instalasi_id)){
                    $ruangan = array();
                } else {
                    $criteria = new CDbCriteria();
                    $criteria->with = 'instalasi';
                    $criteria->compare('LOWER(instalasi.instalasi_nama)',strtolower($instalasi_id), true);
                    $ruangan = RuanganM::model()->findAll($criteria);
                    $ruangan = CHtml::listData($ruangan,'ruangan_nama','ruangan_nama');
                    
                }
                echo CJSON::encode($ruangan);
           } else {
                if(empty($instalasi_id)){
                    $ruangan = array();
                } else {
                    $criteria = new CDbCriteria();
                    $criteria->with = 'instalasi';
                    $criteria->compare('LOWER(instalasi.instalasi_nama)',strtolower($instalasi_id), true);
                    $ruangan = RuanganM::model()->findAll($criteria);
                    $ruangan = CHtml::listData($ruangan,'ruangan_nama','ruangan_nama');
                }
                echo CHtml::hiddenField(''.$namaModel.'[ruanganasal_nama]');
                $i = 0;
                if (count((array)$ruangan) > 0){
                    foreach($ruangan as $value=>$name) {
//                        echo '<label class="checkbox">';
//                        echo CHtml::checkBox(''.$namaModel."[ruangan_id][]", true, array('value'=>$value));
//                        echo '<label for="'.$namaModel.'_ruangan_id_'.$i.'">'.$name.'</label>';
//                        echo '</label>';
                        $selects[] = $value;
                        $i++;
                    }
                    echo CHtml::checkBoxList(''.$namaModel."[ruanganasal_nama]", $selects, $ruangan, array('template'=>'<label class="checkbox">{input}{label}</label>', 'separator'=>''));
                }
                else{
                    echo '<label>Data Tidak Ditemukan</label>';
                }
           }
        }
        Yii::app()->end();
    }
    
    // Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
      
    public function actionGetTarifKabupaten($encode=false,$namaModel='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            if($namaModel !=='' && $attr == ''){
                $propinsi_nama = $_POST["$namaModel"]['kepropinsi_nama'];
            }
             elseif ($namaModel == '' && $attr !== '') {
                $propinsi_nama = $_POST["$attr"];
            }
             elseif ($namaModel !== '' && $attr !== '') {
                $propinsi_nama = $_POST["$namaModel"]["$attr"];
            }
            
            //$propinsi = PropinsiM::model()->find("propinsi_nama='$propinsi_nama'");
            $criteria = new CDbCriteria;
            $criteria->compare('propinsi.propinsi_nama',$propinsi_nama);
            $criteria->order = 'kabupaten_nama';
            $kabupaten = KabupatenM::model()->with('propinsi')->findAll($criteria);
            $kabupaten = CHtml::listData($kabupaten,'kabupaten_nama','kabupaten_nama');
            
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
    
    public function actionGetTarifKecamatan($encode=false,$namaModel='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            if($namaModel !=='' && $attr == ''){
                $kabupaten_nama = $_POST["$namaModel"]['kekabupaten_nama'];
            }
             elseif ($namaModel == '' && $attr !== '') {
                $kabupaten_nama = $_POST["$attr"];
            }
             elseif ($namaModel !== '' && $attr !== '') {
                $kabupaten_nama = $_POST["$namaModel"]["$attr"];
            }
            $criteria = new CDbCriteria;
            $criteria->compare('kabupaten.kabupaten_nama',$kabupaten_nama);
            $criteria->order = 'kecamatan_nama ASC';
            $kecamatan = KecamatanM::model()->with('kabupaten')->findAll($criteria);
            $kecamatan = CHtml::listData($kecamatan,'kecamatan_nama','kecamatan_nama');
            
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
    
    public function actionGetTarifKelurahan($encode=false,$namaModel='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            if($namaModel !=='' && $attr == ''){
                $kecamatan_nama = $_POST["$namaModel"]['kekecamatan_nama'];
            }
             elseif ($namaModel == '' && $attr !== '') {
                $kecamatan_nama = $_POST["$attr"];
            }
            elseif ($namaModel !== '' && $attr !== '') {
                $kecamatan_nama = $_POST["$namaModel"]["$attr"];
            }
            $criteria = new CDbCriteria;
            $criteria->compare('kecamatan.kecamatan_nama',$kecamatan_nama);
            $criteria->order = 'kelurahan_nama';
            $kelurahan = KelurahanM::model()->with('kecamatan')->findAll($criteria);
            $kelurahan = CHtml::listData($kelurahan,'kelurahan_nama','kelurahan_nama');
            
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
    
     public function actionGetSubkategori($encode=false,$namaModel='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            if($namaModel !=='' && $attr == ''){
                $jenisobatalkes_id = $_POST["$namaModel"]['jenisobatalkes_id'];
            }
             elseif ($namaModel == '' && $attr !== '') {
                $jenisobatalkes_id = $_POST["$attr"];
            }
             elseif ($namaModel !== '' && $attr !== '') {
                $jenisobatalkes_id = $_POST["$namaModel"]["$attr"];
            }
            $subkategori = SubjenisM::model()->findAll('jenisobatalkes_id='.$jenisobatalkes_id.'ORDER BY subjenis_nama');
            $subkategori = CHtml::listData($subkategori,'subjenis_id','subjenis_nama');
            
            if($encode){
                echo CJSON::encode($subkategori);
            } else {
                if(empty($subkategori)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                } else {
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    foreach($subkategori as $value=>$name) {
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
    
     public function actionGetSubkategoriProduk($encode=false,$namaModel='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            if($namaModel !=='' && $attr == ''){
                $jenisobatalkes_id = $_POST["$namaModel"]['category_id'];
            }
             elseif ($namaModel == '' && $attr !== '') {
                $jenisobatalkes_id = $_POST["$attr"];
            }
             elseif ($namaModel !== '' && $attr !== '') {
                $jenisobatalkes_id = $_POST["$namaModel"]["$attr"];
            }
            $subkategori = SubjenisM::model()->findAll('jenisobatalkes_id='.$jenisobatalkes_id.'ORDER BY subjenis_nama');
            $subkategori = CHtml::listData($subkategori,'subjenis_id','subjenis_nama');
            
            if($encode){
                echo CJSON::encode($subkategori);
            } else {
                if(empty($subkategori)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                } else {
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    foreach($subkategori as $value=>$name) {
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
    
    
    public function actionGetAsalRujukanNama($encode=false, $namaModel = ''){
        if(Yii::app()->request->isAjaxRequest) {
            $asalrujukan_id = $_GET['asalrujukan_id'];
            $asalrujukan_nama = AsalrujukanM::model()->findByAttributes(array('asalrujukan_id'=>$asalrujukan_id));
            $data['nama'] = $asalrujukan_nama->asalrujukan_nama;
            
            echo json_encode($data);
         Yii::app()->end();
        }
    }

    public function actionGetKursUang($encode=false, $namaModel='', $namaField='')
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $mata_uang_id = $_POST[$namaModel][$namaField];
            $listKurs = array();
            if(!empty($mata_uang_id)){
                $query = "SELECT * FROM kursrp_m WHERE matauang_id = " . $mata_uang_id;
                $result = KursrpM::model()->findAllBySql($query);
                $listKurs = CHtml::listData($result,'kursrp_id','nilai');
            }
            
            $option = "";
            if(empty($listKurs))
            {
                $option = CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
            }else{
                if(count((array)$listKurs) > 1)
                {
                    $option = CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }
                
                foreach($listKurs as $value=>$name)
                {
                    $option .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
            }
            echo($option);
        }
        Yii::app()->end();
    }    
    
    public function actionGetKurs()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $data = array();
            
            $mata_uang_id = $_POST['id'];
            $criteria=new CDbCriteria;
            $condition = 'matauang_id = ' . ($mata_uang_id > 0 ? $mata_uang_id : 98989898989898);
            $criteria->addCondition($condition);
            $criteria->compare('kursrp_aktif', true);
            $criteria->order = 'tglkursrp DESC';
            $criteria->limit = 1;
            $result = KursrpM::model()->find($criteria);
            if($result)
            {
                $data = array(
                    'data' => $result->attributes
                );
            }
            echo json_encode($data);
            Yii::app()->end();
        }
    }
    
    public function actionGetInstansiByProfilRs($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $pasienprofilrs_id = $_POST["$namaModel"]['pasienprofilrs_id'];
            
            $instansi = null;
            if(empty($pasienprofilrs_id))
            {
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
            }else{
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                $instansi = InstalasiM::model()->findAll('profilers_id = '. $pasienprofilrs_id .'');
                $instansi = CHtml::listData($instansi,'instalasi_id', 'instalasi_nama');
                foreach($instansi as $value=>$name)
                {
                    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
            }
        }
        Yii::app()->end();
    }

    public function actionGetRuanganForCheckBox($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
           $instalasi_id = $_POST["$namaModel"]['instalasi_id'];
           if($encode){
                if(empty($instalasi_id)){
                    $ruangan = RuanganM::model()->findAll('ruangan_aktif = TRUE and instalasi_id=9999');
                } else {
                    $ruangan = RuanganM::model()->findAll('ruangan_aktif = TRUE and instalasi_id='.$instalasi_id.' ORDER BY ruangan_nama ASC');
                }
                $ruangan = CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
                echo CJSON::encode($ruangan);
           } else {
                if(empty($instalasi_id)){
                    $ruangan = RuanganM::model()->findAll('ruangan_aktif = TRUE and instalasi_id=9999');
                } else {
                    $ruangan = RuanganM::model()->findAll('ruangan_aktif = TRUE and instalasi_id='.$instalasi_id.' ORDER BY ruangan_nama ASC');
                }
                $ruangan = CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
                echo CHtml::hiddenField(''.$namaModel.'[ruangan_id]');
                $i = 0;
                if (count((array)$ruangan) > 0){
                      echo "<div  >".CHtml::checkBox('checkAllRuangan',true, array('onkeypress'=>"return $(this).focusNextInputField(event)",
                                'class'=>'checkbox-column','onclick'=>'checkAll()','checked'=>'checked'))." Pilih Semua";
                      echo "</div>";
                    foreach($ruangan as $value=>$name) {

//                        echo '<label class="checkbox">';
//                        echo CHtml::checkBox(''.$namaModel."[ruangan_id][]", true, array('value'=>$value));
//                        echo '<label for="'.$namaModel.'_ruangan_id_'.$i.'">'.$name.'</label>';
//                        echo '</label>';
                        $selects[] = $value;
                        $i++;
                    }
                    echo CHtml::checkBoxList(''.$namaModel."[ruangan_id]", $selects, $ruangan);
                }
                else{
                    echo '<label>Data Tidak Ditemukan</label>';
                }
           }
        }
        Yii::app()->end();
    }
    
    public function actionGetRuanganAslForCheckBox($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
           $instalasi_id = $_POST["$namaModel"]['instalasiasal_id'];
           if($encode){
                if(empty($instalasi_id)){
                    $ruangan = RuanganM::model()->findAll('ruangan_aktif = TRUE and instalasi_id=9999');
                } else {
                    $ruangan = RuanganM::model()->findAll('ruangan_aktif = TRUE and instalasi_id='.$instalasi_id.' ORDER BY ruangan_nama ASC');
                }
                $ruangan = CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
                echo CJSON::encode($ruangan);
           } else {
                if(empty($instalasi_id)){
                    $ruangan = RuanganM::model()->findAll('ruangan_aktif = TRUE and instalasi_id=9999');
                } else {
                    $ruangan = RuanganM::model()->findAll('ruangan_aktif = TRUE and instalasi_id='.$instalasi_id.' ORDER BY ruangan_nama ASC');
                }
                $ruangan = CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
                echo CHtml::hiddenField(''.$namaModel.'[ruanganasal_id]');
                $i = 0;
                if (count((array)$ruangan) > 0){
                      echo "<div  >".CHtml::checkBox('checkAllRuangan',true, array('onkeypress'=>"return $(this).focusNextInputField(event)",
                                'class'=>'checkbox-column','onclick'=>'checkAll()','checked'=>'checked'))." Pilih Semua";
                      echo "</div>";
                    foreach($ruangan as $value=>$name) {

//                        echo '<label class="checkbox">';
//                        echo CHtml::checkBox(''.$namaModel."[ruangan_id][]", true, array('value'=>$value));
//                        echo '<label for="'.$namaModel.'_ruangan_id_'.$i.'">'.$name.'</label>';
//                        echo '</label>';
                        $selects[] = $value;
                        $i++;
                    }
                    echo CHtml::checkBoxList(''.$namaModel."[ruanganasal_id]", $selects, $ruangan);
                }
                else{
                    echo '<label>Data Tidak Ditemukan</label>';
                }
           }
        }
        Yii::app()->end();
    }
    
    public function actionGetRuangAslForDropCheck($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
           $instalasi_id = $_POST["$namaModel"]['instalasiasal_id'];
           if($encode){
                if(empty($instalasi_id)){
                    $ruangan = RuanganM::model()->findAll('ruangan_aktif = TRUE and instalasi_id=9999');
                } else {
                    $ruangan = RuanganM::model()->findAll('ruangan_aktif = TRUE and instalasi_id='.$instalasi_id.' ORDER BY ruangan_nama ASC');
                }
                $ruangan = CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
                echo CJSON::encode($ruangan);
           } else {
                if(empty($instalasi_id)){
                    $ruangan = RuanganM::model()->findAll('ruangan_aktif = TRUE and instalasi_id=9999');
                } else {
                    $ruangan = RuanganM::model()->findAll('ruangan_aktif = TRUE and instalasi_id='.$instalasi_id.' ORDER BY ruangan_nama ASC');
                }
                $ruangan = CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
               // echo CHtml::hiddenField(''.$namaModel.'[ruanganasal_id]');
                $i = 0;
                if (count((array)$ruangan) > 0){
                    echo "<label class='checkbox inline'>";
                    echo CHtml::checkBox('checkAllRuangan',true, array('onkeypress'=>"return $(this).focusNextInputField(event)"
                                ,'onclick'=>'checkAll()','checked'=>'checked'));
                    echo '<label>Pilih Semua</label>';
                    echo "</label>";
                    foreach($ruangan as $value=>$name) {

//                        
                        //$selects[] = $value;
                        //$i++;
                         echo "<label class='checkbox inline'>";
                    echo CHtml::checkBox(''.$namaModel."[ruanganasal_id][]", true, array('value' =>$value));
                    echo '<label for="'.$namaModel.'ruanganasal_id_'.$i.'">'.$name.'</label>';
                    echo "</label>";
                    }
                   
                }
                else{
                   
                }
           }
        }
        Yii::app()->end();
    }
    
   
    
    public function actionGetNamaRujukanForCheckBox($encode=false,$namaModel=''){
          if(Yii::app()->request->isAjaxRequest) {
           $asalrujukan_id = $_POST["$namaModel"]['asalrujukan_id'];
           if($encode){
                if(empty($asalrujukan_id)){
                    $rujukan = RujukandariM::model()->findAll('asalrujukan_id=9999');
                } else {
                    $rujukan = RujukandariM::model()->findAll('asalrujukan_id='.$asalrujukan_id.' ORDER BY namaperujuk ASC');
                }
                $rujukan = CHtml::listData($rujukan,'namaperujuk','namaperujuk');
                echo CJSON::encode($rujukan);
           } else {
                if(empty($asalrujukan_id)){
                    $rujukan = RujukandariM::model()->findAll('asalrujukan_id=9999');
                } else {
                    $rujukan = RujukandariM::model()->findAll('asalrujukan_id='.$asalrujukan_id.' ORDER BY namaperujuk ASC');
                }
                $rujukan = CHtml::listData($rujukan,'namaperujuk','namaperujuk');
                echo CHtml::hiddenField(''.$namaModel.'[namaperujuk]');
                $i = 0;
                if (count((array)$rujukan) > 0){
                      echo "<div  >".CHtml::checkBox('checkAllRujukan',true, array('onkeypress'=>"return $(this).focusNextInputField(event)",
                                'class'=>'checkbox-column','onclick'=>'checkAllPerujuk()','checked'=>'checked'))." Pilih Semua";
                      echo "</div>";
                    foreach($rujukan as $value=>$name) {

//                        echo '<label class="checkbox">';
//                        echo CHtml::checkBox(''.$namaModel."[ruangan_id][]", true, array('value'=>$value));
//                        echo '<label for="'.$namaModel.'_ruangan_id_'.$i.'">'.$name.'</label>';
//                        echo '</label>';
                        $selects[] = $value;
                        $i++;
                    }
                    echo CHtml::checkBoxList(''.$namaModel."[namaperujuk]", $selects, $rujukan);
                }
                else{
                   // echo '<label>Data Tidak Ditemukan</label>';
                }
           }
        }
        Yii::app()->end();
      }
    
    public function actionGetBidang($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $modBidang = new BidangM;
                if($model_nama !=='' && $attr == ''){
                    $golongan_id = $_POST["$model_nama"]['golongan_id'];
                }
                 elseif ($model_nama == '' && $attr !== '') {
                    $golongan_id = $_POST["$attr"];
                }
                elseif ($model_nama !== '' && $attr !== '') {
                    $golongan_id = $_POST["$model_nama"]["$attr"];
                }
                //var_dump($golongan_id);die;
                $bidang = null;
                if($golongan_id){
                    //var_dump($golongan_id);die;
                    $bidang = $modBidang->getDataBidangItems($golongan_id);
                   
//                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
                    $bidang = CHtml::listData($bidang,'bidang_id','bidang_nama');
                }

                if($encode){
                    echo CJSON::encode($bidang);
                } else {
                    if(empty($bidang)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    }else{
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        foreach($bidang as $value=>$name)
                        {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
                }
            }
            Yii::app()->end();
        }
        
        public function actionGetKelompok($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $modKelompok = new KelompokM;
                if($model_nama !=='' && $attr == ''){
                    $bidang_id = $_POST["$model_nama"]['bidang_id'];
                }
                 elseif ($model_nama == '' && $attr !== '') {
                    $bidang_id = $_POST["$attr"];
                }
                elseif ($model_nama !== '' && $attr !== '') {
                    $bidang_id = $_POST["$model_nama"]["$attr"];
                }
                //var_dump($golongan_id);die;
                $kelompok = null;
                if($bidang_id){
                    //var_dump($golongan_id);die;
                    $kelompok = $modKelompok->getDataKelompokItems($bidang_id);
                   
//                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
                    $kelompok = CHtml::listData($kelompok,'kelompok_id','kelompok_nama');
                }

                if($encode){
                    echo CJSON::encode($kelompok);
                } else {
                    if(empty($kelompok)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    }else{
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        foreach($kelompok as $value=>$name)
                        {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
                }
            }
            Yii::app()->end();
        }
        
        public function actionGetSubKelompok($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $modSubKelompok = new SubkelompokM;
                if($model_nama !=='' && $attr == ''){
                    $kelompok_id = $_POST["$model_nama"]['kelompok_id'];
                }
                 elseif ($model_nama == '' && $attr !== '') {
                    $kelompok_id = $_POST["$attr"];
                }
                elseif ($model_nama !== '' && $attr !== '') {
                    $kelompok_id = $_POST["$model_nama"]["$attr"];
                }
                //var_dump($golongan_id);die;
                $subkelompok = null;
                if($kelompok_id){
                    //var_dump($golongan_id);die;
                    $subkelompok = $modSubKelompok->getDataSubKelompokItems($kelompok_id);
                   
//                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
                    $subkelompok = CHtml::listData($subkelompok,'subkelompok_id','subkelompok_nama');
                }

                if($encode){
                    echo CJSON::encode($subkelompok);
                } else {
                    if(empty($subkelompok)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    }else{
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        foreach($subkelompok as $value=>$name)
                        {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
                }
            }
            Yii::app()->end();
        }
        
        public function actionGetSubSubKelompok($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $modSubSubKelompok = new SubsubkelompokM;
                if($model_nama !=='' && $attr == ''){
                    $subkelompok_id = $_POST["$model_nama"]['subkelompok_id'];
                }
                 elseif ($model_nama == '' && $attr !== '') {
                    $subkelompok_id = $_POST["$attr"];
                }
                elseif ($model_nama !== '' && $attr !== '') {
                    $subkelompok_id = $_POST["$model_nama"]["$attr"];
                }
                //var_dump($golongan_id);die;
                $subsubkelompok = null;
                if($subkelompok_id){
                    //var_dump($golongan_id);die;
                    $subsubkelompok = $modSubSubKelompok->getDataSubSubKelompokItems($subkelompok_id);
                   
//                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
                    $subsubkelompok = CHtml::listData($subsubkelompok,'subsubkelompok_id','subsubkelompok_nama');
                }

                if($encode){
                    echo CJSON::encode($subsubkelompok);
                } else {
                    if(empty($subsubkelompok)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    }else{
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        foreach($subsubkelompok as $value=>$name)
                        {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
                }
            }
            Yii::app()->end();
        }
        
        public function actionGetCaraBayar($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $modCaraBayar = new JenistarifpenjaminM;
                if($model_nama !=='' && $attr == ''){
                    $jenistarif_id = $_POST["$model_nama"]['jenistarif_id'];
                }
                 elseif ($model_nama == '' && $attr !== '') {
                    $jenistarif_id = $_POST["$attr"];
                }
                elseif ($model_nama !== '' && $attr !== '') {
                    $jenistarif_id = $_POST["$model_nama"]["$attr"];
                }
                //var_dump($golongan_id);die;
                $carabayar = null;
                if($jenistarif_id){
                    //var_dump($golongan_id);die;
                    $carabayar = $modCaraBayar->getDataCaraBayarItems($jenistarif_id);
                   
//                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
//                    var_d
                
                    $carabayar = CHtml::listData($carabayar,'carabayar_id','carabayar_nama');
                }

                if($encode){
                    echo CJSON::encode($carabayar);
                } else {
                    if(empty($carabayar)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    }else{
                        if (count((array)$carabayar) > 1):
                            echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        endif;
                        
                        foreach($carabayar as $value=>$name)
                        {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
                }
            }
            Yii::app()->end();
        }
        
        public function actionListRuangan()
        {
                if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                        if(!empty($_POST['instalasi_id'])){
                                $instalasi_id = $_POST['instalasi_id'];
                                $ruangan_id = $_POST['ruangan_id'];
                                $data = RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id),array('order'=>'ruangan_nama ASC'));
                                $data = CHtml::listData($data,'ruangan_id','ruangan_nama');

                                if(empty($data)){
                                        $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
                                }else{
                                            $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);


                                        foreach($data as $value=>$name) {
                                                        $option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                                        }
                                }
                                 $dataList['listRuangan'] = $option;
                                 $dataList['ruangan_id'] = $ruangan_id;
                                 $dataList['instalasi_id'] = $instalasi_id;
                        } else {                               
                                
                             if(!empty($_POST['ruangan_id'])){
                             
                                $ruangan_id = $_POST['ruangan_id'];
                                $instalasi_id = RuanganM::model()->findByPk($ruangan_id)->instalasi_id;
                                
                                $data = RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$instalasi_id),array('order'=>'ruangan_nama ASC'));
                                $data = CHtml::listData($data,'ruangan_id','ruangan_nama');

                                if(empty($data)){
                                        $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
                                }else{
                                            $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);


                                        foreach($data as $value=>$name) {
                                                        $option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                                        }
                                }
                                 $dataList['listRuangan'] = $option;
                                 $dataList['ruangan_id'] = $ruangan_id; 
                                 $dataList['instalasi_id'] = $instalasi_id;
                             }else{
                                 $dataList['listRuangan'] = $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
                                 $dataList['ruangan_id'] = '';
                                 $dataList['instalasi_id'] = '';
                             }
                        }

                        echo json_encode($dataList);
                        Yii::app()->end();
                }
        }
        
        public function actionGetPendKualifikasi($encode=false,$model_nama='',$attr='')
	{
		if(Yii::app()->request->isAjaxRequest) {
			$modPegawai = new PegawaiM;
			if($model_nama !=='' && $attr == ''){
				$pendidikan_id = $_POST["$model_nama"]['pendidikan_id'];
			}
			 elseif ($model_nama == '' && $attr !== '') {
				$pendidikan_id = $_POST["$attr"];
			}
			 elseif ($model_nama !== '' && $attr !== '') {
				$pendidikan_id = $_POST["$model_nama"]["$attr"];
			}
			$pendKualifikasi = null;
			if($pendidikan_id){
				$pendKualifikasi = $modPegawai->getPendKualifikasiItems($pendidikan_id);
				$pendKualifikasi = CHtml::listData($pendKualifikasi,'pendkualifikasi_id','pendkualifikasi_nama');
			}
			if($encode){
				echo CJSON::encode($pendKualifikasi);
			} else {
				if(empty($pendKualifikasi)){
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				} else {
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					foreach($pendKualifikasi as $value=>$name) {
						echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
				}
			}
		}
		Yii::app()->end();
	}
	
	public function actionGetKelompokPegawai($encode=false,$model_nama='',$attr='')
	{
		if(Yii::app()->request->isAjaxRequest) {
			$modPegawai = new PegawaiM;
			if($model_nama !=='' && $attr == ''){
				$pendKualifikasi = $_POST["$model_nama"]['pendkualifikasi_id'];
			}
			 elseif ($model_nama == '' && $attr !== '') {
				$pendKualifikasi = $_POST["$attr"];
			}
			 elseif ($model_nama !== '' && $attr !== '') {
				$pendKualifikasi = $_POST["$model_nama"]["$attr"];
			}
			$kelpegawai = null;
			if($pendKualifikasi){
				$kelpegawai = $modPegawai->getKelPegawaiItems($pendKualifikasi);
				$kelpegawai = CHtml::listData($kelpegawai,'kelompokpegawai_id','kelompokpegawai_nama');
			}
			if($encode){
				echo CJSON::encode($kelpegawai);
			} else {
				if(empty($kelpegawai)){
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				} else {
					if(count((array)$kelpegawai) > 1){
						echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					}
					foreach($kelpegawai as $value=>$name) {
						echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
				}
			}
		}
		Yii::app()->end();
	}
        
        public function actionGetKlasifikasiKode($encode=false,$model_nama='',$attr='')
        {
            if(Yii::app()->request->isAjaxRequest) {
                $modKlasifikasi = new KlasifikasidiagnosaM;
                if($model_nama !=='' && $attr == ''){
                    $dtd_id = $_POST["$model_nama"]['dtd_id'];
                }
                 elseif ($model_nama == '' && $attr !== '') {
                    $dtd_id = $_POST["$attr"];
                }
                 elseif ($model_nama !== '' && $attr !== '') {
                    $dtd_id = $_POST["$model_nama"]["$attr"];
                }
                $klasifikasi = null;
                if($dtd_id){
                    $klasifikasi = $modKlasifikasi->getKlasifikasiKodeItems($dtd_id);
                    $klasifikasi = CHtml::listData($klasifikasi,'klasifikasidiagnosa_id','KlasifikasiKodeNama');
                                        
                }
                if($encode){
                    echo CJSON::encode($klasifikasi);
                } else {
                    if(empty($klasifikasi)){
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    } else {
                        
                        if (count((array)$klasifikasi)>1){
                            echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        }elseif (count((array)$klasifikasi)==0){
                            echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                        }
                        
                        foreach($klasifikasi as $value=>$name) {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                    }
                }
            }
            Yii::app()->end();
        }
        
        public function actionGetPegawaiRuangan($encode=false,$namaModel='',$attr='')
        {
        if(Yii::app()->request->isAjaxRequest) {
            $ruangan_id = (empty($namaModel))?$_POST["$namaModel"]['ruanganpengirim_id']:$_POST["$namaModel"][$attr];
            
            $ruangan = [];
            if (!empty($ruangan_id)){
                $ruangan = PegawairuanganV::model()->findAll('ruangan_id='.$ruangan_id.' and pegawai_aktif = true ORDER BY nama_pegawai ASC');            
                $ruangan=CHtml::listData($ruangan,'pegawai_id','namaLengkap');
            }
            
            if(empty($ruangan)){
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
            }else{
                if (count((array)$ruangan) > 1){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }elseif (count((array)$ruangan) == 0){                
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }
                foreach($ruangan as $value=>$name)
                {
                    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
            }
        }
        Yii::app()->end();
    }   
    
    public function actionGetKondisiKeluar($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $carakeluar_id = $_POST["$namaModel"]['carakeluar_id'];

           if($encode)
           {
                if(empty($carakeluar_id)){
                    $kondisikeluar = array();
                } else {
                    $kondisikeluar = KondisiKeluarM::model()->findAllByAttributes(array('carakeluar_id'=>$carakeluar_id,'kondisikeluar_aktif'=>true), array('order'=>'kondisikeluar_nama ASC'));
                    $kondisikeluar = CHtml::listData($kondisikeluar,'kondisikeluar_id','kondisikeluar_nama');
                }
                echo CJSON::encode($kondisikeluar);
           } else {
                if(empty($carakeluar_id)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                } else {
                    $kondisikeluar = KondisiKeluarM::model()->findAllByAttributes(array('carakeluar_id'=>$carakeluar_id,'kondisikeluar_aktif'=>true), array('order'=>'kondisikeluar_nama ASC'));
                    if(count((array)$kondisikeluar) > 1)
                    {
                        echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    }
                    $kondisikeluar = CHtml::listData($kondisikeluar,'kondisikeluar_id','kondisikeluar_nama');
                    foreach($kondisikeluar as $value=>$name) {
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
           }
        }
        Yii::app()->end();
    }
	
	public function actionGetRuanganByMultiSelect()
	{
        if(Yii::app()->request->isAjaxRequest) {
            $dataRuangan = array();
			$instalasi_id = !empty($_POST['instalasi_id'])?$_POST['instalasi_id']:null;			
			
			$cri = new CDbCriteria();			
			$cri->addCondition("ruangan_aktif = TRUE");
			if (!empty($instalasi_id)){
				$cri->addInCondition("instalasi_id",$instalasi_id);
			}
			$cri->order = "ruangan_nama ASC";
			
            
			$ruangan = RuanganM::model()->findAll($cri);                        
			$val = array();
			$val['ruangan'] = '';
			
			
			if (!empty($instalasi_id)){
				$data = CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
			}else{
				$data = null;
			}

            if(count((array)$data) > 0){               
				$val['sukses'] = 1;
                foreach($data as $value=>$name)
                {
                    $val['ruangan'] .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					
                }
			}else{
				$val['sukses'] = 1;
			}
			
			 echo CJSON::encode($val);
        }
        Yii::app()->end();
    }  

    public function actionGetJenisKasusPenyakitByInstalasiMultiselect()
	{
        if(Yii::app()->request->isAjaxRequest) {
            $dataRuangan = array();
			$instalasi_id = !empty($_POST['instalasi_id'])?$_POST['instalasi_id']:null;			
			
			$cri = new CDbCriteria();			
			$cri->join = "JOIN kasuspenyakitruangan_m ON t.jeniskasuspenyakit_id = kasuspenyakitruangan_m.jeniskasuspenyakit_id JOIN ruangan_m ON ruangan_m.ruangan_id = kasuspenyakitruangan_m.ruangan_id";
            if (!empty($instalasi_id)){
                $cri->addInCondition('ruangan_m.instalasi_id', $instalasi_id);
            }
            $cri->addCondition('ruangan_m.ruangan_aktif = true ');
			$cri->addCondition('t.jeniskasuspenyakit_aktif = true');
		    $cri->order = "t.jeniskasuspenyakit_nama ASC";
            
			$dataJenisKasus = JeniskasuspenyakitM::model()->findAll($cri);                        
			$val = array();
			$val['spesialis'] = '';
			
			
			if (!empty($instalasi_id)){
				$data = CHtml::listData($dataJenisKasus,'jeniskasuspenyakit_id','jeniskasuspenyakit_nama');
			}else{
				$data = null;
			}

            if(count((array)$data) > 0){               
				$val['sukses'] = 1;
                foreach($data as $value=>$name)
                {
                    $val['spesialis'] .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					
                }
			}else{
				$val['sukses'] = 1;
			}
			
			 echo CJSON::encode($val);
        }
        Yii::app()->end();
    }

    public function actionGetRuanganByJenisKasusPenyakitMultiselect()
	{
        if(Yii::app()->request->isAjaxRequest) {
            $dataRuangan = array();
			$jeniskasuspenyakit_id = !empty($_POST['jeniskasuspenyakit_id'])?$_POST['jeniskasuspenyakit_id']:null;			
			$instalasi_id = !empty($_POST['instalasi_id'])?$_POST['instalasi_id']:null;			
			
			$cri = new CDbCriteria();			
			$cri->join = "JOIN kasuspenyakitruangan_m kpr ON t.ruangan_id = kpr.ruangan_id";
            if (!empty($jeniskasuspenyakit_id)){
                $cri->addInCondition('kpr.jeniskasuspenyakit_id', $jeniskasuspenyakit_id);
            }
            if (!empty($instalasi_id)){
                $cri->addInCondition('t.instalasi_id', $instalasi_id);
            }
            $cri->addCondition('t.ruangan_aktif = true ');
			
		    $cri->order = "t.ruangan_nama ASC";
            
			$ruangan = RuanganM::model()->findAll($cri);                        
			$val = array();
			$val['ruangan'] = '';
			
			
			if (!empty($jeniskasuspenyakit_id)){
				$data = CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
			}else{
				$data = null;
			}

            if(count((array)$data) > 0){               
				$val['sukses'] = 1;
                foreach($data as $value=>$name)
                {
                    $val['ruangan'] .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					
                }
			}else{
				$val['sukses'] = 1;
			}
			
			 echo CJSON::encode($val);
        }
        Yii::app()->end();
    }

    public function actionGetRuanganBySingleSelect()
	{
        if(Yii::app()->request->isAjaxRequest) {
            $dataRuangan = array();
			$instalasi_id = !empty($_POST['instalasi_id'])?$_POST['instalasi_id']:null;			
			
			$cri = new CDbCriteria();			
			$cri->addCondition("ruangan_aktif = TRUE");
			if (!empty($instalasi_id)){
				$cri->addCondition("instalasi_id=".$instalasi_id);
			}
			$cri->order = "ruangan_nama ASC";
			
            
			$ruangan = RuanganM::model()->findAll($cri);                        
			$val = array();
			$val['ruangan'] = '';
			
			
			if (!empty($instalasi_id)){
				$data = CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
			}else{
				$data = null;
			}

            if(count((array)$data) > 0){               
				$val['sukses'] = 1;
                foreach($data as $value=>$name)
                {
                    $val['ruangan'] .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					
                }
			}else{
				$val['sukses'] = 1;
			}
			
			 echo CJSON::encode($val);
        }
        Yii::app()->end();
    }  
	
	/**
	 * @author	M Iqbal Laksana <iqbal.laksana@piindonesia.coo.id>
	 * - digunakan untuk mengenerate data supplier, ke dalam bentuk dropdown multiselect, dengan patokan supplier_jenis yang juga multiselect
	 */
	public function actionGetSupplierMultiSelectByJenis()
	{
        if(Yii::app()->request->isAjaxRequest) {
            $dataRuangan = array();
			$supplier_jenis = !empty($_POST['supplier_jenis'])?$_POST['supplier_jenis']:null;			
			
			$cri = new CDbCriteria();			
			$cri->addCondition("supplier_aktif = TRUE");
			if (!empty($supplier_jenis)){
				$cri->addInCondition("LOWER(supplier_jenis)",$supplier_jenis);
			}
			$cri->order = "supplier_nama ASC";
			
            
			$ruangan = SupplierM::model()->findAll($cri);                        
			
		//	var_dump($supplier_jenis);
			$val = '';
			$val['ruangan'] = '';
			

            $data = CHtml::listData($ruangan,'supplier_id','supplier_nama');

            if(count((array)$data) > 0){               
				$val['sukses'] = 1;
                foreach($data as $value=>$name)
                {
                    $val['ruangan'] .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					
                }
			}
			
			 echo CJSON::encode($val);
        }
        Yii::app()->end();
    }
	
	
	
	public function actionGetNamaRujukanByMultiSelect()
	{
        if(Yii::app()->request->isAjaxRequest) {
            $dataRuangan = array();
			$asalrujukan_id = !empty($_POST['asalrujukan_id'])?$_POST['asalrujukan_id']:null;			
			
			$cri = new CDbCriteria();			
			//$cri->addCondition("ruangan_aktif = TRUE");
			if (!empty($asalrujukan_id)){
				$cri->addInCondition("asalrujukan_id",$asalrujukan_id);
			}
			$cri->order = "namaperujuk ASC";
			           
			$namaperujuk = RujukandariM::model()->findAll($cri);                        
			$val = '';
			$val['namaperujuk'] = '';						
				
            $data = CHtml::listData($namaperujuk,'namaperujuk','namaperujuk');

            if(count((array)$data) > 0){               
				$val['sukses'] = 1;
                foreach($data as $value=>$name)
                {
                    $val['namaperujuk'] .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					
                }
			}
			
			 echo CJSON::encode($val);
        }
        Yii::app()->end();
    }         
	
	public function actionGetPenjaminByMultiSelect()
	{
        if(Yii::app()->request->isAjaxRequest) {
            $dataRuangan = array();
			$carabayar_id = !empty($_POST['carabayar_id'])?$_POST['carabayar_id']:null;			
			
			$cri = new CDbCriteria();			
			$cri->addCondition("penjamin_aktif = TRUE");
			if (!empty($carabayar_id)){
				$cri->addInCondition("carabayar_id",$carabayar_id);
			}
			$cri->order = "penjamin_nama ASC";
			
            
			$penjamin = PenjaminpasienM::model()->findAll($cri);                        
			$val = [];
			$val['penjamin'] = '';
			

            $data = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');

            if(count((array)$data) > 0){               
				$val['sukses'] = 1;
                foreach($data as $value=>$name)
                {
                    $val['penjamin'] .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					
                }
			}
			
			 echo CJSON::encode($val);
        }
        Yii::app()->end();
    }
	
	public function actionGetRuanganAsalByMultiSelect()
	{
        if(Yii::app()->request->isAjaxRequest) {
            $dataRuangan = array();
			$instalasiasal_nama = !empty($_POST['instalasiasal_nama'])?$_POST['instalasiasal_nama']:null;			
					
			
			$cri = new CDbCriteria();			
			$cri->addCondition("ruangan_aktif = TRUE");
			if (!empty($instalasiasal_nama)){
				$cri->join = " JOIN instalasi_m i ON i.instalasi_id = t.instalasi_id ";
				$cri->addInCondition("i.instalasi_nama",$instalasiasal_nama);
			}
			$cri->order = "ruangan_nama ASC";
			
            
			$ruanganasal_nama = RuanganM::model()->findAll($cri);                        
			$val = '';
			$val['ruangan_nama'] = '';
			

            $data = CHtml::listData($ruanganasal_nama,'ruangan_nama','ruangan_nama');

            if(count((array)$data) > 0){               
				$val['sukses'] = 1;
                foreach($data as $value=>$name)
                {
                    $val['ruangan_nama'] .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					
                }
			}
			
			 echo CJSON::encode($val);
        }
        Yii::app()->end();
    }
	
	public function actionGetKabupatenByMultiSelect()
	{
        if(Yii::app()->request->isAjaxRequest) {
            $dataRuangan = array();
			$propinsi_id = !empty($_POST['propinsi_id'])?$_POST['propinsi_id']:null;			
			
			$cri = new CDbCriteria();			
			$cri->addCondition("kabupaten_aktif = TRUE");
			if (!empty($propinsi_id)){
				$cri->addInCondition("propinsi_id",$propinsi_id);
			}
			$cri->order = "kabupaten_nama ASC";
			
            
			$kabupaten = KabupatenM::model()->findAll($cri);                        
			$val = '';
			$val['kabupaten'] = '';
			

            $data = CHtml::listData($kabupaten,'kabupaten_id','kabupaten_nama');

            if(count((array)$data) > 0){               
				$val['sukses'] = 1;
                foreach($data as $value=>$name)
                {
                    $val['kabupaten'] .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					
                }
			}
			
			 echo CJSON::encode($val);
        }
        Yii::app()->end();
    }

    public function actionGetTindakanDariRuanganByMultiSelect()
	{
        if(Yii::app()->request->isAjaxRequest) {
            $dataRuangan = array();
			$ruangan_id = !empty($_POST['ruangan_id'])?$_POST['ruangan_id']:null;			
			
			$cri = new CDbCriteria();
            $cri->join = 'JOIN daftartindakan_m as d ON d.daftartindakan_id = t.daftartindakan_id';
			$cri->addCondition("d.daftartindakan_aktif = TRUE");
			if (!empty($ruangan_id)){
				$cri->addInCondition("t.ruangan_id",$ruangan_id);
			}
			$cri->order = "d.daftartindakan_nama ASC";
			
            
			$tindakan = TindakanruanganM::model()->with('daftartindakan')->findAll($cri);
			$val = array();
			$val['daftartindakan'] = '';
			
			
			if (!empty($ruangan_id)){
                $data = CHtml::listData($tindakan,'daftartindakan_id','daftartindakan.daftartindakan_nama');
			}else{
                $data = null;
			}
            // echo '<pre>'; var_dump($data); die;                        

            if(count((array)$data) > 0){               
				$val['sukses'] = 1;
                foreach($data as $value=>$name)
                {
                    $val['daftartindakan'] .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
			}else{
				$val['sukses'] = 1;
			}
			
			 echo CJSON::encode($val);
        }
        Yii::app()->end();
    }
    
    public function actionGetRujukanDari($encode=false,$namaModel='', $prefix='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $asalrujukan_id = $_POST["$namaModel"][$prefix.'asalrujukan_id'];
            
           if($encode) {
                if(empty($asalrujukan_id)){
                    $rujukandari = array();
                } else {
                    $rujukandari = RujukandariM::model()->findAllByAttributes(array('asalrujukan_id'=>$asalrujukan_id), array('order'=>'namaperujuk'));
                    $rujukandari = CHtml::listData($rujukandari,'rujukandari_id','namaperujuk');
                }
                echo CJSON::encode($rujukandari);
           } else {
                if(empty($asalrujukan_id)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                } else {
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                    $rujukandari = RujukandariM::model()->findAllByAttributes(array('asalrujukan_id'=>$asalrujukan_id), array('order'=>'namaperujuk'));
                    $rujukandari = CHtml::listData($rujukandari,'rujukandari_id','namaperujuk');
                    foreach($rujukandari as $value=>$name) {
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                        
                }
           }
        }
        Yii::app()->end();
    }
	
	public function actionSetDropdownRuangan($encode=false,$model_nama='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $instalasi_id = null;
            if($model_nama !=='' && $attr == ''){
                $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
            }
             else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            }
             else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id),'ruangan_id','ruangan_nama');

            if($encode){
                echo CJSON::encode($models);
            } else {
                if (count((array)$models) > 1){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }elseif (count((array)$models) == 0){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }
                
                if(count((array)$models) > 0){
                    foreach($models as $value=>$name){
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
	
	/*
	* Mencari Ruangan berdasarkan instalasireseptur_id di tabel kelas Ruangan M
	* 
	*/
    public function actionGetRuangResepturDariInsReseptur($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $instalasi = $_POST["$namaModel"]['instalasireseptur_id'];
			if (!empty($instalasi)){
				$ruangan = RuanganM::model()->findAll('instalasi_id='.$instalasi.' and ruangan_aktif = true');

				$ruangan=CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
			}else{
				$ruangan = array();
			}
            
            if(empty($ruangan)){
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
            }else{
                if (count((array)$ruangan) > 1){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }elseif (count((array)$ruangan) == 0){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }
                foreach($ruangan as $value=>$name)
                {
                    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
            }
        }
        Yii::app()->end();
    }
	
	/*
	* Mencari Ruangan berdasarkan instalasireseptur_id di tabel kelas Ruangan M
	* 
	*/
    public function actionGetRuangDaftarDariInsDaftar($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $instalasi = $_POST["$namaModel"]['instalasipendaftaran_id'];
			if (!empty($instalasi)){
				$ruangan = RuanganM::model()->findAll('instalasi_id='.$instalasi.' and ruangan_aktif = true');

				$ruangan=CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
			}else{
				$ruangan = array();
			}
            
            if(empty($ruangan)){
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
            }else{
                if (count((array)$ruangan) > 1){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }elseif (count((array)$ruangan) == 0){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }
                foreach($ruangan as $value=>$name)
                {
                    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
            }
        }
        Yii::app()->end();
    }
	
	/*
	* Mencari Ruangan berdasarkan instalasiakhir_id 
	* 
	*/
    public function actionGetRuangAkhirDariInsAkhir($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $instalasi = $_POST["$namaModel"]['instalasiakhir_id'];
			if (!empty($instalasi)){
				$ruangan = RuanganM::model()->findAll('instalasi_id='.$instalasi.' and ruangan_aktif = true');

				$ruangan=CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
			}else{
				$ruangan = array();
			}
            
            if(empty($ruangan)){
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
            }else{
                if (count((array)$ruangan) > 1){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }elseif (count((array)$ruangan) == 0){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                }
                foreach($ruangan as $value=>$name)
                {
                    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
            }
        }
        Yii::app()->end();
    }
	
	/**
	 * - digunakan untuk mengenerate dari kamar ruangan berdasarkan kelaspelayanan
	 * @param type $encode
	 * @param type $namaModel
	 */
	public function actionGetKamarRuanganByKelas($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
			//var_dump($namaModel);die;
			//die;
            $kelasPelayanan_id = $_POST['kelaspelayanan_id'];
						
           if($encode) {
                if(empty($kelasPelayanan_id)){
                    $kamarRuangan = array();
                } else {
                    $kamarRuangan = KamarruanganM::model()->findAllByAttributes(array('kelaspelayanan_id'=>$kelasPelayanan_id));
                    $kamarRuangan = CHtml::listData($kamarRuangan,'kamarruangan_id','KamarDanTempatTidurPolos');
                    
                }
                echo CJSON::encode($kamarRuangan);
           } else {
                if(empty($kelasPelayanan_id)){
                    echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                } else {
                        
                        $kamarRuangan = KamarruanganM::model()->findAllByAttributes(array('kelaspelayanan_id'=>$kelasPelayanan_id));
						
						if (count((array)$kamarRuangan)>1){
							echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
						}elseif(count((array)$kamarRuangan) == 0){
							echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
						}
						
                        $kamarRuangan = CHtml::listData($kamarRuangan,'kamarruangan_id','KamarDanTempatTidurPolos');
                        foreach($kamarRuangan as $value=>$name) {
                            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                        }
                }
           }
        }
        Yii::app()->end();
    }
    
    public function actionGetRuanganItemsnew($ruangan_id='')
        {
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
           
            
            if(!empty($ruangan_id)){
               $ruangan=intval($ruangan_id);
			
            }
            $modRuangan = RuanganM::model()->findByPk($ruangan_id);
          
            $dataList['Ruangan']=$modRuangan->ruangan_nama;
            echo json_encode($dataList);
            Yii::app()->end();
            }   
        }
          public function actionSetDropdownRuangannew($instalasasi='')
   {
      
       if(Yii::app()->getRequest()->getIsAjaxRequest()) {
           
           
           
           $option = CHtml::tag('option',array('value'=>''),CHtml::encode('-- Pilih --'),true);
           if(!empty($instalasasi)){
               
               $data = $this->getRuanganItems($instalasasi);
               $data = CHtml::listData($data,'ruangan_id','ruangan_nama');
               foreach($data as $value=>$name){
                       $option .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
               }
           } 
           $dataList['listRuangan'] = $option;
           echo json_encode($dataList);
           Yii::app()->end();
       }
   }
   
     public function getRuanganItems($instalasi_id='')
        {
            $criteria = new CDbCriteria();
            if(!empty($instalasi_id)){
                    $criteria->addCondition("instalasi_id= ".$instalasi_id);			
            }
            $criteria->addCondition('ruangan_aktif = true');
            
           
            $modRuangan = RuanganM::model()->findAll($criteria);
            return $modRuangan;
        }


        public function actionGetAlatMakanan(){
            if(Yii::app()->request->isAjaxRequest) {
               $kelaspelayanan_id = $_POST['kelaspelayanan_id'];	
                                       
               $drop = CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
               if (!empty($kelaspelayanan_id)){
                   $alatmakanan = AlatmakananM::model()->findAllByAttributes(array('kelaspelayanan_id'=>$kelaspelayanan_id,'alatmakanan_aktif'=>true));
                   if (!empty($alatmakanan)){                
                       foreach($alatmakanan as $det){
                           $drop .= CHtml::tag('option', array('value'=>$det->alatmakanan_id),CHtml::encode($det->alatmakanan_nama),true);
                       }
                   }
               }
               
               $data['sukses'] = 1;
               $data['drop'] = $drop;
               
               echo json_encode($data);
           }
           Yii::app()->end();
        }
	
}
?>
