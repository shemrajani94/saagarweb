//var url = 'http://query.yahooapis.com/v1/public/yql';
//var startDate = '2012-01-01';
//var endDate = '2012-01-08';
//var data = encodeURIComponent('select * from yahoo.finance.historicaldata where symbol in ("YHOO","AAPL","GOOG","MSFT") and startDate = "' + startDate + '" and endDate = "' + endDate + '"');
//$.getJSON(url, 'q=' + data + "&env=http%3A%2F%2Fdatatables.org%2Falltables.env&format=json", function(x){
//    console.log(x);
//});

$.getJSON('https://finance.yahoo.com/d/quotes.jsonp?s=AAPL&f=a',function(x){
    console.log(x);
});