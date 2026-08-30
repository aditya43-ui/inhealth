<?php

/**
 * This is the model class for table "anamnesa_t".
 *
 * The followings are the available columns in table 'anamnesa_t':
 * @property integer $anamesa_id
 * @property integer $pendaftaran_id
 * @property integer $pasien_id
 * @property integer $triase_id
 * @property integer $pasienadmisi_id
 * @property integer $pegawai_id
 * @property string $tglanamnesis
 * @property string $keluhanutama
 * @property string $keluhantambahan
 * @property string $riwayatpenyakitterdahulu
 * @property string $riwayatpenyakitkeluarga
 * @property string $lamasakit
 * @property string $pengobatanygsudahdilakukan
 * @property string $riwayatalergiobat
 * @property string $riwayatkelahiran
 * @property string $riwayatmakanan
 * @property string $riwayatimunisasi
 * @property string $paramedis_nama
 * @property string $keterangananamesa
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $petugas_triase_id
 * @property boolean $statusmerokok
 * @property integer $jmlrokok_btg_hr
 * @property string $riwayatimunisasiblm
 * @property string $riwayatobatygsering
 * @property string $keb_olahraga
 * @property string $keb_jnsolahraga
 * @property integer $keb_frekuensi_kaliminggu
 * @property string $keb_konsumsialkohol
 * @property string $keb_minumkopi
 * @property string $riwayat_kecelakaan
 * @property string $riwayat_operasi
 * @property string $keb_konsumsidrug
 * @property string $riwayatperjalananpasien
 * @property string $produkperawatan_terakhir
 * @property string $jeniskontrasepsi
 * @property boolean $pernahdirawat
 * @property string $dirawatdimana
 * @property string $riwpenyakitkeldari
 * @property string $penyakitmayor
 * @property string $reaksialergiobat
 * @property string $reaksialergimakanan
 * @property string $riwayatalergilainnya
 * @property string $reaksialergilainnya
 * @property string $gelangtandaalergi
 * @property string $statuspsikologis
 * @property string $statusmental
 * @property string $masalahsebelumnya
 * @property string $prilakukekerasansebelumnya
 * @property boolean $penurunanbb_3bln
 * @property boolean $asupanberkurang
 * @property string $aktifitas_mobilisasi
 * @property string $sebutkan_bantuan
 * @property boolean $resikocedera
 * @property boolean $isgelangresiko
 * @property string $tandasegitigaterpasang
 * @property string $skriningnyeri
 * @property string $skalanyeri
 * @property string $karakteristiknyeri
 * @property string $lokasinyeri
 * @property string $nyeriterasa
 * @property string $nyerihilangbila
 * @property boolean $hubungankeluarga
 * @property string $tempattinggal
 * @property integer $menarcheumur_thn
 * @property integer $siklusmenstruasi_hari
 * @property boolean $siklusmenstruasiteratur
 * @property boolean $dismenorche
 * @property string $hpht
 * @property string $taksiranpersalinan
 * @property string $keluhansaathamil
 * @property string $anc
 * @property string $riwayatkb
 * @property integer $frekmakan_hari
 * @property boolean $makananyangdipantang
 * @property string $ketmakananyangdipantang
 * @property integer $lamatidur_jam_hari
 * @property boolean $masalah
 * @property string $ketmasalah
 * @property boolean $kegiatan_aktivitas
 * @property boolean $olahraga
 * @property boolean $ketergantunganobat
 * @property boolean $minumankeras
 * @property string $statusperkawinan
 * @property integer $jmlperkawinan_kali
 *
 * The followings are the available model relations:
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $pegawai
 * @property PendaftaranT $pendaftaran
 * @property TriaseM $triase
 * @property PengkajianaskepT[] $pengkajianaskepTs
 */
class ATAnamnesaT extends AnamnesaT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}