<?php

/**
 * This is the model class for table "asesmenawalkeperawatan_t".
 *
 * The followings are the available columns in table 'asesmenawalkeperawatan_t':
 * @property integer $asesmenawalkeperawatan_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $paramedis_nama
 * @property integer $dokterpemeriksa_id
 * @property string $jam_masukruangan
 * @property string $tgl_assesmen_awal
 * @property string $keluhanutama
 * @property string $keluhantambahan
 * @property string $riwayatperjalanan_penyakitpasien
 * @property string $lamasakit
 * @property string $lamasakit_satuanwaktu
 * @property string $riwayatpenyakitterdahulu
 * @property string $riwayatpenyakitkeluarga
 * @property string $riwayatpembedahananastesi
 * @property string $statusalergipasien
 * @property string $riwayatalergiobat
 * @property string $riwayatalergimakanan
 * @property string $riwayatalergilainnya
 * @property string $pengobatanygsudahdilakukan
 * @property string $obatyangdibawa
 * @property string $obatygrutindigunakan
 * @property string $riwayatkelahiran
 * @property string $riwayatimunisasi
 * @property boolean $statusmerokok
 * @property integer $jmlrokok_btg_hr
 * @property string $keterangananamesa
 * @property string $kesadaranpasien
 * @property string $kondisiumum
 * @property string $kebutuhankhusus_status
 * @property boolean $kebutuhankhusus_isgigipalsu
 * @property string $kebutuhankhusus_ketgigipalsu
 * @property boolean $kebutuhankhusus_isalatbantudengar
 * @property string $kebutuhankhusus_ketalatbantudengar
 * @property boolean $kebutuhankhusus_ispakaikacamata
 * @property string $kebutuhankhusus_ketpakaikacamata
 * @property boolean $kebutuhankhusus_istongkat
 * @property string $kebutuhankhusus_kettongkat
 * @property boolean $kebutuhankhusus_islainnya
 * @property string $kebutuhankhusus_ketlainnya
 * @property string $kebutuhankhusus_jenislainnya
 * @property integer $td_systolic
 * @property integer $td_diastolic
 * @property string $tekanandarah
 * @property double $meanarteripressure
 * @property integer $detaknadi
 * @property string $denyutjantung
 * @property integer $pernapasan
 * @property double $suhutubuh
 * @property double $tinggibadan_cm
 * @property double $beratbadan_kg
 * @property double $bb_ideal
 * @property string $kelainanpadabagtubuh
 * @property string $tandavital_reflekcahaya
 * @property double $tandavital_spo2
 * @property boolean $kepala_hasilperiksa
 * @property string $kepala_abnormalketerangan
 * @property boolean $mata_hasilperiksa
 * @property string $mata_abnormalketerangan
 * @property boolean $leher_hasilperiksa
 * @property string $leher_abnormalketerangan
 * @property boolean $hidung_hasilperiksa
 * @property string $hidung_abnormalketerangan
 * @property boolean $telinga_hasilperiksa
 * @property string $telinga_abnormalketerangan
 * @property boolean $mulut_hasilperiksa
 * @property string $mulut_abnormalketerangan
 * @property boolean $jantung_hasilperiksa
 * @property string $jantung_abnormalketerangan
 * @property boolean $paru_hasilperiksa
 * @property string $paru_abnormalketerangan
 * @property boolean $abdomen_hasilperiksa
 * @property string $abdomen_abnormalketerangan
 * @property boolean $genitalia_hasilperiksa
 * @property string $genitalia_abnormalketerangan
 * @property boolean $extremitasatas_hasilperiksa
 * @property string $extremitasatas_abnormalketerangan
 * @property boolean $extremitasbawah_hasilperiksa
 * @property string $extremitasbawah_abnormalketerangan
 * @property boolean $kulit_hasilperiksa
 * @property string $kulit_abnormalketerangan
 * @property boolean $statuspsikologis_isstabil
 * @property string $statuspsikologis_ketstabil
 * @property boolean $statuspsikologis_iscemas
 * @property string $statuspsikologis_ketcemas
 * @property boolean $statuspsikologis_ismarah
 * @property string $statuspsikologis_ketmarah
 * @property boolean $statuspsikologis_issedih
 * @property string $statuspsikologis_ketsedih
 * @property boolean $statuspsikologis_islainnya
 * @property string $statuspsikologis_ketlainnya
 * @property string $statuspsikologis_lainnya
 * @property string $hambatansosial_status
 * @property string $hambatansosial_keteranganada
 * @property string $hambatanekonomi_status
 * @property string $hambatanekonomi_keteranganada
 * @property string $hambatanspiritual_status
 * @property string $hambatanspiritual_keteranganada
 * @property string $nilaikepercayaan_status
 * @property string $nilaikepercayaan_keteranganada
 * @property integer $skrinningfungsional_skor_makan
 * @property integer $skrinningfungsional_skor_aktifitastoilet
 * @property integer $skrinningfungsional_skor_berpindahkursi
 * @property integer $skrinningfungsional_skor_kebersihanmandiri
 * @property integer $skrinningfungsional_skor_mandi
 * @property integer $skrinningfungsional_skor_berjalanpermukaankasar
 * @property integer $skrinningfungsional_skor_naikturuntangga
 * @property integer $skrinningfungsional_skor_berpakaian
 * @property integer $skrinningfungsional_skor_mengontroldefekasi
 * @property integer $skrinningfungsional_skor_mengontrolberkemih
 * @property integer $skrinningfungsional_jumlah_skor
 * @property string $skrinningfungsional_keterangan
 * @property string $skrinningfungsional_kategori
 * @property boolean $isskrinninggizidewasa
 * @property string $skrinninggizi_jwb_penurunanbb_dewasa
 * @property integer $skrinninggizi_skor_penurunanbb_dewasa
 * @property string $skrinninggizi_jwb_asupanmakanan_dewasa
 * @property integer $skrinninggizi_skor_asupanmakanan_dewasa
 * @property integer $skrinninggizi_skor_totaldewasa
 * @property string $skrinninggizi_jwb_tampakkurus
 * @property integer $skrinninggizi_skor_tampakkurus
 * @property string $skrinninggizi_jwb_penurunanbb
 * @property integer $skrinninggizi_skor_penurunanbb
 * @property string $skrinninggizi_jwb_kondisi
 * @property integer $skrinninggizi_skor_kondisi
 * @property string $skrinninggizi_jwb_penyakit
 * @property integer $skrinninggizi_skor_penyakit
 * @property integer $skrinninggizi_skor_totalanak
 * @property boolean $isadaresikojatuh
 * @property string $resikojatuh_tingkat
 * @property string $jenisresikojatuh
 * @property string $riwayatjatuh_penilaian
 * @property integer $riwayatjatuh_skor
 * @property string $diagnosismedis_penilaian
 * @property integer $diagnosismedis_skor
 * @property string $alatbantujalan_penilaian
 * @property integer $alatbantujalan_skor
 * @property string $memakaiterapiheparin_penilaian
 * @property integer $memakaiterapiheparin_skor
 * @property string $caraberjalan_penilaian
 * @property integer $caraberjalan_skor
 * @property string $statusmental_penilaian
 * @property integer $statusmental_skor
 * @property integer $resikojatuh_skor
 * @property string $resikojatuh_keterangan
 * @property string $usia_anak
 * @property integer $skor_usia_anak
 * @property string $jeniskelamin_anak
 * @property integer $skor_jeniskelamin_anak
 * @property string $diagnosa_asessment_anak
 * @property integer $skor_diagnosa_anak
 * @property string $gangguan_kognitif_anak
 * @property integer $skor_gangguan_kognitif_anak
 * @property string $faktor_lingkungan_anak
 * @property integer $skor_faktor_lingkungan_anak
 * @property string $responterhadap_pembedahan_anak
 * @property integer $skor_responterhadap_pembedahan_anak
 * @property string $penggunaan_medikamentosa
 * @property integer $skor_medikamentosa_anak
 * @property integer $jumlah_skor_anak
 * @property string $keterangan_resiko_jatuh_anak
 * @property boolean $resiko_jatuh_lansia
 * @property integer $skor_resiko_jatuh_lansia
 * @property boolean $status_mental_lansia
 * @property integer $skor_status_mental_lansia
 * @property boolean $penglihatan_lansia
 * @property integer $skor_penglihatan_lansia
 * @property boolean $kebiasaan_berkemih_lansia
 * @property integer $skor_berkemih_lansia
 * @property string $transfer_mobilitas_lansia
 * @property integer $skor_transfer_mobilitas_lansia
 * @property string $mobilitas_lansia
 * @property integer $skor_mobilitas_lansia
 * @property integer $jumlah_skor_lansia
 * @property string $keterangan_skor_lansia
 * @property boolean $riwayatjatuh_3bln_terakhir
 * @property boolean $riwayatjatuh_alatbantu
 * @property string $riwayatjatuh_jenisalatbantu
 * @property string $riwayatjatuh_jenisalatbantulainnya
 * @property boolean $is_keluhannyeri_dewasa
 * @property integer $score_skalanyeri
 * @property string $keteranganskala_nyeri
 * @property string $deskripsinyeri_penyebabtimbul
 * @property string $deskripsinyeri_karakteristik
 * @property string $deskripsinyeri_lokasiskalanyeri
 * @property string $deskripsinyeri_durasinyeri
 * @property string $deskripsinyeri_frekuensinyeri
 * @property boolean $deskripsinyeri_ismenjalar
 * @property string $deskripsinyeri_lokasipenjalaran
 * @property boolean $isnyerihilangdgn_minumobat
 * @property string $nyerihilangdgn_minumobatket
 * @property boolean $isnyerihilangdgn_berubahposisi
 * @property string $nyerihilangdgn_berubahposisiket
 * @property boolean $isnyerihilangdgn_istirahat
 * @property string $nyerihilangdgn_istirahatket
 * @property boolean $isnyerihilangdgn_dengarmusik
 * @property string $nyerihilangdgn_dengarmusikket
 * @property boolean $isnyerihilangdgn_lainlain
 * @property string $nyerihilangdgn_lainlainket
 * @property string $nyerihilangdgn_lainlainjenis
 * @property string $rentanggerak
 * @property boolean $deformitas_status
 * @property string $deformitas_regio
 * @property boolean $gangguantidur_status
 * @property string $gangguantidur_keterangan
 * @property boolean $keb_nutricairankeluhan_status
 * @property boolean $keb_nutricairankeluhan_ismual
 * @property string $keb_nutricairankeluhan_mualket
 * @property boolean $keb_nutricairankeluhan_ismuntah
 * @property string $keb_nutricairankeluhan_muntahket
 * @property boolean $keb_nutricairankeluhan_isgangguanmengunyah
 * @property string $keb_nutricairankeluhan_gangguanmengunyahket
 * @property boolean $keb_nutricairankeluhan_isgangguanmenelan
 * @property string $keb_nutricairankeluhan_gangguanmenelanket
 * @property boolean $keb_nutricairan_rasahausberlebih
 * @property string $keb_nutricairan_turgorkulit
 * @property string $keb_nutricairan_mukosamulut
 * @property boolean $keb_nutricairan_edemastatus
 * @property string $keb_nutricairan_edemalokasi
 * @property integer $keb_eliminasi_bab_frekuensi
 * @property boolean $keb_eliminasi_bab_keluhanstatus
 * @property boolean $keb_eliminasi_bab_ispendarahan
 * @property string $keb_eliminasi_bab_ketpendarahan
 * @property boolean $keb_eliminasi_bab_ishemorroid
 * @property string $keb_eliminasi_bab_kethemorroid
 * @property boolean $keb_eliminasi_bab_iskonstipasi
 * @property string $keb_eliminasi_bab_ketkonstipasi
 * @property boolean $keb_eliminasi_bab_iskeluhanlainnya
 * @property string $keb_eliminasi_bab_ketkeluhanlainnya
 * @property string $keb_eliminasi_bab_jeniskeluhanlainnya
 * @property string $keb_eliminasi_bab_karakteristik
 * @property string $keb_eliminasi_bab_warnafeces
 * @property boolean $keb_eliminasi_bab_status
 * @property integer $keb_eliminasi_bak_frekuensi
 * @property double $keb_eliminasi_bak_jumlah
 * @property string $keb_eliminasi_bak_warnaurin
 * @property boolean $keb_eliminasi_bak_keluhanstatus
 * @property boolean $keb_eliminasi_bak_ispendarahan
 * @property string $keb_eliminasi_bak_ketpendarahan
 * @property boolean $keb_eliminasi_bak_isnyeri
 * @property string $keb_eliminasi_bak_ketnyeri
 * @property boolean $keb_eliminasi_bak_iskeluhanlainnya
 * @property string $keb_eliminasi_bak_ketkeluhanlainnya
 * @property string $keb_eliminasi_bak_jeniskeluhanlainnya
 * @property boolean $keb_eliminasi_bak_status
 * @property boolean $identifikasipenyakit_ismenular
 * @property string $identifikasipenyakit_ketmenular
 * @property string $identifikasipenyakit_menularketerangan
 * @property boolean $identifikasipenyakit_ispenyakitjiwa
 * @property string $identifikasipenyakit_ketpenyakitjiwa
 * @property boolean $identifikasipenyakitjiwa_iscenderungbunuhdiri
 * @property string $identifikasipenyakit_ketcenderungbunuhdiri
 * @property boolean $identifikasipenyakitjiwa_isberlakuagresif
 * @property string $identifikasipenyakit_ketberlakuagresif
 * @property boolean $identifikasipenyakitjiwa_islainnya
 * @property string $identifikasipenyakit_ketlainnya
 * @property string $identifikasipenyakitjiwa_keteranganlainnya
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 * @property string $riwayatpembedahan_status
 * @property string $riwayatpembedahan_keterangan
 * @property string $kebutuhankhusus_ketcemas
 * @property string $datasubjektif
 * @property boolean $resikojatuhkhususrj_hasilpenilaian_a
 * @property boolean $resikojatuhkhususrj_hasilpenilaian_b
 * @property string $resikojatuhkhususrj_hasilpengkajian
 * @property string $resikojatuhkhususrj_tindakanygdiperlukan
 * @property integer $pasien_id
 * @property integer $neonatus_anakke
 * @property integer $neonatus_umurkehamilan
 * @property boolean $neonatus_ispenyakitibudm
 * @property string $neonatus_penyakitibu
 * @property boolean $neonatus_ispenyakitibuhipertensi
 * @property boolean $neonatus_ispenyakitibujantung
 * @property boolean $neonatus_ispenyakitibutbc
 * @property boolean $neonatus_ispenyakitibuhepatitisb
 * @property boolean $neonatus_ispenyakitibuasma
 * @property boolean $neonatus_ispenyakitibupms
 * @property boolean $neonatus_ispenyakitibulainnya
 * @property string $neonatus_penyakitibu_lainnyaket
 * @property string $neonatus_riwayatpengobatanibu
 * @property string $neonatus_diagnosaibu
 * @property string $neonatus_jamlahir
 * @property string $neonatus_tgllahirbayi
 * @property string $neonatus_kondisisaatlahir
 * @property string $neonatus_carapersalinan
 * @property integer $neonatus_apgarscore
 * @property string $neonatus_letak
 * @property string $neonatus_talipusat
 * @property boolean $neonatus_faktorinfeksimayor_ibudemam
 * @property boolean $neonatus_faktorinfeksimayor_kpdlebihdr24jam
 * @property boolean $neonatus_faktorinfeksimayor_ketubanhijau
 * @property boolean $neonatus_faktorinfeksimayor_korioamnionitis
 * @property boolean $neonatus_faktorinfeksimayor_fetaldistress
 * @property string $neonatus_faktorinfeksimayor_ket
 * @property boolean $neonatus_faktorinfeksiminor_kpdkurangdr12jam
 * @property boolean $neonatus_faktorinfeksiminor_asfiksia
 * @property boolean $neonatus_faktorinfeksiminor_bblr
 * @property boolean $neonatus_faktorinfeksiminor_isk
 * @property boolean $neonatus_faktorinfeksiminor_ukkurangdr37minggu
 * @property boolean $neonatus_faktorinfeksiminor_gemeli
 * @property boolean $neonatus_faktorinfeksiminor_keputihan
 * @property boolean $neonatus_faktorinfeksiminor_ibutemplebihdr37
 * @property string $neonatus_faktorinfeksiminor_ket
 * @property boolean $neonatus_nutrisiasi
 * @property double $neonatus_nutrisiasi_frekuensijml
 * @property integer $neonatus_nutrisiasi_frekuensikali
 * @property string $neonatus_nutrisilainnyaket
 * @property string $neonatus_alergidikajikpd
 * @property boolean $ispasangtandaalergi
 * @property boolean $neonatus_nutrisilainnya
 * @property string $jenisasesmen
 * @property integer $khususanak_usiaibu_saathamil
 * @property integer $khususanak_gravida_g
 * @property integer $khususanak_gravida_p
 * @property integer $khususanak_gravida_a
 * @property string $khususanak_gangguanhamil
 * @property string $khususanak_tipepersalinan
 * @property integer $khususanak_beratbadanlahir
 * @property integer $khususanak_tinggibadan
 * @property string $neonatus_kebpsikologidikasikpd
 * @property string $neonatus_masalahperkawinanortu
 * @property string $neonatus_masalahperkawinanortuket
 * @property string $neonatus_kekerasanfisikortu
 * @property boolean $neonatus_kekerasanfisikortu_iscederadiri
 * @property boolean $neonatus_kekerasanfisikortu_isorglain
 * @property string $neonatus_traumadlmhiduportu
 * @property string $neonatus_traumadlmhiduportuket
 * @property string $neonatus_konsulpsikologortu
 * @property string $neonatus_penerimaankondisibayi
 * @property string $neonatus_dukungansosialdr
 * @property boolean $neonatus_dukungansosialdr_issuami
 * @property boolean $neonatus_dukungansosialdr_isistri
 * @property boolean $neonatus_dukungansosialdr_isortu
 * @property boolean $neonatus_dukungansosialdr_iskeluarga
 * @property boolean $neonatus_dukungansosialdr_islainnya
 * @property string $neonatus_dukungansosialdr_lainnyaket
 * @property string $neonatus_kebsosialekonomi_pihakygdikaji
 * @property string $neonatus_kebsosialekonomi_pihakygdikajilainnya
 * @property string $neonatus_kebsosialekonomi_statusperkawinan
 * @property integer $neonatus_jmlmenikahortu
 * @property string $neonatus_pendidikanortu
 * @property string $neonatus_warganegaraortu
 * @property string $neonatus_pekerjaanortu
 * @property string $neonatus_tinggalbersama
 * @property string $neonatus_tinggalbersamalainnya_nama
 * @property string $neonatus_tinggalbersamalainnya_notlp
 * @property boolean $neonatus_kebiasaanortualkohol_status
 * @property string $neonatus_kebiasaanortualkohol_jenis
 * @property double $neonatus_kebiasaanortualkohol_jml
 * @property string $neonatus_kebiasaanortulainnya
 * @property string $neonatus_agamaortu
 * @property integer $neonatus_cries_totalnilai
 * @property integer $neonatus_cries_cryingnilai
 * @property string $neonatus_cries_cryingket
 * @property integer $neonatus_cries_requiresnilai
 * @property string $neonatus_cries_requiresket
 * @property integer $neonatus_cries_increasednilai
 * @property string $neonatus_cries_increasedket
 * @property integer $neonatus_cries_expressionnilai
 * @property string $neonatus_cries_expressionket
 * @property integer $neonatus_cries_sleeplessnilai
 * @property string $neonatus_cries_sleeplessket
 *
 * The followings are the available model relations:
 * @property AsesmenkebutuhanEdukasiT[] $asesmenkebutuhanEdukasiTs
 * @property PasienadmisiT $pasienadmisi
 * @property PendaftaranT $pendaftaran
 * @property SkrinningnyerianakdetT[] $skrinningnyerianakdetTs
 */
