<?php
/**
 * This is the model class for table "tipepaket_m".
 *
 * The followings are the available columns in table 'tipepaket_m':
 * @property integer $tipepaket_id
 * @property integer $kelaspelayanan_id
 * @property integer $penjamin_id
 * @property integer $carabayar_id
 * @property string $tipepaket_nama
 * @property string $tipepaket_singkatan
 * @property string $tipepaket_namalainnya
 * @property string $tglkesepakatantarif
 * @property string $nokesepakatantarif
 * @property double $tarifpaket
 * @property double $paketsubsidiasuransi
 * @property double $paketsubsidipemerintah
 * @property double $paketsubsidirs
 * @property double $paketiurbiaya
 * @property integer $nourut_tipepaket
 * @property string $keterangan_tipepaket
 * @property boolean $tipepaket_aktif
 */
class SATipePaketM extends TipepaketM{
    public $tipepaketNama;
    public $tipepaket_nama;
    public $paketpelayanan_id;
    public $jenistarif_nama;
	public $jenis_paket;

    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TipepaketM the static model class
     */

    
    public static function model($className=__CLASS__)
    {
           return parent::model($className);
    }
    
    public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array('carabayar', 'penjamin');
		if (!empty($this->tipepaket_id)){
			$criteria->addCondition('tipepaket_id ='.$this->tipepaket_id);
		}
		if (!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id ='.$this->kelaspelayanan_id);
		}
		if (!empty($this->penjamin_id)){
			$criteria->addCondition('t.penjamin_id ='.$this->penjamin_id);
		}
		if (!empty($this->carabayar_id)){
			$criteria->addCondition('t.carabayar_id ='.$this->carabayar_id);
		}
                
                if (!empty($this->jenistarif_id)){
			$criteria->addCondition('t.jenistarif_id ='.$this->jenistarif_id);
		}
                
		$criteria->compare('LOWER(tipepaket_nama)',strtolower($this->tipepaket_nama),true);
		$criteria->compare('LOWER(tipepaket_singkatan)',strtolower($this->tipepaket_singkatan),true);
		$criteria->compare('LOWER(tipepaket_namalainnya)',strtolower($this->tipepaket_namalainnya),true);
		$criteria->compare('LOWER(tglkesepakatantarif)',strtolower($this->tglkesepakatantarif),true);
		$criteria->compare('LOWER(nokesepakatantarif)',strtolower($this->nokesepakatantarif),true);
		$criteria->compare('tarifpaket',$this->tarifpaket);
		$criteria->compare('paketsubsidiasuransi',$this->paketsubsidiasuransi);
		$criteria->compare('paketsubsidipemerintah',$this->paketsubsidipemerintah);
		$criteria->compare('paketsubsidirs',$this->paketsubsidirs);
		$criteria->compare('paketiurbiaya',$this->paketiurbiaya);
		$criteria->compare('nourut_tipepaket',$this->nourut_tipepaket);
		$criteria->compare('LOWER(keterangan_tipepaket)',strtolower($this->keterangan_tipepaket),true);
		$criteria->compare('tipepaket_aktif',isset($this->tipepaket_aktif)?$this->tipepaket_aktif:true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		$criteria->with = array('carabayar', 'penjamin');
		if (!empty($this->tipepaket_id)){
			$criteria->addCondition('tipepaket_id ='.$this->tipepaket_id);
		}
		if (!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id ='.$this->kelaspelayanan_id);
		}
		if (!empty($this->penjamin_id)){
			$criteria->addCondition('t.penjamin_id ='.$this->penjamin_id);
		}
		if (!empty($this->carabayar_id)){
			$criteria->addCondition('t.carabayar_id ='.$this->carabayar_id);
		}
		$criteria->compare('LOWER(tipepaket_nama)',strtolower($this->tipepaket_nama),true);
		$criteria->compare('LOWER(tipepaket_singkatan)',strtolower($this->tipepaket_singkatan),true);
		$criteria->compare('LOWER(tipepaket_namalainnya)',strtolower($this->tipepaket_namalainnya),true);
		$criteria->compare('LOWER(tglkesepakatantarif)',strtolower($this->tglkesepakatantarif),true);
		$criteria->compare('LOWER(nokesepakatantarif)',strtolower($this->nokesepakatantarif),true);
		$criteria->compare('tarifpaket',$this->tarifpaket);
		$criteria->compare('paketsubsidiasuransi',$this->paketsubsidiasuransi);
		$criteria->compare('paketsubsidipemerintah',$this->paketsubsidipemerintah);
		$criteria->compare('paketsubsidirs',$this->paketsubsidirs);
		$criteria->compare('paketiurbiaya',$this->paketiurbiaya);
		$criteria->compare('nourut_tipepaket',$this->nourut_tipepaket);
		$criteria->compare('LOWER(keterangan_tipepaket)',strtolower($this->keterangan_tipepaket),true);
		$criteria->compare('tipepaket_aktif',isset($this->tipepaket_aktif)?$this->tipepaket_aktif:true);
		$criteria->limit=-1; 

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination'=>false,
		));
	}

    
    public static function getItems(){
		$criteria = new CDbCriteria();
		$criteria->addCondition("tipepaket_aktif = TRUE");
		$criteria->order = "nourut_tipepaket, tipepaket_nama";
		return self::model()->findAll($criteria);
	}
}
?>
