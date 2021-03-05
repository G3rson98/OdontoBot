/*=====================================================================
=            Seccion de ITERACION DE ASIGNACION DE PERMISO            =
=====================================================================*/

$("#selectUsuario").on("change", function(){

	let value = $(this).val();

	// console.log("value", value);
    console.log("selectUsuario", "se selecciono algo");

    if( value !== "" ){
    	if(value == 1){
    		
    		$('input[value="1"]').attr({checked: true });
    		$('input[value="2"]').attr({checked: true });
    		$('input[value="3"]').attr({checked: true });
    		$('input[value="4"]').attr({checked: true });
    		$('input[value="5"]').attr({checked: true });
    		$('input[value="6"]').attr({checked: true });
    	}else if(value == 2){
    		$('input[value="1"]').attr({checked: false });
    		$('input[value="2"]').attr({checked: true });
    		$('input[value="3"]').attr({checked: true });
    		$('input[value="4"]').attr({checked: true });
    		$('input[value="5"]').attr({checked: false });
    		$('input[value="6"]').attr({checked: false });
    		
    	}else if( value == 3) {
    		$('input[value="1"]').attr({checked: false });
    		$('input[value="2"]').attr({checked: true });
    		$('input[value="3"]').attr({checked: false });
    		$('input[value="4"]').attr({checked: false });
    		$('input[value="5"]').attr({checked: false });
    		$('input[value="6"]').attr({checked: false });
    	}

    }else{
    	$('input[value="1"]').attr({checked: false });
    	$('input[value="2"]').attr({checked: false });
    	$('input[value="3"]').attr({checked: false });
    	$('input[value="4"]').attr({checked: false });
    	$('input[value="5"]').attr({checked: false });
    	$('input[value="6"]').attr({checked: false });
    }


});





