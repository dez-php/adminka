<?php
/**
 * @var $this \Dez\Template\Core\Compiler
*/
$this->layout('index');
$this->setSection('header_menu', $this->fetch('shopper::common/header_menu'));
?>
<h1>Product Page #<?= $id ?></h1>