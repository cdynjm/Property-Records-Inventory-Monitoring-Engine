<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=0.85" />

<title>PGSO ({{ $title ?? config('app.name') }})</title>

<link rel="icon" href="{{ asset('/img/province-logo-official.png') }}" sizes="any">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/ts/app.ts'])
@fluxAppearance
