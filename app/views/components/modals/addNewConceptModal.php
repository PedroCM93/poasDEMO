
<!-- Modal that contains the POAS concepts added in the form  -->
<div class="modal fade" id="addConceptsPOAModal" tabindex="-1" aria-labelledby="poaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content custom-modal-bg text-white">
            <div class="modal-header border-0">
                <h5 class="modal-title text-md-center" id="poaModalLabel">Nuevo concepto/actividad del POA</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <form id='POAConceptsForm'>
                    <div class="flex space-x-4">
                        <div class="basis-6/12">
                            <label class="block text-sm font-medium text-gray-300 mb-1">Concepto presupuestal</label>
                            <div class="flex items-center bg-gray-700 rounded-md border border-gray-600 overflow-hidden">
                                <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-diagram-3"></i></span>
                                <select class="w-full max-w-full truncate flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md" id="budgetConcept" name="budgetConcept" field-description="Concepto que corresponde a un gasto corriente o gasto estratégico">
                                    <option selected disabled value=''>Seleccione un tipo</option>
                                </select>
                            </div>
                        </div>
                        <div class="basis-6/12">
                            <label class="block text-sm font-medium text-gray-300 mb-1">Evidencia</label>
                            <div class="flex items-center bg-gray-700 rounded-md border border-gray-600 overflow-hidden">
                                <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-diagram-3"></i></span>
                                <select class="w-full max-w-full truncate flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md" id="evidence" name="evidence" field-description="Evidencia adjunta al concepto o actividad del POA">
                                    <option selected disabled value=''>Seleccione una evidencia</option>
                                </select>
                            </div>
                            <div id="otherEvidenceContainer" >
                                <!--<input  class="w-full max-w-full truncate flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md" type="text" name="" id="" placeholder="Lista aquí la otra evidencia">-->
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <div class="basis-8/12">
                            <label class="block text-sm font-medium text-gray-300 mb-1">Concepto o actividad</label>
                            <div class="flex items-center bg-gray-700 rounded-md border border-gray-600">
                                <span class="h-16 inline-flex items-center px-3 text-gray-400"><i class="bi bi-textarea-t"></i></span>
                                <textarea class="flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md h-16" placeholder="Concepto o actividad" id="activityConcept"></textarea>
                            </div>
                        </div>
                        <div class="basis-8/12">
                            <label class="block text-sm font-medium text-gray-300 mb-1">Mes/Meses de ejecución</label>
                            <div class="flex items-center bg-gray-700 rounded-md border border-gray-600">
                                <!-- Will store the execution months -->
                                <ul class="flex flex-wrap gap-2 p-2.5" id="executionMonths"> 
                                </ul>   
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <div class="basis-4/12">
                            <label class="block text-sm font-medium text-gray-300 mb-1">Unidad</label>
                            <div class="flex items-center bg-gray-700 rounded-md border border-gray-600">
                                <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-diagram-3"></i></span>
                                <select class="flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md" id="unit" name="unit">
                                    <option selected disabled value=''>Unidad</option>
                                </select>
                            </div>
                        </div>
                        <div class="basis-4/12">
                            <label class="block text-sm font-medium text-gray-300 mb-1">Cantidad</label>
                            <div class="flex items-center bg-gray-700 rounded-md border border-gray-600">
                                <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-briefcase"></i></span>
                                <input type="number" id='amount' placeholder="Cantidad" class="flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md" min=1 value=1>
                            </div>
                        </div>
                        <div class="basis-4/12">
                            <label class="block text-sm font-medium text-gray-300 mb-1">Costo unitario</label>
                            <div class="flex items-center bg-gray-700 rounded-md border border-gray-600">
                                <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-briefcase"></i></span>
                                <input type="number" id='unitPrice' placeholder="Costo unitario" class="flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md" value=0.10 min = 0.10 step=0.01 >
                            </div>
                        </div>
                    </div>
                    <!--<div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Concepto Presupuestal</label>
                        <div class="flex items-center bg-gray-700 rounded-md border border-gray-600">
                            <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-diagram-3"></i></span>
                            <select class="flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md">
                                <option selected disabled>Seleccione un concepto presupuestal</option>
                                <option>Concepto 1</option>
                                <option>Concepto 2</option>
                            </select
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Responsables</label>
                        <div class="flex items-center bg-gray-700 rounded-md border border-gray-600 p-2">
                            <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-briefcase"></i></span>
                            <input type="text" id='responsibleArea' placeholder="Buscar responsables" class="flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md outline-none">
                        </div>
                    </div>
                    -->
                    <div>
                        <br>
                        <button type="submit" class="flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md outline-none btn btn-success" id="addPOAConceptBtn">Añadir concepto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


