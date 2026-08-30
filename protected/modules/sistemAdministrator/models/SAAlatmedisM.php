<?php

/**
 * This is the model class for table "alatmedis_m".
 *
 * The followings are the available columns in table 'alatmedis_m':
 * @property integer $alatmedis_id
 * @property integer $instalasi_id
 * @property integer $jenisalatmedis_id
 * @property integer $alatmedis_noaset
 * @property string $alatmedis_nama
 * @property string $alatmedis_namalain
 * @property boolean $alatmedis_aktif
 * @property string $alatmedis_kode
 * @property string $alatmedis_format
 *
 * The followings are the available model relations:
 * @property PengambilansampleT[] $pengambilansampleTs
 * @property InstalasiM $instalasi
 * @property JenisalatmedisM $jenisalatmedis
 * @property TindakanpelayananT[] $tindakanpelayananTs
 */
class SAAlatmedisM extends AlatmedisM
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AlatmedisM the static model class
	 */
	public $instalasi_nama;
	public $jenisalatmedis_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
    public function searchDialog()
    {
		 // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=$this->criteriaSearch();
        $criteria->limit=10;

        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
        ));
    }
	public function criteriaSearch()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->alatmedis_id)){
			$criteria->addCondition('alatmedis_id = '.$this->alatmedis_id);
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		if(!empty($this->jenisalatmedis_id)){
			$criteria->addCondition('jenisalatmedis_id = '.$this->jenisalatmedis_id);
		}
		if(!empty($this->alatmedis_noaset)){
			$criteria->addCondition('alatmedis_noaset = '.$this->alatmedis_noaset);
		}
		$criteria->compare('LOWER(alatmedis_nama)',strtolower($this->alatmedis_nama),true);
		$criteria->compare('LOWER(alatmedis_namalain)',strtolower($this->alatmedis_namalain),true);
		//$criteria->compare('alatmedis_aktif',$this->alatmedis_aktif);
		$criteria->compare('alatmedis_aktif',isset($this->alatmedis_aktif)?$this->alatmedis_aktif:true);
		$criteria->compare('LOWER(alatmedis_kode)',strtolower($this->alatmedis_kode),true);
		$criteria->compare('LOWER(alatmedis_format)',strtolower($this->alatmedis_format),true);

		return $criteria;
	}
	public function getInstalasiItems()
	{
		 return InstalasiM::model()->findAll('instalasi_aktif=TRUE ORDER BY instalasi_nama');
	}
	
	public function getJenisalatmedisItems()
	{
		 return JenisalatmedisM::model()->findAll('jenisalatmedis_aktif=TRUE ORDER BY jenisalatmedis_nama');
	}
}