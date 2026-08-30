<?php
class GZLaporanmakanangiziV extends LaporanmakanangiziV
{
	public $jns_periode,$tgl_awal,$tgl_akhir,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
    public $instalasi_id;
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
    public function searchTable()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

        $criteria->join = 'join ruangan_m r on r.ruangan_id = t.ruangan_id';
        $criteria->addBetweenCondition('DATE(t.tglkirimmenu)',$this->tgl_awal,$this->tgl_akhir,true);
		$criteria->compare('t.pasien_id',$this->pasien_id);
		$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		$criteria->compare('LOWER(t.namadepan)',strtolower($this->namadepan),true);
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(t.jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(t.alamat_pasien)',strtolower($this->alamat_pasien),true);
		$criteria->compare('t.pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('LOWER(t.tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('t.kirimmenudiet_id',$this->kirimmenudiet_id);
		$criteria->compare('LOWER(t.tglkirimmenu)',strtolower($this->tglkirimmenu),true);
		$criteria->compare('LOWER(t.jenispesanmenu)',strtolower($this->jenispesanmenu),true);
		$criteria->compare('LOWER(t.keterangan_kirim)',strtolower($this->keterangan_kirim),true);
		$criteria->compare('t.jenisdiet_id',$this->jenisdiet_id);
		$criteria->compare('LOWER(t.jenisdiet_nama)',strtolower($this->jenisdiet_nama),true);
		$criteria->compare('t.menudiet_id',$this->menudiet_id);
		$criteria->compare('t.jml_kirim',$this->jml_kirim);
		$criteria->compare('LOWER(t.satuanjml_urt)',strtolower($this->satuanjml_urt),true);
		$criteria->compare('t.jeniswaktu_id',$this->jeniswaktu_id);
		$criteria->compare('LOWER(t.jeniswaktu_nama)',strtolower($this->jeniswaktu_nama),true);
		$criteria->compare('LOWER(t.menudiet_nama)',strtolower($this->menudiet_nama),true);
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('r.instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(t.ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('t.kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('LOWER(t.kelaspelayanan_nama)',strtolower($this->kelaspelayanan_nama),true);
		$criteria->compare('LOWER(t.ruangan_lokasi)',strtolower($this->ruangan_lokasi),true);
		$criteria->compare('LOWER(t.jeniswaktu_jam)',strtolower($this->jeniswaktu_jam),true);
		$criteria->compare('t.hargasatuan',$this->hargasatuan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    public function searchPrint()
	{
            $prop = $this->searchTable();
            $prop->pagination = false;
            return $prop;
	}

	public function getInstalasiItems()
    {

        $criteria = new CDbCriteria();
        if (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_GIZI) {
            $criteria->addInCondition(
                'instalasi_id',
                Params::grupInstalasiRIID()
            );
        } else {
            $criteria->addInCondition(
                'instalasi_id',
                array(
                    Yii::app()->user->getState('instalasi_id')
                )
            );
        }

        $criteria->addCondition('instalasi_aktif = true');
        $criteria->order = "instalasi_nama ASC";
        $modInstalasis = InstalasiM::model()->findAll($criteria);
        if (count((array) $modInstalasis) > 0)
            return $modInstalasis;
        else
            return array();
    }


	public function getNamaModel()
    {
        return __CLASS__;
    }

	public function getRuanganItems($instalasi_id = null)
    {
        if (!empty($instalasi_id)) {
            return RuanganM::model()->findAllByAttributes(array('instalasi_id' => $instalasi_id, 'ruangan_aktif' => true), array('order' => 'ruangan_nama'));
        } else {
            return RuanganM::model()->findAllByAttributes(array('ruangan_aktif' => true), array('order' => 'ruangan_nama'));
        }
    }
}
?>