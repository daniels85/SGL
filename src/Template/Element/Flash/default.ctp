<?php
$class = 'message';
if (!empty($params['class'])) {
    $class .= ' ' . $params['class'];
}
?>
<div class="ui floating message negative">
	<i class="close icon"></i>
	<div class="header">
		<p><i class="warning sign icon"></i>
		<?php echo $message; ?></p>
	</div>
</div>