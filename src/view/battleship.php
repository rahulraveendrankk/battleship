<!DOCTYPE html>
<html lang="en-US">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/src/view/main.css">
	<title>Battleship</title>
</head>

<body>
	<div id="board">
		<div id="messageArea"></div>
		<table>
			<tr>
				<th class="numbers"></th>
				<?php for ($i = 0; $i < $this->boardSizeCol; $i++) {  ?>
					<th class="numbers"><?php echo $i; ?></th>
				<?php } ?>
			</tr>
			<?php
			$lettNum = 0;
			foreach (range('A', 'Z') as $letter) {
				if ($lettNum < $this->boardSizeRow) { ?>
					<tr>
						<th class="letters"> <?php echo $letter; ?></th>
						<?php for ($i = 0; $i < $this->boardSizeCol; $i++) {  ?>
							<td>
								<div id="<?php echo $lettNum . $i;  ?>"></div>
							</td>
						<?php  }  ?>
					</tr>
			<?php $lettNum++;
				}
			} ?>
		</table>
	</div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- <script src="/src/view/battleship.js" ships="<?php print_r($ships); ?>"  numShips="<?php echo $numShips; ?>" shipLength="<?php echo $shipLength; ?>"></script> -->
	<script type="text/javascript">
		var numShips = '<?php echo $this->numShips ?>';
		var shipLength = '<?php echo $this->shipLength ?>';
		var ships = '<?php echo $ships ?>';

		var model = {
			numShips: parseInt(numShips),
			shipLength: parseInt(shipLength),
			shipsSunk: 0,
			ships: JSON.parse(ships),

			fire: function(guess) {
				for (var i = 0; i < this.numShips; i++) {
					var ship = this.ships[i];
					var index = ship.locations.indexOf(guess); // it searches the arrays for guess and returns the index
					if (ship.hits[index] === "hit") {
						view.displayMessage("You hit this ship before.");
						return true;
					} else if (index >= 0) {
						ship.hits[index] = "hit";
						view.displayHit(guess);
						view.displayMessage("It's a hit!");

						if (this.isSunk(ship)) {
							view.displayMessage("You sunk a battleship!");
							this.shipsSunk++;

							if (this.shipsSunk === this.numShips) {
								var audio3 = new Audio('/src/view/files/sunk all ships.mp3');
								audio3.play();
							} else {
								var audio2 = new Audio('/src/view/files/sunk one ship.mp3');
								audio2.play();
							}

						} else {
							var audio1 = new Audio('/src/view/files/hit.mp3');
							audio1.play();
						}
						return true;
					}
				}
				view.displayMiss(guess);
				view.displayMessage("It's a miss!");
				return false;
			},

			isSunk: function(ship) {
				for (i = 0; i < this.shipLength; i++) {
					if (ship.hits[i] !== "hit") {
						return false;
					}
				}
				return true;
			}
		};

		var view = {
			displayMessage: function(msg) {
				var messageArea = document.getElementById("messageArea");
				messageArea.innerHTML = msg;
			},

			displayHit: function(location) {
				var cell = document.getElementById(location);
				cell.setAttribute("class", "hit");

			},

			displayMiss: function(location) {
				var cell = document.getElementById(location);
				cell.setAttribute("class", "miss");
			}
		};

		var controller = {
			guesses: 0,
			processGuess: function(location) {
				if (location) {
					this.guesses++;
					var hit = model.fire(location);
					if (hit && model.shipsSunk === model.numShips) {
						view.displayMessage("You sunk all of the battleships in " + this.guesses + " tries.");
					}
				}
			}
		}

		window.onload = init;

		function init() {

			var guessClick = document.getElementsByTagName("td");
			for (var i = 0; i < guessClick.length; i++) {
				guessClick[i].onclick = answer;
			}

			view.displayMessage("Hello, let's play! There are 3 ships, each 3 cells long");
		}

		function answer(eventObj) {
			var shot = eventObj.target;
			var location = shot.id;

			controller.processGuess(location);
		}
	</script>
</body>

</html>