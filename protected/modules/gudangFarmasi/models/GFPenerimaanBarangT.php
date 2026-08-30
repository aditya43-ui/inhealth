<?php

/**
 * Model Peneriman OA Farmasi
 * 
 * @author   Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package  application.modules.gudangFarmasi
 * @package  controllers
 * @category controller
 */
class GFPenerimaanBarangT extends PenerimaanbarangT {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PenerimaanbarangT the static model class
     */
    public $tgl_awal, $tgl_akhir;
    public $tick;
    public $data;
    public $jumlah;
    public $supplier_nama,$supplier_nama_langsung,$supplier_id_langsung;
    public $nama_obat;
    public $obatalkes_kode;
    public $satuanbesar_nama;
    public $harganettoper;
    public $jumlahterima;
    public $persendiscount;
    public $nofaktur;
    public $tglfaktur;
    public $totalbruto;
    public $persenppn;
    public $hargadiskon;
    public $hpp;
    public $hargappn;
    public $hargabruto;
    public $sumberdana_nama, $jenisobatalkes_id, $sumberdana_id;
    public $jmlterima;
    public $disc;
    public $ppn;
    public $total_harga;
    public $jns_periode, $bln_awal, $bln_akhir, $thn_awal, $thn_akhir;
    public $jnskelompok;
    public $obatalkes_kategori;
    public $obatalkes_golongan;
    public $pegawaimengetahui_nama;
    public $pegawaimenyetujui_nama;
    public $is_uangmuka = 0;
    public $is_langsungfaktur = 0;
    public $tglkadaluarsa;
    public $tglpermintaanpembelian;
    public $nopermintaan, $tgluangbelimuka, $jumlahuang;

    //public $persenppn;
    //public $persendiscount;

