<h1>Fry - fast object oriented templating system for PHP5</h1>

<p>Why do you have to learn another templating language, 
when PHP itself is a templating language?</p>
<p>With Fry you don't have to learn anything new, it's plain PHP.</p> 
<p>This way it is easy and convenient to do templating and it is much 
faster than compiled templating systems.</p>

<p style="font-weight: bold;">Super buzz words:</p>

<ol>
	<? foreach($this->advertisement as $val): ?>
		<li><?= $val ?></li>
	<? endforeach; ?>
</ol>

<p>Easy and convenient usage of HTML helpers, 
below is Fry generated date selection:</p>

<?= $this->selectDate(array('year' => 'Y', 'month' => 'F', 'day' => 'd')); ?>