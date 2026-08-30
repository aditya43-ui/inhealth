<?php
/**
 * digunakan untuk Master Alat Makanan
 * RSST-3459
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @subpackage models
 * @package         application.modules.gizi
 */
class GZAlatmakananM extends AlatmakananM 
{
   public $no_urut,$status,$image_alatmakananold;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('alatmakanan_id',$this->alatmakanan_id);
		$criteria->compare('alatmakanan_nama',$this->alatmakanan_nama,true);
		$criteria->compare('alatmakanan_aktif',$this->alatmakanan_aktif);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false
		));
	}
}
