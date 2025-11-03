document.addEventListener("DOMContentLoaded", function(){
    new DataTable('#showPoasTable', {
        language: {
            //url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            url : "assets/various/dataTableSpanishConfig.json"
        }
    }); // Initialise the datatable of the poas

    // Bind a click event to the excel button in order to create the xlsx document 
    const poaExcelButtons = document.querySelectorAll(".btnGeneratePoaExcel");
    poaExcelButtons.forEach( function( button ){
        button.addEventListener("click", function(){
            const poaId = this.getAttribute("data-poaid"); // Get the POA id
            const poaName = this.closest('tr').firstElementChild.textContent.trim();// Get the POA's name from the table 
            // Fetch request with the poa controller and the respective method to build the xlsx document 
            fetch("index.php?controller=poa&method=generatePoaExcel",{
                method: "POST",
                body: new URLSearchParams({ poaId: poaId }) // Send the poa id as parameter 
            })
            .then( response => {
                if( !response.ok ){
                    throw new Error("Error en la descarga del archivo");
                }
                return response.blob(); // Return the file in case there's no error 
            })
            .then( blob => { // If all good, then creates the object url, the a element and then download the file with the POA's name and it extension
                const url = window.URL.createObjectURL( blob );
                const a = document.createElement('a');
                a.href = url;
                a.download = `${poaName}.xlsx`;
                document.body.appendChild( a );
                a.click();
                a.remove();
                window.CryptoKey.revokeObjectURL(url); // Remove the element 
            })
            .catch( error => {
                console.error("Error:", error )
            });
        });
    })

    const buildConcentratedDocumentPoasButton = document.getElementById("buildConcentratedDocumentPoas");
    buildConcentratedDocumentPoasButton.addEventListener("click", function( ){
        fetch("?controller=poa&method=generateConcentratedPoas" )
        .then( response => {
            if( !response.ok ){
                throw new Error("Error al descargar el concentrado");
            }
            return response.blob(); // If all good, then return the blob ( the document pues )
        })
        .then( concentratedPoas  => {
            const url = window.URL.createObjectURL( concentratedPoas );
            const a = document.createElement('a');
            a.href = url;
            a.download = `concentradoPOAS.xlsx`;
            document.body.appendChild( a );
            a.click();
            a.remove();
            window.CryptoKey.revokeObjectURL( url );
        })
        .catch( error => {
            console.error("Error: ", error );
        });
    });

});
