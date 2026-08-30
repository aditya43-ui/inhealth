<?php

/**
 * This is the model class for table "pemeriksaanfisik_t".
 *
 * The followings are the available columns in table 'pemeriksaanfisik_t':
 * @property integer $pemeriksaanfisik_id
 * @property integer $gcs_id
 * @property integer $pendaftaran_id
 * @property integer $pegawai_id
 * @property integer $pasienadmisi_id
 * @property integer $pasien_id
 * @property string $tglperiksafisik
 * @property string $keadaanumum
 * @property string $inspeksi
 * @property string $palpasi
 * @property string $perkusi
 * @property string $auskultasi
 * @property string $tekanandarah
 * @property integer $td_systolic
 * @property integer $td_diastolic
 * @property double $meanarteripressure
 * @property integer $detaknadi
 * @property integer $heartindex_i1
 * @property integer $heartindex_i2
 * @property integer $heartindex_i3
 * @property string $suhutubuh
 * @property double $beratbadan_kg
 * @property double $tinggibadan_cm
 * @property double $bb_ideal
 * @property string $pernapasan
 * @property string $paramedis_nama
 * @property string $kelainanpadabagtubuh
 * @property boolean $jn_paten
 * @property boolean $jn_obstruktifpartial
 * @property boolean $jn_obstruktifnormal
 * @property boolean $jn_stridor
 * @property boolean $pgd_simetri
 * @property boolean $pgd_asimetri
 * @property boolean $pgp_normal
 * @property boolean $pgp_kussmaul
 * @property boolean $pgp_takipnea
 * @property boolean $pgp_retraktif
 * @property boolean $pgp_dangkal
 * @property integer $sirkulasi_nadicarotis
 * @property integer $sirkulasi_nadiradialis
 * @property boolean $cfr_kecil_2
 * @property boolean $cfr_besar_2
 * @property boolean $jn_gargling
 * @property boolean $kulit_normal
 * @property boolean $kulit_jaundice
 * @property boolean $kulit_cyanosis
 * @property boolean $kulit_pucat
 * @property boolean $kulit_berkeringat
 * @property string $akral
 * @property integer $gcs_eye
 * @property integer $gcs_verbal
 * @property integer $gcs_motorik
 * @property double $lila
 * @property double $lingkarpinggang
 * @property double $lingkarpinggul
 * @property double $teballemak
 * @property double $tinggilutut
 * @property string $denyutjantung
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property double $lingkarperut_cm
 * @property string $bentukbadan
 * @property string $mata_persepsiwarna
 * @property double $mata_visus_od
 * @property double $mata_visus_os
 * @property string $mata_penglihatanjauh
 * @property string $mata_kelainan
 * @property integer $klasifikasitekanandarah_id
 * @property boolean $adakelgastrointestinal
 * @property string $gastrointestinal_sebutkan
 * @property boolean $pembatasanmakanan
 * @property string $batasmakanan_sebutkan
 * @property boolean $gigipalsu
 * @property string $gigipalsu_bagian
 * @property boolean $mual
 * @property boolean $muntah
 * @property boolean $pendengaran
 * @property string $pendengaran_sebutkan
 * @property boolean $penglihatan
 * @property string $penglihatan_sebutkan
 * @property boolean $defekasi
 * @property string $defekasi_sebutkan
 * @property boolean $miksi
 * @property string $miksi_sebutkan
 * @property boolean $hamil
 * @property string $hpht
 * @property string $keluhanmenstruasi
 * @property integer $skornorton
 * @property boolean $resikodekubitus
 * @property boolean $terdapatluka
 * @property string $lokasiluka
 * @property boolean $hambatanpembelajaran
 * @property string $hambatanpembelajaran_ya
 * @property boolean $butuhpenerjemah
 * @property string $kebutuhanpembelajaran
 * @property double $bbsebelumhamil_kg
 * @property boolean $rambut_mengkilat
 * @property boolean $rambut_kusam
 * @property boolean $rambut_mudahrontok
 * @property boolean $rambut_kotor
 * @property boolean $rambut_bersih
 * @property boolean $mata_konjungtiva_anemis
 * @property boolean $mata_sklera_ikterik
 * @property boolean $mata_penglihatan
 * @property boolean $hidung_bersih
 * @property boolean $sumbatanjalannafas
 * @property boolean $bibir_simetris
 * @property integer $jumlahgigi_buah
 * @property boolean $gigi_karies
 * @property boolean $leher_kelenjartiroid_teraba
 * @property boolean $leher_kelgetahbening_teraba
 * @property boolean $dada_bentukmamae_simetris
 * @property boolean $dada_tumor
 * @property string $dada_putingsusu
 * @property boolean $dada_kolostrum
 * @property string $dada_warnaareola
 * @property boolean $bentuk_ekstremitas
 * @property boolean $ekstremitas_kelainan_oedema
 * @property boolean $ekstremitas_kelainan_varies
 * @property boolean $ekstremitas_kelainan_parese
 * @property boolean $ekstremitas_kelainan_atropi
 * @property boolean $abdo_insp_pelebaranvena
 * @property boolean $abdo_insp_nigra
 * @property boolean $abdo_insp_striae
 * @property boolean $kontraksi_palpasi
 * @property string $ketkontraksi
 * @property string $leopold1_tfu
 * @property string $leopold1_fu_terisi
 * @property string $leopold2_kanan
 * @property string $leopold2_kiri
 * @property string $leopold3_bagbawahterisi
 * @property string $leopold4_pathgambar
 * @property integer $frek_auskultasi
 * @property boolean $frekuensiteratur
 * @property string $kelainan_genitalia
 * @property string $pengeluaran_genitalia
 * @property string $vaginal_genitalia
 * @property string $portio_genitalia
 * @property string $pembukaan_genitalia
 * @property string $ketuban_genitalia
 * @property string $presentasi_genitalia
 * @property string $posisi_genitalia
 * @property string $penurunan_genitalia
 * @property string $kekuatanotot
 *
 * The followings are the available model relations:
 * @property GcsM $gcs
 * @property PasienM $pasien
 * @property PasienadmisiT $pasienadmisi
 * @property PegawaiM $pegawai
 * @property PendaftaranT $pendaftaran
 * @property KlasifikasitekanadarahM $klasifikasitekanandarah
 * @property PengkajianaskepT[] $pengkajianaskepTs
 */
class ATPemeriksaanfisikT extends PemeriksaanfisikT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PemeriksaanfisikT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}