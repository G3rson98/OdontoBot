/*=================================================================
=Agregando Producto al Detalle de ingreso DEL A TABLA de Productos=
===================================================================*/
let button = document.getElementById('modalProductos');

let cuandoClickBotonAddProductoNotaCompra = (event) => {

	let click = event.target,
		btnSelecto;

	if(click.tagName == 'BUTTON' || click.tagName == 'I'){
		click.tagName == 'I' ? btnSelecto = click.parentElement : btnSelecto = click;

		if(btnSelecto.classList.contains('btn-nota-compra')){
            btnSelecto.classList.remove('btn-nota-compra');
            // console.log("btnSelecto", btnSelecto);

			//abilitamos el boton de envio al agregar un producto
			let btnEnvioForm = document.querySelector('.btnEnvio');
				btnEnvioForm.classList.remove('disabled');

			let nombre = btnSelecto.getAttribute('nombreMat'),
                descripcion = btnSelecto.getAttribute('descripcionMat'),
				idMat = btnSelecto.getAttribute('idMat'), contenido,
				bodyTable = document.querySelector('.cuerpo-tabla'),
			 	contenidoBody = bodyTable.innerHTML,
				elementoRow = document.createElement('tr'),
				    	attr1 = document.createAttribute('role');
				    	attr1.value = "row";
				    	elementoRow.setAttributeNode(attr1);
				    	elementoRow.classList.add('odd');

			    contenido =  `<td tabindex="0" class="sorting_1">${nombre}
			    					<input type="hidden" name="idMat[]" value="${idMat}" required>
			    				</td>
                                <td tabindex="0" class="sorting_1">${descripcion}</td>
                                 <td><div class="form-group">
                                        <div class="input-group">
                                            <input class="form-control calcular-precio" type="number" step="0.01" name="cantidad[]" style="width:90px;" min="0" required>
                                        </div>
                                    </div>
                                </td>
                                 <td><div class="form-group">
                                        <div class="input-group">
                                            <input class="form-control calcular-precio" type="number" step="0.01" name="precio[]" style="width:90px;" min="0" required>
                                        </div>
                                    </div>
                                </td>
                                <td><div class="form-group">
                                        <div class="input-group">
                                            <input class="form-control" type="date" name="fechaVen[]" required>
                                        </div>
                                    </div>
                                </td>`;

                    elementoRow.innerHTML = contenido;

                    let nota = bodyTable.querySelector('td[valign=top]');
                    if(nota ){
                    	let nodoOld = nota.parentElement;
                    	bodyTable.replaceChild(elementoRow,nodoOld);
                    	
					}else{

						bodyTable.appendChild(elementoRow);
					}

					// //Validar para calculo de precio
					
		}

	}

}

if(button){

	button.addEventListener('click', cuandoClickBotonAddProductoNotaCompra);
}

/*=====================================================================
=            SECCION DE CALCULO TOTAL DE LA NOTA DE COMPRA            =
=====================================================================*/



$('.calculo-nota').change(function(){
	let bodyTable = document.querySelector('.cuerpo-tabla')
	if($('.calculo-nota').prop('checked')){
		let filas = Array.from(bodyTable.querySelectorAll('tr'));
		if(filas.length > 0){

			let inputs = Array.from(bodyTable.querySelectorAll('.calcular-precio')), length =inputs.length - 1,
			    montoTotal=0, cantidad = 0,precio=0,monto=0;
			console.log("inputs", inputs);

			for (var i =0;  i<length;  i++) {
				console.log("inputs[i].value", inputs[i].value);
				console.log("inputs[i].value", inputs[i+1].value);

				if(inputs[i].value != "" &&
					inputs[i+1].value != "" ){
					cantidad = inputs[i].value;
					precio = inputs[i+1].value;
					monto = monto + (precio*cantidad);
				}
				i++;
			}
			let button= document.querySelector('.mostrar-resultado'),
				inputTotal= document.getElementById('total');
			button.innerHTML = Math.round(monto*100)/100 + '  Bs';
			console.log("monto", monto);
			inputTotal.value = Math.round(monto*100)/100;
			
		}	

	}else{
		let button= document.querySelector('.mostrar-resultado'),
				inputTotal= document.getElementById('total');
			button.innerHTML = '0.0  Bs';
			inputTotal.value = "";
			
		


	}


});


