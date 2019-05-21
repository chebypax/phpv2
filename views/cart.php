<h3>Таблица заказов</h3>
<table class="cart_table">
    <tr>
        <td></td>
        <td>Название</td>
        <td>Количество</td>
        <td>Цена за 1</td>
        <td>Цена за все</td>
        <td></td>
    </tr><br>
    <?php foreach($products as $item):?>
<tr>
                <td><img class="mini-avatar" src="<?=$item['img_path']?>" alt="ava"></td>
                <td><?=$item['name']?></td>

    <td>
        <input data-id = "<?=$item['id']?>" data-price = "<?=$item['price']?>"
               class="cart_quantity" type="number" value= <?=$item['quantity']?>>
    </td>
    <td><?=$item['price']?></td>
    <td><span data-id = "<?=$item['id']?>" class="product-price">
    <?=$item['totalPrice']?></span></td>
    <td>
        <p>
            <a class="cart_delete_button" data-id="<?=$item['id']?>" data-price="<?=$item['price']?>"
               href="/order/delete?id=<?=$item['id']?>&price=<?=$item['price']?>">
                Удалить товар</a></p>
    </td>
    </tr>
    <?php endforeach;?>
</table>
<h4>Итого на сумму <span id="total-price"><?=$totalPrice?></span></h4>


<form action='/order/create' method='post'>
    <?php if(!$params['session']['user']):?>
    <input type='text' name='name' placeholder='Имя' required>
    <input type='text' name='lastname' placeholder='Фамилия' required>
        <div><input class="phone_mask" type="text" name="phone" placeholder="Телефон" required><br></div>
    <?php endif;?>
    <input type='submit' value='Оформить заказ'>
</form>
