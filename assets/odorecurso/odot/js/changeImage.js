
function action(imId){
	window.alert("FUNCIONA PERROS");
}
function on(imId) {
  document.getElementById("overlay").style.display = "block";
  let input = document.getElementById("idDiente");
  console.log("input", input);
  
  input.value = imId;
  
}

function off() {
  document.getElementById("overlay").style.display = "none";
}
function setNewImage(imId){

	switch (imId){
    	 
		  case '18Z':
		  case '17Z': 
		  case '16Z': 
		  case '15Z':
		  case '14Z':
		  case '12Z':
		  case '13Z':
		  case '11Z':

		  case '28Z':
		  case '27Z': 
		  case '26Z': 
		  case '25Z':
		  case '24Z':
		  case '23Z':
		  case '22Z':
		  case '21Z':

		  case '38Z':
		  case '37Z': 
		  case '36Z': 
		  case '35Z':
		  case '34Z':
		  case '33Z':
		  case '32Z':
		  case '31Z':

		  case '48Z':
		  case '47Z': 
		  case '46Z': 
		  case '45Z':
		  case '44Z':
		  case '43Z':
		  case '42Z':
		  case '41Z':
		  		document.getElementById(imId).src = "assets/odorecurso/odot/css/caras2/CC PNG/CZ.png";
    	  break;
    	  case '18X':
    	  case '17X':
    	  case '16X':
    	  case '15X':
		  case '14X':
		  case '13X':
		  case '12X':
		  case '11X':

		  case '28X':
		  case '27X': 
		  case '26X': 
		  case '25X':
		  case '24X':
		  case '23X':
		  case '22X':
		  case '21X':

		  case '38X':
		  case '37X': 
		  case '36X': 
		  case '35X':
		  case '34X':
		  case '33X':
		  case '32X':
		  case '31X':

		  case '48X':
		  case '47X': 
		  case '46X': 
		  case '45X':
		  case '44X':
		  case '43X':
		  case '42X':
		  case '41X':
    	  		document.getElementById(imId).src = "assets/odorecurso/odot/css/caras2/CC PNG/CX.png";
    	  break;
    	  case '18D':
    	  case '17D':
    	  case '16D':
    	  case '15D':
		  case '14D':
		  case '13D':
		  case '12D':
		  case '11D':

		  case '28D':
		  case '27D': 
		  case '26D': 
		  case '25D':
		  case '24D':
		  case '23D':
		  case '22D':
		  case '21D':

		  case '38D':
		  case '37D': 
		  case '36D': 
		  case '35D':
		  case '34D':
		  case '33D':
		  case '32D':
		  case '31D':

		  case '48D':
		  case '47D': 
		  case '46D': 
		  case '45D':
		  case '44D':
		  case '43D':
		  case '42D':
		  case '41D':
				document.getElementById(imId).src = "assets/odorecurso/odot/css/caras2/CC PNG/CD.png";
    	  break;
		  case '18I':
		  case '17I':
		  case '16I':
		  case '15I':
		  case '14I':
		  case '13I':
		  case '12I':
		  case '11I':

		  case '28I':
		  case '27I': 
		  case '26I': 
		  case '25I':
		  case '24I':
		  case '23I':
		  case '22I':
		  case '21I':

		  case '38I':
		  case '37I': 
		  case '36I': 
		  case '35I':
		  case '34I':
		  case '33I':
		  case '32I':
		  case '31I':

		  case '48I':
		  case '47I': 
		  case '46I': 
		  case '45I':
		  case '44I':
		  case '43I':
		  case '42I':
		  case '41I':
				document.getElementById(imId).src = "assets/odorecurso/odot/css/caras2/CC PNG/CI.png";
    	  break;
    	  case '18S':
    	  case '17S':
    	  case '16S':
    	  case '15S':
		  case '14S':
		  case '13S':
		  case '12S':
		  case '11S':

		  case '28S':
		  case '27S': 
		  case '26S': 
		  case '25S':
		  case '24S':
		  case '23S':
		  case '22S':
		  case '21S':

		  case '38S':
		  case '37S': 
		  case '36S': 
		  case '35S':
		  case '34S':
		  case '33S':
		  case '32S':
		  case '31S':

		  case '48S':
		  case '47S': 
		  case '46S': 
		  case '45S':
		  case '44S':
		  case '43S':
		  case '42S':
		  case '41S':
				document.getElementById(imId).src = "assets/odorecurso/odot/css/caras2/CC PNG/CS.png";
		  break;
	}	

};

