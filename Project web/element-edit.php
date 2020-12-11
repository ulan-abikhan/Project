<?php require "header.php"?>

<style type="text/css">
	section {
		margin: 0 auto;
		margin-top: 120px;
		width: 70%;

		border: 1px solid lightgray;
		padding: 20px;
		margin-bottom: 85px;
	}

	input[type="submit"] {
		height: 40px;

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

	.back:hover {
		color: #ed731d;
	}

	.about_edit_element {
		widows: 100%;
		display: flex;
		flex-direction: column;
	}


	.edit_elements {
		margin: 20px;
	}

	h1 {
		font-size: 20px;
	}

	.edit_btn {
		color: blue;
		font-size: 15px;
		margin-left: 15px;
		cursor: pointer;

		user-select: none;
	}

	.edit_btn:hover {
		color: black;
		text-decoration: underline;
	}

	.hidden_edit {
		display: none;
	}

</style>

	<?php
		if (isset($_GET['delete'])) {
			$delete = mysqli_query($connection, "DELETE FROM orders WHERE id=".$_GET['id']);
			//$delete = mysqli_query($connection, "DELETE FROM orders WHERE id=".$id);
			echo "<div style='margin: 324px 0; width: 100%; display: flex; justify-content: center;'><a style='font-size: 20px;'>Товар успешно удалено!<a/><a class='back' style='font-size: 20px; margin: 0 20px;' href='/edit.php'>Вернуться назад</a></div>";
			die();
		}
		if (isset($_GET['submit'])) {
			//echo "UPDATE orders SET title='".$_GET['title']."', about='".$_GET['about']."', price=".$_GET['price']." WHERE id=".$_GET['id'];
			$category_id = 2;
			if ($_GET['category'] == "Бургеры") {
				$category_id = 2;
			} else if ($_GET['category'] == "Чизбургеры") {
				$category_id = 3;
			}
			else if ($_GET['category'] == "Картофель фри") {
				$category_id = 4;
			}
			else if ($_GET['category'] == "Хот-Дог") {
				$category_id = 5;
			}
			else if ($_GET['category'] == "Напитки") {
				$category_id = 6;
			}
			$update = mysqli_query($connection, "UPDATE orders SET title='".$_GET['title']."', about='".$_GET['about']."', price=".$_GET['price'].", category_id=".$category_id." WHERE id=".$_GET['id']);
			echo "<div style='width:100%; display: flex; justify-content: center; margin-top: 20px;'><a style='color: green; font-size: 25px;'>Ваше объявление успешно сохранено</a></div>";
		}
		
		$id = $_GET['id'];
		$res = mysqli_query($connection, "SELECT * FROM orders WHERE id=".$id);
		$result = mysqli_fetch_assoc($res);
		$category_id = $result['category_id'];
		$category = mysqli_query($connection, "SELECT * FROM filter WHERE id=".$category_id);
		$category = mysqli_fetch_assoc($category);
	?>

	<title>Редактировать - <?php echo $result['title'];?></title>

<section>
	<div style="width: 250px;">
		<form method="get">
			<input class="delete_btn" type="submit" name="delete" value="Удалить товар">
			<input type="hidden" name="id" value="<?php echo $result['id']?>">
		</form>
		
	</div>
	<form method="get">
	<div class="about_edit_element">
		<span class="edit_elements">
			<h1>Название товара: </h1><?php echo $result['title']?><a class="edit_btn" onclick="openEditForm(this)"> Изменить</a>
			<div class="hidden_edit">
				<input type="" name="title" value="<?php echo $result['title']?>">
				<input type="hidden" name="id" value="<?php echo $result['id']?>">
			</div>
		</span>
		<span class="edit_elements">
			<h1>О товаре: </h1><?php echo $result['about'];?><a class="edit_btn" onclick="openEditForm(this)"> Изменить</a>
			<div class="hidden_edit">
				<textarea type="" name="about" value="" rows="10" cols="40"><?php echo $result['about'];?></textarea>
			</div>
		</span>
		<span class="edit_elements">
			<h1>Цена: </h1><?php echo $result['price'];?> KZT<a class="edit_btn" onclick="openEditForm(this)"> Изменить</a>
			<div class="hidden_edit">
				<input type="" name="price" value="<?php echo $result['price'];?>">
			</div>
		</span>
		<?php
			$all_category = mysqli_query($connection, "SELECT * FROM filter");
			$all_cate = mysqli_fetch_assoc($all_category);
		?>
		<span class="edit_elements">
			<h1>Категория: </h1><?php echo $category['name'];?><a class="edit_btn" onclick="openEditForm(this)"> Изменить</a>
			<div class="hidden_edit">
				<select onchange="select_cate()">
					<?php 
						while ( $all_res = mysqli_fetch_assoc($all_category) ) {
					?>
					<option><?php echo $all_res['name']?></option>
					<?php } ?>
				</select>
				<input id="category" type="hidden" name="category" value="<?php echo $category['name'];?>">
			</div>
		</span>

		<div>
			<span class="edit_elements">
				<input type="submit" name="submit" value="Сохранить">
			</span>
		</div>
	</div>
	</form>
</section>

<script type="text/javascript">
	function openEditForm(argument) {
		let div = argument.parentNode.querySelector("div").classList;
		if (div.contains("hidden_edit")) {
			argument.parentNode.querySelector("div").classList.remove("hidden_edit");
		} else {
			argument.parentNode.querySelector("div").classList.add("hidden_edit");
		}
	}

	function select_cate() {
		let text = document.querySelector("select");
		text = text[text.selectedIndex].text;
		document.querySelector("#category").value = text;
	}
</script>

<?php require "footer.php"?>