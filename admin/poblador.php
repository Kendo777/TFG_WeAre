<?php
require_once("../mySqli.php");

$numGorros = 0;
$numGafas = 0;
$numPociones = 0;
$numArtefactos = 0;



$name = array("Gorro","Sombrero","Bombin");
$conjuntion = array("de","con");

$sustantive1 = array("Alicia","Costurero","Mecanico","Tecnico","Metalero","Cafe","Te","Vapor","Tren","Alquimia","Gotico","Bronce","Oro","Trapo","Fiesta", "Copa","Mujer","Hombre","Cuerda","Marinero","Ala ancha","Cuero","Terciopelo","Gato");

$sustantive2 = array("Orejas","Engranajes","Gafas","Reloj","Cartas","Plumas","Costuras","Lazo","Manchas","Balas","Cadenas","Hebillas","Pociones","Lupa","Velo","Pinchos","Encaje","Luz","Linterna","Cuernos","Agujeros");

$otro = array("","Grande","Gotico","Mediano","Elegante","Pobre","Noble","Plebe","Resulton","Sobresaliente","Negro","Marron","Rojo","Verde","Gris","Azul","Alto","Bajo","Viejo","Nuevo");

$material = array("Furr","Velvet","Leather","Felt");
$size = array("XS","S","XM","M","L","XL");

for ($i=0; $i <$numGorros; $i++) { 
  $itemName = $name[array_rand($name,1)];
  if(array_rand($conjuntion,1))
  {
    $itemName.=" ".$conjuntion[1];
    $itemName.=" ".$sustantive2[array_rand($sustantive2,1)];
  }
  else
  {
    $itemName.=" ".$conjuntion[0];
    $itemName.=" ".$sustantive1[array_rand($sustantive1,1)];
  }
  $itemName.=" ".$otro[array_rand($otro,1)];
  
  $prize = rand(1500,50000)/100;
  $extra = rand(0,1000)/100;
  if($extra<0.5)
  {
    $extra = 0;
  }
  $description = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";

  $stock = rand(1,30);

  $sql= $mySqli->prepare("INSERT INTO items(itemName, prize, description, stock, extra) VALUES (?,?,?,?,?)");
  $sql->bind_param("sdsid",$itemName,$prize,$description,$stock,$extra);
  $sql->execute();
  $itemId = $mySqli->insert_id;

  $sql = $mySqli->prepare("SELECT * FROM categories WHERE name='Hat'");
  $sql->execute();
  $result=$sql->get_result();
  $row=$result->fetch_assoc();
  $categoryId = $row['categoryId'];
    
  $sql= $mySqli->prepare("INSERT INTO classification(itemId, categoryId) VALUES (?,?)");
  $sql->bind_param("ii",$itemId,$categoryId);
  $sql->execute();


  $sql= $mySqli->prepare("SELECT subcategories.* FROM subcategories INNER JOIN categoriesrelation ON subcategories.subCategoryId=categoriesrelation.subCategoryId WHERE categoriesrelation.categoryId=?");
  $sql->bind_param("i",$categoryId);
  $sql->execute();
  $result=$sql->get_result();

  $numOfSubCat = rand(0,$result->num_rows);
  $pointers= array();
  for ($j=0; $j <$numOfSubCat ; $j++) 
  { 
      do
      {

        $num = rand(0,$result->num_rows-1);
      
      }while (in_array($num,$pointers));

      array_push($pointers, $num);

  }
  for($j=0; $j<$numOfSubCat; $j++)
  {
    $result->data_seek($pointers[$j]);
    $row=$result->fetch_assoc();
    $sql= $mySqli->prepare("INSERT INTO subclasification(itemId, subCategoryId) VALUES (?,?)");
    $sql->bind_param("ii",$itemId,$row['subCategoryId']);
    $sql->execute();
  }

  $sql= $mySqli->prepare("SELECT attributes.* FROM attributes WHERE attributes.categoryId=?");
  $sql->bind_param("i",$categoryId);
  $sql->execute();
  $result=$sql->get_result();
  $row=$result->fetch_assoc();

  $sql= $mySqli->prepare("INSERT INTO itemattribute(itemId, attributeId, value) VALUES (?,?,?)");
  $sql->bind_param("iis",$itemId,$row["attributeId"],$material[array_rand($material,1)]);
  $sql->execute();

  $row=$result->fetch_assoc();

  $sql= $mySqli->prepare("INSERT INTO itemattribute(itemId, attributeId, value) VALUES (?,?,?)");
  $sql->bind_param("iis",$itemId,$row["attributeId"],$size[array_rand($size,1)]);
  $sql->execute();
}