    /**
     * Class Model
     * 
     * @param  string $className
     * @return mixed
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Pencarian faktur pembelian
     * 
     * @return \CActiveDataProvider
     */
    public function searchFakturPembelian() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('LOWER(noterima)', strtolower($this->noterima), true);
        $criteria->compare('date(tglterima)', $this->tglterima);
        $criteria->addCondition('fakturpembelian_id is null');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Pencarian untuk Informasi Penerimaan Barang
     * 
     * @return \CActiveDataProvider
     */
    public function searchInformasi() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = 'supplier';
        $criteria->compare('LOWER(noterima)', strtolower($this->noterima), true);
        $criteria->addBetweenCondition('date(tglterima)', $this->tgl_awal, $this->tgl_akhir);
        if (!empty($this->supplier_id)) {
            $criteria->addCondition('supplier_id = ' . $this->supplier_id);
        }
        $criteria->addCondition("supplier.supplier_jenis='Farmasi'");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Pencarian untuk laporan penerimaan OA
     * 
     * @return \CActiveDataProvider
     */
    public function searchLaporan() {
        $criteria = new CDbCriteria;

        $criteria->join = 'JOIN supplier_m s ON s.supplier_id=t.supplier_id JOIN penerimaandetail_t pd ON pd.penerimaanbarang_id=t.penerimaanbarang_id LEFT JOIN obatalkes_m o ON pd.obatalkes_id=o.obatalkes_id';
        $criteria->select = 't.noterima, t.tglterima, t.totalharga as totalharga, pd.harganettoper as harganetto, pd.jmlterima as jumlahterima, o.obatalkes_nama as nama_obat, s.supplier_nama as supplier_nama';
//                $criteria->group = 't.noterima, t.tglterima, t.totalharga, t.harganetto, o.obatalkes_nama, s.supplier_nama, pd.harganettoper, pd.jmlterima';
        if (!empty($this->supplier_id)) {
            $criteria->addCondition('t.supplier_id = ' . $this->supplier_id);
        }
        $criteria->compare('LOWER(t.noterima)', strtolower($this->noterima), true);
        $criteria->addBetweenCondition('date(tglterima)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->addCondition("s.supplier_jenis='Farmasi'");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Printout pencarian laporan
     * 
     * @return \CActiveDataProvider
     */
    public function searchLaporanPrint() {

        $criteria = new CDbCriteria;

        $criteria->join = 'JOIN supplier_m s ON s.supplier_id=t.supplier_id JOIN penerimaandetail_t pd ON pd.penerimaanbarang_id=t.penerimaanbarang_id LEFT JOIN obatalkes_m o ON pd.obatalkes_id=o.obatalkes_id';
        $criteria->select = 't.noterima, t.tglterima, t.totalharga as totalharga, pd.harganettoper as harganetto, pd.jmlterima as jumlahterima, o.obatalkes_nama as nama_obat, s.supplier_nama as supplier_nama';
//                $criteria->group = 't.noterima, t.tglterima, t.totalharga, t.harganetto, o.obatalkes_nama, s.supplier_nama, pd.harganettoper, pd.jmlterima';
        if (!empty($this->supplier_id)) {
            $criteria->addCondition('t.supplier_id = ' . $this->supplier_id);
        }
        $criteria->compare('LOWER(t.noterima)', strtolower($this->noterima), true);
        $criteria->addBetweenCondition('date(tglterima)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->addCondition("s.supplier_jenis='Farmasi'");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria, 'pagination' => false,
        ));
    }

    /**
     * searchLaporanPenerimaanObatAlkes digunakan pada:
     * 1. Laporan Penerimaan Obat Alkes
     * @return \CActiveDataProvider
     */
    public function searchLaporanPenerimaanObatAlkes() {
        $format = new MyFormatter;
        $criteria = new CDbCriteria;
        $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
        $criteria->join = 'JOIN supplier_m s ON s.supplier_id=t.supplier_id 
				JOIN penerimaandetail_t pd ON pd.penerimaanbarang_id=t.penerimaanbarang_id 
				LEFT JOIN fakturpembelian_t fp ON fp.fakturpembelian_id=t.fakturpembelian_id 
				LEFT JOIN fakturdetail_t fd ON fd.fakturpembelian_id=fp.fakturpembelian_id and fd.penerimaandetail_id = pd.penerimaandetail_id 
				LEFT JOIN satuanbesar_m sb ON sb.satuanbesar_id=fd.satuanbesar_id 
				LEFT JOIN obatalkes_m o ON fd.obatalkes_id=o.obatalkes_id';
        $criteria->group = 'fp.tglfaktur::date, o.obatalkes_kode,o.obatalkes_nama,
				sb.satuanbesar_nama';
        $criteria->select = $criteria->group . ', 
                sum(pd.jmlterima) as jumlahterima, 
                o.obatalkes_nama as nama_obat, 
				sum(fd.harganettofaktur) as harganettoper, 
                sum((fd.harganettofaktur*(fd.persenppnfaktur/100))*fd.jmlterima) as hargappn, 
                sum((fd.harganettofaktur*(fd.persendiscount/100))*fd.jmlterima) as hargadiskon, 
                sum(round((fd.harganettofaktur - fd.jmldiscount) * fd.jmlterima * ((100 + fd.persenppnfaktur)/100))) as totalharga, 
                sum((fd.harganettofaktur - fd.jmldiscount) * ((100 + fd.persenppnfaktur)/100)) as hpp,
                sum(fd.persendiscount) as persendiscount';
        $criteria->compare('LOWER(t.noterima)', strtolower($this->noterima), true);
        //$criteria->compare('o.jenisobatalkes_id',$this->jenisobatalkes_id);
        if (!empty($this->jenisobatalkes_id)) {
            if (is_array($this->jenisobatalkes_id)) {
                $criteria->addInCondition(" o.jenisobatalkes_id ", $this->jenisobatalkes_id);
            } else {
                $criteria->addCondition(" o.jenisobatalkes_id = " . $this->jenisobatalkes_id);
            }
        }
        //$criteria->compare('lower(o.jnskelompok)',strtolower($this->jnskelompok));
        if (!empty($this->jnskelompok)) {
            if (is_array($this->jnskelompok)) {
                $criteria->addInCondition(" o.jnskelompok ", $this->jnskelompok);
            } else {
                $criteria->addCondition(" o.jnskelompok = " . $this->jnskelompok);
            }
        }
        //$criteria->compare('LOWER(o.obatalkes_golongan)',strtolower($this->obatalkes_golongan));
        if (!empty($this->obatalkes_golongan)) {
            if (is_array($this->obatalkes_golongan)) {
                $criteria->addInCondition(" o.obatalkes_golongan ", $this->obatalkes_golongan);
            } else {
                $criteria->addCondition(" o.obatalkes_golongan = " . $this->obatalkes_golongan);
            }
        }

        //$criteria->compare('LOWER(o.obatalkes_kategori)',strtolower($this->obatalkes_kategori));
        if (!empty($this->obatalkes_kategori)) {
            if (is_array($this->obatalkes_kategori)) {
                $criteria->addInCondition(" o.obatalkes_kategori ", $this->obatalkes_kategori);
            } else {
                $criteria->addCondition(" o.obatalkes_kategori = " . $this->obatalkes_kategori);
            }
        }

        $criteria->addBetweenCondition('date(fp.tglfaktur)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->order = 'fp.tglfaktur::date, o.obatalkes_nama ASC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria, // 'pagination'=>false,
        ));
    }

