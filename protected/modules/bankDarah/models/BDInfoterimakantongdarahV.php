<?php
/**
 * - digunakan sebagai Model Extends Info Terima Kantong Darah
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * @package application.modules.bankDarah
 * @subpackage models
**/
class BDInfoterimakantongdarahV extends InfoterimakantongdarahV
{
    public $statuspelulusan, $nama_jenis,$jeniskantongdarah_id;
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KarcisV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        /**
         * Search Informasi Kantong Darah
         * @return \CActiveDataProvider
         */
        public function searchInformasiKantongDarah(){          	
        $criteria = new CDbCriteria();
        $criteria->join = 'LEFT JOIN kantongdarah_t k ON t.kantongdarah_id = k.kantongdarah_id ';
        $criteria->addCondition('k.batalkantongdarah_id IS NULL');
        $criteria->addBetweenCondition('DATE(t.tglterimakantong)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('lower(t.no_kantongdarah)',strtolower($this->no_kantongdarah),true);
        return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
        ));

    }
}