<?php

class PSMasukKamarT extends MasukkamarT
{
    
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    /**
     * menampilkan ruangan m
     */
    public function getRuangan(){
        $modRuangan = RuanganM::model()->findByPk($this->ruangan_id);
        if($modRuangan)
            return $modRuangan;
        else
            return new RuanganM;
    }
    /**
     * menampilkan kamarruangan m
     */
    public function getKamarruangan(){
        $modKamarruangan = KamarruanganM::model()->findByPk($this->kamarruangan_id);
        if($modKamarruangan)
            return $modKamarruangan;
        else
            return new KamarruanganM;
    }
	
}