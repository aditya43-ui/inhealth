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
class EKTipePaketM extends TipepaketM{
    public $tipepaketNama;
    public $tipepaket_nama;
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
		$criteria->compare('tipepaket_id',$this->tipepaket_id);
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
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
		$criteria->compare('tipepaket_aktif',$this->tipepaket_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    
}
?>
