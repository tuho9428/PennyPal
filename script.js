$(document).ready(function() {

    // Hide the "Add Expense" button initially
    $('#add-section').hide();
    
    $('#addExpenseBtn').click(function() {
        const expenseName = $('#expenseNameInput').val().trim();
        const expenseAmount = $('#expenseAmountInput').val().trim();

        if (expenseName !== '' && expenseAmount !== '') {
            const expense = `${expenseName} - $${expenseAmount}`;
            appendExpenseToList(expense);

            // Clear input fields after adding expense
            $('#expenseNameInput').val('');
            $('#expenseAmountInput').val('');
        } else {
            alert('Please enter expense name and amount.');
        }
    });

    $('.yearBtn').click(function() {
        const year = $(this).data('year');
        let selectedYear = '';
    
        const currentYear = new Date().getFullYear();
        const lastYear = currentYear - 1;
    
        if (year === 'currentYear') {
            selectedYear = currentYear;
        } else if (year === 'lastYear') {
            selectedYear = lastYear;
        }
    
        $('#year').html('You picked ' + selectedYear);

        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $('#month').empty();
    
        const monthSelect = $('<select>');
        if (year === 'currentYear') {
            const currentMonth = new Date().getMonth();
            for (let i = 0; i <= currentMonth; i++) {
                monthSelect.append($('<option>').val(months[i]).text(months[i]));
            }
            $('#month').append(selectedYear + ': ').append(monthSelect);
            
        } else if (year === 'lastYear') {
            for (let i = 0; i < months.length; i++) {
                monthSelect.append($('<option>').val(months[i]).text(months[i]));
            }
            $('#month').append(selectedYear + ': ').append(monthSelect);
        }

        // Show the "Add Expense" section once a month has been selected
        monthSelect.on('change', function() {
            $('#add-section').show();
            $('#expenseList').empty();
        });
        
        // Clear the expense list when a year is selected
        $('.yearBtn').on('click', function() {
            $('#expenseList').empty();
        });
    });

});

function appendExpenseToList(expense) {
    const listItem = $('<li>').text(expense);
    $('#expenseList').append(listItem);
}
