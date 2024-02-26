function saveBudget() {
    var budget = document.getElementById('budget').value;
    var currency = document.getElementById('currency').value;

    // Send budget data to PHP script for saving in database
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_budget.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('budget=' + budget + '&currency=' + currency);

    // Update current budget display
    document.getElementById('currentBudget').textContent = currency + budget;
}
