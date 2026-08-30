<?php
/**
 * @package application.modules.pendaftaranPenjadwalan
 * @subpackage models
 * This is the model class for table "bookingkamar_t".
 *
 * The followings are the available columns in table 'bookingkamar_t':
 * @property integer $bookingkamar_id
 * @property integer $kelaspelayanan_id
 * @property integer $pendaftaran_id
 * @property integer $kamarruangan_id
 * @property integer $pasien_id
 * @property integer $ruangan_id
 * @property integer $pasienadmisi_id
 * @property string $bookingkamar_no
 * @property string $tglbookingkamar
 * @property string $statusbooking
 * @property string $keteranganbooking
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PPBookingKamarT extends BookingkamarT{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BookingkamarT the static model class
     */
    public $no_pendaftaran;
    public $isNoPendaftaran;
    public $ruanganJalanGd;
    public $ruanganInap;
    public $noRekamMedik;
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
   public function searchBooking()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->addCondition('tgltransaksibooking BETWEEN \''.$this->tgl_awal.'\' AND \''.$this->tgl_akhir.'\'');
		$criteria->compare('bookingkamar_id',$this->bookingkamar_id);
		$criteria->compare('t.kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->compare('t.pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('t.kamarruangan_id',$this->kamarruangan_id);
		$criteria->compare('t.pasien_id',$this->pasien_id);
		$criteria->compare('t.instalasi_id',$this->instalasi_id);
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('t.pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('LOWER(bookingkamar_no)',strtolower($this->bookingkamar_no),true);
		$criteria->compare('LOWER(statusbooking)',strtolower($this->statusbooking),true);
		$criteria->compare('LOWER(keteranganbooking)',strtolower($this->keteranganbooking),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                $criteria->compare('LOWER(pendaftaran.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
                $criteria->compare('LOWER(statuskonfirmasi)',strtolower($this->statuskonfirmasi),true);
                $criteria->with=array('kelaspelayanan','pendaftaran','kamarruangan','pasien','ruangan','pasienadmisi');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	} 
    
    
    
}
?>
