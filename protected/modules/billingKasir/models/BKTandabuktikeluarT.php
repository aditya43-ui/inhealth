<?php

class BKTandabuktikeluarT extends TandabuktikeluarT
{
        public $notemp, $tgl_awal, $tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TandabuktikeluarT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchTableUntukClosing() {
		$criteria = new CDbCriteria;
		$criteria->join = "left join returbayarpelayanan_t r on r.tandabuktikeluar_id = t.tandabuktikeluar_id";
		$criteria->addBetweenCondition('t.tglkaskeluar', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('t.create_loginpemakai_id', $this->create_loginpemakai_id);
		$criteria->compare('t.ruangan_id', $this->ruangan_id);
		$criteria->compare('t.shift_id', $this->shift_id);
		$criteria->addCondition('t.closingkasir_id is null');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
}