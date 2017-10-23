<?php

class BckPagesController extends Controller
{
	function galeryAjx()
	{
		this->loadModel("likes");
		creer un like en base de donnee,
		lier le like likeur_id et photoLiker_id,
		$this->loadModel("pictures");
		incrementer le nombre de like de la photo concernées,
		returner un true pour le changement de bouton sur la galerie.

	}

}

?>
