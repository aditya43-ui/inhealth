<?php

class GZJenisdietM extends JenisdietM
{
	public $jenismenudiet_id, $jenismenudiet_nama; 
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
	public function searchJenisDiet()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		if (!empty($this->jenisdiet_id)) {
			$criteria->addCondition('jenisdiet_id =' . $this->jenisdiet_id);
		}
		$criteria->compare('LOWER(jenisdiet_nama)', strtolower($this->jenisdiet_nama), true);
		$criteria->compare('LOWER(jenisdiet_namalainnya)', strtolower($this->jenisdiet_namalainnya), true);
		$criteria->compare('LOWER(jenisdiet_keterangan)', strtolower($this->jenisdiet_keterangan), true);
		$criteria->compare('LOWER(jenisdiet_catatan)', strtolower($this->jenisdiet_catatan), true);
		$criteria->compare('jenisdiet_aktif', isset($this->jenisdiet_aktif) ? $this->jenisdiet_aktif : true);
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}


	public static function getJenisdietItems()
	{
		return self::model()->findAll('jenisdiet_aktif=TRUE ORDER BY jenisdiet_nama asc');
	}
}
