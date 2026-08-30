<?php
class MAKorektifmaintenT extends KorektifmaintenT
{

    public $tgl_awal,$tgl_akhir;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchInformasi() {
            
            $criteria=new CDbCriteria;
            $criteria->addBetweenCondition('DATE(korektifmainten_tgl)', $this->tgl_awal, $this->tgl_akhir);        

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
        
    /**
     * 
     * @return \CActiveDataProvider
     */
    public function searchDashboardCorrective(){
        $criteria=new CDbCriteria;
        $criteria->join = " JOIN invperalatan_t inv ON inv.invperalatan_id = t.invperalatan_id "
                        . " JOIN lokasiaset_m lok ON lok.lokasi_id = inv.lokasi_id";
        $criteria->select = [
            'inv.invperalatan_namabrg',
            'inv.invperalatan_kode',
            'lok.lokasiaset_namalokasi',
            't.korektifmainten_status'
        ];
        $criteria->order = "t.create_time DESC";
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,      
            'pagination'=>false
        ));
    }
	
}