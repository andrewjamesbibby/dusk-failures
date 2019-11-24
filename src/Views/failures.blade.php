<body>
<h1 style="margin:0">Dusk Failures</h1>

<p>This email contains failed dusk test screenshots to assist in debugging. There are a total of <strong style="color:red">{{ count($screenshots) }}</strong> screenshot(s).</p>
<p>Build: {{ $options['build'] ? $options['build'] : 'Unknown Build' }}</p>
<table style="width: 100%; border-collapse: collapse; border: solid 1px silver; margin-bottom: 50px;" cellspacing="0" cellpadding="0">
    <tr>
        <th style="padding: 8px; font-size: 14px;"><strong>Failed Test Summary</strong></th>
    </tr>
    @foreach ($screenshots as $screenshot)
        <tr style="border: solid 1px silver;">
            <td style="padding: 5px">
                <span class="color:red; font-size: 16px">&#10060;</span>  {{ $screenshot->getRelativePathname() }}
            </td>
        </tr>
    @endforeach
</table>

@if(! $options['zip'])
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 50px;" cellspacing="0" cellpadding="0">
        @foreach ($screenshots as $screenshot)
            @if($screenshot->getExtension() === 'png')
                <tr>
                    <td style="text-align: center;">
                        <h2 style="border-bottom: solid 1px silver; padding: 5px; margin:10px 0 10px 0; text-align: center;">
                            {{ $screenshot->getExtension() }} |
                            <strong> {{ $screenshot->getRelativePathname() }}</strong>
                        </h2>
                        <img style="display:inline-block; width: 100%; border: solid 1px silver;" src="{{ $message->embed($screenshot->getPathname()) }}">
                    </td>
                </tr>
            @endif
        @endforeach
    </table>
@else
    <p>The screenshots are zipped and attached to this email.</p>
@endif

@if(! $options['console'])
    <p>The console logs are zipped and attached to this email.</p>
@endif

</body>
