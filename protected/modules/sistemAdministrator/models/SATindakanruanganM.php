<?php

class SATindakanruanganM extends TindakanruanganM
{
    public $instalasi_id,$instalasi_nama,$ruangan_nama,$komponenunit_nama, $daftartindakan_nama;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TabularlistM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->with = array('ruangan','daftartindakan','daftartindakan.kategoritindakan','daftartindakan.kelompoktindakan','daftartindakan.komponenunit');
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('t.daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(ruangan.ruangan_nama)',  strtolower($this->ruangan_nama), true);
		$criteria->compare('LOWER(kelompoktindakan.kelompoktindakan_nama)',  strtolower($this->kelompoktindakan_nama), true);
		$criteria->compare('LOWER(kategoritindakan.kategoritindakan_nama)',  strtolower($this->kategoritindakan_nama), true);
                $criteria->compare('LOWER(komponenunit.komponenunit_nama)',  strtolower($this->komponenunit_nama), true);
		$criteria->compare('LOWER(daftartindakan.daftartindakan_kode)',  strtolower($this->daftartindakan_kode), true);
		$criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',  strtolower($this->daftartindakan_nama), true);
                $criteria->order = "daftartindakan.daftartindakan_nama ASC, kelompoktindakan.kelompoktindakan_nama ASC";
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort' => array(
                          'attributes' => array(
                              'kelompoktindakan_nama' => array(
                                  'asc' => 'kelompoktindakan.kelompoktindakan_nama ASC',
                                  'desc' => 'kelompoktindakan.kelompoktindakan_nama DESC',
                                ),
                               'kategoritindakan_nama' => array(
                                  'asc' => 'kategoritindakan.kategoritindakan_nama ASC',
                                  'desc' => 'kategoritindakan.kategoritindakan_nama DESC',
                                ),
                              'komponenunit_nama' => array(
                                  'asc' => 'komponenunit.komponenunit_nama ASC',
                                  'desc' => 'komponenunit.komponenunit_nama DESC',
                                ),
                               'daftartindakan_kode' => array(
                                  'asc' => 'daftartindakan.daftartindakan_kode ASC',
                                  'desc' => 'daftartindakan.daftartindakan_kode DESC',
                                ),
                                'daftartindakan_nama' => array(
                                  'asc' => 'daftartindakan.daftartindakan_nama ASC',
                                  'desc' => 'daftartindakan.daftartindakan_nama DESC',
                                ),
                                '*',
                              
                          )  
                        ),
		));
	}
        
        public function searchPrint()
	{
		$criteria=new CDbCriteria;
		$criteria->with = array('ruangan','daftartindakan','daftartindakan.kategoritindakan','daftartindakan.kelompoktindakan','daftartindakan.komponenunit');
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('t.daftartindakan_id',$this->daftartindakan_id);
		$criteria->compare('LOWER(ruangan.ruangan_nama)',  strtolower($this->ruangan_nama), true);
		$criteria->compare('LOWER(kelompoktindakan.kelompoktindakan_nama)',  strtolower($this->kelompoktindakan_nama), true);
		$criteria->compare('LOWER(kategoritindakan.kategoritindakan_nama)',  strtolower($this->kategoritindakan_nama), true);
                $criteria->compare('LOWER(komponenunit.komponenunit_nama)',  strtolower($this->komponenunit_nama), true);
		$criteria->compare('LOWER(daftartindakan.daftartindakan_kode)',  strtolower($this->daftartindakan_kode), true);
		$criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',  strtolower($this->daftartindakan_nama), true);
                $criteria->order = "daftartindakan.daftartindakan_nama ASC, kelompoktindakan.kelompoktindakan_nama ASC";
                $criteria->limit = -1;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => false,
		));
	}
}