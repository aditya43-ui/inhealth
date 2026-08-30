<?php
class GUInvbarangT extends InvbarangT
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InvbarangT the static model class
     */
    public $mengetahui_nama, $petugas1_nama, $petugas2_nama, $inventarisasi_id;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'invbarang_id' => 'ID',
            'ruangan_id' => 'Ruangan',
            'invbarang_no' => 'No. Inventarisasi',
            'invbarang_tgl' => 'Tgl. Inventarisasi',
            'invbarang_ket' => 'Keterangan',
            'invbarang_totalharga' => 'Total harga',
            'invbarang_totalnetto' => 'Total netto',
            'mengetahui_id' => 'Mengetahui',
            'petugas1_id' => 'Petugas 1',
            'petugas2_id' => 'Petugas 2',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'create_ruangan' => 'Create Ruangan',
            'formulirinvbarang_id' => 'Formulirinvbarang',
            'invbarang_jenis' => 'Jenis Inventarisasi',
            'totalnilaipersediaan' => 'Total Nilai Persediaan'
        );
    }
}
