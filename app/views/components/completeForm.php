<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
  <title>Planeación Operativa Anual</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-gray-800 text-white font-roboto">
    <form id="newPoaForm" method="POST">
        <div class="flex-1 flex p-3 justify-around">
            <div class="flex flex-col bg-gray-700 basis-8/12 shadow-custom_medium rounded-md font-roboto text-white relative h-[760px] w-[1220px] transition-all duration-300 ease-in-out ">
                <!-- === Part  1 === -->
                <div id="initPoa-first" class="flex flex-col p-6 space-y-6 opacity-100 translate-y-0 transition-all duration-300 ease-in-out">
                    <h2 class="text-xl font-semibold text-center">Planeación Operativa Anual</h2>
                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-300 mb-1">Fecha de elaboración</label>
                            <div class="flex items-center bg-gray-700 rounded-md border border-gray-600">
                                <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-calendar"></i></span>
                                <input type="date"  id="productionDate" name="productionDate" class="flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md" disabled field-description ="Corresponde a la fecha de elaboración del POA.">
                            </div>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-300 mb-1">Ejercicio fiscal</label>
                            <div class="flex items-center bg-gray-700 rounded-md border border-gray-600">
                                <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-briefcase"></i></span>
                                <input type="text" id="fiscalyear" name="fiscalyear" readonly class="flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md" disabled placeholder="Ejercicio fiscal" field-description ="Año en que se registran las operaciones financieras">
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Descripción general</label>
                        <div class="flex items-center bg-gray-700 rounded-md border border-gray-600">
                            <span class="h-24 inline-flex items-center px-3 text-gray-400"><i class="bi bi-textarea-t"></i></span>
                            <textarea id="generalDescription" name="generalDescription" class="h-24 flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md" placeholder="Descripción general" field-description= "Concepto por el cual se está elaborando el POA."></textarea>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-300 mb-1">Fecha de inicio</label>
                            <div class="flex items-center bg-gray-700 rounded-md border border-gray-600">
                                <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-calendar-check"></i></span>
                                <input type="date" id="startDate" name="startDate" class="flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md" field-description="Fecha de inicio que comprende el POA">
                            </div>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-300 mb-1">Fecha de término</label>
                            <div class="flex items-center bg-gray-700 rounded-md border border-gray-600">
                                <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-calendar-x"></i></span>
                                <input type="date" id="endDate" name="endDate" class="flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md" field-description="Fecha de término que comprende el POA">
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-300 mb-1">Área</label>
                            <div class="flex items-center bg-gray-700 rounded-md border border-gray-600 overflow-hidden">
                                <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-diagram-3"></i></span>
                                <select class=" max-w-full truncate flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md" name="area" id="area" field-description="Área Principal">
                                    <option selected disabled>Área</option>
                                </select>
                            </div>
                        </div>
                        <!--<div class="flex-1">
                            <label class="block text-sm font-medium text-gray-300 mb-1">Sub área</label>
                            <div class="flex items-center bg-gray-700 rounded-md border border-gray-600 overflow-hidden">
                                <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-diagram-2"></i></span>
                                <select class="w-full max-w-full truncate flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md" id="minorarea" name="minorarea"  field-description="Área inmediata">
                                    <option selected disabled>Sub área</option>
                                </select>
                            </div>
                        </div>-->
                    </div>

                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-300 mb-1">Sub área</label>
                            <div class="flex items-center bg-gray-700 rounded-md border border-gray-600 overflow-hidden">
                                <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-diagram-2"></i></span>
                                <select class="w-full max-w-full truncate flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md" id="minorarea" name="minorarea"  field-description="Área inmediata">
                                </select>
                            </div>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-300 mb-1">Área derivada</label>
                            <div class="flex items-center bg-gray-700 rounded-md border border-gray-600 overflow-hidden">
                                <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-diagram-2"></i></span>
                                <select class="w-full max-w-full truncate flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md" id="derivatedarea" name="derivatedarea"  field-description="Área derivada">
                                </select>
                            </div>
                        </div>
                    </div>



                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Tipo de gasto</label>
                        <div class="flex bg-gray-700 rounded-md border border-gray-600 p-2">
                            <label class="flex-1 cursor-pointer text-center" field-description="Estratégico comprende gastos como equipos de cómputo, mobiliario, etc">
                                <input type="radio" name="budgetType" id="budgetType" class="hidden peer" value="strategic">
                                <span class="peer-checked:bg-green-600 peer-checked:text-white block px-4 py-2 bg-gray-600 border-2 border-gray-500 rounded-l-md text-sm">Estratégico</span>
                            </label>
                            <label class="flex-1 cursor-pointer text-center" field-description="Corriente comprende gastos como material desechable, consumibles, etc">
                                <input type="radio" name="budgetType" id="budgetType" class="hidden peer" value='checking'>
                                <span class="peer-checked:bg-green-600 peer-checked:text-white block px-4 py-2 bg-gray-600 border-2 border-gray-500 rounded-r-md text-sm">Corriente</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8">
                        <button type="button" onclick="initPoa_changeView('initPoa-first', 'initPoa-second')" class="hover:bg-green-700 border-2 border-green-600 text-white font-semibold py-2 px-4 rounded-md">siguiente</button>
                    </div>
                </div>


                

                <!-- === Part 2 === -->
                <div id="initPoa-second" class="hidden flex-col p-6 space-y-6 opacity-0 translate-y-4 transition-all duration-300 ease-in-out">
                    <h2 class="text-xl font-semibold text-center">Planeación Operativa Anual (Conceptos/actividades)</h2>
                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-300 mb-1">Eje Rector del PDI</label>
                            <div class="flex items-center bg-gray-700 rounded-md border border-gray-600 overflow-hidden">
                                <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-diagram-3"></i></span>
                                <select class="w-full max-w-full truncate flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md" name="pdiAxis" id="pdiAxis"  field-description="Tema esencial de los diversos proyectos estratégicos" >
                                <option selected disabled value=''>Eje rector</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-300 mb-1">Línea de acción del PDI</label>
                            <div class="flex items-center bg-gray-700 rounded-md border border-gray-600 overflow-hidden">
                            <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-diagram-3"></i></span>
                            <select class="w-full max-w-full truncate flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md"  name="actionLine" id="actionLine" field-description=" Actividades específicas, estrategias y acciones diseñadas para lograr un objetivo dentro del PDI">
                                <option selected disabled value=''>Línea de acción</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-300 mb-1">Proyecto o meta del PDI</label>
                        <div class="flex items-center bg-gray-700 rounded-md border border-gray-600 overflow-hidden">
                            <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-diagram-2"></i></span>
                            <select class=" w-full max-w-full truncate flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md" name="project" id="project"  field-description="Finalidad que tiene el PDI">
                                <option selected disabled value=''>Proyecto / meta</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Observaciones</label>
                    <div class="flex items-center bg-gray-700 rounded-md border border-gray-600">
                        <span class="h-36 inline-flex items-center px-3 text-gray-400"><i class="bi bi-textarea-t"></i></span>
                        <textarea id="observations" name="observations" class="h-36 flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md" placeholder="Observaciones" field-description="Descripción o anotaciones respecto al POA"></textarea>
                    </div>
                </div>

                <div class="flex flex-col items-end">
                    <button type="button" class="hover:bg-blue-400 border-2 border-blue-600 text-white font-semibold py-2 px-4 rounded-md" id="addNewConceptPOA" data-bs-toggle="modal" data-bs-target="#addConceptsPOAModal">
                        Añadir concepto/actividad <i class="bi bi-plus-circle"></i>
                    </button>
                    <button type="button" class="hover:bg-blue-400 border-2 border-blue-600 text-white font-semibold py-2 px-4 rounded-md w-9/12 mt-1" id="viewMyConceptsPoa" data-bs-toggle="modal" data-bs-target="#viewPOAConceptsModal">
                        Mis conceptos <i class="bi bi-list"></i>
                    </button>
                </div>

                <div class="flex space-x-4">
                    <div class="flex flex-1 justify-center items-center">
                        <button class="hover:bg-green-700 border-2 border-green-600 text-white font-semibold py-2 px-2 h-24 rounded-full" type="submit">Finalizar</button>
                    </div>
                </div>

                <div class="flex justify-between">
                    <button type="button" onclick="initPoa_changeView('initPoa-second', 'initPoa-first')" class="hover:bg-green-700 border-2 border-green-600 text-white font-semibold py-2 px-4 rounded-md">atrás</button>
                </div>
            </div>
        </div>
    </form>
