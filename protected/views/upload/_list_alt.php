
<?php 
        $dir = Yii::app()->basePath.'/../uploads/';
        $clientdir = Yii::app()->basePath.'/../uploads/'. md5($upload->uploadClient->name . $upload->uploadClient->id) . '/';
?>
    
    <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'myModal'.$upload->id)); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4><?php echo $upload->filename; ?><br><small><?php echo ' filesize: '.$upload->file_size; ?></small></h4>
</div>
 
 
<div class="modal-body">
    <?php echo $imageUrl = CHtml::image($upload->getFilepath(), $upload->filename); ?>
</div>


 
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'primary',
        'label'=>'Download',
        'icon'=>'download white',
        'url'=>array('upload/download','id'=>$upload->id),
        //'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'info',
        'icon'=>'info-sign white',
        'label'=>'Info',
        'url'=>array('upload/view','id'=>$upload->id),
        //'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>

    
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'ajaxSubmit',
        'type'=>'danger',
        'label'=>'Delete',
        'icon'=>'remove white',
        'url'=>array('upload/delete','id'=>$upload->id),
        'htmlOptions'=>array('confirm'=>'This will remove the image. Are you sure?', 'data-dismiss'=>'modal'),
    )); ?>
    
 
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Close',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
    
</div>
 
<?php $this->endWidget(); ?>


<?php 
    $imageUrl = CHtml::image($upload->getFilepath(), $upload->filename, array('width'=>200,'height'=>180,'class'=>'thumbnail'));
                    echo CHtml::link($imageUrl, array('upload/view', 'id'=>$upload->id), array('data-toggle'=>'modal','data-target'=>'#myModal'.$upload->id));
?>

