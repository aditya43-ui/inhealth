<?php

/**
 * This is the model class for table "pendaftaran_t".
 *
 * The followings are the available columns in table 'pendaftaran_t':
 * @property integer $pendaftaran_id
 * @property integer $pasienpulang_id
 * @property integer $pasienbatalperiksa_id
 * @property integer $penanggungjawab_id
 * @property integer $penjamin_id
 * @property integer $shift_id
 * @property integer $pasien_id
 * @property integer $persalinan_id
 * @property integer $pegawai_id
 * @property integer $instalasi_id
 * @property integer $caramasuk_id
 * @property integer $pengirimanrm_id
 * @property integer $peminjamanrm_id
 * @property integer $jeniskasuspenyakit_id
 * @property integer $pembayaranpelayanan_id
 * @property integer $kelaspelayanan_id
 * @property integer $carabayar_id
 * @property integer $pasienadmisi_id
 * @property integer $kelompokumur_id
 * @property integer $golonganumur_id
 * @property integer $rujukan_id
 * @property integer $antrian_id
 * @property integer $karcis_id
 * @property integer $ruangan_id
 * @property string $no_pendaftaran
 * @property string $tgl_pendaftaran
 * @property string $no_urutantri
 * @property string $transportasi
 * @property string $keadaanmasuk
 * @property string $statusperiksa
 * @property string $statuspasien
 * @property string $kunjungan
 * @property boolean $alihstatus
 * @property boolean $byphone
 * @property boolean $kunjunganrumah
 * @property string $statusmasuk
 * @property string $umur
 * @property string $tglselesaiperiksa
 * @property string $keterangan_reg
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property boolean $nopendaftaran_aktif
 * @property string $status_konfirmasi
 * @property string $tgl_konfirmasi
 * @property string $tglrenkontrol
 * @property boolean $statusfarmasi
 * @property integer $sep_id
 *
 * The followings are the available model relations:
 * @property AnamesadietT[] $anamesadietTs
 * @property AmbiljenazahT[] $ambiljenazahTs
 * @property AnamnesaT[] $anamnesaTs
 * @property AntrianT[] $antrianTs
 * @property PenjualanresepT[] $penjualanresepTs
 * @property ObatalkespasienT[] $obatalkespasienTs
 * @property BookingkamarT[] $bookingkamarTs
 * @property BayaruangmukaT[] $bayaruangmukaTs
 * @property PasienmasukpenunjangT[] $pasienmasukpenunjangTs
 * @property PasienadmisiT[] $pasienadmisiTs
 * @property PasienpulangT[] $pasienpulangTs
 * @property DietpasienT[] $dietpasienTs
 * @property PeminjamanrmT[] $peminjamanrmTs
 * @property PengirimanrmT[] $pengirimanrmTs
 * @property HasilpemeriksaanpaT[] $hasilpemeriksaanpaTs
 * @property HasilpemeriksaanrmT[] $hasilpemeriksaanrmTs
 * @property HasilpemeriksaanlabT[] $hasilpemeriksaanlabTs
 * @property ResepturT[] $resepturTs
 * @property PasienkirimkeunitlainT[] $pasienkirimkeunitlainTs
 * @property KembalirmT[] $kembalirmTs
 * @property KonsulpoliT[] $konsulpoliTs
 * @property JadwalkunjunganrmT[] $jadwalkunjunganrmTs
 * @property KegbayitabungT[] $kegbayitabungTs
 * @property PasienmorbiditasT[] $pasienmorbiditasTs
 * @property PasienkecelakaanT[] $pasienkecelakaanTs
 * @property ReturresepT[] $returresepTs
 * @property PasienapachescoreT[] $pasienapachescoreTs
 * @property PasienimunisasiT[] $pasienimunisasiTs
 * @property PasienkbT[] $pasienkbTs
 * @property PindahkamarT[] $pindahkamarTs
 * @property PemeriksaanfisikT[] $pemeriksaanfisikTs
 * @property PesanmenudetailT[] $pesanmenudetailTs
 * @property PesanambulansT[] $pesanambulansTs
 * @property RencanaoperasiT[] $rencanaoperasiTs
 * @property RincianCetakan[] $rincianCetakans
 * @property SuratketeranganR[] $suratketeranganRs
 * @property UbahruanganR[] $ubahruanganRs
 * @property PemakaianambulansT[] $pemakaianambulansTs
 * @property TindakanpelayananT[] $tindakanpelayananTs
 * @property PasiendirujukkeluarT[] $pasiendirujukkeluarTs
 * @property OdontogramdetailT[] $odontogramdetailTs
 * @property PasienanastesiT[] $pasienanastesiTs
 * @property PembklaimdetalT[] $pembklaimdetalTs
 * @property PeriksakehamilanT[] $periksakehamilanTs
 * @property PersalinanT[] $persalinanTs
 * @property AntrianT $antrian
 * @property CarabayarM $carabayar
 * @property CaramasukM $caramasuk
 * @property GolonganumurM $golonganumur
 * @property InstalasiM $instalasi
 * @property JeniskasuspenyakitM $jeniskasuspenyakit
 * @property KarcisM $karcis
 * @property KelaspelayananM $kelaspelayanan
 * @property KelompokumurM $kelompokumur
 * @property PasienM $pasien
 * @property PasienbatalperiksaR $pasienbatalperiksa
 * @property PasienpulangT $pasienpulang
 * @property PegawaiM $pegawai
 * @property PeminjamanrmT $peminjamanrm
 * @property PenanggungjawabM $penanggungjawab
 * @property PengirimanrmT $pengirimanrm
 * @property PenjaminpasienM $penjamin
 * @property PersalinanT $persalinan
 * @property RuanganM $ruangan
 * @property RujukanT $rujukan
 * @property ShiftM $shift
 * @property HasilpemeriksaanradT[] $hasilpemeriksaanradTs
 * @property KirimmenupasienT[] $kirimmenupasienTs
 * @property PasiennapzaT[] $pasiennapzaTs
 * @property SepT[] $sepTs
 */
class ATPendaftaranT extends PendaftaranT
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PendaftaranT the static model class
	 */

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}