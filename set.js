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

function saveWeeklyBudget() {
    var weeklyBudget = document.getElementById('weekly').value;
    saveBudget(weeklyBudget, 'weekly');
}

function saveMonthlyBudget() {
    var monthlyBudget = document.getElementById('monthly').value;
    saveBudget(monthlyBudget, 'monthly');
}

function saveYearlyBudget() {
    var yearlyBudget = document.getElementById('yearly').value;
    saveBudget(yearlyBudget, 'yearly');
}

function saveBudget(budget, timeframe) {
    // Send budget data to PHP script for saving in database
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_budget.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('budget=' + budget + '&timeframe=' + timeframe);

    xhr.onload = function() {
        if (xhr.status === 200) {
            alert('Budget saved successfully for ' + timeframe + ' timeframe');
        } else {
            alert('Failed to save budget. Please try again.');
        }
    };
}
