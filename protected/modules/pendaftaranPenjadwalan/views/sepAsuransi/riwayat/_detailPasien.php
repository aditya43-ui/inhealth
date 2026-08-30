
        <div class="row-fluid">
            <div class="col-sm-6">
                <table width="100%" class="tab_sep_detail">
                    <tbody>
                        <tr>
                            <td width="200">Nomor Kartu Peserta</td>
                            <td width="10">:</td>
                            <td><?php echo $peserta['noKartu'] ?></td>
                        </tr>
                        <tr>
                            <td>Nama Peserta</td>
                            <td>:</td>
                            <td><?php echo $peserta['nama'] ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td>:</td>
                            <td><?php echo MyFormatter::formatDateTimeForUser($peserta['tglLahir']) ?></td>
                        </tr>
                        <tr>
                            <td>NIK</td>
                            <td>:</td>
                            <td><?php echo $peserta['nik'] ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td><?php echo $peserta['sex'] ?></td>
                        </tr>
                        <tr>
                            <td>Kode Provider</td>
                            <td>:</td>
                            <td><?php echo $peserta['provUmum']['kdProvider'] ?></td>
                        </tr>
                        <tr>
                            <td>Provider</td>
                            <td>:</td>
                            <td><?php echo $peserta['provUmum']['nmProvider'] ?></td>
                        </tr>
                        <tr>
                            <td>Kode Cabang</td>
                            <td>:</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Nama Cabang</td>
                            <td>:</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Kode Kelas Tanggungan</td>
                            <td>:</td>
                            <td><?php echo $peserta['hakKelas']['kode'] ?></td>
                        </tr>
                        <tr>
                            <td>Kelas Tanggungan</td>
                            <td>:</td>
                            <td><?php echo $peserta['hakKelas']['keterangan'] ?></td>
                        </tr>
                        <tr>
                            <td>Kode Jenis Peserta</td>
                            <td>:</td>
                            <td><?php echo $peserta['jenisPeserta']['kode'] ?></td>
                        </tr>
                        <tr>
                            <td>Jenis Peserta</td>
                            <td>:</td>
                            <td><?php echo $peserta['jenisPeserta']['keterangan'] ?></td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="col-sm-6">
            <table width="100%" class="tab_sep_detail">
                    <tbody>
                        <tr>
                            <td width="200">Status Peserta</td>
                            <td width="10">:</td>
                            <td><?php echo $peserta['statusPeserta']['keterangan'] ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Cetak Kartu</td>
                            <td>:</td>
                            <td><?php echo MyFormatter::formatDateTimeForUser($peserta['tglCetakKartu']) ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal TAT</td>
                            <td>:</td>
                            <td><?php echo MyFormatter::formatDateTimeForUser($peserta['tglTAT']) ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal TMT</td>
                            <td>:</td>
                            <td><?php echo MyFormatter::formatDateTimeForUser($peserta['tglTMT']) ?></td>
                        </tr>
                        <tr>
                            <td>Nomor Rekam Medik</td>
                            <td>:</td>
                            <td><?php echo $peserta['rm']['noMR'] ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td>Umur Sekarang</td>
                            <td>:</td>
                            <td><?php echo $peserta['umur']['umurSekarang'] ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td>Umur Saat Pelayanan</td>
                            <td>:</td>
                            <td><?php echo $peserta['umur']['umurSaatPelayanan'] ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td>Nama Asuransi COB</td>
                            <td>:</td>
                            <td><?php echo $peserta['cob']['nmAsuransi'] ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td>No Asuransi COB</td>
                            <td>:</td>
                            <td><?php echo $peserta['cob']['noAsuransi'] ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td>Dinsos</td>
                            <td>:</td>
                            <td><?php echo $peserta['informasi']['dinsos'] ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td>No. SKTM</td>
                            <td>:</td>
                            <td><?php echo $peserta['informasi']['noSKTM'] ?? "-" ?></td>
                        </tr>
                        <tr>
                            <td>Prolanis PRB</td>
                            <td>:</td>
                            <td><?php echo $peserta['informasi']['prolanisPRB'] ?? "-" ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br/>