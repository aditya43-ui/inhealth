<?php

/**
 * This is the model class for table "pengajuanpegawai_t".
 *
 * The followings are the available columns in table 'pengajuanpegawai_t':
 * @property integer $pengajuanpegawai_t_id
 * @property string $tglpengajuan
 * @property string $nopengajuan
 * @property integer $mengajukan_id
 * @property integer $mengetahui_id
 * @property string $keterangan
 * @property integer $menyetujui_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 *
 * The followings are the available model relations:
 * @property PengpegawaidetT[] $pengpegawaidetTs
 */
class KPInfopengajuanpegawaiV extends InfopengajuanpegawaiV
{
    public $tgl_awal, $tgl_akhir;
   
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function searchInformasi()
    {
        $criteria = new CDbCriteria();
        
        $criteria->addBetweenCondition('DATE(tglpengajuan)', $this->tgl_awal, $this->tgl_akhir);        
        
        if (!empty($this->nopengajuan)){
            $criteria->addCondition("LOWER(nopengajuan) ILIKE '%".strtolower($this->nopengajuan)."%' ");
        }
        
        if (!empty($this->id_pegmengetahui)){
            $criteria->addCondition("id_pegmengetahui =".$this->id_pegmengetahui);
        }
        
        if (!empty($this->id_pegmengajukan)){
            $criteria->addCondition("id_pegmengajukan =".$this->id_pegmengajukan);
        }
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        
    }
    
    public function getPegawaiRuangan()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition("pegawai_aktif = TRUE");
        $criteria->addCondition("ruangan_id = ".Yii::app()->user->getState('ruangan_id'));
        $criteria->order = "nama_pegawai ASC";
        
        return KPPegawairuanganV::model()->findAll($criteria);
    }
    
    
           
}
?>
