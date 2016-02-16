# SondakikaHaberler.class.php
Sondakika.com Haber Botu 


<a href="http://sondakika.com" target="_blank">Sondakika.com</a> Sitesinden il il son dakika haberlerini çekebilirsiniz. 

Kullanımı : 

```php
require_once("SonDakikaHaberler.class.php");
$veri = new SonDakikaHaberler("erzurum"); // erzuruma ait haberleri çek.

foreach($veri->HaberGetir("array") as $haber)
echo$haber['baslik'];
```

Methodlar: 

$this->HaberGetir($type) Haber başlıklarını ve içeriklerini liste halinde getiren methoddur. 1 parametre alır. bu parametre veriyi hangi türde almak istediğimizi belirler.
Default olarak array tipinde gönderilir. alabileceği değerler aray,json,text.

$this->HaberDetayGetir($url,$type) Habein tam içeriğini getiren methoddur. iki parametre alır. birinci parametre haberin linki ikinci parametre ise haber bilgilerinin hangi veri tipinde döndürüleceğidir.
Default olarak array tipinde gönderilir. alabileceği değerler aray,json,text.

<h1>KESİNLİKLE HABERLERİ KAYNAK GÖSTERMEDEN KULLANMAYINIZ. </h1>


