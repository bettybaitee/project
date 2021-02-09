<?php

namespace app\controllers;

use app\models\JenisProses;
use app\models\ProsesPerolehan;
use Yii;
use app\models\MasterlistPero;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\KonfRujukan;

/**
 * MasterlistController implements the CRUD actions for MasterlistPero model.
 */
class MasterlistController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MasterlistPero models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MasterlistPero::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all MasterlistPero models.
     * @return mixed
     */
    public function actionIndexsub()
    {
        $qry = $sql = "SELECT * FROM masterlist_pero m WHERE m.perakuan_subkukp = 8 OR m.perakuan_subkukp = 7 OR m.perakuan_subkukp IS null";
        $dataProvider = new ActiveDataProvider([
            'query' => MasterlistPero::findBySql($qry),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all MasterlistPero models.
     * @return mixed
     */
    public function actionIndexsubw()
    {
        $qry = $sql = "SELECT * FROM masterlist_pero m WHERE m.perakuan_subw = 9 OR m.perakuan_subw = 7 OR m.perakuan_subw IS null";
        $dataProvider = new ActiveDataProvider([
            'query' => MasterlistPero::findBySql($qry),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all MasterlistPero models.
     * @return mixed
     */
    public function actionIndexksu()
    {
        $qry = $sql = "SELECT * FROM masterlist_pero m WHERE m.perakuan_ksu = 10 OR m.perakuan_ksu = 7 OR m.perakuan_ksu IS null";
        $dataProvider = new ActiveDataProvider([
            'query' => MasterlistPero::findBySql($qry),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all MasterlistPero models.
     * @return mixed
     */
    public function actionIndexurusetia()
    {
        $qry = $sql = "SELECT * FROM masterlist_pero m WHERE m.perakuan_ksu = 6";
        $dataProvider = new ActiveDataProvider([
            'query' => MasterlistPero::findBySql($qry),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all MasterlistPero models.
     * @return mixed
     */
    public function actionPukalsub()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MasterlistPero::find(),
        ]);

        return $this->render('pukalsub', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MasterlistPero model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MasterlistPero model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MasterlistPero();
        $model->status_id = '1';
        $model->created_at =  date('Y-m-d H:i:s');

        $mail_subjek = JenisProses::findOne($model->status_id);
        $message = $mail_subjek->mailSubjek;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if($model->save()) {
                /* log proses perolehan status where 22 = Permohonan Baharu
                */
                $proses_pero = new ProsesPerolehan();
                $proses_pero->pero_id = $model->id;
                $proses_pero->jenis_id = $model->status_id;
                $proses_pero->date_proses = date('Y-m-d');
                $proses_pero->staff_id = $model->staff_id;
                $proses_pero->save();

                /* send email to urusetia (w) untuk semakan
                */
                Yii::$app->mailer->compose('layouts/mailsemak_urusetia', ['model' => $model->id, 'message' => $message])
                    ->setFrom(Yii::$app->params['senderEmail'])
                    ->setTo(Yii::$app->params['subkukpEmail'])
                    ->setSubject($message)
                    ->send();

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MasterlistPero model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->status_id = '2';
        $model->updated_at = date('Y-m-d H:i:s');

        $mail_subjek = JenisProses::findOne($model->status_id);
        $message = $mail_subjek->mailSubjek;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if($model->save()) {
                /* log proses perolehan status where 22 = Permohonan Pindaan PPT
                */
                $proses_pero = new ProsesPerolehan();
                $proses_pero->pero_id = $model->id;
                $proses_pero->jenis_id = $model->status_id;
                $proses_pero->date_proses = date('Y-m-d');
                $proses_pero->staff_id = $model->staff_id;
                $proses_pero->save();

                /* send email to urusetia (w) untuk semakan
                */
                Yii::$app->mailer->compose('layouts/mail_semak', ['model' => $model->id, 'message' => $message])
                    ->setFrom(Yii::$app->params['senderEmail'])
                    ->setTo(Yii::$app->params['subkukpEmail'])
                    ->setSubject($message)
                    ->send();

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,

        ]);
    }

    /**
     * Updates an existing MasterlistPero model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionSubkukp($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $perakuan_subkukp = KonfRujukan::findOne($model->perakuan_subkukp);

            if ($perakuan_subkukp->rujukanNama == 'Setuju' ) {
                $mail_subjek = JenisProses::findOne(3);
                $message = $mail_subjek->mailSubjek;
                $jenisProses = '3';
                $tosender = Yii::$app->params['subwEmail'];
            }
            elseif ($perakuan_subkukp->rujukanNama == 'Tidak Setuju' ) {
                $mail_subjek = JenisProses::findOne(8);
                $message = $mail_subjek->mailSubjek;
                $jenisProses = '8';
                $tosender = Yii::$app->params['penyediaEmail'];
            }
            else {
                $mail_subjek = JenisProses::findOne(7);
                $message = $mail_subjek->mailSubjek;
                $jenisProses = '7';
                $tosender = Yii::$app->params['penyediaEmail'];
            }

            $model->status_id = $jenisProses;
            $model->updated_at = date('Y-m-d H:i:s');

            if($model->save()) {
                /* log proses perolehan status where 24 = Permohonan Baharu - Semakan SUBKUKP
                */

                $proses_pero = new ProsesPerolehan();
                $proses_pero->pero_id = $model->id;
                $proses_pero->jenis_id = $jenisProses;
                $proses_pero->date_proses = date('Y-m-d');
                $proses_pero->staff_id = '26'; //akan amik dr id login
                $proses_pero->catatan = $model->catatan_subkukp;
                $proses_pero->save();

                /* send email to sub (w) untuk semakan dan sokongan
                */
                Yii::$app->mailer->compose('layouts/mail_semak', ['model' => $model->id, 'message' => $message])
                    ->setFrom(Yii::$app->params['senderEmail'])
                    ->setTo($tosender)
                    ->setSubject($message)
                    ->send();

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('subkukp', [
            'model' => $model,

        ]);
    }

    /**
     * Updates an existing MasterlistPero model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionSubw($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $perakuan_subw = KonfRujukan::findOne($model->perakuan_subw);

            if ($perakuan_subw->rujukanNama == 'Sokong' ) {
                $mail_subjek = JenisProses::findOne(4);
                $message = $mail_subjek->mailSubjek;
                $jenisProses = '4';
                $tosender = Yii::$app->params['ksuEmail'];
            }
            elseif ($perakuan_subw->rujukanNama == 'Tidak Sokong' ) {
                $mail_subjek = JenisProses::findOne(9);
                $message = $mail_subjek->mailSubjek;
                $jenisProses = '9';
                $tosender = Yii::$app->params['penyediaEmail'];
            }
            else {
                $mail_subjek = JenisProses::findOne(7);
                $message = $mail_subjek->mailSubjek;
                $jenisProses = '7';
                $tosender = Yii::$app->params['penyediaEmail'];
            }

            $model->status_id = $jenisProses;
            $model->updated_at = date('Y-m-d H:i:s');

            if($model->save()) {
                /* log proses perolehan status where 24 = Permohonan Baharu - Semakan SUBKUKP
                */

                $proses_pero = new ProsesPerolehan();
                $proses_pero->pero_id = $model->id;
                $proses_pero->jenis_id = $jenisProses;
                $proses_pero->date_proses = date('Y-m-d');
                $proses_pero->staff_id = '23'; //akan amik dr id login
                $proses_pero->catatan = $model->catatan_subw;
                $proses_pero->save();

                /* send email to sub (w) untuk semakan dan sokongan
                */
                Yii::$app->mailer->compose('layouts/mail_semak', ['model' => $model->id, 'message' => $message])
                    ->setFrom(Yii::$app->params['senderEmail'])
                    ->setTo($tosender)
                    ->setSubject($message)
                    ->setCc(Yii::$app->params['urusetiaEmail'])
                    ->send();

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('subw', [
            'model' => $model,

        ]);
    }

    /**
     * Updates an existing MasterlistPero model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionKsu($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $perakuan_ksu = KonfRujukan::findOne($model->perakuan_ksu);

            if ($perakuan_ksu->rujukanNama == 'Lulus' ) {
                $mail_subjek = JenisProses::findOne(6);
                $message = $mail_subjek->mailSubjek;
                $jenisProses = '6';
                $tosender = Yii::$app->params['subwEmail'];
            }
            elseif ($perakuan_ksu->rujukanNama == 'Tidak Lulus' ) {
                $mail_subjek = JenisProses::findOne(10);
                $message = $mail_subjek->mailSubjek;
                $jenisProses = '10';
                $tosender = Yii::$app->params['penyediaEmail'];
            }
            else {
                $mail_subjek = JenisProses::findOne(7);
                $message = $mail_subjek->mailSubjek;
                $jenisProses = '7';
                $tosender = Yii::$app->params['penyediaEmail'];
            }

            $model->status_id = $jenisProses;
            $model->updated_at = date('Y-m-d H:i:s');

            if($model->save()) {
                /* log proses perolehan status where 24 = Permohonan Baharu - Semakan SUBKUKP
                */

                $proses_pero = new ProsesPerolehan();
                $proses_pero->pero_id = $model->id;
                $proses_pero->jenis_id = $jenisProses;
                $proses_pero->date_proses = date('Y-m-d');
                $proses_pero->staff_id = '25'; //akan amik dr id login
                $proses_pero->catatan = $model->catatan_ksu;
                $proses_pero->save();

                if ($proses_pero->jenis_id == 6 ) { //KSU luluskan automatik date AP168

                    $proses_pero = new ProsesPerolehan();
                    $proses_pero->pero_id = $model->id;
                    $proses_pero->jenis_id = 11;
                    $proses_pero->date_proses = date('Y-m-d');
                    $proses_pero->staff_id = '25'; //akan amik dr id login
                    $proses_pero->save();
                }

                /* send email to sub (w) untuk semakan dan sokongan
                */
                Yii::$app->mailer->compose('layouts/mail_semak', ['model' => $model->id, 'message' => $message])
                    ->setFrom(Yii::$app->params['senderEmail'])
                    ->setTo($tosender)
                    ->setCc(Yii::$app->params['urusetiaEmail'])
                    ->setSubject($message)
                    ->send();

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('ksu', [
            'model' => $model,

        ]);
    }

    /**
     * Updates an existing MasterlistPero model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUrusetia($id)
    {
        $model = $this->findModel($id);
        $model->status_id = '24';
        $model->updated_at = date('Y-m-d H:i:s');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if($model->save()) {
                /* log proses perolehan status where 24 = Permohonan Baharu - Semakan Urusetia
                */
                $proses_pero = new ProsesPerolehan();
                $proses_pero->pero_id = $model->id;
                $proses_pero->jenis_id = '24';
                $proses_pero->date_proses = date('Y-m-d');
                $proses_pero->staff_id = $model->staff_id;
                $proses_pero->save();

                /* send email to sub (w) untuk semakan
                */
                $message = 'PROMAS: Permohonan PPT telah disemak';
                Yii::$app->mailer->compose('layouts/mail_semak', ['model' => $model->id, 'message' => $message])
                    ->setFrom(Yii::$app->params['senderEmail'])
                    ->setTo(Yii::$app->params['subwEmail'])
                    ->setSubject($message)
                    ->send();

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,

        ]);
    }

    /**
     * Deletes an existing MasterlistPero model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MasterlistPero model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MasterlistPero the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterlistPero::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