</body>
</html>



<!-- Step 3 (previously built) will be appended here -->
<!-- === Step 3 === 
<div id="initPoa-third" class="hidden flex-col p-6 space-y-6 opacity-0 transition-all duration-300 ease-in-out">
  <h2 class="text-xl font-semibold text-center">Planeación Operativa Anual (Conceptos/actividades)</h2>

  <!--
  <div class="flex space-x-4">
    <div class="flex-1">
      <label class="block text-sm font-medium text-gray-300 mb-1">Concepto presupuestal</label>
      <div class="flex items-center bg-gray-700 rounded-md border border-gray-600 overflow-hidden">
        <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-diagram-3"></i></span>
        <select class="w-full max-w-full truncate flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md" id="budgetConcept" name="budgetConcept" field-description="Concepto que corresponde a un gasto corriente o gasto estratégico">
          <option selected disabled>Seleccione un tipo</option>
        </select>
      </div>
    </div>
  </div>

  <div class="flex space-x-4">
    <div class="basis-3/12">
      <label class="block text-sm font-medium text-gray-300 mb-1">Fecha de ejecución</label>
      <div class="flex items-center bg-gray-700 rounded-md border border-gray-600">
        <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-calendar-check"></i></span>
        <input type="date" class="flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md">
      </div>
    </div>
    <div class="basis-3/12">
      <label class="block text-sm font-medium text-gray-300 mb-1">Fecha de ejecución</label>
      <div class="flex items-center bg-gray-700 rounded-md border border-gray-600">
        <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-calendar-check"></i></span>
        <input type="date" class="flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md">
      </div>
    </div>
    <div class="basis-6/12">
      <label class="block text-sm font-medium text-gray-300 mb-1">Concepto o actividad</label>
      <div class="flex items-center bg-gray-700 rounded-md border border-gray-600">
        <span class="h-16 inline-flex items-center px-3 text-gray-400"><i class="bi bi-textarea-t"></i></span>
        <textarea class="flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md h-16" placeholder="Concepto o actividad"></textarea>
      </div>
    </div>
  </div>

  <div class="flex space-x-4">
    <div class="basis-3/12">
      <label class="block text-sm font-medium text-gray-300 mb-1">Unidad</label>
      <div class="flex items-center bg-gray-700 rounded-md border border-gray-600">
        <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-diagram-3"></i></span>
        <select class="flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md">
          <option selected disabled>Unidad</option>
          <option>Unidad 1</option>
          <option>Unidad 2</option>
        </select>
      </div>
    </div>
    <div class="basis-3/12">
      <label class="block text-sm font-medium text-gray-300 mb-1">Cantidad</label>
      <div class="flex items-center bg-gray-700 rounded-md border border-gray-600">
        <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-briefcase"></i></span>
        <input type="text" placeholder="Cantidad" class="flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md">
      </div>
    </div>
    <div class="basis-3/12">
      <label class="block text-sm font-medium text-gray-300 mb-1">Costo unitario</label>
      <div class="flex items-center bg-gray-700 rounded-md border border-gray-600">
        <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-briefcase"></i></span>
        <input type="text" placeholder="Costo unitario" class="flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md">
      </div>
    </div>
    <div class="basis-3/12">
      <label class="block text-sm font-medium text-gray-300 mb-1">Importes</label>
      <div class="flex items-center bg-gray-700 rounded-md border border-gray-600">
        <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-briefcase"></i></span>
        <input type="text" placeholder="Importes" readonly class="flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md">
      </div>
    </div>
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-300 mb-1">Concepto Presupuestal</label>
    <div class="flex items-center bg-gray-700 rounded-md border border-gray-600">
      <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-diagram-3"></i></span>
      <select class="flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md">
        <option selected disabled>Seleccione un concepto presupuestal</option>
        <option>Concepto 1</option>
        <option>Concepto 2</option>
      </select>
    </div>
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-300 mb-1">Responsables</label>
    <div class="flex items-center bg-gray-700 rounded-md border border-gray-600 p-2">
      <span class="inline-flex items-center px-3 text-gray-400"><i class="bi bi-briefcase"></i></span>
      <input type="text" placeholder="Buscar responsables" class="flex-1 bg-gray-800 text-white p-2.5 border-none rounded-md outline-none">
    </div>
  </div>



  <div class="flex justify-between h-24">
    <button onclick="initPoa_changeView('initPoa-third', 'initPoa-second')" class="hover:bg-green-700 border-2 border-green-600 text-white font-semibold py-2 px-4 rounded-md h-3/6">
      <i class="bi bi-arrow-left-short"></i> atrás
    </button>
    <div class="flex flex-col items-end">
      <button class="hover:bg-blue-400 border-2 border-blue-600 text-white font-semibold py-2 px-4 rounded-md" id="addNewConceptPOA" data-bs-toggle="modal" data-bs-target="#addConceptsPOAModal">
        Añadir concepto/actividad <i class="bi bi-plus-circle"></i>
      </button>
      <button class="hover:bg-blue-400 border-2 border-blue-600 text-white font-semibold py-2 px-4 rounded-md w-9/12 mt-1" id="viewMyConceptsPoa" data-bs-toggle="modal" data-bs-target="#viewPOAConceptsModal">
        Mis conceptos <i class="bi bi-list"></i>
      </button>
    </div>
  </div>

  <div class="flex space-x-4">
    <div class="flex flex-1 justify-center items-center">
      <button class="hover:bg-green-700 border-2 border-green-600 text-white font-semibold py-2 px-2 h-24 rounded-full">Finalizar</button>
    </div>
  </div>
</div>
</div>
</div>
</body>
</html>
-->