    /**
     * searchLaporanPenerimaanObatAlkes digunakan pada:
     * 1. Laporan Penerimaan Obat Alkes
     * @return \CActiveDataProvider
     */
    public function frameGrafikPenerimaanBarangOa() {
        $format = new MyFormatter;
        $criteria = new CDbCriteria;
        $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
        $criteria->join = 'JOIN supplier_m s ON s.supplier_id=t.supplier_id 
				JOIN penerimaandetail_t pd ON pd.penerimaanbarang_id=t.penerimaanbarang_id 
				LEFT JOIN satuanbesar_m sb ON sb.satuanbesar_id=pd.satuanbesar_id 
				LEFT JOIN fakturpembelian_t fp ON fp.fakturpembelian_id=t.fakturpembelian_id 
				LEFT JOIN obatalkes_m o ON pd.obatalkes_id=o.obatalkes_id';

        $criteria->select = '( (sum(pd.harganettoper * pd.jmlterima)) - (sum((pd.harganettoper*(pd.persendiscount/100))*pd.jmlterima)) + (sum((pd.harganettoper*(pd.persenppn/100))*pd.jmlterima))  )as jumlah, o.obatalkes_nama as data';
        $criteria->group = 'data';
        $criteria->compare('LOWER(t.noterima)', strtolower($this->noterima), true);
        //$criteria->compare('o.jenisobatalkes_id',$this->jenisobatalkes_id);
        if (!empty($this->jenisobatalkes_id)) {
            if (is_array($this->jenisobatalkes_id)) {
                $criteria->addInCondition(" o.jenisobatalkes_id ", $this->jenisobatalkes_id);
            } else {
                $criteria->addCondition(" o.jenisobatalkes_id = " . $this->jenisobatalkes_id);
            }
        }
        //$criteria->compare('lower(o.jnskelompok)',strtolower($this->jnskelompok));
        if (!empty($this->jnskelompok)) {
            if (is_array($this->jnskelompok)) {
                $criteria->addInCondition(" o.jnskelompok ", $this->jnskelompok);
            } else {
                $criteria->addCondition(" o.jnskelompok = " . $this->jnskelompok);
            }
        }
        //$criteria->compare('LOWER(o.obatalkes_golongan)',strtolower($this->obatalkes_golongan));
        if (!empty($this->obatalkes_golongan)) {
            if (is_array($this->obatalkes_golongan)) {
                $criteria->addInCondition(" o.obatalkes_golongan ", $this->obatalkes_golongan);
            } else {
                $criteria->addCondition(" o.obatalkes_golongan = " . $this->obatalkes_golongan);
            }
        }

        //$criteria->compare('LOWER(o.obatalkes_kategori)',strtolower($this->obatalkes_kategori));
        if (!empty($this->obatalkes_kategori)) {
            if (is_array($this->obatalkes_kategori)) {
                $criteria->addInCondition(" o.obatalkes_kategori ", $this->obatalkes_kategori);
            } else {
                $criteria->addCondition(" o.obatalkes_kategori = " . $this->obatalkes_kategori);
            }
        }

        $criteria->addBetweenCondition('date(tglterima)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->order = 'jumlah DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria, // 'pagination'=>false,
        ));
    }

    /**
     * Pencarian laporan Penerimaan OA Supplier
     * @return \CActiveDataProvider
     */
    public function searchLaporanPenerimaanObatAlkesSupplier() {
        $prov = $this->searchLaporanPenerimaanObatAlkes();

        $prov->criteria->group = 'fp.tglfaktur::date, t.penerimaanbarang_id, t.noterima, t.tglterima, s.supplier_nama';
        $prov->criteria->select = $prov->criteria->group . ', 
                sum(fd.harganettofaktur) as harganettoper, 
                sum((fd.harganettofaktur*(fd.persenppnfaktur/100))*fd.jmlterima) as hargappn, 
                sum((fd.harganettofaktur*(fd.persendiscount/100))*fd.jmlterima) as hargadiskon, 
                sum(round((fd.harganettofaktur - fd.jmldiscount) * fd.jmlterima * ((100 + fd.persenppnfaktur)/100))) as totalharga, 
                sum((fd.harganettofaktur - fd.jmldiscount) * ((100 + fd.persenppnfaktur)/100)) as hpp,
                sum(fd.persendiscount) as persendiscount';

        $prov->criteria->order = 'DATE(fp.tglfaktur) ASC, t.noterima ASC';

        /*
          if (!empty($this->supplier_id)){
          if (is_array($this->supplier_id)){
          $prov->criteria->addInCondition(" t.supplier_id ", $this->supplier_id);
          }else{
          $prov->criteria->addCondition(" t.supplier_id ".$this->supplier_id);
          }
          }
         * 
         */

        //$prov->criteria->group = 't.penerimaanbarang_id, t.noterima, t.tglterima,
        //	s.supplier_nama, t.harganetto, t.jmldiscount,t.totalpajakppn,t.totalharga';
        //$prov->criteria->select = $prov->criteria->group;

        return $prov;
    }

    /**
     * Pencarian grafik untuk laporan penerimaan OA Supplier
     * 
     * @return \CActiveDataProvider
     */
    public function searchGrafikOASupplier() {
        $prov = $this->searchLaporanPenerimaanObatAlkes();
        $prov->criteria->join = " JOIN supplier_m s ON s.supplier_id = t.supplier_id ";



        $prov->criteria->order = 'jumlah DESC';

        if (!empty($this->supplier_id)) {
            if (is_array($this->supplier_id)) {
                $prov->criteria->addInCondition(" t.supplier_id ", $this->supplier_id);
            } else {
                $prov->criteria->addCondition(" t.supplier_id " . $this->supplier_id);
            }
        }



        $prov->criteria->select = 'sum(t.totalharga)as jumlah, s.supplier_nama as data';
        $prov->criteria->group = 'data';
        return $prov;
    }

    /**
     * Pencarian grafik
     * 
     * @return \CActiveDataProvider
     */
    public function searchGrafik() {

        $criteria = new CDbCriteria;

        $criteria->join = "JOIN supplier_m s on s.supplier_id=t.supplier_id AND s.supplier_jenis='Farmasi'";
        $criteria->select = 's.supplier_nama as data, count(t.noterima) as jumlah, t.supplier_id';
        $criteria->group = 't.noterima, t.supplier_id, s.supplier_nama';
        $criteria->addBetweenCondition('date(tglterima)', $this->tgl_awal, $this->tgl_akhir);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * searchPenerimaanJenisItems digunakan pada:
     * 1. Laporan Penerimaan Items Berdasarkan Jenis
     * @return \CActiveDataProvider
     */
    public function searchPenerimaanItems() {
        $format = new MyFormatter;
        $criteria = new CDbCriteria;
        $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
        $criteria->join = 'JOIN supplier_m s ON s.supplier_id=t.supplier_id 
                        JOIN penerimaandetail_t pd ON pd.penerimaanbarang_id=t.penerimaanbarang_id 
                        LEFT JOIN satuanbesar_m sb ON sb.satuanbesar_id=pd.satuanbesar_id 
                        LEFT JOIN fakturpembelian_t fp ON fp.fakturpembelian_id=t.fakturpembelian_id 
                        LEFT JOIN obatalkes_m o ON pd.obatalkes_id=o.obatalkes_id
                        LEFT JOIN sumberdana_m sd ON pd.sumberdana_id=sd.sumberdana_id';
        $criteria->select = 't.noterima, t.tglterima, sum(t.totalharga) as totalharga, t.penerimaanbarang_id,
                        fp.nofaktur as nofaktur, fp.tglfaktur as tglfaktur,o.sumberdana_id,
                        sum(pd.harganettoper) as harganettoper, sum(pd.jmlterima) as jumlahterima, 
                        sum((pd.harganettoper *pd.jmlterima)*(o.ppn_persen/100)) as persenppn, sum((pd.harganettoper * pd.jmlterima)*(o.discount/100)) as persendiscount, sd.sumberdana_nama,pd.sumberdana_id,o.jenisobatalkes_id,
                        o.obatalkes_kode as obatalkes_kode,o.obatalkes_nama as nama_obat, 
                        sb.satuanbesar_nama as satuanbesar_nama, 
                        s.supplier_nama as supplier_nama,
                        sum(((pd.harganettoper  * pd.jmlterima) - ((pd.harganettoper * pd.jmlterima) * (o.discount / 100))) + ((pd.harganettoper * pd.jmlterima)*(o.ppn_persen / 100))) as total_harga,
                        sum(pd.harganettoper * pd.jmlterima) as hargabruto
                        ';
        $criteria->group = 'pd.sumberdana_id, o.jenisobatalkes_id, t.noterima,t.tglterima,fp.nofaktur,fp.tglfaktur,sb.satuanbesar_nama, o.obatalkes_kode,o.obatalkes_nama,
                                        s.supplier_nama,sd.sumberdana_nama,o.sumberdana_id,t.penerimaanbarang_id
                                        ';
        $jenisobatalkes_id = (isset($_GET['GFPenerimaanBarangT']['jenisobatalkes_id']) ? $_GET['GFPenerimaanBarangT']['jenisobatalkes_id'] : null);
        $sumberdana_id = (isset($_GET['GFPenerimaanBarangT']['sumberdana_id']) ? $_GET['GFPenerimaanBarangT']['sumberdana_id'] : null);
        if (!empty($this->supplier_id)) {
            $criteria->addCondition('t.supplier_id = ' . $this->supplier_id);
        }
        $criteria->compare('LOWER(t.noterima)', strtolower($this->noterima), true);
        if (!empty($jenisobatalkes_id)) {
            $criteria->addCondition('o.jenisobatalkes_id = ' . $jenisobatalkes_id);
        }
        if (!empty($sumberdana_id)) {
            $criteria->addCondition('o.sumberdana_id = ' . $sumberdana_id);
        }
        $criteria->addBetweenCondition('DATE(tglterima)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->addCondition("s.supplier_jenis='Farmasi'");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Printout Pencarian penerimaan Barang
     * 
     * @return \CActiveDataProvider
     */
    public function searchPrintPenerimaanItems() {
        $format = new MyFormatter;
        $criteria = new CDbCriteria;
        $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
        $criteria->join = 'JOIN supplier_m s ON s.supplier_id=t.supplier_id 
                        JOIN penerimaandetail_t pd ON pd.penerimaanbarang_id=t.penerimaanbarang_id 
                        LEFT JOIN satuanbesar_m sb ON sb.satuanbesar_id=pd.satuanbesar_id 
                        LEFT JOIN fakturpembelian_t fp ON fp.fakturpembelian_id=t.fakturpembelian_id 
                        LEFT JOIN obatalkes_m o ON pd.obatalkes_id=o.obatalkes_id
                        LEFT JOIN sumberdana_m sd ON pd.sumberdana_id=sd.sumberdana_id';
        $criteria->select = 't.noterima, t.tglterima, sum(t.totalharga) as totalharga, t.penerimaanbarang_id,
                        fp.nofaktur as nofaktur, fp.tglfaktur as tglfaktur,o.sumberdana_id,
                        sum(pd.harganettoper) as harganettoper, sum(pd.jmlterima) as jumlahterima, 
                        sum((pd.harganettoper *pd.jmlterima)*(o.ppn_persen/100)) as persenppn, sum((pd.harganettoper * pd.jmlterima)*(o.discount/100)) as persendiscount, sd.sumberdana_nama,pd.sumberdana_id,o.jenisobatalkes_id,
                        o.obatalkes_kode as obatalkes_kode,o.obatalkes_nama as nama_obat, 
                        sb.satuanbesar_nama as satuanbesar_nama, 
                        s.supplier_nama as supplier_nama,
                        sum(((pd.harganettoper  * pd.jmlterima) - ((pd.harganettoper * pd.jmlterima) * (o.discount / 100))) + ((pd.harganettoper * pd.jmlterima)*(o.ppn_persen / 100))) as total_harga,
                        sum(pd.harganettoper * pd.jmlterima) as hargabruto
                        ';
        $criteria->group = 'pd.sumberdana_id, o.jenisobatalkes_id, t.noterima,t.tglterima,fp.nofaktur,fp.tglfaktur,sb.satuanbesar_nama, o.obatalkes_kode,o.obatalkes_nama,
                                        s.supplier_nama,sd.sumberdana_nama,o.sumberdana_id,t.penerimaanbarang_id
                                        ';
        $jenisobatalkes_id = (isset($_GET['GFPenerimaanBarangT']['jenisobatalkes_id']) ? $_GET['GFPenerimaanBarangT']['jenisobatalkes_id'] : null);
        $sumberdana_id = (isset($_GET['GFPenerimaanBarangT']['sumberdana_id']) ? $_GET['GFPenerimaanBarangT']['sumberdana_id'] : null);
        if (!empty($this->supplier_id)) {
            $criteria->addCondition('t.supplier_id = ' . $this->supplier_id);
        }
        $criteria->compare('LOWER(t.noterima)', strtolower($this->noterima), true);
        if (!empty($jenisobatalkes_id)) {
            $criteria->addCondition('o.jenisobatalkes_id = ' . $jenisobatalkes_id);
        }
        if (!empty($sumberdana_id)) {
            $criteria->addCondition('o.sumberdana_id = ' . $sumberdana_id);
        }
        $criteria->addBetweenCondition('DATE(tglterima)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->addCondition("s.supplier_jenis='Farmasi'");
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * Printout Pencarian penerimaan jenis Barang
     * 
     * @return \CActiveDataProvider
     */
    public function searchGrafikPenerimaanJenisItems() {

        $criteria = new CDbCriteria;

        $criteria->join = "JOIN supplier_m s on s.supplier_id=t.supplier_id AND s.supplier_jenis='Farmasi'";
        $criteria->select = 's.supplier_nama as data, count(t.noterima) as jumlah, t.supplier_id';
        $criteria->group = 't.noterima, t.supplier_id, s.supplier_nama';
        $criteria->addBetweenCondition('date(tglterima)', $this->tgl_awal, $this->tgl_akhir);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * persenppnToPersen konversi dari rupiah Ppn ke persen Ppn
     * @return int
     */
    public function getHargappnToPersen() {
        $persen = 10;
        if (!empty($this->persenppn))
            $persen = 10;
        else
            $persen = 0;
        return $persen;
    }

    /**
     * getTotal menampilkan total dari penerimaandetail_t
     * @param type $pilih
     * @return type
     */
    public function getTotal($pilih = "") {
        $modDetail = GFPenerimaanDetailT::model()->findAllByAttributes(array('penerimaanbarang_id' => $this->penerimaanbarang_id));
        $totalBruto = 0;
        $totalDiskon = 0;
        $totalPPN = 0;
        $totalNetto = 0;
        foreach ($modDetail as $mod) {
            $totalBruto += ($mod->harganettoper * $mod->jmlterima);
            $hargaDiskon = $mod->harganettoper * $mod->persendiscount / 100;
            $hargaPPN = ($mod->harganettoper - $hargaDiskon) * $mod->HargappnToPersen / 100;
            $totalDiskon += ($hargaDiskon * $mod->jmlterima);
            $totalPPN += ($hargaPPN * $mod->jmlterima);
            $totalNetto += (($mod->harganettoper - $hargaDiskon + $hargaPPN) * $mod->jmlterima);
        }
        if ($pilih == 'bruto')
            return $totalBruto;
        else if ($pilih == 'diskon')
            return $totalDiskon;
        else if ($pilih == 'ppn')
            return $totalPPN;
        else if ($pilih == 'netto')
//              HITUNGANNYA ADA SELISIH >>  return $totalNetto + $this->fakturpembelian->biayamaterai;
            return $this->totalharga + (isset($this->fakturpembelian) ? $this->fakturpembelian->biayamaterai : 0);
        else
            return 0.00;
    }

    /**
     * Menampilkan supplier aktif untuk dropdownlist.
     * @return type
     */
    public function getSupplierItems() {
        return SupplierM::model()->findAll("supplier_aktif=TRUE AND supplier_jenis='Farmasi' ORDER BY supplier_nama");
    }

}
