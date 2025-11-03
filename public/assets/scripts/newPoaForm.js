// Manage the number of the elements added in the body of the table of the POA's concepts 
var poaConceptsAdded = 0;
// Store the current date to set the date inputs with at least that date
var currentDate = new Date();
currentDate = currentDate.toISOString().split('T')[0];// Get the yyyy-mm-dd  format to the current date 

// Stores the months ( In spanish ) in order to fill the execution months UL element
const months = [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ];


const editConceptIcon = `   <i class="ph ph-note-pencil"></i>`;


// Auxiliar function that allows to navegate into the form parts
function initPoa_changeView(firstElement, secondElement, animation = null) {
    const FE = document.getElementById(firstElement);
    const SE = document.getElementById(secondElement);
    const ANIMATION = animation == null ? 'translate-y-4' : animation;
    FE.classList.add('opacity-0', ANIMATION, 'transition-all', 'duration-300', 'ease-in-out');
    setTimeout(() => {
        FE.classList.add('hidden');
        FE.classList.remove('opacity-0', ANIMATION, 'transition-all', 'duration-300');
        SE.classList.remove('hidden');
        SE.classList.add('flex', 'opacity-0', ANIMATION);
        void SE.offsetWidth;
        SE.classList.add('opacity-100', 'translate-y-0', 'transition-all', 'duration-300', 'ease-in-out');
        SE.classList.remove('opacity-0', ANIMATION);
    }, 300);
}


// Auxiliar function that get the field description and later put it on the element that will contain the description
function getFieldDescription( selectedField ){
    const description = selectedField.getAttribute("field-description");
    document.getElementById("selectDescription").textContent = description;

}


let userAreas;

