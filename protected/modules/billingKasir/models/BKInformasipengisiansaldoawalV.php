<?php
class BKInformasipengisiansaldoawalV extends PengisiansaldoawalT
{
        public $tgl_awal,$tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasifakturpembelianV the static model class
	 */

	public $nama_rumahsakit,$ruangan_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public function searchTable()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(tglpengisiansaldo)',$this->tgl_awal,$this->tgl_akhir,true);
		
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id ='.$this->shift_id);
		}
	
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
			$criteria->addBetweenCondition('DATE(tglpengisiansaldo)', $this->tgl_awal, $this->tgl_akhir,true);
		}
			

		$criteria->order = " tglpengisiansaldo DESC ";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getRuanganNama(){
		$ruangan = RuanganM::model()->findByPk($this->ruangan_id);
		if(!empty($ruangan)){
			return $ruangan->ruangan_nama;
		}else{
			return '';
		}
	}

	public function getNamaRumahsakit(){
		$rs = ProfilrumahsakitM::model()->findByPk($this->profilrs_id);
		if(!empty($rs)){
			return $rs->nama_rumahsakit;
		}else{
			return '';
		}
	}

	public function getShiftItems(){
        $modShift = ShiftM::model()->findAllByAttributes(array('shift_aktif'=>true), array('order'=>'shift_jamawal'));
        return $modShift;
	}
}