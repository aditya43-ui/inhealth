<?php

/**
 * This is the model class for table "ttdelktronikpegawaisk_t".
 *
 * The followings are the available columns in table 'ttdelktronikpegawaisk_t':
 * @property integer $ttdelktronikpegawaisk_id
 * @property integer $pegawai_id
 * @property string $nomor_sk
 * @property string $tglberlaku_awal
 * @property string $tglberlaku_akhir
 * @property string $file_surat
 * @property string $path_file_surat
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai
 * @property string $update_loginpemakai
 * @property integer $create_petugaspengisi_id
 * @property integer $create_ruangan_id
 *
 * The followings are the available model relations:
 * @property PegawaiM $pegawai
 */
class TtdelktronikpegawaiskT extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ttdelktronikpegawaisk_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, nomor_sk, tglberlaku_awal, tglberlaku_akhir, path_file_surat, create_time, create_loginpemakai, update_loginpemakai', 'required'),
			array('pegawai_id, create_petugaspengisi_id, create_ruangan_id', 'numerical', 'integerOnly'=>true),
			array('nomor_sk, file_surat', 'length', 'max'=>200),
			array('create_loginpemakai, update_loginpemakai', 'length', 'max'=>100),
			array('update_time, file_surat', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ttdelktronikpegawaisk_id, pegawai_id, nomor_sk, tglberlaku_awal, tglberlaku_akhir, file_surat, path_file_surat, create_time, update_time, create_loginpemakai, update_loginpemakai, create_petugaspengisi_id, create_ruangan_id', 'safe', 'on'=>'search'),
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
			'ttdelktronikpegawaisk_id' => 'Ttdelktronikpegawaisk',
			'pegawai_id' => 'Pegawai',
			'nomor_sk' => 'No. SK Direktur',
			'tglberlaku_awal' => 'Tanggal Awal Berlaku Surat',
			'tglberlaku_akhir' => 'Tanggal Akhir Berlaku Surat',
			'file_surat' => 'File Surat',
			'path_file_surat' => 'Path File Surat',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_petugaspengisi_id' => 'Create Petugaspengisi',
			'create_ruangan_id' => 'Create Ruangan',
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

		$criteria->compare('ttdelktronikpegawaisk_id',$this->ttdelktronikpegawaisk_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('nomor_sk',$this->nomor_sk,true);
		$criteria->compare('tglberlaku_awal',$this->tglberlaku_awal,true);
		$criteria->compare('tglberlaku_akhir',$this->tglberlaku_akhir,true);
		$criteria->compare('file_surat',$this->file_surat,true);
		$criteria->compare('path_file_surat',$this->path_file_surat,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai,true);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai,true);
		$criteria->compare('create_petugaspengisi_id',$this->create_petugaspengisi_id);
		$criteria->compare('create_ruangan_id',$this->create_ruangan_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TtdelktronikpegawaiskT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getStatusAktif() {
            
            $tgl_awal = strtotime($this->tglberlaku_awal);
            $tgl_akhir = strtotime($this->tglberlaku_akhir);
            
            $sekarang = time();
            
            return $sekarang >= $tgl_awal && $sekarang <= $tgl_akhir;
            
            
        }
}
