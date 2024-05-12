<script>
	var listener = new window.keypress.Listener(); //usaremos la libreria de dmauro/keypress, q nos pide que definamos un listener para escuchar los eventos del teclado

	listener.simple_combo("f6", function() {
		console.log('f6')
		Livewire.dispatch('saveSale') //saveSale envia desde el boton Guardar de coinsblade	
        
    })

	listener.simple_combo("f8", function() { //cuando presionan f8 que se habilite en la caja, ponemos el foco, de texto vacia 
		document.getElementById('cash').value =''// cash es la caja de texto
		document.getElementById('cash').focus()
		document.getElementById('hiddenTotal').value =''
	})
	
	// listener.simple_combo("f7", function() {
	// 	console.log('print last : f10')
	// 	livewire.emit('print-last')
	// })

	listener.simple_combo("f4", function() {//para cancelar--- solo estara en caso de que hayan productos en el carrito
		var total = parseFloat(document.getElementById('hiddenTotal').value)	//validamos que tenga un total	
		if(total > 0) {
			Confirm(0, 'clearCart', '¿SEGUR@ DE ELIMINAR EL CARRITO?') //primero el id de producto a eliminar , ninguno por eso 0, el segundo parametro es el evento que vamos a emitir y el tercero el msj
		} else 
		{
			noty('AGREGA PRODUCTOS A LA VENTA')
		}
	})



</script>