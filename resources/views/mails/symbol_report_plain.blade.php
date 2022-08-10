Hello {{ strtok($data->receiver, '@') }},
You requested data on the current situation of the company in the asset market. We provide you with a report for the period:

Period: {{ $start_date }} - {{ $end_date }}

You could check the results in our page.

Best Regards,
{{ strtok($data->sender, '@') }}
