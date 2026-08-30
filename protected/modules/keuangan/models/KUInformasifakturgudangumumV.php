<?php

/**
 * This is the model class for table "informasifakturgudangumum_v".
 *
 * The followings are the available columns in table 'informasifakturgudangumum_v':
 * @property integer $pembelianbarang_id
 * @property string $tglpembelian
 * @property string $nopembelian
 * @property string $tgldikirim
 * @property integer $sumberdana_id
 * @property string $sumberdana_nama
 * @property integer $terimapersediaan_id
 * @property string $tglterima
 * @property string $nopenerimaan
 * @property string $keterangan_persediaan
 * @property integer $fakturpembelian_id
 * @property string $tglfaktur
 * @property string $nofaktur
 * @property string $tgljatuhtempo
 * @property string $keteranganfaktur
 * @property double $totharganetto
 * @property double $persendiscount
 * @property double $jmldiscount
 * @property double $biayamaterai
 * @property double $totalpajakpph
 * @property double $totalpajakppn
 * @property double $totalhargabruto
 * @property string $nofakturpajak
 * @property integer $instalasi_id
 * @property string $instalasi_nama
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $syaratbayar_id
 * @property string $syaratbayar_nama
 * @property integer $terimapersdetail_id
 * @property integer $barang_id
 * @property string $barang_kode
 * @property string $barang_nama
 * @property string $barang_type
 * @property string $barang_merk
 * @property double $hargabeli
 * @property double $hargasatuan
 * @property double $jmlterima
 * @property string $satuanbeli
 * @property string $kondisibarang
 * @property integer $supplier_id
 * @property string $supplier_kode
 * @property string $supplier_nama
 * @property integer $bayarkesupplier_id
 * @property integer $jurnalrekening_id
 */
class KUInformasifakturgudangumumV extends InformasifakturgudangumumV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasifakturgudangumumV the static model class
	 */
	public $tgl_awal, $tgl_akhir;
	public $tglAwalJatuhTempo, $tglAkhirJatuhTempo;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchLaporan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pembelianbarang_id',$this->pembelianbarang_id);
		$criteria->compare('LOWER(tglpembelian)',strtolower($this->tglpembelian),true);
		$criteria->compare('LOWER(nopembelian)',strtolower($this->nopembelian),true);
		$criteria->compare('LOWER(tgldikirim)',strtolower($this->tgldikirim),true);
		$criteria->compare('sumberdana_id',$this->sumberdana_id);
		$criteria->compare('LOWER(sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('terimapersediaan_id',$this->terimapersediaan_id);
		 $criteria->compare('LOWER(tglterima)',strtolower($this->tglterima),true);
		$criteria->addBetweenCondition('date(tglfaktur)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(nopenerimaan)',strtolower($this->nopenerimaan),true);
		$criteria->compare('LOWER(keterangan_persediaan)',strtolower($this->keterangan_persediaan),true);
		$criteria->compare('fakturpembelian_id',$this->fakturpembelian_id);
//		$criteria->compare('LOWER(tglfaktur)',strtolower($this->tglfaktur),true);
		$criteria->compare('LOWER(nofaktur)',strtolower($this->nofaktur),true);
		$criteria->compare('LOWER(tgljatuhtempo)',strtolower($this->tgljatuhtempo),true);
		$criteria->compare('LOWER(keteranganfaktur)',strtolower($this->keteranganfaktur),true);
		$criteria->compare('totharganetto',$this->totharganetto);
		$criteria->compare('persendiscount',$this->persendiscount);
		$criteria->compare('jmldiscount',$this->jmldiscount);
		$criteria->compare('biayamaterai',$this->biayamaterai);
		$criteria->compare('totalpajakpph',$this->totalpajakpph);
		$criteria->compare('totalpajakppn',$this->totalpajakppn);
		$criteria->compare('totalhargabruto',$this->totalhargabruto);
		$criteria->compare('LOWER(nofakturpajak)',strtolower($this->nofakturpajak),true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		$criteria->compare('syaratbayar_id',$this->syaratbayar_id);
		$criteria->compare('LOWER(syaratbayar_nama)',strtolower($this->syaratbayar_nama),true);
		$criteria->compare('terimapersdetail_id',$this->terimapersdetail_id);
		$criteria->compare('barang_id',$this->barang_id);
		$criteria->compare('LOWER(barang_kode)',strtolower($this->barang_kode),true);
		$criteria->compare('LOWER(barang_nama)',strtolower($this->barang_nama),true);
		$criteria->compare('LOWER(barang_type)',strtolower($this->barang_type),true);
		$criteria->compare('LOWER(barang_merk)',strtolower($this->barang_merk),true);
		$criteria->compare('hargabeli',$this->hargabeli);
		$criteria->compare('hargasatuan',$this->hargasatuan);
		$criteria->compare('jmlterima',$this->jmlterima);
		$criteria->compare('LOWER(satuanbeli)',strtolower($this->satuanbeli),true);
		$criteria->compare('LOWER(kondisibarang)',strtolower($this->kondisibarang),true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('LOWER(supplier_kode)',strtolower($this->supplier_kode),true);
		$criteria->compare('LOWER(supplier_nama)',strtolower($this->supplier_nama),true);
		$criteria->compare('bayarkesupplier_id',$this->bayarkesupplier_id);
		$criteria->compare('jurnalrekening_id',$this->jurnalrekening_id);
		if(isset($_GET['berdasarkanJatuhTempo'])){
            if($_GET['berdasarkanJatuhTempo']>0){
				$criteria->addBetweenCondition('tgljatuhtempo', $this->tglAwalJatuhTempo, $this->tglAkhirJatuhTempo);
			}
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}