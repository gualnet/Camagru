<div class="centralView">


	<div class="gridWrapper">
		<?php
			$pageReq -= 1;
			$cpt = 0;
			for($i = $nbrPics-1; $i >= 0; $i--)
			{
				$res = $i - ($pageReq * 6);
				if(isset($picsUrl[$res]))
				{
					$id = $i - ($pageReq * 6);
					echo "<img class=\"img\" id=\"item-".$cpt."\" src=\""
					.$picsUrl[$id]."\" />\n";
				}
				if($cpt === 5)
					break;
				$cpt++;
			}
		?>
		<div class="pagination">
			<?php
				$max = ($nbrPics / 6);
				if(is_float($max))
					$max += 1;
				for($i = 1; $i < $max; $i++)
				{
					echo "<a href=\"".$i."\">$i</a>";
				}
			?>
		</div>
	</div>


<!-- </div> -->
