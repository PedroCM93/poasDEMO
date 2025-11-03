document.addEventListener("DOMContentLoaded", function( ){
    const informButton = document.getElementById("btnInform");
    informButton.addEventListener("click", function(){
            const fiscalYear = this.getAttribute("data-fiscalyear");
            
            fetch("?controller=poa&method=generateInformPerArea", {
                method:"POST",
                body: new URLSearchParams( { fiscalYear : fiscalYear })
            })
            .then( response => {
                if( !response.ok ){
                    throw new Error("Error al descargar el archivo");
                }
                return response.blob();
            })
            .then( blob => {
                const url = window.URL.createObjectURL( blob );
                const a = document.createElement( 'a' );
                a.href = url;
                a.download = `reportByAreas.xlsx`;
                a.click();
                a.remove();
                window.CryptoKey.revokeObjectURL( url );
            })
            .catch( error => {
                console.error ("Error: ", error );
            });
    });
});