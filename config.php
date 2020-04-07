<?php 
//TB PREFIXE
$tbPrefixe = 'im24';

// DB ACESS
$hostname = "localhost";
$database = "name_banco";
$username = "name_user";
$password = "password_user";

//API moderatecontent
$apiKey = "864d4f8b1bfc56a979d2dc886cbea8aa";

//Current date and time
$time=date('Y-m-d H:i:s');

// You should set your time interval for which content check
$ptime=date('Y-m-d H:i:s',strtotime('-5 minute')); 

$domainStorage = 'https://ap.imagensbrasil.org/';
$domain = 'https://imagensbrasil.org/';

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