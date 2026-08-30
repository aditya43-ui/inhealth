<?php
/**
 * This is the model class for table "tindakanrm_m".
 *
 * The followings are the available columns in table 'tindakanrm_m':
 * @property integer $tindakanrm_id
 * @property integer $jenistindakanrm_id
 * @property integer $daftartindakan_id
 * @property string $tindakanrm_nama
 * @property string $tindakanrm_namalainnya
 * @property boolean $tindakanrm_aktif
 */
class RMTindakanrmM extends TindakanrmM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TindakanrmM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    public function searchDaftarTindakan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		if (!empty($this->tariftindakan_id)){
			$criteria->addCondition('tariftindakan_id ='.$this->tariftindakan_id);
		}
		if (!empty($this->jenistarif_id)){
			$criteria->addCondition('t.jenistarif_id ='.$this->jenistarif_id);
		}
//		$criteria->compare('jenistarif.jenistarif_nama',$this->jenistarif_nama);
		$criteria->compare('LOWER(daftartindakan.daftartindakan_nama)',strtolower($this->daftartindakan_id),true);
//		$criteria->compare('daftartindakan.daftartindakan_nama',$this->daftartindakan_nama);
		if (!empty($this->komponentarif_id)){
			$criteria->addCondition('t.komponentarif_id ='.$this->komponentarif_id);
		}
//		$criteria->compare('komponentarif.komponentarif_nama',$this->komponentarif_nama);
		if (!empty($this->perdatarif_id)){
			$criteria->addCondition('t.perdatarif_id ='.$this->perdatarif_id);
		}
		$criteria->compare('harga_tariftindakan',$this->harga_tariftindakan);
		$criteria->compare('persendiskon_tind',$this->persendiskon_tind);
		$criteria->compare('hargadiskon_tind',$this->hargadiskon_tind);
		$criteria->compare('persencyto_tind',$this->persencyto_tind);
		if (!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('t.kelaspelayanan_id ='.$this->kelaspelayanan_id);
		}
                $criteria->addCondition('t.komponentarif_id = '.Params::KOMPONENTARIF_ID_TOTAL);
                $criteria->with=array('perdatarif','jenistarif','komponentarif','daftartindakan','kelaspelayanan');
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
//                        'pagination'=>array(
//                            'pageSize'=>1,
//                        ),
		));
	}

	public function getJenisTindakanItems() 
    {
        $modJenisTindakan = RMJenisTindakanrmM::model()->findAll('jenistindakanrm_aktif=true ORDER BY jenistindakanrm_nama');
        return $modJenisTindakan;
    }
}
?>
