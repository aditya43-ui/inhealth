<?php

/**
 * This is the model class for table "returbayarpelayanan_t".
 *
 * The followings are the available columns in table 'returbayarpelayanan_t':
 * @property integer $returbayarpelayanan_id
 * @property integer $tandabuktikeluar_id
 * @property integer $tandabuktibayar_id
 * @property integer $ruangan_id
 * @property string $tglreturpelayanan
 * @property string $noreturbayar
 * @property double $totaloaretur
 * @property double $totaltindakanretur
 * @property double $totalbiayaretur
 * @property double $biayaadministrasi
 * @property string $keteranganretur
 * @property integer $user_nm_otorisasi
 * @property integer $user_id_otorisasi
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class BKReturbayarpelayananT extends ReturbayarpelayananT
{
    public $notemp;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReturbayarpelayananT the static model class
	 */
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        public function searchInformasi() {
            $criteria = new CDbCriteria();
            $criteria->join = 'left join tandabuktibayar_t tb on tb.tandabuktibayar_id = t.tandabuktibayar_id '
                    . 'left join pembayaranpelayanan_t pp on pp.pembayaranpelayanan_id = tb.pembayaranpelayanan_id '
                    . 'left join pendaftaran_t p on p.pendaftaran_id = pp.pendaftaran_id '
                    . 'join pasien_m pa on pa.pasien_id = p.pasien_id';
            
            if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
                $criteria->addBetweenCondition('tglreturpelayanan::date', $this->tgl_awal, $this->tgl_akhir);
            }
            $criteria->compare('lower(p.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
            $criteria->compare('lower(tb.nobuktibayar)', strtolower($this->nobuktibayar), true);
            $criteria->compare('p.carabayar_id', $this->carabayar_id);
            $criteria->compare('p.penjamin_id', $this->penjamin_id);
            $criteria->compare('lower(pa.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
            $criteria->compare('lower(t.noreturbayar)', strtolower($this->noreturbayar), true);
            $criteria->compare('lower(pa.nama_pasien)', strtolower($this->nama_pasien), true);
            
            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }
}