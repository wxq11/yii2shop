<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'sort');
echo $form->field($model,'status')->inline()->radioList([1=>'显示',0=>'隐藏']);
echo $form->field($model,'is_help')->inline()->radioList([1=>'帮助文档',0=>'普通文档']);
echo \yii\bootstrap\Html::submitInput('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();