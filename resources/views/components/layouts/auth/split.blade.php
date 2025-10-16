<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen flex flex-col bg-zinc-100 antialiased">

    <!-- Main container -->
    <div class="flex flex-1 items-center justify-center px-4 py-12 mt-4">
        <div class="bg-white rounded-lg flex flex-col lg:flex-row overflow-hidden w-full max-w-4xl">

            <!-- Left Illustration -->
            <div class="hidden lg:flex w-1/2 bg-gray-50 items-center justify-start p-8 flex-col">

                <!-- Image on top -->
                <img src="{{ asset('/img/help-desk.png') }}" alt="Login Illustration" draggable="false"
                    class="max-h-[300px] object-contain mb-6">

                <!-- Text below image -->
                <h6 class="mb-1 text-gray-800 flex items-center text-[15px]">
                    Need technical assistance? Chat
                    <iconify-icon icon="marketeq:chat-4" width="27" height="27" class="ml-1"></iconify-icon>
                </h6>

                <h3 class="text-green-600 font-bold text-[18px] mb-1">JEMUEL CADAYONA</h3>

                <div class="mb-2">
                    <small class="text-[13px]">Software Developer</small>
                </div>

                <hr class="my-2 w-full">

                <a href="https://www.facebook.com/jemuel.cadayona.94" target="_blank"
                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded uppercase text-[11px] inline-block mt-2">
                    Click to Chat
                </a>

                <div class="mb-4 mt-2">
                    <a href="https://jemcdyn.vercel.app/" target="_blank"
                        class="text-gray-600 underline flex items-center text-[13px]">
                        <iconify-icon icon="logos:webkit" width="25" height="25" class="mr-2"></iconify-icon>
                        https://jemcdyn.vercel.app/
                    </a>
                </div>

            </div>


            <!-- Right Login Form -->
            <!-- Right Login Form -->
            <div class="w-full lg:w-1/2 p-10 md:p-15 flex flex-col justify-center">
                <div>
                    {{ $slot }}
                </div>

                <div class="mt-6 text-xs text-gray-500 flex items-center justify-center gap-2 text-start">
                    <iconify-icon icon="ph:seal-check-duotone" width="35" height="35"
                        class="text-green-500"></iconify-icon>
                    <span>
                        Seamlessly <span class="font-bold text-green-600">track your inventories</span>,
                        ensuring consistent efficiency and reliability throughout!
                    </span>
                </div>
            </div>

        </div>
    </div>

    <div class=" px-0 md:px-50 mb-0 md:mb-10">
        <x-guest-footer />
    </div>

    <!-- Help Desk Image & Text for small screens only -->
    <div class="lg:hidden flex flex-col items-center justify-center p-6">

        <!-- Image on top -->
        <img src="{{ asset('/img/help-desk.png') }}" alt="Login Illustration" draggable="false"
            class="max-h-[200px] object-contain mb-4">

        <!-- Text below image -->
        <h6 class="mb-1 text-gray-800 flex items-center text-[15px] justify-center">
            Need technical assistance? Chat
            <iconify-icon icon="marketeq:chat-4" width="27" height="27" class="ml-1"></iconify-icon>
        </h6>

        <h3 class="text-green-600 font-bold text-[20px] mb-1 text-center">JEMUEL CADAYONA</h3>

        <div class="mb-2 text-center">
            <small class="text-[14px]">Software Developer</small>
        </div>

        <hr class="my-2 w-full">

        <a href="/messenger/120"
            class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded uppercase text-[11px] inline-block mt-2">
            Click to Chat
        </a>

        <div class="mb-4 mt-2 text-center">
            <a href="https://jemcdyn.vercel.app/" target="_blank"
                class="text-gray-600 underline flex items-center justify-center">
                <iconify-icon icon="logos:webkit" width="25" height="25" class="mr-2"></iconify-icon>
                https://jemcdyn.vercel.app/
            </a>
        </div>

    </div>


    @fluxScripts
</body>

</html>
