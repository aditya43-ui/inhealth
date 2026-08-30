<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class KPPendidikanpegawaiR extends PendidikanpegawaiR {
public $pendidikan_nama;
public $satuan;
    public static function model($className = __CLASS__) {
        parent::model($className);
    }

	public function searchInfo($pegawai = null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		$criteria->with = array('pendidikan');
		if(!empty($pegawai)){
		$criteria->addCondition('pegawai_id = '.$pegawai);
		}
		if(!empty($this->pendidikanpegawai_id)){
		$criteria->addCondition('t.pendidikanpegawai_id = '.$this->pendidikanpegawai_id);
		}
		if(!empty($this->kabupaten_id)){
		$criteria->addCondition('kabupaten_id = '.$this->kabupaten_id);
		}
		if(!empty($this->propinsi_id)){
		$criteria->addCondition('propinsi_id = '.$this->propinsi_id);
		}
		$criteria->compare('LOWER(pendidikan.pendidikan_nama)',strtolower($this->pendidikan_nama),true);
		$criteria->compare('LOWER(jenispendidikan)',strtolower($this->jenispendidikan),true);
		$criteria->compare('nourut_pend',$this->nourut_pend);
		$criteria->compare('LOWER(namasek_univ)',strtolower($this->namasek_univ),true);
		$criteria->compare('LOWER(almtsek_univ)',strtolower($this->almtsek_univ),true);
		$criteria->compare('LOWER(tglmasuk)',strtolower($this->tglmasuk),true);
		$criteria->compare('LOWER(tgllulus)',strtolower($this->tgllulus),true);
		$criteria->compare('lamapendidikan_bln',$this->lamapendidikan_bln);
		$criteria->compare('LOWER(no_ijazah_sert)',strtolower($this->no_ijazah_sert),true);
		$criteria->compare('LOWER(tgl_ijazah_sert)',strtolower($this->tgl_ijazah_sert),true);
		$criteria->compare('LOWER(ttd_ijazah_sert)',strtolower($this->ttd_ijazah_sert),true);
		$criteria->compare('nilailulus',$this->nilailulus);
		$criteria->compare('LOWER(gradelulus)',strtolower($this->gradelulus),true);
		$criteria->compare('LOWER(keteranganpend)',strtolower($this->keteranganpend),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->order='nourut_pend';
		$criteria->limit=3; 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}

?>
