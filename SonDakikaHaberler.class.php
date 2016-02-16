<?php
/**
* 	@author: Vehbi AKDOGAN
* 	@mail: mf.leqelyy@gmail.com || info@vehbiakdogan.com
* 	@website: vehbiakdogan.com
*/


class SonDakikaHaberler {
	
	
	private $sehir; // Girilecek İl
	private $gelenVeri; // Çektiğimiz Veriler
	private $verilerArray = array(); // göndereceğimiz jSon Veya Dizi Türünde Parametre
	private $haberDetayArray = array(); // göndereceğimiz jSon Veya Dizi Türünde Parametre
	
	

	
	/**
	* 
	* @param String $il
	* 
	* @void
	*/
	public function __construct($il){
		$this->sehir = $il;
			
		
	}
	
	private function HaberParcala(){
		
		$this->gelenVeri = GetContent("http://www.sondakika.com/".$this->EnCevir($this->sehir));
		if($this->gelenVeri === FALSE) {
			exit("Lütfen Geçerli Bir İl Giriniz.");
		}
		
		
		$i = 0;
		preg_match_all('#<ul class="news-list">(.*?)</ul>#si',$this->gelenVeri,$ulBlock);
		preg_match_all('#<li>(.*?)</li>#si',$ulBlock[1][0],$liBlock);
		foreach($liBlock[0] as $li) {
			preg_match_all('#<span class="date" title="(.*?)">(.*?)</span>#si',$li,$tarih);
	
			preg_match_all('#<img src="(.*?)" alt="(.*?)">#si',$li,$resim);
			
			preg_match_all('#<span class="title">(.*?)</span>#si',$li,$baslik);
			preg_match_all('#<span class="spot (.*?)">(.*?)</span>#si',$li,$icerik);
			
			preg_match_all('#<a href="(.*?)" class="content">(.*?)</a>#si',$li,$link);
			
			
			
			$resimYolu = isset($resim[1][0]) ? $resim[1][0] : "no_image.png";
			$url = isset($link[1][0]) ? strip_tags($link[1][0]) : "";
			
			$this->verilerArray[$i]["tarih"] = $tarih[1][0]; 
			$this->verilerArray[$i]["saat"] = $tarih[2][0]; 
			$this->verilerArray[$i]["resimYolu"] = $resimYolu; 
			$this->verilerArray[$i]["baslik"] = $baslik[1][0]; 
			$this->verilerArray[$i]["icerik"] = $icerik[2][0]; 
			$this->verilerArray[$i]["link"] =str_replace('" class="fr">','',$url) ; 
			
			$i++;
			
		}
		
		
	}
	
	/**
	* 
	* @param String $type
	* 
	* @param defaultType array
	* 
	* @param json,array,text
	* 
	* @return
	*/
	public function HaberGetir($type="array") {
		$this->HaberParcala();
		if($type == "json") {
			
			return json_encode($this->verilerArray);
			
		}else if($type == "text") {
			$metin="";
			foreach( $this->verilerArray as $veri) {
				
				$metin.=$veri["tarih"]."|".$veri["saat"]."|".$veri['resimYolu']."|".$veri['baslik']."|".$veri['icerik']."|".$veri['link']."==";
			}
			return $metin;
		}else {
			return $this->verilerArray;
		}
		
		
	}
	
	
	
	
	private function HaberDetayParcala($url){
		$veri = GetContent("http://sondakika.com".$url);
		
		if($veri === FALSE) {
			exit("Lütfen Geçerli Bir URL Giriniz.");
		}
		
		preg_match_all('#<h1 itemprop="headline">(.*?)</h1>#si',$veri,$baslik);
		preg_match_all('#<h2 itemprop="description" class="mt10">(.*?)</h2>#si',$veri,$aciklama);
		preg_match_all('#<span class="relase-date">(.*?)</span>#si',$veri,$saat);
		preg_match_all('#<img itemprop="image" src="(.*?)" id="haberResim" alt="(.*?)">#si',$veri,$resim);
		preg_match_all('#<div class="wrapper" itemprop="articleBody">(.*?)</div>#si',$veri,$haberIcerik);
		
			$resimYolu = isset($resim[1][0]) ? $resim[1][0] : "no_image.png";
			
			
			$this->haberDetayArray["baslik"] = $baslik[1][0]; 
			$this->haberDetayArray["aciklama"] = $aciklama[1][0]; 
			$this->haberDetayArray["icerik"] = $haberIcerik[1][0]; 
			$this->haberDetayArray["saat"] = $saat[1][0]; 
			$this->haberDetayArray["resimYolu"] = $resimYolu; 
			
			


		
		
	}
	
	
	
	
	/**
	* 
	* @param String $url
	* 
	* @param String $type
	* 
	* @param defaultType array
	* 
	* @param json,array,text
	* 
	* @return
	*/
	public function HaberDetayGetir($url, $type="array") {
		$this->HaberDetayParcala($url);
		if($type == "json") {
			
			return json_encode($this->haberDetayArray);
			
		}else if($type == "text") {
			$veri = $this->haberDetayArray;
			return $veri["baslik"]."|".$veri["aciklama"]."|".$veri['icerik']."|".$veri['saat']."|".$veri['resimYolu']."==";
			
		}else {
			return $this->haberDetayArray;
		}
		
		
	}
	
	
	
	
	
	
	/**
	* 
	* @param String $s
	* 
	* @return $s
	*/
	private function EnCevir($s) {
	    $tr = array('ş','Ş','ı','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç');
	    $eng = array('s','s','i','i','g','g','u','u','o','o','c','c');
	    $s = str_replace($tr,$eng,$s);
	    $s = strtolower($s);
	    $s = preg_replace('/&.+?;/', '', $s);
	    $s = preg_replace('/[^%a-z0-9 _-]/', '', $s);
	    $s = preg_replace('/\s+/', '-', $s);
	    $s = preg_replace('|-+|', '-', $s);
	    $s = trim($s, '-');
 
	    return $s;
	}

	
	private function GetContent($URL){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_URL, $URL);
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
	}
	
	
	
	
	
	
}

?>
