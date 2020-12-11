<?
	require "header.php";

	$id = $_GET['id'];
	$result = mysqli_query($connection, "SELECT * FROM orders WHERE id=".$id);
	$result = mysqli_fetch_assoc($result);
?>

<title><?echo $result['title'];?></title>

<style type="text/css">
  .big_image {
    width: 500px;
  }

  .img_section {
    width: 50%;

    display: flex;
    justify-content: center;
  }

  .about_section {
    width: 50%;
  }

  .main {
    max-width: 1300px;
    margin: auto;
    margin-top: 200px;

    display: flex;
    justify-content: space-between;
  }

  .title_section {
    font-weight: 700;
    font-size: 35px;
  }

  .price_section {
    font-size: 25px;
    font-weight: 700;
  }

  .basket {
    width: 400px;
    display: flex;
    margin-left: 35px;

    user-select: none;

    transition: 0.5s;
  }

  .to_basket {
    height: 40px;
    width: 50%;
    display: flex;
    justify-content: center;
    align-items: center;

    background-color: #ed731d;
    border: 1px solid #ed731d;
    border-radius: 50px;
    padding: 0 15px;

    font-size: 20px;
    text-transform: uppercase;
    cursor: pointer;

    color: white;

    transition: 0s;
  }

  .to_basket:hover {
    color: black;
    border-color: black;
  }

  .to_basket:hover .hidden {
    display: inherit;
  }

  .to_basket:hover .visible {
    display: none;
  }

  .hidden {
    display: none;
  }

  .visible {
    display: inherit;
  }

  .btn {
  	border: 1px solid #ed731d; 
  	padding: 5px 10px; 
  	border-radius: 20px; 
  	background-color: #ed731d; 
  	color: white; 
  	cursor: pointer
  }

  .count {
  	opacity: .7; 
  	margin: 0 10px; 
  	width: 30px; 
  	display: flex; 
  	justify-content: center;
  }

  .addToBasketDiv {
    display: flex; 
    align-items: center; 
    margin-top: 20px;
  }

  @media (max-width: 815px) {
    .main {
      flex-direction: column;
      align-items: center;

      margin: 20px 0;
    }

    .addToBasketDiv {
      flex-direction: column;
      align-items: center;
    }

    .basket {
      display: flex;
      justify-content: center;
      margin: 10px 0 0 0;
    }
  }
</style>

<div class="main">
  <div class="img_section">
    <img class="big_image" src="<?php echo $result['img_src'];?>" />
  </div>
  <div class="about_section">
    <div style="display: flex; flex-direction: column">
      <span class="title_section"><?php echo $result['title']?></span>
      <span class="about_order_section" style="margin: 30px 0; opacity: 0.7"
        ><?php echo $result['about']?></span
      >
      <span class="price_section"><?php echo $result['price']?>₸</span>
    </div>
    <div class="addToBasketDiv">
      <div style="font-weight: 700; user-select: none; width: 120px; display: flex; justify-content: space-between; align-items: center;">
        <span onclick="countMinus()" class="btn">-</span>
        <span class="count" style="">1</span>
        <span onclick="countPlus()" class="btn">+</span>
      </div>
      <div class="basket">
        <span class="to_basket" onclick="addBasket(this)">
          <img
            class="heart visible"
            style="width: 30px"
            src="images/whitebasket.png"
          />
          <img
            class="heart hidden"
            style="width: 30px"
            src="images/blackbasket.png"
          />
          <h6 style="margin-left: 10px">В корзину</h6>
        </span>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function addBasket(span) {
    let title = span.parentNode.parentNode.parentNode.querySelector(
      ".about_section .title_section"
    ).innerHTML;
    let price = span.parentNode.parentNode.parentNode.querySelector(
      ".about_section .price_section"
    ).innerHTML;
    price = price.replaceAll("\n", "");
    price = price.replaceAll("\t", "");
    price = price.replaceAll("₸", "");
    let json = { title: title, price: price };

    let localJson = localStorage.getItem("basket");
    if (!localJson) {
      localJson = [];
    } else {
      localJson = JSON.parse(localJson);
    }
    
    let count = parseInt(document.querySelector(".count").innerHTML);
    for (let i = 0; i < count; i++) {
    	localJson[localJson.length] = json;
    }

    localStorage.setItem("basket", JSON.stringify(localJson));
    document.querySelector(".count").innerHTML = 1;
  }

  function countPlus() {
  	let count = parseInt(document.querySelector(".count").innerHTML);
  	count++;
  	document.querySelector(".count").innerHTML = count;
  }

  function countMinus() {
  	let count = parseInt(document.querySelector(".count").innerHTML);
  	count--;
  	if (count == 0) count = 1;
  	document.querySelector(".count").innerHTML = count;
  }
</script>
<?php require "footer.php"?>