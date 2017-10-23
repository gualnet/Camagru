<div class="centralView">

	<div class="flexBox">
		<?php
			$pageReq -= 1;
			$cpt = 0;
			for($i = $nbrPics-1; $i >= 0; $i--)
			{
				$res = $i - ($pageReq * 6);
				if(isset($picsUrl[$res]))
				{
					$id = $i - ($pageReq * 6);
					echo "<div class=\"sticker\">";
					echo "<img class=\"img\" id=\"item-".$cpt."\" src=\""
					.$picsUrl[$id]."\" />\n";
					echo "<div class=\"imgSubBox\">
					<ul>
						<li onclick=like(this)>Like</li>
						<li>Unlike</li>
						<li>Comment</li>
					</ul>
					</div>";
					echo "</div>";
				}
				if($cpt === 5)
					break;
				$cpt++;
			}
		?>
	</div>
		<div class="pagination">
			<?php
				$max = ($nbrPics / 6);
				if(is_float($max))
					$max += 1;
				for($i = 1; $i < $max; $i++)
				{
					echo "<a href=\"http://".HTTP_HOST."/pages/galery/".$i."\">$i</a>";
					// echo "<a href=\"http://localhost:8888/pages/galery/".$i."\">$i</a>";
				}
			?>
		</div>

</div>

<script>

	function like(me)
	{
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "../bckPages/galeryAjx", true);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		data = me.parentElement.parentElement.parentElement.getElementsByClassName("img")[0].getAttribute("src");
		xhr.send("var1=like&var2="+data+"&var3=none");
	}

</script>
