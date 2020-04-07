<?php 
//TB PREFIXE
$tbPrefixe = 'bd24_';

// DB ACESS
$hostname = "localhost";
$database = "name_banco";
$username = "name_user";
$password = "password_user";

//API moderatecontent
$apiKey = "this-key";

//Current date and time
$time=date('Y-m-d H:i:s');

// You should set your time interval for which content check
$ptime=date('Y-m-d H:i:s',strtotime('-5 minute')); 

$domainStorage = 'https://domain.com/';
$domain = 'https://domain.com/';

//Variaveis de template
$imageid = "";
$links = "";
$rating = "";
$search = "";
$imgmd = "";
$asize = "";
$imagedate = "";
$ipurl = "";
$ip = "";
$imageview = "";
$error = "FALSE";