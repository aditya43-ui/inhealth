<?php
class MCDokterV extends DokterV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegawaiV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchDokterDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$ruangan = RuanganM::model()->findByPk(Yii::app()->user->ruangan_id);
		$ruangan_nama = $ruangan->ruangan_nama;

		$criteria=new CDbCriteria;
		$criteria->group = 'nama_pegawai,ruangan_nama';
		$criteria->select = $criteria->group;
		$criteria->compare('LOWER(ruangan_nama)',strtolower($ruangan_nama),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->limit=5;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}

}