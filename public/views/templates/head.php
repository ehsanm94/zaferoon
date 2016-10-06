<base href="<?php echo getenv('URL') ?>">
<title><?php echo isset($title) ? $title : getenv('TITLE') ?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="public/src/style/css/global.css">

<script src="public/src/plugins/jquery-1.12.4.min.js"></script>
<script src="public/src/js/functions.js"></script>
<script src="public/src/plugins/persianumber.min.js"></script>

<?php if (isset($resources)) {
	foreach($resources as $resource) {
		$ext = pathinfo($resource, PATHINFO_EXTENSION);
		if ($ext === 'js') {
			echo '<script src="public/src/' . $resource . '"></script>' . "\n\r";
		}
		else if ($ext === 'css') {
			echo '<link rel="stylesheet" type="text/css" href="public/src/' . $resource . '">' . "\n\r";
		}
	}
}
?>