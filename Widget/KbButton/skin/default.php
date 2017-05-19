<?php
/**
 * Public representation of the widget.
 * All form data is available here in form of variables.
 * Please check the existence of all variables as at the beginning widget has no data.
 */
?>

<?php if(isset($label)):?>
<a href="<?=$link?>" class="<?=$classes?>"><?=$label?></a>
<?php else: ?>
<a href="" class="btn btn-default">Padrão</a>
<?php endif;?>