<?php
/**
 * model yang digunakan untuk mengakses tabel infopengkajianaskep_v, pada modul asuhan keperawatan
 * 
 * @package application.modules.asuhanKeperawatan
 * @subpackage models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0
 * @link    <http://piindonesia.co.id>
 */
class ASInfopengkajianaskepV extends InfopengkajianaskepV
{
	public $tgl_awal,$tgl_akhir,$instalasi_id, $rencanaaskep_id;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
            //    $criteria->select = "t.no_pengkajian, t.pengkajianaskep_tgl, t.no_pendaftaran, t.nama_pasien, t.jeniskelamin, t.nama_pegawai, t.ruangan_nama, t.kelaspelayanan_nama, t.pengkajianaskep_id, rencanaaskep_t.rencanaaskep_id";
            //    $criteria->join = " LEFT JOIN rencanaaskep_t ON rencanaaskep_t.pengkajianaskep_id = t.pengkajianaskep_id";
			$criteria->group = "t.no_pengkajian, t.pengkajianaskep_tgl, t.no_pendaftaran, t.nama_pasien, t.jeniskelamin, t.nama_pegawai, t.ruangan_nama, t.kelaspelayanan_nama, t.pengkajianaskep_id, rencanaaskep_t.rencanaaskep_id";
			$criteria->select = $criteria->group;
            $criteria->join = " LEFT JOIN rencanaaskep_t ON rencanaaskep_t.pengkajianaskep_id = t.pengkajianaskep_id";
                        
