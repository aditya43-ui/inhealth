<?php

class FAReturresepdetT extends ReturresepdetT
{
        public $pilihObat = true;
        public $satuankecil_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /**
         * getSumberDana untuk menampilkan data sumberdana_m berdasarkan id
         * @param type $id
         * @return type
         */
        public function getSumberDana($id){
            return SumberdanaM::model()->findByPk($id);
        }

}