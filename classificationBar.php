
<div class="col-md-auto">
    <div class="classificationBar">
    <h7 style="color: red;"><a <?php 
    if(isset($categ))
        echo'href="index.php?page=shop&product='.$categ.'"';
    else
        echo'href="index.php?page=shop&search='.$_GET['search'].'"';
    ?>
    >Resset</a></h7>
    <h5>Order by:</h5><hr>
<form method="post" <?php echo 'action="index.php?'.$_SERVER['QUERY_STRING'].'"'; ?>>
  <select class="form-control" name="order">
    <option value="itemName">Name</option>
    <option value="prize">Prize</option>
  </select>
  <br>
  <input type="submit">
</form><hr>
<?php
if(isset($_GET["search"]))
{
    echo '<h5>Products</h5><hr>';
    $sqlAux= $mySqli->prepare("SELECT categories.* FROM categories ");
    $sqlAux->execute();
    $resultAux=$sqlAux->get_result();
    for($i=0; $i<$resultAux->num_rows; $i++)
        {
            $rowAux=$resultAux->fetch_assoc();
            if(strpos($_SERVER['QUERY_STRING'], '&product='.$rowAux['categoryId']) === false)
            {
                echo'<p><a href="index.php?'.$_SERVER['QUERY_STRING'].'&product='.$rowAux['categoryId'].'">'.$rowAux['name'].'</a></p>';
            }
            else
            {
                echo'<p class="selected"><a href="index.php?'.str_replace("&product=".$rowAux['categoryId'], '', $_SERVER['QUERY_STRING']).'">'.$rowAux['name'].'</a></p>';
            }
        }
}
?>
    <h5>Related categories</h5><hr>
<?php
require_once("mySqli.php");
if(isset($_POST['attributeClassifi']))
{
    if(strpos($_SERVER['QUERY_STRING'], "&classifi=".$_POST['attributeClassifi']) === false)
    {
        header("Location: index.php?".$_SERVER['QUERY_STRING']."&classifi=".$_POST['attributeClassifi']);
    }
    else
    {
        header("Location: index.php?".$_SERVER['QUERY_STRING']);
    }
}
if(isset($_POST['prize']))
{
    if(strpos($_SERVER['QUERY_STRING'], "&prize=".$_POST['prize']) === false)
    {
        header("Location: index.php?".$_SERVER['QUERY_STRING']."&prize=".$_POST['prize']);
    }
    else
    {
        header("Location: index.php?".$_SERVER['QUERY_STRING']);
    }
}
if(isset($_POST['shippment']))
{
    if(strpos($_SERVER['QUERY_STRING'], "&freeShippment") === false)
    {
        header("Location: index.php?".$_SERVER['QUERY_STRING']."&freeShippment");
    }
}
else if(isset($_POST['uncheck']))
{
    header("Location: index.php?".str_replace("&freeShippment", '', $_SERVER['QUERY_STRING'])."");
}

