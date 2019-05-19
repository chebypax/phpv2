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
        <input data-id = "<?=$item['product_id']?>" class="cart_quantity" type="number" value= <?=$item['quantity']?>>
    </td>
    <td><?=$item['price']?></td>
    <td><?=$item['totalPrice']?></td>
    <td>
        <p><a href="/order/delete?id=<?=$item['id']?>">Удалить товар</a></p>
    </td>
    </tr>
    <?php endforeach;?>
</table>
<h4>Итого на сумму <?=$totalSum?></h4>


<form action='/order/create' method='post'>
    <?php if(!$params['session']['user']):?>
    <input type='text' name='name' placeholder='Имя' required>
    <input type='text' name='lastname' placeholder='Фамилия' required>
    <input type='tel' name='phone' placeholder='Телефон' required>
    <?endif;?>
    <input type='submit' value='Оформить заказ'>
</form>
