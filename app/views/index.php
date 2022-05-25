<?php

$this->view('layout/head', $data);
$this->view('layout/navbar', $data);
$this->view($page? "page/$page" :404,$data);
$this->view('layout/footer', $data);