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
    $.ajax({
      url: "../engine/add_to_cart.php",
      type: "POST",
      data: {
        cart: "change",
        id: id,
        col: count
      },
      success: function(response) {
        response = JSON.parse(response);
        if (response["status"] === 1) {
          $(e.target).val(count);
        } else (
          $(e.target).val(100) //Здесь можно добавить сообщение об ошибке, но сейчас просто ставлю 100 как заглушку
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
    $.ajax({
      url: "../engine/add_to_cart.php",
      type: "POST",
      data: {
        cart: "delete",
        id: id
      },
      success: function(response) {
        response = JSON.parse(response);
        if (response["status"] === 1) {
          $(e.target).closest('tr').remove();
        }
      }

    })
  });

  /*$('.buy-btn').on('click', (e) => {
    e.preventDefault();
    let id = $('.buy-btn').data('id');
    let price = $('.buy-btn').data('price');
    $.ajax({
      url: "../engine/add_to_cart.php",
      type: "POST",
      data: {
        cart: "add",
        col: $('.count-value').val(),
        id: id,
        price: price,
      },
      success: function (response) {
        response = JSON.parse(response);
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
  })*/
});