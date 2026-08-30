<?php 

class SALogpembatalanolehuserV extends LogaudittrailV
{
    public $tgl_awal, $tgl_akhir;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function searchInformasi()
    {
        $criteria=new CDbCriteria;

		$criteria->compare('id_log',$this->id_log);
		$criteria->compare('jenislog',$this->jenislog,true);
		$criteria->compare('keterangan_log',$this->keterangan_log,true);
		$criteria->addBetweenCondition('DATE(tgl_log)',$this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('loginpemakai_id',$this->loginpemakai_id,true);
		$criteria->compare('nama_pemakai',$this->nama_pemakai,true);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
    }
}
