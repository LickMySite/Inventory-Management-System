<?php

$this->view('layout/head', $data);
$this->view('layout/navbar', $data);
$this->view(isset($page) ? 'page/'.$page : 'page/404', $data);
$this->view('layout/footer', $data);