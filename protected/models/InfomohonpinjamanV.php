<?php

/**
 * This is the model class for table "infomohonpinjaman_v".
 *
 * The followings are the available columns in table 'infomohonpinjaman_v':
 * @property integer $pegawai_id
 * @property string $nomorindukpegawai
 * @property string $gelardepan
 * @property string $nama_pegawai
 * @property integer $gelarbelakang_id
 * @property string $gelarbelakang_nama
 * @property string $tempatlahir_pegawai
 * @property string $tgl_lahirpegawai
 * @property string $jeniskelamin
 * @property string $agama
 * @property string $statusperkawinan
 * @property string $alamat_pegawai
 * @property integer $kelurahan_id
 * @property string $kelurahan_nama
 * @property string $kode_pos
 * @property string $kategoripegawai
 * @property integer $golonganpegawai_id
 * @property string $golonganpegawai_nama
 * @property integer $pangkat_id
 * @property string $pangkat_nama
 * @property integer $jabatan_id
 * @property string $jabatan_nama
 * @property integer $keanggotaan_id
 * @property string $tglkeanggotaaan
 * @property string $nokeanggotaan
 * @property integer $permohonanpinjaman_id
 * @property string $tglpermohonanpinjaman
 * @property string $nopermohonan
 * @property string $jenispinjaman_permohonan
 * @property double $jmlpinjaman
 * @property integer $jangkawaktu_pinj_bln
 * @property double $jasapinjaman_bln
 * @property string $untukkeperluan
 * @property double $jmlinsentif
 * @property double $jmlsimpanan
 * @property double $jmlpenghasilanlain
 * @property double $jmltunggakanuangpinj
 * @property double $jmltunggakanbrgpinj
 * @property double $batasplafon
 * @property integer $petugas_id
 * @property integer $pinjaman_id
 * @property string $no_pinjaman
 * @property string $tglpinjaman
 * @property integer $approval_id
 * @property string $tglapproval
 * @property string $keteranganapproval
 * @property integer $appr_diperiksaoleh_id
 * @property string $appr_tgldiperiksa
 * @property integer $appr_disetujuioleh_id
 * @property string $appr_tgldisetujui
 * @property boolean $status_disetujui
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 */
class InfomohonpinjamanV extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfomohonpinjamanV the static model class
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
		return 'infomohonpinjaman_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, gelarbelakang_id, kelurahan_id, golonganpegawai_id, pangkat_id, jabatan_id, keanggotaan_id, permohonanpinjaman_id, jangkawaktu_pinj_bln, petugas_id, pinjaman_id, approval_id, appr_diperiksaoleh_id, appr_disetujuioleh_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('jmlpinjaman, jasapinjaman_bln, jmlinsentif, jmlsimpanan, jmlpenghasilanlain, jmltunggakanuangpinj, jmltunggakanbrgpinj, batasplafon', 'numerical'),
			array('nomorindukpegawai, tempatlahir_pegawai', 'length', 'max'=>30),
			array('gelardepan', 'length', 'max'=>10),
			array('nama_pegawai, kelurahan_nama, golonganpegawai_nama, pangkat_nama, nokeanggotaan, nopermohonan, jenispinjaman_permohonan, no_pinjaman', 'length', 'max'=>50),
			array('gelarbelakang_nama, kode_pos', 'length', 'max'=>15),
			array('jeniskelamin, agama, statusperkawinan', 'length', 'max'=>20),
			array('kategoripegawai', 'length', 'max'=>128),
			array('jabatan_nama', 'length', 'max'=>100),
			array('tgl_lahirpegawai, alamat_pegawai, tglkeanggotaaan, tglpermohonanpinjaman, untukkeperluan, tglpinjaman, tglapproval, keteranganapproval, appr_tgldiperiksa, appr_tgldisetujui, status_disetujui, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegawai_id, nomorindukpegawai, gelardepan, nama_pegawai, gelarbelakang_id, gelarbelakang_nama, tempatlahir_pegawai, tgl_lahirpegawai, jeniskelamin, agama, statusperkawinan, alamat_pegawai, kelurahan_id, kelurahan_nama, kode_pos, kategoripegawai, golonganpegawai_id, golonganpegawai_nama, pangkat_id, pangkat_nama, jabatan_id, jabatan_nama, keanggotaan_id, tglkeanggotaaan, nokeanggotaan, permohonanpinjaman_id, tglpermohonanpinjaman, nopermohonan, jenispinjaman_permohonan, jmlpinjaman, jangkawaktu_pinj_bln, jasapinjaman_bln, untukkeperluan, jmlinsentif, jmlsimpanan, jmlpenghasilanlain, jmltunggakanuangpinj, jmltunggakanbrgpinj, batasplafon, petugas_id, pinjaman_id, no_pinjaman, tglpinjaman, approval_id, tglapproval, keteranganapproval, appr_diperiksaoleh_id, appr_tgldiperiksa, appr_disetujuioleh_id, appr_tgldisetujui, status_disetujui, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pegawai_id' => 'Pegawai',
			'nomorindukpegawai' => 'Nomorindukpegawai',
			'gelardepan' => 'Gelardepan',
			'nama_pegawai' => 'Nama Pegawai',
			'gelarbelakang_id' => 'Gelarbelakang',
			'gelarbelakang_nama' => 'Gelarbelakang Nama',
			'tempatlahir_pegawai' => 'Tempatlahir Pegawai',
			'tgl_lahirpegawai' => 'Tgl. Lahir Pegawai',
			'jeniskelamin' => 'Jenis Kelamin',
			'agama' => 'Agama',
			'statusperkawinan' => 'Statusperkawinan',
			'alamat_pegawai' => 'Alamat Pegawai',
			'kelurahan_id' => 'Kelurahan',
			'kelurahan_nama' => 'Kelurahan Nama',
			'kode_pos' => 'Kode Pos',
			'kategoripegawai' => 'Kategoripegawai',
			'golonganpegawai_id' => 'Golonganpegawai',
			'golonganpegawai_nama' => 'Golonganpegawai Nama',
			'pangkat_id' => 'Pangkat',
			'pangkat_nama' => 'Pangkat Nama',
			'jabatan_id' => 'Jabatan',
			'jabatan_nama' => 'Jabatan Nama',
			'keanggotaan_id' => 'Keanggotaan',
			'tglkeanggotaaan' => 'Tglkeanggotaaan',
			'nokeanggotaan' => 'No. Anggotaan',
			'permohonanpinjaman_id' => 'Permohonanpinjaman',
			'tglpermohonanpinjaman' => 'Tglpermohonanpinjaman',
			'nopermohonan' => 'No Permohonan',
			'jenispinjaman_permohonan' => 'Jenis Pinjaman',
			'jmlpinjaman' => 'Jmlpinjaman',
			'jangkawaktu_pinj_bln' => 'Jangkawaktu Pinj Bln',
			'jasapinjaman_bln' => 'Jasapinjaman Bln',
			'untukkeperluan' => 'Untukkeperluan',
			'jmlinsentif' => 'Jmlinsentif',
			'jmlsimpanan' => 'Jmlsimpanan',
			'jmlpenghasilanlain' => 'Jmlpenghasilanlain',
			'jmltunggakanuangpinj' => 'Jmltunggakanuangpinj',
			'jmltunggakanbrgpinj' => 'Jmltunggakanbrgpinj',
			'batasplafon' => 'Batasplafon',
			'petugas_id' => 'Petugas',
			'pinjaman_id' => 'Pinjaman',
			'no_pinjaman' => 'No Pinjaman',
			'tglpinjaman' => 'Tglpinjaman',
			'approval_id' => 'Approval',
			'tglapproval' => 'Tglapproval',
			'keteranganapproval' => 'Keteranganapproval',
			'appr_diperiksaoleh_id' => 'Appr Diperiksaoleh',
			'appr_tgldiperiksa' => 'Appr Tgldiperiksa',
			'appr_disetujuioleh_id' => 'Appr Disetujuioleh',
			'appr_tgldisetujui' => 'Appr Tgldisetujui',
			'status_disetujui' => 'Status Disetujui',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		if (!empty($this->tglAwal) && !empty($this->tglAkhir)) {
			$criteria->addBetweenCondition('t.tglpermohonanpinjaman', $this->tglAwal, $this->tglAkhir);
		}

		if(!empty($this->pegawai_id))$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		//$criteria->compare('t.pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(t.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(t.tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('t.tgl_lahirpegawai',$this->tgl_lahirpegawai,true);
		$criteria->compare('t.jeniskelamin',$this->jeniskelamin,true);
		$criteria->compare('LOWER(t.agama)',strtolower($this->agama),true);
		$criteria->compare('t.statusperkawinan',$this->statusperkawinan,true);
		$criteria->compare('LOWER(t.alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		if(!empty($this->kelurahan_id))$criteria->addCondition('t.kelurahan_id = '.$this->kelurahan_id);
		//$criteria->compare('t.kelurahan_id',$this->kelurahan_id);
		$criteria->compare('LOWER(t.kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		$criteria->compare('t.kode_pos',$this->kode_pos,true);
		$criteria->compare('LOWER(t.kategoripegawai)',strtolower($this->kategoripegawai),true);
		$criteria->compare('t.golonganpegawai_id',$this->golonganpegawai_id);
		$criteria->compare('LOWER(t.golonganpegawai_nama)',strtolower($this->golonganpegawai_nama),true);
		if(!empty($this->pangkat_id))$criteria->addCondition('t.pangkat_id = '.$this->pangkat_id);
		//$criteria->compare('t.pangkat_id',$this->pangkat_id);
		$criteria->compare('LOWER(t.pangkat_nama)',strtolower($this->pangkat_nama),true);
		if(!empty($this->jabatan_id))$criteria->addCondition('t.jabatan_id = '.$this->jabatan_id);
		//$criteria->compare('t.jabatan_id',$this->jabatan_id);
		$criteria->compare('LOWER(t.jabatan_nama)',strtolower($this->jabatan_nama),true);
		if(!empty($this->unit_id))$criteria->addCondition('t.unit_id = '.$this->unit_id);
		//$criteria->compare('t.unit_id',$this->unit_id);
		//$criteria->compare('LOWER(t.namaunit)',strtolower($this->namaunit),true);
		if(!empty($this->keanggotaan_id))$criteria->addCondition('t.keanggotaan_id = '.$this->keanggotaan_id);
		//$criteria->compare('t.keanggotaan_id',$this->keanggotaan_id);
		$criteria->compare('t.nokeanggotaan',$this->nokeanggotaan,true);
		if(!empty($this->permohonanpinjaman_id))$criteria->addCondition('t.permohonanpinjaman_id = '.$this->permohonanpinjaman_id);
		//$criteria->compare('t.permohonanpinjaman_id',$this->permohonanpinjaman_id);
		//$criteria->compare('t.tglpermohonanpinjaman',$this->tglpermohonanpinjaman,true);
		$criteria->compare('t.nopermohonan',$this->nopermohonan,true);
		$criteria->compare('LOWER(t.jenispinjaman_permohonan)',strtolower($this->jenispinjaman_permohonan),true);
		// $criteria->compare('potongansumber_id',$this->potongansumber_id);
		// $criteria->compare('LOWER(namapotongan)',strtolower($this->namapotongan),true);
		$criteria->compare('jmlpinjaman',$this->jmlpinjaman);
		$criteria->compare('jangkawaktu_pinj_bln',$this->jangkawaktu_pinj_bln);
		$criteria->compare('jasapinjaman_bln',$this->jasapinjaman_bln);
		$criteria->compare('untukkeperluan',$this->untukkeperluan,true);
		$criteria->compare('jmlinsentif',$this->jmlinsentif);
		$criteria->compare('jmlsimpanan',$this->jmlsimpanan);
		$criteria->compare('jmlpenghasilanlain',$this->jmlpenghasilanlain);
		$criteria->compare('jmltunggakanuangpinj',$this->jmltunggakanuangpinj);
		$criteria->compare('jmltunggakanbrgpinj',$this->jmltunggakanbrgpinj);
		$criteria->compare('batasplafon',$this->batasplafon);
		if(!empty($this->petugas_id))$criteria->addCondition('petugas_id = '.$this->petugas_id);
		//$criteria->compare('petugas_id',$this->petugas_id);
		if(!empty($this->approval_id))$criteria->addCondition('approval_id = '.$this->approval_id);
		//$criteria->compare('approval_id',$this->approval_id);
		$criteria->compare('tglapproval',$this->tglapproval,true);
		$criteria->compare('keteranganapproval',$this->keteranganapproval,true);
		if(!empty($this->appr_diperiksaoleh_id))$criteria->addCondition('appr_diperiksaoleh_id = '.$this->appr_diperiksaoleh_id);
		//$criteria->compare('appr_diperiksaoleh_id',$this->appr_diperiksaoleh_id);
		$criteria->compare('appr_tgldiperiksa',$this->appr_tgldiperiksa,true);
		if(!empty($this->appr_disetujuioleh_id))$criteria->addCondition('appr_disetujuioleh_id = '.$this->appr_disetujuioleh_id);
		//$criteria->compare('appr_disetujuioleh_id',$this->appr_disetujuioleh_id);
		$criteria->compare('appr_tgldisetujui',$this->appr_tgldisetujui,true);
		//$criteria->compare('status_disetujui',$this->status_disetujui);
		
		//$criteria->order='t.tglpermohonanpinjaman DESC';
		//var_dump($this->status_disetujui); die;

		if ($this->status_disetujui == 3) $criteria->addCondition('approval_id is null');
		else if ($this->status_disetujui == 1) $criteria->addCondition('status_disetujui = true');
		else if ($this->status_disetujui == 2) $criteria->addCondition('status_disetujui = false');

		if ($this->cair == 1) $criteria->addCondition('pinjaman_id is not null');
		else if ($this->cair == 2) $criteria->addCondition('pinjaman_id is null');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'t.tglpermohonanpinjaman DESC',
			),
		));
	}

	public function searchTerupdate(){
		$provider=$this->search();
		$provider->criteria->limit = 5;

		return new CActiveDataProvider($this, array(
			'criteria'=>$provider->criteria,
			'sort'=>array(
				'defaultOrder'=>'t.tglpermohonanpinjaman DESC',
			),'Pagination'=>FALSE
		));
	}

	public $potongansumber_id;
	public function searchInformasi() {
                $sql_surat_peminjaman = "("
                                . "case when pinjaman.pinjaman_id is null then ("
                                . "case when t.approval_id is not null and t.status_disetujui = false then 3 else 1 end"
                                . ") else 2 end"
                                . ")";
            
		$provider = $this->search();
		if (!empty($this->potongansumber_id)) {
			$provider->criteria->join = 'join potonganpinjamandari_t p on p.permohonanpinjaman_id = t.permohonanpinjaman_id ';
			$provider->criteria->addCondition('p.potongansumber_id = '.$this->potongansumber_id);
                        
			//$provider->criteria->compare('p.potongansumber_id', $this->potongansumber_id);
		}
                
                $provider->criteria->join .= ' left join pinjaman_t pinjaman on pinjaman.permohonanpinjaman_id = t.permohonanpinjaman_id';
                $provider->criteria->select .= ", t.permohonanpinjaman_id, ".$sql_surat_peminjaman." as surat_peminjaman";
                $provider->criteria->compare($sql_surat_peminjaman, $this->surat_peminjaman);
                
		return $provider;
	}

	public function searchPrint(){
		$provider = $this->searchInformasi();
		$provider->setPagination(false);
		$provider->setSort(false);
		return $provider;
	}

	public function searchPemohonApproved() {
		$provider = $this->search();
		$provider->criteria->addCondition('status_disetujui = true');
		$provider->criteria->join = 'left join pinjaman_t pinjaman on pinjaman.permohonanpinjaman_id = t.permohonanpinjaman_id';
		$provider->criteria->addCondition('pinjaman.pinjaman_id is null');
		return $provider;
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InformasipermohonanpinjamanV the static model class
	 */
	

	public function getPinjaman() {
		$id = PotonganpinjamandariT::model()->findAllByAttributes(array('permohonanpinjaman_id'=>$this->permohonanpinjaman_id));
		//var_dump($id);
		return !empty($id);
	}
	public function getSumberPotongan() {
			$id = PotonganpinjamandariT::model()->findAllByAttributes(array('permohonanpinjaman_id'=>$this->permohonanpinjaman_id));
			$str = '';
			foreach ($id as $x){
						$sumber = PotongansumberM::model()->findByPk($x->potongansumber_id);
						$str .= "<i class='entypo-check'></i>".$sumber->namapotongan."<br/>";
			}
			return $str."<br/>";
	}

	public function getJmlPinjamTerkini() {
		$pinjaman = PinjamanT::model()->findByPk($this->pinjaman_id);
        return empty($pinjaman)?0:$this->jmlpinjaman;
	}

	public function getTotalPinjaman($provider, $cair = false) {
		$total = 0;
		foreach ($provider->data as $item) {
			$total += $cair?$item->jmlPinjamTerkini:$item->jmlpinjaman;
		}
		return $total;
	}
}