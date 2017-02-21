<?php
    use dosamigos\fileupload\FileUploadUI;
    // with UI
?>
<?= FileUploadUI::widget([
    'model' => $model,
    'attribute' => 'image',
    'url' => ['upload/imageupload'],
    'gallery' => false,
    'fieldOptions' => [
        'accept' => 'image/*',
    ],
    'clientOptions' => [
        'maxFileSize' => 2000000
    ],
    // ...
    'clientEvents' => [
        'fileuploaddone' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
        'fileuploadfail' => 'function(e, data) {
                                console.log(e);
                                console.log(data);
                            }',
    ],
]); ?>