function saveBudget() {
    var category = document.getElementById('category').value;
    var timeframe = document.getElementById('timeframe').value;
    var budget = document.getElementById('budget').value;

    // Send budget data to PHP script for saving in database
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_budget.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('budget=' + budget + '&category=' + category + '&timeframe=' + timeframe);

    xhr.onload = function() {
        if (xhr.status === 200) {
            alert('Budget saved successfully for ' + category + ' category in ' + timeframe + ' timeframe');
        } else {
            alert('Failed to save budget. Please try again.');
        }
    };
}
