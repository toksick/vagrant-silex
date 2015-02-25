<?php
$view->extend("layout.html.php");
$view["slots"]->set("title", "Blog Post");

?>
<div class="row">
    <div class="col-sm-12" >
        <?php foreach ($posts as $value) { ?>
            <div class="list-group">
              <a href="/blogposts/post/<?= $value['id']?>" class="list-group-item">
                <h4 class="list-group-item-heading"><?= $value['title']?></h4>
                <p class="list-group-item-text"><?= $value['text']?></p>
              </a>
              <button class="btn btn-default" type="submit">Delete</button>
            </div>
        <?php }?>
    </div>
</div>