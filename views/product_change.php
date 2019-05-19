<h3>Редактирование товара</h3>
<div class ="gallery">
<?php foreach ($images as $image) :?>
<div class="image-block">
    <?php if($image['avatar'] == 1) {
        $class = 'avatar';
    } else {
        $class = '';
    }?>

    <img class="gallery-image <?=$class?>" src="<?=$image['path']?>" alt="pic"><br>
    <a href="/product/avatarImage?imgId=<?=$image['id']?>&prodId=<?=$product['id']?>">Сделать аватарой</a><br>
    <a href="/product/deleteImage?id=<?=$image['id']?>">Удалить картинку</a>
</div>
<?php endforeach;?>
</div>

<div class="upload_catalog_form">
   <form action="/product/update?id=<?=$product['id']?>" method="post" enctype="multipart/form-data">
        Название товара<br> <input type="text" name="name" value="<?=$product['name']?>"><br>
        Цена товара<br> <input type="number" name="price" value="<?=$product['price']?>"><br>
        Описание товара<br> <textarea name="description" id="" cols="50" rows="20"><?=$product['description']?></textarea><br>
        Категория товара<br>
        Текущее занечние: <?=$product['category']?><br>
       <select name="category" id="">
            <option value="1">Men</option>
            <option value="2">Women</option>
            <option value="3">Children</option>
        </select><br>
       Добавить фото<br><input type="file" name="myfile[]" multiple><br>
        <input type="submit" value="Внести изменения">
    </form>
</div>
