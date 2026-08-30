<?php
/**
 * This is the model class for table "pengajuanklaimdetail_t".
 *
 * The followings are the available columns in table 'pengajuanklaimdetail_t':
 * @property integer $pengajuanklaimdetail_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $pengajuanklaimpiutang_id
 * @property integer $pembayaranpelayanan_id
 * @property integer $tandabuktibayar_id
 * @property double $jmlpiutang
 * @property double $jumlahbayar
 * @property double $jmltelahbayar
 * @property double $jmlsisapiutang
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PembayaranpelayananT $pembayaranpelayanan
 * @property PengajuanklaimpiutangT $pengajuanklaimpiutang
 * @property PendaftaranT $pendaftaran
 * @property TandabuktibayarT $tandabuktibayar
 */
class KUPengajuanklaimdetailT extends PengajuanklaimdetailT
{
	public $tgl_pendaftaran, $no_pendaftaran, $nama_pasien;
	public $tgl_awalPengajuan,$tgl_akhirPengajuan,$tgl_awalJatuhTempo,$tgl_akhirJatuhTempo;
	public $nopengajuanklaimanklaim, $nopembayaran, $carabayar_id, $penjamin_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PengajuanklaimdetailT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		
		$criteria->join = "JOIN pengajuanklaimpiutang_t ON pengajuanklaimpiutang_t.pengajuanklaimpiutang_id = t.pengajuanklaimpiutang_id
							JOIN pembayaranpelayanan_t ON pembayaranpelayanan_t.pembayaranpelayanan_id = t.pembayaranpelayanan_id
							JOIN carabayar_m ON carabayar_m.carabayar_id = pembayaranpelayanan_t.carabayar_id
							JOIN penjaminpasien_m ON penjaminpasien_m.penjamin_id = pembayaranpelayanan_t.penjamin_id";
		$criteria->addBetweenCondition('DATE(pengajuanklaimpiutang_t.tglpengajuanklaimanklaim)',$this->tgl_awalPengajuan,$this->tgl_akhirPengajuan);
		if (isset($_GET['berdasarkanJatuhTempo'])){
			if($_GET['berdasarkanJatuhTempo'] > 0){
				$criteria->addBetweenCondition('DATE(pengajuanklaimpiutang_t.tgljatuhtempo)', $this->tgl_awalJatuhTempo, $this->tgl_akhirJatuhTempo);
			}
		}
		
		if(!empty($this->pembayaranpelayanan_id)){
			$criteria->addCondition('t.pembayaranpelayanan_id = '.$this->pembayaranpelayanan_id);
		}
		if(!empty($this->carabayar_id)){
			$criteria->addCondition('pembayaranpelayanan_t.carabayar_id = '.$this->carabayar_id);
		}
		if(!empty($this->penjamin_id)){
			$criteria->addCondition('pembayaranpelayanan_t.penjamin_id = '.$this->penjamin_id);
		}
		if (!empty($this->pengajuanklaimdetail_id)){
		$criteria->addCondition('t.pengajuanklaimdetail_id = '.$this->pengajuanklaimdetail_id);
		}
		if (!empty($this->pengajuanklaimpiutang_id)){
		$criteria->addCondition('t.pengajuanklaimpiutang_id ='.$this->pengajuanklaimpiutang_id);
		}
		$criteria->compare('LOWER(pengajuanklaimpiutang_t.nopengajuanklaimanklaim)', strtolower($this->nopengajuanklaimanklaim),true);
		$criteria->compare('LOWER(pembayaranpelayanan_t.nopembayaran)', strtolower($this->nopembayaran),true);
		
		$criteria->compare('t.jmlpiutang',$this->jmlpiutang);
		$criteria->compare('t.jumlahbayar',$this->jumlahbayar);
		$criteria->compare('t.jmlsisapiutang',$this->jmlsisapiutang);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchDetail($id=null){
		$criteria=new CDbCriteria;
		$criteria->join = "JOIN pendaftaran_t ON t.pendaftaran_id = pendaftaran_t.pendaftaran_id "
				. "JOIN pasien_m ON t.pasien_id = pasien_m.pasien_id";
		if(!empty($id)){
			$criteria->addCondition('t.pengajuanklaimpiutang_id = '.$id);
		}
		$criteria->limit=20;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
}
