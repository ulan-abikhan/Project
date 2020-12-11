<?php require "header.php";?>

<style type="text/css">
		section {
			display: flex;
			margin: 0 auto;
			width: 90%;
		}

		.section_main {
			width: 100%;

			margin-top: 120px;

			display: flex;
			flex-wrap: wrap;
		}

		.span_img_content {
			height: 150px;
			display: flex; 
			justify-content: center; 
			border: 1px solid lightgray; 
			width: 100%;
		}

		.cards_img_content {
			width: 150px;
		}

		.cards {
			position: relative;

			width: 300px;

			margin: 0 10px;

			margin-bottom: 20px;

		}

		.about_card {
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			margin-top: 20px;
		}

		.price {
			position: absolute;
			top: 10px;
			left: 10px;
			z-index: 10;

			background-color: black;
			color: #fbba00;
			font-weight: 700;
			padding: 7px 13px;
			border: 1px solid black;
			border-radius: 5px;
		}

		.basket {
			width: 100%;
			display: flex;
			justify-content: center;

			user-select: none;

		}

		.to_basket {
			height: 40px;
			width: 50%;

			margin-top: 20px;

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

		@media (max-width: 727px) {
			.section_main {
				display: flex;
				flex-direction: column;
				align-items: center;
			}
		}
</style>

<section>
	<?php 
		$filter = mysqli_query($connection, "SELECT * FROM filter");
		$orders = mysqli_query($connection, "SELECT * FROM orders");
	?>

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
					<span class="to_basket" onclick="edit(this)">
						<input type="hidden" name="" value="<?php echo $res['id']?>">
						<img class="heart visible" style="width: 30px" src="images/whitepencil.png">
						<img class="heart hidden" style="width: 30px" src="images/blackpencil.png">
						<h6 style="margin-left: 10px; ">Редактировать</h6>
					</span>
				</div>
			</div>
		<?php } ?>
		</div>
</section>

<script type="text/javascript">
	function edit(arg) {
		window.location.href = "/element-edit.php?id=" + arg.querySelector("input").value;
	}
</script>

<?php require "footer.php"?>