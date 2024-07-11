document.getElementById('addRow').addEventListener('click', function() {
    const table = document.getElementById('logTable').getElementsByTagName('tbody')[0];
    const newRow = table.insertRow();

    const cell1 = newRow.insertCell(0);
    const cell2 = newRow.insertCell(1);
    const cell3 = newRow.insertCell(2);
    const cell4 = newRow.insertCell(3);
    const cell5 = newRow.insertCell(4);
    const cell6 = newRow.insertCell(5);
    const cell7 = newRow.insertCell(6);

    cell1.innerHTML = '<input type="text" name="studentName[]" required>';
    cell2.innerHTML = '<input type="text" name="laptopNumber[]" required>';
    cell3.innerHTML = '<input type="text" name="lessonPeriod[]" required>';
    cell4.innerHTML = '<input type="time" name="signOutTime[]" required>';
    cell5.innerHTML = '<input type="text" name="signOutSignature[]" required>';
    cell6.innerHTML = '<input type="time" name="signInTime[]" required>';
    cell7.innerHTML = '<input type="text" name="signInSignature[]" required>';
});
