<?php
use yii\web\JsExpression;
use xj\uploadify\Uploadify;
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'logo')->hiddenInput();
//显示上传图片的
echo $form->field($model,'imgFile')->fileInput();
if($model->logo){
    echo \yii\bootstrap\Html::img('http://img.yii2shop.com'.$model->logo,['id'=>'img_logo','height'=>100]);
}else{
    echo \yii\bootstrap\Html::img('',['style'=>'display:none','id'=>'img_logo','height'=>100]);
}

echo $form->field($model,'sort');
echo $form->field($model,'status')->inline()->radioList([1=>'显示',0=>'隐藏']);
echo \yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();