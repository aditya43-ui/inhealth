<?php
class ARPendaftaranT extends PendaftaranT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PendaftaranT the static model class
	 */
	public $tgl_awal, $tgl_akhir;
	public $keterangan,$instalasi_nama,$ruangan_nama,$kelaspelayanan_nama;
	public $tanggal_lahir,$jeniskelamin,$no_rekam_medik,$nama_pasien;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	
	public function searchTabel()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', MyFormatter::formatDateTimeForDb($this->tgl_awal), MyFormatter::formatDateTimeForDb($this->tgl_akhir));
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('penjamin_id = '.$this->penjamin_id);
		}
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('carabayar_id = '.$this->carabayar_id);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}
	
	 public function getCaraBayarItems()
        {
            return CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true),array('order'=>'carabayar_nourut'));
        }

    public function getPenjaminItems($carabayar_id=null)
        {
            if(!empty($carabayar_id))
                    return PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif'=>true,'carabayar_id'=>$carabayar_id),array('order'=>'penjamin_nama'));
            else
                    return array();
                    //return PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif'=>true),array('order'=>'penjamin_nama'));
        }

		public function getKelasTanggunganItems()
        {
			$cri = new CDbCriteria();
			$cri->addCondition(" kelaspelayanan_aktif = TRUE ");
			$cri->addCondition(" kelasbpjs_id IS NOT NULL ");
			$cri->order = " urutankelas ASC ";
            //return KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true),array('order'=>'kelaspelayanan_nama'));
			return KelaspelayananM::model()->findAll($cri);
        }	
       
}