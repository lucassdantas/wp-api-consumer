jQuery( document ).ready(function( $ ){
    $( document ).on('submit_success', function( event, response ){
        if ( response.data.output ) {
            let data = JSON.parse(response.data.output)
            if(data.status == 200){
                document.querySelector('#formAccountMessage').innerHTML = 'Conta criada com sucesso! Em Breve, será redirecioado.'
                setTimeout(() => {
                    location.href = 'https://prisma.devrdmarketing.com/obrigado/'
                }, 3000)
            }else if(data.status == 400){
                document.querySelector('#formAccountMessage').innerHTML = 'Os dados estão incorretos ou a conta já existe'
            }
        }
    });
});