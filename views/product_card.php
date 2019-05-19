<h3><?=$product['name']?></h3>
<div class ="gallery">
    <?php foreach ($images as $image) :?>
        <div class="image-block">
            <img class="gallery-image" src="<?=$image['path']?>" alt="pic"><br>

        </div>
    <?php endforeach;?>
</div>
<div class="cart-block">
    <form class="cart-block_form"
          action="/order/addToCart?id=<?=$product['id']?>&price=<?=$product['price']?>" method="post">
        <div class="cart-block_message"></div>
        <button name="operation" class="change-value-btn decrease-value" value="-">
            <i class="fas fa-minus"></i></button>
        <input class="count-value" type="text" name="count" value="1">
        <span class="alter-count-value">1</span>
        <button name="operation" class="change-value-btn increase-value" value="+">
            <i class="fas fa-plus"></i></button>
        <input type="submit" data-id=<?=$product['id']?> data-price=<?=$product['price']?>
               class="buy-btn" name="operation" value="КУПИТЬ">
    </form>
</div>
    <h4>$<?=$product['price']?></h4>
    <p><?=$product['description']?></p>


<div>

</div>

