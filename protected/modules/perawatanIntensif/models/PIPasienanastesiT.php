<?php

/**
 * This is the model class for table "pasienanastesi_t".
 *
 * The followings are the available columns in table 'pasienanastesi_t':
 * @property integer $pasienanastesi_id
 * @property integer $pasien_id
 * @property integer $jenisanastesi_id
 * @property integer $rencanaoperasi_id
 * @property integer $pasienmasukpenunjang_id
 * @property integer $anastesi_id
 * @property integer $pendaftaran_id
 * @property integer $typeanastesi_id
 * @property string $tglanastesi
 * @property string $dokteranastesi_id
 * @property string $perawatanastesi_id
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $perawatanastesi2_id
 * @property integer $ruangan_id
 * @property string $noanestesi
 * @property string $statusanestesi
 * @property integer $pasienadmisi_id
 *
 * The followings are the available model relations:
 * @property RencanaoperasiT[] $rencanaoperasiTs
 * @property PraanestesiT[] $praanestesiTs
 * @property IntraanestesiT[] $intraanestesiTs
 * @property SuratpersetujuantmT[] $suratpersetujuantmTs
 * @property PascaanestesiT[] $pascaanestesiTs
 * @property RuanganM $ruangan
 * @property AnastesiM $anastesi
 * @property PegawaiM $dokteranastesi
 * @property JenisanastesiM $jenisanastesi
 * @property PasienM $pasien
 * @property PasienmasukpenunjangT $pasienmasukpenunjang
 * @property PendaftaranT $pendaftaran
 * @property PegawaiM $perawatanastesi
 * @property RencanaoperasiT $rencanaoperasi
 * @property TypeanastesiM $typeanastesi
 * @property PegawaiM $perawatanastesi2
 * @property PasienadmisiT $pasienadmisi
 * @property ObatalkespasienT[] $obatalkespasienTs
 */
class PIPasienanastesiT extends PasienanastesiT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienanastesiT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}