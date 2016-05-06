setTimeout(function(){
    $(".texto").typed({
        strings: ["Ops!^500 Há algo de estranho aqui,^200 não?^800<br>Tem certeza que pegamos o caminho correto?^800<br>Não podemos ficar nos perdendo!^800<br>Vamos para o início tentar novamente!"],
        typeSpeed: 40, // typing speed
        backDelay: 500, // pause before backspacing
        loop: false, // loop on or off (true or false)
        loopCount: false, // number of loops, false = infinite
        //callback: function(){ } // call function after typing is done
    });
}, 0);

$(document).ready(function() {
  setTimeout(function() {
    // send 'em packing 
    $('.kick').append('<a class="ui button teal tiny" href="/"><i class="home icon"></i> HOME</a>');
  }, 15500);
});