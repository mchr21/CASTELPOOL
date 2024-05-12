<script>

    //usaremos el framework onScan.js en el repositori  axenox/onscan.js -----podemos revisar mucha info de otros eventos que utiliza este framework 
    //es un frameworj de js el cual nos permite escuchar eventos de lecturas de codigo de barra a travez de hardware(que son los lectores)
	
    try{
    
        onScan.attachTo(document, {
      //  suffixKeyCodes: [13],//13 es la pulsacion de la tecla enter
        onScan: function(barcode) { //definomos dos fuciones collback una para definir la lectura de codigo de barras
            console.log(barcode) //lee el codigo de barras
            window.Livewire.dispatch('scan-code', barcode)//emitimos el evento con js para poder capturar en el backent y buscar el cod de barras en la bd para posteriormente agregarloa a la grillla de eventos
        },
        onScanError: function(e){ //la segunda sera cuando se intenta se lee ese codigo pero de manera incompleta es decir cuando hay errores
            console.log(e) // capturamos e imprimimos el error
        }
    })
    
    console.log('Scanner ready!') //msj el escaner esta listo
    
    
    } catch(e){
        console.log('Error de lectura: ', e)//mensaje de error
    }
    
    
    </script>
    
    