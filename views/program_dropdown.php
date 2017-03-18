	<select class="form-control" id="programDropdown" name="program">
		<option value="">-</option>
		<?php
			$string = file_get_contents("data/programs.json");
			$programs = json_decode($string);
										
			foreach ($programs as $id => $p) {
				if ($id == $_SESSION['user_program']) {
					echo '<option value="'. $id .'" selected>'. $p->title .' ('. $p->type .')</option>';
				} else {
					echo '<option value="'. $id .'">'. $p->title .' ('. $p->type .')</option>';
				}
			}
		?>
	</select>