<?php

/**
 * This is the model class for table "kriteriamasukicu_t".
 *
 * The followings are the available columns in table 'kriteriamasukicu_t':
 * @property integer $kriteriamasukicu_id
 * @property integer $pendaftaran_id
 * @property integer $pasienadmisi_id
 * @property string $tanggal_pemeriksaan
 * @property string $petugas_pemeriksa
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai
 * @property integer $update_loginpemakai
 * @property integer $create_ruangan
 * @property string $statuskriteria
 * @property boolean $kardiovaskular_ismiokardinfark
 * @property boolean $kardiovaskular_iskardiogenik
 * @property boolean $kardiovaskular_isaritmiakompleks
 * @property boolean $kardiovaskular_ischfakut
 * @property boolean $kardiovaskular_ishipertensi
 * @property boolean $kardiovaskular_isanginapektoris
 * @property boolean $kardiovaskular_ispemulihan
 * @property boolean $kardiovaskular_istamponadejantung
 * @property boolean $kardiovaskular_isdiseksi
 * @property boolean $kardiovaskular_isblokjantung
 * @property boolean $kardiovaskular_issindromcoroner
 * @property boolean $kardiovaskular_isintraaorta
 * @property boolean $kardiovaskular_iskateter
 * @property boolean $kardiovaskular_isgagaljantung
 * @property boolean $kardiovaskular_islajujantung
 * @property boolean $respirasi_isgagalpernafasan
 * @property boolean $respirasi_isemboliparu
 * @property boolean $respirasi_isburukpernapasan
 * @property boolean $respirasi_ishemoptisis
 * @property boolean $respirasi_isgagalnapas
 * @property boolean $respirasi_isventilasi
 * @property boolean $respirasi_isobstruksi
 * @property boolean $respirasi_islajupernapasan
 * @property boolean $respirasi_isterapioksigen
 * @property boolean $respirasi_isinstabilitas
 * @property boolean $respirasi_isintubasi
 * @property boolean $gastrointestinal_ispendarahan
 * @property boolean $gastrointestinal_iskegagalanhati
 * @property boolean $gastrointestinal_ispankreatitis
 * @property boolean $gastrointestinal_isperforasi
 * @property boolean $gastrointestinal_isobstruksi
 * @property boolean $gastrointestinal_isabdomen
 * @property boolean $renal_isterapi
 * @property boolean $renal_isgagalginjal
 * @property boolean $renal_isproduksiurine
 * @property boolean $renal_isbersihankeratin
 * @property boolean $endokri_isketoasisdosis
 * @property boolean $endokri_isthyroidstorm
 * @property boolean $endokri_ishyperosmolar
 * @property boolean $endokri_ispermasalahanendokrin
 * @property boolean $endokri_ishipofosfatemia
 * @property boolean $endokri_ishipermagnesemia
 * @property boolean $endokri_iskalsiumserum
 * @property boolean $endokri_isnatriumserum
 * @property boolean $endokri_iskaliumserum
 * @property boolean $endokri_isglukosaserum
 * @property boolean $hematologi_ishemolisis
 * @property boolean $hematologi_istrombositopenia
 * @property boolean $hematologi_iskoagulopati
 * @property boolean $hematologi_isleukosit
 * @property boolean $sarafpusat_isstrokeakut
 * @property boolean $sarafpusat_iskoma
 * @property boolean $sarafpusat_ispendarahan
 * @property boolean $sarafpusat_isminingitis
 * @property boolean $sarafpusat_isgangguansistem
 * @property boolean $sarafpusat_isepileptikus
 * @property boolean $sarafpusat_iskematianotak
 * @property boolean $sarafpusat_isciderakepala
 * @property boolean $sarafpusat_iskejang
 * @property boolean $sarafpusat_iskelemahanotot
 * @property boolean $sarafpusat_isdelirium
 * @property boolean $sarafpusat_ismedullaspinalis
 * @property boolean $sarafpusat_iskraniotomi
 * @property boolean $sarafpusat_ispemantauan
 * @property boolean $sarafpusat_istekananintakranial
 * @property boolean $sarafpusat_isgcs
 * @property boolean $sepsis_isshock
 * @property boolean $sepsis_isshockseptik
 * @property boolean $sepsis_istekanandarah
 * @property boolean $sepsis_isasidosislaktat
 * @property boolean $pembedahan_ismonitoring
 * @property boolean $pembedahan_isperioperative
 * @property boolean $lukabakar_istrauma
 * @property boolean $lukabakar_istanpatraumakurang
 * @property boolean $lukabakar_istanpatraumalebih
 * @property boolean $lukabakar_ispascatraumabesar
 * @property boolean $lukabakar_ispascatraumakecil
 * @property boolean $kondisilain_iscidera
 * @property boolean $kondisilain_istrauma
 * @property boolean $kondisilain_ispengobatan
 * @property boolean $kondisilain_isgangguanreflek
 * @property boolean $kondisilain_isobatinfus
 * @property boolean $kondisilain_isdialisis
 * @property boolean $kondisilain_ismetabolik
 * @property boolean $kondisilain_iskehamilan
 * @property boolean $kondisilain_isgangguanmultiorgan
 * @property boolean $kondisilain_iseklampsia
 * @property boolean $kondisilain_isemboli
 */
