<div class="container">
    <div class="caption">
        Index Page 111
    </div>
    <div class="content">
        <h3>SQ Hello World!1</h3>
        <pre><?= __FILE__; ?></pre>
    </div>
</div>
<?= $this->fetch('sq::index/product_data', [
    'id' => md5(__FILE__)
]); ?>
<?php $this->layout('max_shop::index'); ?>