$name = array("Gafas","Lentes","Oculos");
$conjuntion = array("de","con");
$sustantive1 = array("Metal","Pasta","Vidrio","Soldador","Sol","Vision Nocturna","Vision","Espejo","Bronce","Cobre","Aviador");

$sustantive2 = array("Pinchos","Lupa","Engranajes","Lupas","Aumentos","Goma elastica","Cinta de cuero","Proteccion","Tornillos");

$otro = array("","Cristal Verde","Cristal Rojo","Cristal Azul","Cristal Negro","Cristal Arcoiris","Doradas","Plateadas","Mate","Cobre","Grandes","Pequeñas","Redondas","Cuadradas","Ajustadas","Todo en uno","Sin goma");

$glassColor = array("Black","Green","Red","Dark Blue","Bright Blue","Magenta","Rainbow");

for ($i=0; $i <$numGafas; $i++) 
{ 
  $itemName = $name[array_rand($name,1)];
  if(array_rand($conjuntion,1))
  {
    $itemName.=" ".$conjuntion[1];
    $itemName.=" ".$sustantive2[array_rand($sustantive2,1)];
  }
  else
  {
    $itemName.=" ".$conjuntion[0];
    $itemName.=" ".$sustantive1[array_rand($sustantive1,1)];
  }
  $itemName.=" ".$otro[array_rand($otro,1)];
  
  $prize = rand(1000,10000)/100;
  $extra = rand(0,5000)/100;
    if($extra<0.5)
  {
    $extra = 0;
  }
  $description = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";

  $stock = rand(1,30);

  $sql= $mySqli->prepare("INSERT INTO items(itemName, prize, description, stock, extra) VALUES (?,?,?,?,?)");
  $sql->bind_param("sdsid",$itemName,$prize,$description,$stock,$extra);
  $sql->execute();
  $itemId = $mySqli->insert_id;

  $sql = $mySqli->prepare("SELECT * FROM categories WHERE name='Glasses'");
  $sql->execute();
  $result=$sql->get_result();
  $row=$result->fetch_assoc();
  $categoryId = $row['categoryId'];
    
  $sql= $mySqli->prepare("INSERT INTO classification(itemId, categoryId) VALUES (?,?)");
  $sql->bind_param("ii",$itemId,$categoryId);
  $sql->execute();


  $sql= $mySqli->prepare("SELECT subcategories.* FROM subcategories INNER JOIN categoriesrelation ON subcategories.subCategoryId=categoriesrelation.subCategoryId WHERE categoriesrelation.categoryId=?");
  $sql->bind_param("i",$categoryId);
  $sql->execute();
  $result=$sql->get_result();

  $numOfSubCat = rand(0,$result->num_rows);
  $pointers= array();
  for ($j=0; $j <$numOfSubCat ; $j++) 
  { 
      do
      {

        $num = rand(0,$result->num_rows-1);
      
      }while (in_array($num,$pointers));

      array_push($pointers, $num);

  }
  for($j=0; $j<$numOfSubCat; $j++)
  {
    $result->data_seek($pointers[$j]);
    $row=$result->fetch_assoc();
    $sql= $mySqli->prepare("INSERT INTO subclasification(itemId, subCategoryId) VALUES (?,?)");
    $sql->bind_param("ii",$itemId,$row['subCategoryId']);
    $sql->execute();
  }

  $sql= $mySqli->prepare("SELECT attributes.* FROM attributes WHERE attributes.categoryId=?");
  $sql->bind_param("i",$categoryId);
  $sql->execute();
  $result=$sql->get_result();
  $row=$result->fetch_assoc();

  $sql= $mySqli->prepare("INSERT INTO itemattribute(itemId, attributeId, value) VALUES (?,?,?)");
  $sql->bind_param("iis",$itemId,$row["attributeId"],$glassColor[array_rand($material,1)]);
  $sql->execute();
}




