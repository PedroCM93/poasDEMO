
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Annual Operational Planning</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .form-section { background-color: #343a40; color: white; border-radius: 8px; padding: 20px; margin-bottom: 20px; display: none; }
    .form-label { color: #adb5bd; }
    .form-control, .form-select { background-color: #495057; color: white; border: none; }
    .form-check-label { color: #adb5bd; }
    .btn-custom { background-color: #198754; color: white; }
    .form-section.active { display: block; }
    .btn-custom-outline { border: 1px solid #198754; color: #198754; background-color: transparent; }
    .btn-custom-outline:hover { background-color: #198754; color: white; }
  </style>
</head>
<body>
<div class="container mt-4">
  <h2 class="mb-4 text-center">Annual Operational Planning of Activities</h2>

  <form id="poaForm">
    <!-- Section 1 -->
    <div class="form-section active" id="section1">
      <h5 class="mb-3">Annual Operational Planning</h5>
      <div class="row mb-3">
        <div class="col">
          <label class="form-label">Fecha de elaboración</label>
          <input type="date" class="form-control" required>
        </div>
        <div class="col">
          <label class="form-label">Ejercicio fiscal</label>
          <input type="text" class="form-control" placeholder="Fiscal year" required>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Descripción general</label>
        <textarea class="form-control" rows="2" required></textarea>
      </div>
      <div class="row mb-3">
        <div class="col">
          <label class="form-label">Fecha de inicio</label>
          <input type="date" class="form-control" required>
        </div>
        <div class="col">
          <label class="form-label">Fecha de término</label>
          <input type="date" class="form-control" required>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col">
          <label class="form-label">Área</label>
          <select class="form-select" required>
            <option value="">Select Area</option>
            <option>Example Area</option>
          </select>
        </div>
        <div class="col">
          <label class="form-label">Sub área</label>
          <select class="form-select" required>
            <option value="">Select Subarea</option>
            <option>Example Subarea</option>
          </select>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Tipo de gasto</label>
        <div class="d-flex">
          <div class="form-check me-3">
            <input class="form-check-input" type="radio" name="tipoGasto" id="estrategico" required>
            <label class="form-check-label" for="estrategico">Estratégico</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="tipoGasto" id="corriente" required>
            <label class="form-check-label" for="corriente">Corriente</label>
          </div>
        </div>
      </div>
      <div class="text-end">
        <button type="button" class="btn btn-custom" onclick="nextSection()">Next</button>
      </div>
    </div>

    <!-- Section 2 -->
    <div class="form-section" id="section2">
      <h5 class="mb-3">Planeación Operativa Anual (Conceptos/actividades)</h5>
      <div class="mb-3">
        <label class="form-label">Eje Rector del PDI</label>
        <select class="form-select" required>
          <option value="">Select axis</option>
          <option>Example axis</option>
        </select>
      </div>
      <div class="row mb-3">
        <div class="col">
          <label class="form-label">Línea de acción del PDI</label>
          <select class="form-select" required>
            <option value="">Select line</option>
            <option>Example line</option>
          </select>
        </div>
        <div class="col">
          <label class="form-label">Proyecto o meta del PDI</label>
          <select class="form-select" required>
            <option value="">Select project/goal</option>
            <option>Example project</option>
          </select>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Observaciones</label>
        <textarea class="form-control" rows="2"></textarea>
      </div>
      <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-custom-outline" onclick="prevSection()">Back</button>
        <button type="button" class="btn btn-custom" onclick="nextSection()">Next</button>
      </div>
    </div>

    <!-- Section 3 -->
    <div class="form-section" id="section3">
      <h5 class="mb-3">Execution and Budget</h5>
      <div class="mb-3">
        <label class="form-label">Tipo de cuenta</label>
        <select class="form-select" required>
          <option value="">Select account type</option>
          <option>Example account</option>
        </select>
      </div>
      <div class="row mb-3">
        <div class="col">
          <label class="form-label">Fecha de ejecución (inicio)</label>
          <input type="date" class="form-control" required>
        </div>
        <div class="col">
          <label class="form-label">Fecha de ejecución (fin)</label>
          <input type="date" class="form-control" required>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Concepto o actividad</label>
        <textarea class="form-control" rows="2" required></textarea>
      </div>
      <div class="row mb-3">
        <div class="col">
          <label class="form-label">Unidad</label>
          <select class="form-select" required>
            <option value="">Select unit</option>
            <option>Piece</option>
          </select>
        </div>
        <div class="col">
          <label class="form-label">Cantidad</label>
          <input type="number" class="form-control" required>
        </div>
        <div class="col">
          <label class="form-label">Costo unitario</label>
          <input type="number" class="form-control" required>
        </div>
        <div class="col">
          <label class="form-label">Importes</label>
          <input type="number" class="form-control" required>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Concepto Presupuestal</label>
        <select class="form-select" required>
          <option value="">Select a budget concept</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Responsables</label>
        <input type="text" class="form-control" placeholder="Search responsibles" required>
      </div>
      <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-custom-outline" onclick="prevSection()">Back</button>
        <button type="submit" class="btn btn-custom">Finish</button>
      </div>
    </div>
  </form>
</div>

<script>
let currentSection = 1;
const totalSections = 3;

function showSection(index) {
  for (let i = 1; i <= totalSections; i++) {
    document.getElementById("section" + i).classList.remove("active");
  }
  document.getElementById("section" + index).classList.add("active");
}

function nextSection() {
  if (validateSection(currentSection)) {
    currentSection++;
    showSection(currentSection);
  }
}

function prevSection() {
  currentSection--;
  showSection(currentSection);
}

function validateSection(sectionNum) {
  let valid = true;
  const section = document.getElementById("section" + sectionNum);
  const inputs = section.querySelectorAll("input, textarea, select");
  inputs.forEach(input => {
    if (!input.checkValidity()) {
      input.classList.add("is-invalid");
      valid = false;
    } else {
      input.classList.remove("is-invalid");
    }
  });
  return valid;
}

document.getElementById('poaForm').addEventListener('submit', function(e) {
  if (!validateSection(currentSection)) {
    e.preventDefault();
  } else {
    alert("Form submitted successfully!");
  }
});
</script>
</body>
</html>
