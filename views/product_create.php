<h3>Добавление товара в каталог</h3>

<div class="upload_catalog_form">
    <form action="/product/create" method="post" enctype="multipart/form-data">
        Название товара<br> <input type="text" name="name"><br>
        Цена товара<br> <input type="number" name="price"><br>
        Описание товара<br> <textarea name="description" id="" cols="30" rows="10"></textarea><br>
        Категория товара
        <select name="category" id="">
            <option value="1">Men</option>
            <option value="2">Women</option>
            <option value="3">Children</option>
        </select><br>
        Добавить фото<br><input type="file" name="myfile[]" multiple><br>
        <input type="submit" value="Добавить товар">
    </form>
</div>
