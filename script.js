document.getElementById('addExpenseBtn').addEventListener('click', addExpense);

function addExpense() {
    const expenseNameInput = document.getElementById('expenseNameInput');
    const expenseName = expenseNameInput.value.trim();

    const expenseAmountInput = document.getElementById('expenseAmountInput');
    const expenseAmount = expenseAmountInput.value.trim();

    if (expenseName !== '' && expenseAmount !== '') {
        const expense = `${expenseName} - $${expenseAmount}`;
        saveExpense(expense);
        appendExpenseToList(expense);
        expenseNameInput.value = '';
        expenseAmountInput.value = '';
    }
}

function saveExpense(expense) {
    // Implement saving the expense to the database or any other necessary action
}

function appendExpenseToList(expense) {
    const expenseList = document.getElementById('expenseList');
    const listItem = document.createElement('li');
    listItem.textContent = expense;
    expenseList.appendChild(listItem);
}
