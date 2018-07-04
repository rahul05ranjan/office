<?php
  $ch = curl_init(); 

  // set url 
  curl_setopt($ch, CURLOPT_URL, "http://18.220.184.192:3000/gettr/".$_GET['id']); 

  //return the transfer as a string 
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

  // $output contains the output string 
  $output = curl_exec($ch); 

  // close curl resource to free up system resources 
  curl_close($ch);
  // print_r(json_decode($output));

  $transcript_detail = json_decode($output);
//print_r($transcript_detail->data->studentdata->snama);
  ?>

  <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>form</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
  </head>
  <body>
  <div class="container">
    <div class="col-md-10 col-md-offset-1">
	   <div class="include">
	      <div class="">
		      <div class="Rasmi">
			     <div class="Transkrip">
				    Transkrip Rasmi
				 </div>
				 <div class="Transkrip1">
				    Transkrip Rasmi
				 </div>
			  </div>
			  <div class="col-md-7 col-md-offset-3">
			     <div class="UNIVERSITI1">
				 <img src="img/lo.PNG">
			      <h2>UNIVERSITI SAINS MALAYSIA</h2>
				  <p>Jalan UMS 88400 Kota Kinabalu, Sabah, malaysia</p>
				  </div>
			  </div>
			  <div class="col-md-6">
			  <div class="col-md-12">
			    <div class="col-md-6"><b>NAME</b> </div>   <div class="col-md-6">:<input type="text" value="<?php if($transcript_detail->data->studentdata->snama){ echo strtoupper($transcript_detail->data->studentdata->snama); } ?>" class="snama"></div>
				</div>
				<div class="col-md-12">
				<div class="col-md-6"><b>SEKOLAH</b></div>   <div class="col-md-6"> :<input type="text" value="<?php if($transcript_detail->data->studentdata->sseklom){ echo strtoupper($transcript_detail->data->studentdata->sseklom); } ?>" class="sseklom"></div>
				</div>
				<div class="col-md-12">
				<div class="col-md-6"><b>KOD PROGRAM</b></div>   <div class="col-md-6"> :<input type="text" value="<?php if($transcript_detail->data->studentdata->skidProgram){ echo strtoupper($transcript_detail->data->studentdata->skidProgram); } ?>" class="skidProgram"></div>
				</div>
				<div class="col-md-12">
				<div class="col-md-6"><b>NANA PROGRAM </b> </div>  <div class="col-md-6">:<input type="text" value="<?php if($transcript_detail->data->studentdata->snamaProgram){ echo strtoupper($transcript_detail->data->studentdata->snamaProgram); } ?>" class="snamaProgram"></div>
				</div>
			  </div>
			   <div class="col-md-6">
			  <div class="col-md-12">
			   <div class="col-md-6"> <b>NO KP/PASPOT </b></div>  <div class="col-md-6"> :<input type="text" value="<?php if($transcript_detail->data->studentdata->snoKpiaspot){ echo strtoupper($transcript_detail->data->studentdata->snoKpiaspot); } ?>" class="snoKpiaspot"></div>
				</div>
				<div class="col-md-12">
				<div class="col-md-6"><b>NO. PELAJAR </b> </div>  <div class="col-md-6">  :<input type="text" value="<?php if($transcript_detail->data->studentdata->snoPelajar){ echo strtoupper($transcript_detail->data->studentdata->snoPelajar); } ?>" class="snoPelajar"></div>
				</div>
				
			  </div>
			  <div class="col-md-12">
          <div id="kk">
            <div class="col-md-12">
              <?php //echo "<pre>"; print_r($transcript_detail->data->data); die(); ?>
              <?php if($transcript_detail->data->data){ foreach($transcript_detail->data->data as $tr){  ?>
                <table class="table">
                          <h3 class="SEMISTTER"><?php if($tr->semesterName){ echo $tr->semesterName; } ?> SESI <?php if($tr->sec){ echo $tr->sec; } ?></h3>
                          <div class="col-md-6 col-md-offset-3">
                          <p class="ONGS1"><div class="col-md-2"><b>pngs</b></div><div class="col-md-4">: <?php if($tr->pngk){ echo $tr->pngk; } ?></div>
                          <div class="col-md-2"><b>pngk</b></div><div class="col-md-4">: <?php if($tr->pngs){ echo $tr->pngs; } ?></div></P>
                          </div>
                  <thead>
                      <tr>
                      <th scope="col">XCVB</th>
                      <th scope="col">KURSUS</th>
                      <th scope="col">GRED</th>
                      <th scope="col">STATUS</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php if($tr->subjects){ foreach ($tr->subjects as $valsubject) { ?>
                      <tr>
                          <td><?php if($valsubject->sno){ echo $valsubject->sno; } ?></td>
                          <td><?php if($valsubject->subName){ echo $valsubject->subName; } ?></td>
                          <td><?php if($valsubject->grade){ echo $valsubject->grade; } ?></td>
                          <td><?php if($valsubject->status){ echo $valsubject->status; } ?></td>
                      </tr>
                      <?php }} ?>
                  </tbody>
                  </table>

              <?php }} ?>
			</div>
          </div>
  <div class="col-md-12">
  <div class="BO">
     <img src="img/BO.PNG">
  </div>
			  <div class="col-md-4">
			    <b>PURATA NILAI GRED KUMUATI </b></div><div class="col-md-8"> :<input type="text" value="2.71">
				</div>
				<div class="col-md-4">
				<b>DIANUGREKAN </b></div><div class="col-md-8"> :<input type="text" value="IJAZAH SARJANA MUDA SAINS DENGAN KEPUJIAN (TEKNOLOGI MULTMEDIA)" style="width: 293px;"></div>
				<div class="col-md-4">
				<b>KELAS</b></div><div class="col-md-8"> :<input type="text" value="DUI: II">
				</div>
				<ul class="Veriy">
				<li class="verified">Verified</li>
				</ul>
				<ul>
				<li><b>MEJ. (K) DATUK ABDULLAH HJ. MOHD. SAID</b></li>
				<li><b>PENDAFTAR</b></li>
				<li>UNIVERSITI SAINS MALAYSIA</li>
				<li>Tankh Cetak : 8October 2012</li>
				</ul>
			  </div>
			  </div>
		  </div>
	   </div>
	</div>
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>