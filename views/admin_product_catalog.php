<div>
    <h3>Каталог товаров</h3>
    <table class="cart_table">
        <tr>
            <td>Изображение</td>
            <td>Название</td>
            <td>Описание</td>
            <td>Цена за 1</td>
            <td>Категория</td>
            <td></td>
        </tr>
        <?php foreach ($products as $item) :?>
            <tr>
                <td><img class="mini-avatar" src="<?=$item['img_path']?>" alt="ava"></td>
                <td><?=$item['name']?></td>
                <td><?=$item['description']?></td>
                <td><?=$item['price']?></td>
                <td><?=$item['category']?></td>
                <td>
                    <p><a href="/product/delete?id=<?=$item['id']?>">Удалить товар</a></p>
                    <p><a href="/product/change?id=<?=$item['id']?>">Редактировать товар</a></p>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>