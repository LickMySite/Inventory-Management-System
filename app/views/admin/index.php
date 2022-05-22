<?php

$this->view('admin/layout/head', $data);
$this->view('admin/layout/navbar', $data);
$this->view(isset($page) ? 'admin/page/'.$page : 'page/404', $data);
$this->view('admin/layout/footer', $data);