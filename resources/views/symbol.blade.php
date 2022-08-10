<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="/js/app.js" defer></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $( function() {
            $( ".datepicker" ).datepicker({dateFormat: 'yy-mm-dd'});
        } );
    </script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-core.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-stock.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-data-adapter.min.js"></script>

    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-ui.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-exports.min.js"></script>

    <link href="https://cdn.anychart.com/releases/8.11.0/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
    <link href="https://cdn.anychart.com/releases/8.11.0/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">

    <style type="text/css">
        html, body, #container {
            width: 100%; height: 100%; margin: 0; padding: 0;
        }
    </style>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <form>
        @csrf
        <div class="form-group">
            <label for="symbol">Company Symbol</label>
            <input type="text" class="form-control" name="symbol" id="symbol" required="">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="text" id="start_date" class="form-control datepicker" name="start_date">
        </div>
        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="text" id="end_date" class="form-control datepicker" name="end_date">
        </div>
        <button type="button"
                id="companySymbol"
                class="w-full flex justify-center items-center py-2 px-5 border border-transparent rounded-md shadow-sm text-2xl font-medium bg-blue-500 hover:bg-blue-700 uppercase focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Submit
        </button>
    </form>
</div>
<div id="result" class="hidden font-bold text-3xl text-center">
</div>
<div id="container"></div>
<script>
    // All the code for the JS Stock Chart will come here
</script>
</body>
</html>
