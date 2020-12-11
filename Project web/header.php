<?php
	require "config.php";
?>

<style type="text/css">
	@import url('https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap');

	* {
		opacity: .5s;
	}

	body {
		margin: 0;
		padding: 0;
		font-family: 'Rubik';
	}

	h1, h2, h3, h4, h5, h6 {
		margin: 0;
	}

	a {
		text-decoration: none;
		color: black;
	}

	header {
		height: 70px;
		width: 100%;

		background-color: #222;

		left: 0;
		top: 10px;
		z-index: 1000;
	}

	.header_container {
		max-width: 800px;
		margin: 0 auto;
	}

	.header {
		height: 70px;

		display: flex;
		justify-content: space-between;
	}

	.nav {
		width: 33%;
		height: 100%;

		display: flex;
		align-items: center;
	}

	.header_a {
		text-transform: uppercase;

		color: white;

		transition: 1.5;

		margin-right: 20px;
	}

	.header_a:hover {
		color: #ed7825;
	}

	.header_a:last-child {
		margin-right: 0;
	}

	.header_img {
		width: 50px;

		cursor: pointer;
	}

	.header_logo {
		width: 50px;
		height: 70px;

		display: flex;
		justify-content: center;
		align-items: center;
	}

	.icon {
		width: 20px;
	}

	.right {
		display: flex;
		justify-content: flex-end;
	}

	.right_side {
		display: flex;
		justify-content: center;
		align-items: center;

		cursor: pointer;

		width: 32px;
		height: 32px;
		padding: 3px;
		border: 1px solid white;
		border-radius: 32px;
		background-color: white;

		margin: 0 5px;
	}

	.right_side:hover {
		border-color: #ed7825;
		background-color: #ed7825;

		transition: 1;
	}

	.basket_div {
		width: 100%;
		height: 100ch;
		margin: 0;

		display: none;

		background-color: white;

		color: black;

		position: absolute;
		top: -10px;
		left: 0;
		z-index: 2000;
	}

	.inner_basket {
		position: relative;

		width: 100%;
		height: 500px;

		margin-top: 70px;

		display: flex;
		flex-direction: column;
		align-items: center;
	}

	.empty_basket {
		margin-bottom: 50px;

		width: 150px;

		opacity: .1;
	}

	.close_btn {
		width: 35px;

		position: absolute;
		top: -40px;
		right: 20px;

		cursor: pointer;
	}

	.close_btn:hover {
		opacity: .5;
	}

	.basket_price {
		color: #ed731d;
		font-weight: 500;
		font-size: 13px;

		margin-top: 5px;
	}

	#basket_div {
		display: flex; 
		flex-direction: column;
	}

	#inner_basket_div {
		width: 450px; 
		display: flex; 
		justify-content: 
		space-between; 
		border-bottom: 1px solid black; 
		padding: 15px 0
	}

	@media (max-width: 550px) {
		#inner_basket_div {
			width: 250px;
		}
	}

	@media (max-width: 740px) {
		.header a {
			font-size: 12px;
		}

		.header {
			justify-content: space-between;
			padding: 0 10px;
		}

		.header_img {
			width: 32px;
		}

		.nav {
			width: 100px;
		}

		.right_side {
			width: 25px;
			height: 25px;
		}
	}
</style>

<header>
	<div class="header_container">
		<div class="header">
			<nav class="nav">
				<a href="/" class="header_a">Главная</a>
				<a href="/add.php" class="header_a">Добавить товар</a>
			</nav>
			<span class="header_logo">
				<img onclick="openMainMenu()" src="images/burger.png" class="header_img">
			</span>
			<nav class="nav right">
				<div style="display: flex; justify-content: space-between;">
					<span class="right_side" onclick="openBasket()">
						<img class="icon" src="images/cart.png">
					</span>
					<div class="basket_div">
						<div class="inner_basket">
							
						</div>
					</div>
					<span class="right_side" onclick="openEdit()">
						<img class="icon" src="images/blackpencil.png">
					</span>

				</div>
				
			</nav>
		</div>
	</div>
</header>

<script type="text/javascript">
	function openMainMenu() {
		window.location.href = "/";
	}

	function openEdit() {
		window.location.href = "/edit.php";
	}

	function openBasket() {
		document.querySelector('.inner_basket').innerHTML = "";
		document.querySelector('.basket_div').style.display = "inherit";

		let localJson = localStorage.getItem('basket');
		let template = `
			<img onclick="closeBasket()" class="close_btn" src="images/close.png">
		`;
		if (!localJson) {
			template += '<img class="empty_basket" src="images/shopping-bag.png"><h1 style="font-weight: 400; opacity: .4;">Ваша корзина пуста.</h1>';
		} else {
			template += "<div style='overflow: auto; padding-right: 20px; overflow-x: hidden'>"
			let orders = localStorage.getItem('basket');
			orders = JSON.parse(orders);

			let a = arrayCountValues(orders);
			let finish1 = [];
			let finish = [];
			
			for (let i = 0, v = 0; i < orders.length; i++) {
				if (!finish1.includes(orders[i]['title'])) {
					finish1[v] = orders[i]['title'];
					finish[v] = orders[i];
					v++;
				}
			}

			let total = 0;

			for (let i = 0; i < finish.length; i++) {
				total += parseInt(a[finish[i]['title']]) * parseInt(finish[i]['price']);
				template += `<div id="inner_basket_div">
								<div id="basket_div">
									<a class="asdf">` + finish[i]['title'] + `</a>
									<a class="basket_price">` + a[finish[i]['title']] + "x" + finish[i]['price'] + `₸</a>
								</div>
								<img onclick="deleteOrder(this)" style="width: 25px; height: 25px; cursor: pointer" src="images/delete.png">
							</div>`;
			}

			template += "</div><div style='width: 250px; display: flex; justify-content: space-between; padding: 15px 0; margin-top: 50px;'><a>Подытог:</a><a>" + total + "₸</a></div>"
		}

		document.querySelector('.inner_basket').innerHTML += template;
	}

	function arrayCountValues (arr) {
	    var v, freqs = {};

	    for (var i = arr.length; i--; ) { 
	        v = arr[i]['title'];
	        if (freqs[v]) freqs[v] += 1;
	        else freqs[v] = 1;
	    }
	    return freqs;
	}

	function closeBasket() {
		document.querySelector('.basket_div').style.display = "none";
	}

	function deleteOrder(img) {
		let a = img.parentNode.querySelector(".asdf").innerHTML;
		let localJSON = JSON.parse(localStorage.getItem("basket"));

		let arr = [];
		let count = 0;
		for (let i = 0; i < localJSON.length; i++) {
			if (localJSON[i]['title'] != a) {
				arr[count] = localJSON[i];
				count++;
			}
		}

		if (arr.length == 0) {
			localStorage.removeItem("basket");
		}
		else {
			localStorage.setItem("basket", JSON.stringify(arr));
		}

		openBasket();
	}
</script>