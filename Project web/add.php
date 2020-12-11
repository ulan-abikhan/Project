<?php require "header.php"?>

<style type="text/css">
	.container {
		max-width: 1100px;
		margin: 0 auto;

		margin-top: 100px;
	}

	.border {
		border: 1px solid gray;

		margin: 10px 0 55px 0;

		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;

		padding: 15px;
	}

	select {
		font-size: 20px;
		cursor: pointer;
		width: 250px;
	}

	option {
		font-size: 20px;

		color: #222;
		cursor: pointer;

		width: 250px;
	}

	input {
		width: 250px;
	}

	.option_text:hover {
		cursor: pointer;
		background-color: #ed731d;
		color: white;
	}

	.error {
		border: 2px solid red;
	}

	.error:focus {
		border: 2px solid red;
	}

	.category {
		margin: 10px 0;
		font-size: 20px;
	}

	textarea {
		font-size: 20px;
	}

	.submit {
		width: auto;

		border: 1px solid #ed731d;
		background-color: #ed731d;
		color: white;
		border-radius: 50px;
    	padding: 5px 25px;

    	font-size: 20px;

    	cursor: pointer;
	}

	.submit_not {
		width: auto;

		border: 1px solid #ed731d;
		background-color: #ed731d;
		color: white;
		border-radius: 50px;
    	padding: 5px 25px;

    	font-size: 20px;

    	cursor: no-drop;
    	opacity: .5;

    	user-select: none;
	}

	.submit:hover {
		border-color: black;
		color: black;
	}

	.display_none {
		display: none;
	}
</style>

<title>
	Добавление товара
</title>

<div class="container">
	<form method="get">
		<?php
			if (isset($_GET['category'])) {
				$category = $_GET['category'];
				$category_id = 1;
				$price = $_GET['price'];
				$src = $_GET['src'];
				$about= $_GET['about'];
				$title = $_GET['title'];

				if ($category == 'Бургеры') {
					$category_id = 2;
				} else if ($category == 'Чизбургеры') {
					$category_id = 3;
				} else if ($category == 'Картофель фри') {
					$category_id = 4;
				} else if ($category == 'Хот-Дог') {
					$category_id = 5;
				} else if ($category == 'Напитки') {
					$category_id = 6;
				}
				$insert = mysqli_query($connection, "INSERT INTO `orders` (`id`, `category_id`, `title`, `about`, `price`, `img_src`) VALUES (NULL, '".$category_id."', '".$title."', '".$about."', '".$price."', '".$src."')");
				if ($insert) {
					$filter = mysqli_query($connection, "SELECT COUNT(`id`) FROM orders");
					$total = mysqli_fetch_row($filter);
					$total = $total[0];
					$filter = mysqli_query($connection, "SELECT count FROM filter WHERE id=".$category_id);
					$filter = mysqli_fetch_assoc($filter);
					$categoryCount = intval($filter['count'] . "");

					$res = mysqli_query($connection, "UPDATE filter SET count=".($categoryCount + 1)." WHERE name='".$category."'");
					$res = mysqli_query($connection, "UPDATE filter SET count=".$total." WHERE name='Вся продукция'");

					?>
					<script type="text/javascript">
						window.location.href = "/add.php";
					</script>
					<?php
				}
			}
		?>
		<div class="border">
			<select class="hover category" onclick="categorySelect(this)">
				<option>Выберите категорию</option>
				<option>Бургеры</option>
				<option>Чизбургеры</option>
				<option>Картофель фри</option>
				<option>Хот-Дог</option>
				<option>Напитки</option>
				<input id="category" type="hidden" name="category" value="">
			</select>
			<input onchange="selectTitle(this)" type="text" name="title" class="category product" placeholder="Название продукта">
			<input onchange="selectPrice(this)" class="category price" type="number" name="price" placeholder="Цена">
			<input onchange="selectSrc(this)" class="category src" type="text" name="src" placeholder="Ссылка на фото">
			<textarea onchange="selectAbout(this)" id="about" class="category about" rows="10" cols="40" placeholder="О товаре" value="" name="about"></textarea>
			<input class="submit display_none" type="submit" name="">
			<span class="submit_not">Отправить</span>
		</div>
	</form>
</div>

<script type="text/javascript">
	setInterval(isCorrect, 200);

	function categorySelect(argument) {
		let text = argument[argument.selectedIndex].text;
		if (text == "Выберите категорию") {
			argument.classList.add("error");
			document.querySelector("#category").value = "";
		}
		else {
			argument.classList.remove("error")
			document.querySelector("#category").value = text;
		}
	}

	function selectPrice(argument) {
		let text = argument.value;
		if (text == "" || text == "0") {
			argument.classList.add("error");
		} else {
			argument.classList.remove("error");
		}
	}

	function selectSrc(argument) {
		let text = argument.value;
		if (text == "") {
			argument.classList.add("error");
		} else {
			argument.classList.remove("error");
		}
	}

	function selectAbout(argument) {
		let text = argument.value;
		if (text == "") {
			argument.classList.add("error");
		} else {
			argument.classList.remove("error");
		}
	}

	function selectTitle(argument) {
		let text = argument.value;
		if (text == "") {
			argument.classList.add("error");
		} else {
			argument.classList.remove("error");
		}
	}

	function isCorrect() {
		let product = document.querySelector(".product").value;
		let category = document.querySelector("#category").value;
		let price = document.querySelector(".price").value;
		let src = document.querySelector(".src").value;
		let about = document.querySelector(".about").value;

		if (product != "" && (category != "" && category != "Вся продукция") && price != "" && src != "" && about != "") {
			document.querySelector(".submit").classList.remove("display_none");
			document.querySelector(".submit_not").classList.add("display_none");
		} else {
			document.querySelector(".submit").classList.add("display_none");
			document.querySelector(".submit_not").classList.remove("display_none");
		}
	}
</script>

<?php require "footer.php"?>