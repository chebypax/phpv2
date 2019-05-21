$(document).ready(() => {
  let count = $('.count-value').val();


  $('.decrease-value').on('click', (e) => {
    e.preventDefault();
    if (count > 0) {
      $('.count-value').val(--count);
      $('.alter-count-value').html(count);
    } else {
      $('.count-value').val(count);
      $('.alter-count-value').html(count);
    }
  });

  $('.increase-value').on('click', (e) => {
    e.preventDefault();
    $('.count-value').val(++count);
    $('.alter-count-value').html(count);

  });

  $('.cart_quantity').on('input', (e) => {
    let count = +$(e.target).val();
    if (count > 0 && Number.isInteger(count)) {
      $(e.target).val(count);
  } else {
      $(e.target).val('');
      }
  });

  $('.cart_quantity').on('change', (e) => {
    let count = $(e.target).val();
    if (count === '') {
      $(e.target).val(1);
      count = 1;
    }
    let id = $(e.target).data('id');
    let price = $(e.target).data('price');
    $.ajax({
      url: "/order/update",
      type: "POST",
      data: {
        cart: "change",
        id: id,
        count: count,
        price: price,
        AJAX: 1
      },
      success: function(response) {
        response = JSON.parse(response);
        if (response["status"] === 1) {
          let quantity = response["quantity"];
          let productPrice = response["productPrice"];
          let totalPrice = response["totalPrice"];
          $('#cart-quantity').text(quantity);
          $('#total-price').text(totalPrice);
          $(`.product-price[data-id=${id}]`).text(productPrice);
          $(e.target).val(count);
        } else (
          $(e.target).val(1) //Здесь можно добавить сообщение об ошибке, но сейчас просто ставлю 100 как заглушку
        )
      }
    })
  });

  $('.count-value').on('input', () => {
    count = +$('.count-value').val();
    if (count > 0 && Number.isInteger(count)) {
      $('.count-value').val(count);
      $('.alter-count-value').html(count);
    } else {
      $('.count-value').val('');
      $('.alter-count-value').html('');
    }
  });

  $(".cart_delete_button").on('click', (e) => {
    e.preventDefault();
    let id = $(e.target).data('id');
    let price = $(e.target).data('price');
    $.ajax({
      url: `/order/delete`,
      type: "POST",
      data: {
        AJAX: 1,
        price: price,
        cart: "delete",
        id: id
      },
      success: function(response) {
        response = JSON.parse(response);
        if (response["status"] === 1) {
          let quantity = response["quantity"];
          let totalPrice = response["totalPrice"];
          $('#cart-quantity').text(quantity);
          $('#total-price').text(totalPrice);
          $(e.target).closest('tr').remove();
        }
      }

    })
  });

  $('.buy-btn').on('click', (e) => {
    e.preventDefault();
    let id = $('.buy-btn').data('id');
    let price = $('.buy-btn').data('price');
    $.ajax({
      url: `/order/addToCart`,
      type: "POST",
      data: {
        cart: "add",
        count: $('.count-value').val(),
        AJAX: 1,
        price: price,
        id: id
      },
      success: function (response) {
        response = JSON.parse(response);
        let quantity = response["quantity"];
        $('#cart-quantity').text(quantity);
        $('.cart-block_message').html(response["message"]);
         if ($('.cart-block_message').hasClass('hidden')) {
           $('.cart-block_message').removeClass('hidden');
         }
         setTimeout(() => {
           $('.cart-block_message').addClass('hidden');
         }, 10);

         // setTimeout(() => {
         //   $('.cart-block_message').removeClass('hidden');
         // }, 3000)
      }
    });
  })

  $('.phone-number').on('input', (e) => {
    let input = e.originalEvent.data;
    let string = $(e.target).val();
    console.log(string.length);
    if(string.length < 3){
      $(e.target).val("+7(");
    }
    if(string.length == 16){
      $(e.target).val(string.substring(0, string.length - 1));
    }
    if (isNaN(input) || input == " "){
      $(e.target).val(string.substring(0, string.length - 1));
    }

    if(string.length === 6 && e.originalEvent.inputType == "deleteContentBackward"){
      $(e.target).val(string.substring(0, string.length - 1));
    } else if(string.length === 6){
      $(e.target).val(string +")");
    }
    if(string.length === 10 && e.originalEvent.inputType == "deleteContentBackward"){
      $(e.target).val(string.substring(0, string.length - 1));
    } else if(string.length === 10){
      $(e.target).val(string +"-");
    }

  })
  $(".phone_mask").mask("+7(999)999-99-99");

  $('#registration-form').on('submit', (e) =>{

    let valid = new Validator('registration-form');
    e.preventDefault();
    if(valid.flag.length > 0){
      $(this).trigger('submit');
    }
    $.ajax({
      url: `/user/create`,
      type: "POST",
      data: {
        AJAX: 1,
        login: $('#login').val(),
        password: $('#password').val(),
        name: $('#name').val(),
        lastname: $('#lastname').val(),
        phone: $('#phone').val(),
        email: $('#email').val(),

      },
      success: function(response) {
        response = JSON.parse(response);
        console.log(response);
        if (response["status"] === 0) {
          $('.login-field').append(`<p class="${valid.errorClass}">Пользователь с таким логином уже существует</p>`)
        }
        if (response["status"] === 1) {
          $('.email-field')
              .append(`<p class="${valid.errorClass}">Пользователь с такой электронной почтой уже существует</p>`)
        }
        if (response["status"] === 2){
          $('.header-fields').hide();
          $('#create-user').text('Пользователь создан');
        }
      }

    })
  })




});