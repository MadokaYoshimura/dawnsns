$(function(){
  $('.ac-btn').click(function () {
    $('.ac-menu').toggleClass('close');
    $('.ac-btn').toggleClass('close');
  })
})

// 投稿削除モーダル
$(function () {
  $('.delete-btn').each(function () {
    $(this).click(function () {
      let target = $(this).data('target');
      let modal = document.getElementById(target);
      $(modal).fadeIn();
      return false;
    });
  });
//キャンセルボタン
  $('.modal-close').click(function () {
    $('.delete-modal').fadeOut();
    return false;
  });
});

// 投稿編集モーダル
$(function () {
  $('.edit-btn').each(function () {
    $(this).click(function () {
      let target = $(this).data('target');
      let modal = document.getElementById(target);
      $(modal).fadeIn();
      return false;
    });
  });
});

// Ajax
// 投稿編集フォーム
$(function () {
  $('.edit-submit').click(function (e) {
    e.preventDefault();
    var formData = document.forms["edit"];
    var postLength = $('.post-length').val().length;
    $.ajax("/post/update",{
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      data: $(formData).serialize()
    }).done(function (data) {
      if (postLength >= 200) {
        $('.length-error').text("200文字以内にしてください");
      } else {
        $('.edit-modal').close;
        location.reload();
      }
    })
      .fail(function (XMLHttpRequest, textStatus, errorThrown) {
        console.log('通信失敗');
        console.log("XMLHttpRequest : " + XMLHttpRequest.status);
        console.log("textStatus     : " + textStatus);
        console.log("errorThrown    : " + errorThrown.message);
      });
  });
});

// イメージファイルの名前表示
  $(function() {
  $('.file_name').change(function() {
    var file = $(this).prop('files')[0];
    $('#fileName').text(file.name);
  });
  });

// 編集画面で背景をクリックしたらフォーム消える
$(document).click(function (event) {
  var target = $(event.target);

  if (target.hasClass('edit-modal')) {
    target.fadeOut();
  }
});