// When the DOM are loaded
document.addEventListener("DOMContentLoaded", function () {

    // Async function that get the user's areas 
    async function getUserAreas( ){
        try{
            const response = await fetch("index.php?controller=poa&method=userAreas");
            if( !response.ok ){
                throw new Error("There's no response to get the user's areas ");
            }
            userAreas  = await response.json(); // Store the user's areas into the variable 
        } catch( error ){
            return null;
        }
    }


    // Set the production date with the current date and set the min to the current date too
    const productionDateInput = document.getElementById("productionDate");
    productionDateInput.value = currentDate;
    productionDateInput.setAttribute("min", currentDate );
    // Set the fiscal year with the next year 
    const fiscalYearInput = document.getElementById("fiscalyear");
    fiscalYearInput.value = parseInt( currentDate.split('-')[0] ) + 1 ;
    // Set the start date with the current date and set thee min value too
    const startDateInput = document.getElementById("startDate");
    startDateInput.value = currentDate;
    startDateInput.setAttribute("min", currentDate );
    // Var that will store the date one day later than the current date
    var oneDayLater = new Date();
    oneDayLater.setDate(oneDayLater.getDate() + 1); // Add one day
    oneDayLater = oneDayLater.toISOString().split('T')[0]; // Format to YYYY-MM-DD
    // Set the end date input, adding one more day to the current date, including it's min value too
    const endDateInput = document.getElementById("endDate");
    endDateInput.value = oneDayLater; // Set the end date to one day later than the current date
    endDateInput.setAttribute("min", oneDayLater);

    // Fill the areas select 
    getUserAreas().then( () => {
        // If the user has at least one area 
        if( userAreas.length > 0 ){
            // If the user has one main area that belongs to that person 
            if( userAreas[0].MAINAREACODE != null ){
                // Stores the main area and subarea values 
                const mainAreaCode = userAreas[0].MAINAREACODE;
                const subAreaCode = userAreas[0].SUBAREACODE;
                // Fill the area and subarea selects 
                fillAreasSelect( 'area',  mainAreaCode );
                fillSubareaSelect( "minorarea", mainAreaCode, subAreaCode );
            }
            // If the subarea is empty, then the users belongs to a derivated area 
            else if ( userAreas[0].SUBAREACODE != null ){
                const derivatedAreaCode = userAreas[0].SUBAREACODE;
                const subareaCode = derivatedAreaCode.split('.')[0];
                const mainAreaCode = getMainAreaCode( subareaCode );
                //const derivatedAreaCode = userAreas[0].SUBAREACODE.split('.')[0];
                fillDerivatedAreasSelect( "derivatedarea", subareaCode, derivatedAreaCode );
                fillSubareaSelect( "minorarea", mainAreaCode, subareaCode );
                fillAreasSelect( "area", mainAreaCode );
            }
        }
        else{
            fillAreasSelect("area");
            
        }
    })
    .catch(err => console.error("Error loading data: ", err));

    //Fill the pdiAxis select 
    fetch( "fetchSelectData.php", {
        method : "POST",
        headers: {
            "Content-Type" : "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({ option: "getPdiAxis"} )
    })
    .then( response => response.json() )
    .then( data => {
        const pdiAxisSelect = document.getElementById("pdiAxis");
        data.forEach( item => {
            const option = document.createElement("option");
            option.value = item.ID;
            option.textContent = item.ID + " " + item.AXISNAME;
            pdiAxisSelect.appendChild( option );
        });
    })
    .catch( err => console.error("Error loading data: ", err ));

    // Fill the budget concepts selector
    fetch( "fetchSelectData.php",{
        method: "POST",
        headers: { 
            "Content-Type" : "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({ option: "getBudgetConcepts"})
    })
    .then ( response => response.json() )
    .then( data => {
            const budgetConceptsSelect = document.getElementById('budgetConcept');
            data.forEach( item => {
                const option = document.createElement("option");
                option.value = item.ID;
                option.textContent = item.CONCEPT;
                budgetConceptsSelect.appendChild( option );
            });
    })
    .catch( err => console.error( "Error loading data: ", err ) );

    // Fill the evidence selector 
    fetch("fetchSelectData.php", {
        method: "POST",
        headers: {        
            "Content-Type" : "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({ option: "getEvidences" })
    })
    .then( response => response.json() )
    .then( data => {
        const evidenceSelect = document.getElementById('evidence');
        data.forEach( item => {
            const option = document.createElement("option");
            option.value = item.ID;
            option.textContent = item.NAME;
            evidenceSelect.appendChild( option );
        });
    })
    .catch( err => console.error("Error loading data: ", err ));

    // Fill the units selector
    fetch("fetchSelectData.php", {
        method : "POST",
        headers: {
            "Content-Type" : "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({ option: "getUnits" } )
    })
    .then( response => response.json() )
    .then( data => {
        const unitsSelect = document.getElementById('unit');
        data.forEach( item => {
            const option = document.createElement("option");
            option.value = item.ID;
            option.setAttribute("data-abbreviation", item.ABBREVIATION); 
            //option.textContent = item.NAME + "(" + item.ABBREVIATION + ")";
            option.textContent = item.NAME.trim();
            unitsSelect.appendChild( option );
        })
    })
    .catch( err => console.error("Error loading data:", err ));

    // For every input of the form will be binded an event in order to get the description and then load it in the selectedDescription paragraph element 
   document.querySelectorAll(".flex-1").forEach( input =>{
        input.addEventListener("mouseenter", function(){
            getFieldDescription( this );
        });
        input.addEventListener("mouseover", function(){
            document.getElementById("selectDescription").textContent = "Selecciona un campo para visualizar su descripción";
        });
    })

    // Autocomplete the fiscal year, taking the date ( Adding one year to the current year )
    document.getElementById('productionDate').addEventListener( "change", function(){
        var fiscalYear;
        // If the value of the production date is not a number, then the fiscal year is 0
        if( this.value == '' || this.value == undefined )
            fiscalYear = 0;
        else // If not, then the fiscal year will be the next year
            fiscalYear = parseInt( this.value.split('-')[0] ) + 1;
        document.getElementById('fiscalyear').value = fiscalYear;
    });

    // When the area changes, then fill the subareas select with the subareas that belongs to the selected area
    document.getElementById('area').addEventListener("change", function( ){
        var selectedArea = this.value;
        document.getElementById('derivatedarea').innerHTML = "";
        fillSubareaSelect( "minorarea", selectedArea );
    });
    // When the subarea changes, it will update the derivated areas from that subarea
    document.getElementById('minorarea').addEventListener("change", function(){
        var selectedSubarea = this.value;
        fillDerivatedAreasSelect("derivatedarea", selectedSubarea );
    });


    // When the pdi axis changes, then fill the action lines select with the action lines that belongs to the selected pdi axis
    document.getElementById('pdiAxis').addEventListener("change", function( ){
        var selectedPdiAxis = this.value;
        document.getElementById('actionLine').innerHTML = '';
        document.getElementById('project').innerHTML = '';
        fetch('fetchSelectData.php', {
            method: "POST",
            headers: { 
                "Content-Type" : "application/x-www-form-urlencoded"
            },
            body: new URLSearchParams({ option: "getActionLines", selectedPdiAxis: selectedPdiAxis  })
        })
        .then( response => response.json()) 
        .then( data =>  {
            const actionLinesSelect =  document.getElementById('actionLine');
            data.forEach( item => {
                const option = document.createElement("option");
                option.value = item.ID;
                option.textContent = item.NUMBER + " " + item.NAME;
                actionLinesSelect.appendChild( option );
            });
            // Get the first value of the action line select 
            var actionLine = document.getElementById('actionLine');
            const firstActionLineSelect = actionLine.options[ 0 ].value; 
            // And get the pdi projects related to that action line 
            fetch('fetchSelectData.php', {
                method : "POST",
                headers: {
                    "Content-Type" : "application/x-www-form-urlencoded"
                },
                body : new URLSearchParams( { option: "getPdiProjects", selectedActionLine: firstActionLineSelect } )
            })
            .then( response => response.json() )
            .then( data => {
                const projectsSelect = document.getElementById("project");
                data.forEach( item => {
                    const option = document.createElement("option");
                    option.value = item.ID;
                    option.textContent = `${item.NUMBER} ${item.DESCRIPTION}`;
                    projectsSelect.appendChild( option );
                })
            })
            .catch( err => console.error("Error loading data: ", err ));

        })
        .catch( err => console.error("Error loading data:", err ));
        
    });

    // Set the current date to the start date in case the start date is earlier than the current date
    document.getElementById('startDate').addEventListener("change", function () {
        const currentDateObject = new Date(); // Creates an object with the current date 
        currentDateObject.setHours(0, 0, 0, 0); // Restart the time to set to 00:00:00 hours 
        const startDateObject = getDateObject(this.value); // creates a date object with the start date and the 00:00:00 hours 
        // Compare the current date and the start date 
        if (currentDateObject.getTime() > startDateObject.getTime()) {
            // If the start date is earlier than the current date then build the string that represents the date
            const year = currentDateObject.getFullYear();
            const month = String(currentDateObject.getMonth() + 1).padStart(2, '0');
            const day = String(currentDateObject.getDate()).padStart(2, '0');
            // Then assign the value to the input 
            const dateValue = `${year}-${month}-${day}`;
            this.value = dateValue;
        }
        // And then sets the value for the end date too
        const startDateStringValue = `${this.value.split('-')[0]},${this.value.split('-')[1]},${this.value.split('-')[2]}`;
        const  endDateObject = new Date( startDateStringValue );
        endDateObject.setDate( endDateObject.getDate() + 1 );
        const endDateYear = endDateObject.getFullYear();
        const endDateMonth = String( endDateObject.getMonth() + 1 ).padStart(2,'0');
        const endDateDay = String( endDateObject.getDate() ).padStart(2,'0');
        const endDateValue = `${endDateYear}-${endDateMonth}-${endDateDay}`;
        // Sets the right end date value and then establish the min value for the end date input
        document.getElementById('endDate').value = endDateValue;
        document.getElementById('endDate').setAttribute("min", endDateValue); // Set the min value for the end date input

    });

    // Set one day after the start Date in case the end date is earlier than the start date
    document.getElementById('endDate').addEventListener("change", function( ){
        const startDate = document.getElementById("startDate").value;
        const stringStartDate = `${startDate.split('-')[0]},${startDate.split('-')[1]},${startDate.split('-')[2]}`;
        const startDateObject = new Date( stringStartDate );
        const endDateObject = getDateObject( this.value );

        if( endDateObject < startDateObject ){
            const nextDayStartDate = new Date(stringStartDate );
            nextDayStartDate.setDate( nextDayStartDate.getDate() + 1 );
            endDateYear = nextDayStartDate.getFullYear();
            endDateMonth = String(  nextDayStartDate.getMonth() + 1 ).padStart(2,'0');
            endDateDay = String( nextDayStartDate.getDate() ).padStart(2,'0');
            this.value = `${endDateYear}-${endDateMonth}-${endDateDay}`;
        }

    });
     

    // Refresh the project selector when the action line change 
    document.getElementById('actionLine').addEventListener( "change", function( ){
        var selectedActionLine = this.value;
        document.getElementById('project').innerHTML = "";
        fetch( "fetchSelectData.php", {
            method: "POST",
            headers: {
                "Content-Type" : "application/x-www-form-urlencoded"
            },
            body: new URLSearchParams( { option: "getPdiProjects", selectedActionLine: selectedActionLine } )
        })
        .then( response => response.json() )
        .then( data => {
            const projectsSelect = document.getElementById("project");
            data.forEach( item => {
                const option = document.createElement("option");
                option.value = item.ID;
                option.textContent = item.NUMBER + " " + item.DESCRIPTION;
                projectsSelect.appendChild( option );
            });
        })
        .catch( err => console.error("Error loading data: ", err ));
    });



    // When the budget concept doesn't have finantial funding ( When the 'Sin presupuesto' option is selected )
    document.getElementById("budgetConcept").addEventListener("change", function( ){
        const unitSelector = document.getElementById("unit");
        const amountInput = document.getElementById("amount");
        const unitPriceInput = document.getElementById("unitPrice");
        const selectedOption = this.options[this.selectedIndex].textContent.trim(); // Stores the selected option text content
        if( selectedOption === "Sin presupuesto" ){ // If the selected option is "Sin presupuesto" 
            /*  It will make that the unit selector will be disabled and the value will be "No aplica",
                the amount and unitPrice will be 0 and disabled too */
            selectOption( unitSelector, "No aplica");
            unitSelector.setAttribute("disabled", true);
            amountInput.value = 0; // Set the amount to 0
            amountInput.setAttribute("disabled", true);
            unitPriceInput.value = 0; // Set the unit price to 0
            unitPriceInput.setAttribute("disabled", true);
        } 
        else{
            // If the selected option is not "Sin presupuesto", then enable the unit selector, amount and unit price inputs
            unitSelector.removeAttribute("disabled");
            amountInput.removeAttribute("disabled");
            unitPriceInput.removeAttribute("disabled");
            // And set the value of the amount and unit price to empty
            amountInput.value = 1;
            unitPriceInput.value = 0.10;  
            unitSelector.value = ""; // Set the unit selector to empty
        }
    });


    // When the evidence selector changes and the selected option is "OTRO"
    document.getElementById("evidence").addEventListener("change", function( ){
        const otherEvidenceContainer = document.getElementById("otherEvidenceContainer");
        var selectedOption = this.options[this.selectedIndex].textContent.trim(); // Get the selected option text content
        if( selectedOption === "OTRO" ){ // If the evidence is another (OTRO) of the listed 
            otherEvidenceContainer.innerHTML = `<input class="w-full max-w-full truncate flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md" type="text" name="otherEvidence" id="otherEvidence" placeholder="Escribe aquí la otra evidencia">`;
        } 
        else{
            otherEvidenceContainer.innerHTML = ""; // If not, then will clean the other evidence container
        }  
        
    });

    
    // When the add concepts modal is opened
    const addConceptsModal = document.getElementById('addConceptsPOAModal');
    addConceptsModal.addEventListener("show.bs.modal", function( ){
        const executionMonthsContainer = document.getElementById("executionMonths");
        executionMonthsContainer.innerHTML = ""; // Clean the execution months container
        const firstMonth = parseInt( document.getElementById("startDate").value.split('-')[1] ); // Get the start month value
        const secondMonth = parseInt( document.getElementById("endDate").value.split('-')[1]); // Get the end month value
        if( secondMonth > firstMonth ){
            const selectAllCheck = `    <li class="flex items-center">
                                            <input type="checkbox" id="checkAllMonths" name="month" value="allMonths">
                                            <label for="selectAllMonths" class="ml-2">Seleccionar todos</label>
                                        </li>`;
            executionMonthsContainer.insertAdjacentHTML('beforeend', selectAllCheck ); // Insert the select all checkbox
        }
        // Set the range of months in order to fill the UL element that contains the execution months
        for( let month = firstMonth; month <= secondMonth; month++ ){
            const monthElement = `  <li class="flex items-center">
                                        <input type="checkbox"  name="month" value="${months[month - 1]}">
                                        <label for="month" class="ml-2">${months[month - 1]}</label>
                                    </li>`;
            // Insert the month element into the execution months container
            executionMonthsContainer.insertAdjacentHTML('beforeend', monthElement );
        }

        const checkAllMonthsCheckbox = document.getElementById("checkAllMonths");
        if( checkAllMonthsCheckbox ){  // iF the select all checkbox exists
            checkAllMonthsCheckbox.addEventListener("change", function( ){
                // If the checkbox to select all the months is checked
                if( this.checked ){
                    // If the checkbox is checked, then check all the months checkboxes
                    const monthCheckboxes = document.querySelectorAll("input[name='month']");
                    monthCheckboxes.forEach( checkbox => {
                        if( checkbox.value != "allMonths" ) // If the checkbox is not the select all checkbox
                            checkbox.checked = true; // Then check the checkbox
                    });
                }
                else{
                    // If the checkbox to select all the months is unchecked, then uncheck all the months checkboxes
                    const monthCheckboxes = document.querySelectorAll("input[name='month']");
                    monthCheckboxes.forEach( checkbox => {
                        if( checkbox.value != "allMonths" ) // If the checkbox is not the select all checkbox
                            checkbox.checked = false; // Then uncheck the checkbox
                    });
                }
            });
        }
    });


    // Handle the concepts POA form when the form is submitted 
    document.getElementById("POAConceptsForm").addEventListener("submit", function( e ){
        e.preventDefault(); // To prevent the page reload
        // Get all the data for the table         
        var budgetConcept = this.querySelector('#budgetConcept').value;
        var activityConcept = this.querySelector('#activityConcept').value;
        var evidence = this.querySelector('#evidence').value;
        var evidenceText = this.querySelector('#evidence option:checked').textContent.trim(); // Get the text content of the selected evidence option
        // Contains the element that contains the input for other kind of evidence 
        const otherEvidenceInput = this.querySelector("#otherEvidence");
        // If that input exists
        if( otherEvidenceInput ){
            evidenceText = "OTRO: " + otherEvidenceInput.value.trim(); // Then the evidence text will be that value
        }

        //var responsibleArea = this.querySelector('#responsibleArea').value;
        var unit = this.querySelector('#unit');
        const selectedUnit = unit.options[unit.selectedIndex]; // Get the selected index
        const unitAbbreviation = selectedUnit.getAttribute('data-abbreviation'); // In order to get the data-abbreviation attribute 
        const unitName = selectedUnit.textContent.trim(); // Get the text content of the selected option
        var amount = this.querySelector('#amount').value;
        var unitPrice = this.querySelector('#unitPrice').value;
        var executionMonths = "";
    
        const monthCheckboxes = document.querySelectorAll("input[name='month']"); // Get all the month checkboxes
        monthCheckboxes.forEach( checkbox => {
            if( checkbox.checked && checkbox.value != "allMonths" ){ // If the checkbox is checked and it's not the select all checkbox
                executionMonths += checkbox.value + "-"; // Then add the month value to the execution months string
            }
        });
        
        if( executionMonths.length > 0 ){ // If the execution months string is not empty
            executionMonths = executionMonths.slice(0, -1); // Remove the last hyphen   
        }

        // The concept will be added if all the fields are filled
        if(     budgetConcept != '' && budgetConcept != undefined  && activityConcept != '' &&  unit != '' && unit != undefined && amount != '' 
                && unitPrice != '' && executionMonths != "" && executionMonths != undefined  && evidence != '' && evidence != undefined  ){
            // If the concept are correct, then add plus 1 to the concepts variable
            poaConceptsAdded++;
            // If there's one concept at least, then insert the table into the POA's concepts modal body
            if( poaConceptsAdded == 1 ){
                var poaConceptsModalBody = document.getElementById('viewPOASConceptModalBody');
                var poaConceptsModalBodyContent = ` 
                                                    <div class="table-responsive">    
                                                        <table class="table table-dark table-hover">
                                                            <thead>
                                                                <th>Concepto</th>
                                                                <th>Cantidad</th>
                                                                <th>Unidad</th>
                                                                <th>Mes(es) de ejecución</th>
                                                                <th>Tipo de evidencia</th>
                                                                <th>Costo Unitario</th>
                                                                <th>Importes</th>
                                                               <th colspan=2></th>
                                                            </thead>
                                                            <tbody id="poaConceptsTableBody">
                                                            </tbody>
                                                            <tfoot id="poaConceptsTableFooter">
                                                            </tfoot>
                                                        </table>
                                                    </div>`;
                poaConceptsModalBody.textContent = ""; // Clean the modal body
                poaConceptsModalBody.insertAdjacentHTML('beforeend', poaConceptsModalBodyContent ); // Then , inserts the table 
            }
            var total = parseFloat( unitPrice ) * amount; // Calculate the total per unit and price
            // Build the row for the table 
            // Formats the unit price of the concept
            const formattedUnitPrice = new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }).format(unitPrice);
            // Formats the total amount of the concept 
            const formattedTotal = new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }).format( total );
            var conceptRow = `  <tr>
                                    <td data-budgetconceptid="${budgetConcept}">${activityConcept}</td>
                                    <td class="text-center">${amount}</td>
                                    <td data-unitId="${unit.value}">${unitName}</td>
                                    <td>${executionMonths}</td>
                                    <td data-evidenceId="${evidence}">${evidenceText}</td>
                                    <td>$${formattedUnitPrice}</td>
                                    <td>$${formattedTotal}</td>
                                    <!--<td><button type="button" class="btn btn-info editConceptBtn">${editConceptIcon}Modificar</button></td>-->
                                    <td><button type="button" class="btn btn-danger removeConceptBtn">Quitar</button></td>
                                </tr>`;
            // Get the table body element
            var poaConceptsTableBody = document.getElementById("poaConceptsTableBody");
            // Then, add the row in the body of the table
            poaConceptsTableBody.insertAdjacentHTML('beforeend', conceptRow );

            /*

            var subtotal = 0; // It will store the subtotal of all the concepts showed in the table 
            const poaConceptsTableRows = document.querySelectorAll("#poaConceptsTableBody tr");
            poaConceptsTableRows.forEach( row => {
                const importCell = row.querySelector("td:nth-child(7)").textContent; // Get the import cell text 
                // Now, remove the $ and , characters from the import cell text 
                const importValue = parseFloat(importCell.replace(/[$,]/g, '')); // Get the import value
                subtotal += importValue; // Add the import value to the subtotal
            });







            /*
            // Get all the rows of the table body and then calculate the total amount of the concepts
            const poaConceptsTableRows = document.querySelectorAll("#poaConceptsTableBody tr");
            var totalAmount = 0; // Variable that will store the total amount of the concepts
            poaConceptsTableRows.forEach( row => {
                const amountCell = row.querySelector("td:nth-child(2)"); // Get the amount cell
                const unitPriceCell = row.querySelector("td:nth-child(6)"); // Get the unit price cell  
                if( amountCell && unitPriceCell ){ // If the amount and unit price cells exist
                    const amountValue = parseFloat(amountCell.textContent); // Get the amount value
                    const unitPriceValue = parseFloat(unitPriceCell.textContent.replace(/[$,]/g, '')); // Get the unit price value and remove the $ and , characters
                    totalAmount += amountValue * unitPriceValue; // Add the total amount of the concept to the total amount
                }
            });
            // Get the footer of the table
            var poaConceptsTableFooter = document.getElementById("poaConceptsTableFooter");
            // If the footer is empty, then insert the footer with the total amount of the concepts
            if( poaConceptsTableFooter.innerHTML == "" ){
                var footerContent = `<tr>
                                        <td colspan="6" class="text-end">Total:</td>
                                        <td colspan="2">$${new Intl.NumberFormat('en-US', {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2,
                                        }).format(totalAmount)}</td>
                                    </tr>`;
                poaConceptsTableFooter.insertAdjacentHTML('beforeend', footerContent ); // Insert the footer content
            }
                */

            // Get the add concepts modal 
            var poasConceptsModal = document.getElementById('addConceptsPOAModal');
            // Get the instance of the modal
            var bsModal = bootstrap.Modal.getInstance( poasConceptsModal ) || new bootstrap.Modal( poasConceptsModal );
            // Resets the other evidence container, in order to "clean" the form for another concept 
            this.querySelector("#otherEvidenceContainer").innerHTML = "";
            // Finally, hide the modal
            bsModal.hide();
            // And reset the form
            this.reset();
        }
        else{
            alert("Debes llenar todos los campos!");
        }
   });

    // When the poas concept modal is open
    const poasConceptModal = document.getElementById('viewPOAConceptsModal');
    poasConceptModal.addEventListener("shown.bs.modal", function( ){
        // When the remove concept button is clicked, then remove the row of the concept related to that button
        const removeConceptButtons = document.querySelectorAll(".removeConceptBtn");
        const editConceptButtons = document.querySelectorAll(".editConceptBtn");
        removeConceptButtons.forEach( button => {
            button.addEventListener("click", function( ){
                const row = this.closest("tr");
                if ( row )
                    row.remove();
            });
        });

        editConceptButtons.forEach( button => {
            button.addEventListener("click", function( ){
                alert("Se edita el concepto");
            });
        })
   });

   // When the poas concept modal is show ( Before the modal is shown )
    poasConceptModal.addEventListener("show.bs.modal", function( ){
            var subtotal = 0; // It will store the subtotal of all the concepts showed in the table 
            const poaConceptsTableRows = document.querySelectorAll("#poaConceptsTableBody tr");
            poaConceptsTableRows.forEach( row => {
                const importCell = row.querySelector("td:nth-child(7)").textContent; // Get the import cell ( number 7 ) text 
                // Now, remove the $ and , characters from the import cell text 
                const importValue = parseFloat(importCell.replace(/[$,]/g, '')); // Stores the import value
                subtotal += importValue; // Add the import value to the subtotal
            });

            if( subtotal != 0 ){ // The content will be added only if there's one concept at least ( subtotal is not 0 )
                var footerContent = `<tr>
                        <td colspan="6" class="text-end">Subtotal:</td>
                        <td colspan="2">$${new Intl.NumberFormat('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2,
                        }).format(subtotal)}</td>
                    </tr>`;
                document.getElementById("poaConceptsTableFooter").innerHTML = footerContent; // Set the footer content
            }

    });




});


