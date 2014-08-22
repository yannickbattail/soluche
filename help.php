<?php
require_once ('ajaxInit.php');

/* ------ treatment ------- */

/* ------ html ------- */
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Soluche</title>
<link rel="icon" type="image/png" href="images/soluche_icon.png">
<link rel="stylesheet" href="theme/theme.css" type="text/css">
<link rel="stylesheet" href="theme/other.css" type="text/css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.9.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
</head>
<body>

	<h2>Info</h2>
	Chaque action est signalée
	<div class="action">comme ca</div>
	.
	<br />En mettant la souris dessus on voit les détails de ce qu'apport l'action.
	<br /><img src="images/help/action tooltip ex.png" alt="détails de l'action" style="border-style: dotted; border-width: 1px;" />
	<br />En fonction de la réusite:
	<table>
		<tr>
			<td>
				<img src="images/emotes/face-smile.png" width="32" height="32" title="Succès" alt="Succès">
			</td>
			<td>Signifie succès</td>
		</tr>
		<tr>
			<td>
				<img src="images/emotes/face-plain.png" width="32" height="32" title="bof" alt="bof">
			</td>
			<td>Signifie exaequo</td>
		</tr>
		<tr>
			<td>
				<img src="images/emotes/face-sad.png" width="32" height="32" title="Echec" alt="Echec">
			</td>
			<td>Signifie Echec</td>
		</tr>
	</table>
	Chaque caractéristque des item est défine par une icone 
	<table>
		<tr><th><img src="images/util/Dignichose.png" width="32" height="32" title="Coût en dignichose" alt="Coût en dignichose"></th><td>dignichose (la monnaie du jeu)</td></tr>
		<tr><th><img src="images/util/lock closed.png" width="32" height="32" title="Permanant" alt="Permanant"></th><td>Permanant: si l'item est permanant son effet est ajouté aux caractéristiques du joueur (ex: les insignes comme la poule), si il ne l'est pas l'item n'aura d'effet que lorsqu'il sera utilisé (ou mangé ou bu) (ex: les nourritures ou boissons comme la bière ou le sandwish).</td></tr>
		<tr><th><img src="images/util/notoriété.png" width="32" height="32" title="Crédibidulité" alt="Crédibidulité"></th><td>Crédibidulité (ou notoriété)</td></tr>
		<tr><th><img src="images/util/chope argent.png" width="32" height="32" title="Verres" alt="Verres"></th><td>Verres: alcoolémie en cours.</td></tr>
		<tr><th><img src="images/util/chope or.png" width="32" height="32" title="Verres optimum" alt="Verres optimum"></th><td>Verres optimum: la limite d'alcoolémie optimum. Au-delà de cette limite plus rien n'est sur ... /!\</td></tr>
		<tr><th><img src="images/util/chope rouge.png" width="32" height="32" title="Verres max" alt="Verres max"></th><td>Verres max: la limite d'alcoolémie max. Au-delà de cette limite c'est la PLS bloqué pendant 60s, perte de crédibidulité etc ...</td></tr>
		<tr><th><img src="images/util/sleep.png" width="32" height="32" title="Fatigue" alt="Fatigue"></th><td>Fatigue: chaque action épuise, après il faut se reposer ou boire de la cafféine.</td></tr>
		<tr><th><img src="images/util/fatigue max.png" width="32" height="32" title="Fatigue max" alt="Fatigue max"></th>Fatigue max: au-delà de cette limite, il n'est plus possible de faire d'action, le repose est obligatoire.<td></td></tr>
		<tr><th><img src="images/util/sex appeal.png" width="32" height="32" title="Sexe appeal" alt="Sexe appeal"></th><td>Sexe appeal: non pas à pile, appeal! l'attirance toussa toussa!</td></tr>
		<tr><th><img src="images/util/time.png" width="32" height="32" title="¼ d'heure" alt="¼ d'heure"></th><td>le temps (en ¼ d'heure): chaque action prend + ou - de temps et un congrès et limité dans le temps.</td></tr>
	</table>
	Rappel les valeurs des items sont ajoutée au joueur.
	<br />(par ex: (<?= plus(-1, 1) ?> en verre ou <?= plus(-1, 0) ?> en Sexe appeal diminuera la valeur du joueur)	
	<br />(par ex: (<?= plus(1, 1) ?> en Crédibidulité ou <?= plus(1, 0) ?> en Fatigue augementera la valeur du joueur)	
	<br />La couleur rouge ou verte indique l'aspect positif ou négatif de la chose.
	<br /><a href="itemDico.php">liste des items</a> et leurs caratéristiques.
	
</body>
</html>
