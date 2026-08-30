<?php

class ANInfokunjunganrjV extends InfokunjunganrjV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokunjunganrjV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
         * menampilkan ruangan yang terdaftar di pendafaran_t
         * @param type $no_layar
         * @param type $instalasi_id
         */
	public static function getRuanganTerdaftar($no_layar=null,$instalasi_id = null){
            $criteria = new CDbCriteria();
            $criteria->compare('instalasi_id',$instalasi_id);
            $criteria->addCondition('ruangan_aktif = true');
            $criteria->group = "ruangan_id, ruangan_nama, ruangan_singkatan, ruangan_nourut";
            $criteria->select = $criteria->group;
            $criteria->order = "ruangan_nourut, ruangan_nama";
            if(!empty($no_layar)){
                $criteria->limit = 6;
                $criteria->offset = ($criteria->limit*$no_layar)-6;
            }
            $models = RuanganM::model()->findAll($criteria);
            return $models;
        }
}