class KriteriamasukicuT extends CActiveRecord
{
	public $renal_isterapi;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'kriteriamasukicu_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pendaftaran_id, tanggal_pemeriksaan, petugas_pemeriksa, create_time, create_loginpemakai, create_ruangan', 'required'),
			array('pendaftaran_id, pasienadmisi_id, create_loginpemakai, update_loginpemakai, create_ruangan', 'numerical', 'integerOnly'=>true),
			array('petugas_pemeriksa', 'length', 'max'=>100),
			array('statuskriteria', 'length', 'max'=>20),
			array('update_time, kardiovaskular_ismiokardinfark, kardiovaskular_iskardiogenik, kardiovaskular_isaritmiakompleks, kardiovaskular_ischfakut, kardiovaskular_ishipertensi, kardiovaskular_isanginapektoris, kardiovaskular_ispemulihan, kardiovaskular_istamponadejantung, kardiovaskular_isdiseksi, kardiovaskular_isblokjantung, kardiovaskular_issindromcoroner, kardiovaskular_isintraaorta, kardiovaskular_iskateter, kardiovaskular_isgagaljantung, kardiovaskular_islajujantung, respirasi_isgagalpernafasan, respirasi_isemboliparu, respirasi_isburukpernapasan, respirasi_ishemoptisis, respirasi_isgagalnapas, respirasi_isventilasi, respirasi_isobstruksi, respirasi_islajupernapasan, respirasi_isterapioksigen, respirasi_isinstabilitas, respirasi_isintubasi, gastrointestinal_ispendarahan, gastrointestinal_iskegagalanhati, gastrointestinal_ispankreatitis, gastrointestinal_isperforasi, gastrointestinal_isobstruksi, gastrointestinal_isabdomen, renal_isterapi, renal_isgagalginjal, renal_isproduksiurine, renal_isbersihankeratin, endokri_isketoasisdosis, endokri_isthyroidstorm, endokri_ishyperosmolar, endokri_ispermasalahanendokrin, endokri_ishipofosfatemia, endokri_ishipermagnesemia, endokri_iskalsiumserum, endokri_isnatriumserum, endokri_iskaliumserum, endokri_isglukosaserum, hematologi_ishemolisis, hematologi_istrombositopenia, hematologi_iskoagulopati, hematologi_isleukosit, sarafpusat_isstrokeakut, sarafpusat_iskoma, sarafpusat_ispendarahan, sarafpusat_isminingitis, sarafpusat_isgangguansistem, sarafpusat_isepileptikus, sarafpusat_iskematianotak, sarafpusat_isciderakepala, sarafpusat_iskejang, sarafpusat_iskelemahanotot, sarafpusat_isdelirium, sarafpusat_ismedullaspinalis, sarafpusat_iskraniotomi, sarafpusat_ispemantauan, sarafpusat_istekananintakranial, sarafpusat_isgcs, sepsis_isshock, sepsis_isshockseptik, sepsis_istekanandarah, sepsis_isasidosislaktat, pembedahan_ismonitoring, pembedahan_isperioperative, lukabakar_istrauma, lukabakar_istanpatraumakurang, lukabakar_istanpatraumalebih, lukabakar_ispascatraumabesar, lukabakar_ispascatraumakecil, kondisilain_iscidera, kondisilain_istrauma, kondisilain_ispengobatan, kondisilain_isgangguanreflek, kondisilain_isobatinfus, kondisilain_isdialisis, kondisilain_ismetabolik, kondisilain_iskehamilan, kondisilain_isgangguanmultiorgan, kondisilain_iseklampsia, kondisilain_isemboli', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('kriteriamasukicu_id, pendaftaran_id, pasienadmisi_id, tanggal_pemeriksaan, petugas_pemeriksa, create_time, update_time, create_loginpemakai, update_loginpemakai, create_ruangan, statuskriteria, kardiovaskular_ismiokardinfark, kardiovaskular_iskardiogenik, kardiovaskular_isaritmiakompleks, kardiovaskular_ischfakut, kardiovaskular_ishipertensi, kardiovaskular_isanginapektoris, kardiovaskular_ispemulihan, kardiovaskular_istamponadejantung, kardiovaskular_isdiseksi, kardiovaskular_isblokjantung, kardiovaskular_issindromcoroner, kardiovaskular_isintraaorta, kardiovaskular_iskateter, kardiovaskular_isgagaljantung, kardiovaskular_islajujantung, respirasi_isgagalpernafasan, respirasi_isemboliparu, respirasi_isburukpernapasan, respirasi_ishemoptisis, respirasi_isgagalnapas, respirasi_isventilasi, respirasi_isobstruksi, respirasi_islajupernapasan, respirasi_isterapioksigen, respirasi_isinstabilitas, respirasi_isintubasi, gastrointestinal_ispendarahan, gastrointestinal_iskegagalanhati, gastrointestinal_ispankreatitis, gastrointestinal_isperforasi, gastrointestinal_isobstruksi, gastrointestinal_isabdomen, renal_isterapi, renal_isgagalginjal, renal_isproduksiurine, renal_isbersihankeratin, endokri_isketoasisdosis, endokri_isthyroidstorm, endokri_ishyperosmolar, endokri_ispermasalahanendokrin, endokri_ishipofosfatemia, endokri_ishipermagnesemia, endokri_iskalsiumserum, endokri_isnatriumserum, endokri_iskaliumserum, endokri_isglukosaserum, hematologi_ishemolisis, hematologi_istrombositopenia, hematologi_iskoagulopati, hematologi_isleukosit, sarafpusat_isstrokeakut, sarafpusat_iskoma, sarafpusat_ispendarahan, sarafpusat_isminingitis, sarafpusat_isgangguansistem, sarafpusat_isepileptikus, sarafpusat_iskematianotak, sarafpusat_isciderakepala, sarafpusat_iskejang, sarafpusat_iskelemahanotot, sarafpusat_isdelirium, sarafpusat_ismedullaspinalis, sarafpusat_iskraniotomi, sarafpusat_ispemantauan, sarafpusat_istekananintakranial, sarafpusat_isgcs, sepsis_isshock, sepsis_isshockseptik, sepsis_istekanandarah, sepsis_isasidosislaktat, pembedahan_ismonitoring, pembedahan_isperioperative, lukabakar_istrauma, lukabakar_istanpatraumakurang, lukabakar_istanpatraumalebih, lukabakar_ispascatraumabesar, lukabakar_ispascatraumakecil, kondisilain_iscidera, kondisilain_istrauma, kondisilain_ispengobatan, kondisilain_isgangguanreflek, kondisilain_isobatinfus, kondisilain_isdialisis, kondisilain_ismetabolik, kondisilain_iskehamilan, kondisilain_isgangguanmultiorgan, kondisilain_iseklampsia, kondisilain_isemboli', 'safe', 'on'=>'search'),
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
			'pendaftaran' => array(self::BELONGS_TO, 'PendaftaranT', 'pendaftaran_id'),
			'pasienadmisi' => array(self::BELONGS_TO, 'PasienadmisiT', 'pasienadmisi_id'),
			'kriteriamasukicudetTs' => array(self::HAS_MANY, 'KriteriamasukicudetT', 'kriteriamasukicu_id'),


		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kriteriamasukicu_id' => 'Kriteriamasukicu',
			'pendaftaran_id' => 'Pendaftaran',
			'pasienadmisi_id' => 'Pasienadmisi',
			'tanggal_pemeriksaan' => 'Tanggal Pemeriksaan',
			'petugas_pemeriksa' => 'Petugas Pemeriksa',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
			'create_loginpemakai' => 'Create Loginpemakai',
			'update_loginpemakai' => 'Update Loginpemakai',
			'create_ruangan' => 'Create Ruangan',
			'statuskriteria' => 'Statuskriteria',
			'kardiovaskular_ismiokardinfark' => 'Kardiovaskular Ismiokardinfark',
			'kardiovaskular_iskardiogenik' => 'Kardiovaskular Iskardiogenik',
			'kardiovaskular_isaritmiakompleks' => 'Kardiovaskular Isaritmiakompleks',
			'kardiovaskular_ischfakut' => 'Kardiovaskular Ischfakut',
			'kardiovaskular_ishipertensi' => 'Kardiovaskular Ishipertensi',
			'kardiovaskular_isanginapektoris' => 'Kardiovaskular Isanginapektoris',
			'kardiovaskular_ispemulihan' => 'Kardiovaskular Ispemulihan',
			'kardiovaskular_istamponadejantung' => 'Kardiovaskular Istamponadejantung',
			'kardiovaskular_isdiseksi' => 'Kardiovaskular Isdiseksi',
			'kardiovaskular_isblokjantung' => 'Kardiovaskular Isblokjantung',
			'kardiovaskular_issindromcoroner' => 'Kardiovaskular Issindromcoroner',
			'kardiovaskular_isintraaorta' => 'Kardiovaskular Isintraaorta',
			'kardiovaskular_iskateter' => 'Kardiovaskular Iskateter',
			'kardiovaskular_isgagaljantung' => 'Kardiovaskular Isgagaljantung',
			'kardiovaskular_islajujantung' => 'Kardiovaskular Islajujantung',
			'respirasi_isgagalpernafasan' => 'Respirasi Isgagalpernafasan',
			'respirasi_isemboliparu' => 'Respirasi Isemboliparu',
			'respirasi_isburukpernapasan' => 'Respirasi Isburukpernapasan',
			'respirasi_ishemoptisis' => 'Respirasi Ishemoptisis',
			'respirasi_isgagalnapas' => 'Respirasi Isgagalnapas',
			'respirasi_isventilasi' => 'Respirasi Isventilasi',
			'respirasi_isobstruksi' => 'Respirasi Isobstruksi',
			'respirasi_islajupernapasan' => 'Respirasi Islajupernapasan',
			'respirasi_isterapioksigen' => 'Respirasi Isterapioksigen',
			'respirasi_isinstabilitas' => 'Respirasi Isinstabilitas',
			'respirasi_isintubasi' => 'Respirasi Isintubasi',
			'gastrointestinal_ispendarahan' => 'Gastrointestinal Ispendarahan',
			'gastrointestinal_iskegagalanhati' => 'Gastrointestinal Iskegagalanhati',
			'gastrointestinal_ispankreatitis' => 'Gastrointestinal Ispankreatitis',
			'gastrointestinal_isperforasi' => 'Gastrointestinal Isperforasi',
			'gastrointestinal_isobstruksi' => 'Gastrointestinal Isobstruksi',
			'gastrointestinal_isabdomen' => 'Gastrointestinal Isabdomen',
			'renal_isterapi' => 'Renal Isterapi',
			'renal_isgagalginjal' => 'Renal Isgagalginjal',
			'renal_isproduksiurine' => 'Renal Isproduksiurine',
			'renal_isbersihankeratin' => 'Renal Isbersihankeratin',
			'endokri_isketoasisdosis' => 'Endokri Isketoasisdosis',
			'endokri_isthyroidstorm' => 'Endokri Isthyroidstorm',
			'endokri_ishyperosmolar' => 'Endokri Ishyperosmolar',
			'endokri_ispermasalahanendokrin' => 'Endokri Ispermasalahanendokrin',
			'endokri_ishipofosfatemia' => 'Endokri Ishipofosfatemia',
			'endokri_ishipermagnesemia' => 'Endokri Ishipermagnesemia',
			'endokri_iskalsiumserum' => 'Endokri Iskalsiumserum',
			'endokri_isnatriumserum' => 'Endokri Isnatriumserum',
			'endokri_iskaliumserum' => 'Endokri Iskaliumserum',
			'endokri_isglukosaserum' => 'Endokri Isglukosaserum',
			'hematologi_ishemolisis' => 'Hematologi Ishemolisis',
			'hematologi_istrombositopenia' => 'Hematologi Istrombositopenia',
			'hematologi_iskoagulopati' => 'Hematologi Iskoagulopati',
			'hematologi_isleukosit' => 'Hematologi Isleukosit',
			'sarafpusat_isstrokeakut' => 'Sarafpusat Isstrokeakut',
			'sarafpusat_iskoma' => 'Sarafpusat Iskoma',
			'sarafpusat_ispendarahan' => 'Sarafpusat Ispendarahan',
			'sarafpusat_isminingitis' => 'Sarafpusat Isminingitis',
			'sarafpusat_isgangguansistem' => 'Sarafpusat Isgangguansistem',
			'sarafpusat_isepileptikus' => 'Sarafpusat Isepileptikus',
			'sarafpusat_iskematianotak' => 'Sarafpusat Iskematianotak',
			'sarafpusat_isciderakepala' => 'Sarafpusat Isciderakepala',
			'sarafpusat_iskejang' => 'Sarafpusat Iskejang',
			'sarafpusat_iskelemahanotot' => 'Sarafpusat Iskelemahanotot',
			'sarafpusat_isdelirium' => 'Sarafpusat Isdelirium',
			'sarafpusat_ismedullaspinalis' => 'Sarafpusat Ismedullaspinalis',
			'sarafpusat_iskraniotomi' => 'Sarafpusat Iskraniotomi',
			'sarafpusat_ispemantauan' => 'Sarafpusat Ispemantauan',
			'sarafpusat_istekananintakranial' => 'Sarafpusat Istekananintakranial',
			'sarafpusat_isgcs' => 'Sarafpusat Isgcs',
			'sepsis_isshock' => 'Sepsis Isshock',
			'sepsis_isshockseptik' => 'Sepsis Isshockseptik',
			'sepsis_istekanandarah' => 'Sepsis Istekanandarah',
			'sepsis_isasidosislaktat' => 'Sepsis Isasidosislaktat',
			'pembedahan_ismonitoring' => 'Pembedahan Ismonitoring',
			'pembedahan_isperioperative' => 'Pembedahan Isperioperative',
			'lukabakar_istrauma' => 'Lukabakar Istrauma',
			'lukabakar_istanpatraumakurang' => 'Lukabakar Istanpatraumakurang',
			'lukabakar_istanpatraumalebih' => 'Lukabakar Istanpatraumalebih',
			'lukabakar_ispascatraumabesar' => 'Lukabakar Ispascatraumabesar',
			'lukabakar_ispascatraumakecil' => 'Lukabakar Ispascatraumakecil',
			'kondisilain_iscidera' => 'Kondisilain Iscidera',
			'kondisilain_istrauma' => 'Kondisilain Istrauma',
			'kondisilain_ispengobatan' => 'Kondisilain Ispengobatan',
			'kondisilain_isgangguanreflek' => 'Kondisilain Isgangguanreflek',
			'kondisilain_isobatinfus' => 'Kondisilain Isobatinfus',
			'kondisilain_isdialisis' => 'Kondisilain Isdialisis',
			'kondisilain_ismetabolik' => 'Kondisilain Ismetabolik',
			'kondisilain_iskehamilan' => 'Kondisilain Iskehamilan',
			'kondisilain_isgangguanmultiorgan' => 'Kondisilain Isgangguanmultiorgan',
			'kondisilain_iseklampsia' => 'Kondisilain Iseklampsia',
			'kondisilain_isemboli' => 'Kondisilain Isemboli',
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

		$criteria->compare('kriteriamasukicu_id',$this->kriteriamasukicu_id);
		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
		$criteria->compare('pasienadmisi_id',$this->pasienadmisi_id);
		$criteria->compare('tanggal_pemeriksaan',$this->tanggal_pemeriksaan,true);
		$criteria->compare('petugas_pemeriksa',$this->petugas_pemeriksa,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai',$this->create_loginpemakai);
		$criteria->compare('update_loginpemakai',$this->update_loginpemakai);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('statuskriteria',$this->statuskriteria,true);
		$criteria->compare('kardiovaskular_ismiokardinfark',$this->kardiovaskular_ismiokardinfark);
		$criteria->compare('kardiovaskular_iskardiogenik',$this->kardiovaskular_iskardiogenik);
		$criteria->compare('kardiovaskular_isaritmiakompleks',$this->kardiovaskular_isaritmiakompleks);
		$criteria->compare('kardiovaskular_ischfakut',$this->kardiovaskular_ischfakut);
		$criteria->compare('kardiovaskular_ishipertensi',$this->kardiovaskular_ishipertensi);
		$criteria->compare('kardiovaskular_isanginapektoris',$this->kardiovaskular_isanginapektoris);
		$criteria->compare('kardiovaskular_ispemulihan',$this->kardiovaskular_ispemulihan);
		$criteria->compare('kardiovaskular_istamponadejantung',$this->kardiovaskular_istamponadejantung);
		$criteria->compare('kardiovaskular_isdiseksi',$this->kardiovaskular_isdiseksi);
		$criteria->compare('kardiovaskular_isblokjantung',$this->kardiovaskular_isblokjantung);
		$criteria->compare('kardiovaskular_issindromcoroner',$this->kardiovaskular_issindromcoroner);
		$criteria->compare('kardiovaskular_isintraaorta',$this->kardiovaskular_isintraaorta);
		$criteria->compare('kardiovaskular_iskateter',$this->kardiovaskular_iskateter);
		$criteria->compare('kardiovaskular_isgagaljantung',$this->kardiovaskular_isgagaljantung);
		$criteria->compare('kardiovaskular_islajujantung',$this->kardiovaskular_islajujantung);
		$criteria->compare('respirasi_isgagalpernafasan',$this->respirasi_isgagalpernafasan);
		$criteria->compare('respirasi_isemboliparu',$this->respirasi_isemboliparu);
		$criteria->compare('respirasi_isburukpernapasan',$this->respirasi_isburukpernapasan);
		$criteria->compare('respirasi_ishemoptisis',$this->respirasi_ishemoptisis);
		$criteria->compare('respirasi_isgagalnapas',$this->respirasi_isgagalnapas);
		$criteria->compare('respirasi_isventilasi',$this->respirasi_isventilasi);
		$criteria->compare('respirasi_isobstruksi',$this->respirasi_isobstruksi);
		$criteria->compare('respirasi_islajupernapasan',$this->respirasi_islajupernapasan);
		$criteria->compare('respirasi_isterapioksigen',$this->respirasi_isterapioksigen);
		$criteria->compare('respirasi_isinstabilitas',$this->respirasi_isinstabilitas);
		$criteria->compare('respirasi_isintubasi',$this->respirasi_isintubasi);
		$criteria->compare('gastrointestinal_ispendarahan',$this->gastrointestinal_ispendarahan);
		$criteria->compare('gastrointestinal_iskegagalanhati',$this->gastrointestinal_iskegagalanhati);
		$criteria->compare('gastrointestinal_ispankreatitis',$this->gastrointestinal_ispankreatitis);
		$criteria->compare('gastrointestinal_isperforasi',$this->gastrointestinal_isperforasi);
		$criteria->compare('gastrointestinal_isobstruksi',$this->gastrointestinal_isobstruksi);
		$criteria->compare('gastrointestinal_isabdomen',$this->gastrointestinal_isabdomen);
		$criteria->compare('renal_isterapi',$this->renal_isterapi);
		$criteria->compare('renal_isgagalginjal',$this->renal_isgagalginjal);
		$criteria->compare('renal_isproduksiurine',$this->renal_isproduksiurine);
		$criteria->compare('renal_isbersihankeratin',$this->renal_isbersihankeratin);
		$criteria->compare('endokri_isketoasisdosis',$this->endokri_isketoasisdosis);
		$criteria->compare('endokri_isthyroidstorm',$this->endokri_isthyroidstorm);
		$criteria->compare('endokri_ishyperosmolar',$this->endokri_ishyperosmolar);
		$criteria->compare('endokri_ispermasalahanendokrin',$this->endokri_ispermasalahanendokrin);
		$criteria->compare('endokri_ishipofosfatemia',$this->endokri_ishipofosfatemia);
		$criteria->compare('endokri_ishipermagnesemia',$this->endokri_ishipermagnesemia);
		$criteria->compare('endokri_iskalsiumserum',$this->endokri_iskalsiumserum);
		$criteria->compare('endokri_isnatriumserum',$this->endokri_isnatriumserum);
		$criteria->compare('endokri_iskaliumserum',$this->endokri_iskaliumserum);
		$criteria->compare('endokri_isglukosaserum',$this->endokri_isglukosaserum);
		$criteria->compare('hematologi_ishemolisis',$this->hematologi_ishemolisis);
		$criteria->compare('hematologi_istrombositopenia',$this->hematologi_istrombositopenia);
		$criteria->compare('hematologi_iskoagulopati',$this->hematologi_iskoagulopati);
		$criteria->compare('hematologi_isleukosit',$this->hematologi_isleukosit);
		$criteria->compare('sarafpusat_isstrokeakut',$this->sarafpusat_isstrokeakut);
		$criteria->compare('sarafpusat_iskoma',$this->sarafpusat_iskoma);
		$criteria->compare('sarafpusat_ispendarahan',$this->sarafpusat_ispendarahan);
		$criteria->compare('sarafpusat_isminingitis',$this->sarafpusat_isminingitis);
		$criteria->compare('sarafpusat_isgangguansistem',$this->sarafpusat_isgangguansistem);
		$criteria->compare('sarafpusat_isepileptikus',$this->sarafpusat_isepileptikus);
		$criteria->compare('sarafpusat_iskematianotak',$this->sarafpusat_iskematianotak);
		$criteria->compare('sarafpusat_isciderakepala',$this->sarafpusat_isciderakepala);
		$criteria->compare('sarafpusat_iskejang',$this->sarafpusat_iskejang);
		$criteria->compare('sarafpusat_iskelemahanotot',$this->sarafpusat_iskelemahanotot);
		$criteria->compare('sarafpusat_isdelirium',$this->sarafpusat_isdelirium);
		$criteria->compare('sarafpusat_ismedullaspinalis',$this->sarafpusat_ismedullaspinalis);
		$criteria->compare('sarafpusat_iskraniotomi',$this->sarafpusat_iskraniotomi);
		$criteria->compare('sarafpusat_ispemantauan',$this->sarafpusat_ispemantauan);
		$criteria->compare('sarafpusat_istekananintakranial',$this->sarafpusat_istekananintakranial);
		$criteria->compare('sarafpusat_isgcs',$this->sarafpusat_isgcs);
		$criteria->compare('sepsis_isshock',$this->sepsis_isshock);
		$criteria->compare('sepsis_isshockseptik',$this->sepsis_isshockseptik);
		$criteria->compare('sepsis_istekanandarah',$this->sepsis_istekanandarah);
		$criteria->compare('sepsis_isasidosislaktat',$this->sepsis_isasidosislaktat);
		$criteria->compare('pembedahan_ismonitoring',$this->pembedahan_ismonitoring);
		$criteria->compare('pembedahan_isperioperative',$this->pembedahan_isperioperative);
		$criteria->compare('lukabakar_istrauma',$this->lukabakar_istrauma);
		$criteria->compare('lukabakar_istanpatraumakurang',$this->lukabakar_istanpatraumakurang);
		$criteria->compare('lukabakar_istanpatraumalebih',$this->lukabakar_istanpatraumalebih);
		$criteria->compare('lukabakar_ispascatraumabesar',$this->lukabakar_ispascatraumabesar);
		$criteria->compare('lukabakar_ispascatraumakecil',$this->lukabakar_ispascatraumakecil);
		$criteria->compare('kondisilain_iscidera',$this->kondisilain_iscidera);
		$criteria->compare('kondisilain_istrauma',$this->kondisilain_istrauma);
		$criteria->compare('kondisilain_ispengobatan',$this->kondisilain_ispengobatan);
		$criteria->compare('kondisilain_isgangguanreflek',$this->kondisilain_isgangguanreflek);
		$criteria->compare('kondisilain_isobatinfus',$this->kondisilain_isobatinfus);
		$criteria->compare('kondisilain_isdialisis',$this->kondisilain_isdialisis);
		$criteria->compare('kondisilain_ismetabolik',$this->kondisilain_ismetabolik);
		$criteria->compare('kondisilain_iskehamilan',$this->kondisilain_iskehamilan);
		$criteria->compare('kondisilain_isgangguanmultiorgan',$this->kondisilain_isgangguanmultiorgan);
		$criteria->compare('kondisilain_iseklampsia',$this->kondisilain_iseklampsia);
		$criteria->compare('kondisilain_isemboli',$this->kondisilain_isemboli);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}




	public function searchRiwayat()
	{
		$criteria=new CDbCriteria;

		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}

		if(!empty($this->create_ruangan)){
			$criteria->addCondition('create_ruangan = '.$this->create_ruangan);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return KriteriamasukicuT the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
