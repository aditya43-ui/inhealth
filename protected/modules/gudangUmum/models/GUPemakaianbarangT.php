<?php
class GUPemakaianbarangT extends PemakaianbarangT
{
    public $pegawai_nama;
    public $stok;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function searchInformasi() {
        $criteria = new CDbCriteria;
        
        $criteria->compare('pemakaianbarang_id',$this->pemakaianbarang_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('nopemakaianbrg',$this->nopemakaianbrg,true);
		$criteria->compare('untukkeperluan',$this->untukkeperluan,true);
		$criteria->compare('keteranganpakai',$this->keteranganpakai,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
        
        if (!empty($this->tglAwal) && !empty($this->tglAkhir)) {
            $criteria->addBetweenCondition('tglpemakaianbrg::date', $this->tglAwal, $this->tglAkhir);
        }
        
        

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        
    }
}