		$criteria->compare('t.pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('t.ruangan_id',$this->ruangan_id);
		$criteria->compare('t.anamesa_id',$this->anamesa_id);
		$criteria->compare('t.pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		$criteria->compare('t.no_pengkajian',$this->no_pengkajian,true);
		$criteria->addBetweenCondition('DATE(t.pengkajianaskep_tgl)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('t.create_time',$this->create_time,true);
		$criteria->compare('t.update_time',$this->update_time,true);
		$criteria->compare('t.create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('t.update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('t.create_ruangan',$this->create_ruangan,true);
		$criteria->compare('t.pegawai_id',$this->pegawai_id);
		$criteria->compare('t.nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('t.tglanamnesis',$this->tglanamnesis,true);
		$criteria->compare('t.keluhanutama',$this->keluhanutama,true);
		$criteria->compare('t.keluhantambahan',$this->keluhantambahan,true);
		$criteria->compare('t.riwayatpenyakitterdahulu',$this->riwayatpenyakitterdahulu,true);
		$criteria->compare('t.riwayatpenyakitkeluarga',$this->riwayatpenyakitkeluarga,true);
		$criteria->compare('t.riwayatimunisasi',$this->riwayatimunisasi,true);
		$criteria->compare('t.riwayatalergiobat',$this->riwayatalergiobat,true);
		$criteria->compare('t.riwayatmakanan',$this->riwayatmakanan,true);
		$criteria->compare('t.tglperiksafisik',$this->tglperiksafisik,true);
		$criteria->compare('t.keadaanumum',$this->keadaanumum,true);
		$criteria->compare('t.beratbadan_kg',$this->beratbadan_kg);
		$criteria->compare('t.tinggibadan_cm',$this->tinggibadan_cm);
		$criteria->compare('t.tekanandarah',$this->tekanandarah,true);
		$criteria->compare('t.detaknadi',$this->detaknadi);
		$criteria->compare('t.suhutubuh',$this->suhutubuh,true);
		$criteria->compare('t.pernapasan',$this->pernapasan,true);
		$criteria->compare('t.gcs_motorik',$this->gcs_motorik);
		$criteria->compare('t.kelainanpadabagtubuh',$this->kelainanpadabagtubuh,true);
		$criteria->compare('t.pengkajianaskep_id',$this->pengkajianaskep_id);
		$criteria->compare('t.ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('t.kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('t.nama_pasien',$this->nama_pasien,true);
		$criteria->compare('t.no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('t.tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('t.no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('t.umur',$this->umur,true);
		$criteria->compare('t.statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('t.jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('t.pekerjaan_nama',$this->pekerjaan_nama,true);
		$criteria->compare('t.pendidikan_nama',$this->pendidikan_nama,true);
		$criteria->compare('t.agama',$this->agama,true);
		$criteria->compare('t.alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('t.kamarruangan_nokamar',$this->kamarruangan_nokamar,true);
		$criteria->compare('t.kamarruangan_nobed',$this->kamarruangan_nobed,true);
		$criteria->compare('t.diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('t.nama_pj',$this->nama_pj,true);
		$criteria->compare('t.no_identitas',$this->no_identitas,true);
		$criteria->compare('t.tgllahir_pj',$this->tgllahir_pj,true);
		$criteria->compare('t.no_teleponpj',$this->no_teleponpj,true);
		$criteria->compare('t.no_mobilepj',$this->no_mobilepj,true);
		$criteria->compare('t.hubungankeluarga',$this->hubungankeluarga,true);
		$criteria->compare('t.alamat_pj',$this->alamat_pj,true);
		$criteria->compare('t.jk',$this->jk,true);
		$criteria->compare('t.riwayatperjalananpasien',$this->riwayatperjalananpasien,true);
		$criteria->compare('t.pernahdirawat',$this->pernahdirawat);
		$criteria->compare('t.dirawatdimana',$this->dirawatdimana,true);
		$criteria->compare('t.lamasakit',$this->lamasakit,true);
		$criteria->compare('t.riwpenyakitkeldari',$this->riwpenyakitkeldari,true);
		$criteria->compare('t.penyakitmayor',$this->penyakitmayor,true);
		$criteria->compare('t.reaksialergiobat',$this->reaksialergiobat,true);
		$criteria->compare('t.reaksialergimakanan',$this->reaksialergimakanan,true);
		$criteria->compare('t.riwayatalergilainnya',$this->riwayatalergilainnya,true);
		$criteria->compare('t.reaksialergilainnya',$this->reaksialergilainnya,true);
		$criteria->compare('t.pengobatanygsudahdilakukan',$this->pengobatanygsudahdilakukan,true);
		$criteria->compare('t.riwayatkelahiran',$this->riwayatkelahiran,true);
		$criteria->compare('t.gelangtandaalergi',$this->gelangtandaalergi,true);
		$criteria->compare('t.statusmerokok',$this->statusmerokok);
		$criteria->compare('t.jmlrokok_btg_hr',$this->jmlrokok_btg_hr);
		$criteria->compare('t.statuspsikologis',$this->statuspsikologis,true);
		$criteria->compare('t.statusmental',$this->statusmental,true);
		$criteria->compare('t.masalahsebelumnya',$this->masalahsebelumnya,true);
		$criteria->compare('t.prilakukekerasansebelumnya',$this->prilakukekerasansebelumnya,true);
		$criteria->compare('t.penurunanbb_3bln',$this->penurunanbb_3bln);
		$criteria->compare('t.asupanberkurang',$this->asupanberkurang);
		$criteria->compare('t.aktifitas_mobilisasi',$this->aktifitas_mobilisasi,true);
		$criteria->compare('t.sebutkan_bantuan',$this->sebutkan_bantuan,true);
		$criteria->compare('t.resikocedera',$this->resikocedera);
		$criteria->compare('t.isgelangresiko',$this->isgelangresiko);
		$criteria->compare('t.tandasegitigaterpasang',$this->tandasegitigaterpasang,true);
		$criteria->compare('t.skriningnyeri',$this->skriningnyeri,true);
		$criteria->compare('t.skalanyeri',$this->skalanyeri,true);
		$criteria->compare('t.karakteristiknyeri',$this->karakteristiknyeri,true);
		$criteria->compare('t.lokasinyeri',$this->lokasinyeri,true);
		$criteria->compare('t.nyeriterasa',$this->nyeriterasa,true);
		$criteria->compare('t.nyerihilangbila',$this->nyerihilangbila,true);
		$criteria->compare('t.hubkeluarga',$this->hubkeluarga);
		$criteria->compare('t.tempattinggal',$this->tempattinggal,true);
		$criteria->compare('t.keterangananamesa',$this->keterangananamesa,true);
		$criteria->compare('t.meanarteripressure',$this->meanarteripressure);
		$criteria->compare('t.denyutjantung',$this->denyutjantung,true);
		$criteria->compare('t.inspeksi',$this->inspeksi,true);
		$criteria->compare('t.palpasi',$this->palpasi,true);
		$criteria->compare('t.perkusi',$this->perkusi,true);
		$criteria->compare('t.auskultasi',$this->auskultasi,true);
		$criteria->compare('t.jn_paten',$this->jn_paten);
		$criteria->compare('t.jn_obstruktifpartial',$this->jn_obstruktifpartial);
		$criteria->compare('t.jn_obstruktifnormal',$this->jn_obstruktifnormal);
		$criteria->compare('t.jn_stridor',$this->jn_stridor);
		$criteria->compare('t.jn_gargling',$this->jn_gargling);
		$criteria->compare('t.pgd_simetri',$this->pgd_simetri);
		$criteria->compare('t.pgd_asimetri',$this->pgd_asimetri);
		$criteria->compare('t.pgp_normal',$this->pgp_normal);
		$criteria->compare('t.pgp_kussmaul',$this->pgp_kussmaul);
		$criteria->compare('t.pgp_takipnea',$this->pgp_takipnea);
		$criteria->compare('t.pgp_retraktif',$this->pgp_retraktif);
		$criteria->compare('t.pgp_dangkal',$this->pgp_dangkal);
		$criteria->compare('t.sirkulasi_nadicarotis',$this->sirkulasi_nadicarotis);
		$criteria->compare('t.sirkulasi_nadiradialis',$this->sirkulasi_nadiradialis);
		$criteria->compare('t.cfr_kecil_2',$this->cfr_kecil_2);
		$criteria->compare('t.cfr_besar_2',$this->cfr_besar_2);
		$criteria->compare('t.kulit_normal',$this->kulit_normal);
		$criteria->compare('t.kulit_jaundice',$this->kulit_jaundice);
		$criteria->compare('t.kulit_cyanosis',$this->kulit_cyanosis);
		$criteria->compare('t.kulit_pucat',$this->kulit_pucat);
		$criteria->compare('t.kulit_berkeringat',$this->kulit_berkeringat);
		$criteria->compare('t.akral',$this->akral,true);
		$criteria->compare('t.gcs_eye',$this->gcs_eye);
		$criteria->compare('t.gcs_verbal',$this->gcs_verbal);
		$criteria->compare('t.adakelgastrointestinal',$this->adakelgastrointestinal);
		$criteria->compare('t.gastrointestinal_sebutkan',$this->gastrointestinal_sebutkan,true);
		$criteria->compare('t.pembatasanmakanan',$this->pembatasanmakanan);
		$criteria->compare('t.batasmakanan_sebutkan',$this->batasmakanan_sebutkan,true);
		$criteria->compare('t.gigipalsu',$this->gigipalsu);
		$criteria->compare('t.gigipalsu_bagian',$this->gigipalsu_bagian,true);
		$criteria->compare('t.mual',$this->mual);
		$criteria->compare('t.muntah',$this->muntah);
		$criteria->compare('t.pendengaran',$this->pendengaran);
		$criteria->compare('t.pendengaran_sebutkan',$this->pendengaran_sebutkan,true);
		$criteria->compare('t.penglihatan',$this->penglihatan);
		$criteria->compare('t.penglihatan_sebutkan',$this->penglihatan_sebutkan,true);
		$criteria->compare('t.defekasi',$this->defekasi);
		$criteria->compare('t.defekasi_sebutkan',$this->defekasi_sebutkan,true);
		$criteria->compare('t.miksi',$this->miksi);
		$criteria->compare('t.miksi_sebutkan',$this->miksi_sebutkan,true);
		$criteria->compare('t.hamil',$this->hamil);
		$criteria->compare('t.hpht',$this->hpht,true);
		$criteria->compare('t.keluhanmenstruasi',$this->keluhanmenstruasi,true);
		$criteria->compare('t.skornorton',$this->skornorton);
		$criteria->compare('t.resikodekubitus',$this->resikodekubitus);
		$criteria->compare('t.terdapatluka',$this->terdapatluka);
		$criteria->compare('t.lokasiluka',$this->lokasiluka,true);
		$criteria->compare('t.hambatanpembelajaran',$this->hambatanpembelajaran);
		$criteria->compare('t.hambatanpembelajaran_ya',$this->hambatanpembelajaran_ya,true);
		$criteria->compare('t.butuhpenerjemah',$this->butuhpenerjemah);
		$criteria->compare('t.kebutuhanpembelajaran',$this->kebutuhanpembelajaran,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort' =>[
                            'defaultOrder'=>'pengkajianaskep_tgl DESC'
                        ]
		));
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

		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('anamesa_id',$this->anamesa_id);
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		$criteria->compare('LOWER(no_pengkajian)',strtolower($this->no_pengkajian),true);
		if(!empty($this->pengkajianaskep_tgl)){
			$criteria->addCondition("DATE(pengkajianaskep_tgl) = '" . $this->pengkajianaskep_tgl . "'");
		}
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('tglanamnesis',$this->tglanamnesis,true);
		$criteria->compare('keluhanutama',$this->keluhanutama,true);
		$criteria->compare('keluhantambahan',$this->keluhantambahan,true);
		$criteria->compare('riwayatpenyakitterdahulu',$this->riwayatpenyakitterdahulu,true);
		$criteria->compare('riwayatpenyakitkeluarga',$this->riwayatpenyakitkeluarga,true);
		$criteria->compare('riwayatimunisasi',$this->riwayatimunisasi,true);
		$criteria->compare('riwayatalergiobat',$this->riwayatalergiobat,true);
		$criteria->compare('riwayatmakanan',$this->riwayatmakanan,true);
		$criteria->compare('tglperiksafisik',$this->tglperiksafisik,true);
		$criteria->compare('keadaanumum',$this->keadaanumum,true);
		$criteria->compare('beratbadan_kg',$this->beratbadan_kg);
		$criteria->compare('tinggibadan_cm',$this->tinggibadan_cm);
		$criteria->compare('tekanandarah',$this->tekanandarah,true);
		$criteria->compare('detaknadi',$this->detaknadi);
		$criteria->compare('suhutubuh',$this->suhutubuh,true);
		$criteria->compare('pernapasan',$this->pernapasan,true);
		$criteria->compare('gcs_motorik',$this->gcs_motorik);
		$criteria->compare('kelainanpadabagtubuh',$this->kelainanpadabagtubuh,true);
		$criteria->compare('pengkajianaskep_id',$this->pengkajianaskep_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('pekerjaan_nama',$this->pekerjaan_nama,true);
		$criteria->compare('pendidikan_nama',$this->pendidikan_nama,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('kamarruangan_nokamar',$this->kamarruangan_nokamar,true);
		$criteria->compare('kamarruangan_nobed',$this->kamarruangan_nobed,true);
		$criteria->compare('diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('nama_pj',$this->nama_pj,true);
		$criteria->compare('no_identitas',$this->no_identitas,true);
		$criteria->compare('tgllahir_pj',$this->tgllahir_pj,true);
		$criteria->compare('no_teleponpj',$this->no_teleponpj,true);
		$criteria->compare('no_mobilepj',$this->no_mobilepj,true);
		$criteria->compare('hubungankeluarga',$this->hubungankeluarga,true);
		$criteria->compare('alamat_pj',$this->alamat_pj,true);
		$criteria->compare('jk',$this->jk,true);
		$criteria->compare('riwayatperjalananpasien',$this->riwayatperjalananpasien,true);
		$criteria->compare('pernahdirawat',$this->pernahdirawat);
		$criteria->compare('dirawatdimana',$this->dirawatdimana,true);
		$criteria->compare('lamasakit',$this->lamasakit,true);
		$criteria->compare('riwpenyakitkeldari',$this->riwpenyakitkeldari,true);
		$criteria->compare('penyakitmayor',$this->penyakitmayor,true);
		$criteria->compare('reaksialergiobat',$this->reaksialergiobat,true);
		$criteria->compare('reaksialergimakanan',$this->reaksialergimakanan,true);
		$criteria->compare('riwayatalergilainnya',$this->riwayatalergilainnya,true);
		$criteria->compare('reaksialergilainnya',$this->reaksialergilainnya,true);
		$criteria->compare('pengobatanygsudahdilakukan',$this->pengobatanygsudahdilakukan,true);
		$criteria->compare('riwayatkelahiran',$this->riwayatkelahiran,true);
		$criteria->compare('gelangtandaalergi',$this->gelangtandaalergi,true);
		$criteria->compare('statusmerokok',$this->statusmerokok);
		$criteria->compare('jmlrokok_btg_hr',$this->jmlrokok_btg_hr);
		$criteria->compare('statuspsikologis',$this->statuspsikologis,true);
		$criteria->compare('statusmental',$this->statusmental,true);
		$criteria->compare('masalahsebelumnya',$this->masalahsebelumnya,true);
		$criteria->compare('prilakukekerasansebelumnya',$this->prilakukekerasansebelumnya,true);
		$criteria->compare('penurunanbb_3bln',$this->penurunanbb_3bln);
		$criteria->compare('asupanberkurang',$this->asupanberkurang);
		$criteria->compare('aktifitas_mobilisasi',$this->aktifitas_mobilisasi,true);
		$criteria->compare('sebutkan_bantuan',$this->sebutkan_bantuan,true);
		$criteria->compare('resikocedera',$this->resikocedera);
		$criteria->compare('isgelangresiko',$this->isgelangresiko);
		$criteria->compare('tandasegitigaterpasang',$this->tandasegitigaterpasang,true);
		$criteria->compare('skriningnyeri',$this->skriningnyeri,true);
		$criteria->compare('skalanyeri',$this->skalanyeri,true);
		$criteria->compare('karakteristiknyeri',$this->karakteristiknyeri,true);
		$criteria->compare('lokasinyeri',$this->lokasinyeri,true);
		$criteria->compare('nyeriterasa',$this->nyeriterasa,true);
		$criteria->compare('nyerihilangbila',$this->nyerihilangbila,true);
		$criteria->compare('hubkeluarga',$this->hubkeluarga);
		$criteria->compare('tempattinggal',$this->tempattinggal,true);
		$criteria->compare('keterangananamesa',$this->keterangananamesa,true);
		$criteria->compare('meanarteripressure',$this->meanarteripressure);
		$criteria->compare('denyutjantung',$this->denyutjantung,true);
		$criteria->compare('inspeksi',$this->inspeksi,true);
		$criteria->compare('palpasi',$this->palpasi,true);
		$criteria->compare('perkusi',$this->perkusi,true);
		$criteria->compare('auskultasi',$this->auskultasi,true);
		$criteria->compare('jn_paten',$this->jn_paten);
		$criteria->compare('jn_obstruktifpartial',$this->jn_obstruktifpartial);
		$criteria->compare('jn_obstruktifnormal',$this->jn_obstruktifnormal);
		$criteria->compare('jn_stridor',$this->jn_stridor);
		$criteria->compare('jn_gargling',$this->jn_gargling);
		$criteria->compare('pgd_simetri',$this->pgd_simetri);
		$criteria->compare('pgd_asimetri',$this->pgd_asimetri);
		$criteria->compare('pgp_normal',$this->pgp_normal);
		$criteria->compare('pgp_kussmaul',$this->pgp_kussmaul);
		$criteria->compare('pgp_takipnea',$this->pgp_takipnea);
		$criteria->compare('pgp_retraktif',$this->pgp_retraktif);
		$criteria->compare('pgp_dangkal',$this->pgp_dangkal);
		$criteria->compare('sirkulasi_nadicarotis',$this->sirkulasi_nadicarotis);
		$criteria->compare('sirkulasi_nadiradialis',$this->sirkulasi_nadiradialis);
		$criteria->compare('cfr_kecil_2',$this->cfr_kecil_2);
		$criteria->compare('cfr_besar_2',$this->cfr_besar_2);
		$criteria->compare('kulit_normal',$this->kulit_normal);
		$criteria->compare('kulit_jaundice',$this->kulit_jaundice);
		$criteria->compare('kulit_cyanosis',$this->kulit_cyanosis);
		$criteria->compare('kulit_pucat',$this->kulit_pucat);
		$criteria->compare('kulit_berkeringat',$this->kulit_berkeringat);
		$criteria->compare('akral',$this->akral,true);
		$criteria->compare('gcs_eye',$this->gcs_eye);
		$criteria->compare('gcs_verbal',$this->gcs_verbal);
		$criteria->compare('adakelgastrointestinal',$this->adakelgastrointestinal);
		$criteria->compare('gastrointestinal_sebutkan',$this->gastrointestinal_sebutkan,true);
		$criteria->compare('pembatasanmakanan',$this->pembatasanmakanan);
		$criteria->compare('batasmakanan_sebutkan',$this->batasmakanan_sebutkan,true);
		$criteria->compare('gigipalsu',$this->gigipalsu);
		$criteria->compare('gigipalsu_bagian',$this->gigipalsu_bagian,true);
		$criteria->compare('mual',$this->mual);
		$criteria->compare('muntah',$this->muntah);
		$criteria->compare('pendengaran',$this->pendengaran);
		$criteria->compare('pendengaran_sebutkan',$this->pendengaran_sebutkan,true);
		$criteria->compare('penglihatan',$this->penglihatan);
		$criteria->compare('penglihatan_sebutkan',$this->penglihatan_sebutkan,true);
		$criteria->compare('defekasi',$this->defekasi);
		$criteria->compare('defekasi_sebutkan',$this->defekasi_sebutkan,true);
		$criteria->compare('miksi',$this->miksi);
		$criteria->compare('miksi_sebutkan',$this->miksi_sebutkan,true);
		$criteria->compare('hamil',$this->hamil);
		$criteria->compare('hpht',$this->hpht,true);
		$criteria->compare('keluhanmenstruasi',$this->keluhanmenstruasi,true);
		$criteria->compare('skornorton',$this->skornorton);
		$criteria->compare('resikodekubitus',$this->resikodekubitus);
		$criteria->compare('terdapatluka',$this->terdapatluka);
		$criteria->compare('lokasiluka',$this->lokasiluka,true);
		$criteria->compare('hambatanpembelajaran',$this->hambatanpembelajaran);
		$criteria->compare('hambatanpembelajaran_ya',$this->hambatanpembelajaran_ya,true);
		$criteria->compare('butuhpenerjemah',$this->butuhpenerjemah);
		$criteria->compare('kebutuhanpembelajaran',$this->kebutuhanpembelajaran,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchDialog()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('anamesa_id',$this->anamesa_id);
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		$criteria->compare('LOWER(no_pengkajian)',strtolower($this->no_pengkajian),true);
		if(!empty($this->pengkajianaskep_tgl)){
                        $pengkajianaskep_tgl = $this->getKonverviDateRange($this->pengkajianaskep_tgl);
                        $criteria->addBetweenCondition('DATE(pengkajianaskep_tgl)', $pengkajianaskep_tgl[0]." 00:00:00", $pengkajianaskep_tgl[1]." 23:59:59");
//			$criteria->addCondition("DATE(pengkajianaskep_tgl) = '" . MyFormatter::formatDateTimeForDb($this->pengkajianaskep_tgl) . "'");
		}
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nama_pegawai',$this->nama_pegawai,true);
		$criteria->compare('tglanamnesis',$this->tglanamnesis,true);
		$criteria->compare('keluhanutama',$this->keluhanutama,true);
		$criteria->compare('keluhantambahan',$this->keluhantambahan,true);
		$criteria->compare('riwayatpenyakitterdahulu',$this->riwayatpenyakitterdahulu,true);
		$criteria->compare('riwayatpenyakitkeluarga',$this->riwayatpenyakitkeluarga,true);
		$criteria->compare('riwayatimunisasi',$this->riwayatimunisasi,true);
		$criteria->compare('riwayatalergiobat',$this->riwayatalergiobat,true);
		$criteria->compare('riwayatmakanan',$this->riwayatmakanan,true);
		$criteria->compare('tglperiksafisik',$this->tglperiksafisik,true);
		$criteria->compare('keadaanumum',$this->keadaanumum,true);
		$criteria->compare('beratbadan_kg',$this->beratbadan_kg);
		$criteria->compare('tinggibadan_cm',$this->tinggibadan_cm);
		$criteria->compare('tekanandarah',$this->tekanandarah,true);
		$criteria->compare('detaknadi',$this->detaknadi);
		$criteria->compare('suhutubuh',$this->suhutubuh,true);
		$criteria->compare('pernapasan',$this->pernapasan,true);
		$criteria->compare('gcs_motorik',$this->gcs_motorik);
		$criteria->compare('kelainanpadabagtubuh',$this->kelainanpadabagtubuh,true);
		$criteria->compare('pengkajianaskep_id',$this->pengkajianaskep_id);
		$criteria->compare('ruangan_nama',$this->ruangan_nama,true);
		$criteria->compare('kelaspelayanan_nama',$this->kelaspelayanan_nama,true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('no_pendaftaran',$this->no_pendaftaran,true);
		$criteria->compare('tgl_pendaftaran',$this->tgl_pendaftaran,true);
		$criteria->compare('no_rekam_medik',$this->no_rekam_medik,true);
		$criteria->compare('umur',$this->umur,true);
		$criteria->compare('statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('pekerjaan_nama',$this->pekerjaan_nama,true);
		$criteria->compare('pendidikan_nama',$this->pendidikan_nama,true);
		$criteria->compare('agama',$this->agama,true);
		$criteria->compare('alamat_pasien',$this->alamat_pasien,true);
		$criteria->compare('kamarruangan_nokamar',$this->kamarruangan_nokamar,true);
		$criteria->compare('kamarruangan_nobed',$this->kamarruangan_nobed,true);
		$criteria->compare('diagnosa_nama',$this->diagnosa_nama,true);
		$criteria->compare('nama_pj',$this->nama_pj,true);
		$criteria->compare('no_identitas',$this->no_identitas,true);
		$criteria->compare('tgllahir_pj',$this->tgllahir_pj,true);
		$criteria->compare('no_teleponpj',$this->no_teleponpj,true);
		$criteria->compare('no_mobilepj',$this->no_mobilepj,true);
		$criteria->compare('hubungankeluarga',$this->hubungankeluarga,true);
		$criteria->compare('alamat_pj',$this->alamat_pj,true);
		$criteria->compare('jk',$this->jk,true);
		$criteria->compare('riwayatperjalananpasien',$this->riwayatperjalananpasien,true);
		$criteria->compare('pernahdirawat',$this->pernahdirawat);
		$criteria->compare('dirawatdimana',$this->dirawatdimana,true);
		$criteria->compare('lamasakit',$this->lamasakit,true);
		$criteria->compare('riwpenyakitkeldari',$this->riwpenyakitkeldari,true);
		$criteria->compare('penyakitmayor',$this->penyakitmayor,true);
		$criteria->compare('reaksialergiobat',$this->reaksialergiobat,true);
		$criteria->compare('reaksialergimakanan',$this->reaksialergimakanan,true);
		$criteria->compare('riwayatalergilainnya',$this->riwayatalergilainnya,true);
		$criteria->compare('reaksialergilainnya',$this->reaksialergilainnya,true);
		$criteria->compare('pengobatanygsudahdilakukan',$this->pengobatanygsudahdilakukan,true);
		$criteria->compare('riwayatkelahiran',$this->riwayatkelahiran,true);
		$criteria->compare('gelangtandaalergi',$this->gelangtandaalergi,true);
		$criteria->compare('statusmerokok',$this->statusmerokok);
		$criteria->compare('jmlrokok_btg_hr',$this->jmlrokok_btg_hr);
		$criteria->compare('statuspsikologis',$this->statuspsikologis,true);
		$criteria->compare('statusmental',$this->statusmental,true);
		$criteria->compare('masalahsebelumnya',$this->masalahsebelumnya,true);
		$criteria->compare('prilakukekerasansebelumnya',$this->prilakukekerasansebelumnya,true);
		$criteria->compare('penurunanbb_3bln',$this->penurunanbb_3bln);
		$criteria->compare('asupanberkurang',$this->asupanberkurang);
		$criteria->compare('aktifitas_mobilisasi',$this->aktifitas_mobilisasi,true);
		$criteria->compare('sebutkan_bantuan',$this->sebutkan_bantuan,true);
		$criteria->compare('resikocedera',$this->resikocedera);
		$criteria->compare('isgelangresiko',$this->isgelangresiko);
		$criteria->compare('tandasegitigaterpasang',$this->tandasegitigaterpasang,true);
		$criteria->compare('skriningnyeri',$this->skriningnyeri,true);
		$criteria->compare('skalanyeri',$this->skalanyeri,true);
		$criteria->compare('karakteristiknyeri',$this->karakteristiknyeri,true);
		$criteria->compare('lokasinyeri',$this->lokasinyeri,true);
		$criteria->compare('nyeriterasa',$this->nyeriterasa,true);
		$criteria->compare('nyerihilangbila',$this->nyerihilangbila,true);
		$criteria->compare('hubkeluarga',$this->hubkeluarga);
		$criteria->compare('tempattinggal',$this->tempattinggal,true);
		$criteria->compare('keterangananamesa',$this->keterangananamesa,true);
		$criteria->compare('meanarteripressure',$this->meanarteripressure);
		$criteria->compare('denyutjantung',$this->denyutjantung,true);
		$criteria->compare('inspeksi',$this->inspeksi,true);
		$criteria->compare('palpasi',$this->palpasi,true);
		$criteria->compare('perkusi',$this->perkusi,true);
		$criteria->compare('auskultasi',$this->auskultasi,true);
		$criteria->compare('jn_paten',$this->jn_paten);
		$criteria->compare('jn_obstruktifpartial',$this->jn_obstruktifpartial);
		$criteria->compare('jn_obstruktifnormal',$this->jn_obstruktifnormal);
		$criteria->compare('jn_stridor',$this->jn_stridor);
		$criteria->compare('jn_gargling',$this->jn_gargling);
		$criteria->compare('pgd_simetri',$this->pgd_simetri);
		$criteria->compare('pgd_asimetri',$this->pgd_asimetri);
		$criteria->compare('pgp_normal',$this->pgp_normal);
		$criteria->compare('pgp_kussmaul',$this->pgp_kussmaul);
		$criteria->compare('pgp_takipnea',$this->pgp_takipnea);
		$criteria->compare('pgp_retraktif',$this->pgp_retraktif);
		$criteria->compare('pgp_dangkal',$this->pgp_dangkal);
		$criteria->compare('sirkulasi_nadicarotis',$this->sirkulasi_nadicarotis);
		$criteria->compare('sirkulasi_nadiradialis',$this->sirkulasi_nadiradialis);
		$criteria->compare('cfr_kecil_2',$this->cfr_kecil_2);
		$criteria->compare('cfr_besar_2',$this->cfr_besar_2);
		$criteria->compare('kulit_normal',$this->kulit_normal);
		$criteria->compare('kulit_jaundice',$this->kulit_jaundice);
		$criteria->compare('kulit_cyanosis',$this->kulit_cyanosis);
		$criteria->compare('kulit_pucat',$this->kulit_pucat);
		$criteria->compare('kulit_berkeringat',$this->kulit_berkeringat);
		$criteria->compare('akral',$this->akral,true);
		$criteria->compare('gcs_eye',$this->gcs_eye);
		$criteria->compare('gcs_verbal',$this->gcs_verbal);
		$criteria->compare('adakelgastrointestinal',$this->adakelgastrointestinal);
		$criteria->compare('gastrointestinal_sebutkan',$this->gastrointestinal_sebutkan,true);
		$criteria->compare('pembatasanmakanan',$this->pembatasanmakanan);
		$criteria->compare('batasmakanan_sebutkan',$this->batasmakanan_sebutkan,true);
		$criteria->compare('gigipalsu',$this->gigipalsu);
		$criteria->compare('gigipalsu_bagian',$this->gigipalsu_bagian,true);
		$criteria->compare('mual',$this->mual);
		$criteria->compare('muntah',$this->muntah);
		$criteria->compare('pendengaran',$this->pendengaran);
		$criteria->compare('pendengaran_sebutkan',$this->pendengaran_sebutkan,true);
		$criteria->compare('penglihatan',$this->penglihatan);
		$criteria->compare('penglihatan_sebutkan',$this->penglihatan_sebutkan,true);
		$criteria->compare('defekasi',$this->defekasi);
		$criteria->compare('defekasi_sebutkan',$this->defekasi_sebutkan,true);
		$criteria->compare('miksi',$this->miksi);
		$criteria->compare('miksi_sebutkan',$this->miksi_sebutkan,true);
		$criteria->compare('hamil',$this->hamil);
		$criteria->compare('hpht',$this->hpht,true);
		$criteria->compare('keluhanmenstruasi',$this->keluhanmenstruasi,true);
		$criteria->compare('skornorton',$this->skornorton);
		$criteria->compare('resikodekubitus',$this->resikodekubitus);
		$criteria->compare('terdapatluka',$this->terdapatluka);
		$criteria->compare('lokasiluka',$this->lokasiluka,true);
		$criteria->compare('hambatanpembelajaran',$this->hambatanpembelajaran);
		$criteria->compare('hambatanpembelajaran_ya',$this->hambatanpembelajaran_ya,true);
		$criteria->compare('butuhpenerjemah',$this->butuhpenerjemah);
		$criteria->compare('kebutuhanpembelajaran',$this->kebutuhanpembelajaran,true);
		$criteria->limit = 5;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                            'pageSize'=>5
                        ),
                        'sort'=>[
                            'defaultOrder'=>'pengkajianaskep_tgl DESC'
                        ]
		));
	}
        
        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchDialogPengkajian()
	{
		
            $criteria=new CDbCriteria;
            $criteria->join = " LEFT JOIN pegawai_m peg ON peg.pegawai_id = t.pegawai_id  "
                            . " LEFT JOIN gelarbelakang_m gelarblkg ON gelarblkg.gelarbelakang_id = peg.gelarbelakang_id ";
            $criteria->group = " t.pengkajianaskep_id ,t.no_pengkajian, t.nama_pasien, t.no_pendaftaran, t.pengkajianaskep_tgl, t.ruangan_nama, peg.gelardepan, t.nama_pegawai, gelarblkg.gelarbelakang_nama";
            $criteria->select = $criteria->group.", CONCAT(peg.gelardepan,' ',t.nama_pegawai,', ',gelarblkg.gelarbelakang_nama) as nama_pegawai";
            if(!empty($this->pengkajianaskep_tgl)){
                    $pengkajianaskep_tgl = $this->getKonverviDateRange($this->pengkajianaskep_tgl);
                    $criteria->addBetweenCondition('DATE(pengkajianaskep_tgl)', $pengkajianaskep_tgl[0]." 00:00:00", $pengkajianaskep_tgl[1]." 23:59:59");
            }
            if (!empty($this->ruangan_id)){
                $criteria->addCondition(" t.ruangan_id = '".$this->ruangan_id."' ");
            }
            $criteria->compare(" LOWER(t.nama_pegawai) ", strtolower($this->nama_pegawai),true);
            $criteria->compare(" LOWER(t.no_pengkajian) ", strtolower($this->no_pengkajian),true);
            $criteria->compare(" LOWER(t.no_pendaftaran) ", strtolower($this->no_pendaftaran),true);
            $criteria->compare(" LOWER(t.nama_pasien) ", strtolower($this->nama_pasien),true);
            

            $criteria->limit = 5;
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>array(
                        'pageSize'=>5
                    )
            ));
	}
	
        /**
         * load data no kamar
         * @param type $pendaftaran_id
         * @return type
         */
	public function getNoKamar($pendaftaran_id) {
		$no_kamar = '-';
		if (!empty($pendaftaran_id)) {
			$kamar = KamarruanganM::model()->findBySql('
			SELECT kamarruangan_m.kamarruangan_nokamar
			FROM kamarruangan_m
			JOIN masukkamar_t ON kamarruangan_m.kamarruangan_id = masukkamar_t.kamarruangan_id
			JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = masukkamar_t.pasienadmisi_id
			JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienadmisi_t.pendaftaran_id
			WHERE pendaftaran_t.pendaftaran_id = ' . $pendaftaran_id);
			if (!empty($kamar)) {
				$no_kamar = $kamar->kamarruangan_nokamar;
			}
		}
		return $no_kamar;
	}

        /**
         * load no bed
         * @param type $pendaftaran_id
         * @return type
         */
	public function getNoBed($pendaftaran_id) {
		
		$no_bed = '-';
		if (!empty($pendaftaran_id)) {
			$kamar = KamarruanganM::model()->findBySql('
			SELECT kamarruangan_m.kamarruangan_nobed
			FROM kamarruangan_m
			JOIN masukkamar_t ON kamarruangan_m.kamarruangan_id = masukkamar_t.kamarruangan_id
			JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = masukkamar_t.pasienadmisi_id
			JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienadmisi_t.pendaftaran_id
			WHERE pendaftaran_t.pendaftaran_id = ' . $pendaftaran_id);
			if (!empty($kamar)) {
				$no_bed = $kamar->kamarruangan_nobed;
			}
		}
		return $pendaftaran_id;
	}

        /**
         * load kelas pelayanan
         * @param type $pendaftaran_id
         * @return type
         */
	public function getKelasPelayanan($pendaftaran_id) {

		$pelayanan = '-';
		if (!empty($pendaftaran_id)) {
			$kelas = KelaspelayananM::model()->findBySql('
			SELECT kelaspelayanan_m.kelaspelayanan_nama
			FROM kelaspelayanan_m
			JOIN masukkamar_t ON kelaspelayanan_m.kelaspelayanan_id = masukkamar_t.kelaspelayanan_id
			JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = masukkamar_t.pasienadmisi_id
			JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienadmisi_t.pendaftaran_id
			WHERE pendaftaran_t.pendaftaran_id = ' . $pendaftaran_id);
			if (!empty($kelas)) {
				$pelayanan = $kelas->kelaspelayanan_nama;
			}
		}

		return $pelayanan;
	}

        /**
         * load diagnosa medis
         * @param type $pasien_id
         * @param type $pendaftaran_id
         * @return type
         */
	public function getDiagnosaMedis($pasien_id, $pendaftaran_id) {
		$nama = '-';

		if (!empty($pasien_id) && !empty($pendaftaran_id)) {
			$diagnosa = ASDiagnosaM::model()->findBySql('
			SELECT diagnosa_m.diagnosa_nama
			FROM diagnosa_m
			JOIN pasienmorbiditas_t ON pasienmorbiditas_t.diagnosa_id = diagnosa_m.diagnosa_id
			WHERE pasienmorbiditas_t.pasien_id = ' . $pasien_id . ' AND pendaftaran_id =' . $pendaftaran_id);
			if (!empty($diagnosa)) {
				$nama = $diagnosa->diagnosa_nama;
			}
		}
		return $nama;
	}

        /**
         * load nama dokter
         * @param type $pendaftaran_id
         * @return string
         */
	public function getNamaDokter($pendaftaran_id) {
		$nama = '-';
		$dokter = ASPegawaiM::model()->findBySql('
			SELECT pegawai_m.nama_pegawai,pegawai_m.gelardepan,gelarbelakang_m.gelarbelakang_nama
			FROM pendaftaran_t 
			JOIN pegawai_m ON pegawai_m.pegawai_id = pendaftaran_t.pegawai_id
			LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
			WHERE pendaftaran_id =' . $pendaftaran_id);
		if (!empty($dokter)) {
			$nama = (isset($dokter->gelardepan) ? $dokter->gelardepan : "") . (isset($dokter->nama_pegawai) ? $dokter->nama_pegawai : "") . (isset($dokter->gelarbelakang_nama) ? $dokter->gelarbelakang_nama : "");
		}
		return $nama;
	}
        
        /**
         * konversi date
         * @param type $tgl
         * @return type
         */
        public function getKonverviDateRange($tgl){
            $Tgl = (explode(" - ",$tgl));

            //harus di format date dulu karena hasil dri widget tidak sama seperti format DB
            $Tgl[0] = DateTime::createFromFormat('m/d/Y', $Tgl[0]);
            $Tgl[0] = $Tgl[0]->format('Y-m-d');
            $Tgl[1] = DateTime::createFromFormat('m/d/Y', $Tgl[1]);
            $Tgl[1] = $Tgl[1]->format('Y-m-d');
            return array($Tgl[0],$Tgl[1]);
        }
}