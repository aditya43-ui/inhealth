<?php

/**
 * This is the model class for table "pengajuankasbon_t".
 *
 * The followings are the available columns in table 'pengajuankasbon_t':
 * @property integer $pengajuankasbon_id
 * @property string $tgl_pengajuan
 * @property string $no_pengajuan
 * @property string $keperluan
 * @property integer $pegawai_mengajukan_id
 * @property string $nip
 * @property integer $nominal_kasbon
 * @property integer $pegawai_mengetahui_id
 * @property string $tgl_pegawai_mengetahui
 * @property integer $pegawai_menyetujui1_id
 * @property string $tgl_pegawai_menyetuji1
 * @property integer $pegawai_menyetujui2_id
 * @property string $tgl_pegawai_menyetujui2
 * @property string $status_persetujuan
 * @property string $status_validasi
 * @property integer $kasir_menyetujui_id
 * @property string $tgl_kasir_menyetujui
 * @property string $no_kuitansi
 * @property integer $instalasi_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 *
 * The followings are the available model relations:
 * @property InstalasiM $instalasi
 * @property PegawaiM $kasirMenyetujui
 * @property PegawaiM $pegawaiMengajukan
 * @property PegawaiM $pegawaiMenyetujui1
 * @property PegawaiM $pegawaiMenyetujui2
 * @property PegawaiM $pegawaiMengetahui
 * @property LpjT[] $lpjTs
 */