class AsesmenawalkeperawatanT extends CActiveRecord
{
	public $is_dbn, $isresikojatuh, $isasesmenawalkep;
	public $skrinninggizi_jwb_penurunanbb_dewasa_text, $skrinninggizi_jwb_asupanmakanan_dewasa_text, $skrinninggizi_jwb_tampakkurus_text, $skrinninggizi_jwb_penurunanbb_text, $skrinninggizi_jwb_kondisi_text, $skrinninggizi_jwb_penyakit_text;
	public $riwayatjatuh_penilaian_text, $diagnosismedis_penilaian_text, $alatbantujalan_penilaian_text, $memakaiterapiheparin_penilaian_text, $caraberjalan_penilaian_text, $statusmental_penilaian_text;
	public $usia_anak_text, $jeniskelamin_anak_text, $diagnosa_asessment_anak_text, $gangguan_kognitif_anak_text, $faktor_lingkungan_anak_text, $responterhadap_pembedahan_anak_text, $penggunaan_medikamentosa_text;
	public $score_skalanyeri_anak, $keteranganskala_nyeri_anak;
	public $jam_masukruangan_anak, $tgl_assesmen_awal_anak, $jam_masukruangan_dws, $tgl_assesmen_awal_dws, $kondisiumum_dws, $keluhanutama_dws, $keluhantambahan_dws, $kepala_abnormalketerangan_dws, $mata_abnormalketerangan_dws, $leher_abnormalketerangan_dws, $hidung_abnormalketerangan_dws, $telinga_abnormalketerangan_dws, $mulut_abnormalketerangan_dws, $jantung_abnormalketerangan_dws, $paru_abnormalketerangan_dws, $abdomen_abnormalketerangan_dws, $genitalia_abnormalketerangan_dws, $extremitasatas_abnormalketerangan_dws, $extremitasbawah_abnormalketerangan_dws, $kulit_abnormalketerangan_dws;
	public $isneonatus_cries_crying, $isneonatus_cries_requires, $isneonatus_cries_increased, $isneonatus_cries_expression, $isneonatus_cries_sleepless;
	public $keb_eliminasi_bab_keluhanstatus_neonatus, $keb_eliminasi_bab_ispendarahan_neonatus, $keb_eliminasi_bab_ishemorroid_neonatus, $keb_eliminasi_bab_iskonstipasi_neonatus, $keb_eliminasi_bab_iskeluhanlainnya_neonatus, $keb_eliminasi_bab_jeniskeluhanlainnya_neonatus, $keb_eliminasi_bak_keluhanstatus_neonatus, $keb_eliminasi_bak_isnyeri_neonatus, $keb_eliminasi_bak_ispendarahan_neonatus, $keb_eliminasi_bak_iskeluhanlainnya_neonatus, $keb_eliminasi_bak_jeniskeluhanlainnya_neonatus, $statusalergipasien_neonatus, $riwayatalergiobat_neonatus, $riwayatalergimakanan_neonatus, $riwayatalergilainnya_neonatus, $ispasangtandaalergi_neonatus;
	public $neonatus_kebsosialekonomi_statusperkawinan_dws, $neonatus_tinggalbersamalainnya_notlp_dws, $neonatus_tinggalbersamalainnya_nama_dws, $neonatus_tinggalbersama_dws, $neonatus_pekerjaanortu_dws, $neonatus_warganegaraortu_dws, $neonatus_pendidikanortu_dws, $neonatus_kebiasaanortualkohol_status_dws, $neonatus_kebiasaanortualkohol_jenis_dws, $neonatus_kebiasaanortualkohol_jml_dws, $neonatus_kebiasaanortulainnya_dws, $neonatus_agamaortu_dws;
	public $kualitasnyeri_lainnya, $keluhanutama_obgyn, $keluhantambahan_obgyn, $jam_masukruangan_obgyn, $tgl_assesmen_awal_obgyn;
	public $obgyn_jumlahperkawainan, $isfungsional;
	public $diagnosa_utama, $diagnosa_tambahan, $score_skalanyeri_dws, $keteranganskala_nyeri_dws, $skriningnyeribps_ekspresiwajahpenilaian_text, $skriningnyeribps_ekstremitasataspenilaian_text, $skriningnyeribps_kepatuhanventilatorpenilaian_text;
	public $jam_masukruangan_neonatus, $tgl_assesmen_awal_neonatus, $keluhanutama_neonatus, $keluhantambahan_neonatus;
	public $jam_masukruangan_geriatri, $tgl_assesmen_awal_geriatri, $keluhanutama_geriatri, $keluhantambahan_geriatri, $kondisiumum_geriatri;


	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AsesmenawalkeperawatanT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'asesmenawalkeperawatan_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, dokterpemeriksa_id, jam_masukruangan, tgl_assesmen_awal, create_time, create_loginpemakai', 'required'),
			array('pendaftaran_id, pasienadmisi_id, dokterpemeriksa_id, jmlrokok_btg_hr, td_systolic, td_diastolic, detaknadi, pernapasan, skrinningfungsional_skor_makan, skrinningfungsional_skor_aktifitastoilet, skrinningfungsional_skor_berpindahkursi, skrinningfungsional_skor_kebersihanmandiri, skrinningfungsional_skor_mandi, skrinningfungsional_skor_berjalanpermukaankasar, skrinningfungsional_skor_naikturuntangga, skrinningfungsional_skor_berpakaian, skrinningfungsional_skor_mengontroldefekasi, skrinningfungsional_skor_mengontrolberkemih, skrinningfungsional_jumlah_skor, skrinninggizi_skor_penurunanbb_dewasa, skrinninggizi_skor_asupanmakanan_dewasa, skrinninggizi_skor_totaldewasa, skrinninggizi_skor_tampakkurus, skrinninggizi_skor_penurunanbb, skrinninggizi_skor_kondisi, skrinninggizi_skor_penyakit, skrinninggizi_skor_totalanak, riwayatjatuh_skor, diagnosismedis_skor, alatbantujalan_skor, memakaiterapiheparin_skor, caraberjalan_skor, statusmental_skor, resikojatuh_skor, skor_usia_anak, skor_jeniskelamin_anak, skor_diagnosa_anak, skor_gangguan_kognitif_anak, skor_faktor_lingkungan_anak, skor_responterhadap_pembedahan_anak, skor_medikamentosa_anak, jumlah_skor_anak, skor_resiko_jatuh_lansia, skor_status_mental_lansia, skor_penglihatan_lansia, skor_berkemih_lansia, skor_transfer_mobilitas_lansia, skor_mobilitas_lansia, jumlah_skor_lansia, score_skalanyeri, keb_eliminasi_bab_frekuensi, keb_eliminasi_bak_frekuensi, create_petugaspengisi_id, create_ruangan_id, pasien_id, neonatus_anakke, neonatus_umurkehamilan, neonatus_apgarscore, neonatus_nutrisiasi_frekuensikali, khususanak_usiaibu_saathamil, khususanak_gravida_g, khususanak_gravida_p, khususanak_gravida_a, khususanak_beratbadanlahir, khususanak_tinggibadan, neonatus_jmlmenikahortu, neonatus_cries_totalnilai, neonatus_cries_cryingnilai, neonatus_cries_requiresnilai, neonatus_cries_increasednilai, neonatus_cries_expressionnilai, neonatus_cries_sleeplessnilai, jml_anak, obgyn_siklushaid, obgyn_menarcheumur, obgyn_lamahaid, obgyn_umurkawinpertama, obgyn_usiakehamilanhpht, obgyn_jumlahperkawainan, skriningnyeribps_ekspresiwajahskor, skriningnyeribps_ekstremitasatasskor, skriningnyeribps_kepatuhanventilatorskor, b1_spo2, b6_skorbraden, b5_babfrekuensi, b4_bakfrekuensi, b3_gcsmotoric_nilai, b3_gcsverbal_nilai, b3_gcseye_nilai, b1_rr, b2_td_systolic, b2_td_diastolic,b2_nadi, neonatus_saatlahir_hr, neonatus_saatlahir_rr, neonatus_saatlahir_spo2, khususanak_gravida_h', 'numerical', 'integerOnly'=>true),
			array('meanarteripressure, suhutubuh, tinggibadan_cm, beratbadan_kg, bb_ideal, tandavital_spo2, keb_eliminasi_bak_jumlah, neonatus_nutrisiasi_frekuensijml, neonatus_kebiasaanortualkohol_jml, beratbadan_biasanya, b1_jmloksigenperliter, b6_suhutubuh, neonatus_saatlahir_suhutubuh, neonatus_saatlahir_lingkarkepala, neonatus_saatlahir_lingkardada', 'numerical'),
			array('paramedis_nama, kebutuhankhusus_jenislainnya, denyutjantung, tandavital_reflekcahaya, statuspsikologis_lainnya, skrinningfungsional_keterangan, skrinninggizi_jwb_penurunanbb_dewasa, skrinninggizi_jwb_asupanmakanan_dewasa, skrinninggizi_jwb_tampakkurus, skrinninggizi_jwb_penurunanbb, skrinninggizi_jwb_kondisi, skrinninggizi_jwb_penyakit, riwayatjatuh_penilaian, diagnosismedis_penilaian, alatbantujalan_penilaian, memakaiterapiheparin_penilaian, caraberjalan_penilaian, statusmental_penilaian, resikojatuh_keterangan, usia_anak, jeniskelamin_anak, diagnosa_asessment_anak, gangguan_kognitif_anak, faktor_lingkungan_anak, penggunaan_medikamentosa, keterangan_resiko_jatuh_anak, transfer_mobilitas_lansia, mobilitas_lansia, keterangan_skor_lansia, riwayatjatuh_jenisalatbantulainnya, keteranganskala_nyeri, deskripsinyeri_lokasipenjalaran, nyerihilangdgn_lainlainjenis, deformitas_regio, keb_nutricairan_edemalokasi, keb_eliminasi_bab_jeniskeluhanlainnya, keb_eliminasi_bab_warnafeces, keb_eliminasi_bak_warnaurin, keb_eliminasi_bak_jeniskeluhanlainnya, identifikasipenyakit_ketberlakuagresif, create_loginpemakai, update_loginpemakai, resikojatuhkhususrj_tindakanygdiperlukan, neonatus_carapersalinan, neonatus_letak, neonatus_talipusat, jenisasesmen, neonatus_cries_cryingket, neonatus_cries_requiresket, neonatus_cries_increasedket, neonatus_cries_expressionket, neonatus_cries_sleeplessket, obgyn_banyaknyahaid, obgyn_antenatalcare_tempat, namapasien_verifikator, b5_abdomen_nyeritekanlokasi,b6_lokasioedema,b6_berkeringatbanyak,b6_lokasiluka,b6_turgorkulit,orangterdekat, b6_lokasifraktur, caratibadiruangan', 'length', 'max'=>100),
			array('lamasakit, statusalergipasien, kesadaranpasien, kebutuhankhusus_status, tekanandarah, hambatansosial_status, hambatanekonomi_status, hambatanspiritual_status, nilaikepercayaan_status, resikojatuh_tingkat, jenisresikojatuh, riwayatjatuh_jenisalatbantu, nyerihilangdgn_minumobatket, nyerihilangdgn_berubahposisiket, nyerihilangdgn_istirahatket, nyerihilangdgn_dengarmusikket, nyerihilangdgn_lainlainket, rentanggerak, keb_nutricairankeluhan_mualket, keb_nutricairankeluhan_muntahket, keb_nutricairankeluhan_gangguanmengunyahket, keb_nutricairankeluhan_gangguanmenelanket, keb_eliminasi_bab_ketpendarahan, keb_eliminasi_bab_kethemorroid, keb_eliminasi_bab_ketkonstipasi, keb_eliminasi_bab_ketkeluhanlainnya, keb_eliminasi_bab_karakteristik, keb_eliminasi_bak_ketpendarahan, keb_eliminasi_bak_ketnyeri, keb_eliminasi_bak_ketkeluhanlainnya, identifikasipenyakit_ketmenular, identifikasipenyakit_ketpenyakitjiwa, identifikasipenyakit_ketcenderungbunuhdiri, identifikasipenyakit_ketlainnya, riwayatpembedahan_status, kebutuhankhusus_ketcemas, neonatus_alergidikajikpd, neonatus_kebpsikologidikasikpd, neonatus_masalahperkawinanortu, neonatus_kekerasanfisikortu, neonatus_traumadlmhiduportu, neonatus_konsulpsikologortu, neonatus_penerimaankondisibayi, neonatus_kebsosialekonomi_pihakygdikaji, neonatus_kebsosialekonomi_statusperkawinan, neonatus_warganegaraortu, nutrisi_perubahanbb6blnterakhir, sumberdata, isada_anak, isadakeluhannyeri, jenisnyeri, deskripsinyeri_onsetsatuan, tingkatannyeri, obgyn_keteraturanhaid, jenis_statusfungsional, riwayattransfusi_status, riwayattransfusi_isreaksi, kesadaranpasien_pengkajiannyeri, b1_iramapernapasan, b2_denyutjantung, b2_akral, b2_crt, b2_isnyerdada,b3_kesimetrisanpupil,b3_ukuranreflek_pupilkanan,b3_ukuranreflek_pupilkiri,b4_bakwarnaurin,b4_isnyeritekankandungkemih,b5_abdomen_kesimetrisan, b6_caraukursuhutubuh, b6_pergerakan, b1_kesulitanbernafas, b5_statusnafasumakan, b6_isfraktur, b6_jenisfraktur, neonatus_warnaketuban', 'length', 'max'=>20),
			array('lamasakit_satuanwaktu, keb_nutricairan_turgorkulit, keb_nutricairan_mukosamulut, obgyn_imunisasittstatus, obgyn_antenatalcare_frekuensi, obgyn_antenatalcare_status', 'length', 'max'=>10),
			array('pengobatanygsudahdilakukan, obatyangdibawa, obatygrutindigunakan, kelainanpadabagtubuh, deskripsinyeri_penyebabtimbul, deskripsinyeri_karakteristik, deskripsinyeri_lokasiskalanyeri, neonatus_traumadlmhiduportuket, sumberdata_lainnya, deskripsinyeri_onset, obgyn_keluhansaathamillainnya, skrininggizidewasa_tindakanygdilakukan, skriningnyeribps_ekspresiwajahpenilaian, skriningnyeribps_ekstremitasataspenilaian, skriningnyeribps_kepatuhanventilatorpenilaian, b2_lokasioedem,b6_turgorkulit,gangguanorientasi_terhadap,b3_paresa, neonatus_sebabkematian', 'length', 'max'=>200),
			array('kebutuhankhusus_ketgigipalsu, kebutuhankhusus_ketalatbantudengar, kebutuhankhusus_ketpakaikacamata, kebutuhankhusus_kettongkat, kebutuhankhusus_ketlainnya, deskripsinyeri_durasinyeri, resikojatuhkhususrj_hasilpengkajian, neonatus_penyakitibu, neonatus_faktorinfeksimayor_ket, neonatus_faktorinfeksiminor_ket, khususanak_tipepersalinan, neonatus_masalahperkawinanortuket, neonatus_dukungansosialdr, neonatus_dukungansosialdr_lainnyaket, neonatus_kebsosialekonomi_pihakygdikajilainnya, neonatus_pendidikanortu, neonatus_pekerjaanortu, neonatus_tinggalbersama, neonatus_tinggalbersamalainnya_nama, neonatus_tinggalbersamalainnya_notlp, neonatus_kebiasaanortualkohol_jenis, neonatus_agamaortu, skrininggizidewasa_resiko, b1_jenisterapioksigen, perasaansaatini, b5_warnafeces, neonatus_jeniskelahiran', 'length', 'max'=>50),
			array('skrinningfungsional_kategori', 'length', 'max'=>5),
			array('responterhadap_pembedahan_anak, neonatus_saatlahir_anus, neonatus_saatlahir_kelahiran', 'length', 'max'=>225),
			array('neonatus_kondisisaatlahir, neonatus_nutrisilainnyaket', 'length', 'max'=>300),
			array('kontrolrisikoinfeksi_status, masalahdlm_berbicara, obgyn_statuskawin, obgyn_golongandarah, b3_kesadaran,b5_mukosamulut, neonatus_placenta, neonatus_jeniskelamin, neonatus_statuskelahiranmati', 'length', 'max'=>30),

			array('keluhanutama, keluhantambahan, riwayatperjalanan_penyakitpasien, riwayatpenyakitterdahulu, riwayatpenyakitkeluarga, riwayatpembedahananastesi, riwayatalergiobat, riwayatalergimakanan, riwayatalergilainnya, riwayatkelahiran, riwayatimunisasi, statusmerokok, keterangananamesa, kondisiumum, kebutuhankhusus_isgigipalsu, kebutuhankhusus_isalatbantudengar, kebutuhankhusus_ispakaikacamata, kebutuhankhusus_istongkat, kebutuhankhusus_islainnya, kepala_hasilperiksa, kepala_abnormalketerangan, mata_hasilperiksa, mata_abnormalketerangan, leher_hasilperiksa, leher_abnormalketerangan, hidung_hasilperiksa, hidung_abnormalketerangan, telinga_hasilperiksa, telinga_abnormalketerangan, mulut_hasilperiksa, mulut_abnormalketerangan, jantung_hasilperiksa, jantung_abnormalketerangan, paru_hasilperiksa, paru_abnormalketerangan, abdomen_hasilperiksa, abdomen_abnormalketerangan, genitalia_hasilperiksa, genitalia_abnormalketerangan, extremitasatas_hasilperiksa, extremitasatas_abnormalketerangan, extremitasbawah_hasilperiksa, extremitasbawah_abnormalketerangan, kulit_hasilperiksa, kulit_abnormalketerangan, statuspsikologis_isstabil, statuspsikologis_ketstabil, statuspsikologis_iscemas, statuspsikologis_ketcemas, statuspsikologis_ismarah, statuspsikologis_ketmarah, statuspsikologis_issedih, statuspsikologis_ketsedih, statuspsikologis_islainnya, statuspsikologis_ketlainnya, hambatansosial_keteranganada, hambatanekonomi_keteranganada, hambatanspiritual_keteranganada, nilaikepercayaan_keteranganada, isskrinninggizidewasa, isadaresikojatuh, resiko_jatuh_lansia, status_mental_lansia, penglihatan_lansia, kebiasaan_berkemih_lansia, riwayatjatuh_3bln_terakhir, riwayatjatuh_alatbantu, is_keluhannyeri_dewasa, deskripsinyeri_ismenjalar, isnyerihilangdgn_minumobat, isnyerihilangdgn_berubahposisi, isnyerihilangdgn_istirahat, isnyerihilangdgn_dengarmusik, isnyerihilangdgn_lainlain, deformitas_status, gangguantidur_status, gangguantidur_keterangan, keb_nutricairankeluhan_status, keb_nutricairankeluhan_ismual, keb_nutricairankeluhan_ismuntah, keb_nutricairankeluhan_isgangguanmengunyah, keb_nutricairankeluhan_isgangguanmenelan, keb_nutricairan_rasahausberlebih, keb_nutricairan_edemastatus, keb_eliminasi_bab_keluhanstatus, keb_eliminasi_bab_ispendarahan, keb_eliminasi_bab_ishemorroid, keb_eliminasi_bab_iskonstipasi, keb_eliminasi_bab_iskeluhanlainnya, keb_eliminasi_bab_status, keb_eliminasi_bak_keluhanstatus, keb_eliminasi_bak_ispendarahan, keb_eliminasi_bak_isnyeri, keb_eliminasi_bak_iskeluhanlainnya, keb_eliminasi_bak_status, identifikasipenyakit_ismenular, identifikasipenyakit_menularketerangan, identifikasipenyakit_ispenyakitjiwa, identifikasipenyakitjiwa_iscenderungbunuhdiri, identifikasipenyakitjiwa_isberlakuagresif, identifikasipenyakitjiwa_islainnya, identifikasipenyakitjiwa_keteranganlainnya, update_time, riwayatpembedahan_keterangan, datasubjektif, resikojatuhkhususrj_hasilpenilaian_a, resikojatuhkhususrj_hasilpenilaian_b, neonatus_ispenyakitibudm, neonatus_ispenyakitibuhipertensi, neonatus_ispenyakitibujantung, neonatus_ispenyakitibutbc, neonatus_ispenyakitibuhepatitisb, neonatus_ispenyakitibuasma, neonatus_ispenyakitibupms, neonatus_ispenyakitibulainnya, neonatus_penyakitibu_lainnyaket, neonatus_riwayatpengobatanibu, neonatus_diagnosaibu, neonatus_jamlahir, neonatus_tgllahirbayi, neonatus_faktorinfeksimayor_ibudemam, neonatus_faktorinfeksimayor_kpdlebihdr24jam, neonatus_faktorinfeksimayor_ketubanhijau, neonatus_faktorinfeksimayor_korioamnionitis, neonatus_faktorinfeksimayor_fetaldistress, neonatus_faktorinfeksiminor_kpdkurangdr12jam, neonatus_faktorinfeksiminor_asfiksia, neonatus_faktorinfeksiminor_bblr, neonatus_faktorinfeksiminor_isk, neonatus_faktorinfeksiminor_ukkurangdr37minggu, neonatus_faktorinfeksiminor_gemeli, neonatus_faktorinfeksiminor_keputihan, neonatus_faktorinfeksiminor_ibutemplebihdr37, neonatus_nutrisiasi, ispasangtandaalergi, neonatus_nutrisilainnya, khususanak_gangguanhamil, neonatus_kekerasanfisikortu_iscederadiri, neonatus_kekerasanfisikortu_isorglain, neonatus_dukungansosialdr_issuami, neonatus_dukungansosialdr_isistri, neonatus_dukungansosialdr_isortu, neonatus_dukungansosialdr_iskeluarga, neonatus_dukungansosialdr_islainnya, neonatus_kebiasaanortualkohol_status, neonatus_kebiasaanortulainnya, deskripsinyeri_frekuensinyerilainnya, kualitasnyeri, nutrisi_perubahanbb6blnterakhirket, nutrisi_dietsaatini, masalahbicara_ket, jenisrisikoinfeksi, jenisrisikoinfeksi_lainnya, addtional_precaution, deskripsinyeri_frekuensinyeri, obgyn_mensterakhir, obgyn_taksiranpersalinan, obgyn_keluhansaathaid, obgyn_antenatalcare_tempatlainnya, obgyn_imunisasittket, obgyn_keluhansaathamil, obgyn_penjelasankeluhan, kekerasanfisiket, resikotinggi_pasien, riwayattransfusi_reaksiygtimbul, b1_jenispernapasan,b1jenispernapasan_lainnya,b1_polapernapasan,b1_suaranafas,b2_keluhanlain,b3_kejang,b3_keluhanlain,b4_gangguan,b4_keluhanlain,b5_keluhanlain, b6_warnakulit, b6_otot, b6_keluhanlain, psikososialspriritual_keluhanlain, b1_keluhanlain, neonatus_kompilkasikehamilan, neonatus_kompilkasikehamilanlainnya, neonatus_kebiasaansaathamil, neonatus_kebiasaansaathamillainnya, neonatus_jamketubanpecah, neonatus_tglpersalinan, neonatus_jampersalinan, neonatus_isketubanpecah, b2_ispendarahan, b2_isoedem', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('asesmenawalkeperawatan_id, pendaftaran_id, pasienadmisi_id, paramedis_nama, dokterpemeriksa_id, jam_masukruangan, tgl_assesmen_awal, keluhanutama, keluhantambahan, riwayatperjalanan_penyakitpasien, lamasakit, lamasakit_satuanwaktu, riwayatpenyakitterdahulu, riwayatpenyakitkeluarga, riwayatpembedahananastesi, statusalergipasien, riwayatalergiobat, riwayatalergimakanan, riwayatalergilainnya, pengobatanygsudahdilakukan, obatyangdibawa, obatygrutindigunakan, riwayatkelahiran, riwayatimunisasi, statusmerokok, jmlrokok_btg_hr, keterangananamesa, kesadaranpasien, kondisiumum, kebutuhankhusus_status, kebutuhankhusus_isgigipalsu, kebutuhankhusus_ketgigipalsu, kebutuhankhusus_isalatbantudengar, kebutuhankhusus_ketalatbantudengar, kebutuhankhusus_ispakaikacamata, kebutuhankhusus_ketpakaikacamata, kebutuhankhusus_istongkat, kebutuhankhusus_kettongkat, kebutuhankhusus_islainnya, kebutuhankhusus_ketlainnya, kebutuhankhusus_jenislainnya, td_systolic, td_diastolic, tekanandarah, meanarteripressure, detaknadi, denyutjantung, pernapasan, suhutubuh, tinggibadan_cm, beratbadan_kg, bb_ideal, kelainanpadabagtubuh, tandavital_reflekcahaya, tandavital_spo2, kepala_hasilperiksa, kepala_abnormalketerangan, mata_hasilperiksa, mata_abnormalketerangan, leher_hasilperiksa, leher_abnormalketerangan, hidung_hasilperiksa, hidung_abnormalketerangan, telinga_hasilperiksa, telinga_abnormalketerangan, mulut_hasilperiksa, mulut_abnormalketerangan, jantung_hasilperiksa, jantung_abnormalketerangan, paru_hasilperiksa, paru_abnormalketerangan, abdomen_hasilperiksa, abdomen_abnormalketerangan, genitalia_hasilperiksa, genitalia_abnormalketerangan, extremitasatas_hasilperiksa, extremitasatas_abnormalketerangan, extremitasbawah_hasilperiksa, extremitasbawah_abnormalketerangan, kulit_hasilperiksa, kulit_abnormalketerangan, statuspsikologis_isstabil, statuspsikologis_ketstabil, statuspsikologis_iscemas, statuspsikologis_ketcemas, statuspsikologis_ismarah, statuspsikologis_ketmarah, statuspsikologis_issedih, statuspsikologis_ketsedih, statuspsikologis_islainnya, statuspsikologis_ketlainnya, statuspsikologis_lainnya, hambatansosial_status, hambatansosial_keteranganada, hambatanekonomi_status, hambatanekonomi_keteranganada, hambatanspiritual_status, hambatanspiritual_keteranganada, nilaikepercayaan_status, nilaikepercayaan_keteranganada, skrinningfungsional_skor_makan, skrinningfungsional_skor_aktifitastoilet, skrinningfungsional_skor_berpindahkursi, skrinningfungsional_skor_kebersihanmandiri, skrinningfungsional_skor_mandi, skrinningfungsional_skor_berjalanpermukaankasar, skrinningfungsional_skor_naikturuntangga, skrinningfungsional_skor_berpakaian, skrinningfungsional_skor_mengontroldefekasi, skrinningfungsional_skor_mengontrolberkemih, skrinningfungsional_jumlah_skor, skrinningfungsional_keterangan, skrinningfungsional_kategori, isskrinninggizidewasa, skrinninggizi_jwb_penurunanbb_dewasa, skrinninggizi_skor_penurunanbb_dewasa, skrinninggizi_jwb_asupanmakanan_dewasa, skrinninggizi_skor_asupanmakanan_dewasa, skrinninggizi_skor_totaldewasa, skrinninggizi_jwb_tampakkurus, skrinninggizi_skor_tampakkurus, skrinninggizi_jwb_penurunanbb, skrinninggizi_skor_penurunanbb, skrinninggizi_jwb_kondisi, skrinninggizi_skor_kondisi, skrinninggizi_jwb_penyakit, skrinninggizi_skor_penyakit, skrinninggizi_skor_totalanak, isadaresikojatuh, resikojatuh_tingkat, jenisresikojatuh, riwayatjatuh_penilaian, riwayatjatuh_skor, diagnosismedis_penilaian, diagnosismedis_skor, alatbantujalan_penilaian, alatbantujalan_skor, memakaiterapiheparin_penilaian, memakaiterapiheparin_skor, caraberjalan_penilaian, caraberjalan_skor, statusmental_penilaian, statusmental_skor, resikojatuh_skor, resikojatuh_keterangan, usia_anak, skor_usia_anak, jeniskelamin_anak, skor_jeniskelamin_anak, diagnosa_asessment_anak, skor_diagnosa_anak, gangguan_kognitif_anak, skor_gangguan_kognitif_anak, faktor_lingkungan_anak, skor_faktor_lingkungan_anak, responterhadap_pembedahan_anak, skor_responterhadap_pembedahan_anak, penggunaan_medikamentosa, skor_medikamentosa_anak, jumlah_skor_anak, keterangan_resiko_jatuh_anak, resiko_jatuh_lansia, skor_resiko_jatuh_lansia, status_mental_lansia, skor_status_mental_lansia, penglihatan_lansia, skor_penglihatan_lansia, kebiasaan_berkemih_lansia, skor_berkemih_lansia, transfer_mobilitas_lansia, skor_transfer_mobilitas_lansia, mobilitas_lansia, skor_mobilitas_lansia, jumlah_skor_lansia, keterangan_skor_lansia, riwayatjatuh_3bln_terakhir, riwayatjatuh_alatbantu, riwayatjatuh_jenisalatbantu, riwayatjatuh_jenisalatbantulainnya, is_keluhannyeri_dewasa, score_skalanyeri, keteranganskala_nyeri, deskripsinyeri_penyebabtimbul, deskripsinyeri_karakteristik, deskripsinyeri_lokasiskalanyeri, deskripsinyeri_durasinyeri, deskripsinyeri_frekuensinyeri, deskripsinyeri_ismenjalar, deskripsinyeri_lokasipenjalaran, isnyerihilangdgn_minumobat, nyerihilangdgn_minumobatket, isnyerihilangdgn_berubahposisi, nyerihilangdgn_berubahposisiket, isnyerihilangdgn_istirahat, nyerihilangdgn_istirahatket, isnyerihilangdgn_dengarmusik, nyerihilangdgn_dengarmusikket, isnyerihilangdgn_lainlain, nyerihilangdgn_lainlainket, nyerihilangdgn_lainlainjenis, rentanggerak, deformitas_status, deformitas_regio, gangguantidur_status, gangguantidur_keterangan, keb_nutricairankeluhan_status, keb_nutricairankeluhan_ismual, keb_nutricairankeluhan_mualket, keb_nutricairankeluhan_ismuntah, keb_nutricairankeluhan_muntahket, keb_nutricairankeluhan_isgangguanmengunyah, keb_nutricairankeluhan_gangguanmengunyahket, keb_nutricairankeluhan_isgangguanmenelan, keb_nutricairankeluhan_gangguanmenelanket, keb_nutricairan_rasahausberlebih, keb_nutricairan_turgorkulit, keb_nutricairan_mukosamulut, keb_nutricairan_edemastatus, keb_nutricairan_edemalokasi, keb_eliminasi_bab_frekuensi, keb_eliminasi_bab_keluhanstatus, keb_eliminasi_bab_ispendarahan, keb_eliminasi_bab_ketpendarahan, keb_eliminasi_bab_ishemorroid, keb_eliminasi_bab_kethemorroid, keb_eliminasi_bab_iskonstipasi, keb_eliminasi_bab_ketkonstipasi, keb_eliminasi_bab_iskeluhanlainnya, keb_eliminasi_bab_ketkeluhanlainnya, keb_eliminasi_bab_jeniskeluhanlainnya, keb_eliminasi_bab_karakteristik, keb_eliminasi_bab_warnafeces, keb_eliminasi_bab_status, keb_eliminasi_bak_frekuensi, keb_eliminasi_bak_jumlah, keb_eliminasi_bak_warnaurin, keb_eliminasi_bak_keluhanstatus, keb_eliminasi_bak_ispendarahan, keb_eliminasi_bak_ketpendarahan, keb_eliminasi_bak_isnyeri, keb_eliminasi_bak_ketnyeri, keb_eliminasi_bak_iskeluhanlainnya, keb_eliminasi_bak_ketkeluhanlainnya, keb_eliminasi_bak_jeniskeluhanlainnya, keb_eliminasi_bak_status, identifikasipenyakit_ismenular, identifikasipenyakit_ketmenular, identifikasipenyakit_menularketerangan, identifikasipenyakit_ispenyakitjiwa, identifikasipenyakit_ketpenyakitjiwa, identifikasipenyakitjiwa_iscenderungbunuhdiri, identifikasipenyakit_ketcenderungbunuhdiri, identifikasipenyakitjiwa_isberlakuagresif, identifikasipenyakit_ketberlakuagresif, identifikasipenyakitjiwa_islainnya, identifikasipenyakit_ketlainnya, identifikasipenyakitjiwa_keteranganlainnya, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id, riwayatpembedahan_status, riwayatpembedahan_keterangan, kebutuhankhusus_ketcemas, datasubjektif, resikojatuhkhususrj_hasilpenilaian_a, resikojatuhkhususrj_hasilpenilaian_b, resikojatuhkhususrj_hasilpengkajian, resikojatuhkhususrj_tindakanygdiperlukan, pasien_id, neonatus_anakke, neonatus_umurkehamilan, neonatus_ispenyakitibudm, neonatus_penyakitibu, neonatus_ispenyakitibuhipertensi, neonatus_ispenyakitibujantung, neonatus_ispenyakitibutbc, neonatus_ispenyakitibuhepatitisb, neonatus_ispenyakitibuasma, neonatus_ispenyakitibupms, neonatus_ispenyakitibulainnya, neonatus_penyakitibu_lainnyaket, neonatus_riwayatpengobatanibu, neonatus_diagnosaibu, neonatus_jamlahir, neonatus_tgllahirbayi, neonatus_kondisisaatlahir, neonatus_carapersalinan, neonatus_apgarscore, neonatus_letak, neonatus_talipusat, neonatus_faktorinfeksimayor_ibudemam, neonatus_faktorinfeksimayor_kpdlebihdr24jam, neonatus_faktorinfeksimayor_ketubanhijau, neonatus_faktorinfeksimayor_korioamnionitis, neonatus_faktorinfeksimayor_fetaldistress, neonatus_faktorinfeksimayor_ket, neonatus_faktorinfeksiminor_kpdkurangdr12jam, neonatus_faktorinfeksiminor_asfiksia, neonatus_faktorinfeksiminor_bblr, neonatus_faktorinfeksiminor_isk, neonatus_faktorinfeksiminor_ukkurangdr37minggu, neonatus_faktorinfeksiminor_gemeli, neonatus_faktorinfeksiminor_keputihan, neonatus_faktorinfeksiminor_ibutemplebihdr37, neonatus_faktorinfeksiminor_ket, neonatus_nutrisiasi, neonatus_nutrisiasi_frekuensijml, neonatus_nutrisiasi_frekuensikali, neonatus_nutrisilainnyaket, neonatus_alergidikajikpd, ispasangtandaalergi, neonatus_nutrisilainnya, jenisasesmen, khususanak_usiaibu_saathamil, khususanak_gravida_g, khususanak_gravida_p, khususanak_gravida_a, khususanak_gangguanhamil, khususanak_tipepersalinan, khususanak_beratbadanlahir, khususanak_tinggibadan, neonatus_kebpsikologidikasikpd, neonatus_masalahperkawinanortu, neonatus_masalahperkawinanortuket, neonatus_kekerasanfisikortu, neonatus_kekerasanfisikortu_iscederadiri, neonatus_kekerasanfisikortu_isorglain, neonatus_traumadlmhiduportu, neonatus_traumadlmhiduportuket, neonatus_konsulpsikologortu, neonatus_penerimaankondisibayi, neonatus_dukungansosialdr, neonatus_dukungansosialdr_issuami, neonatus_dukungansosialdr_isistri, neonatus_dukungansosialdr_isortu, neonatus_dukungansosialdr_iskeluarga, neonatus_dukungansosialdr_islainnya, neonatus_dukungansosialdr_lainnyaket, neonatus_kebsosialekonomi_pihakygdikaji, neonatus_kebsosialekonomi_pihakygdikajilainnya, neonatus_kebsosialekonomi_statusperkawinan, neonatus_jmlmenikahortu, neonatus_pendidikanortu, neonatus_warganegaraortu, neonatus_pekerjaanortu, neonatus_tinggalbersama, neonatus_tinggalbersamalainnya_nama, neonatus_tinggalbersamalainnya_notlp, neonatus_kebiasaanortualkohol_status, neonatus_kebiasaanortualkohol_jenis, neonatus_kebiasaanortualkohol_jml, neonatus_kebiasaanortulainnya,
			 neonatus_agamaortu, neonatus_cries_totalnilai, neonatus_cries_cryingnilai, neonatus_cries_cryingket, neonatus_cries_requiresnilai, neonatus_cries_requiresket, neonatus_cries_increasednilai, neonatus_cries_increasedket, neonatus_cries_expressionnilai, neonatus_cries_expressionket, neonatus_cries_sleeplessnilai, neonatus_cries_sleeplessket, jml_anak, nutrisi_perubahanbb6blnterakhir, sumberdata, isada_anak, isadakeluhannyeri, jenisnyeri, deskripsinyeri_onsetsatuan, tingkatannyeri, sumberdata_lainnya, deskripsinyeri_onset, kontrolrisikoinfeksi_status, masalahdlm_berbicara, deskripsinyeri_frekuensinyerilainnya, kualitasnyeri, nutrisi_perubahanbb6blnterakhirket, nutrisi_dietsaatini, masalahbicara_ket, jenisrisikoinfeksi, jenisrisikoinfeksi_lainnya, addtional_precaution, obgyn_siklushaid, obgyn_menarcheumur, obgyn_lamahaid, obgyn_umurkawinpertama, obgyn_usiakehamilanhpht, obgyn_mensterakhir, obgyn_taksiranpersalinan, obgyn_keluhansaathaid, obgyn_antenatalcare_tempatlainnya, obgyn_imunisasittket, obgyn_keluhansaathamil, obgyn_penjelasankeluhan, obgyn_banyaknyahaid, obgyn_antenatalcare_tempat, obgyn_keteraturanhaid, obgyn_statuskawin, obgyn_golongandarah, obgyn_imunisasittstatus, obgyn_antenatalcare_frekuensi, obgyn_antenatalcare_status, obgyn_keluhansaathamillainnya, namapasien_verifikator, obgyn_jumlahperkawainan, kekerasanfisiket, jenis_statusfungsional, resikotinggi_pasien, riwayattransfusi_status, riwayattransfusi_isreaksi, riwayattransfusi_reaksiygtimbul, skrininggizidewasa_resiko, skrininggizidewasa_tindakanygdilakukan, beratbadan_biasanya, kesadaranpasien_pengkajiannyeri, skriningnyeribps_ekspresiwajahpenilaian, skriningnyeribps_ekstremitasataspenilaian, skriningnyeribps_kepatuhanventilatorpenilaian, skriningnyeribps_ekspresiwajahskor, skriningnyeribps_ekstremitasatasskor, skriningnyeribps_kepatuhanventilatorskor, b1_spo2, b6_skorbraden, b5_babfrekuensi, b4_bakfrekuensi, b3_gcsmotoric_nilai, b3_gcsverbal_nilai, b3_gcseye_nilai, b1_rr, b2_td_systolic, b2_td_diastolic,b2_nadi, b1_iramapernapasan, b2_denyutjantung, b2_akral, b2_crt, b2_isnyerdada,b3_kesimetrisanpupil,b3_ukuranreflek_pupilkanan,b3_ukuranreflek_pupilkiri,b4_bakwarnaurin,b4_isnyeritekankandungkemih,b5_abdomen_kesimetrisan, b6_caraukursuhutubuh, b6_pergerakan, b1_jenispernapasan,b1jenispernapasan_lainnya,b1_polapernapasan,b1_suaranafas,b2_keluhanlain,b3_kejang,b3_keluhanlain,b4_gangguan,b4_keluhanlain,b5_keluhanlain, b6_warnakulit, b6_otot, b6_keluhanlain, psikososialspriritual_keluhanlain, b1_jmloksigenperliter, b6_suhutubuh, b1_jenisterapioksigen, perasaansaatini, b2_lokasioedem,b6_turgorkulit,gangguanorientasi_terhadap,b3_paresa, b3_kesadaran,b5_mukosamulut, b5_abdomen_nyeritekanlokasi,b6_lokasioedema,b6_berkeringatbanyak,b6_lokasiluka,b6_turgorkulit,orangterdekat, b5_warnafeces, b1_keluhanlain, b1_kesulitanbernafas, b5_statusnafasumakan, b6_isfraktur, b6_jenisfraktur, b6_lokasifraktur, neonatus_kompilkasikehamilan, neonatus_kompilkasikehamilanlainnya, neonatus_kebiasaansaathamil, neonatus_kebiasaansaathamillainnya, neonatus_jamketubanpecah, neonatus_tglpersalinan, neonatus_jampersalinan, neonatus_isketubanpecah, neonatus_warnaketuban, neonatus_placenta, neonatus_jeniskelamin, neonatus_statuskelahiranmati, neonatus_jeniskelahiran, neonatus_sebabkematian, neonatus_saatlahir_anus, neonatus_saatlahir_kelahiran, neonatus_saatlahir_hr, neonatus_saatlahir_rr, neonatus_saatlahir_spo2, neonatus_saatlahir_suhutubuh, neonatus_saatlahir_lingkarkepala, neonatus_saatlahir_lingkardada, b2_ispendarahan, b2_isoedem, caratibadiruangan, khususanak_gravida_h', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'asesmenkebutuhanEdukasiTs' => array(self::HAS_MANY, 'AsesmenkebutuhanEdukasiT', 'asesmenawalkeperawatan_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'skrinningnyerianakdetTs' => array(self::HAS_MANY, 'SkrinningnyerianakdetT', 'asesmenawalkeperawatan_id'),
			'dokterpemeriksa' => array(self::BELONGS_TO, 'PegawaiM', 'dokterpemeriksa_id'),
			'ruangan' => array(self::BELONGS_TO, 'RuanganM', 'create_ruangan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'asesmenawalkeperawatan_id' => 'Asesmenawalkeperawatan',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'paramedis_nama' => 'Paramedis Nama',
			'dokterpemeriksa_id' => 'Dokter Pemeriksa',
			'jam_masukruangan' => 'Jam Masuk Ruangan',
			'tgl_assesmen_awal' => 'Tanggal & Jam Pengkajian',
			'keluhanutama' => 'Keluhan Utama',
			'keluhantambahan' => 'Keluhan Tambahan',
			'riwayatperjalanan_penyakitpasien' => 'Riwayat Perjalanan Penyakit Pasien',
			'lamasakit' => 'Lama Sakit',
			'lamasakit_satuanwaktu' => 'Lamasakit Satuanwaktu',
			'riwayatpenyakitterdahulu' => 'Riwayat Penyakit Terdahulu',
			'riwayatpenyakitkeluarga' => 'Riwayat Penyakit Keluarga',
			'riwayatpembedahananastesi' => 'Riwayat Pembedahan atau Anastesi',
			'statusalergipasien' => 'Alergi',
			'riwayatalergiobat' => 'Riwayat Alergi Obat',
			'riwayatalergimakanan' => 'Riwayat alergi Makanan',
			'riwayatalergilainnya' => 'Riwayat Alergi Lainnya',
			'pengobatanygsudahdilakukan' => 'Pengobatan Yang Sudah Dilakukan',
			'obatyangdibawa' => 'Obat Yang Dibawa',
			'obatygrutindigunakan' => 'Obat Yang Rutin Digunakan',
			'riwayatkelahiran' => 'Riwayat Kelahiran',
			'riwayatimunisasi' => 'Riwayat Imunisasi',
			'statusmerokok' => 'Status Merokok',
			'jmlrokok_btg_hr' => 'Jumlah Rokok Batangan',
			'keterangananamesa' => 'Keterangan Anamesa',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_petugaspengisi_id' => 'Create Petugaspengisi',
			'create_ruangan_id' => 'Create Ruangan',
			'kesadaranpasien' => 'Kesadaran',
			'kondisiumum' => 'Kondisi Umum',
			'kebutuhankhusus_status' => 'Kebutuhan Khusus',
			'kebutuhankhusus_isgigipalsu' => 'Gigi Palsu',
			'kebutuhankhusus_ketgigipalsu' => 'Kebutuhankhusus Ketgigipalsu',
			'kebutuhankhusus_isalatbantudengar' => 'Alat Bantu Dengar',
			'kebutuhankhusus_ketalatbantudengar' => 'Kebutuhankhusus Ketalatbantudengar',
			'kebutuhankhusus_ispakaikacamata' => 'Kacamata',
			'kebutuhankhusus_ketpakaikacamata' => 'Kebutuhankhusus Ketpakaikacamata',
			'kebutuhankhusus_istongkat' => 'Tongkat',
			'kebutuhankhusus_kettongkat' => 'Kebutuhankhusus Kettongkat',
			'kebutuhankhusus_islainnya' => 'Lainnya',
			'kebutuhankhusus_ketlainnya' => 'Kebutuhankhusus Ketlainnya',
			'kebutuhankhusus_jenislainnya' => 'Kebutuhankhusus Jenislainnya',
			'td_systolic' => 'Td Systolic',
			'td_diastolic' => 'Td Diastolic',
			'tekanandarah' => 'Tekanan Darah',
			'meanarteripressure' => 'Meanarteripressure',
			'detaknadi' => 'Detaknadi',
			'denyutjantung' => 'Denyutjantung',
			'pernapasan' => 'Pernapasan',
			'suhutubuh' => 'Suhu Tubuh',
			'tinggibadan_cm' => 'Tinggibadan Cm',
			'beratbadan_kg' => 'Beratbadan Kg',
			'bb_ideal' => 'Bb Ideal',
			'kelainanpadabagtubuh' => 'Kelainan pada Bag. Tubuh',
			'tandavital_reflekcahaya' => 'Reflek Cahaya',
			'tandavital_spo2' => 'SPO2',
			'kepala_hasilperiksa' => 'Kepala',
			'kepala_abnormalketerangan' => 'Kepala Abnormalketerangan',
			'mata_hasilperiksa' => 'Mata',
			'mata_abnormalketerangan' => 'Mata Abnormalketerangan',
			'leher_hasilperiksa' => 'Leher',
			'leher_abnormalketerangan' => 'Leher Abnormalketerangan',
			'hidung_hasilperiksa' => 'Hidung',
			'hidung_abnormalketerangan' => 'Hidung Abnormalketerangan',
			'telinga_hasilperiksa' => 'Telinga',
			'telinga_abnormalketerangan' => 'Telinga Abnormalketerangan',
			'mulut_hasilperiksa' => 'Mulut',
			'mulut_abnormalketerangan' => 'Mulut Abnormalketerangan',
			'jantung_hasilperiksa' => 'Jantung',
			'jantung_abnormalketerangan' => 'Jantung Abnormalketerangan',
			'paru_hasilperiksa' => 'Paru',
			'paru_abnormalketerangan' => 'Paru Abnormalketerangan',
			'abdomen_hasilperiksa' => 'Abdomen',
			'abdomen_abnormalketerangan' => 'Abdomen Abnormalketerangan',
			'genitalia_hasilperiksa' => 'Genitalia',
			'genitalia_abnormalketerangan' => 'Genitalia Abnormalketerangan',
			'extremitasatas_hasilperiksa' => 'Extremitas Atas',
			'extremitasatas_abnormalketerangan' => 'Extremitasatas Abnormalketerangan',
			'extremitasbawah_hasilperiksa' => 'Extremitas Bawah',
			'extremitasbawah_abnormalketerangan' => 'Extremitasbawah Abnormalketerangan',
			'kulit_hasilperiksa' => 'Kulit',
			'kulit_abnormalketerangan' => 'Kulit Abnormalketerangan',
                    'statuspsikologis_isstabil' => 'Stabil / Tenang',
                    'statuspsikologis_iscemas' => 'Cemas / Takut',
                    'statuspsikologis_ismarah' => 'Marah',
                    'statuspsikologis_issedih' => 'Sedih',
                    'statuspsikologis_islainnya' => 'Lainnya',
                    'hambatansosial_status' => 'Hambatan Sosial',
                    'hambatanekonomi_status' => 'Hambatan Ekonomi',
                    'hambatanspiritual_status' => 'Hambatan Spriritual',
                    'nilaikepercayaan_status' => 'Nilai Kepercayaan',
                    'isadaresikojatuh' => 'Ada Resiko Jatuh',
                    'deskripsinyeri_penyebabtimbul' => 'Penyebab timbulnya nyeri',
                    'deskripsinyeri_karakteristik' => 'Karakteristik nyeri',
                    'deskripsinyeri_lokasiskalanyeri' => 'Lokasi skala nyeri',
                    'deskripsinyeri_durasinyeri' => 'Durasi nyeri',
                    'deskripsinyeri_frekuensinyeri' => 'Frekuensi nyeri',
                    'isnyerihilangdgn_minumobat' => 'Minum Obat',
                    'isnyerihilangdgn_berubahposisi' => 'Berubah posisi/ tidur',
                    'isnyerihilangdgn_istirahat' => 'Istirahat',
                    'isnyerihilangdgn_dengarmusik' => 'Mendengarkan Musik',
                    'isnyerihilangdgn_lainlain' => 'Lain-lain',
                    'keb_nutricairankeluhan_status'=>'Keluhan',
                    'keb_nutricairankeluhan_ismual'=>'Mual',
                    'keb_nutricairankeluhan_ismuntah'=>'Muntah',
                    'keb_nutricairankeluhan_isgangguanmengunyah'=>'Gangguan Mengunyah',
                    'keb_nutricairankeluhan_isgangguanmenelan'=>'Gangguan Menelan',
                    'keb_nutricairan_rasahausberlebih'=>'Rasa haus berlebih',
                    'keb_nutricairan_turgorkulit'=>'Tugor Kulit',
                    'keb_nutricairan_mukosamulut'=>'Mukosa Mulut',
                    'keb_nutricairan_edemastatus'=>'Edema',
                    'keb_eliminasi_bab_frekuensi'=>'Frekuensi BAB',
                    'keb_eliminasi_bab_keluhanstatus'=>'Keluhan BAB',
                    'keb_eliminasi_bab_ispendarahan'=>'Pendaharan',
                    'keb_eliminasi_bab_ishemorroid'=>'Hemorroid',
                    'keb_eliminasi_bab_iskonstipasi'=>'Konstipasi',
                    'keb_eliminasi_bab_iskeluhanlainnya'=>'Lainnya',
                    'keb_eliminasi_bab_karakteristik'=>'Karakteristik BAB',
                    'keb_eliminasi_bab_warnafeces'=>'Warna Feces',
                    'keb_eliminasi_bab_status'=>'Kebutuhan Eliminasi',
                    'keb_eliminasi_bak_frekuensi'=>'Frekuensi BAK',
                    'keb_eliminasi_bak_jumlah'=>'Jumlah',
                    'keb_eliminasi_bak_warnaurin'=>'Warna Urin',
                    'keb_eliminasi_bak_keluhanstatus'=>'Keluhan BAK',
                    'keb_eliminasi_bak_ispendarahan'=>'Pendarahan',
                    'keb_eliminasi_bak_isnyeri'=>'Nyeri',
                    'keb_eliminasi_bak_iskeluhanlainnya'=>'Lainnya',
                    'keb_eliminasi_bak_status'=>'Kebutuhan Eliminasi',
                    'identifikasipenyakitjiwa_iscenderungbunuhdiri'=>'kecenderung Bunuh Diri',
                    'identifikasipenyakitjiwa_isberlakuagresif'=>'Berlaku Agresif',
                    'identifikasipenyakitjiwa_islainnya'=>'Lainnya',
                    'riwayatpembedahan_status' => 'Riwayat Pembedahan atau Anastesi',

                    'neonatus_anakke' => 'Anak ke-',
                    'neonatus_umurkehamilan' => 'Umur Kehamilan',
                    'neonatus_riwayatpengobatanibu' => 'Riwayat Pengobatan Ibu',
                    'neonatus_diagnosaibu' => 'Diagnosa Ibu',
                    'neonatus_tgllahirbayi' => 'Tanggal Lahir',
                    'neonatus_jamlahir' => 'Jam Lahir',
                    'neonatus_kondisisaatlahir' => 'Kondisi saat Lahir',
                    'neonatus_carapersalinan' => 'Cara Persalinan',
                    'neonatus_apgarscore' => 'Apgar Score',
                    'neonatus_letak' => 'Letak',
                    'neonatus_talipusat' => 'Tali Pusat',
                    'neonatus_alergidikajikpd' => 'Alergi/ Reaksi pada',
                    'riwayatpembedahan_status' => 'Riwayat Pembedahan atau Anastesi',
                    'neonatus_kebpsikologidikasikpd'=>'Kebutuhan Psikologi yang Dikaji',
                    'neonatus_masalahperkawinanortu'=>'Masalah Perkawinan',
                    'neonatus_kekerasanfisikortu'=>'Mengalami Kekerasan Fisik',
                    'neonatus_traumadlmhiduportu'=>'Trauma dalam Kehidupan',
                    'gangguantidur_status'=>'Gangguan Tidur',
                    'neonatus_konsulpsikologortu'=>'Konsultasi dengan Psikologi/ Psikiater',
                    'neonatus_penerimaankondisibayi'=>'Penerimaan terhadap Kondisi Bayi saat ini',
                    'neonatus_kebsosialekonomi_pihakygdikaji'=>'Pihak yang Dikaji',
                    'neonatus_kebsosialekonomi_statusperkawinan'=>'Status Pernikahan',
                    'neonatus_pendidikanortu'=>'Pendidikan Terakhir',
                    'neonatus_warganegaraortu'=>'Warga Negara',
                    'neonatus_pekerjaanortu'=>'Pekerjaan',
                    'neonatus_tinggalbersama'=>'Tinggal Bersama',
                    'neonatus_kebiasaanortualkohol_status'=>'Alkohol',
                    'neonatus_kebiasaanortulainnya'=>'Kebiasaan Lainnya',
                    'neonatus_agamaortu'=>'Agama'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('asesmenawalkeperawatan_id',$this->asesmenawalkeperawatan_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('paramedis_nama',$this->paramedis_nama,true);
		$criteria->compare('dokterpemeriksa_id',$this->dokterpemeriksa_id);
		$criteria->compare('jam_masukruangan',$this->jam_masukruangan,true);
		$criteria->compare('tgl_assesmen_awal',$this->tgl_assesmen_awal,true);
		$criteria->compare('keluhanutama',$this->keluhanutama,true);
		$criteria->compare('keluhantambahan',$this->keluhantambahan,true);
		$criteria->compare('riwayatperjalanan_penyakitpasien',$this->riwayatperjalanan_penyakitpasien,true);
		$criteria->compare('lamasakit',$this->lamasakit,true);
		$criteria->compare('lamasakit_satuanwaktu',$this->lamasakit_satuanwaktu,true);
		$criteria->compare('riwayatpenyakitterdahulu',$this->riwayatpenyakitterdahulu,true);
		$criteria->compare('riwayatpenyakitkeluarga',$this->riwayatpenyakitkeluarga,true);
		$criteria->compare('riwayatpembedahananastesi',$this->riwayatpembedahananastesi,true);
		$criteria->compare('statusalergipasien',$this->statusalergipasien,true);
		$criteria->compare('riwayatalergiobat',$this->riwayatalergiobat,true);
		$criteria->compare('riwayatalergimakanan',$this->riwayatalergimakanan,true);
		$criteria->compare('riwayatalergilainnya',$this->riwayatalergilainnya,true);
		$criteria->compare('pengobatanygsudahdilakukan',$this->pengobatanygsudahdilakukan,true);
		$criteria->compare('obatyangdibawa',$this->obatyangdibawa,true);
		$criteria->compare('obatygrutindigunakan',$this->obatygrutindigunakan,true);
		$criteria->compare('riwayatkelahiran',$this->riwayatkelahiran,true);
		$criteria->compare('riwayatimunisasi',$this->riwayatimunisasi,true);
		$criteria->compare('statusmerokok',$this->statusmerokok);
		$criteria->compare('jmlrokok_btg_hr',$this->jmlrokok_btg_hr);
		$criteria->compare('keterangananamesa',$this->keterangananamesa,true);
		$criteria->compare('kesadaranpasien',$this->kesadaranpasien,true);
		$criteria->compare('kondisiumum',$this->kondisiumum,true);
		$criteria->compare('kebutuhankhusus_status',$this->kebutuhankhusus_status,true);
		$criteria->compare('kebutuhankhusus_isgigipalsu',$this->kebutuhankhusus_isgigipalsu);
		$criteria->compare('kebutuhankhusus_ketgigipalsu',$this->kebutuhankhusus_ketgigipalsu,true);
		$criteria->compare('kebutuhankhusus_isalatbantudengar',$this->kebutuhankhusus_isalatbantudengar);
		$criteria->compare('kebutuhankhusus_ketalatbantudengar',$this->kebutuhankhusus_ketalatbantudengar,true);
		$criteria->compare('kebutuhankhusus_ispakaikacamata',$this->kebutuhankhusus_ispakaikacamata);
		$criteria->compare('kebutuhankhusus_ketpakaikacamata',$this->kebutuhankhusus_ketpakaikacamata,true);
		$criteria->compare('kebutuhankhusus_istongkat',$this->kebutuhankhusus_istongkat);
		$criteria->compare('kebutuhankhusus_kettongkat',$this->kebutuhankhusus_kettongkat,true);
		$criteria->compare('kebutuhankhusus_islainnya',$this->kebutuhankhusus_islainnya);
		$criteria->compare('kebutuhankhusus_ketlainnya',$this->kebutuhankhusus_ketlainnya,true);
		$criteria->compare('kebutuhankhusus_jenislainnya',$this->kebutuhankhusus_jenislainnya,true);
		$criteria->compare('td_systolic',$this->td_systolic);
		$criteria->compare('td_diastolic',$this->td_diastolic);
		$criteria->compare('tekanandarah',$this->tekanandarah,true);
		$criteria->compare('meanarteripressure',$this->meanarteripressure);
		$criteria->compare('detaknadi',$this->detaknadi);
		$criteria->compare('denyutjantung',$this->denyutjantung,true);
		$criteria->compare('pernapasan',$this->pernapasan);
		$criteria->compare('suhutubuh',$this->suhutubuh);
		$criteria->compare('tinggibadan_cm',$this->tinggibadan_cm);
		$criteria->compare('beratbadan_kg',$this->beratbadan_kg);
		$criteria->compare('bb_ideal',$this->bb_ideal);
		$criteria->compare('kelainanpadabagtubuh',$this->kelainanpadabagtubuh,true);
		$criteria->compare('tandavital_reflekcahaya',$this->tandavital_reflekcahaya,true);
		$criteria->compare('tandavital_spo2',$this->tandavital_spo2);
		$criteria->compare('kepala_hasilperiksa',$this->kepala_hasilperiksa);
		$criteria->compare('kepala_abnormalketerangan',$this->kepala_abnormalketerangan,true);
		$criteria->compare('mata_hasilperiksa',$this->mata_hasilperiksa);
		$criteria->compare('mata_abnormalketerangan',$this->mata_abnormalketerangan,true);
		$criteria->compare('leher_hasilperiksa',$this->leher_hasilperiksa);
		$criteria->compare('leher_abnormalketerangan',$this->leher_abnormalketerangan,true);
		$criteria->compare('hidung_hasilperiksa',$this->hidung_hasilperiksa);
		$criteria->compare('hidung_abnormalketerangan',$this->hidung_abnormalketerangan,true);
		$criteria->compare('telinga_hasilperiksa',$this->telinga_hasilperiksa);
		$criteria->compare('telinga_abnormalketerangan',$this->telinga_abnormalketerangan,true);
		$criteria->compare('mulut_hasilperiksa',$this->mulut_hasilperiksa);
		$criteria->compare('mulut_abnormalketerangan',$this->mulut_abnormalketerangan,true);
		$criteria->compare('jantung_hasilperiksa',$this->jantung_hasilperiksa);
		$criteria->compare('jantung_abnormalketerangan',$this->jantung_abnormalketerangan,true);
		$criteria->compare('paru_hasilperiksa',$this->paru_hasilperiksa);
		$criteria->compare('paru_abnormalketerangan',$this->paru_abnormalketerangan,true);
		$criteria->compare('abdomen_hasilperiksa',$this->abdomen_hasilperiksa);
		$criteria->compare('abdomen_abnormalketerangan',$this->abdomen_abnormalketerangan,true);
		$criteria->compare('genitalia_hasilperiksa',$this->genitalia_hasilperiksa);
		$criteria->compare('genitalia_abnormalketerangan',$this->genitalia_abnormalketerangan,true);
		$criteria->compare('extremitasatas_hasilperiksa',$this->extremitasatas_hasilperiksa);
		$criteria->compare('extremitasatas_abnormalketerangan',$this->extremitasatas_abnormalketerangan,true);
		$criteria->compare('extremitasbawah_hasilperiksa',$this->extremitasbawah_hasilperiksa);
		$criteria->compare('extremitasbawah_abnormalketerangan',$this->extremitasbawah_abnormalketerangan,true);
		$criteria->compare('kulit_hasilperiksa',$this->kulit_hasilperiksa);
		$criteria->compare('kulit_abnormalketerangan',$this->kulit_abnormalketerangan,true);
		$criteria->compare('statuspsikologis_isstabil',$this->statuspsikologis_isstabil);
		$criteria->compare('statuspsikologis_ketstabil',$this->statuspsikologis_ketstabil,true);
		$criteria->compare('statuspsikologis_iscemas',$this->statuspsikologis_iscemas);
		$criteria->compare('statuspsikologis_ketcemas',$this->statuspsikologis_ketcemas,true);
		$criteria->compare('statuspsikologis_ismarah',$this->statuspsikologis_ismarah);
		$criteria->compare('statuspsikologis_ketmarah',$this->statuspsikologis_ketmarah,true);
		$criteria->compare('statuspsikologis_issedih',$this->statuspsikologis_issedih);
		$criteria->compare('statuspsikologis_ketsedih',$this->statuspsikologis_ketsedih,true);
		$criteria->compare('statuspsikologis_islainnya',$this->statuspsikologis_islainnya);
		$criteria->compare('statuspsikologis_ketlainnya',$this->statuspsikologis_ketlainnya,true);
		$criteria->compare('statuspsikologis_lainnya',$this->statuspsikologis_lainnya,true);
		$criteria->compare('hambatansosial_status',$this->hambatansosial_status,true);
		$criteria->compare('hambatansosial_keteranganada',$this->hambatansosial_keteranganada,true);
		$criteria->compare('hambatanekonomi_status',$this->hambatanekonomi_status,true);
		$criteria->compare('hambatanekonomi_keteranganada',$this->hambatanekonomi_keteranganada,true);
		$criteria->compare('hambatanspiritual_status',$this->hambatanspiritual_status,true);
		$criteria->compare('hambatanspiritual_keteranganada',$this->hambatanspiritual_keteranganada,true);
		$criteria->compare('nilaikepercayaan_status',$this->nilaikepercayaan_status,true);
		$criteria->compare('nilaikepercayaan_keteranganada',$this->nilaikepercayaan_keteranganada,true);
		$criteria->compare('skrinningfungsional_skor_makan',$this->skrinningfungsional_skor_makan);
		$criteria->compare('skrinningfungsional_skor_aktifitastoilet',$this->skrinningfungsional_skor_aktifitastoilet);
		$criteria->compare('skrinningfungsional_skor_berpindahkursi',$this->skrinningfungsional_skor_berpindahkursi);
		$criteria->compare('skrinningfungsional_skor_kebersihanmandiri',$this->skrinningfungsional_skor_kebersihanmandiri);
		$criteria->compare('skrinningfungsional_skor_mandi',$this->skrinningfungsional_skor_mandi);
		$criteria->compare('skrinningfungsional_skor_berjalanpermukaankasar',$this->skrinningfungsional_skor_berjalanpermukaankasar);
		$criteria->compare('skrinningfungsional_skor_naikturuntangga',$this->skrinningfungsional_skor_naikturuntangga);
		$criteria->compare('skrinningfungsional_skor_berpakaian',$this->skrinningfungsional_skor_berpakaian);
		$criteria->compare('skrinningfungsional_skor_mengontroldefekasi',$this->skrinningfungsional_skor_mengontroldefekasi);
		$criteria->compare('skrinningfungsional_skor_mengontrolberkemih',$this->skrinningfungsional_skor_mengontrolberkemih);
		$criteria->compare('skrinningfungsional_jumlah_skor',$this->skrinningfungsional_jumlah_skor);
		$criteria->compare('skrinningfungsional_keterangan',$this->skrinningfungsional_keterangan,true);
		$criteria->compare('skrinningfungsional_kategori',$this->skrinningfungsional_kategori,true);
		$criteria->compare('isskrinninggizidewasa',$this->isskrinninggizidewasa);
		$criteria->compare('skrinninggizi_jwb_penurunanbb_dewasa',$this->skrinninggizi_jwb_penurunanbb_dewasa,true);
		$criteria->compare('skrinninggizi_skor_penurunanbb_dewasa',$this->skrinninggizi_skor_penurunanbb_dewasa);
		$criteria->compare('skrinninggizi_jwb_asupanmakanan_dewasa',$this->skrinninggizi_jwb_asupanmakanan_dewasa,true);
		$criteria->compare('skrinninggizi_skor_asupanmakanan_dewasa',$this->skrinninggizi_skor_asupanmakanan_dewasa);
		$criteria->compare('skrinninggizi_skor_totaldewasa',$this->skrinninggizi_skor_totaldewasa);
		$criteria->compare('skrinninggizi_jwb_tampakkurus',$this->skrinninggizi_jwb_tampakkurus,true);
		$criteria->compare('skrinninggizi_skor_tampakkurus',$this->skrinninggizi_skor_tampakkurus);
		$criteria->compare('skrinninggizi_jwb_penurunanbb',$this->skrinninggizi_jwb_penurunanbb,true);
		$criteria->compare('skrinninggizi_skor_penurunanbb',$this->skrinninggizi_skor_penurunanbb);
		$criteria->compare('skrinninggizi_jwb_kondisi',$this->skrinninggizi_jwb_kondisi,true);
		$criteria->compare('skrinninggizi_skor_kondisi',$this->skrinninggizi_skor_kondisi);
		$criteria->compare('skrinninggizi_jwb_penyakit',$this->skrinninggizi_jwb_penyakit,true);
		$criteria->compare('skrinninggizi_skor_penyakit',$this->skrinninggizi_skor_penyakit);
		$criteria->compare('skrinninggizi_skor_totalanak',$this->skrinninggizi_skor_totalanak);
		$criteria->compare('isadaresikojatuh',$this->isadaresikojatuh);
		$criteria->compare('resikojatuh_tingkat',$this->resikojatuh_tingkat,true);
		$criteria->compare('jenisresikojatuh',$this->jenisresikojatuh,true);
		$criteria->compare('riwayatjatuh_penilaian',$this->riwayatjatuh_penilaian,true);
		$criteria->compare('riwayatjatuh_skor',$this->riwayatjatuh_skor);
		$criteria->compare('diagnosismedis_penilaian',$this->diagnosismedis_penilaian,true);
		$criteria->compare('diagnosismedis_skor',$this->diagnosismedis_skor);
		$criteria->compare('alatbantujalan_penilaian',$this->alatbantujalan_penilaian,true);
		$criteria->compare('alatbantujalan_skor',$this->alatbantujalan_skor);
		$criteria->compare('memakaiterapiheparin_penilaian',$this->memakaiterapiheparin_penilaian,true);
		$criteria->compare('memakaiterapiheparin_skor',$this->memakaiterapiheparin_skor);
		$criteria->compare('caraberjalan_penilaian',$this->caraberjalan_penilaian,true);
		$criteria->compare('caraberjalan_skor',$this->caraberjalan_skor);
		$criteria->compare('statusmental_penilaian',$this->statusmental_penilaian,true);
		$criteria->compare('statusmental_skor',$this->statusmental_skor);
		$criteria->compare('resikojatuh_skor',$this->resikojatuh_skor);
		$criteria->compare('resikojatuh_keterangan',$this->resikojatuh_keterangan,true);
		$criteria->compare('usia_anak',$this->usia_anak,true);
		$criteria->compare('skor_usia_anak',$this->skor_usia_anak);
		$criteria->compare('jeniskelamin_anak',$this->jeniskelamin_anak,true);
		$criteria->compare('skor_jeniskelamin_anak',$this->skor_jeniskelamin_anak);
		$criteria->compare('diagnosa_asessment_anak',$this->diagnosa_asessment_anak,true);
		$criteria->compare('skor_diagnosa_anak',$this->skor_diagnosa_anak);
		$criteria->compare('gangguan_kognitif_anak',$this->gangguan_kognitif_anak,true);
		$criteria->compare('skor_gangguan_kognitif_anak',$this->skor_gangguan_kognitif_anak);
		$criteria->compare('faktor_lingkungan_anak',$this->faktor_lingkungan_anak,true);
		$criteria->compare('skor_faktor_lingkungan_anak',$this->skor_faktor_lingkungan_anak);
		$criteria->compare('responterhadap_pembedahan_anak',$this->responterhadap_pembedahan_anak,true);
		$criteria->compare('skor_responterhadap_pembedahan_anak',$this->skor_responterhadap_pembedahan_anak);
		$criteria->compare('penggunaan_medikamentosa',$this->penggunaan_medikamentosa,true);
		$criteria->compare('skor_medikamentosa_anak',$this->skor_medikamentosa_anak);
		$criteria->compare('jumlah_skor_anak',$this->jumlah_skor_anak);
		$criteria->compare('keterangan_resiko_jatuh_anak',$this->keterangan_resiko_jatuh_anak,true);
		$criteria->compare('resiko_jatuh_lansia',$this->resiko_jatuh_lansia);
		$criteria->compare('skor_resiko_jatuh_lansia',$this->skor_resiko_jatuh_lansia);
		$criteria->compare('status_mental_lansia',$this->status_mental_lansia);
		$criteria->compare('skor_status_mental_lansia',$this->skor_status_mental_lansia);
		$criteria->compare('penglihatan_lansia',$this->penglihatan_lansia);
		$criteria->compare('skor_penglihatan_lansia',$this->skor_penglihatan_lansia);
		$criteria->compare('kebiasaan_berkemih_lansia',$this->kebiasaan_berkemih_lansia);
		$criteria->compare('skor_berkemih_lansia',$this->skor_berkemih_lansia);
		$criteria->compare('transfer_mobilitas_lansia',$this->transfer_mobilitas_lansia,true);
		$criteria->compare('skor_transfer_mobilitas_lansia',$this->skor_transfer_mobilitas_lansia);
		$criteria->compare('mobilitas_lansia',$this->mobilitas_lansia,true);
		$criteria->compare('skor_mobilitas_lansia',$this->skor_mobilitas_lansia);
		$criteria->compare('jumlah_skor_lansia',$this->jumlah_skor_lansia);
		$criteria->compare('keterangan_skor_lansia',$this->keterangan_skor_lansia,true);
		$criteria->compare('riwayatjatuh_3bln_terakhir',$this->riwayatjatuh_3bln_terakhir);
		$criteria->compare('riwayatjatuh_alatbantu',$this->riwayatjatuh_alatbantu);
		$criteria->compare('riwayatjatuh_jenisalatbantu',$this->riwayatjatuh_jenisalatbantu,true);
		$criteria->compare('riwayatjatuh_jenisalatbantulainnya',$this->riwayatjatuh_jenisalatbantulainnya,true);
		$criteria->compare('is_keluhannyeri_dewasa',$this->is_keluhannyeri_dewasa);
		$criteria->compare('score_skalanyeri',$this->score_skalanyeri);
		$criteria->compare('keteranganskala_nyeri',$this->keteranganskala_nyeri,true);
		$criteria->compare('deskripsinyeri_penyebabtimbul',$this->deskripsinyeri_penyebabtimbul,true);
		$criteria->compare('deskripsinyeri_karakteristik',$this->deskripsinyeri_karakteristik,true);
		$criteria->compare('deskripsinyeri_lokasiskalanyeri',$this->deskripsinyeri_lokasiskalanyeri,true);
		$criteria->compare('deskripsinyeri_durasinyeri',$this->deskripsinyeri_durasinyeri,true);
		$criteria->compare('deskripsinyeri_frekuensinyeri',$this->deskripsinyeri_frekuensinyeri,true);
		$criteria->compare('deskripsinyeri_ismenjalar',$this->deskripsinyeri_ismenjalar);
		$criteria->compare('deskripsinyeri_lokasipenjalaran',$this->deskripsinyeri_lokasipenjalaran,true);
		$criteria->compare('isnyerihilangdgn_minumobat',$this->isnyerihilangdgn_minumobat);
		$criteria->compare('nyerihilangdgn_minumobatket',$this->nyerihilangdgn_minumobatket,true);
		$criteria->compare('isnyerihilangdgn_berubahposisi',$this->isnyerihilangdgn_berubahposisi);
		$criteria->compare('nyerihilangdgn_berubahposisiket',$this->nyerihilangdgn_berubahposisiket,true);
		$criteria->compare('isnyerihilangdgn_istirahat',$this->isnyerihilangdgn_istirahat);
		$criteria->compare('nyerihilangdgn_istirahatket',$this->nyerihilangdgn_istirahatket,true);
		$criteria->compare('isnyerihilangdgn_dengarmusik',$this->isnyerihilangdgn_dengarmusik);
		$criteria->compare('nyerihilangdgn_dengarmusikket',$this->nyerihilangdgn_dengarmusikket,true);
		$criteria->compare('isnyerihilangdgn_lainlain',$this->isnyerihilangdgn_lainlain);
		$criteria->compare('nyerihilangdgn_lainlainket',$this->nyerihilangdgn_lainlainket,true);
		$criteria->compare('nyerihilangdgn_lainlainjenis',$this->nyerihilangdgn_lainlainjenis,true);
		$criteria->compare('rentanggerak',$this->rentanggerak,true);
		$criteria->compare('deformitas_status',$this->deformitas_status);
		$criteria->compare('deformitas_regio',$this->deformitas_regio,true);
		$criteria->compare('gangguantidur_status',$this->gangguantidur_status);
		$criteria->compare('gangguantidur_keterangan',$this->gangguantidur_keterangan,true);
		$criteria->compare('keb_nutricairankeluhan_status',$this->keb_nutricairankeluhan_status);
		$criteria->compare('keb_nutricairankeluhan_ismual',$this->keb_nutricairankeluhan_ismual);
		$criteria->compare('keb_nutricairankeluhan_mualket',$this->keb_nutricairankeluhan_mualket,true);
		$criteria->compare('keb_nutricairankeluhan_ismuntah',$this->keb_nutricairankeluhan_ismuntah);
		$criteria->compare('keb_nutricairankeluhan_muntahket',$this->keb_nutricairankeluhan_muntahket,true);
		$criteria->compare('keb_nutricairankeluhan_isgangguanmengunyah',$this->keb_nutricairankeluhan_isgangguanmengunyah);
		$criteria->compare('keb_nutricairankeluhan_gangguanmengunyahket',$this->keb_nutricairankeluhan_gangguanmengunyahket,true);
		$criteria->compare('keb_nutricairankeluhan_isgangguanmenelan',$this->keb_nutricairankeluhan_isgangguanmenelan);
		$criteria->compare('keb_nutricairankeluhan_gangguanmenelanket',$this->keb_nutricairankeluhan_gangguanmenelanket,true);
		$criteria->compare('keb_nutricairan_rasahausberlebih',$this->keb_nutricairan_rasahausberlebih);
		$criteria->compare('keb_nutricairan_turgorkulit',$this->keb_nutricairan_turgorkulit,true);
		$criteria->compare('keb_nutricairan_mukosamulut',$this->keb_nutricairan_mukosamulut,true);
		$criteria->compare('keb_nutricairan_edemastatus',$this->keb_nutricairan_edemastatus);
		$criteria->compare('keb_nutricairan_edemalokasi',$this->keb_nutricairan_edemalokasi,true);
		$criteria->compare('keb_eliminasi_bab_frekuensi',$this->keb_eliminasi_bab_frekuensi);
		$criteria->compare('keb_eliminasi_bab_keluhanstatus',$this->keb_eliminasi_bab_keluhanstatus);
		$criteria->compare('keb_eliminasi_bab_ispendarahan',$this->keb_eliminasi_bab_ispendarahan);
		$criteria->compare('keb_eliminasi_bab_ketpendarahan',$this->keb_eliminasi_bab_ketpendarahan,true);
		$criteria->compare('keb_eliminasi_bab_ishemorroid',$this->keb_eliminasi_bab_ishemorroid);
		$criteria->compare('keb_eliminasi_bab_kethemorroid',$this->keb_eliminasi_bab_kethemorroid,true);
		$criteria->compare('keb_eliminasi_bab_iskonstipasi',$this->keb_eliminasi_bab_iskonstipasi);
		$criteria->compare('keb_eliminasi_bab_ketkonstipasi',$this->keb_eliminasi_bab_ketkonstipasi,true);
		$criteria->compare('keb_eliminasi_bab_iskeluhanlainnya',$this->keb_eliminasi_bab_iskeluhanlainnya);
		$criteria->compare('keb_eliminasi_bab_ketkeluhanlainnya',$this->keb_eliminasi_bab_ketkeluhanlainnya,true);
		$criteria->compare('keb_eliminasi_bab_jeniskeluhanlainnya',$this->keb_eliminasi_bab_jeniskeluhanlainnya,true);
		$criteria->compare('keb_eliminasi_bab_karakteristik',$this->keb_eliminasi_bab_karakteristik,true);
		$criteria->compare('keb_eliminasi_bab_warnafeces',$this->keb_eliminasi_bab_warnafeces,true);
		$criteria->compare('keb_eliminasi_bab_status',$this->keb_eliminasi_bab_status);
		$criteria->compare('keb_eliminasi_bak_frekuensi',$this->keb_eliminasi_bak_frekuensi);
		$criteria->compare('keb_eliminasi_bak_jumlah',$this->keb_eliminasi_bak_jumlah);
		$criteria->compare('keb_eliminasi_bak_warnaurin',$this->keb_eliminasi_bak_warnaurin,true);
		$criteria->compare('keb_eliminasi_bak_keluhanstatus',$this->keb_eliminasi_bak_keluhanstatus);
		$criteria->compare('keb_eliminasi_bak_ispendarahan',$this->keb_eliminasi_bak_ispendarahan);
		$criteria->compare('keb_eliminasi_bak_ketpendarahan',$this->keb_eliminasi_bak_ketpendarahan,true);
		$criteria->compare('keb_eliminasi_bak_isnyeri',$this->keb_eliminasi_bak_isnyeri);
		$criteria->compare('keb_eliminasi_bak_ketnyeri',$this->keb_eliminasi_bak_ketnyeri,true);
		$criteria->compare('keb_eliminasi_bak_iskeluhanlainnya',$this->keb_eliminasi_bak_iskeluhanlainnya);
		$criteria->compare('keb_eliminasi_bak_ketkeluhanlainnya',$this->keb_eliminasi_bak_ketkeluhanlainnya,true);
		$criteria->compare('keb_eliminasi_bak_jeniskeluhanlainnya',$this->keb_eliminasi_bak_jeniskeluhanlainnya,true);
		$criteria->compare('keb_eliminasi_bak_status',$this->keb_eliminasi_bak_status);
		$criteria->compare('identifikasipenyakit_ismenular',$this->identifikasipenyakit_ismenular);
		$criteria->compare('identifikasipenyakit_ketmenular',$this->identifikasipenyakit_ketmenular,true);
		$criteria->compare('identifikasipenyakit_menularketerangan',$this->identifikasipenyakit_menularketerangan,true);
		$criteria->compare('identifikasipenyakit_ispenyakitjiwa',$this->identifikasipenyakit_ispenyakitjiwa);
		$criteria->compare('identifikasipenyakit_ketpenyakitjiwa',$this->identifikasipenyakit_ketpenyakitjiwa,true);
		$criteria->compare('identifikasipenyakitjiwa_iscenderungbunuhdiri',$this->identifikasipenyakitjiwa_iscenderungbunuhdiri);
		$criteria->compare('identifikasipenyakit_ketcenderungbunuhdiri',$this->identifikasipenyakit_ketcenderungbunuhdiri,true);
		$criteria->compare('identifikasipenyakitjiwa_isberlakuagresif',$this->identifikasipenyakitjiwa_isberlakuagresif);
		$criteria->compare('identifikasipenyakit_ketberlakuagresif',$this->identifikasipenyakit_ketberlakuagresif,true);
		$criteria->compare('identifikasipenyakitjiwa_islainnya',$this->identifikasipenyakitjiwa_islainnya);
		$criteria->compare('identifikasipenyakit_ketlainnya',$this->identifikasipenyakit_ketlainnya,true);
		$criteria->compare('identifikasipenyakitjiwa_keteranganlainnya',$this->identifikasipenyakitjiwa_keteranganlainnya,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_petugaspengisi_id',$this->create_petugaspengisi_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);
		$criteria->compare('riwayatpembedahan_status',$this->riwayatpembedahan_status,true);
		$criteria->compare('riwayatpembedahan_keterangan',$this->riwayatpembedahan_keterangan,true);
		$criteria->compare('kebutuhankhusus_ketcemas',$this->kebutuhankhusus_ketcemas,true);
		$criteria->compare('datasubjektif',$this->datasubjektif,true);
		$criteria->compare('resikojatuhkhususrj_hasilpenilaian_a',$this->resikojatuhkhususrj_hasilpenilaian_a);
		$criteria->compare('resikojatuhkhususrj_hasilpenilaian_b',$this->resikojatuhkhususrj_hasilpenilaian_b);
		$criteria->compare('resikojatuhkhususrj_hasilpengkajian',$this->resikojatuhkhususrj_hasilpengkajian,true);
		$criteria->compare('resikojatuhkhususrj_tindakanygdiperlukan',$this->resikojatuhkhususrj_tindakanygdiperlukan,true);
		$criteria->compare('pasien_id',$this->pasien_id);
		$criteria->compare('neonatus_anakke',$this->neonatus_anakke);
		$criteria->compare('neonatus_umurkehamilan',$this->neonatus_umurkehamilan);
		$criteria->compare('neonatus_ispenyakitibudm',$this->neonatus_ispenyakitibudm);
		$criteria->compare('neonatus_penyakitibu',$this->neonatus_penyakitibu,true);
		$criteria->compare('neonatus_ispenyakitibuhipertensi',$this->neonatus_ispenyakitibuhipertensi);
		$criteria->compare('neonatus_ispenyakitibujantung',$this->neonatus_ispenyakitibujantung);
		$criteria->compare('neonatus_ispenyakitibutbc',$this->neonatus_ispenyakitibutbc);
		$criteria->compare('neonatus_ispenyakitibuhepatitisb',$this->neonatus_ispenyakitibuhepatitisb);
		$criteria->compare('neonatus_ispenyakitibuasma',$this->neonatus_ispenyakitibuasma);
		$criteria->compare('neonatus_ispenyakitibupms',$this->neonatus_ispenyakitibupms);
		$criteria->compare('neonatus_ispenyakitibulainnya',$this->neonatus_ispenyakitibulainnya);
		$criteria->compare('neonatus_penyakitibu_lainnyaket',$this->neonatus_penyakitibu_lainnyaket,true);
		$criteria->compare('neonatus_riwayatpengobatanibu',$this->neonatus_riwayatpengobatanibu,true);
		$criteria->compare('neonatus_diagnosaibu',$this->neonatus_diagnosaibu,true);
		$criteria->compare('neonatus_jamlahir',$this->neonatus_jamlahir,true);
		$criteria->compare('neonatus_tgllahirbayi',$this->neonatus_tgllahirbayi,true);
		$criteria->compare('neonatus_kondisisaatlahir',$this->neonatus_kondisisaatlahir,true);
		$criteria->compare('neonatus_carapersalinan',$this->neonatus_carapersalinan,true);
		$criteria->compare('neonatus_apgarscore',$this->neonatus_apgarscore);
		$criteria->compare('neonatus_letak',$this->neonatus_letak,true);
		$criteria->compare('neonatus_talipusat',$this->neonatus_talipusat,true);
		$criteria->compare('neonatus_faktorinfeksimayor_ibudemam',$this->neonatus_faktorinfeksimayor_ibudemam);
		$criteria->compare('neonatus_faktorinfeksimayor_kpdlebihdr24jam',$this->neonatus_faktorinfeksimayor_kpdlebihdr24jam);
		$criteria->compare('neonatus_faktorinfeksimayor_ketubanhijau',$this->neonatus_faktorinfeksimayor_ketubanhijau);
		$criteria->compare('neonatus_faktorinfeksimayor_korioamnionitis',$this->neonatus_faktorinfeksimayor_korioamnionitis);
		$criteria->compare('neonatus_faktorinfeksimayor_fetaldistress',$this->neonatus_faktorinfeksimayor_fetaldistress);
		$criteria->compare('neonatus_faktorinfeksimayor_ket',$this->neonatus_faktorinfeksimayor_ket,true);
		$criteria->compare('neonatus_faktorinfeksiminor_kpdkurangdr12jam',$this->neonatus_faktorinfeksiminor_kpdkurangdr12jam);
		$criteria->compare('neonatus_faktorinfeksiminor_asfiksia',$this->neonatus_faktorinfeksiminor_asfiksia);
		$criteria->compare('neonatus_faktorinfeksiminor_bblr',$this->neonatus_faktorinfeksiminor_bblr);
		$criteria->compare('neonatus_faktorinfeksiminor_isk',$this->neonatus_faktorinfeksiminor_isk);
		$criteria->compare('neonatus_faktorinfeksiminor_ukkurangdr37minggu',$this->neonatus_faktorinfeksiminor_ukkurangdr37minggu);
		$criteria->compare('neonatus_faktorinfeksiminor_gemeli',$this->neonatus_faktorinfeksiminor_gemeli);
		$criteria->compare('neonatus_faktorinfeksiminor_keputihan',$this->neonatus_faktorinfeksiminor_keputihan);
		$criteria->compare('neonatus_faktorinfeksiminor_ibutemplebihdr37',$this->neonatus_faktorinfeksiminor_ibutemplebihdr37);
		$criteria->compare('neonatus_faktorinfeksiminor_ket',$this->neonatus_faktorinfeksiminor_ket,true);
		$criteria->compare('neonatus_nutrisiasi',$this->neonatus_nutrisiasi);
		$criteria->compare('neonatus_nutrisiasi_frekuensijml',$this->neonatus_nutrisiasi_frekuensijml);
		$criteria->compare('neonatus_nutrisiasi_frekuensikali',$this->neonatus_nutrisiasi_frekuensikali);
		$criteria->compare('neonatus_nutrisilainnyaket',$this->neonatus_nutrisilainnyaket,true);
		$criteria->compare('neonatus_alergidikajikpd',$this->neonatus_alergidikajikpd,true);
		$criteria->compare('ispasangtandaalergi',$this->ispasangtandaalergi);
		$criteria->compare('neonatus_nutrisilainnya',$this->neonatus_nutrisilainnya);
		$criteria->compare('jenisasesmen',$this->jenisasesmen,true);
		$criteria->compare('khususanak_usiaibu_saathamil',$this->khususanak_usiaibu_saathamil);
		$criteria->compare('khususanak_gravida_g',$this->khususanak_gravida_g);
		$criteria->compare('khususanak_gravida_p',$this->khususanak_gravida_p);
		$criteria->compare('khususanak_gravida_a',$this->khususanak_gravida_a);
		$criteria->compare('khususanak_gangguanhamil',$this->khususanak_gangguanhamil,true);
		$criteria->compare('khususanak_tipepersalinan',$this->khususanak_tipepersalinan,true);
		$criteria->compare('khususanak_beratbadanlahir',$this->khususanak_beratbadanlahir);
		$criteria->compare('khususanak_tinggibadan',$this->khususanak_tinggibadan);
		$criteria->compare('neonatus_kebpsikologidikasikpd',$this->neonatus_kebpsikologidikasikpd,true);
		$criteria->compare('neonatus_masalahperkawinanortu',$this->neonatus_masalahperkawinanortu,true);
		$criteria->compare('neonatus_masalahperkawinanortuket',$this->neonatus_masalahperkawinanortuket,true);
		$criteria->compare('neonatus_kekerasanfisikortu',$this->neonatus_kekerasanfisikortu,true);
		$criteria->compare('neonatus_kekerasanfisikortu_iscederadiri',$this->neonatus_kekerasanfisikortu_iscederadiri);
		$criteria->compare('neonatus_kekerasanfisikortu_isorglain',$this->neonatus_kekerasanfisikortu_isorglain);
		$criteria->compare('neonatus_traumadlmhiduportu',$this->neonatus_traumadlmhiduportu,true);
		$criteria->compare('neonatus_traumadlmhiduportuket',$this->neonatus_traumadlmhiduportuket,true);
		$criteria->compare('neonatus_konsulpsikologortu',$this->neonatus_konsulpsikologortu,true);
		$criteria->compare('neonatus_penerimaankondisibayi',$this->neonatus_penerimaankondisibayi,true);
		$criteria->compare('neonatus_dukungansosialdr',$this->neonatus_dukungansosialdr,true);
		$criteria->compare('neonatus_dukungansosialdr_issuami',$this->neonatus_dukungansosialdr_issuami);
		$criteria->compare('neonatus_dukungansosialdr_isistri',$this->neonatus_dukungansosialdr_isistri);
		$criteria->compare('neonatus_dukungansosialdr_isortu',$this->neonatus_dukungansosialdr_isortu);
		$criteria->compare('neonatus_dukungansosialdr_iskeluarga',$this->neonatus_dukungansosialdr_iskeluarga);
		$criteria->compare('neonatus_dukungansosialdr_islainnya',$this->neonatus_dukungansosialdr_islainnya);
		$criteria->compare('neonatus_dukungansosialdr_lainnyaket',$this->neonatus_dukungansosialdr_lainnyaket,true);
		$criteria->compare('neonatus_kebsosialekonomi_pihakygdikaji',$this->neonatus_kebsosialekonomi_pihakygdikaji,true);
		$criteria->compare('neonatus_kebsosialekonomi_pihakygdikajilainnya',$this->neonatus_kebsosialekonomi_pihakygdikajilainnya,true);
		$criteria->compare('neonatus_kebsosialekonomi_statusperkawinan',$this->neonatus_kebsosialekonomi_statusperkawinan,true);
		$criteria->compare('neonatus_jmlmenikahortu',$this->neonatus_jmlmenikahortu);
		$criteria->compare('neonatus_pendidikanortu',$this->neonatus_pendidikanortu,true);
		$criteria->compare('neonatus_warganegaraortu',$this->neonatus_warganegaraortu,true);
		$criteria->compare('neonatus_pekerjaanortu',$this->neonatus_pekerjaanortu,true);
		$criteria->compare('neonatus_tinggalbersama',$this->neonatus_tinggalbersama,true);
		$criteria->compare('neonatus_tinggalbersamalainnya_nama',$this->neonatus_tinggalbersamalainnya_nama,true);
		$criteria->compare('neonatus_tinggalbersamalainnya_notlp',$this->neonatus_tinggalbersamalainnya_notlp,true);
		$criteria->compare('neonatus_kebiasaanortualkohol_status',$this->neonatus_kebiasaanortualkohol_status);
		$criteria->compare('neonatus_kebiasaanortualkohol_jenis',$this->neonatus_kebiasaanortualkohol_jenis,true);
		$criteria->compare('neonatus_kebiasaanortualkohol_jml',$this->neonatus_kebiasaanortualkohol_jml);
		$criteria->compare('neonatus_kebiasaanortulainnya',$this->neonatus_kebiasaanortulainnya,true);
		$criteria->compare('neonatus_agamaortu',$this->neonatus_agamaortu,true);
		$criteria->compare('neonatus_cries_totalnilai',$this->neonatus_cries_totalnilai);
		$criteria->compare('neonatus_cries_cryingnilai',$this->neonatus_cries_cryingnilai);
		$criteria->compare('neonatus_cries_cryingket',$this->neonatus_cries_cryingket,true);
		$criteria->compare('neonatus_cries_requiresnilai',$this->neonatus_cries_requiresnilai);
		$criteria->compare('neonatus_cries_requiresket',$this->neonatus_cries_requiresket,true);
		$criteria->compare('neonatus_cries_increasednilai',$this->neonatus_cries_increasednilai);
		$criteria->compare('neonatus_cries_increasedket',$this->neonatus_cries_increasedket,true);
		$criteria->compare('neonatus_cries_expressionnilai',$this->neonatus_cries_expressionnilai);
		$criteria->compare('neonatus_cries_expressionket',$this->neonatus_cries_expressionket,true);
		$criteria->compare('neonatus_cries_sleeplessnilai',$this->neonatus_cries_sleeplessnilai);
		$criteria->compare('neonatus_cries_sleeplessket',$this->neonatus_cries_sleeplessket,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
