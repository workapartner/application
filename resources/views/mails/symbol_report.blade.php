Hello <i>{{ strtok($data->receiver, '@') }}</i>,
<p>You requested data on the current situation of the company in the asset market. We provide you with a report for the period:</p>

<div>
    <p><b>Period</b>&nbsp;{{ $start_date }} - {{ $end_date }}</p>
</div>

<div>
You could check the results in our page.
</div>

<br/>
Best Regards,
<br/>
<i>{{ ucfirst(strtok($data->sender, '@')) }}</i>
