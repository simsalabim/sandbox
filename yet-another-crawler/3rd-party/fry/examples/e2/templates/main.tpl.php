<html>
	<head>
		<title><?= $this->get('title'); ?></title>
	</head>
	<body> 
		<div style="float: left; width: 20%; border: 1px dashed #eeeeee;">
			<?= $this->renderPart('menu'); ?>
		</div>
		<div style="float: right; width: 75%;">
			<?= $this->renderPart('content'); ?>
		</div>
	</body>
</html>