<?php 
use yii\helpers\Url;

?>
<div class="swiper-category d-lg-none d-block">
	<div class="swiper-wrapper">
    	<?php foreach($this->params['sidebarCategories'] as $category) :?>
    		<a href="<?= Url::toRoute(['/category/'.$category['url']]) ?>" class="swiper-category__item swiper-slide">
    			<?= $category['title']; ?>
    		</a>
    	<?php endforeach;?>
  	</div>
</div>