$name = array("Pocion","Mejunje","Infusion","Pocima","Jarabe","Farmaco","Pocima","Remedio","Balsamo","Elixir","Tonico","Filtro","Fluido");
$conjuntion = array("","de");

$sustantive1 = array("Agudizadora de Ingenio","Alisadora","Amortentia","para Arpías","Chispeante","Crece-Huesos","Crece-Pelo","Doxycida","para Encoger","Envejecedora","Explosivo","Felix Felicis","Matalobos","Mopsus","Paz","Pimentónica");

$sustantive2 = array("Amor","Crecimiento","Envalsamar","Amarre","Engrasado","Euforia","Memoria","los Muertos en Vida","Olvido","Rue","Wiggenweld","Reliquia");

$ml = array("20","60","100","120","5","240");
$taste = array("Strawberry","Lime","Lemon","Sweet","Bitter","Acid","Rare","Bad");
$color = array("White","Black","Red","Yellow","Orange","Green","Blue","Cian","Pink");
$container = array("Pyramidal","Spherical","Bottle","Rectangular");
$ingridient = array("BAT wings","Spider legs","Toad's breath","Blood","Ginger","Coriandrum","Citrus","Crocus","Curcuma","Lavandula","Mentha","Rosmari");

for ($i=0; $i <$numPociones; $i++) 
{ 
  $itemName = $name[array_rand($name,1)];
  if(array_rand($conjuntion,1))
  {
    $itemName.=" ".$conjuntion[1];
    $itemName.=" ".$sustantive2[array_rand($sustantive2,1)];
  }
  else
  {
    $itemName.=" ".$conjuntion[0];
    $itemName.=" ".$sustantive1[array_rand($sustantive1,1)];
  }
  
  $prize = rand(500,7000)/100;
  $extra = rand(0,500)/100;
    if($extra<0.5)
  {
    $extra = 0;
  }
  $description = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";

  $stock = rand(1,30);

  $sql= $mySqli->prepare("INSERT INTO items(itemName, prize, description, stock, extra) VALUES (?,?,?,?,?)");
  $sql->bind_param("sdsid",$itemName,$prize,$description,$stock,$extra);
  $sql->execute();
  $itemId = $mySqli->insert_id;

  $sql = $mySqli->prepare("SELECT * FROM categories WHERE name='Potion'");
  $sql->execute();
  $result=$sql->get_result();
  $row=$result->fetch_assoc();
  $categoryId = $row['categoryId'];
    
  $sql= $mySqli->prepare("INSERT INTO classification(itemId, categoryId) VALUES (?,?)");
  $sql->bind_param("ii",$itemId,$categoryId);
  $sql->execute();


  $sql= $mySqli->prepare("SELECT subcategories.* FROM subcategories INNER JOIN categoriesrelation ON subcategories.subCategoryId=categoriesrelation.subCategoryId WHERE categoriesrelation.categoryId=?");
  $sql->bind_param("i",$categoryId);
  $sql->execute();
  $result=$sql->get_result();

  $numOfSubCat = rand(0,$result->num_rows);
  $pointers= array();
  for ($j=0; $j <$numOfSubCat ; $j++) 
  { 
      do
      {

        $num = rand(0,$result->num_rows-1);
      
      }while (in_array($num,$pointers));

      array_push($pointers, $num);

  }
  for($j=0; $j<$numOfSubCat; $j++)
  {
    $result->data_seek($pointers[$j]);
    $row=$result->fetch_assoc();
    $sql= $mySqli->prepare("INSERT INTO subclasification(itemId, subCategoryId) VALUES (?,?)");
    $sql->bind_param("ii",$itemId,$row['subCategoryId']);
    $sql->execute();
  }

  $sql= $mySqli->prepare("SELECT attributes.* FROM attributes WHERE attributes.categoryId=?");
  $sql->bind_param("i",$categoryId);
  $sql->execute();
  $result=$sql->get_result();
  $row=$result->fetch_assoc();

  $sql= $mySqli->prepare("INSERT INTO itemattribute(itemId, attributeId, value) VALUES (?,?,?)");
  $sql->bind_param("iis",$itemId,$row["attributeId"],$ml[array_rand($material,1)]);
  $sql->execute();

  $row=$result->fetch_assoc();

  $sql= $mySqli->prepare("INSERT INTO itemattribute(itemId, attributeId, value) VALUES (?,?,?)");
  $sql->bind_param("iis",$itemId,$row["attributeId"],$taste[array_rand($material,1)]);
  $sql->execute();

  $row=$result->fetch_assoc();

  $sql= $mySqli->prepare("INSERT INTO itemattribute(itemId, attributeId, value) VALUES (?,?,?)");
  $sql->bind_param("iis",$itemId,$row["attributeId"],$color[array_rand($material,1)]);
  $sql->execute();

  $row=$result->fetch_assoc();

  $sql= $mySqli->prepare("INSERT INTO itemattribute(itemId, attributeId, value) VALUES (?,?,?)");
  $sql->bind_param("iis",$itemId,$row["attributeId"],$container[array_rand($material,1)]);
  $sql->execute();

  $row=$result->fetch_assoc();

  $sql= $mySqli->prepare("INSERT INTO itemattribute(itemId, attributeId, value) VALUES (?,?,?)");
  $sql->bind_param("iis",$itemId,$row["attributeId"],$ingridient[array_rand($material,1)]);
  $sql->execute();
}