function setOldImage(imId){

		switch (imId){
		  case '18Z':
		  case '17Z': 
		  case '16Z': 
		  case '15Z':
		  case '14Z':
		  case '13Z':
		  case '12Z':
		  case '11Z':

		  case '28Z':
		  case '27Z': 
		  case '26Z': 
		  case '25Z':
		  case '24Z':
		  case '23Z':
		  case '22Z':
		  case '21Z':

		  case '38Z':
		  case '37Z': 
		  case '36Z': 
		  case '35Z':
		  case '34Z':
		  case '33Z':
		  case '32Z':
		  case '31Z':

		  case '48Z':
		  case '47Z': 
		  case '46Z': 
		  case '45Z':
		  case '44Z':
		  case '43Z':
		  case '42Z':
		  case '41Z':
		  		document.getElementById(imId).src = "assets/odorecurso/odot/css/caras2/B PNG/CZ.png";
    	  break;
    	  case '18X':
    	  case '17X':
    	  case '16X':
    	  case '15X':
		  case '14X':
		  case '13X':
		  case '12X':
		  case '11X':

		  case '28X':
		  case '27X': 
		  case '26X': 
		  case '25X':
		  case '24X':
		  case '23X':
		  case '22X':
		  case '21X':

		  case '38X':
		  case '37X': 
		  case '36X': 
		  case '35X':
		  case '34X':
		  case '33X':
		  case '32X':
		  case '31X':

		  case '48X':
		  case '47X': 
		  case '46X': 
		  case '45X':
		  case '44X':
		  case '43X':
		  case '42X':
		  case '41X':
    	  		document.getElementById(imId).src = "assets/odorecurso/odot/css/caras2/B PNG/CX.png";
    	  break;
    	  case '18D':
    	  case '17D':
    	  case '16D':
    	  case '15D':
		  case '14D':
		  case '13D':
		  case '12D':
		  case '11D':

		  case '28D':
		  case '27D': 
		  case '26D': 
		  case '25D':
		  case '24D':
		  case '23D':
		  case '22D':
		  case '21D':

		  case '38D':
		  case '37D': 
		  case '36D': 
		  case '35D':
		  case '34D':
		  case '33D':
		  case '32D':
		  case '31D':

		  case '48D':
		  case '47D': 
		  case '46D': 
		  case '45D':
		  case '44D':
		  case '43D':
		  case '42D':
		  case '41D':
				document.getElementById(imId).src = "assets/odorecurso/odot/css/caras2/B PNG/CD.png";
    	  break;
    	  case '18S':
    	  case '17S':
    	  case '16S':
		  case '15S':
		  case '14S':
		  case '13S':
		  case '12S':
		  case '11S':

		  case '28S':
		  case '27S': 
		  case '26S': 
		  case '25S':
		  case '24S':
		  case '23S':
		  case '22S':
		  case '21S':

		  case '38S':
		  case '37S': 
		  case '36S': 
		  case '35S':
		  case '34S':
		  case '33S':
		  case '32S':
		  case '31S':

		  case '48S':
		  case '47S': 
		  case '46S': 
		  case '45S':
		  case '44S':
		  case '43S':
		  case '42S':
		  case '41S':
				document.getElementById(imId).src = "assets/odorecurso/odot/css/caras2/B PNG/CS.png";
    	  break;
    	  case '18I':
    	  case '17I':
    	  case '16I':
    	  case '15I':
		  case '14I':
		  case '13I':
		  case '12I':
		  case '11I':

		  case '28I':
		  case '27I': 
		  case '26I': 
		  case '25I':
		  case '24I':
		  case '23I':
		  case '22I':
		  case '21I':

		  case '38I':
		  case '37I': 
		  case '36I': 
		  case '35I':
		  case '34I':
		  case '33I':
		  case '32I':
		  case '31I':

		  case '48I':
		  case '47I': 
		  case '46I': 
		  case '45I':
		  case '44I':
		  case '43I':
		  case '42I':
		  case '41I':
				document.getElementById(imId).src = "assets/odorecurso/odot/css/caras2/B PNG/CI.png";
    	  break;

	}

};