<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestRencanaLembur
 *
 * @author root
 */
class TestRencanaLembur extends CTestCase {
    //put your code here
    public $post;
    public $postReal;
    public $data;
    public $dataReal;
    public $trans;
    
    
    public function setUp() {
        Yii::import('kepegawaian.models.KPRencanaLemburT');
        Yii::import('kepegawaian.models.KPRealisasiLemburT');
        $this->post = array (
            'tglrencana' => '09/01/2018', 
            'norencana' => '-- Otomatis --', 
            'keterangan' => 'abc', 
            'pemberitugas_id' => '47', 
            'pemberitugas_nama' => 'Abdul Rohman', 
            'mengetahui_id' => '4', 
            'mengetahui_nama' => 'Diah Arini', 
            'menyetujui_id' => '872', 
            'menyetujui_nama' => 'ANGGI', 
            'karlembur_nama' => '', 
            'detail' => array ( 
                88 => array ( 
                    'nourut' => '1', 
                    'pegawai_id' => '88', 
                    'jamMulai' => '14:00:00', 
                    'jamSelesai' => '15:00:00', 
                    'alasanlembur' => 'abc', 
                ), 
                47 => array ( 
                    'nourut' => '2', 
                    'pegawai_id' => '47', 
                    'jamMulai' => '14:00:00', 
                    'jamSelesai' => '11:00:00', 
                    'alasanlembur' => 'def', 
                ), 
                9 => array ( 
                    'nourut' => '3', 
                    'pegawai_id' => '9', 
                    'jamMulai' => '13:00:00', 
                    'jamSelesai' => '23:00:00', 
                    'alasanlembur' => 'ghi', 
                ), 
                49 => array ( 
                    'nourut' => '4', 
                    'pegawai_id' => '49', 
                    'jamMulai' => '16:00:00', 
                    'jamSelesai' => '23:00:00', 
                    'alasanlembur' => 'jkl', 
                ), 
                53 => array ( 
                    'nourut' => '5', 
                    'pegawai_id' => '53', 
                    'jamMulai' => '18:00:00', 
                    'jamSelesai' => '23:00:00', 
                    'alasanlembur' => 'mno', 
                ), 54 => array ( 
                    'nourut' => '6', 
                    'pegawai_id' => '54', 
                    'jamMulai' => '18:00:00', 
                    'jamSelesai' => '20:00:00', 
                    'alasanlembur' => 'pqr', 
                ), 
                62 => array (
                    'nourut' => '7', 
                    'pegawai_id' => '62', 
                    'jamMulai' => '17:00:00', 
                    'jamSelesai' => '21:00:00', 
                    'alasanlembur' => 'stu', 
                ), 
            ), 
        );
        
        $this->postReal = array ( 
            'KPRencanaLemburT' => array ( 
                'tglrencana' => '10 Jan 2018 00:00:00', 
                'norencana' => 'RCLB1801100001', 
                'rencanalembur_id' => '18',
                'keterangan' => 'abc', 
                'pemberitugas_id' => '99', 
                'pemberitugas_nama' => 'Adi Nugroho', 
                'mengetahui_id' => '4', 
                'mengetahui_nama' => 'Diah Arini', 
                'menyetujui_id' => '872', 
                'menyetujui_nama' => 'ANGGI', 
            ), 
            'KPRealisasiLemburT' => array ( 
                'tglrealisasi' => '11/01/2018', 
                'norealisasi' => 'RLP180111001', 
                'detail' => array ( 
                    0 => array ( 
                        'nourut' => '1', 
                        'pegawai_id' => '14', 
                        'rencanalemburdet_id' => '22', 
                        'nomorindukpegawai' => '199708052016092046', 
                        'jamMulai' => '14:49:00', 
                        'jamSelesai' => '20:00:00', 
                        'totalJam' => '6', 
                        'nilaiLembur' => '4.000', 
                        'totalNilai' => '24.000', 
                        'alasanLembur' => 'abc', 
                    ), 
                    1 => array ( 
                        'nourut' => '2', 
                        'pegawai_id' => '26', 
                        'rencanalemburdet_id' => '23', 
                        'nomorindukpegawai' => '199110312016101022', 
                        'jamMulai' => '16:00:00', 
                        'jamSelesai' => '21:00:00', 
                        'totalJam' => '5', 
                        'nilaiLembur' => '4.000', 
                        'totalNilai' => '20.000', 
                        'alasanLembur' => 'def', ), 
                    2 => array ( 
                        'nourut' => '3', 
                        'pegawai_id' => '62', 
                        'rencanalemburdet_id' => '24', 
                        'nomorindukpegawai' => '199105262016101029', 
                        'jamMulai' => '18:00:00', 
                        'jamSelesai' => '23:00:00', 
                        'totalJam' => '5', 
                        'nilaiLembur' => '4.000', 
                        'totalNilai' => '20.000', 
                        'alasanLembur' => 'ghi', 
                    ), 
                    3 => array ( 
                        'nourut' => '4', 
                        'pegawai_id' => '3', 
                        'nomorindukpegawai' => '199012252017021031', 
                        'jamMulai' => '18:00:00', 
                        'jamSelesai' => '20:00:00', 
                        'totalJam' => '2', 
                        'nilaiLembur' => '4.000', 
                        'totalNilai' => '8.000', 
                        'alasanLembur' => 'test', 
                    ), 
                ), 
            ), 
            'isharilembur' => '1', 
            'KPPegawaiM' => array ( 
                0 => array ( 'nama_pegawai' => 'Asia Frida Shafira', ), 
                1 => array ( 'nama_pegawai' => 'Ahmad Imam Fahrudin', ), 
                2 => array ( 'nama_pegawai' => 'Agus Setiyadi', ), 
                3 => array ( 'nama_pegawai' => 'Andre Natalia', ), 
            ), 
        );
        
        parent::setUp();
    }
    
    
    public function testSimpanRencanaLembur() {
        echo "=== BEGIN TEST RENCANA LEMBUR ===\n";
        
        $this->trans = Yii::app()->db->beginTransaction();
        
        echo "Tested Post Input :\n";
        print_r($this->post);
        
        $this->data = KPRencanaLemburT::model()->saveRencanaLembur($this->post, true);
        
        echo "Current Data :\n";
        print_r($this->data->attributes);
        
        echo "Current Validation Errors :\n";
        print_r($this->data->errors);
        
        
        
        $this->assertEquals(true, $this->data->ok);
        $this->assertEquals(false, $this->data->is_error);
        $this->assertNotEmpty($this->data->rencanalembur_id);
        $this->assertNotEmpty($this->data->detail);
        $this->assertGreaterThan(0, count($this->data->detail));
        
        if (!empty($this->data->detail)) {
            echo "Added data :\n";
            foreach ($this->data->detail as $item) {
                print_r($item->attributes);
                $this->assertNotEmpty($item->rencanalemburdet_id);
            }
        }
        
        
        
        
        $this->trans->rollback();
        
        echo "END TEST RENCANA LEMBUR...\n";
        echo "---------------------------------------------------\n\n";
    }
    
    public function testSimpanRealisasiLembur() {
        
        echo "=== BEGIN TEST REALISASI LEMBUR ===\n";
        
        $this->trans = Yii::app()->db->beginTransaction();
        
        echo "Tested Post Input :\n";
        print_r($this->postReal);
        
        
        $this->dataReal = KPRealisasiLemburT::model()->saveRealisasiLembur($this->postReal, true);
        
        echo "Current Data :\n";
        print_r($this->dataReal->attributes);
        
        echo "Current Validation Errors :\n";
        print_r($this->dataReal->errors);
        
        $this->assertEquals(true, $this->dataReal->ok);
        $this->assertEquals(false, $this->dataReal->is_error);
        $this->assertNotEmpty($this->dataReal->rencanalembur_id);
        $this->assertNotEmpty($this->dataReal->detail);
        $this->assertGreaterThan(0, count($this->dataReal->detail));
        
        if (!empty($this->dataReal->detail)) {
            echo "Added data :\n";
            foreach ($this->dataReal->detail as $item) {
                print_r($item->attributes);
                $this->assertNotEmpty($item->realisasilemburdet_id);
            }
        }
        
        $this->trans->rollback();
        
        
    }
    
}
