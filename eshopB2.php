<?php
session_start();
?>
<?php include('NavBar.php'); ?>

<h1 class="m-0 px-5 pt-3">Eshop</h1>

<?php $bdd = new PDO('mysql:host=localhost;dbname=Getflix;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); 

$id=$_SESSION['id_user'];
$sql = "SELECT * FROM commande WHERE id = $id";

$statement=$bdd->query($sql);
$result=$statement->fetchAll();

?>


<h3 class="px-5">Your personal information :</h3>


<?php


 echo "<section class='px-5'>" . "<b> Commmande au nom de : </b> " . $_POST['nom'] . " " . $_POST['prenom'] . "<br>" . "<b> Adresse de livraison: </b> " . $_POST['adresse'] . "</section>" . "</br>" . "<b> Email: </b> " . $_POST['email'] . "</section>" . "</br>";

 
 if ($_POST['codePromo']=="MikeEstTropCool" ){
  echo "<span class='px-5'> <b> REDUCTION 10% ACTIVÉ </b> </span>";
} else {
  echo "<span class='px-5'> <b> PAS DE REDUCTION </b> </span>" . "<br>";
} 
?>
 
<h3 class="px-5">Overview of your order</h3>

<table>
<tr>
<th class="pl-5">Id Film</th>
<th>Quantity</th>
<th>Price</th>
</tr>

<?php
$price =0;
$qty =0;
foreach($result as $row){
$qty += intval(($row['qty']));
$price += intval(($row['prix']));
?>

<tr>
<td class="pl-5"><?=$row['id_vid'];?></td>
<td><?=$row['qty'];?></td>
<td><?=$row['prix'];?></td>

<?php ;}?>

</tr>
</table>

<br>


<?php if ($qty>=5 && $_POST['codePromo']=="MikeEstTropCool"){
  
  echo "<p class='px-5'> 10% discount for your promoCode </p>". "<br>";
  echo "<p class='px-5'> 5% discount for 5 or more than 5 dvd or blue-ray bought. </p>". "<br>";
  echo "<p class='px-5'> Total price of your order : " . ($price-($price/100*15)) . "€ </p>";
}elseif($qty>=5){
  echo "<p class='px-5'> 5% discount for 5 or more than 5 dvd or blue-ray bought. </p>";
  echo "<p class='px-5'> Delivary cost : ".delivary()."€";
  echo "<p class='px-5'> Total price of your order : " . ($price-($price/100*5)+delivary()) . "€ </p>";
}elseif($_POST['codePromo']){
  echo "<p class='px-5'> 10% discount for your promoCode </p>". "<br>";
  echo "<p class='px-5'> Total price of your order : " . ($price-($price/100*10)) . "€ </p>";
}else{
  echo "<p class='px-5'> Delivary cost : ".delivary()."€";
  echo "<p class='px-5'> Total price of your order : " .($price + delivary())."€ </p>";
}
?>

 <form action="eshopC.php" method="post">
<div class="pl-5 py-3">

<a href="eshopC.php"><button >Confirm your order</button></a>
<input type="hidden" value="<?= $_POST['email']?>" name="email">
<input type="hidden" value="<?=$_POST['prenom']?>" name="prenom">
<input type="hidden" value="<?=$_POST['nom']?>" name="nom">
<input type="hidden" value="<?=$_POST['adresse']?>" name="adresse">
</form>
</div>






<?php include('footer.php'); ?>


<?php 

function delivary(){
  $delivary= 0;
if($_POST["select"]=="Belgium"){
  $delivary = 0;
}elseif($_POST["select"]=="EU"){
  $delivary = 2.5;
}else{
  $delivary = 5;
}
return $delivary;
}

?>