<!DOCTYPE html>
<html>
<head>
	<title>Главная</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
	<?php require "header.php";?>
	

	<?php
		$filter = mysqli_query($connection, "SELECT * FROM filter");
		$orders = mysqli_query($connection, "SELECT * FROM orders");
		$burger_count = 0;
		$cheese_count = 0;
		$free_count = 0;
		$hot_count = 0;
		$drink_count = 0;
		$count = mysqli_query($connection, "SELECT * FROM orders");
		while ($coun = mysqli_fetch_assoc($count)) {
			if ($coun['category_id'] == 2) {
				$burger_count++;
			} else if ($coun['category_id'] == 3) {
				$cheese_count++;
			} else if ($coun['category_id'] == 4) {
				$free_count++;
			} else if ($coun['category_id'] == 5) {
				$hot_count++;
			} else if ($coun['category_id'] == 6) {
				$drink_count++;
			}
		}
		$total = $burger_count + $cheese_count + $free_count + $hot_count + $drink_count;
		$update = mysqli_query($connection, "UPDATE filter SET count = ".$total." WHERE id = 1");
		$update = mysqli_query($connection, "UPDATE filter SET count = ".$burger_count." WHERE id = 2");
		$update = mysqli_query($connection, "UPDATE filter SET count = ".$cheese_count." WHERE id = 3");
		$update = mysqli_query($connection, "UPDATE filter SET count = ".$free_count." WHERE id = 4");
		$update = mysqli_query($connection, "UPDATE filter SET count = ".$hot_count." WHERE id = 5");
		$update = mysqli_query($connection, "UPDATE filter SET count = ".$drink_count." WHERE id = 6");
	?>

	<section>
		<div class="section_filter">
			<h3 style="font-size: 25px;">Категории продукции</h3>
			<ul style="margin-top: 50px; font-size: 15px">

				<?php
					$res = mysqli_fetch_assoc($filter);
				?>
				<li class="li" style="" onclick="filter(this)">
					<a class="li_title li_title_selected">- <?php echo $res['name']; ?></a>
					<span class="li_count li_count_selected"><?php echo $res['count']?></span>
				</li>
				<?php
					while ( $res = mysqli_fetch_assoc($filter) ) {
				?>
				<li class="li" style="" onclick="filter(this)">
					<a class="li_title">- <?php echo $res['name']; ?></a>
					<span class="li_count"><?php echo $res['count']?></span>
				</li>
			<?php } ?>
			</ul>
		</div>
		<div class="section_main">
			<?php
			while ($res = mysqli_fetch_assoc($orders)) {
			?>
			<div class="cards">
				<span class="span_img_content">
					<img class="cards_img_content" src="<?php echo $res['img_src']; ?>">
				</span>
				<span class="about_card">
					<a href="element.php?id=<?php echo $res['id']?>" class="title" style="font-weight: 500; font-size: 18px"><?php echo $res['title'];?></a>
					<span style="width: 80%; display: flex; line-height: 1.5">
						<a style="margin-top: 10px; text-align: center; color: gray"><?php echo $res['about']?></a>
					</span>
				</span>
				<div class="price">
					<?php echo $res['price'];?>₸
				</div>
				<div class="basket">
					<span class="to_basket" onclick="addBasket(this)">
						<img class="heart visible" style="width: 30px" src="images/whitebasket.png">
						<img class="heart hidden" style="width: 30px" src="images/blackbasket.png">
						<h6 style="margin-left: 10px; ">В корзину</h6>
					</span>
				</div>
			</div>
		<?php } ?>
		</div>
	</section>

	<script type="text/javascript">
		let ul = document.querySelectorAll(".li");

		function filter(li) {
			document.querySelector(".section_main").innerHTML = "";
			let filterTitle = li.querySelector(".li_title").innerHTML;
			filterTitle = filterTitle.replace("- ", "");

			for (let i = 0; i < ul.length; i++) {
				ul[i].querySelector(".li_title").classList.remove("li_title_selected");
				ul[i].querySelector(".li_count").classList.remove("li_count_selected");
			}
			li.querySelector('.li_title').classList.add("li_title_selected");
			li.querySelector('.li_count').classList.add("li_count_selected");
			//================================================================
			fetch("fetch.php").then(data => data.text()).then(data => {

				let result = JSON.parse(data);

				if (filterTitle == 'Вся продукция') {
					for (let i = 0; i < result.length; i++) {
						document.querySelector(".section_main").innerHTML += `
							<div class="cards">
								<span class="span_img_content">
									<img class="cards_img_content" src="` + result[i]['img_src'] + `">
								</span>
								<span class="about_card">
									<a href="element.php?id=` + result[i]['id'] + `" class="title" style="font-weight: 500; font-size: 18px">` + result[i]['title'] + `</a>
									<span style="width: 80%; display: flex; line-height: 1.5">
										<a style="margin-top: 10px; text-align: center; color: gray">` + result[i]['about'] + `</a>
									</span>
								</span>
								<div class="price">
									` + result[i]['price'] + `₸
								</div>
								<div class="basket">
										<span class="to_basket" onclick="addBasket(this)">
											<img class="heart visible" style="width: 30px" src="images/whitebasket.png">
											<img class="heart hidden" style="width: 30px" src="images/blackbasket.png">
											<h6 style="margin-left: 10px">В корзину</h6>
										</span>
									</div>
							</div>
						`
					}
				} else if (filterTitle == 'Бургеры') {
					let index = 2;
					for (let i = 0; i < result.length; i++) {
						if (index == result[i]['category_id']) {
							document.querySelector(".section_main").innerHTML += `
								<div class="cards">
									<span class="span_img_content">
										<img class="cards_img_content" src="` + result[i]['img_src'] + `">
									</span>
									<span class="about_card">
										<a href="element.php?id=` + result[i]['id'] + `" class="title" style="font-weight: 500; font-size: 18px">` + result[i]['title'] + `</a>
										<span style="width: 80%; display: flex; line-height: 1.5">
											<a style="margin-top: 10px; text-align: center; color: gray">` + result[i]['about'] + `</a>
										</span>
									</span>
									<div class="price">
										` + result[i]['price'] + `₸
									</div>
									<div class="basket">
										<span class="to_basket" onclick="addBasket(this)">
											<img class="heart visible" style="width: 30px" src="images/whitebasket.png">
											<img class="heart hidden" style="width: 30px" src="images/blackbasket.png">
											<h6 style="margin-left: 10px">В корзину</h6>
										</span>
									</div>
								</div>
							`
						}
					}
				} else if (filterTitle == 'Чизбургеры') {
					let index = 3;
					for (let i = 0; i < result.length; i++) {
						if (index == result[i]['category_id']) {
							document.querySelector(".section_main").innerHTML += `
								<div class="cards">
									<span class="span_img_content">
										<img class="cards_img_content" src="` + result[i]['img_src'] + `">
									</span>
									<span class="about_card">
										<a href="element.php?id=` + result[i]['id'] + `" class="title" style="font-weight: 500; font-size: 18px">` + result[i]['title'] + `</a>
										<span style="width: 80%; display: flex; line-height: 1.5">
											<a style="margin-top: 10px; text-align: center; color: gray">` + result[i]['about'] + `</a>
										</span>
									</span>
									<div class="price">
										` + result[i]['price'] + `₸
									</div>
									<div class="basket">
										<span class="to_basket" onclick="addBasket(this)">
											<img class="heart visible" style="width: 30px" src="images/whitebasket.png">
											<img class="heart hidden" style="width: 30px" src="images/blackbasket.png">
											<h6 style="margin-left: 10px">В корзину</h6>
										</span>
									</div>
								</div>
							`
						}
					}
				} else if (filterTitle == 'Картофель фри') {
					let index = 4;
					for (let i = 0; i < result.length; i++) {
						if (index == result[i]['category_id']) {
							document.querySelector(".section_main").innerHTML += `
								<div class="cards">
									<span class="span_img_content">
										<img class="cards_img_content" src="` + result[i]['img_src'] + `">
									</span>
									<span class="about_card">
										<a href="element.php?id=` + result[i]['id'] + `" class="title" style="font-weight: 500; font-size: 18px">` + result[i]['title'] + `</a>
										<span style="width: 80%; display: flex; line-height: 1.5">
											<a style="margin-top: 10px; text-align: center; color: gray">` + result[i]['about'] + `</a>
										</span>
									</span>
									<div class="price">
										` + result[i]['price'] + `₸
									</div>
									<div class="basket">
										<span class="to_basket" onclick="addBasket(this)">
											<img class="heart visible" style="width: 30px" src="images/whitebasket.png">
											<img class="heart hidden" style="width: 30px" src="images/blackbasket.png">
											<h6 style="margin-left: 10px">В корзину</h6>
										</span>
									</div>
								</div>
							`
						}
					}
				} else if (filterTitle == 'Хот-Дог') {
					let index = 5;
					for (let i = 0; i < result.length; i++) {
						if (index == result[i]['category_id']) {
							document.querySelector(".section_main").innerHTML += `
								<div class="cards">
									<span class="span_img_content">
										<img class="cards_img_content" src="` + result[i]['img_src'] + `">
									</span>
									<span class="about_card">
										<a href="element.php?id=` + result[i]['id'] + `" class="title" style="font-weight: 500; font-size: 18px">` + result[i]['title'] + `</a>
										<span style="width: 80%; display: flex; line-height: 1.5">
											<a style="margin-top: 10px; text-align: center; color: gray">` + result[i]['about'] + `</a>
										</span>
									</span>
									<div class="price">
										` + result[i]['price'] + `₸
									</div>
									<div class="basket">
										<span class="to_basket" onclick="addBasket(this)">
											<img class="heart visible" style="width: 30px" src="images/whitebasket.png">
											<img class="heart hidden" style="width: 30px" src="images/blackbasket.png">
											<h6 style="margin-left: 10px">В корзину</h6>
										</span>
									</div>
								</div>
							`
						}
					}
				} else if (filterTitle == 'Напитки') {
					let index = 6;
					for (let i = 0; i < result.length; i++) {
						if (index == result[i]['category_id']) {
							document.querySelector(".section_main").innerHTML += `
								<div class="cards">
									<span class="span_img_content">
										<img class="cards_img_content" src="` + result[i]['img_src'] + `">
									</span>
									<span class="about_card">
										<a href="element.php?id=` + result[i]['id'] + `" class="title" style="font-weight: 500; font-size: 18px">` + result[i]['title'] + `</a>
										<span style="width: 80%; display: flex; line-height: 1.5">
											<a style="margin-top: 10px; text-align: center; color: gray">` + result[i]['about'] + `</a>
										</span>
									</span>
									<div class="price">
										` + result[i]['price'] + `₸
									</div>
									<div class="basket">
										<span class="to_basket" onclick="addBasket(this)">
											<img class="heart visible" style="width: 30px" src="images/whitebasket.png">
											<img class="heart hidden" style="width: 30px" src="images/blackbasket.png">
											<h6 style="margin-left: 10px">В корзину</h6>
										</span>
									</div>
								</div>
							`
						}
					}
				}
			});
		}
	</script>
	<script type="text/javascript">
		function addBasket(span) {
			let title = span.parentNode.parentNode.querySelector(".about_card .title").innerHTML;
			let price = span.parentNode.parentNode.querySelector(".price").innerHTML;
			price = price.replaceAll("\n", "");
			price = price.replaceAll("\t", "");
			price = price.replaceAll("₸", "");
			let json = {'title' : title, 'price' : price};

			let localJson = localStorage.getItem('basket');
			if (!localJson) {
				localJson = [];
			} else {
				localJson = JSON.parse(localJson);
			}
			localJson[localJson.length] = json;

			localStorage.setItem("basket", JSON.stringify(localJson));
		}
	</script>
	<?php require "footer.php"?>
</body>
</html>