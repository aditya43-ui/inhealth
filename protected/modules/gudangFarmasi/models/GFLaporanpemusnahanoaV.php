<?php

/**
 * This is the model class for table "laporanpemusnahanoa_v".
 *
 * The followings are the available columns in table 'laporanpemusnahanoa_v':
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $pemusnahanobatalkes_id
 * @property string $date
 * @property string $nopemusnahan
 * @property string $keterangan
 * @property integer $pemusnahanoadetail_id
 * @property integer $jenisobatalkes_id
 * @property string $jenisobatalkes_kode
 * @property string $jenisobatalkes_nama
 * @property integer $obatalkes_id
 * @property string $obatalkes_barcode
 * @property string $obatalkes_kode
 * @property string $obatalkes_nama
 * @property string $obatalkes_golongan
 * @property string $obatalkes_kategori
 * @property string $obatalkes_kadarobat
 * @property integer $kemasanbesar
 * @property integer $kekuatan
 * @property string $satuankekuatan
 * @property integer $stokobatalkes_id
 * @property double $jmlbarang
 * @property string $tglkadaluarsa
 * @property string $nobatch
 * @property double $harganetto
 * @property double $persendiscount
 * @property double $jmldiscount
 * @property double $persenppn
 * @property double $persenpph
 * @property double $persenmargin
 * @property double $jmlmargin
 * @property integer $satuankecil_id
 * @property string $satuankecil_nama
 * @property string $kondisibarang
 * @property integer $pegawai_id
 * @property string $pegawai_nip
 * @property string $pegawai_jenisidentitas
 * @property string $pegawai_noidentitas
 * @property string $pegawai_gelardepan
 * @property string $pegawai_nama
 * @property string $pegawai_gelarbelakang
 * @property integer $pegawaimengetahui_id
 * @property string $pegawaimengetahui_nip
 * @property string $pegawaimengetahui_jenisidentitas
 * @property string $pegawaimengetahui_noidentitas
 * @property string $pegawaimengetahui_gelardepan
 * @property string $pegawaimengetahui_nama
 * @property string $pegawaimengetahui_gelarbelakang
 * @property integer $pegawaimenyetujui_id
 * @property string $pegawaimenyetujui_nip
 * @property string $pegawaimenyetujui_jenisidentitas
 * @property string $pegawaimenyetujui_noidentitas
 * @property string $pegawaimenyetujui_gelardepan
 * @property string $pegawaimenyetujui_nama
 * @property string $pegawaimenyetujui_gelarbelakang
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class GFLaporanpemusnahanoaV extends LaporanpemusnahanoaV
{
	public $tgl_awal,$tgl_akhir,$data,$jumlah;
	public $jns_periode,$bln_awal,$bln_akhir,$thn_awal,$thn_akhir;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function searchLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->instalasi_id)){
			$criteria->addCondition('instalasi_id = '.$this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id = '.$this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->pemusnahanobatalkes_id)){
			$criteria->addCondition('pemusnahanobatalkes_id = '.$this->pemusnahanobatalkes_id);
		}
		$criteria->addBetweenCondition('date(tglpemusnahan)',$this->tgl_awal,$this->tgl_akhir);
		$criteria->compare('LOWER(nopemusnahan)',strtolower($this->nopemusnahan),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		if(!empty($this->pemusnahanoadetail_id)){
			$criteria->addCondition('pemusnahanoadetail_id = '.$this->pemusnahanoadetail_id);
		}
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
		$criteria->compare('LOWER(jenisobatalkes_kode)',strtolower($this->jenisobatalkes_kode),true);
		$criteria->compare('LOWER(jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		$criteria->compare('LOWER(obatalkes_barcode)',strtolower($this->obatalkes_barcode),true);
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(obatalkes_kadarobat)',strtolower($this->obatalkes_kadarobat),true);
		if(!empty($this->kemasanbesar)){
			$criteria->addCondition('kemasanbesar = '.$this->kemasanbesar);
		}
		if(!empty($this->kekuatan)){
			$criteria->addCondition('kekuatan = '.$this->kekuatan);
		}
		$criteria->compare('LOWER(satuankekuatan)',strtolower($this->satuankekuatan),true);
		if(!empty($this->stokobatalkes_id)){
			$criteria->addCondition('stokobatalkes_id = '.$this->stokobatalkes_id);
		}
		$criteria->compare('jmlbarang',$this->jmlbarang);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('LOWER(nobatch)',strtolower($this->nobatch),true);
		$criteria->compare('harganetto',$this->harganetto);
		$criteria->compare('persendiscount',$this->persendiscount);
		$criteria->compare('jmldiscount',$this->jmldiscount);
		$criteria->compare('persenppn',$this->persenppn);
		$criteria->compare('persenpph',$this->persenpph);
		$criteria->compare('persenmargin',$this->persenmargin);
		$criteria->compare('jmlmargin',$this->jmlmargin);
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('satuankecil_id = '.$this->satuankecil_id);
		}
		$criteria->compare('LOWER(satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('LOWER(kondisibarang)',strtolower($this->kondisibarang),true);
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(pegawai_nip)',strtolower($this->pegawai_nip),true);
		$criteria->compare('LOWER(pegawai_jenisidentitas)',strtolower($this->pegawai_jenisidentitas),true);
		$criteria->compare('LOWER(pegawai_noidentitas)',strtolower($this->pegawai_noidentitas),true);
		$criteria->compare('LOWER(pegawai_gelardepan)',strtolower($this->pegawai_gelardepan),true);
		$criteria->compare('LOWER(pegawai_nama)',strtolower($this->pegawai_nama),true);
		$criteria->compare('LOWER(pegawai_gelarbelakang)',strtolower($this->pegawai_gelarbelakang),true);
		if(!empty($this->pegawaimengetahui_id)){
			$criteria->addCondition('pegawaimengetahui_id = '.$this->pegawaimengetahui_id);
		}
		$criteria->compare('LOWER(pegawaimengetahui_nip)',strtolower($this->pegawaimengetahui_nip),true);
		$criteria->compare('LOWER(pegawaimengetahui_jenisidentitas)',strtolower($this->pegawaimengetahui_jenisidentitas),true);
		$criteria->compare('LOWER(pegawaimengetahui_noidentitas)',strtolower($this->pegawaimengetahui_noidentitas),true);
		$criteria->compare('LOWER(pegawaimengetahui_gelardepan)',strtolower($this->pegawaimengetahui_gelardepan),true);
		$criteria->compare('LOWER(pegawaimengetahui_nama)',strtolower($this->pegawaimengetahui_nama),true);
		$criteria->compare('LOWER(pegawaimengetahui_gelarbelakang)',strtolower($this->pegawaimengetahui_gelarbelakang),true);
		if(!empty($this->pegawaimenyetujui_id)){
			$criteria->addCondition('pegawaimenyetujui_id = '.$this->pegawaimenyetujui_id);
		}
		$criteria->compare('LOWER(pegawaimenyetujui_nip)',strtolower($this->pegawaimenyetujui_nip),true);
		$criteria->compare('LOWER(pegawaimenyetujui_jenisidentitas)',strtolower($this->pegawaimenyetujui_jenisidentitas),true);
		$criteria->compare('LOWER(pegawaimenyetujui_noidentitas)',strtolower($this->pegawaimenyetujui_noidentitas),true);
		$criteria->compare('LOWER(pegawaimenyetujui_gelardepan)',strtolower($this->pegawaimenyetujui_gelardepan),true);
		$criteria->compare('LOWER(pegawaimenyetujui_nama)',strtolower($this->pegawaimenyetujui_nama),true);
		$criteria->compare('LOWER(pegawaimenyetujui_gelarbelakang)',strtolower($this->pegawaimenyetujui_gelarbelakang),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

		$criteria->limit=10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchGrafik()
	{
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;

                $criteria->select = 'count(pemusnahanobatalkes_id) as jumlah,nopemusnahan,obatalkes_nama as data';
                $criteria->group = 'tglpemusnahan, nopemusnahan, pemusnahanobatalkes_id,obatalkes_nama';
                $criteria->addBetweenCondition('date(tglpemusnahan)',$this->tgl_awal,$this->tgl_akhir);
                $criteria->compare('nopemusnahan',$this->nopemusnahan);

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                ));
        }
	
	public function getPegawaimengetahuiLengkap()
        {
            return (isset($this->pegawaimengetahui_gelardepan) ? $this->pegawaimengetahui_gelardepan : "").' '.$this->pegawaimengetahui_nama.(isset($this->pegawaimengetahui_gelarbelakang) ? ', '.$this->pegawaimengetahui_gelardepan : "");
        }

        public function getPegawaimenyetujuiLengkap()
        {
            return (isset($this->pegawaimenyetujui_gelardepan) ? $this->pegawaimenyetujui_gelardepan : "").' '.$this->pegawaimenyetujui_nama.(isset($this->pegawaimenyetujui_gelarbelakang) ? ', '.$this->pegawaimenyetujui_gelardepan : "");
        }
}