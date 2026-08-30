<?php

/**
 * This is the model class for table "obatalkes_m".
 *
 * The followings are the available columns in table 'obatalkes_m':
 * @property integer $obatalkes_id
 * @property integer $jenisobatalkes_id
 * @property integer $sumberdana_id
 * @property integer $lokasigudang_id
 * @property integer $satuankecil_id
 * @property integer $satuanbesar_id
 * @property integer $subjenis_id
 * @property integer $generik_id
 * @property string $obatalkes_barcode
 * @property string $obatalkes_kode
 * @property string $obatalkes_nama
 * @property string $obatalkes_namalain
 * @property string $obatalkes_golongan
 * @property string $obatalkes_kategori
 * @property string $obatalkes_kadarobat
 * @property integer $kemasanbesar
 * @property integer $kekuatan
 * @property string $satuankekuatan
 * @property double $ppn_persen
 * @property double $harganetto
 * @property double $hargajual
 * @property double $hargamaksimum
 * @property double $hargaminimum
 * @property double $hargaaverage
 * @property double $margin
 * @property double $gp_persen
 * @property double $discount
 * @property string $tglkadaluarsa
 * @property integer $minimalstok
 * @property string $formularium
 * @property boolean $discountinue
 * @property string $image_obat
 * @property string $activedate
 * @property boolean $mintransaksi
 * @property boolean $obatalkes_aktif
 * @property boolean $obatalkes_farmasi
 * @property string $noregister
 * @property string $nobatch
 * @property double $marginresep
 * @property double $jasadokter
 * @property double $hjaresep
 * @property double $marginnonresep
 * @property double $hjanonresep
 * @property double $hpp
 * @property string $jnskelompok
 * @property string $ven
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property integer $pabrik_id
 * @property integer $atc_id
 * @property integer $maksimalstok
 * @property integer $urutan_ven
 * @property string $signa_obatalkes
 * @property integer $satuanterkecil_id
 * @property integer $kemasanterkecil
 *
 * The followings are the available model relations:
 * @property StokobatalkesT[] $stokobatalkesTs
 * @property StokopnamedetT[] $stokopnamedetTs
 * @property UbahhargaobatR[] $ubahhargaobatRs
 * @property TerimamutasidetailT[] $terimamutasidetailTs
 * @property ProduksiobatdetT[] $produksiobatdetTs
 * @property PemusnahanoadetailT[] $pemusnahanoadetailTs
 * @property ObatsupplierM[] $obatsupplierMs
 * @property ObatalkesproduksiM[] $obatalkesproduksiMs
 * @property DiagnosaM[] $diagnosaMs
 * @property RencdetailkebT[] $rencdetailkebTs
 * @property GenerikM $generik
 * @property JenisobatalkesM $jenisobatalkes
 * @property LokasigudangM $lokasigudang
 * @property SatuanbesarM $satuanbesar
 * @property SatuankecilM $satuankecil
 * @property SubjenisM $subjenis
 * @property SumberdanaM $sumberdana
 * @property AtcM $atc
 * @property PabrikM $pabrik
 * @property SatuankecilM $satuanterkecil
 * @property ProduksiobatT[] $produksiobatTs
 * @property FormstokopnameR[] $formstokopnameRs
 * @property ObatalkespasienT[] $obatalkespasienTs
 * @property PenerimaandetailT[] $penerimaandetailTs
 * @property ReturdetailT[] $returdetailTs
 * @property PermintaandetailT[] $permintaandetailTs
 * @property FakturdetailT[] $fakturdetailTs
 * @property UnitdosisdetailT[] $unitdosisdetailTs
 * @property ResepturdetailT[] $resepturdetailTs
 * @property Rl313Obat[] $rl313Obats
 * @property PesanoadetailT[] $pesanoadetailTs
 * @property PenawarandetailT[] $penawarandetailTs
 * @property PaketbmhpM[] $paketbmhpMs
 * @property ObatalkesdetailM[] $obatalkesdetailMs
 * @property PermohonanoadetailT[] $permohonanoadetailTs
 * @property JeniskasuspenyakitM[] $jeniskasuspenyakitMs
 * @property MutasioadetailT[] $mutasioadetailTs
 * @property OasudahbayarT[] $oasudahbayarTs
 */
ini_set('memory_limit', '512M'); //Raise to 512 MB

class ATObatalkesM extends ObatalkesM
{
	public $sumberdana_nama,$jenisobatalkes_nama;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObatalkesM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->join = "JOIN sumberdana_m ON sumberdana_m.sumberdana_id = t.sumberdana_id 
						JOIN satuankecil_m ON satuankecil_m.satuankecil_id = t.satuankecil_id
						LEFT JOIN jenisobatalkes_m ON jenisobatalkes_m.jenisobatalkes_id = t.jenisobatalkes_id
					";
		if(!empty($this->obatalkes_id)){
			$criteria->addCondition('obatalkes_id = '.$this->obatalkes_id);
		}
		if(!empty($this->sumberdana_id)){
			$criteria->addCondition('t.sumberdana_id = '.$this->sumberdana_id);
		}
		if(!empty($this->satuankecil_id)){
			$criteria->addCondition('t.satuankecil_id = '.$this->satuankecil_id);
		}
		if(!empty($this->jenisobatalkes_id)){
			$criteria->addCondition('t.jenisobatalkes_id = '.$this->jenisobatalkes_id);
		}
		$criteria->compare('LOWER(obatalkes_kode)',strtolower($this->obatalkes_kode),true);
		$criteria->compare('LOWER(obatalkes_nama)',strtolower($this->obatalkes_nama),true);
		$criteria->compare('LOWER(obatalkes_golongan)',strtolower($this->obatalkes_golongan),true);
		$criteria->compare('LOWER(obatalkes_kategori)',strtolower($this->obatalkes_kategori),true);
		$criteria->compare('LOWER(tglkadaluarsa)',strtolower($this->tglkadaluarsa),true);
		$criteria->compare('LOWER(satuankecil_m.satuankecil_nama)',strtolower($this->satuankecil_nama),true);
		$criteria->compare('LOWER(sumberdana_m.sumberdana_nama)',strtolower($this->sumberdana_nama),true);
		$criteria->compare('LOWER(jenisobatalkes_m.jenisobatalkes_nama)',strtolower($this->jenisobatalkes_nama),true);
		$criteria->addCondition('obatalkes_aktif = TRUE');
		//RND-12818
		//$criteria->order='obatalkes_nama ASC';
		$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
//			'pagination'=>false,
		));
	}
}