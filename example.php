<?php
//header("Content-type:application/json; charset=utf-8");
require_once("SonDakikaHaberler.class.php");

$veri = new SonDakikaHaberler("erzurum");

if(isset($_GET["link"]) && !empty($_GET["link"])) {
	// haber Detayı Çekelim.
	$haberDetayi = $veri->HaberDetayGetir($_GET["link"]);
	
	echo 'Kaynak: <a href="http://sondakika.com"> sondakika.com</a> <br/>
		Telif hakkı sorunu olmaması için haberleri kulanırken lütfen kaynak göstererek kullanınız. <br/>
		 
	';
	echo " <strong>Haber Başlık:</strong> ".$haberDetayi["baslik"];
	echo " <br/> <strong>Haber Açıklama: </strong> ".$haberDetayi["aciklama"];
	echo " <br/><strong>Haber Saati: </strong> ".$haberDetayi["saat"];
	echo " <br/><strong>Haber Resim Yolu: </strong> ".$haberDetayi["resimYolu"];
	echo " <br/><strong>Haber İcerik: </strong> ".$haberDetayi["icerik"];
	
	
	
}

foreach($veri->HaberGetir("array") as $haber)
echo '<a href="?link='.$haber['link'].'">'.$haber['baslik'].'</a><hr/>';




?>

<style type="text/css">
	
	a {
		color: #111;
		text-decoration: none;
		font-weight: bold;
	}
	a:hover {
		color: #f00;
	}
	
</style>