// Returns a date object with the given date in the parameter
function getDateObject(givenDate) {
    const [year, month, day] = givenDate.split('-').map(Number);
    return new Date(year, month - 1, day); // JS months are 0-based
}

// Function that fills the area ( main area ) selector, with an optional value in order to select that option if not empty 
function fillAreasSelect( areasSelectId, selectedOption = "" ){
    const areasSelect = document.getElementById(areasSelectId);
    areasSelect.innerHTML = "";
    const firstOption = document.createElement("option");
    firstOption.value= "";
    firstOption.textContent = "Área";
    areasSelect.appendChild( firstOption );
    fetch("fetchSelectData.php", {
        method: "POST",
        headers: {
            "Content-Type" : "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams( { option: "getAreas"})
    })
    .then( response => response.json() )
    .then( areas => {
        areas.forEach( area => {
            const option = document.createElement('option');
            option.value = area.AREACODE;
            if( selectedOption != "" && selectedOption != null  ){
                if( selectedOption == area.AREACODE )
                    option.setAttribute("selected", true );
            }
            option.textContent = area.NAME;
            areasSelect.appendChild( option );
        })
    })
}

// Function that fills the subareas seelect, same as the areas selector, contains an optional parameter to select the value if is not empty
function fillSubareaSelect( subareaSelectId, selectedArea,  selectedOption = "" ){
    const subareasSelect = document.getElementById( subareaSelectId );
    subareasSelect.innerHTML = "";
    fetch("fetchSelectData.php", {
        method: "POST",
        headers: {
            "Content-Type" : "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams( { option: "getSubareas", selectedArea : selectedArea } )
    })
    .then( response => response.json() )
    .then( subareas => {
        subareasSelect.innerHTML = "";
        subareas.forEach(subarea => {
            const option = document.createElement("option");
            option.value = subarea.SUBAREACODE;
            option.textContent = subarea.NAME;
            // If the selected option is not empty in the parameter values 
            if( selectedOption != "" && selectedOption != null ){
                // If the subareas belongs to the user, then will be selected 
                if( selectedOption == option.value )
                    option.setAttribute("selected", true );
            }
            subareasSelect.appendChild( option );
        })
    })
}

// Fill the derivated areas selector 
function fillDerivatedAreasSelect( derivatedAreasSelectId, selectedSubarea, selectedOption = "" ){
    const derivatedAreasSelect = document.getElementById( derivatedAreasSelectId );
    derivatedAreasSelect.innerHTML = "";
    fetch("fetchSelectData.php", {
        method: "POST",
        headers: {
            "Content-Type" : "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams( { option: "getDerivatedAreas", subarea: selectedSubarea  })
    })
    .then( response => response.json() )
    .then( derivatedAreas => {
        derivatedAreasSelect.innerHTML = "";
        derivatedAreas.forEach( derivatedArea => {
            const option = document.createElement("option");
            option.value = derivatedArea.CODE;
            option.textContent = derivatedArea.NAME;
            if( selectedOption == derivatedArea.CODE )
                option.setAttribute("selected", true ); 
            derivatedAreasSelect.appendChild( option );
        })
    })
}

// Get the subarea code from a derivated area code 
function getMainAreaCode( subarea ){
    var mainAreaCode = "";
    for( let letter = 0; letter < subarea.length; letter++ ){
        if( !subarea[letter].match(/\d+/g) )
      		mainAreaCode += subarea[letter];
    }
    return mainAreaCode;
}

// Select an option from a selector by the text content of the option
function selectOption( selectorElement , valueToSelect ){
    //const selector = document.getElementById( selectorId );
    for( let option = 0; option < selectorElement.options.length; option++ ){
        if( selectorElement.options[ option ].textContent === valueToSelect ) {
	        selectorElement.selectedIndex = option;
	        break;
	    }
    }
}