$name = array("","","Gun","Revolver","Mechanic Protesis","Gear","Rifle","Mechanism","Cane","Owl","Pet","Encrypt","Tesla","Root","Reloj");

for ($i=0; $i <$numArtefactos; $i++) {
  $itemName = $name[array_rand($name,1)]." ";
  $itemName.= chr(rand(65,90));
  $itemName.= chr(rand(65,90));
  if(rand(0,1))
  {
    $itemName.="-";
  }
  else
  {
    $itemName.=".";
  }
  $num = rand(1,4);
  for($j=0; $j<$num; $j++)
  {
    $itemName.=random_int(0, 9);
  }
  
  $prize = rand(1500,80000)/100;
  $extra = rand(0,2000)/100;
    if($extra<0.5)
  {
    $extra = 0;
  }
  $description = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";

  $stock = rand(1,30);

  $sql= $mySqli->prepare("INSERT INTO items(itemName, prize, description, stock, extra) VALUES (?,?,?,?,?)");
  $sql->bind_param("sdsid",$itemName,$prize,$description,$stock,$extra);
  $sql->execute();
  $itemId = $mySqli->insert_id;

  $sql = $mySqli->prepare("SELECT * FROM categories WHERE name='Gears and Artefacts'");
  $sql->execute();
  $result=$sql->get_result();
  $row=$result->fetch_assoc();
  $categoryId = $row['categoryId'];
    
  $sql= $mySqli->prepare("INSERT INTO classification(itemId, categoryId) VALUES (?,?)");
  $sql->bind_param("ii",$itemId,$categoryId);
  $sql->execute();


  $sql= $mySqli->prepare("SELECT subcategories.* FROM subcategories INNER JOIN categoriesrelation ON subcategories.subCategoryId=categoriesrelation.subCategoryId WHERE categoriesrelation.categoryId=?");
  $sql->bind_param("i",$categoryId);
  $sql->execute();
  $result=$sql->get_result();

  $numOfSubCat = rand(0,$result->num_rows);
  $pointers= array();
  for ($j=0; $j <$numOfSubCat ; $j++) 
  { 
      do
      {

        $num = rand(0,$result->num_rows-1);
      
      }while (in_array($num,$pointers));

      array_push($pointers, $num);

  }
  for($j=0; $j<$numOfSubCat; $j++)
  {
    $result->data_seek($pointers[$j]);
    $row=$result->fetch_assoc();
    $sql= $mySqli->prepare("INSERT INTO subclasification(itemId, subCategoryId) VALUES (?,?)");
    $sql->bind_param("ii",$itemId,$row['subCategoryId']);
    $sql->execute();
  }

  $sql= $mySqli->prepare("SELECT attributes.* FROM attributes WHERE attributes.categoryId=?");
  $sql->bind_param("i",$categoryId);
  $sql->execute();
  $result=$sql->get_result();
  $row=$result->fetch_assoc();

  $num = rand(1,20);
  $sql= $mySqli->prepare("INSERT INTO itemattribute(itemId, attributeId, value) VALUES (?,?,?)");
  $sql->bind_param("iis",$itemId,$row["attributeId"],$num);
  $sql->execute();
}
?>