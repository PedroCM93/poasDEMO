document.addEventListener("DOMContentLoaded", function(){
    // Get the main form 
    var poaForm = document.querySelector('#newPoaForm');
    poaForm.addEventListener("submit", function( e ){
        e.preventDefault();// Prevent the page reload
        // Get all the fields of the new poa's form 
        const productionDate = document.querySelector("#productionDate").value;
        const fiscalYear = document.querySelector("#fiscalyear").value;
        const startDate = document.querySelector("#startDate").value;
        const endDate = document.querySelector("#endDate").value;
        const derivatedArea = document.getElementById("derivatedarea");
        const subarea = document.getElementById("minorarea");



        // Stores the subarea that belongs to the created POA ( subarea or derivated area from a subarea )
        var poaArea = "";
        // If the derivated area field is empty, then will be contain the subarea value
        if( derivatedArea.value  == null || derivatedArea.value  == undefined || derivatedArea.value  == '' )
            poaArea = subarea.value;
        else // If there's a derivated area selected, then it will be the value 
            poaArea = derivatedArea.value;

        const generalDescription = document.querySelector('#generalDescription').value;
        const budgetTypes = document.getElementsByName("budgetType"); // Stores the options of the radio, because the b udget type has multiple options
        const budgetTypesNumber = budgetTypes.length; // Stores the previous radio options 
        var selectedBudgetType; // Will store the selected option of the two budget types
        for( let element = 0; element < budgetTypesNumber; element++ ){ // Loop through the radio element 
            if( budgetTypes[element].checked ) // If there's an element selected, then will be the selected budget type 
                selectedBudgetType = budgetTypes[element].value;
        }
        const pdiProject = document.querySelector('#project').value;
        const observations = document.querySelector('#observations').value;
        // Now, get all the rows from the body of the table of the poas concepts
        const rows = document.querySelectorAll("#poaConceptsTableBody tr");
        // This array will contain all the values obtained 
        var poaConcepts = []; 
        // Loop the rows values 
        rows.forEach( row => {
            const cells = row.querySelectorAll("td"); // Get all the td element from every row 
            // Get the attributes that belongs to the budgetconceptid and the unitid of the concept added 
            const budgetConceptId = cells[0].getAttribute("data-budgetconceptid");
            const unitId = cells[2].getAttribute("data-unitid");
            // Take the value of the price in the table, but removing the $ sign at the beginning
            const unitPriceString = String( cells[5].innerText.trim().slice(1) );
            // And replacing the ',' char with an empty space, in order to take only the value with the dot for the decimal values
            const unitPriceFormatted = unitPriceString.replace(',', '' );
            const evidenceId = cells[4].getAttribute("data-evidenceid");
            const evidenceText = cells[4].innerText.trim(); // Get the text content of the evidence
            var otherEvidenceValue = "";
            if( evidenceText.startsWith("OTRO:") ){ // If the evidence text starts with "OTRO:", then it will be the other evidence input value
                otherEvidenceValue = evidenceText.slice(5).trim(); // Remove the "OTRO:" part and trim the value
            }
            // The rowData array will contain all the data in order to store it in the table of the database 
            const rowData = {
                CONCEPT: cells[0].innerText.trim(),
                BUDGETCONCEPT: budgetConceptId,
                AMOUNT: cells[1].innerText.trim(),
                UNIT: unitId,
                UNITPRICE: unitPriceFormatted,
                EXECUTIONMONTHS: cells[3].innerText.trim(),
                EVIDENCE: evidenceId,
                OTHER_EVIDENCE: otherEvidenceValue,
            };
            // Then push the data into the array
            poaConcepts.push( rowData );
        });
        console.log( poaConcepts ); // Debugging purposes, to see the data that will be sent to the server
        const numberofConcepts = poaConcepts.length;
        /*** DATA VALIDATION */
        // Verify if there's at least one concept added in the POA 
        if( numberofConcepts < 1 ){
            showAlert( "POA sin conceptos!", "Debes añadir al menos un concepto al POA!"  );
            return;
        }
        // If the description is empty
        else if( generalDescription == ''  ){
            showAlert("Descripción de POA vacía", "Debes colocar una descripción al POA!");
            return;
        }
        // If the budget type is not selected
        else if ( selectedBudgetType == undefined || selectedBudgetType == '' ){
            showAlert("Elige un tipo de gasto", "Debes seleccionar un tipo de gasto para el POA");
            return;
        }
        // If the pdi project is not selected ( Also means the pdi axis and the action line must be selected too )
        else if( pdiProject == '' || pdiProject == undefined ){
            showAlert("Proyecta o Meta vacío", "Debes seleccionar un proyecto o meta del PDI!");
            return;
        }
        // If the observation textarea is empty 
        else if ( observations == '' || observations == undefined  ){
            showAlert("Observaciones vacías", "Debe escribir una observación para el POA realizado!");
            return;
        }
        // If the poa's area is not defined ( subarea or derivated area )
        else if ( poaArea == '' || poaArea == undefined || poaArea == null ){
            showAlert("Área no definida", "Debes seleccionar un área para el POA!");
            return;
        }
        else{
            // FOrmats the budgetType to spanish, because the system text is showed in spanish
            if( selectedBudgetType == "strategic" )
                selectedBudgetType = "estratégico";
            else
                selectedBudgetType = 'corriente';
            const poaData = new FormData();
            poaData.append("productionDate", productionDate);
            poaData.append("fiscalYear", fiscalYear);
            poaData.append("startDate", startDate);
            poaData.append("endDate", endDate);
            poaData.append("subarea", poaArea);
            poaData.append("generalDescription", generalDescription);
            poaData.append("budgetType", selectedBudgetType);
            poaData.append("pdiProject", pdiProject);
            poaData.append("observations", observations);
            poaData.append("poaConcepts", JSON.stringify( poaConcepts ) );


            // Calls the store method of the poa controller, in order to insert the POA and receive and anwser to that request
            fetch(  "index.php?controller=poa&method=store", {
                    method: "POST",
                    body: poaData
            })
            .then( response => response.json() )
            .then( data => {
                if( data.success ){
                    // Resets the form 
                    const form = e.target;
                    form.reset();
                    showAlertWithRedirect("POA creado con éxito!", data.message, data.location );
                }
                else{
                    showAlert("Error al crear POA", data.message );
                }
            });
            


        }
        
    });
});
 

// Shows a sweet alert modal instead of the ordinary alert 
function showAlert( modalTitle, message, type = "error" ){
    Swal.fire({
        icon: type,
        title: modalTitle,
        text: message,
        background: "#e5e7eb",
        confirmButtonColor: "#2563eb",
        allowOutsideClick: false
    });
}


function showAlertWithRedirect( alertTitle, alertMessage, locationRoute ){
    Swal.fire({
        title: alertTitle,
        text: alertMessage,
        icon: "success",
        timer: 2000,
        showConfirmButton: true,
        confirmButtonText: "Aceptar",
        allowOutsideClick: false,
        willClose: () => {
            location.href = locationRoute;
        }
    });
}

