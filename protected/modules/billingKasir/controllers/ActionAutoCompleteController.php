<?php

/**
 * RND-7811 : INI SUDAH TIDAK DIGUNAKAN LAGI, FUNCTION PINDAHKAN KE CONTROLLER MASING2
 */
class ActionAutoCompleteController extends Controller
{
  public function actionDaftarPasien($nama = false)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->with = array('pasien', 'instalasi', 'ruangan');
      //                $criteria->with = array('pasien','instalasi','ruangan','obatalkespasien','tindakanpelayanan');
      if ($nama) {
        $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($_GET['term']), true);
        if (isset($_GET['instalasiId'])) {
          if (!empty($_GET['instalasiId'])) {
            $criteria->addCondition("t.instalasi_id = " . $_GET['instalasiId']);
          }
        }
      } else {
        $criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($_GET['term']), true);
        if (isset($_GET['instalasiId'])) {
          if (!empty($_GET['instalasiId'])) {
            $criteria->addCondition("t.instalasi_id = " . $_GET['instalasiId']);
          }
        }
      }
      $a = 'BELUM LUNAS';
      //                $criteria->addCondition('tindakanpelayanan.tindakansudahbayar_id IS NULL OR  obatalkespasien.oasudahbayar_id 
      //                                         IS NULL OR tindakansudahbayar_id IS NULL AND obatalkespasien.returresepdet_id IS NULL 
      //                                         AND obatalkespasien.obatalkes_id IS NOT NULL');
      $criteria->order = 'tgl_pendaftaran DESC';

      $models = PendaftaranT::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        if ($nama) {
          $returnVal[$i]['label'] = $model->pasien->nama_pasien . ' - ' . $model->ruangan->ruangan_nama . ' - ' . $model->tgl_pendaftaran . ' - ' . $model->pasien->alamat_pasien;
          $returnVal[$i]['value'] = $model->pasien->nama_pasien;
          $returnVal[$i]['norekammedik'] = $model->pasien->no_rekam_medik;
        } else {
          $returnVal[$i]['label'] = $model->pasien->no_rekam_medik . ' - ' . $model->ruangan->ruangan_nama . ' - ' . $model->tgl_pendaftaran;
          $returnVal[$i]['value'] = $model->pasien->no_rekam_medik;
        }
        $returnVal[$i]['jeniskelamin'] = $model->pasien->jeniskelamin;
        $returnVal[$i]['namapasien'] = $model->pasien->nama_pasien;
        $returnVal[$i]['nama_pasien'] = $model->pasien->nama_pasien;
        $returnVal[$i]['namabin'] = $model->pasien->nama_bin;
        $returnVal[$i]['nama_bin'] = $model->pasien->nama_bin;
        $returnVal[$i]['jeniskasuspenyakit'] = ((isset($model->jeniskasuspenyakit->jeniskasuspenyakit_nama)) ? $model->jeniskasuspenyakit->jeniskasuspenyakit_nama : null);
        $returnVal[$i]['jeniskasuspenyakit_nama'] = ((isset($model->jeniskasuspenyakit->jeniskasuspenyakit_nama)) ? $model->jeniskasuspenyakit->jeniskasuspenyakit_nama : null);
        $returnVal[$i]['namainstalasi'] = $model->instalasi->instalasi_nama;
        $returnVal[$i]['instalasi_nama'] = $model->instalasi->instalasi_nama;
        $returnVal[$i]['namaruangan'] = $model->ruangan->ruangan_nama;
        $returnVal[$i]['ruangan_nama'] = $model->ruangan->ruangan_nama;
        $returnVal[$i]['no_rekam_medik'] = $model->pasien->no_rekam_medik;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * method to handling search pasien with name for another method
   * digunakan di:
   * 1. billing kasir -> transaksi -> rincian pembyaran
   * 2. billing kasir -> transaksi -> bayar uang muka
   * 3. billing kasir -> transaksi -> pembayaran resep pasien
   * 4. billing kasir -> transaksi -> retur tagihan pasien
   * 5. billing kasir -> transaksi -> pembatalan uang muka
   */
  public function actionDaftarPasienberdasarkanNama()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (isset($_GET['daftarpasienruangan']))
        $this->actionDaftarPasienRuangan(true);
      else if (isset($_GET['retur']))
        $this->actionDaftarPasienRetur(true);
      else if (isset($_GET['daftarpasien']))
        $this->actionDaftarPasien(true);
      else if (isset($_GET['bataluangmuka']))
        $this->actionDaftarPasienBatalUangMuka(true);
    }
    Yii::app()->end();
  }

  public function actionDaftarPasienRuangan($nama = false)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->with = array('pasien', 'instalasi', 'ruangan', 'pembayaranpelayanan', 'obatalkespasien', 'tindakanpelayanan');
      if ($nama) {
        $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($_GET['term']), true);
        if (isset($_GET['instalasiId'])) {
          if (!empty($_GET['instalasiId'])) {
            $criteria->addCondition("t.instalasi_id = " . $_GET['instalasiId']);
          }
        }
      } else {
        $criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($_GET['term']), true);
        if (isset($_GET['instalasiId'])) {
          if (!empty($_GET['instalasiId'])) {
            $criteria->addCondition("t.instalasi_id = " . $_GET['instalasiId']);
          }
        }
      }
      $criteria->addCondition('tindakanpelayanan.tindakansudahbayar_id IS NULL OR  obatalkespasien.oasudahbayar_id 
                                         IS NULL OR tindakansudahbayar_id IS NULL AND obatalkespasien.returresepdet_id IS NULL 
                                         AND obatalkespasien.obatalkes_id IS NOT NULL');
      $criteria->addCondition('t.ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
      $criteria->order = 'tgl_pendaftaran DESC';

      $models = PendaftaranT::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        if ($nama) {
          $returnVal[$i]['label'] = $model->pasien->nama_pasien . ' - ' . $model->ruangan->ruangan_nama . ' - ' . $model->tgl_pendaftaran;
          $returnVal[$i]['value'] = $model->pasien->nama_pasien;
          $returnVal[$i]['norekammedik'] = $model->pasien->no_rekam_medik;
        } else {
          $returnVal[$i]['label'] = $model->pasien->no_rekam_medik . ' - ' . $model->ruangan->ruangan_nama . ' - ' . $model->tgl_pendaftaran;
          $returnVal[$i]['value'] = $model->pasien->no_rekam_medik;
        }
        $returnVal[$i]['jeniskelamin'] = $model->pasien->jeniskelamin;
        $returnVal[$i]['namapasien'] = $model->pasien->nama_pasien;
        $returnVal[$i]['namabin'] = $model->pasien->nama_bin;
        $returnVal[$i]['jeniskasuspenyakit'] = $model->jeniskasuspenyakit->jeniskasuspenyakit_nama;
        $returnVal[$i]['namainstalasi'] = $model->instalasi->instalasi_nama;
        $returnVal[$i]['namaruangan'] = $model->ruangan->ruangan_nama;
        $returnVal[$i]['carabayar_nama'] = $model->carabayar->carabayar_nama;
        $returnVal[$i]['penjamin_nama'] = $model->penjamin->penjamin_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionDaftarPasienRetur($nama = false)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->with = array('pasien', 'pendaftaran', 'ruangan');
      if ($nama) {
        $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($_GET['term']), true);
      } else {
        $criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($_GET['term']), true);
      }
      $criteria->order = 'pendaftaran.tgl_pendaftaran DESC';
      $models = PembayaranpelayananT::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        if ($nama) {
          $returnVal[$i]['label'] = $model->pasien->nama_pasien . ' - ' . $model->ruangan->ruangan_nama . ' - ' . $model->tglpembayaran;
          $returnVal[$i]['value'] = $model->pasien->nama_pasien;
          $returnVal[$i]['norekammedik'] = $model->pasien->no_rekam_medik;
        } else {
          $returnVal[$i]['label'] = $model->pasien->no_rekam_medik . ' - ' . $model->ruangan->ruangan_nama . ' - ' . $model->tglpembayaran;
          $returnVal[$i]['value'] = $model->pasien->no_rekam_medik;
        }
        $returnVal[$i]['jeniskelamin'] = $model->pasien->jeniskelamin;
        $returnVal[$i]['namapasien'] = $model->pasien->nama_pasien;
        $returnVal[$i]['namabin'] = $model->pasien->nama_bin;
        $returnVal[$i]['alamatpasien'] = $model->pasien->alamat_pasien;
        $returnVal[$i]['jeniskasuspenyakit'] = $model->pendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama;
        $returnVal[$i]['namainstalasi'] = $model->pendaftaran->instalasi->instalasi_nama;
        $returnVal[$i]['namaruangan'] = $model->ruangan->ruangan_nama;
        $returnVal[$i]['tglpendaftaran'] = $model->pendaftaran->tgl_pendaftaran;
        $returnVal[$i]['nopendaftaran'] = $model->pendaftaran->no_pendaftaran;
        $returnVal[$i]['umur'] = $model->pendaftaran->umur;
        $returnVal[$i]['carabayar_nama'] = $model->carabayar->carabayar_nama;
        $returnVal[$i]['penjamin_nama'] = $model->penjamin->penjamin_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionDaftarPasienBatalUangMuka($nama = false)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->with = array('pasien', 'pendaftaran', 'ruangan');
      if ($nama) {
        $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($_GET['term']), true);
      } else {
        $criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($_GET['term']), true);
      }
      $criteria->addCondition('pembatalanuangmuka_id IS NULL');
      $criteria->order = 'tgluangmuka DESC';
      $models = BayaruangmukaT::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        if ($nama) {
          $returnVal[$i]['label'] = $model->pasien->nama_pasien . ' - ' . $model->ruangan->ruangan_nama . ' - ' . $model->tgluangmuka;
          $returnVal[$i]['value'] = $model->pasien->nama_pasien;
          $returnVal[$i]['norekammedik'] = $model->pasien->no_rekam_medik;
        } else {
          $returnVal[$i]['label'] = $model->pasien->no_rekam_medik . ' - ' . $model->ruangan->ruangan_nama . ' - ' . $model->tgluangmuka;
          $returnVal[$i]['value'] = $model->pasien->no_rekam_medik;
        }
        $returnVal[$i]['jeniskelamin'] = $model->pasien->jeniskelamin;
        $returnVal[$i]['namapasien'] = $model->pasien->nama_pasien;
        $returnVal[$i]['namabin'] = $model->pasien->nama_bin;
        $returnVal[$i]['alamatpasien'] = $model->pasien->alamat_pasien;
        $returnVal[$i]['jeniskasuspenyakit'] = $model->pendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama;
        $returnVal[$i]['namainstalasi'] = $model->pendaftaran->instalasi->instalasi_nama;
        $returnVal[$i]['namaruangan'] = $model->ruangan->ruangan_nama;
        $returnVal[$i]['tglpendaftaran'] = $model->pendaftaran->tgl_pendaftaran;
        $returnVal[$i]['nopendaftaran'] = $model->pendaftaran->no_pendaftaran;
        $returnVal[$i]['umur'] = $model->pendaftaran->umur;
        $returnVal[$i]['tandabuktibayar_id'] = $model->tandabuktibayar_id;
        $returnVal[$i]['bayaruangmuka_id'] = $model->bayaruangmuka_id;
        $returnVal[$i]['carabayar_nama'] = $model->pendaftaran->carabayar->carabayar_nama;
        $returnVal[$i]['penjamin_nama'] = $model->pendaftaran->penjamin->penjamin_nama;
        $returnVal[$i]['norekammedik'] = $model->pasien->no_rekam_medik;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionJenisPenerimaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      //                $criteria->compare('LOWER(jenispenerimaan_nama)', strtolower($_GET['term']), true);
      $criteria->addCondition('LOWER(jenispenerimaan_kode) || \' - \' || LOWER(jenispenerimaan_nama) LIKE \'%' . strtolower($_GET['term']) . '%\'');
      $models = JenispenerimaanM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->jenispenerimaan_kode . ' - ' . $model->jenispenerimaan_nama;
        $returnVal[$i]['value'] = $model->jenispenerimaan_kode . ' - ' . $model->jenispenerimaan_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionJenisPengeluaran()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(jenispengeluaran_nama)', strtolower($_GET['term']), true);
      //                $criteria->addCondition('LOWER(jenispenerimaan_kode) || \' - \' || LOWER(jenispenerimaan_nama) LIKE \'%'.strtolower($_GET['term']).'%\'');
      $models = JenispengeluaranM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->jenispengeluaran_nama;
        $returnVal[$i]['value'] = $model->jenispengeluaran_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionInfoBuktiBayar()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->with = array('buktibayar');
      $criteria->compare('LOWER(buktibayar.nobuktibayar)', strtolower($_GET['term']), true);
      $criteria->order = 'buktibayar.tglbuktibayar DESC';
      $criteria->addCondition('buktibayar.returpenerimaanumum_id IS NULL');
      $models = PenerimaanumumT::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->buktibayar->nobuktibayar . ' - ' . $model->buktibayar->darinama_bkm;
        $returnVal[$i]['value'] = $model->buktibayar->nobuktibayar;
        $returnVal[$i]["tglbuktibayar"] = $model->buktibayar->tglbuktibayar;
        $returnVal[$i]["darinama_bkm"] = $model->buktibayar->darinama_bkm;
        $returnVal[$i]["alamat_bkm"] = $model->buktibayar->alamat_bkm;
        $returnVal[$i]["biayamaterai"] = $model->buktibayar->biayamaterai;
        $returnVal[$i]["carapembayaran"] = $model->buktibayar->carapembayaran;
        $returnVal[$i]["jmlpembayaran"] = $model->buktibayar->jmlpembayaran;
        $returnVal[$i]["biayaadministrasi"] = $model->buktibayar->biayaadministrasi;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionInfoBayarSupplier()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->with = array('bayarsupplier');
      $criteria->compare('LOWER(nokaskeluar)', strtolower($_GET['term']), true);
      $criteria->addCondition('t.bayarkesupplier_id IS NOT NULL');
      $models = TandabuktikeluarT::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nokaskeluar . ' - ' . $model->namapenerima;
        $returnVal[$i]['value'] = $model->nokaskeluar;
        $returnVal[$i]['tglbayarkesupplier'] = $model->bayarsupplier->tglbayarkesupplier;
        $returnVal[$i]['totaltagihan'] = $model->bayarsupplier->totaltagihan;
        $returnVal[$i]['jmldibayarkan'] = $model->bayarsupplier->jmldibayarkan;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionDaftarSupplier()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      //$criteria->with = array();
      $criteria->compare('LOWER(supplier_nama)', strtolower($_GET['term']), true);
      $criteria->order = 'supplier_nama DESC';
      $models = SupplierM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->supplier_kode . ' - ' . $model->supplier_nama;
        $returnVal[$i]['value'] = $model->supplier_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * get no resep penjualan from pasien id
   */
  public function actionGetNoResepObatPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = (isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : 0);
      $criteria = new CDbCriteria();
      //                $criteria->with = array('bayarsupplier');
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
      }
      $criteria->compare('LOWER(noresep)', strtolower($_GET['term']), true);
      //                $criteria->addCondition('t.bayarkesupplier_id IS NOT NULL');
      $models = PenjualanresepT::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $jumlahObat = ObatalkespasienT::model()->countByAttributes(array('penjualanresep_id' => $model->penjualanresep_id, 'oasudahbayar_id' => null));
        if ($jumlahObat > 0) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->noresep . ' - ' . $model->tglresep;
          $returnVal[$i]['value'] = $model->noresep;
        }
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  function actionDaftarPasienInstalasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $models = null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
      //$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
      if (isset($_GET['instalasiId'])) {
        if (!empty($_GET['instalasiId'])) {
          $criteria->addCondition("instalasi_id = " . $_GET['instalasiId']);
        }
      }
      $criteria->limit = 5;
      $criteria->order = 'tgl_pendaftaran DESC';
      //kembalikan format
      if ($_GET['instalasiId'] == Params::INSTALASI_ID_RD) {
        $models = BKInfokunjunganrdV::model()->findAll($criteria);
      } else if ($_GET['instalasiId'] == Params::INSTALASI_ID_RJ) {
        $models = BKInfokunjunganrjV::model()->findAll($criteria);
      }
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->no_pendaftaran . ' - ' . $model->tgl_pendaftaran; //.' - '.$model->statusperiksa
        $returnVal[$i]['value'] = $model->no_rekam_medik;
        $returnVal[$i]['jeniskelamin'] = $model->jeniskelamin;
        $returnVal[$i]['namapasien'] = $model->nama_pasien;
        $returnVal[$i]['namabin'] = $model->nama_bin;
        $returnVal[$i]['jeniskasuspenyakit'] = $model->jeniskasuspenyakit_nama;
        $returnVal[$i]['namainstalasi'] = $model->instalasi_nama;
        $returnVal[$i]['namaruangan'] = $model->ruangan_nama;
        $returnVal[$i]['carabayar_nama'] = $model->carabayar_nama;
        $returnVal[$i]['penjamin_nama'] = $model->penjamin_nama;
        //cari tanggungan penjamin
        $criteria = new CDbCriteria();
        if (!empty($model->penjamin_id)) {
          $criteria->addCondition("penjamin_id = " . $model->penjamin_id);
        }
        if (!empty($model->kelaspelayanan_id)) {
          $criteria->addCondition("kelaspelayanan_id = " . $model->kelaspelayanan_id);
        }
        if (!empty($model->carabayar_id)) {
          $criteria->addCondition("carabayar_id = " . $model->carabayar_id);
        }
        $tanggungan = TanggunganpenjaminM::model()->find($criteria);
        $returnVal[$i]['subsidirumahsakitoa'] = $tanggungan->subsidirumahsakitoa;
        $returnVal[$i]['subsidipemerintahoa'] = $tanggungan->subsidipemerintahoa;
        $returnVal[$i]['subsidiasuransioa'] = $tanggungan->subsidiasuransioa;
        $returnVal[$i]['iurbiayaoa'] = $tanggungan->iurbiayaoa;
        $returnVal[$i]['makstanggpel'] = $tanggungan->makstanggpel;
        //cari dokter ruangan
        $pasienAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
        if (!empty($pasienAdmisi->pasienadmisi_id)) {
          $returnVal[$i]['pegawai_id'] = $pasienAdmisi->pegawai_id;
          $returnVal[$i]['pegawai_nama'] = PegawaiM::model()->findByPk($pasienAdmisi->pegawai_id)->NamaLengkap;
        } else {
          $returnVal[$i]['pegawai_id'] = $model->pegawai_id;
          $returnVal[$i]['pegawai_nama'] = PegawaiM::model()->findByPk($model->pegawai_id)->NamaLengkap;
        }
      }

      echo CJSON::encode($returnVal);
    }
  }
}
