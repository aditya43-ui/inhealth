<?php
/**
 * - digunakan sebagai informasi penerimaan kantong darah
 * @author     Elham Budianto <elhambudianto1@gmail.com>
 * @author     Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author     Yusuf Putra Anugrah <yusufputra@.com>
 * @package    application.modules.bankDarah
 * @subpackage controllers
**/
class InformasiPenerimaanDarahController extends MyAuthController
{    
    /**
     * Menampilkan informasi penerimaan darah
     */
    public function actionIndex(){
        
        $model = new BDInfoterimakantongdarahV;
        
        
        $model->tgl_awal= date("Y-m-d");
        $model->tgl_akhir= date("Y-m-d");        
        if (isset($_GET['BDInfoterimakantongdarahV'])){
            $model->attributes = $_GET['BDInfoterimakantongdarahV'];    
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BDInfoterimakantongdarahV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BDInfoterimakantongdarahV']['tgl_akhir']);
        }
        $this->render('index',
            array(
                'model'=>$model,
            )
        );
    }
    
    /**
     * Menampilkan detail penerimaan kantong darah.
     * 
     * @param integer $terimakantongdarah_id
     */
    public function actionLihatDetail($terimakantongdarah_id){
        $this->layout = "//layouts/iframe";
        
        $model = InfoterimakantongdarahV::model()->find('terimakantongdarah_id='.$terimakantongdarah_id);
        $tanggal= MyFormatter::formatDateTimeForUser($model->tglterimakantong);
        $model->tglterimakantong=$tanggal;  
        $cri=new CDbCriteria;
        $cri->select="daftardonasi_id,terimakantongdarah_id,no_identitas,no_formulir,nomorbarcode_utama,nomorbarcode_sample,gol_darah,rhesus,nama_jenis";
        $cri->group=$cri->select;
        $cri->addCondition('t.terimakantongdarah_id='.$terimakantongdarah_id);
        
        $detail = InfokantongdarahV::model()->findAll($cri);
        $this->render('detail',array('model'=>$model,'detail'=>$detail));
    }
    
    /**
     * Membatalkan penerimaan kantong darah.
     * 
     * Sebelum dilakukan pembatalan, terlebih dahulu diperiksa apakah salah satu
     * dari kantong darah telah dilakukan pengujian.
     * 
     * Jika belum, maka bisa dibatalkan. Begitu juga sebaliknya.
     */
    public function actionBatalTerima() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $id = $_POST['id'];
        $ok = 1;
        $msg = "Pengiriman kantong darah berhasil dibatalkan";
        
        
        // list kantong darah
        $kantong = KantongdarahT::model()->findAllByAttributes(array(
            'terimakantongdarah_id'=>$_POST['id']
        ));
        
        $sudah_diuji = false;
        foreach ($kantong as $item) {
            if (!empty($item->skriningimltd_id)
                || !empty($item->periksakomponendarah_id)
                || !empty($item->pengujiandarah_id)) {
                $sudah_diuji = true;
            }
        }
        
        if ($sudah_diuji) {
            $ok = 0;
            $msg = "Batal terima kantong darah tidak dapat dilakukan.<br/>"
                . "Kantong Darah sudah dilakukan pengujian.";
            
            echo CJSON::encode(array('ok'=>$ok, 'msg'=>$msg));
            Yii::app()->end();
        }
        
        // hapus terima darah
        
        $trans = Yii::app()->db->beginTransaction();
        
        try {
            foreach ($kantong as $item) {
                $item->terimakantongdarah_id = null;
                $item->save();
            }

            TerimakantongdetT::model()->deleteAllByAttributes(array(
                'terimakantongdarah_id'=>$id,
            ));

            TerimakantongdarahT::model()->deleteByPk($id);
            
            $trans->commit();
 
        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Batal terima kantong darah tidak dapat dilakukan.<br/>"
                . $ex->getMessage();
            
            echo CJSON::encode(array('ok'=>$ok, 'msg'=>$msg));
            Yii::app()->end();
        }
        
        
        echo CJSON::encode(array('ok'=>$ok, 'msg'=>$msg));
        Yii::app()->end();
    }

}