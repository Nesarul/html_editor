var synth = window.speechSynthesis;

var text = "";
var voice = 5; 
var voices = [];
var vc = 0;
function speak(){
    if (synth.speaking) {
        console.error('speechSynthesis.speaking');
        return;
    }
	
    if (text !== '') {
      	var utterThis = new SpeechSynthesisUtterance(text);
    	utterThis.onend = function (event) {
        	console.log('SpeechSynthesisUtterance.onend');
    	}
    	utterThis.onerror = function (event) {
        	console.error('SpeechSynthesisUtterance.onerror');
		}
		
		utterThis.voice = voices[voice];
		utterThis.pitch = 1;
		utterThis.rate = 1;
		synth.speak(utterThis);
		text = "";
  	}
}

function btnClick(id){
    var msg  = id.substring(4);
    $('#bub-'+msg).toggleClass('d-none');
}

// $('.bbl-main>span,.bbl-main-r>span').on("click",function(){
	$('.bbl-main,.bbl-main-r').on("click",'span',function(){
	vc=parseInt($(this).parent().attr('data-person'));
	
	text+= $(this).parent('div').children('p').text()
	voices = synth.getVoices();
	var index;
	var len = voices.length;
	var x = 0;
	for(i = 0; i < len; ++i){
		var str = voices[i];
		if(vc === 0)
			index = str.name.indexOf("David");
		else
			index = str.name.indexOf("Zira");

		if(index !== -1){
			x=i;
			break;
		}
	}

	voice = x;
	if (synth.speaking){
		text = "";
		synth.cancel();
	}
        
    else speak();
});

$('.js-toexpand').click(function(){
    $(this).toggleClass('ico');
    $(this).next('.js-expand_more').slideToggle('slow');
});
