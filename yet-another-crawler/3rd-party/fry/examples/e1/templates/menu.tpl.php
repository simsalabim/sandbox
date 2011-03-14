<div style="padding: 20px;">
	<ul>
		<li>
			<?= $this->link('http://google.com', 'Google', array('style' => 'color: green;', 'target' => '_blank')); ?>
		</li>
		<li>
			<?= $this->link('./', 'This site', array('title' => 'Hello Fry')); ?>
		</li>
	</ul> 
	
	<p><?= $this->getGlobal('something'); ?></p>
</div>