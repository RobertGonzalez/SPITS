<?php
$pagetitle = 'SPITS Start';

require_once 'utils/ScriptsList.php';
$files = ScriptsList::getScriptsList();
?>
<h1>Start Here</h1>
<p>To test a script, please pick a script from the list</p>
<ul>
    <?php foreach ($files as $dir => $items): ?>
    <li><?php echo $dir ?>/<ul>
        <?php foreach ($items as $file): ?>
        <li><a href="<?php echo $file['link'] ?>"><?php echo $file['name'] ?></a></li>
        <?php endforeach; ?>
    </ul></li>
    <?php endforeach ?>
</ul>