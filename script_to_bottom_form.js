<script>
//The event is submit_success so you can catch it for example:
jQuery( document ).ready(function( $ ){
    $( document ).on('submit_success', function( event, response ){
        if ( response.data.output ) {
            let data = JSON.parse(response.data.output)
            console.log(data)
            if(data.status == 200){
                document.querySelector('#formAccountMessage').innerHTML = 'Conta criada com sucesso! Em Breve, será redirecioado.'
                setTimeout(() => {
                    location.href = ''
                }, 3000)
            }
            if(data.status == 400){
                document.querySelector('#formAccountMessage').innerHTML = 'Os dados estão incorretos ou a conta já existe'
            }
            else{

            }
            /*
            {
                "status":200,
                "message":"User teste03@rdmarketing.com.br - teste03@rdmarketing.com.br successfully inserted"
            }
            */
            console.log( response.data.output  );
        }
    });
});
</script>