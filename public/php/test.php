<?php

$date = "2024-05-30";

$hours = "12:30";

$completDate = $date . " " . $hours;    var_dump($completDate);

$completDate = DateTime::createFromFormat('Y-m-d H:i',$completDate);

var_dump($completDate);