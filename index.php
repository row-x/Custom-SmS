
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="referrer" content="never">
  <link href="https://i.postimg.cc/Zn0Np0BL/favicon.png" rel="icon">
  <title>Free Sender</title>
  <link rel="stylesheet" href="style.css">
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css'>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
</head>
<body>

<div class="centerall">
    <h3>FREE SMS SENDER V3</h3>


    <div class="form">

    <ul class="ul">
        <li>SENT : <span id="sent">0</span></li>
        <li>ERROR : <span id="error">0</span></li>
        <li>TOTAL : <span id="total">0</span></li>
    </ul>
        <div id="response"></div>
        <div id="badresponce"></div>
        <span style="width: 100%;" id="responce"></span>
        <label>Message</label>
        <textarea placeholder="Message" id="message"></textarea>

        <label>API</label>
        <div class="skbox">
            <input type="" id="api" name="api" placeholder="NOMAX API" value="<?php if(isset($_COOKIE['NOMAX_API'])){echo $_COOKIE['NOMAX_API'];}?>">
            <div onclick="checkapi()">CHECK</div>
            <span id="ModalMsg">RESULTS</span>
         </div>

        <label>Numbers</label>
        <textarea placeholder="Numbers" id="numbers"></textarea>
        <input type="submit" onmousedown="enviar();" value="Send SMS now!">
    </div>
</div>





<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js" type="text/javascript"></script>
<script title="ajax">

  function enviar() {
    function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    var numbers = $("#numbers").val();
    var message = $("#message").val();
    var api = $("#api").val();
    var lines = numbers.split("\n");
    var total = lines.length;
    var st = 0;
    var dd = 0;

    if(api.length == 0) {
        var api = "";
    }else{
        setCookie('NOMAX_API', api, '3');
    }

    if (message.length == 0){
        $('#responce').html('<div class="cap" style="width: 100%;color: red;position: relative; background: #f2dede;color: #a94442;text-align: center;font-size: 13px;font-weight: bold;border-radius: 5px;margin-top: 15px;">Message empty.<i style="position: absolute;right: 15px;top: 50%;transform: translate(0,-50%);cursor: pointer;" class="fa fa-close" onclick="removeDiv()"></i></div>');
        return;
    }
    
    if (api.length == 0){
        $('#responce').html('<div class="cap" style="width: 100%;color: red;position: relative; background: #f2dede;color: #a94442;text-align: center;font-size: 13px;font-weight: bold;border-radius: 5px;margin-top: 15px;">API empty.<i style="position: absolute;right: 15px;top: 50%;transform: translate(0,-50%);cursor: pointer;" class="fa fa-close" onclick="removeDiv()"></i></div>');
        return;
    }
    if (numbers.length == 0){
        $('#responce').html('<div class="cap" style="width: 100%;color: red;position: relative; background: #f2dede;color: #a94442;text-align: center;font-size: 13px;font-weight: bold;border-radius: 5px;margin-top: 15px;">Numbers empty.<i style="position: absolute;right: 15px;top: 50%;transform: translate(0,-50%);cursor: pointer;" class="fa fa-close" onclick="removeDiv()"></i></div>');
        return;
    }
    lines.forEach(function(value, index) {
      setTimeout(
        function() {
          $.ajax({
            url: 'api.php',
            type: 'POST',
            data: {
                apikey: api,
                number: value,
                message: message,
            },
            async: true,
            success: function(Results) {
              if (Results.match("Message Sent => ")) {
                removeline();
                st++;
                $('#response').html(Results);
                var txt = $('#balance').text();
                $('#ModalMsg').text(txt);
              } else{
                removeline();
                dd++;
                $('#response').html(Results);
              }
              $('#total').html(total);
              $('#sent').html(st);
              $('#error').html(dd);
            }
          });
        }, 500 * index);
    });
        }

  function removeline() {
    var lines = $("#numbers").val().split('\n');
    lines.splice(0, 1);
    $("#numbers").val(lines.join("\n"));
  }
</script>
<script type="text/javascript">
    function checkapi(){
    function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    var api = $("#api").val();
    if (api.length == 0) {
        
        $('#ModalMsg').text("API EMPTY.");
        return;
    }
    if (api.length < 25){
        
        $('#ModalMsg').text("Invalid.");
        return;
    }
    
    $('#ModalMsg').text("CHECKING");
    setTimeout(
        function(){
            $.ajax({
            url: 'api.php',
            type: 'POST',
            data: {
                apikey: api,
                check: 'ok',
            },
            async: true,
            beforeSend: function () {
                $('#ModalMsg').text("CHECKING");
            },
            success: function(data){
                if (data.match("DEAD")) {
                    $('#ModalMsg').html('<span style="color: #ff0008;height: 100%;background: transparent;display: flex;justify-content: center;align-items: center;">DEAD</span>');
                }else if(data.match("Api Empty!")){
                    $('#ModalMsg').html('<span style="color: #ff0008;height: 100%;background: transparent;display: flex;justify-content: center;align-items: center;">Empty!</span>');
                }else 
                if(data.match("insufficient credit")){
                    $('#ModalMsg').html('<span style="font-size:13px;color: #ff0008;height: 100%;background: transparent;display: flex;justify-content: center;align-items: center;">insufficient credit</span>');
                }else {
                    $('#ModalMsg').html('<span style="font-size:11px;color: #79ff00;height: 100%;background: transparent;display: flex;justify-content: center;align-items: center;">'+ data +'</span>');
                    var api = $("#api").val();
                    if(api.length == 0) {
                        var api = "";
                    }else{
                        setCookie('NOMAX_API', api, '3');
                    }
                }
            }
        });
    }, 2000);
}
</script>

<script type="text/javascript">
    function removeDiv() {
    $(".cap").remove();
}
</script>

</body>
</html>