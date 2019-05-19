<div>
    <h3>Новые заказы</h3><hr>
    <?php foreach ($orders as $key=>$order) :?>
    <h4>Заказ номер <?=$key?></h4>
    <p><?=$order[0]['customerName']?> <?=$order[0]['customerLastname']?></p>
    <p>Телефон <?=$order[0]['customerPhone']?></p>
    <table class="cart_table">
        <tr>
            <td>ИД товара</td>
            <td>Количество</td>
        </tr>
        <?php foreach ($order as $item) :?>
            <tr>
                <td><?=$item['productId']?></td>
                <td><?=$item['productQuantity']?></td>

            </tr>
        <?php endforeach; ?>
    </table>
        <p><a href="/order/complete?id=<?=$key?>">Выполнить заказ</a></p>
    <hr>
    <?php endforeach;?>
</div>
