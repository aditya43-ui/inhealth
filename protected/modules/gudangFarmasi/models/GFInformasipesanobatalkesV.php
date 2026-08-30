<?php
class GFInformasipesanobatalkesV extends InformasipesanobatalkesV
{
        public $tgl_awal,$tgl_akhir;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasipesanobatalkesV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchInformasiPemesananKeluar()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(tglpemesanan)',$this->tgl_awal,$this->tgl_akhir);
		if(!empty($this->pesanobatalkes_id)){
			$criteria->addCondition('pesanobatalkes_id = '.$this->pesanobatalkes_id);
		}
		$criteria->compare('LOWER(nopemesanan)',strtolower($this->nopemesanan),true);
		if(!empty($this->mutasioaruangan_id)){
			$criteria->addCondition('mutasioaruangan_id = '.$this->mutasioaruangan_id);
		}
		$criteria->compare('tglmutasioa',$this->tglmutasioa,true);
		$criteria->compare('nomutasioa',$this->nomutasioa,true);
		$criteria->compare('LOWER(statuspesan)',strtolower($this->statuspesan),true);
		$criteria->compare('tglmintadikirim',$this->tglmintadikirim,true);
		$criteria->compare('keterangan_pesan',$this->keterangan_pesan,true);
		if(!empty($this->instalasipemesan_id)){
			$criteria->addCondition('instalasipemesan_id = '.$this->instalasipemesan_id);
		}
		$criteria->compare('instalasipemesan_nama',$this->instalasipemesan_nama,true);
		if(!empty($this->ruanganpemesan_id)){
			$criteria->addCondition('ruanganpemesan_id = '.$this->ruanganpemesan_id);
		}
		$criteria->compare('ruanganpemesan_nama',$this->ruanganpemesan_nama,true);
		if(!empty($this->instalasitujuan_id)){
			$criteria->addCondition('instalasitujuan_id = '.$this->instalasitujuan_id);
		}
		$criteria->compare('instalasitujuan_nama',$this->instalasitujuan_nama,true);
		if(!empty($this->ruangantujuan_id)){
			$criteria->addCondition('ruangantujuan_id = '.$this->ruangantujuan_id);
		}
		$criteria->compare('ruangantujuan_nama',$this->ruangantujuan_nama,true);
		if(!empty($this->pegawaipemesan_id)){
			$criteria->addCondition('pegawaipemesan_id = '.$this->pegawaipemesan_id);
		}
		$criteria->compare('pegawaipemesan_gelardepan',$this->pegawaipemesan_gelardepan,true);
		$criteria->compare('pegawaipemesan_nama',$this->pegawaipemesan_nama,true);
		$criteria->compare('pegawaipemesan_gelarbelakang',$this->pegawaipemesan_gelarbelakang,true);
		if(!empty($this->pegawaimengetahui_id)){
			$criteria->addCondition('pegawaimengetahui_id = '.$this->pegawaimengetahui_id);
		}
		$criteria->compare('pegawaimengetahui_gelardepan',$this->pegawaimengetahui_gelardepan,true);
		$criteria->compare('pegawaimengetahui_nama',$this->pegawaimengetahui_nama,true);
		$criteria->compare('pegawaimengetahui_gelarbelakang',$this->pegawaimengetahui_gelarbelakang,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		if(!empty($this->terimamutasi_id)){
			$criteria->addCondition('terimamutasi_id = '.$this->terimamutasi_id);
		}
		$criteria->compare('tglterima',$this->tglterima,true);
		$criteria->compare('noterimamutasi',$this->noterimamutasi,true);
                if ($this->statusmutasi == 1) {
                    $criteria->addCondition('mutasioaruangan_id is not null');
                } else if ($this->statusmutasi == 2) {
                    $criteria->addCondition('mutasioaruangan_id is null');
                }
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'tglpemesanan desc',
            ),
		));
	}
        
	public function searchInformasiPemesananMasuk()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addBetweenCondition('DATE(tglpemesanan)',$this->tgl_awal,$this->tgl_akhir,true);
		if(!empty($this->pesanobatalkes_id)){
			$criteria->addCondition('pesanobatalkes_id = '.$this->pesanobatalkes_id);
		}
		$criteria->compare('LOWER(nopemesanan)',strtolower($this->nopemesanan),true);
		if(!empty($this->mutasioaruangan_id)){
			$criteria->addCondition('mutasioaruangan_id = '.$this->mutasioaruangan_id);
		}
		$criteria->compare('tglmutasioa',$this->tglmutasioa,true);
		$criteria->compare('nomutasioa',$this->nomutasioa,true);
		$criteria->compare('LOWER(statuspesan)',strtolower($this->statuspesan),true);
		$criteria->compare('tglmintadikirim',$this->tglmintadikirim,true);
		$criteria->compare('keterangan_pesan',$this->keterangan_pesan,true);
		if(!empty($this->instalasipemesan_id)){
			$criteria->addCondition('instalasipemesan_id = '.$this->instalasipemesan_id);
		}
		$criteria->compare('instalasipemesan_nama',$this->instalasipemesan_nama,true);
		if(!empty($this->ruanganpemesan_id)){
			$criteria->addCondition('ruanganpemesan_id = '.$this->ruanganpemesan_id);
		}
		$criteria->compare('ruanganpemesan_nama',$this->ruanganpemesan_nama,true);
		if(!empty($this->instalasitujuan_id)){
			$criteria->addCondition('instalasitujuan_id = '.$this->instalasitujuan_id);
		}
		$criteria->compare('instalasitujuan_nama',$this->instalasitujuan_nama,true);
		$criteria->addCondition('ruangantujuan_id = '.Yii::app()->user->getState('ruangan_id'));
		$criteria->compare('ruangantujuan_nama',$this->ruangantujuan_nama,true);
		if(!empty($this->pegawaipemesan_id)){
			$criteria->addCondition('pegawaipemesan_id = '.$this->pegawaipemesan_id);
		}
		$criteria->compare('pegawaipemesan_gelardepan',$this->pegawaipemesan_gelardepan,true);
		$criteria->compare('pegawaipemesan_nama',$this->pegawaipemesan_nama,true);
		$criteria->compare('pegawaipemesan_gelarbelakang',$this->pegawaipemesan_gelarbelakang,true);
		if(!empty($this->pegawaimengetahui_id)){
			$criteria->addCondition('pegawaimengetahui_id = '.$this->pegawaimengetahui_id);
		}
		$criteria->compare('pegawaimengetahui_gelardepan',$this->pegawaimengetahui_gelardepan,true);
		$criteria->compare('pegawaimengetahui_nama',$this->pegawaimengetahui_nama,true);
		$criteria->compare('pegawaimengetahui_gelarbelakang',$this->pegawaimengetahui_gelarbelakang,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition('create_loginpemakai_id = '.$this->create_loginpemakai_id);
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition('update_loginpemakai_id = '.$this->update_loginpemakai_id);
		}
		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}
		if(!empty($this->terimamutasi_id)){
			$criteria->addCondition('terimamutasi_id = '.$this->terimamutasi_id);
		}
		$criteria->compare('tglterima',$this->tglterima,true);
		$criteria->compare('noterimamutasi',$this->noterimamutasi,true);
                if ($this->statusmutasi == 1) {
                    $criteria->addCondition('mutasioaruangan_id is not null');
                } else if ($this->statusmutasi == 2) {
                    $criteria->addCondition('mutasioaruangan_id is null');
                }
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'tglpemesanan desc',
            ),
		));
	}
        
        public function getPegawaiPemesanLengkap()
        {
            return (isset($this->pegawaipemesan_gelardepan) ? $this->pegawaipemesan_gelardepan : "").' '.$this->pegawaipemesan_nama.(isset($this->pegawaipemesan_gelarbelakang) ? ', '.$this->pegawaipemesan_gelarbelakang : "");
        }

        public function getPegawaiMengetahuiLengkap()
        {
            return (isset($this->pegawaimengetahui_gelardepan) ? $this->pegawaimengetahui_gelardepan : "").' '.$this->pegawaimengetahui_nama.(isset($this->pegawaimengetahui_gelarbelakang) ? ', '.$this->pegawaimengetahui_gelarbelakang : "");
        }
}