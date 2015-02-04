<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'upload-form',
	'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>


	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->fileField($model,'file',array('class'=>'span5')); ?>
        
	<div>
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Upload' : 'Save',
		)); ?>
            
                <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'link',
			'type'=>'danger',
			'label'=>'Cancel',
                        'url'=>array('client/view','id'=>$model->uploadClient->id),
		)); ?>
	</div>

<?php $this->endWidget(); ?>