class PengajuankasbonT extends CActiveRecord
{
	public $pegawai_mengajukan_nama, $unitkerja_nama; 
	public $pegawai_mengetahui_nama, $pegawai_menyetujui1_nama, $pegawai_menyetujui2_nama; 
	public $tgl_awal, $tgl_akhir; 
	public $unitkerja_id; 
	public $total_lpj;
	public $status, $url;
	public $ada_pengeluaran = false;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pengajuankasbon_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('instalasi_id, keperluan, nominal_kasbon, create_time, create_loginpemakai_id', 'required'),
			array('pegawai_mengajukan_id, nominal_kasbon, pegawai_mengetahui_id, pegawai_menyetujui1_id, pegawai_menyetujui2_id, kasir_menyetujui_id, instalasi_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('no_pengajuan, status_persetujuan, status_validasi, no_kuitansi', 'length', 'max'=>45),
			array('nip', 'length', 'max'=>20),
			array('tgl_pengajuan, tgl_pegawai_mengetahui, tgl_pegawai_menyetuji1, tgl_pegawai_menyetujui2, tgl_kasir_menyetujui, update_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('pengajuankasbon_id, tgl_pengajuan, no_pengajuan, keperluan, pegawai_mengajukan_id, nip, nominal_kasbon, pegawai_mengetahui_id, tgl_pegawai_mengetahui, pegawai_menyetujui1_id, tgl_pegawai_menyetuji1, pegawai_menyetujui2_id, tgl_pegawai_menyetujui2, status_persetujuan, status_validasi, kasir_menyetujui_id, tgl_kasir_menyetujui, no_kuitansi, instalasi_id, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan', 'safe', 'on'=>'search'),
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
			'instalasi' => array(self::BELONGS_TO, 'InstalasiM', 'instalasi_id'),
			'kasirMenyetujui' => array(self::BELONGS_TO, 'PegawaiM', 'kasir_menyetujui_id'),
			'pegawaimengajukan' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_mengajukan_id'),
			'pegawaimenyetujui1' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_menyetujui1_id'),
			'pegawaimenyetujui2' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_menyetujui2_id'),
			'pegawaimengetahui' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_mengetahui_id'),
			'lpjTs' => array(self::HAS_MANY, 'LpjT', 'pengajuankasbon_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pengajuankasbon_id' => 'Pengajuankasbon',
			'tgl_pengajuan' => 'Tgl Pengajuan',
			'no_pengajuan' => 'No Pengajuan',
			'keperluan' => 'Keperluan',
			'pegawai_mengajukan_id' => 'Pegawai Mengajukan',
			'pegawai_mengajukan_nama' => 'Pegawai yang Mengajukan',
			'unitkerja_nama' => 'Unit Kerja',
			'nip' => 'NIP',
			'nominal_kasbon' => 'Nominal Kasbon (Rp.)',
			'pegawai_mengetahui_id' => 'Pegawai Mengetahui',
			'tgl_pegawai_mengetahui' => 'Tgl Pegawai Mengetahui',
			'pegawai_menyetujui1_id' => 'Pegawai Menyetujui1',
			'tgl_pegawai_menyetuji1' => 'Tgl Pegawai Menyetuji1',
			'pegawai_menyetujui2_id' => 'Pegawai Menyetujui2',
			'tgl_pegawai_menyetujui2' => 'Tgl Pegawai Menyetujui2',
			'status_persetujuan' => 'Status Persetujuan',
			'status_validasi' => 'Status Validasi',
			'kasir_menyetujui_id' => 'Kasir Menyetujui',
			'tgl_kasir_menyetujui' => 'Tgl Kasir Menyetujui',
			'no_kuitansi' => 'No Kuitansi',
			'instalasi_id' => 'Instalasi',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai_id' => 'Create Loginpemakai',
			'update_loginpemakai_id' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('pengajuankasbon_id',$this->pengajuankasbon_id);
		$criteria->compare('tgl_pengajuan',$this->tgl_pengajuan,true);
		$criteria->compare('no_pengajuan',$this->no_pengajuan,true);
		$criteria->compare('keperluan',$this->keperluan,true);
		$criteria->compare('pegawai_mengajukan_id',$this->pegawai_mengajukan_id);
		$criteria->compare('nip',$this->nip,true);
		$criteria->compare('nominal_kasbon',$this->nominal_kasbon);
		$criteria->compare('pegawai_mengetahui_id',$this->pegawai_mengetahui_id);
		$criteria->compare('tgl_pegawai_mengetahui',$this->tgl_pegawai_mengetahui,true);
		$criteria->compare('pegawai_menyetujui1_id',$this->pegawai_menyetujui1_id);
		$criteria->compare('tgl_pegawai_menyetuji1',$this->tgl_pegawai_menyetuji1,true);
		$criteria->compare('pegawai_menyetujui2_id',$this->pegawai_menyetujui2_id);
		$criteria->compare('tgl_pegawai_menyetujui2',$this->tgl_pegawai_menyetujui2,true);
		$criteria->compare('status_persetujuan',$this->status_persetujuan,true);
		$criteria->compare('status_validasi',$this->status_validasi,true);
		$criteria->compare('kasir_menyetujui_id',$this->kasir_menyetujui_id);
		$criteria->compare('tgl_kasir_menyetujui',$this->tgl_kasir_menyetujui,true);
		$criteria->compare('no_kuitansi',$this->no_kuitansi,true);
		$criteria->compare('instalasi_id',$this->instalasi_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PengajuankasbonT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    /**
     * 
     * @param type $model
     * @param type $post
     * @return type
     */
    public static function simpan_data($model, $post, $is_lpj = false) {
        $ok = true;
        $format = new MyFormatter();

        $model->attributes = $post;
        $model->tgl_pengajuan = $format->formatDateTimeForDb($model->tgl_pengajuan);

        if (empty($model->pengajuankasbon_id)) {
            $model->create_time = date('Y-m-d H:i:s');
            $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $model->no_pengajuan = MyGenerator::noPengajuanKasbon();
            $model->no_kuitansi = MyGenerator::noKuitansiKasbon();
        } else {
            $model->update_time = date('Y-m-d H:i:s');
            $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        }

		if ($is_lpj == true) {
			$model->no_lpj = MyGenerator::noVoucherLPJ();
		}    

        $ok &= $model->save();
        $pesan = '';

        if (!$ok) {
            $pesan .= '<br/> Pengajuan Kasbon : ' . MyExceptionMessage::getErrorMessage($model);
        }

        $data['sukses'] = $ok;
        $data['model'] = $model;
        $data['pesan'] = $pesan;

        return $data;
    }

	public function criteriaSearch() {
		$criteria = new CDbCriteria();
		$criteria->select = "t.*, pegawai_m.unitkerja_id ";
		if (!empty($this->tgl_awal) && !empty($this->tgl_akhir)) {
			$criteria->addBetweenCondition("DATE(t.tgl_pengajuan)", $this->tgl_awal, $this->tgl_akhir);
		}
		$criteria->join = "JOIN pegawai_m on t.pegawai_mengajukan_id = pegawai_m.pegawai_id ";
		$criteria->compare('lower(no_pengajuan)', strtolower($this->no_pengajuan), true);
        $criteria->compare('status_persetujuan', $this->status_persetujuan);
        $criteria->compare('pegawai_m.unitkerja_id', $this->unitkerja_id);
		$criteria->order = "pengajuankasbon_id desc";

		if ($this->ada_pengeluaran) {
			$criteria->addCondition("pengeluaranumum_id is not null");
		}

		if (Yii::app()->user->getState('ruangan_id') !== Params::RUANGAN_ID_KASIR) {
			$modKepalaUnit = UnitkerjaM::model()->findByAttributes(['kepalaunitpeg_id' => Yii::app()->user->getState('pegawai_id')]);
			if (!empty($modKepalaUnit)) {
				$criteria->addCondition('pegawai_m.unitkerja_id = '.$modKepalaUnit->unitkerja_id);
			} else {	
				$criteria->addCondition('pegawai_menyetujui1_id = '.Yii::app()->user->getState('pegawai_id'). ' OR pegawai_menyetujui2_id = '.Yii::app()->user->getState('pegawai_id'). 'OR pegawai_mengajukan_id = '.Yii::app()->user->getState('pegawai_id'). 'OR pegawai_mengetahui_id = '.Yii::app()->user->getState('pegawai_id'));
			}
		}

		return $criteria;
	}

	public function searchInformasi() {
		$criteria = $this->criteriaSearch(); 

		return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
	}

	public function searchInformasiUntukPengeluaranKas() {
		$criteria = $this->criteriaSearch(); 
		$criteria->addCondition('pengeluaranumum_id is null');

		return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
	}

	public function searchInformasiUntukPenerimaanKas() {
		$criteria = $this->criteriaSearch(); 
		$criteria->addCondition('pengeluaranumum_id is not null and penerimaanumum_id is null');

		return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
	}

	public function searchPrint() {
		$criteria = $this->criteriaSearch(); 

		return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
	}
}
