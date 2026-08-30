<?php

class SAFaktorrisikoM extends FaktorrisikoM
{
	public $diagnosakep_nama;
    public $faktorrisiko_nama;
        public $kelompokfaktorrisikodaftar;
        public $jenisfaktorrisiko_id;
        public $detail;
        public $diagnosakep_id;
        public $jenisfaktorrisiko_nama;
        public $faktorrisiko_aktif;
        public $aktif;


        /**
         * Returns the static model of the specified AR class.
         * @param string $className active record class name.
         */
        public static function model($className=__CLASS__)
        {
                return parent::model($className);
        }
        
        /**
         * 
         * @return type
         */
        public function rules()
	{
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('diagnosakep_id, diagnosakep_nama, faktorrisiko_nama, jenisfaktorrisiko_id, jenisfaktorrisiko_nama, faktorrisiko_aktif', 'safe', 'on'=>'search'),
            );
	}

        /**
         * untuk dropdown list jenis resiko
         * @return Array
         */
        public function jenisfaktorrisiko()
        {
            $lem    = JenisfaktorrisikoM::model()->findAll(['select'=>'jenisfaktorrisiko_id, jenisfaktorrisiko_nama', 'condition'=>'jenisfaktorrisiko_aktif = true']);
            $list   = CHtml::listData($lem, 'jenisfaktorrisiko_id', 'jenisfaktorrisiko_nama');

            return $list;
        }

        /**
         * 
         * @return \CActiveDataProvider
         */
        public function searchAdmin()
        {
            $cri = new CDbCriteria();
            $cri->select = "t.*"
                    . ", a.diagnosakep_id"
                    . ", a.diagnosakep_nama"
                    . ", c.jenisfaktorrisiko_id"
                    . ", c.jenisfaktorrisiko_nama";
            $cri->join = " left join diagnosakep_m a on a.diagnosakep_id = t.diagnosakep_id"
                    . " left join kelompokfaktorrisikodaftar_m b on b.kelompokfaktorrisikodaftar_id = t.kelompokfaktorrisikodaftar_id"
                    . " left join jenisfaktorrisiko_m c on c.jenisfaktorrisiko_id = b.jenisfaktorrisiko_id";
            
            
            $cri->compare('a.diagnosakep_id', $this->diagnosakep_id);
            $cri->compare('c.jenisfaktorrisiko_id', $this->jenisfaktorrisiko_id);
            
            if(!empty($this->aktif)){
                if($this->aktif == 'y'){
                    $cri->addCondition('faktorrisiko_aktif = true');
                }else {
                    $cri->addCondition('faktorrisiko_aktif = false');
                }
            }
            $cri->compare('lower(faktorrisiko_nama)', strtolower($this->faktorrisiko_nama), true);
            $cri->compare('lower(diagnosakep_nama)', strtolower($this->diagnosakep_nama), true);
            $cri->compare('lower(jenisfaktorrisiko_nama)', strtolower($this->jenisfaktorrisiko_nama), true);
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$cri,
            ));
        }
}
?>