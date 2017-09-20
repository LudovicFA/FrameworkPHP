<?= $renderer->render('header')  ?>

Bienvenue sur le blog

<ul>
  <li><a href="<?= $router->generateUri('blog.show',['slug'=>'zaefze0-7efzaf']) ?>">Article 1</a> </li>
  <li>Article 1 </li>
  <li>Article 1 </li>
  <li>Article 1 </li>
  <li>Article 1 </li>
  <li>Article 1 </li>
</ul>


<?= $renderer->render('footer')  ?>
