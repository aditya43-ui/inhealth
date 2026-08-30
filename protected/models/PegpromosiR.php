<?php

/**
 * This is the model class for table "pegpromosi_r".
 *
 * The followings are the available columns in table 'pegpromosi_r':
 * @property integer $pegpromosi_id
 * @property integer $pegawai_id
 * @property string $jenispromosi
 * @property string $prom_nomorsurat
 * @property string $prom_golongan_lama
 * @property string $prom_jabatan_lama
 * @property string $prom_pangkat_lama
 * @property string $prom_unitkerja
 * @property string $prom_nosk
 * @property string $prom_tglsk
 * @property string $prom_tmtsk
 * @property string $prom_mengetahui_nama
 * @property string $prom_pimpinan_nama
 * @property string $prom_golongan_baru
 * @property string $prom_jabatan_baru
 * @property string $prom_pangkat_baru
 * @property string $prom_unitkerja_baru
 * @property string $prom_lokasikerja_baru
 * @property string $prom_file_sk
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 */
class PegpromosiR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PegpromosiR the static model class
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
		return 'pegpromosi_r';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, jenispromosi, prom_nomorsurat, prom_jabatan_lama, prom_unitkerja, prom_nosk, prom_tglsk, prom_mengetahui_nama, prom_pimpinan_nama', 'required'),
			array('pegawai_id', 'numerical', 'integerOnly'=>true),
			array('jenispromosi, prom_nomorsurat, prom_mengetahui_nama, prom_pimpinan_nama, prom_lokasikerja_baru', 'length', 'max'=>100),
			array('prom_golongan_lama, prom_jabatan_lama, prom_pangkat_lama, prom_unitkerja, prom_golongan_baru, prom_jabatan_baru, prom_pangkat_baru, prom_unitkerja_baru', 'length', 'max'=>50),
			array('prom_nosk', 'length', 'max'=>20),
			array('prom_file_sk', 'length', 'max'=>255),
			array('prom_pegapproval, prom_approval, prom_tmtsk', 'safe'),
                        array('prom_status, prom_alasan, prom_file_sk', 'file', 'types'=>'pdf','allowEmpty'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pegpromosi_id, pegawai_id, jenispromosi, prom_nomorsurat, prom_golongan_lama, prom_jabatan_lama, prom_pangkat_lama, prom_unitkerja, prom_nosk, prom_tglsk, prom_tmtsk, prom_mengetahui_nama, prom_pimpinan_nama, prom_golongan_baru, prom_jabatan_baru, prom_pangkat_baru, prom_unitkerja_baru, prom_lokasikerja_baru, prom_file_sk', 'safe', 'on'=>'search'),
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
			'pegawai' => array(self::BELONGS_TO, 'PegawaiM', 'pegawai_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'pegpromosi_id' => 'ID',
			'pegawai_id' => 'Pegawai',
			'jenispromosi' => 'Jenis Promosi',
			'prom_nomorsurat' => 'Nomor Surat',
			'prom_golongan_lama' => 'Golongan Lama',
			'prom_jabatan_lama' => 'Jabatan Lama',
			'prom_pangkat_lama' => 'Pangkat Lama',
			'prom_unitkerja' => 'Unit Kerja',
			'prom_nosk' => 'No SK',
			'prom_tglsk' => 'Tanggal SK',
			'prom_tmtsk' => 'TMT SK',
			'prom_mengetahui_nama' => 'Mengetahui',
			'prom_pimpinan_nama' => 'Pimpinan',
			'prom_golongan_baru' => 'Golongan Baru',
			'prom_jabatan_baru' => 'Jabatan Baru',
			'prom_pangkat_baru' => 'Pangkat Baru',
			'prom_unitkerja_baru' => 'Unit Kerja Baru',
			'prom_lokasikerja_baru' => 'Lokasi Kerja Baru',
			'prom_file_sk' => 'File SK',
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

		$criteria->compare('pegpromosi_id',$this->pegpromosi_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('jenispromosi',$this->jenispromosi,true);
		$criteria->compare('prom_nomorsurat',$this->prom_nomorsurat,true);
		$criteria->compare('prom_golongan_lama',$this->prom_golongan_lama,true);
		$criteria->compare('prom_jabatan_lama',$this->prom_jabatan_lama,true);
		$criteria->compare('prom_pangkat_lama',$this->prom_pangkat_lama,true);
		$criteria->compare('prom_unitkerja',$this->prom_unitkerja,true);
		$criteria->compare('prom_nosk',$this->prom_nosk,true);
		$criteria->compare('prom_tglsk',$this->prom_tglsk,true);
		$criteria->compare('prom_tmtsk',$this->prom_tmtsk,true);
		$criteria->compare('prom_mengetahui_nama',$this->prom_mengetahui_nama,true);
		$criteria->compare('prom_pimpinan_nama',$this->prom_pimpinan_nama,true);
		$criteria->compare('prom_golongan_baru',$this->prom_golongan_baru,true);
		$criteria->compare('prom_jabatan_baru',$this->prom_jabatan_baru,true);
		$criteria->compare('prom_pangkat_baru',$this->prom_pangkat_baru,true);
		$criteria->compare('prom_unitkerja_baru',$this->prom_unitkerja_baru,true);
		$criteria->compare('prom_lokasikerja_baru',$this->prom_lokasikerja_baru,true);
		$criteria->compare('prom_file_sk',$this->prom_file_sk,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getJabatanItems() {
            return JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama');
        }
        
        public function getPangkatItems() {
            return PangkatM::model()->findAll('pangkat_aktif=TRUE ORDER BY pangkat_nama');
        }
        
        public function getMengetahuiItems() {
            return PegawaiM::model()->findAll('pegawai_aktif=TRUE ORDER BY nama_pegawai');
        }
        
        public function getRuanganItems() {
            return RuanganM::model()->findAll('ruangan_aktif=TRUE ORDER BY ruangan_nama');
        }
        
        public function getGolonganItems() {
            return GolonganpegawaiM::model()->findAll('golonganpegawai_aktif=TRUE ORDER BY golonganpegawai_nama');
        }
}