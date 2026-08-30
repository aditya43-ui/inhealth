<?php

class RJDokterV extends DokterV
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienM the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    public function searchDokterdialog() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(t.nomorindukpegawai)', strtolower($this->nomorindukpegawai), true);
        if (!empty($this->jabatan_id)){
            $criteria->addCondition(" jabatan_id = '".$this->jabatan_id."' ");
        }
        //$criteria->compare('LOWER(t.gelardepan)', strtolower($this->gelardepan), true);
        $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        
        if(is_array($this->pegawai_id)){
            $criteria->addInCondition('t.pegawai_id', $this->pegawai_id);
        }else{
            if(!empty($this->pegawai_id)){
                $criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
            }
        }
        
        $criteria->order = 't.nama_pegawai DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));	

    }
}
?>