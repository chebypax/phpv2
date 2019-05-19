<div class="gallery">
    <?php foreach ($products as $product): ?>
        <a class='gallery_item' href="/product/card?id=<?= $product['id'] ?>">
            <img class="gallery-image" src=<?= $product['img_path'] ?> class='gallery__img' alt='gallery_image'>
            <h3 class='product_name'><?= $product['name'] ?></h3>
            <h3 class='product_price'>$<?= $product['price'] ?></h3>


        </a>
    <?php endforeach; ?>
</div>