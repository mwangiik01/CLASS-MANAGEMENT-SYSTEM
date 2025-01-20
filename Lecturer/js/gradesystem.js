  // Function to recalculate all students' totals based on new Max Marks input
  function updateMaxMarks() {
    // Update Max Marks for each category (CATs, Assignments, Labs)
    let cat1Max = parseFloat(document.getElementById('cat-1-max').value) || 0;
    let cat2Max = parseFloat(document.getElementById('cat-2-max').value) || 0;
    let cat3Max = parseFloat(document.getElementById('cat-3-max').value) || 0;
    let totalCatsMax = cat1Max + cat2Max + cat3Max;
    document.getElementById('total-cats-max').value = totalCatsMax.toFixed(2);

    let assign1Max = parseFloat(document.getElementById('assignment-1-max').value) || 0;
    let assign2Max = parseFloat(document.getElementById('assignment-2-max').value) || 0;
    let assign3Max = parseFloat(document.getElementById('assignment-3-max').value) || 0;
    let totalAssignmentsMax = assign1Max + assign2Max + assign3Max;
    document.getElementById('total-assignments-max').value = totalAssignmentsMax.toFixed(2);

    let lab1Max = parseFloat(document.getElementById('lab-1-max').value) || 0;
    let lab2Max = parseFloat(document.getElementById('lab-2-max').value) || 0;
    let lab3Max = parseFloat(document.getElementById('lab-3-max').value) || 0;
    let totalLabsMax = lab1Max + lab2Max + lab3Max;
    document.getElementById('total-labs-max').value = totalLabsMax.toFixed(2);

    // Recalculate the marks for all students
    let studentIds = document.querySelectorAll('.student-id'); // Select all student rows
    studentIds.forEach(studentIdElem => {
        let studentId = studentIdElem.value; // Get the student ID from the hidden input or other way
        calculateTotals(studentId);
    });
}

// Function to calculate totals for an individual student
function calculateTotals(studentId) {
    // Initialize category totals
    let totalCats = 0, finalCats = 0;
    let totalAssignments = 0, finalAssignments = 0;
    let totalLabs = 0, finalLabs = 0;
    let totalFinal = 0;

    // Get Max Marks values for each category (check if Max Marks are inputted)
    let cat1Max = parseFloat(document.getElementById('cat-1-max').value) || 0;
    let cat2Max = parseFloat(document.getElementById('cat-2-max').value) || 0;
    let cat3Max = parseFloat(document.getElementById('cat-3-max').value) || 0;
    let assign1Max = parseFloat(document.getElementById('assignment-1-max').value) || 0;
    let assign2Max = parseFloat(document.getElementById('assignment-2-max').value) || 0;
    let assign3Max = parseFloat(document.getElementById('assignment-3-max').value) || 0;
    let lab1Max = parseFloat(document.getElementById('lab-1-max').value) || 0;
    let lab2Max = parseFloat(document.getElementById('lab-2-max').value) || 0;
    let lab3Max = parseFloat(document.getElementById('lab-3-max').value) || 0;

    // Calculate CAT totals only if Max Marks are set for each individual CAT
    let cat1 = (cat1Max > 0) ? parseFloat(document.getElementById(`cat-1-${studentId}`).value) || 0 : 0;
    let cat2 = (cat2Max > 0) ? parseFloat(document.getElementById(`cat-2-${studentId}`).value) || 0 : 0;
    let cat3 = (cat3Max > 0) ? parseFloat(document.getElementById(`cat-3-${studentId}`).value) || 0 : 0;
    totalCats = cat1 + cat2 + cat3;

    // Calculate final CAT marks (only if Max Marks are provided)
    finalCats = (cat1Max + cat2Max + cat3Max > 0) ? (totalCats * parseFloat(document.getElementById('final-cat-max').value) || 0) / (cat1Max + cat2Max + cat3Max) : 0;
    document.getElementById(`total-cats-${studentId}`).value = totalCats.toFixed(2);
    document.getElementById(`final-cat-${studentId}`).value = finalCats.toFixed(2);

    // Calculate Assignments totals only if Max Marks are set for each individual Assignment
    let assign1 = (assign1Max > 0) ? parseFloat(document.getElementById(`assignment-1-${studentId}`).value) || 0 : 0;
    let assign2 = (assign2Max > 0) ? parseFloat(document.getElementById(`assignment-2-${studentId}`).value) || 0 : 0;
    let assign3 = (assign3Max > 0) ? parseFloat(document.getElementById(`assignment-3-${studentId}`).value) || 0 : 0;
    totalAssignments = assign1 + assign2 + assign3;

    // Calculate final Assignment marks (only if Max Marks are provided)
    finalAssignments = (assign1Max + assign2Max + assign3Max > 0) ? (totalAssignments * parseFloat(document.getElementById('final-assignment-max').value) || 0) / (assign1Max + assign2Max + assign3Max) : 0;
    document.getElementById(`total-assignments-${studentId}`).value = totalAssignments.toFixed(2);
    document.getElementById(`final-assignment-${studentId}`).value = finalAssignments.toFixed(2);

    // Calculate Labs totals only if Max Marks are set for each individual Lab
    let lab1 = (lab1Max > 0) ? parseFloat(document.getElementById(`lab-1-${studentId}`).value) || 0 : 0;
    let lab2 = (lab2Max > 0) ? parseFloat(document.getElementById(`lab-2-${studentId}`).value) || 0 : 0;
    let lab3 = (lab3Max > 0) ? parseFloat(document.getElementById(`lab-3-${studentId}`).value) || 0 : 0;
    totalLabs = lab1 + lab2 + lab3;

    // Calculate final Lab marks (only if Max Marks are provided)
    finalLabs = (lab1Max + lab2Max + lab3Max > 0) ? (totalLabs * parseFloat(document.getElementById('final-lab-max').value) || 0) / (lab1Max + lab2Max + lab3Max) : 0;
    document.getElementById(`total-labs-${studentId}`).value = totalLabs.toFixed(2);
    document.getElementById(`final-lab-${studentId}`).value = finalLabs.toFixed(2);

    // Get Main Exam input value
    let mainExam = parseFloat(document.getElementById(`main-exam-${studentId}`).value) || 0;

    // Calculate Total Final Marks (always include Main Exam)
    totalFinal = finalCats + finalAssignments + finalLabs + mainExam;
    document.getElementById(`total-marks-${studentId}`).value = totalFinal.toFixed(2);
    document.getElementById(`final-${studentId}`).value = totalFinal.toFixed(2);
}