<?php
/**
*       - controller ini untuk extends ke controller cuti pegawai
*       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
*       @website	<piindonesia.co.id>
*/

Yii::import('rawatInap.models.*');
Yii::import('rawatInap.controllers.EResepController');
class EResepHDController extends EResepController{
    
    public $init_modul='HD';
    
    /**
     * untuk load data pasien setelah di pilih no rekam medik
     */
    public function actionLoadDataPasien()
    {
        if(Yii::app()->request->isAjaxRequest){
            $data = HDInfoKunjunganRDV::model()->findByAttributes(array('pendaftaran_id'=>$_POST['pendaftaran_id']));
                        
            $criRiwayat = new CDbCriteria();
            $criRiwayat->select = "t.tglreseptur, t.noresep, pegawai_id, t.reseptur_id, t.pendaftaran_id";
            $criRiwayat->join = " JOIN eresep_t e ON e.reseptur_id = t.reseptur_id ";
            $criRiwayat->addCondition(" pendaftaran_id = '".$data->pendaftaran_id."' AND ruanganreseptur_id = '".Yii::app()->user->getState('ruangan_id')."' ");
            $criRiwayat->group = $criRiwayat->select;
            $criRiwayat->order = " t.create_time DESC ";
            
            $modRiwayatResep = ResepturT::model()->findAll($criRiwayat);         
            
            $diagnosa = PasienmorbiditasT::model()->find("pendaftaran_id = '".$_POST['pendaftaran_id']."' AND kelompokdiagnosa_id = '".Params::KELOMPOKDIAGNOSA_UTAMA."' ");
            
            $post = array(
                'tgl_pendaftaran'=>MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran),
                'no_pendaftaran'=>$data->no_pendaftaran,
                'umur'=>$data->umur,
                'jeniskasuspenyakit_nama'=>$data->jeniskasuspenyakit_nama,
                'instalasi_nama' => $data->instalasi_nama,
                'ruangan_nama'=>$data->ruangan_nama,
                'pendaftaran_id'=>$data->pendaftaran_id,
                'pasien_id'=>$data->pasien_id,
                'jeniskelamin'=>$data->jeniskelamin,
                'statusperkawinan'=>$data->statusperkawinan,
                'nama_pasien'=>$data->namadepan.$data->nama_pasien,
                'nama_bin'=>$data->nama_bin,
                'kamarruangan_nokamar'=>'',
                'kamarruangan_nobed'=>'',
                'kelaspelayanan_nama'=>$data->kelaspelayanan_nama,
                'carabayar_nama'=>$data->carabayar_nama,
                'penjamin_nama'=>$data->penjamin_nama,
                'no_rekam_medik'=>$data->no_rekam_medik,
                'pendaftaran_id'=>$data->pendaftaran_id,
                'diagnosa' => !(empty($diagnosa))?$diagnosa->diagnosa->diagnosa_nama:''
            );
                                   
            
            $post['riwayat'] = $this->renderPartial($this->path_view.'_listResep',array(
                                'modRiwayatResep'=>$modRiwayatResep,
                                ),true);
            //$post['riwayat'] = '';
            
            
            
            echo CJSON::encode($post);
            Yii::app()->end();
        }
    }
}

?>
