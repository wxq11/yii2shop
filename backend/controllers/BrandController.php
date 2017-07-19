<?php

namespace backend\controllers;

use backend\filters\AccessFilter;
use backend\models\Brand;
use Psr\Http\Message\UploadedFileInterface;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\UploadedFile;
use xj\uploadify\UploadAction;
use crazyfd\qiniu\Qiniu;

class BrandController extends Controller
{

    public function actionIndex()
    {

        //��ȡ���ݱ�������ģ�Ͷ���
        $query = Brand::find()->where(['>=','status',0]);
        //������
        $total = $query->count();
        $page = new Pagination([
            'totalCount'=>$total,
            'defaultPageSize'=>3,
        ]);
        $models = $query->orderBy('sort')->offset($page->offset)->limit($page->limit)->all();
        //������ͼ������ģ��
        return $this->render('index',['models'=>$models,'page'=>$page]);
    }

    /**
     * @���Ʒ��
     * @return string|\yii\web\Response
     */
    public function actionAdd(){
        //ʵ����Brandģ��
        $model = new Brand();
        //ʵ����request���
        $request = \Yii::$app->request;
        //����������ݳɹ�
        if($model->load($request->post())){
//            $model->imgFile = UploadedFile::getInstance($model,'imgFile');
            //��֤
            if($model->validate()){//��֤�ɹ�
                $model->imgFile = UploadedFile::getInstance($model,'imgFile');
                $dataPath = \Yii::getAlias('@data');
                $filePath = $dataPath.'/'.date('Y-m-d',time());//D:\phpStudy\WWW\yii2shop/data/2017-07-19/
                if(!is_dir($filePath)){
                    mkdir($filePath,0777,true);
                }
                $filename = uniqid(time()).'.'.$model->imgFile->getExtension();
                $imgPath = $filePath.'/'.$filename;
                //�ƶ�ͼƬ
                $model->imgFile->saveAs($imgPath);
                $model->logo = str_replace($dataPath,'',$imgPath);
                //����
                $model->save();
                //��ʾ
                \Yii::$app->session->setFlash('success','Ʒ����ӳɹ�');
                //��ת�б�
                return $this->redirect(['brand/index']);
            }else{//��֤ʧ��
                var_dump($model->getErrors());exit;
            }
        }
        //������ͼ������ģ��
        return $this->render('add',['model'=>$model]);
    }

    /**
     * @ɾ��Ʒ��
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDel($id){
        //����id��ȡģ�Ͷ���
        $model = Brand::findOne(['id'=>$id]);
        //ɾ��
        $model->status = -1;
        $model->save();
        //��ת�б�
        \Yii::$app->session->setFlash('success','Ʒ��ɾ���ɹ�');
        return $this->redirect(['brand/index']);
    }

    /**
     * ����״̬
     * @param $id
     * @return \yii\web\Response
     */
    public function actionState($id){

        //����id��ȡģ�Ͷ���
        $model = Brand::findOne(['id'=>$id]);
            if($model->status == 0){
                $model->status = 1;
            }else{
                $model->status = 0;
            }
        $model->save();
        //��ת�б�
        return $this->redirect(['brand/index']);
    }
    public function actionEdit($id){
        //����id��ȡģ�Ͷ���
        $model = Brand::findOne(['id'=>$id]);
        //ʵ����request���
        $request = \Yii::$app->request;
        //����������ݳɹ�
        if($model->load($request->post())){
//            $model->imgFile = UploadedFile::getInstance($model,'imgFile');
            //��֤
            if($model->validate()){//��֤�ɹ�

                //����
                $model->save();
                //��ʾ
                \Yii::$app->session->setFlash('success','Ʒ���޸ĳɹ�');
                //��ת�б�
                return $this->redirect(['brand/index']);
            }else{//��֤ʧ��
                var_dump($model->getErrors());exit;
            }
        }
        //������ͼ������ģ��
        return $this->render('add',['model'=>$model]);
    }

}
