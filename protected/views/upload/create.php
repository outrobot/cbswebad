<?php
$this->breadcrumbs=array(
	$model->uploadClient->name=>array('client/view/' . $model->uploadClient->id),
	'Create',
); ?>

<div class="hero-unit"> 
    <h1><?php echo $model->formheader; ?></h1>
    <?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>