if(isset($_POST['order']))
{
    if(strpos($_SERVER['QUERY_STRING'],'&orderBy') === false)
    {
        header("Location: index.php?".$_SERVER['QUERY_STRING']."&orderBy=".$_POST['order']);
    }
    else
    {
        $get = mysql_fix_string($mySqli,$_GET['orderBy']);;
        header("Location: index.php?".str_replace("&orderBy=".$get, "&orderBy=".$_POST['order'], $_SERVER['QUERY_STRING'])."");
    }
}

    if(isset($categ))
    {
        $sqlAux= $mySqli->prepare("SELECT subcategories.* FROM subcategories INNER JOIN categoriesrelation ON subcategories.subCategoryId=categoriesrelation.subCategoryId WHERE categoriesrelation.categoryId=?");
        $sqlAux->bind_param("i",$categ);
    }
    else if(isset($_GET["search"]))
    {
        $sqlAux= $mySqli->prepare("SELECT subcategories.* FROM subcategories ");
    }
    $sqlAux->execute();
    $resultAux=$sqlAux->get_result();
    for($i=0; $i<$resultAux->num_rows; $i++)
        {
            $rowAux=$resultAux->fetch_assoc();
            if(strpos($_SERVER['QUERY_STRING'], '&subCategory='.$rowAux['subCategoryId']) === false)
            {
                echo'<p><a href="index.php?'.$_SERVER['QUERY_STRING'].'&subCategory='.$rowAux['subCategoryId'].'">'.$rowAux['name'].'</a></p>';
            }
            else
            {
                echo'<p class="selected"><a href="index.php?'.str_replace("&subCategory=".$rowAux['subCategoryId'], '', $_SERVER['QUERY_STRING']).'">'.$rowAux['name'].'</a></p>';
            }
        }
    echo "<hr>";
    echo '<form method="post" action="index.php?'.$_SERVER['QUERY_STRING'].'">
  <div class="form-group">
    <label for="formControlRange">Prize</label>
    <input type="range" name="prize" class="form-control-range"min="0" max="100" value="';
    if(isset($_GET['prize']) && is_numeric($_GET['prize']))
    {
        echo $_GET['prize'].'" onchange="updateTextInput(this.value)">
    <p id="textInput">'.$_GET['prize'].'$</p>';
    }
    else
    {
        echo '0" onchange="updateTextInput(this.value)">
    <p id="textInput">0$</p>';
    }
    echo '  </div>
   <input type="submit">
</form><hr>';

echo '<form method="post" action="index.php?'.$_SERVER['QUERY_STRING'].'">
<div class="custom-control custom-checkbox form-group">
  <input type="hidden" name="uncheck"/>
  <input type="checkbox" name="shippment" class="custom-control-input" id="ShippmentCheckbox" ';
  if(isset($_GET["freeShippment"]))
  {
    echo "checked";
  }
  echo '>
  <label class="custom-control-label" for="ShippmentCheckbox">Free Shippment</label><br>
</div>
  <input type="submit">
</form><hr>
<h4>Attributes</h4>';

    if(isset($categ))
    {
        $sqlAux= $mySqli->prepare("SELECT attributes.* FROM attributes WHERE attributes.categoryId=?");
        $sqlAux->bind_param("i",$categ);
    }
    else if(isset($_GET["search"]))
    {
        $sqlAux= $mySqli->prepare("SELECT attributes.* FROM attributes");
    }

    $sqlAux->execute();
    $resultAux=$sqlAux->get_result();
        for($i=0; $i<$resultAux->num_rows; $i++)
        {
            $rowAux=$resultAux->fetch_assoc();
            if(strpos($_SERVER['QUERY_STRING'], '&attribute='.$rowAux['attributeId']) === false)
            {
                echo'<hr><h5><a href="index.php?'.$_SERVER['QUERY_STRING'].'&attribute='.$rowAux['attributeId'].'">'.$rowAux['name'].'</a></h5>';
            }
            else
            {
                echo'<hr><h5 class="selected"><a href="index.php?'.str_replace("&attribute=".$rowAux['attributeId'], '', $_SERVER['QUERY_STRING']).'">'.$rowAux['name'].'</a></h5>';
            }
            $attId = $rowAux['attributeId'];
            $sqlAtt= $mySqli->prepare("SELECT DISTINCT value FROM itemattribute WHERE attributeId=? ORDER BY value");
            $sqlAtt->bind_param("i",$attId);
            $sqlAtt->execute();
            $resultAtt=$sqlAtt->get_result();
            for($j=0; $j<$resultAtt->num_rows; $j++)
            {
              $rowAtt=$resultAtt->fetch_assoc();
              if(strpos($_SERVER['QUERY_STRING'], '&classifi='.$rowAtt['value']) === false)
                {
                    echo'<p class="attribute"><a href="index.php?'.$_SERVER['QUERY_STRING'].'&classifi='.$rowAtt['value'].'">'.$rowAtt['value'].'</a></p>';
                }
                else
                {
                    echo'<p class="selected"><a href="index.php?'.str_replace("&classifi=".$rowAtt['value'], '', $_SERVER['QUERY_STRING']).'">'.$rowAtt['value'].'</a></p>';
                }
            }
        }
?>
</div>
</div>

