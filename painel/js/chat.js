$(()=>{

  $('.box__chat__online').scrollTop($('.box__chat__online')[0].scrollHeight);

  $('textarea').keyup(function(e){
    var code = e.keyCode || e.which;
    if(code == 13){ //enter keycode
      insertChat();
    }
  })

  $('form').submit(function(){
    insertChat();
    return false;
  })

  function insertChat(){
    //insert message
    var mensagem = $('textarea').val();
    $('textarea').val('');
    $.ajax({
      url:include_path+'ajax/chat.php',
      method:'post',
      data: {'mensagem':mensagem,'acao':'inserir_mensagem'}
    }).done(function(data){
      $('.box__chat__online').append(data);
      $('.box__chat__online').scrollTop($('.box__chat__online')[0].scrollHeight);
    })
  }

  function recuperarMensagens(){
      //Taken news messages from db
      $.ajax({
        url:include_path+'ajax/chat.php',
        method:'post',
        data: {'acao':'pegarMensagens'}
      }).done(function(data){
        $('.box__chat__online').append(data);
        $('.box__chat__online').scrollTop($('.box__chat__online')[0].scrollHeight);
      })
  }

  setInterval(function(){
    recuperarMensagens();
  },3000);
  
})