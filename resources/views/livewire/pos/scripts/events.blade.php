<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.Livewire.on('scan-ok',
        Msg => { //	usamos para capturar todas las operaciones de ok en cuanto al codigo de barras se refiere
            noty(Msg) // le mandamos el mensaje que nos devuelne el backend dentro del ecvento
        })

        window.Livewire.on('scan-notfound', Msg => { //evento cuando no 	encontramos el prod a en la bd	
            
            noty(Msg, 2) //para que pase msj de tipo alert warning
          //  console.log('Mensaje a mostrar:', msg); // Imprimir el mensaje que se va a mostrar
          //  toastr.success(msg);

          //  doAction()
        })

        window.Livewire.on('no-stock', Msg => {
            noty(Msg, 2)
        })

        
        // 	window.Livewire.on('sale-ok', Msg => {	
        // 		console.log('sale-ok')	/////////////
        // 	//@this.printTicket(Msg)		
        // 	noty(Msg)			
        // })

        window.Livewire.on('sale-error', Msg => {
            noty(Msg, 2)
        })

        

        // window.Livewire.on('print-ticket', info => { //////////////////////////

        //     if (getBrowser() != 'edge') {
        //         window.open("print://" + info, '_self').close()
        //     } else {
        //         window.open("print://" + info)
        //         //obj.close()
        //     }

        // })

     window.Livewire.on('print-ticket', saleId => { /////////////////////////
          
                window.open("print://" + saleId , '_blank').close
           
              
          

        })




        
        // window.Livewire.on('print-last-id', saleId => {///////////////////////////////////
        //     window.open("print://" + saleId, '_self')
        //     //window.open("print://" + saleId,  '_self').close()//en chrome cierra la ventana
        // })


    })
</script>

{{-- 
<script>


    //console.log(window.navigator.userAgent.toLowerCase().indexOf("edge"))






    // function getBrowser(agent) {   ////////////////////////////
    //     var agent = window.navigator.userAgent.toLowerCase()
    //     switch (true) {
    //         case agent.indexOf("edge") > -1:
    //             return "edge";
    //         case agent.indexOf("edg") > -1:
    //             return "chromium based edge (dev or canary)";
    //         case agent.indexOf("opr") > -1 && !!window.opr:
    //             return "opera";
    //         case agent.indexOf("chrome") > -1 && !!window.chrome:
    //             return "chrome";
    //         case agent.indexOf("trident") > -1:
    //             return "ie";
    //         case agent.indexOf("firefox") > -1:
    //             return "firefox";
    //         case agent.indexOf("safari") > -1:
    //             return "safari";
    //         default:
    //             return "other";
    //     }
    // }










    // console.log(getBrowser())
</script> --}}
