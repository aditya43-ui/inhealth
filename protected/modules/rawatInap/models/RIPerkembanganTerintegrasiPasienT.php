<?php

/**
 * This is the model class for table "perkembangan_terintegrasi_pasien_t".
 *
 * The followings are the available columns in table 'perkembangan_terintegrasi_pasien_t':
 * @property integer $perkembangan_terintegrasi_pasien_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property string $tgltransaksi
 * @property string $profesi
 * @property integer $pegawai_id
 * @property string $subyektif
 * @property string $obyektif
 * @property string $asesmen
 * @property string $perencanaan
 * @property string $instruksi
 * @property integer $dpjp_id
 * @property boolean $menyetujui
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan_id
 * @property integer $update_ruangan_id
 * @property string $create_time
 * @property string $update_time
 */
class RIPerkembanganTerintegrasiPasienT extends PerkembanganTerintegrasiPasienT
{
    public $ppds_nama, $proses;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PerkembanganTerintegrasiPasienT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function searchRI()
        {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=$this->criteriaSearch();
            if(isset($_GET['pendaftaran_id'])){
                $criteria->addCondition('pendaftaran_id = '.$_GET['pendaftaran_id']);
            }
            $criteria->limit=10;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
        }

}