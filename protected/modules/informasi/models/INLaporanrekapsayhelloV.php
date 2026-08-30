<?php
class INLaporanrekapsayhelloV extends LaporanrekapsayhelloV
{
	public $tgl_awal, $tgl_akhir, $jmlruang;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchSayHelloTable()
    {
        $criteria=new CDbCriteria;
		$criteria->addBetweenCondition('DATE(t.tgl_sayhello)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->order = 'tgl_sayhello DESC';

        return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
        ));
    }
	
	public function getNamaRuangan($ruangan_id = null) {
		$namaRuangan = '';
		if(!empty($ruangan_id)){
			$ruangan = RuanganM::model()->findByPk($ruangan_id);
			$namaRuangan = $ruangan->ruangan_nama;
		}
		return $namaRuangan;
	}
}

