<?php
    include('./config.php');
    include('./dbconnectfile.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Moderation Auto detect Adult Content</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

        <style>
            .card img {
                object-fit: cover;
                object-position: 100% 0;
                width: 100%;
                height: 200px;
            }
            .url-adjust {
                word-wrap: break-word;
            }
        </style>
    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Moderation Auto detect Adult Content</h1>
                    <h2>Mod time <?php echo $time ?></h2>
                </div>
            </div>

            <div class="row">
                <?php 
                    if (mysqli_num_rows($result) > 0) {
                        while ($r = mysqli_fetch_array($result)) {
                        $find++;
                        $imageid = $r["image_id"];
                        $imagename = $r["image_name"];
                        $imageview = $r["image_views"];
                        $imagex = $r["image_extension"];
                        $ip = $r["image_uploader_ip"];
                        $storageMode = $r["image_storage_mode"];
                        $imagedate = $r["image_date"];
                        $size = $r["image_size"];
                        $storid = $r["image_storage_id"];
                        $dataAtual = date("d-m-Y", strtotime($imagedate));
                        $arrayData = explode("-", $dataAtual);
                        $dataDia = $arrayData[0];
                        $dataMes = $arrayData[1];
                        $dataAno = $arrayData[2];
                        $times = date("Y-m-d", strtotime($imagedate));
                        $timesp = explode('-', $times);
                        $search = $domain.'search/images/?as_q=&as_epq=%22' . $imagename . '%22&as_eq=&as_stor=' . $storid . '';  //Search link to find image by anme
                        
                        if ($storageMode == 'datefolder') {
                            $imgurl = $domainStorage.'images/' . $dataAno . '/' . $dataMes . '/' . $dataDia . '/' . $imagename . '.' . $imagex . ''; //Generate image URL for external storage server
                            $imgmd = $domainStorage.'images/' . $dataAno . '/' . $dataMes . '/' . $dataDia . '/' . $imagename . '.md.' . $imagex . ''; //Image URL for thimbnail
                        } else {
                            $imgurl = $domainStorage.'images/' . $imagename . '.' . $imagex . ''; //Generate image URL for external storage server
                            $imgmd = $domainStorage.'images/' . $imagename . '.md.' . $imagex . ''; //Image URL for thimbnail
                        }

                        $ipurl = $domain.'search/images/?as_ip=' . $ip . '';  //Search link to find all images uploaded by this IP
                        $asize = number_format($size / 1048576, 2) . ' MB';  //Convert image size to MB
                        
                        if ($size < '10485760') {
                            $links = 'https://www.moderatecontent.com/api/v2?key=' . $apiKey . '&url=' . $imgurl . '';
                        } else {
                            $links = 'https://www.moderatecontent.com/api/v2?key=' . $apiKey . '&url=' . $imgmd . '';
                        }

                        $file_get_contents = file_get_contents($links);
                        $parse = json_decode($file_get_contents);

                        if (empty($parse->error_code)) {

                            $rating = $parse->rating_label;
                            $teen = $parse->predictions->teen;
                            $everyone = $parse->predictions->everyone;
                            $adult = $parse->predictions->adult;

                            if ($rating === "everyone") {  //If the image is safe, remove NSFW tag
                                mysqli_query($link, "UPDATE im24_images SET image_nsfw='0' WHERE image_id='$imageid'") or die(mysql_error());
                            } else {
                                mysqli_query($link, "UPDATE im24_images SET image_nsfw='1' WHERE image_id='$imageid'") or die(mysql_error());
                            }

                ?>
                <div class="col-3">
                <div class="card">
                    <img src="<? echo $imgmd ?>" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Details Image</h5>
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Ranting: </strong> <? echo  $rating ?></li>
                            <li class="list-group-item"><strong>Size: </strong> <? echo  $asize ?></li>
                            <li class="list-group-item"><strong>Image Date: </strong> <? echo  $imagedate ?></li>
                            <li class="list-group-item"><strong>IP: </strong> <a href="<? echo $ipurl ?>" target="_blank"><? echo $ip ?></a></li>
                            <li class="list-group-item"><strong>Views: </strong> <? echo $imageview ?></li>
                        </ul>
                        <a href="<? echo $search ?>" target="_blank" class="btn btn-primary">Search Image</a>
                    </div>
                </div>
                </div>
                <?php } else { ?>
                <div class="col-3">
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Image Erro</h4>
                        <p>URL: <span class="url-adjust"><? echo $search ?></span></p>
                        <hr>
                        <p class="mb-0">Please correct the problem before continuing</p>
                    </div>
                </div>
                <?php } } } ?>
            </div>
        </div>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>