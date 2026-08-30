<?php
class MCInfoKunjunganRJV extends InfokunjunganrjV
{
	public $jumlah;
	public $data;
	public $tick;
	public $adaKarcis = false;
	public $Jenis_kasus_nama_penyakit;
	public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfokunjunganRj the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * menampilkan data terakhir daftar
	*/
	public function searchPendaftaranTerakhir()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->addBetweenCondition('tgl_pendaftaran', date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59'));
                if (!empty($this->ruangan_id)){
                    $criteria->addCondition("ruangan_id = '".$this->ruangan_id."' ");
                }
		$criteria->order = 'tgl_pendaftaran DESC';
                $criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
        
	public function getNamaAlias()
	{
		if(!empty($this->nama_bin)){
			return $this->nama_pasien.' Alias '.$this->nama_bin;
		}else{
			return $this->nama_pasien;
		}

	}

	public function primaryKey() {
		return 'pendaftaran_id';
	}

	public function getNamaModel()
	{
		return __CLASS__;
	}
}